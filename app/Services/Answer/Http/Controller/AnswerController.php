<?php

namespace App\Services\Answer\Http\Controller;

use Gerfey\ResponseBuilder\ResponseBuilder;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    public function getIndex()
    {
        return ResponseBuilder::success([]);
    }
}
