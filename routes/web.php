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
    AuthenticatedSessionController,
    PendingVerificationController
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
    TestimoniController,
    CommentController,
    ShowcaseController,
    CourseDetailController,
    LessonController,
    InstructorProfileController
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
    KatalogClientController,
    TestimoniClientController,
    InstrukturClientController,
    // LoginClientController  // (tidak dipakai; login pakai StudentAuthController)
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
Route::get('/', [HomeClientController::class, 'index'])->name('home.index');
Route::get('/about', [AboutClientController::class, 'index'])->name('about.index');

Route::get('/contact', [ContactClientController::class, 'index'])->name('contact.index');
// Showcase publik
Route::get('/showcase', [ShowcaseClientController::class, 'index'])->name('showcase.index');

Route::get('/testimoni', [TestimoniClientController::class, 'index'])->name('testimoni.index');
Route::get('/instruktur', [InstrukturClientController::class, 'index'])->name('instruktur.index');
Route::get('/katalog', [KatalogClientController::class, 'index'])->name('katalog.index');

/* === ALIAS AMAN (TIDAK MENIMPA RUTE ASLI) ===
   Alias ini hanya redirect ke rute asli supaya pemanggilan route('course.detail')
   dan route('course.lessons') tetap bisa dipakai tanpa menimpa nama rute lama. */
Route::get('/go/course/{slug}', function ($slug) {
    return redirect()->route('detail.index', ['slug' => $slug]);
})->name('course.detail');

Route::get('/go/lessons/{slug}', function ($slug) {
    return redirect()->route('lesson.index', ['slug' => $slug]);
})->name('course.lessons');

/*
|--------------------------------------------------------------------------
| ==========================
| STUDENT AUTH (GUEST ONLY)
| ==========================
| Form login/register + forgot/reset password.
*/
Route::middleware(['guest'])->group(function () {
    // Login & Register
    Route::get('/login', [StudentAuthController::class, 'showLoginRegisterForm'])->name('login');
    
    Route::post('/login', [StudentAuthController::class, 'login'])->name('login.submit');


    Route::get('/register', [StudentAuthController::class, 'showLoginRegisterForm'])->name('register');
    // Route::post('/register', [StudentAuthController::class, 'register'])->name('register.submit');

    Route::post('/register-pending', [PendingVerificationController::class, 'storePending'])
        ->name('register.pending')
        ->middleware('throttle:5,1');

    // NOTE: rute verify-pending DIPINDAH ke luar grup guest (lihat di bawah)
    // Forgot & Reset Password
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// >>> VERIFY-PENDING: letakkan DI LUAR semua grup agar tidak terblokir middleware guest
Route::get('/verify-pending', [PendingVerificationController::class, 'verify'])
    ->name('pending.verify');

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
    Route::get('/data', [PendataanClientController::class, 'index'])->name('pendataan.index');
    Route::post('/data', [PendataanClientController::class, 'store'])->name('pendataan.store');
});

