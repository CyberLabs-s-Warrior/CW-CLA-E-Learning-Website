<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AboutController;

use App\Http\Controllers\HomeClientController;
use App\Http\Controllers\CourseClientController;
use App\Http\Controllers\LessonClientController;
use App\Http\Controllers\LoginClientController;
use App\Http\Controllers\ProfileClientController;
use App\Http\Controllers\DetailCourseClientController;

/*
|--------------------------------------------------------------------------
| Public Routes 
|--------------------------------------------------------------------------
*/

    Route::get('/', function () {
        return view('welcome');
    });

Route::get('/home', [HomeClientController::class, 'index'])->name('home.index');
Route::get('/course', [CourseClientController::class, 'index'])->name('course.index');
Route::get('/lesson', [LessonClientController::class, 'index'])->name('lesson.index');
Route::get('/profile', [ProfileClientController::class, 'index'])->name('profile.index');
Route::get('/login-client', [LoginClientController::class, 'index'])->name('login.index');
Route::get('/detail-course', [DetailCourseClientController::class, 'index'])->name('detail.index');

/*
|--------------------------------------------------------------------------
| Admin Routes 
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');

});

/*
|--------------------------------------------------------------------------
| Auth Routes dari Breeze
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

