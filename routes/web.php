<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeClientController;
use App\Http\Controllers\CourseClientController;
use App\Http\Controllers\LessonClientController;
use App\Http\Controllers\LoginClientController;
use App\Http\Controllers\ProfileClientController;

/*
|--------------------------------------------------------------------------
| Public Routes (Tidak Harus Login)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeClientController::class, 'index'])->name('home.index');
Route::get('/course', [CourseClientController::class, 'index'])->name('course.index');
Route::get('/lesson', [LessonClientController::class, 'index'])->name('lesson.index');
// Route::get('/profile', [ProfileClientController::class, 'index'])->name('profile.index');
// Route::get('/login-client', [LoginClientController::class, 'index'])->name('login.index');

/*
|--------------------------------------------------------------------------
| Admin Routes (Hanya Bisa Diakses Setelah Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

/*
|--------------------------------------------------------------------------
| Auth Routes dari Breeze
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
