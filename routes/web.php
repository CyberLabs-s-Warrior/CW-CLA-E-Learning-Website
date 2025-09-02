<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\{
    NewPasswordController,
    StudentAuthController,
    PasswordResetLinkController,
    AuthenticatedSessionController
};

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\{
    DashboardController,
    UsersController,
    RoleController,
    AboutController,
    UserController,
    ProfileController,
    ContactController,
    CourseController,
    CourseCategoryController,
    DetailCourseController,
    LessonController,
    CommentController,
    ShowcaseController
};

/*
|--------------------------------------------------------------------------
| GUEST CONTROLLERS (publik)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Guest\{
    HomeClientController,
    AboutClientController,
    ShowcaseClientController,
    ContactClientController,
};

/*
|--------------------------------------------------------------------------
| STUDENT CONTROLLERS (sesudah login)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Student\{
    CourseClientController,
    DetailCourseClientController,
    LessonClientController,
    PaymentClientController,
    PendataanClientController,
    ProfileClientController
};

/*
|--------------------------------------------------------------------------
| ================
| GUEST (PUBLIC)
| ================
| Hanya halaman publik. Tidak ada course/detail/lessons/payment di sini.
*/
Route::get('/',      [HomeClientController::class,  'index'])->name('home.index');
Route::get('/about', [AboutClientController::class, 'index'])->name('about.index');
Route::get('/contact', [ContactClientController::class, 'index'])->name('contact.index');
// Showcase publik
Route::get('/showcase', [ShowcaseClientController::class, 'index'])
    ->name('showcase.index');

