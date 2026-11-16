<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminEnrollmentController;
use App\Http\Controllers\Backend\AdminLectureController;
use App\Http\Controllers\Backend\AdminReviewController;
use App\Http\Controllers\Backend\AdminStaffController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CourseReviewController;
use App\Http\Controllers\LectureStreamController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SafepayWebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::get('/', [RouteController::class, 'Frontend_Home'])->name('home');

// Static Pages
Route::get('/about', [RouteController::class, 'Frontend_About'])->name('about');
Route::get('/faq', [RouteController::class, 'Frontend_Faq'])->name('faq');
Route::get('/contact', [RouteController::class, 'Frontend_Contact'])->name('contact');
Route::get('/privacy-policy', [RouteController::class, 'Frontend_PrivacyPolicy'])->name('privacy-policy');
Route::get('/terms-conditions', [RouteController::class, 'Frontend_TermsConditions'])->name('terms-conditions');
Route::get('/error', [RouteController::class, 'Frontend_Error'])->name('error');
Route::get('/e-library', [RouteController::class, 'Frontend_ELibrary'])->name('e-library');
Route::get('/e-library/download/{slug}', [RouteController::class, 'Frontend_DownloadResource'])->name('e-library.download');

// Online Mock Tests & MCQs
Route::get('/tests', [RouteController::class, 'Frontend_Tests'])->name('tests');
Route::get('/test/{slug}', [RouteController::class, 'Frontend_TakeTest'])->name('test.take');
Route::post('/test/{slug}/submit', [RouteController::class, 'Frontend_SubmitTest'])->name('test.submit');
Route::get('/test/result/{attempt}', [RouteController::class, 'Frontend_TestResult'])->name('test.result');

// Blog
Route::get('/blog', [RouteController::class, 'Frontend_Blog'])->name('blog');
Route::get('/blog/{slug}', [RouteController::class, 'Frontend_BlogDetails'])->name('blog-details');
Route::get('/blog-details/{slug?}', function ($slug = null) {
    return $slug
        ? redirect()->route('blog-details', $slug, 301)
        : redirect()->route('blog');
});

