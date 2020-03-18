<?php

use Illuminate\Database\Seeder;

class AnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->insert([
            [
                'answer' => 'Что вы не можете сделать?',
                'keywords' => '{"words": ["МОЧЬ"]}'
            ],
            [
                'answer' => 'Что именно вы не можете скачать?',
                'keywords' => '{"words": ["МОЧЬ", "СКАЧАТЬ"]}'
            ],
            [
                'answer' => 'Какие документы вас интересуют?',
                'keywords' => '{"words": ["МОЙ", "ДОКУМЕНТ"]}'
            ],
            [
                'answer' => 'Какие документы вы не можете скачать?',
                'keywords' => '{"words": ["МОЧЬ", "СКАЧАТЬ", "ДОКУМЕНТЫ"]}'
            ],
            [
                'answer' => 'Здравстуйте, я ваш персональный автоматический помощник. Постараюсь помочь Вам решить самые распространенные вопросы. Вам нужно будет выбрать один из предложенных вариантов ответа.',
                'keywords' => '{"words": ["ДОБРЫЙ", "ДЕНЬ", "ВЕЧЕР", "ЗДРАВСТВОВАТЬ"]}'
            ]
        ]);
    }
}