/*
|--------------------------------------------------------------------------
| ===========================================
| STUDENT — Area utama (SETELAH profil lengkap)
| ===========================================
| Semua fitur siswa lain wajib lewat CheckUserProfileMiddleware.
*/
Route::middleware([
    'auth',
    'role:student',
    \App\Http\Middleware\CheckUserProfileMiddleware::class
])->group(function () {

    // Dashboard
    Route::get('/dashboard', [ProfileClientController::class, 'index'])->name('dashboard.index');

    // Courses (dipindah dari guest ke student)
    Route::get('/course', [CourseClientController::class, 'index'])->name('course.index');

/* === DETAIL & LESSONS — RUTE ASLI (JANGAN DIUBAH) === */
    Route::get('/detail/{slug}', [DetailCourseClientController::class, 'index'])->name('detail.index');
    Route::get('/detail/{slug}/lessons', [LessonClientController::class, 'index'])->name('lesson.index');

    // Payments (dipindah dari guest ke student)
    Route::get('/payment', [PaymentClientController::class, 'index'])->name('payment.index');

      // === Student Profile (Settings) ===
    Route::get('/profile', [\App\Http\Controllers\Student\ProfileSettingsController::class, 'show'])
        ->name('student.profile.show');

    Route::put('/profile/biodata', [\App\Http\Controllers\Student\ProfileSettingsController::class, 'updateBiodata'])
        ->name('student.profile.biodata');

    Route::put('/profile/account', [\App\Http\Controllers\Student\ProfileSettingsController::class, 'updateAccount'])
        ->name('student.profile.account');

    // Ganti password: pakai controller Auth kamu (punya error bag "updatePassword")
    Route::put('/profile/password', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])
        ->name('student.profile.password');
});


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
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

        // User Management
        Route::resource('/users', UserController::class)
            ->except('show')
            ->middleware('is_superadmin');

        // About & Contact
        Route::resource('/about', AboutController::class)->middleware('can:kelola_about');
        Route::prefix('contact')->middleware('can:kelola_contact')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('contact.index');
            Route::get('/edit', [ContactController::class, 'edit'])->name('contact.edit');
            Route::post('/update', [ContactController::class, 'update'])->name('contact.update');
        });

        // Course Management
        Route::resource('/course', CourseController::class)
            ->except('show')
            ->middleware('can:kelola_course');

        // Course Categories
        Route::prefix('course-categories')->middleware('can:kelola_course')->group(function () {
            Route::get('/index', [CourseCategoryController::class, 'index'])->name('course-categories.index');
            Route::get('/create', [CourseCategoryController::class, 'create'])->name('course-categories.create');
            Route::get('/create-category', [CourseCategoryController::class, 'createCategory'])->name('course-categories.create.category');
            Route::post('/store-category', [CourseCategoryController::class, 'storeCategory'])->name('course-categories.store.category');
            Route::get('/{id}/edit', [CourseCategoryController::class, 'edit'])->name('course-categories.edit');
            Route::put('/{id}', [CourseCategoryController::class, 'update'])->name('course-categories.update');
            Route::delete('/{id}', [CourseCategoryController::class, 'destroy'])->name('course-categories.destroy');
        });

        // Course Levels
        Route::prefix('course-levels')->middleware('can:kelola_course')->group(function () {
            Route::get('/create', [CourseCategoryController::class, 'createLevel'])->name('course-levels.create');
            Route::post('/store', [CourseCategoryController::class, 'storeLevel'])->name('course-levels.store');
            Route::get('/{id}/edit', [CourseCategoryController::class, 'editLevel'])->name('course-levels.edit');
            Route::put('/{id}', [CourseCategoryController::class, 'updateLevel'])->name('course-levels.update');
            Route::delete('/{id}', [CourseCategoryController::class, 'destroyLevel'])->name('course-levels.destroy');
        });

        // Course Prices
        Route::prefix('course-prices')->middleware('can:kelola_course')->group(function () {
            Route::get('/create', [CourseCategoryController::class, 'createPrice'])->name('course-prices.create');
            Route::post('/store', [CourseCategoryController::class, 'storePrice'])->name('course-prices.store');
            Route::get('/{id}/edit', [CourseCategoryController::class, 'editPrice'])->name('course-prices.edit');
            Route::put('/{id}', [CourseCategoryController::class, 'updatePrice'])->name('course-prices.update');
            Route::delete('/{id}', [CourseCategoryController::class, 'destroyPrice'])->name('course-prices.destroy');
        });

        // Detail Courses (ADMIN)
        Route::resource('/detail', CourseDetailController::class, )
            ->middleware('can:kelola_course')
            ->names('detail');

        // Tambahan AJAX endpoint untuk ambil data lengkap course (ADMIN)
        Route::get('/detail/course/{id}/info', [CourseDetailController::class, 'getCourseInfo'])
            ->middleware('can:kelola_course')
            ->name('detail.course.info');

        // Lessons (ADMIN)
        Route::resource('/lessons', LessonController::class);
        Route::get('course/{courseId}/modules', [LessonController::class, 'getModules'])->name('course.modules');

        // Route::resource('/comments', CommentController::class)->except('show');
        Route::resource('/showcase', ShowcaseController::class)->middleware('can:kelola_showcase');
        Route::resource('/testimoni', TestimoniController::class)
            ->except('show')->middleware('can:kelola_testimoni');
        Route::resource('/instruktur', InstructorProfileController::class)
        ->except('show')
        ->middleware('can:kelola_instructor');
});

// Route Payment Gateaway (Midtrans) - untuk AJAX dari client
Route::post('/checkout', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');
Route::get('/test-midtrans', function () {
    return [
        'server' => config('midtrans.serverKey'),
        'client' => config('midtrans.clientKey'),
        'prod' => config('midtrans.isProduction'),
    ];
});

/*
|--------------------------------------------------------------------------
| Laravel Default Auth (Breeze/Fortify/etc)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
