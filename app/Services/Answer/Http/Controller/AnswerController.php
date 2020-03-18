<?php

namespace App\Services\Answer\Http\Controller;

use App\Integrations\FindMorphy\SearchAnswer;
use Gerfey\ResponseBuilder\ResponseBuilder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function getIndex(Request $request)
    {
        $searchAnswer = new SearchAnswer();
        return ResponseBuilder::success($searchAnswer->search($request->get('str')));
    }
}