/*
|--------------------------------------------------------------------------
| ==========================
| STUDENT AUTH (GUEST ONLY)
| ==========================
| Form login/register + forgot/reset password.
*/
Route::middleware(['guest'])->group(function () {
    // Login & Register
    Route::get('/login',     [StudentAuthController::class, 'showLoginRegisterForm'])->name('login');
    Route::post('/login',    [StudentAuthController::class, 'login'])->name('login.submit');

    Route::get('/register',  [StudentAuthController::class, 'showLoginRegisterForm'])->name('register');
    Route::post('/register', [StudentAuthController::class, 'register'])->name('register.submit');

    // Forgot & Reset Password
    Route::get('/forgot-password',        [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password',       [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password',        [NewPasswordController::class, 'store'])->name('password.store');
});

// Logout student
Route::middleware(['auth'])->post('/logout', [StudentAuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ===========================================
| STUDENT — Pendataan (SEBELUM profil lengkap)
| ===========================================
| Alur: register → (email) → pendataan → dashboard.
| Pendataan TIDAK lewat CheckUserProfileMiddleware.
*/
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/data',  [PendataanClientController::class, 'index'])->name('pendataan.index');
    Route::post('/data', [PendataanClientController::class, 'store'])->name('pendataan.store');
});

/*
|--------------------------------------------------------------------------
| ===========================================
| STUDENT — Area utama (SETELAH profil lengkap)
| ===========================================
| Semua fitur siswa lain wajib lewat CheckUserProfileMiddleware.
*/
Route::middleware(['auth', 'role:student', \App\Http\Middleware\CheckUserProfileMiddleware::class])->group(function () {

    // Dashboard
    Route::get('/dashboard', [ProfileClientController::class, 'index'])->name('dashboard.index');

    // Courses (dipindah dari guest ke student)
    Route::get('/course',                      [CourseClientController::class,       'index'])->name('course.index');
    Route::get('/detail/{courseName}',         [DetailCourseClientController::class, 'index'])->name('detail.index');
    Route::get('/detail/{courseName}/lessons', [LessonClientController::class,       'index'])->name('lesson.index');

    // Payments (dipindah dari guest ke student)
    Route::get('/payment', [PaymentClientController::class, 'index'])->name('payment.index');
});

/*
|--------------------------------------------------------------------------
| ==========================
| ADMIN AUTH ROUTES
| ==========================
*/
Route::get('/login-admin',  [AuthenticatedSessionController::class, 'create'])->name('admin.login');
Route::post('/login-admin', [AuthenticatedSessionController::class, 'store'])->name('admin.login.submit');
Route::post('/logout-admin',[AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ===================
| ADMIN PANEL ROUTES
| ===================
*/
Route::middleware(['auth', 'role:admin|superadmin|instructor'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard & Profile
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/profile',   [ProfileController::class, 'show'])->name('profile.show');

        // User Management
        Route::resource('/users', UserController::class)
            ->except('show')
            ->middleware('is_superadmin');

        // About & Contact
        Route::resource('/about', AboutController::class)->middleware('can:kelola_about');
        Route::prefix('contact')->middleware('can:kelola_contact')->group(function () {
            Route::get('/',      [ContactController::class, 'index'])->name('contact.index');
            Route::get('/edit',  [ContactController::class, 'edit'])->name('contact.edit');
            Route::post('/update',[ContactController::class, 'update'])->name('contact.update');
        });

        // Course Management
        Route::resource('/course', CourseController::class)
            ->except('show')
            ->middleware('can:kelola_course');

        // Course Categories
        Route::prefix('course-categories')->middleware('can:kelola_course')->group(function () {
            Route::get('/index',           [CourseCategoryController::class, 'index'])->name('course-categories.index');
            Route::get('/create',          [CourseCategoryController::class, 'create'])->name('course-categories.create');
            Route::get('/create-category', [CourseCategoryController::class, 'createCategory'])->name('course-categories.create.category');
            Route::post('/store-category', [CourseCategoryController::class, 'storeCategory'])->name('course-categories.store.category');
            Route::get('/{id}/edit',       [CourseCategoryController::class, 'edit'])->name('course-categories.edit');
            Route::put('/{id}',            [CourseCategoryController::class, 'update'])->name('course-categories.update');
            Route::delete('/{id}',         [CourseCategoryController::class, 'destroy'])->name('course-categories.destroy');
        });

        // Course Levels
        Route::prefix('course-levels')->middleware('can:kelola_course')->group(function () {
            Route::get('/create',    [CourseCategoryController::class, 'createLevel'])->name('course-levels.create');
            Route::post('/store',    [CourseCategoryController::class, 'storeLevel'])->name('course-levels.store');
            Route::get('/{id}/edit', [CourseCategoryController::class, 'editLevel'])->name('course-levels.edit');
            Route::put('/{id}',      [CourseCategoryController::class, 'updateLevel'])->name('course-levels.update');
            Route::delete('/{id}',   [CourseCategoryController::class, 'destroyLevel'])->name('course-levels.destroy');
        });

        // Course Prices
        Route::prefix('course-prices')->middleware('can:kelola_course')->group(function () {
            Route::get('/create',    [CourseCategoryController::class, 'createPrice'])->name('course-prices.create');
            Route::post('/store',    [CourseCategoryController::class, 'storePrice'])->name('course-prices.store');
            Route::get('/{id}/edit', [CourseCategoryController::class, 'editPrice'])->name('course-prices.edit');
            Route::put('/{id}',      [CourseCategoryController::class, 'updatePrice'])->name('course-prices.update');
            Route::delete('/{id}',   [CourseCategoryController::class, 'destroyPrice'])->name('course-prices.destroy');
        });

        // Detail Courses
        Route::resource('/detail_courses', DetailCourseController::class);

        // Lessons
        Route::resource('/lessons', LessonController::class);

        Route::get('course/{courseId}/modules', [LessonController::class, 'getModules'])->name('course.modules');

        Route::resource('/comments', CommentController::class)->except('show');
        Route::resource('/showcases', ShowcaseController::class)->middleware('can:kelola_showcase');

    });

/*
|--------------------------------------------------------------------------
| Laravel Default Auth (Breeze/Fortify/etc)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
