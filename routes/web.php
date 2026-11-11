<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\RouteController;
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

// Blog
Route::get('/blog', [RouteController::class, 'Frontend_Blog'])->name('blog');
Route::get('/blog/{slug}', [RouteController::class, 'Frontend_BlogDetails'])->name('blog-details');
Route::get('/blog-details/{slug?}', function ($slug = null) {
    $slug = $slug ?? array_key_first(config('blogs', []));

    return $slug
        ? redirect()->route('blog-details', $slug, 301)
        : redirect()->route('blog');
});

// Courses
Route::get('/course', [RouteController::class, 'Frontend_Course'])->name('course');
Route::get('/courses/{slug}', [RouteController::class, 'Frontend_CourseDetails'])->name('course-details');
Route::get('/course-details/{slug?}', function ($slug = null) {
    $slug = $slug ?? array_key_first(config('courses', []));

    return $slug
        ? redirect()->route('course-details', $slug, 301)
        : redirect()->route('course');
});
Route::get('/my-courses/{slug?}', [RouteController::class, 'Frontend_MyCourses'])->name('my-courses');
Route::get('/cart', [RouteController::class, 'Frontend_Cart'])->name('cart');
Route::get('/checkout', [RouteController::class, 'Frontend_Checkout'])->name('checkout');

// Authentication
use App\Http\Controllers\Auth\StudentAuthController;

Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [StudentAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [StudentAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [StudentAuthController::class, 'register'])->name('register.submit');
Route::match(['get', 'post'], '/logout', [StudentAuthController::class, 'logout'])->name('logout');

// Google OAuth
Route::get('/auth/google', [StudentAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [StudentAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Password Reset Flow
Route::get('/forgot-password', [RouteController::class, 'Frontend_ForgotPassword'])->name('forgot-password');
Route::get('/verify-code', [RouteController::class, 'Frontend_VerifyCode'])->name('verify-code');
Route::get('/reset-password', [RouteController::class, 'Frontend_ResetPassword'])->name('reset-password');

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
});

Route::get('/dashboard', function () {
    return redirect()->route('student.dashboard');
})->name('dashboard');

Route::match(['get', 'post'], '/profile', [RouteController::class, 'Frontend_Profile'])->name('profile');
Route::get('/notifications', [RouteController::class, 'Frontend_Notifications'])->name('notifications');

// Admin Panel Routes
use App\Http\Controllers\Backend\CmsController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Auth
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected Admin Studio Routes
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.index');

        // Complete Website Content & Images CMS
        Route::get('/cms', [CmsController::class, 'index'])->name('cms');
        Route::post('/cms/section', [CmsController::class, 'updateSection'])->name('cms.section.update');
        Route::post('/cms/instructors', [CmsController::class, 'saveInstructor'])->name('cms.instructors.save');
        Route::delete('/cms/instructors/{id}', [CmsController::class, 'deleteInstructor'])->name('cms.instructors.delete');
        Route::post('/cms/testimonials', [CmsController::class, 'saveTestimonial'])->name('cms.testimonials.save');
        Route::delete('/cms/testimonials/{id}', [CmsController::class, 'deleteTestimonial'])->name('cms.testimonials.delete');
        Route::post('/cms/faqs', [CmsController::class, 'saveFaq'])->name('cms.faqs.save');
        Route::delete('/cms/faqs/{id}', [CmsController::class, 'deleteFaq'])->name('cms.faqs.delete');

        // Courses, Tests, E-Library, Blogs CRUD
        Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
        Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
        Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
        Route::delete('/courses/{slug}', [AdminController::class, 'deleteCourse'])->name('courses.delete');

        Route::get('/tests', [AdminController::class, 'tests'])->name('tests');
        Route::post('/tests', [AdminController::class, 'storeTest'])->name('tests.store');
        Route::delete('/tests/{slug}', [AdminController::class, 'deleteTest'])->name('tests.delete');

        Route::get('/elibrary', [AdminController::class, 'elibrary'])->name('elibrary');
        Route::post('/elibrary', [AdminController::class, 'storeResource'])->name('elibrary.store');
        Route::delete('/elibrary/{slug}', [AdminController::class, 'deleteResource'])->name('elibrary.delete');

        Route::get('/blogs', [AdminController::class, 'blogs'])->name('blogs');
        Route::post('/blogs', [AdminController::class, 'storeBlog'])->name('blogs.store');
        Route::delete('/blogs/{slug}', [AdminController::class, 'deleteBlog'])->name('blogs.delete');

        Route::get('/students', [AdminController::class, 'students'])->name('students');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'saveSettings'])->name('settings.save');
    });
});
