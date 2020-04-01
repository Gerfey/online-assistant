<?php

namespace Gerfey\OnlineAssistant\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    protected $table = 'answers';

    public $timestamps = false;

    protected $fillable = [
        'answer', 'keywords'
    ];

    protected $casts = [
        'answer' => 'string',
        'keywords' => 'json'
    ];

    public function choices(): HasMany
    {
        return $this->hasMany(AnswerChoice::class, 'answer_id', 'id');
    }
}
