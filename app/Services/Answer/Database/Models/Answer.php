<?php

namespace App\Services\Answer\Database\Models;

use Illuminate\Database\Eloquent\Model;

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
}
