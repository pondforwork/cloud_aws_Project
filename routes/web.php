<?php

use App\Http\Controllers\studentcontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/student', [studentcontroller::class, 'index']);
Route::get('/student/list', [studentcontroller::class, 'getList']);


