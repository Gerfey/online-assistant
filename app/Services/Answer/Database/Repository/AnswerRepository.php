<?php

namespace App\Services\Answer\Database\Repository;

use App\Services\Answer\Database\Models\Answer;
use Gerfey\Repository\Repository;

class AnswerRepository extends Repository
{
    protected $entity = Answer::class;
}
