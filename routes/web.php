<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'role:admin|manager'])->group(function ($route) {
    $route->resource('admin/answer', 'AdminAnswerController');
    $route->resource('admin/answerChoice', 'AdminAnswerChoiceController');
    $route->get('admin', function () {
        return view('admin.index');
    });
});
