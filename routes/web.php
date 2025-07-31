<?php

use App\Http\Controllers\AboutClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\HomeClientController;
use App\Http\Controllers\CourseClientController;
use App\Http\Controllers\LessonClientController;
use App\Http\Controllers\LoginClientController;
use App\Http\Controllers\ProfileClientController;
use App\Http\Controllers\DetailCourseClientController;
use App\Http\Controllers\DatanClientController;
use App\Http\Controllers\PendataanClientController;

/*
|--------------------------------------------------------------------------
| Public Routes 
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Auth\StudentAuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));

Route::get('/home', [HomeClientController::class, 'index'])->name('home.index');
Route::get('/course', [CourseClientController::class, 'index'])->name('course.index');
Route::get('/lesson', [LessonClientController::class, 'index'])->name('lesson.index');
Route::get('/profile', [ProfileClientController::class, 'index'])->name('profile.index');
Route::get('/login-client', [LoginClientController::class, 'index'])->name('login.index');
Route::get('/detail-course', [DetailCourseClientController::class, 'index'])->name('detail.index');
Route::get('/about', [AboutClientController::class, 'index'])->name('about.index');
Route::get('/data', [PendataanClientController::class, 'index'])->name('pendataan.index');

/*
|--------------------------------------------------------------------------
| Admin Routes 
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
});
Route::get('/detail-course', [DetailCourseClientController::class, 'index'])->name('detail.index');

// Login Client / Student
Route::get('/login-client', [LoginClientController::class, 'index'])->name('login.index');
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login');
Route::post('/student/register', [StudentAuthController::class, 'register'])->name('student.register');
Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Profile
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

        // User Management
        Route::resource('/users', UserController::class)->except('show')->middleware('is_superadmin');

        // About
        Route::resource('/about', AboutController::class)->middleware('can:kelola_about');

        // Contact
        Route::get('/contact', [ContactController::class, 'index'])->name('contact.index')->middleware('can:kelola_contact');
        Route::get('/contact/edit', [ContactController::class, 'edit'])->name('contact.edit')->middleware('can:kelola_contact');
        Route::post('/contact/update', [ContactController::class, 'update'])->name('contact.update')->middleware('can:kelola_contact');

        // ------------------------------
        // Course Category Management
        // ------------------------------

        // Course Categories
        Route::get('/course-categories', [CourseCategoryController::class, 'index'])->name('course-categories.index')->middleware('can:kelola_course');
        Route::get('/course-categories/create', [CourseCategoryController::class, 'create'])->name('course-categories.create')->middleware('can:kelola_course');
        Route::post('/course-categories', [CourseCategoryController::class, 'store'])->name('course-categories.store')->middleware('can:kelola_course');
        Route::get('/course-categories/{id}/edit', [CourseCategoryController::class, 'edit'])->name('course-categories.edit')->middleware('can:kelola_course');
        Route::put('/course-categories/{id}', [CourseCategoryController::class, 'update'])->name('course-categories.update')->middleware('can:kelola_course');
        Route::delete('/course-categories/{id}', [CourseCategoryController::class, 'destroy'])->name('course-categories.destroy')->middleware('can:kelola_course');

        // Course Levels
        Route::get('/course-levels/{id}/edit', [CourseCategoryController::class, 'editLevel'])->name('course-levels.edit');
        Route::put('/course-levels/{id}', [CourseCategoryController::class, 'updateLevel'])->name('course-levels.update');
        Route::delete('/course-levels/{id}', [CourseCategoryController::class, 'destroyLevel'])->name('course-levels.destroy');

        // Course Price Ranges
        Route::get('/course-prices/{id}/edit', [CourseCategoryController::class, 'editPrice'])->name('course-prices.edit');
        Route::put('/course-prices/{id}', [CourseCategoryController::class, 'updatePrice'])->name('course-prices.update');
        Route::delete('/course-prices/{id}', [CourseCategoryController::class, 'destroyPrice'])->name('course-prices.destroy');

        // ------------------------------
        // Course Management (Singular: course)
        // ------------------------------

        Route::get('/course', [CourseController::class, 'index'])->name('course.index');
        Route::get('/course/create', [CourseController::class, 'create'])->name('course.create');
        Route::post('/course', [CourseController::class, 'store'])->name('course.store');
        Route::get('/course/{course}/edit', [CourseController::class, 'edit'])->name('course.edit');
        Route::put('/course/{course}', [CourseController::class, 'update'])->name('course.update');
        Route::delete('/course/{course}', [CourseController::class, 'destroy'])->name('course.destroy');
    });
/*
|--------------------------------------------------------------------------
| Auth Routes dari Breeze
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
