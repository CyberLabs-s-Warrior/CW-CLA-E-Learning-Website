<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ContactController;

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

Route::middleware(['auth'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         
    // Dashboard (semua user ter-auth bisa akses)
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard.index');

    // About (butuh permission kelola_about)
    Route::resource('/about', AboutController::class)
         ->names('about')
         ->middleware('can:kelola_about');

    // Contact (butuh permission kelola_contact)
    Route::get('/contact',      [ContactController::class, 'index'])
         ->name('contact.index')
         ->middleware('can:kelola_contact');
    Route::get('/contact/edit', [ContactController::class, 'edit'])
         ->name('contact.edit')
         ->middleware('can:kelola_contact');
    Route::post('/contact/update', [ContactController::class, 'update'])
         ->name('contact.update')
         ->middleware('can:kelola_contact');

    Route::resource('/users', UserController::class)
        ->except(['show'])
        ->middleware('is_superadmin');

});

/*
|--------------------------------------------------------------------------
| Auth Routes dari Breeze
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
