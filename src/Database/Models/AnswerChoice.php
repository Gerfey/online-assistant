<?php

namespace Gerfey\OnlineAssistant\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnswerChoice extends Model
{
    protected $table = 'answers_choices';

    public $timestamps = false;

    protected $fillable = [
        'answer_id', 'title', 'keywords'
    ];

    protected $hidden = [
        'id', 'answer_id'
    ];

    protected $casts = [
        'answer_id' => 'int',
        'title' => 'string',
        'keywords' => 'json'
    ];

    public function choice(): HasOne
    {
        return $this->hasOne(Choice::class, 'id', 'choice_id');
    }
}
