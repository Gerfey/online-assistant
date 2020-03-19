<?php

namespace App\Integrations\FindMorphy;

use App\Services\Answer\Database\Models\Answer;

class SearchAnswer extends BaseMorphy
{
    public function search(string $question): array
    {
        $result = $temp = [];

        $words = $this->createResponse($question, 2);
        foreach ($this->searchPositionsToDB($words) as $array_find) {
            $index = $this->checkResponseCorrect($words, $array_find['keywords']);
            if ($index > 0) {
                $temp[$index][] = $array_find;
            }
        }

        krsort($temp);

        if (count($temp) > 0) {
            $result = array_values($temp)[0];
        } else {
            $result[] = ['answer' => 'К сожалению я не знаю ответа на ваш вопрос.', 'keywords' => null];
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

    private function searchPositionsToDB(object $target)
    {
        $result = Answer::query();
        if ($target->words && count($target->words) > 0) {
            foreach ($target->words as $target_word) {
                if ($target_word->basic && count($target_word->basic) > 0) {
                    foreach ($target_word->basic as $lem) {
                        $result->orWhereJsonContains('keywords->words', $lem);
                    }
                }
            }
        }

        $result->with('choices');

        $answer = [];
        if ($result->count() > 0) {
            foreach ($result->get() as $key => $value) {
                $answer[$key] = [
                    'answer' => $value['answer'],
                    'keywords' => $value['keywords']['words'],
                    'choices' => []
                ];

                foreach ($value->choices as $choice) {
                    $answer[$key]['choices'][] = [
                        'title' => $choice->title,
                        'keywords' => (!empty($choice->keywords)) ? $choice->keywords['words'] : null,
                    ];
                }
            }
        }

        return $answer;
    }
}
