<?php

use App\Http\Controllers\CourseClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeClientController::class, 'index'])->name('home.index');
Route::get('/course', [CourseClientController::class, 'index'])->name('course.index');