<?php

namespace App\Integrations\FindMorphy;

use App\Integrations\FindMorphy\Entity\AnswerEntity;
use App\Integrations\FindMorphy\Entity\WordsEntity;
use cijic\phpMorphy\Morphy;
use Gerfey\Mapper\Format\ArrayMapper;

class BaseMorphy
{
    protected $morphy;

    protected $arrayMapper;

    private $lang = 'ru';

    private $regexp_word = '/([a-zа-я0-9]+)/ui';

    private $regexp_entity = '/&([a-zA-Z0-9]+);/';

    public function __construct()
    {
        $this->morphy = new Morphy($this->lang);
        $this->arrayMapper = new ArrayMapper();
    }

    protected function createResponse(string $content, int $range = 1): object
    {
        $answerEntity = $this->arrayMapper->map(AnswerEntity::class, [
            'range' => $range,
            'words' => []
        ]);

        // Выделение слов из текста
        $words = $this->getWords($content);
        foreach ($words as $word) {

            // Оценка значимости слова
            $weight = $this->getWeight($word);
            if ($weight > 0) {
                $length = count($answerEntity->words);

                for ($i = 0; $i < $length; $i++) {
                    if ($answerEntity->words[$i]->source === $word) {
                        $answerEntity->words[$i]->count++;
                        $answerEntity->words[$i]->range = $range * $answerEntity->words[$i]->count * $answerEntity->words[$i]->weight;

                        continue;
                    }
                }

                // Если исходного слова еще нет в индексе
                if ($lemma = $this->morphy->lemmatize($word)) {
                    for ($i = 0; $i < $length; $i++) {
                        if ($answerEntity->words[$i]->basic) {
                            $difference = count(
                                array_diff($lemma, $answerEntity->words[$i]->basic)
                            );

                            // Если сравниваемое слово имеет менее двух отличных лемм
                            if ($difference === 0) {
                                $answerEntity->words[$i]->count++;
                                $answerEntity->words[$i]->range = $range * $answerEntity->words[$i]->count * $answerEntity->words[$i]->weight;

                                continue;
                            }
                        }
                    }
                }

                $answerEntity->words[] = $this->arrayMapper->map(WordsEntity::class, [
                    'source' => $word,
                    'count' => 1,
                    'range' => $range * $weight,
                    'weight' => $weight,
                    'basic' => $lemma,
                ]);
            }
        }

        return $answerEntity;
    }

    protected function getWords(string $content, bool $filter = true): array
    {
        if ($filter) {
            $content = preg_replace($this->regexp_entity, ' ', strip_tags($content));
        }

        $content = mb_strtoupper($content, 'UTF-8');
        $content = str_ireplace('Ё', 'Е', $content);
        preg_match_all($this->regexp_word, $content, $words_src);

        return $words_src[1];
    }

    protected function getWeight(string $word, bool $profile = true): int
    {
        // Попытка определения части речи
        $partsOfSpeech = $this->morphy->getPartOfSpeech($word);

        if ($profile) {
            $profile = [
                // Служебные части речи
                'ИНФИНИТИВ' => 10,

                'ПРЕДЛ' => 0,
                'СОЮЗ' => 0,
                'МЕЖД' => 0,
                'ВВОДН' => 0,
                'ЧАСТ' => 0,
                'МС' => 0,

                // Наиболее значимые части речи
                'С' => 6,
                'Г' => 3,
                'П' => 3,
                'Н' => 3,

                // Остальные части речи
                'DEFAULT' => 1
            ];
        }

        // Если не удалось определить возможные части речи
        if (!$partsOfSpeech) {
            return $profile['DEFAULT'];
        }

        // Определение ранга
        $range = [];
        for ($i = 0; $i < count($partsOfSpeech); $i++) {
            if (isset($profile[$partsOfSpeech[$i]])) {
                $range[] = $profile[$partsOfSpeech[$i]];
            } else {
                $range[] = $profile['DEFAULT'];
            }
        }

        return max($range);
    }
}
