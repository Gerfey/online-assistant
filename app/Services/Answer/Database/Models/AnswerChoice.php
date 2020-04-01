<?php

namespace App\Services\Answer\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnswerChoice extends Model
{
    protected $table = 'answers_choice';

    public $timestamps = false;

    protected $fillable = [
        'answer_id', 'title', 'keywords'
    ];

   /* protected $hidden = [
        'id', 'answer_id'
    ];*/

    protected $casts = [
        'answer_id' => 'int',
        'title' => 'string',
        'keywords' => 'json'
    ];
}
