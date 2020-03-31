<?php

namespace App\Services\Answer\Database\Models;

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
        return $this->hasMany('App\Services\Answer\Database\Models\AnswerChoice', 'answer_id', 'id');
    }
}
