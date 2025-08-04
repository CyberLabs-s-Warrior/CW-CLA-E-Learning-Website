<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\HomeClientController;
use App\Http\Controllers\CourseClientController;
use App\Http\Controllers\LessonClientController;
use App\Http\Controllers\LoginClientController;
use App\Http\Controllers\ProfileClientController;
use App\Http\Controllers\DetailCourseClientController;
use App\Http\Controllers\AboutClientController;
use App\Http\Controllers\PaymentClientController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PendataanClientController;

// --------------------------
// Public Routes
// --------------------------
Route::get('/', fn() => view('welcome'));

Route::get('/home', [HomeClientController::class, 'index'])->name('home.index');
Route::get('/course', [CourseClientController::class, 'index'])->name('course.index');
Route::get('/lesson', [LessonClientController::class, 'index'])->name('lesson.index');
Route::get('/profile', [ProfileClientController::class, 'index'])->name('profile.index');
// Route::get('/login-client', [LoginClientController::class, 'index'])->name('login.index');
Route::get('/detail-course', [DetailCourseClientController::class, 'index'])->name('detail.index');
Route::get('/about', [AboutClientController::class, 'index'])->name('about.index');
Route::get('/data', [PendataanClientController::class, 'index'])->name('pendataan.index');
Route::get('/payment', [PaymentClientController::class, 'index'])->name('payment.index');

// --------------------------
// Student Auth
// --------------------------
// --------------------------
Route::middleware('guest')->group(function () {
    // Tampilkan form login & register student
    Route::get('/login', [StudentAuthController::class, 'showLoginRegisterForm'])
        ->name('login');
    // Proses login student
    Route::post('/login', [StudentAuthController::class, 'login'])
        ->name('login.submit');

    // Tampilkan form register (bisa digabung dengan login page jika satu view)
    Route::get('/register', [StudentAuthController::class, 'showLoginRegisterForm'])
        ->name('register');
    // Proses register student
    Route::post('/register', [StudentAuthController::class, 'register'])
        ->name('register.submit');
});

// Logout student
Route::middleware('auth')->post('/logout', [StudentAuthController::class, 'logout'])
    ->name('logout');


// Admin Login
Route::get('/login-admin', [AuthenticatedSessionController::class, 'create'])
    ->name('admin.login');

Route::post('/login-admin', [AuthenticatedSessionController::class, 'store'])
    ->name('admin.login.submit');

// Logout admin
Route::post('/logout-admin', [AuthenticatedSessionController::class, 'destroy'])
    ->name('admin.logout');

// --------------------------
// Admin Routes
// --------------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

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

    // --------------------------
    // COURSE CRUD
    // --------------------------
    Route::get('/course', [CourseController::class, 'index'])->name('course.index')->middleware('can:kelola_course');
    Route::get('/course/create', [CourseController::class, 'create'])->name('course.create')->middleware('can:kelola_course');
    Route::post('/course', [CourseController::class, 'store'])->name('course.store')->middleware('can:kelola_course');
    Route::get('/course/{course}/edit', [CourseController::class, 'edit'])->name('course.edit')->middleware('can:kelola_course');
    Route::put('/course/{course}', [CourseController::class, 'update'])->name('course.update')->middleware('can:kelola_course');
    Route::delete('/course/{course}', [CourseController::class, 'destroy'])->name('course.destroy')->middleware('can:kelola_course');

    // --------------------------
    // COURSE CATEGORY MANAGEMENT
    // --------------------------
    Route::get('/course-categories/index', [CourseCategoryController::class, 'index'])->name('course-categories.index')->middleware('can:kelola_course');
    Route::get('/course-categories/create', [CourseCategoryController::class, 'create'])->name('course-categories.create')->middleware('can:kelola_course');

    // CRUD Category
    Route::get('/course-categories/create-category', [CourseCategoryController::class, 'createCategory'])->name('course-categories.create.category')->middleware('can:kelola_course');
    Route::post('/course-categories/store-category', [CourseCategoryController::class, 'storeCategory'])->name('course-categories.store.category')->middleware('can:kelola_course');
    Route::get('/course-categories/{id}/edit', [CourseCategoryController::class, 'edit'])->name('course-categories.edit')->middleware('can:kelola_course');
    Route::put('/course-categories/{id}', [CourseCategoryController::class, 'update'])->name('course-categories.update')->middleware('can:kelola_course');
    Route::delete('/course-categories/{id}', [CourseCategoryController::class, 'destroy'])->name('course-categories.destroy')->middleware('can:kelola_course');

    // CRUD Level
    Route::get('/course-levels/create', [CourseCategoryController::class, 'createLevel'])->name('course-levels.create')->middleware('can:kelola_course');
    Route::post('/course-levels/store', [CourseCategoryController::class, 'storeLevel'])->name('course-levels.store')->middleware('can:kelola_course');
    Route::get('/course-levels/{id}/edit', [CourseCategoryController::class, 'editLevel'])->name('course-levels.edit')->middleware('can:kelola_course');
    Route::put('/course-levels/{id}', [CourseCategoryController::class, 'updateLevel'])->name('course-levels.update')->middleware('can:kelola_course');
    Route::delete('/course-levels/{id}', [CourseCategoryController::class, 'destroyLevel'])->name('course-levels.destroy')->middleware('can:kelola_course');

    // CRUD Price Range
    Route::get('/course-prices/create', [CourseCategoryController::class, 'createPrice'])->name('course-prices.create')->middleware('can:kelola_course');
    Route::post('/course-prices/store', [CourseCategoryController::class, 'storePrice'])->name('course-prices.store')->middleware('can:kelola_course');
    Route::get('/course-prices/{id}/edit', [CourseCategoryController::class, 'editPrice'])->name('course-prices.edit')->middleware('can:kelola_course');
    Route::put('/course-prices/{id}', [CourseCategoryController::class, 'updatePrice'])->name('course-prices.update')->middleware('can:kelola_course');
    Route::delete('/course-prices/{id}', [CourseCategoryController::class, 'destroyPrice'])->name('course-prices.destroy')->middleware('can:kelola_course');
});

// --------------------------
// Breeze Auth Routes
// --------------------------
require __DIR__ . '/auth.php';
