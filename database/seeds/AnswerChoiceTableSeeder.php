<?php

use Illuminate\Database\Seeder;

class AnswerChoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers_choice')->insert([
            [
                'answer_id' => 1,
                'title' => 'Начать',
                'keywords' => '{"words": ["НАЧАТЬ"]}'
            ],
            [
                'answer_id' => 1,
                'title' => 'На сайт',
                'keywords' => '{"words": ["САЙТ"]}'
            ],
            [
                'answer_id' => 1,
                'title' => 'Что ты умеешь',
                'keywords' => '{"words": ["ЧТО", "УМЕТЬ"]}'
            ],
            [
                'answer_id' => 1,
                'title' => 'Помощь',
                'keywords' => '{"words": ["ПОМОЩЬ"]}'
            ],
            [
                'answer_id' => 2,
                'title' => 'На главную',
                'keywords' => '{"words": ["ДОБРЫЙ", "ЗДРАВСТВОВАТЬ"]}'
            ],
            [
                'answer_id' => 3,
                'title' => 'На главную',
                'keywords' => '{"words": ["ДОБРЫЙ", "ЗДРАВСТВОВАТЬ"]}'
            ],
            [
                'answer_id' => 4,
                'title' => 'На главную',
                'keywords' => '{"words": ["ДОБРЫЙ", "ЗДРАВСТВОВАТЬ"]}'
            ],
            [
                'answer_id' => 5,
                'title' => 'Телефоны',
                'keywords' => '{"words": ["ТЕЛЕФОН"]}'
            ],
            [
                'answer_id' => 6,
                'title' => 'Сенсорные телефоны',
                'keywords' => '{"words": ["СЕНСОРНЫЙ", "ТЕЛЕФОН"]}'
            ],
            [
                'answer_id' => 6,
                'title' => 'Кнопочные телефоны',
                'keywords' => '{"words": ["КНОПОЧНЫЙ", "ТЕЛЕФОН"]}'
            ],
            [
                'answer_id' => 7,
                'title' => 'На главную',
                'keywords' => '{"words": ["ДОБРЫЙ", "ЗДРАВСТВОВАТЬ"]}'
            ],
            [
                'answer_id' => 8,
                'title' => 'На главную',
                'keywords' => '{"words": ["ДОБРЫЙ", "ЗДРАВСТВОВАТЬ"]}'
            ],
            [
                'answer_id' => 9,
                'title' => 'Сенсорные телефоны',
                'keywords' => '{"words": ["СЕНСОРНЫЙ", "ТЕЛЕФОН"]}'
            ],
            [
                'answer_id' => 9,
                'title' => 'Кнопочные телефоны',
                'keywords' => '{"words": ["КНОПОЧНЫЙ", "ТЕЛЕФОН"]}'
            ],
        ]);
    }
}
