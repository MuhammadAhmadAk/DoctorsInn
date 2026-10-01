<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;

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
Route::get('/login', [RouteController::class, 'Frontend_Login'])->name('login');
Route::get('/register', [RouteController::class, 'Frontend_Register'])->name('register');
Route::get('/forgot-password', [RouteController::class, 'Frontend_ForgotPassword'])->name('forgot-password');
Route::get('/verify-code', [RouteController::class, 'Frontend_VerifyCode'])->name('verify-code');
Route::get('/reset-password', [RouteController::class, 'Frontend_ResetPassword'])->name('reset-password');

// User Account
Route::match(['get', 'post'], '/profile', [RouteController::class, 'Frontend_Profile'])->name('profile');
Route::get('/notifications', [RouteController::class, 'Frontend_Notifications'])->name('notifications');