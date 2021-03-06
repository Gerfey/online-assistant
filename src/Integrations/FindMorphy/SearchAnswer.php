<?php

namespace Gerfey\OnlineAssistant\Integrations\FindMorphy;

use Gerfey\OnlineAssistant\Database\Models\Answer;

class SearchAnswer extends BaseMorphy
{
    public function searchString(?string $question): array
    {
        $words = $this->createResponse($question, 2);
        return $this->search($words);
    }

    public function searchKeywords(?array $question): array
    {
        $words = $this->createResponse(implode(' ', $question), 2);
        return $this->search($words, true);
    }

    private function search(object $words, bool $isRelation = false): array
    {
        $temp = [];
        foreach ($this->searchPositionsToDB($words, $isRelation) as $array_find) {
            $index = $this->checkResponseCorrect($words, $array_find['keywords']);
            if ($index > 0) {
                $temp[$index][] = $array_find;
            }
        }

        krsort($temp);

        $result = [];
        if (count($temp) > 0) {
            $result = array_values($temp)[0];
        } else {
            $result[] = [
                'answer' => 'К сожалению я не знаю ответа на ваш вопрос.',
                'keywords' => null,
                'choices' => [
                    [
                        'title' => 'На главную',
                        'keywords' => [
                            'ДОБРЫЙ',
                            'ЗДРАВСТВОВАТЬ'
                        ]
                    ]
                ]
            ];
        }

        return $result;
    }

    private function checkResponseCorrect(object $target, array $keywords)
    {
        $total_range = 0;

        // Перебор слов запроса от клиента
        foreach ($target->words as $target_word) {
            // Перебор слов из БД
            foreach ($keywords as $key_word) {
                if ($key_word && $target_word->basic) {

                    // Прокидываем вес
                    $index_count = count($keywords);
                    $target_count = count($target_word->basic);

                    for ($i = 0; $i < $target_count; $i++) {
                        for ($j = 0; $j < $index_count; $j++) {
                            if ($keywords[$j] === $target_word->basic[$i]) {
                                $total_range += $this->getWeight($key_word);
                                continue;
                            }
                        }
                    }
                }
            }
        }

        return $total_range;
    }

    private function searchPositionsToDB(object $target, bool $isRelation = false)
    {
        $result = Answer::query();
        if ($target->words && count($target->words) > 0) {
            foreach ($target->words as $target_word) {
                if ($target_word->basic && count($target_word->basic) > 0) {
                    foreach ($target_word->basic as $lem) {
                        $lem = ($lem) ? $lem : $target_word->source;
                        if ($isRelation) {
                            $result->whereJsonContains('keywords->words', $lem);
                        } else {
                            $result->orWhereJsonContains('keywords->words', $lem);
                        }
                    }
                }
            }
        }

        $result->with('answers_choices');

        $answer = [];
        if ($result->count() > 0) {
            foreach ($result->get() as $key => $value) {
                $answer[$key] = [
                    'answer' => $value['answer'],
                    'keywords' => $value['keywords']['words'],
                    'choices' => []
                ];

                if (!empty($value->answers_choices) && count($value->answers_choices) > 0) {
                    foreach ($value->answers_choices as $answers_choices) {
                        $answer[$key]['choices'][] = [
                            'title' => $answers_choices->choice->title,
                            'keywords' => (!empty($answers_choices->choice->keywords)) ? $answers_choices->choice->keywords['words'] : null,
                        ];
                    }
                } else {
                    $answer[$key]['choices'][] = [
                        'title' => 'На главную',
                        'keywords' => [["ДОБРЫЙ", "ЗДРАВСТВОВАТЬ"]],
                    ];
                }
            }
        }

        return $answer;
    }
}
