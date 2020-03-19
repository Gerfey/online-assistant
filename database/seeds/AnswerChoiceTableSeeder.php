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
                'title' => 'Найти документы',
                'keywords' => '{"words": ["МОЙ", "ДОКУМЕНТ"]}'
            ],
            [
                'answer_id' => 1,
                'title' => 'Скачать документы',
                'keywords' => '{"words": ["МОЧЬ", "СКАЧАТЬ", "ДОКУМЕНТ"]}'
            ]
        ]);
    }
}