// Courses
Route::get('/course', [RouteController::class, 'Frontend_Course'])->name('course');
Route::get('/courses/{slug}', [RouteController::class, 'Frontend_CourseDetails'])->name('course-details');
Route::post('/courses/{slug}/reviews', [CourseReviewController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('courses.review.store');
Route::get('/course-details/{slug?}', function ($slug = null) {
    return $slug
        ? redirect()->route('course-details', $slug, 301)
        : redirect()->route('course');
});
Route::get('/my-courses/{slug?}', [RouteController::class, 'Frontend_MyCourses'])->name('my-courses');
Route::get('/cart', [RouteController::class, 'Frontend_Cart'])->name('cart');

// Enrollment checkout (Safepay: EasyPaisa / JazzCash / card)
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout/{slug}', [CheckoutController::class, 'pay'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('checkout.pay');
Route::post('/courses/{slug}/enroll', [CheckoutController::class, 'enrollFree'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('courses.enroll');
Route::get('/checkout/return/{reference}', [CheckoutController::class, 'callback'])
    ->middleware('auth')
    ->name('checkout.callback');
Route::get('/checkout/cancel/{reference}', [CheckoutController::class, 'cancel'])
    ->middleware('auth')
    ->name('checkout.cancel');
Route::post('/checkout/status/{reference}', [CheckoutController::class, 'status'])
    ->middleware(['auth', 'throttle:12,1'])
    ->name('checkout.status');
Route::post('/webhooks/safepay', [SafepayWebhookController::class, 'handle'])->name('webhooks.safepay');

// Authentication
use App\Http\Controllers\Auth\StudentAuthController;

Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [StudentAuthController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
Route::get('/register', [StudentAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [StudentAuthController::class, 'register'])->middleware('throttle:5,1')->name('register.submit');
Route::match(['get', 'post'], '/logout', [StudentAuthController::class, 'logout'])->name('logout');

// Google OAuth
Route::get('/auth/google', [StudentAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [StudentAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Password Reset Flow
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('forgot-password');
Route::post('/forgot-password', [PasswordResetController::class, 'sendCode'])->middleware('throttle:5,1')->name('forgot-password.submit');
Route::get('/verify-code', [PasswordResetController::class, 'showVerifyForm'])->name('verify-code');
Route::post('/verify-code', [PasswordResetController::class, 'verifyCode'])->middleware('throttle:6,1')->name('verify-code.submit');
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('reset-password');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->middleware('throttle:5,1')->name('reset-password.submit');

// User Account & Student LMS Portal
use App\Http\Controllers\Student\StudentDashboardController;

Route::prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentDashboardController::class, 'courses'])->name('courses');
    Route::get('/classroom/{slug?}', [StudentDashboardController::class, 'classroom'])->name('classroom');
    Route::get('/tests', [StudentDashboardController::class, 'tests'])->name('tests');
    Route::get('/elibrary', [StudentDashboardController::class, 'elibrary'])->name('elibrary');
    Route::get('/analytics', [StudentDashboardController::class, 'analytics'])->name('analytics');
    Route::get('/settings', [StudentDashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [StudentDashboardController::class, 'updateSettings'])->name('settings.update');

    // Secure lecture playback sessions & watch progress
    Route::post('/lectures/{video}/playback-url', [LectureStreamController::class, 'playbackUrl'])->name('lectures.url');
    Route::post('/lectures/{video}/progress', [LectureStreamController::class, 'saveProgress'])->name('lectures.progress');
});

// Signed delivery for lectures. Segments/playlists come from HLS; `source` is
// the direct-progress fallback used when FFmpeg is not installed.
Route::get('/media/lectures/{video}/source', [LectureStreamController::class, 'streamOriginal'])
    ->middleware(['signed', 'throttle:1200,1'])
    ->name('lectures.original');

Route::get('/media/lectures/{video}/{file}', [LectureStreamController::class, 'stream'])
    ->where('file', '.*')
    ->middleware(['signed', 'throttle:1200,1'])
    ->name('lectures.hls');

Route::get('/dashboard', function () {
    return redirect()->route('student.dashboard');
})->name('dashboard');

Route::match(['get', 'post'], '/profile', [RouteController::class, 'Frontend_Profile'])->name('profile');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

// Admin Panel Routes
use App\Http\Controllers\Backend\CmsController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Auth
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected Admin Studio Routes
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.index');

        // Complete Website Content & Images CMS
        Route::middleware('admin.permission:cms')->group(function () {
            Route::get('/cms', [CmsController::class, 'index'])->name('cms');
            Route::post('/cms/section', [CmsController::class, 'updateSection'])->name('cms.section.update');
            Route::post('/cms/instructors', [CmsController::class, 'saveInstructor'])->name('cms.instructors.save');
            Route::delete('/cms/instructors/{id}', [CmsController::class, 'deleteInstructor'])->name('cms.instructors.delete');
            Route::post('/cms/testimonials', [CmsController::class, 'saveTestimonial'])->name('cms.testimonials.save');
            Route::delete('/cms/testimonials/{id}', [CmsController::class, 'deleteTestimonial'])->name('cms.testimonials.delete');
            Route::post('/cms/faqs', [CmsController::class, 'saveFaq'])->name('cms.faqs.save');
            Route::delete('/cms/faqs/{id}', [CmsController::class, 'deleteFaq'])->name('cms.faqs.delete');
        });

        // Courses, Tests, E-Library, Blogs CRUD
        Route::middleware('admin.permission:courses')->group(function () {
            Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
            Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
            Route::get('/courses/{slug}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
            Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
            Route::delete('/courses/{slug}', [AdminController::class, 'deleteCourse'])->name('courses.delete');
            Route::post('/courses/upload-resource', [AdminController::class, 'uploadCourseResource'])->name('courses.uploadResource');

            // Lecture video library, processing status & secure preview
            Route::post('/lectures', [AdminLectureController::class, 'store'])->name('lectures.store');
            Route::get('/lectures/{video}/status', [AdminLectureController::class, 'status'])->name('lectures.status');
            Route::get('/lectures/{video}/preview-url', [LectureStreamController::class, 'adminPlaybackUrl'])->name('lectures.preview');
            Route::post('/lectures/{video}/retry', [AdminLectureController::class, 'retry'])->name('lectures.retry');
            Route::delete('/lectures/{video}', [AdminLectureController::class, 'destroy'])->name('lectures.destroy');

            // Course Reviews Management
            Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews');
            Route::post('/reviews/{review}/toggle', [AdminReviewController::class, 'toggleStatus'])->name('reviews.toggle');
            Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.delete');
        });

        Route::middleware('admin.permission:tests')->group(function () {
            Route::get('/tests', [AdminController::class, 'tests'])->name('tests');
            Route::post('/tests', [AdminController::class, 'storeTest'])->name('tests.store');
            Route::delete('/tests/{slug}', [AdminController::class, 'deleteTest'])->name('tests.delete');
            Route::get('/tests/{slug}/questions', [AdminController::class, 'testQuestions'])->name('tests.questions');
            Route::post('/tests/{slug}/questions', [AdminController::class, 'storeQuestion'])->name('tests.questions.store');
            Route::match(['put', 'post'], '/tests/{slug}/questions/{question}', [AdminController::class, 'updateQuestion'])->name('tests.questions.update');
            Route::delete('/tests/{slug}/questions/{question}', [AdminController::class, 'deleteQuestion'])->name('tests.questions.destroy');
        });

        Route::middleware('admin.permission:library')->group(function () {
            Route::get('/elibrary', [AdminController::class, 'elibrary'])->name('elibrary');
            Route::post('/elibrary', [AdminController::class, 'storeResource'])->name('elibrary.store');
            Route::delete('/elibrary/{slug}', [AdminController::class, 'deleteResource'])->name('elibrary.delete');
        });

        Route::middleware('admin.permission:blogs')->group(function () {
            Route::get('/blogs', [AdminController::class, 'blogs'])->name('blogs');
            Route::post('/blogs', [AdminController::class, 'storeBlog'])->name('blogs.store');
            Route::delete('/blogs/{slug}', [AdminController::class, 'deleteBlog'])->name('blogs.delete');
        });

        Route::middleware('admin.permission:students')->group(function () {
            Route::get('/students', [AdminController::class, 'students'])->name('students');
        });

        // Enrollments, manual access & payment orders
        Route::middleware('admin.permission:enrollments')->group(function () {
            Route::get('/enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments');
            Route::post('/enrollments', [AdminEnrollmentController::class, 'store'])->name('enrollments.store');
            Route::post('/enrollments/{enrollment}/revoke', [AdminEnrollmentController::class, 'revoke'])->name('enrollments.revoke');
            Route::post('/enrollments/{enrollment}/restore', [AdminEnrollmentController::class, 'restore'])->name('enrollments.restore');
        });

        // Staff accounts, roles & permissions
        Route::middleware('admin.permission:staff')->group(function () {
            Route::get('/staff-access', [AdminStaffController::class, 'index'])->name('staff');
            Route::post('/staff-access', [AdminStaffController::class, 'store'])->name('staff.store');
            Route::match(['put', 'post'], '/staff-access/{staff}', [AdminStaffController::class, 'update'])->name('staff.update');
            Route::delete('/staff-access/{staff}', [AdminStaffController::class, 'destroy'])->name('staff.destroy');
        });

        Route::middleware('admin.permission:settings')->group(function () {
            Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
            Route::post('/settings', [AdminController::class, 'saveSettings'])->name('settings.save');
        });
    });
});
