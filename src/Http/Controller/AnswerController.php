<?php

namespace Gerfey\Http\Controller;

use App\Integrations\FindMorphy\SearchAnswer;
use Gerfey\ResponseBuilder\ResponseBuilder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function getString(Request $request)
    {
        $searchAnswer = new SearchAnswer();
        return ResponseBuilder::success($searchAnswer->searchString($request->get('str')));
    }

    public function getKeywords(Request $request)
    {
        $searchAnswer = new SearchAnswer();
        return ResponseBuilder::success($searchAnswer->searchKeywords($request->get('kw')));
    }
}
