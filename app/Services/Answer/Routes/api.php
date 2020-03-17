<?php

Route::prefix('v1')->group(function () {
    Route::get('answer', 'AnswerController@getIndex');
});
