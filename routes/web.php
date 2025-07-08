<?php

use App\Http\Controllers\CourseClientController;
use App\Http\Controllers\LessonClientController;
use App\Http\Controllers\ProfileClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeClientController::class, 'index'])->name('home.index');
Route::get('/course', [CourseClientController::class, 'index'])->name('course.index');
Route::get('/lesson', [LessonClientController::class, 'index'])->name('lesson.index');
Route::get('/profile', [ProfileClientController::class, 'index'])->name('profile.index');
