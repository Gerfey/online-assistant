<?php

namespace App\Services\Answer\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * @var string
     */
    protected $table = 'answers';

    public $timestamps = false;
}
