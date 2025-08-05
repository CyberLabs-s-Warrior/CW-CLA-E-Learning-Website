<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Admin\{
    DashboardController, UsersController, RoleController, AboutController,
    UserController, ProfileController, ContactController, CourseController,
    CourseCategoryController, DetailCourseController, LessonController, CommentController
};

use App\Http\Controllers\{
    HomeClientController, CourseClientController, LessonClientController,
    LoginClientController, ProfileClientController, DetailCourseClientController,
    AboutClientController, PendataanClientController, PaymentClientController
};

// --------------------------
// Public Client Routes
// --------------------------
// Route::get('/', fn() => view('welcome'));
Route::get('/', [HomeClientController::class, 'index'])->name('home.index');
Route::get('/course', [CourseClientController::class, 'index'])->name('course.index');
Route::get('/lesson', [LessonClientController::class, 'index'])->name('lesson.index');
Route::get('/profile', [ProfileClientController::class, 'index'])->name('profile.index');
Route::get('/detail-course', [DetailCourseClientController::class, 'index'])->name('detail.index');
Route::get('/about', [AboutClientController::class, 'index'])->name('about.index');
Route::get('/data', [PendataanClientController::class, 'index'])->name('pendataan.index');
Route::get('/payment', [PaymentClientController::class, 'index'])->name('payment.index');

// --------------------------
// Student Auth Routes
// --------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLoginRegisterForm'])->name('login');
    Route::post('/login', [StudentAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [StudentAuthController::class, 'showLoginRegisterForm'])->name('register');
    Route::post('/register', [StudentAuthController::class, 'register'])->name('register.submit');
});
Route::middleware('auth')->post('/logout', [StudentAuthController::class, 'logout'])->name('logout');

// --------------------------
// Admin Auth Routes
// --------------------------
Route::get('/login-admin', [AuthenticatedSessionController::class, 'create'])->name('admin.login');
Route::post('/login-admin', [AuthenticatedSessionController::class, 'store'])->name('admin.login.submit');
Route::post('/logout-admin', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

// --------------------------
// Admin Panel Routes
// --------------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    // User Management
    Route::resource('/users', UserController::class)->except('show')->middleware('is_superadmin');

    // About & Contact
    Route::resource('/about', AboutController::class)->middleware('can:kelola_about');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index')->middleware('can:kelola_contact');
    Route::get('/contact/edit', [ContactController::class, 'edit'])->name('contact.edit')->middleware('can:kelola_contact');
    Route::post('/contact/update', [ContactController::class, 'update'])->name('contact.update')->middleware('can:kelola_contact');

    // Course Management
    Route::resource('/course', CourseController::class)->except('show')->middleware('can:kelola_course');

    // Course Category, Level, Price
    Route::prefix('course-categories')->middleware('can:kelola_course')->group(function () {
        Route::get('/index', [CourseCategoryController::class, 'index'])->name('course-categories.index');
        Route::get('/create', [CourseCategoryController::class, 'create'])->name('course-categories.create');
        Route::get('/create-category', [CourseCategoryController::class, 'createCategory'])->name('course-categories.create.category');
        Route::post('/store-category', [CourseCategoryController::class, 'storeCategory'])->name('course-categories.store.category');
        Route::get('/{id}/edit', [CourseCategoryController::class, 'edit'])->name('course-categories.edit');
        Route::put('/{id}', [CourseCategoryController::class, 'update'])->name('course-categories.update');
        Route::delete('/{id}', [CourseCategoryController::class, 'destroy'])->name('course-categories.destroy');
    });

    Route::prefix('course-levels')->middleware('can:kelola_course')->group(function () {
        Route::get('/create', [CourseCategoryController::class, 'createLevel'])->name('course-levels.create');
        Route::post('/store', [CourseCategoryController::class, 'storeLevel'])->name('course-levels.store');
        Route::get('/{id}/edit', [CourseCategoryController::class, 'editLevel'])->name('course-levels.edit');
        Route::put('/{id}', [CourseCategoryController::class, 'updateLevel'])->name('course-levels.update');
        Route::delete('/{id}', [CourseCategoryController::class, 'destroyLevel'])->name('course-levels.destroy');
    });

    Route::prefix('course-prices')->middleware('can:kelola_course')->group(function () {
        Route::get('/create', [CourseCategoryController::class, 'createPrice'])->name('course-prices.create');
        Route::post('/store', [CourseCategoryController::class, 'storePrice'])->name('course-prices.store');
        Route::get('/{id}/edit', [CourseCategoryController::class, 'editPrice'])->name('course-prices.edit');
        Route::put('/{id}', [CourseCategoryController::class, 'updatePrice'])->name('course-prices.update');
        Route::delete('/{id}', [CourseCategoryController::class, 'destroyPrice'])->name('course-prices.destroy');
    });

    // Detail Courses
    Route::resource('/detail_courses', DetailCourseController::class);

    // Lessons
    Route::resource('/lessons', LessonController::class);

    // AJAX - Fetch modules by DetailCourse ID
    Route::get('/detail-courses/{id}/modules', function ($id) {
        $course = \App\Models\DetailCourse::findOrFail($id);
        return response()->json([
            'modules' => $course->modules ?? []
        ]);
    })->name('detail_courses.modules');

    // Comments
    Route::resource('/comments', CommentController::class)->except('show');
});

// --------------------------
// Breeze Auth Routes
// --------------------------
require __DIR__ . '/auth.php';
