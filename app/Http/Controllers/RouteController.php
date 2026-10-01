<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller{

    public function Frontend_Home(){
        $courses = config('courses', []);
        return view('frontend.index', compact('courses'));
    }

    public function Frontend_About(){
        return view('frontend.pages.about');
    }

    public function Frontend_Faq(){
        return view('frontend.pages.faq');
    }

    public function Frontend_Contact(){
        return view('frontend.pages.contact');
    }

    public function Frontend_PrivacyPolicy(){
        return view('frontend.pages.privacy-policy');
    }

    public function Frontend_TermsConditions(){
        return view('frontend.pages.terms-conditions');
    }

    public function Frontend_Error(){
        return view('frontend.pages.error');
    }

    public function Frontend_ELibrary(){
        return view('frontend.pages.elibrary');
    }

    // Courses
    public function Frontend_Course(){
        $courses = config('courses', []);
        return view('frontend.pages.courses.course', compact('courses'));
    }

    public function Frontend_CourseDetails(Request $request, $slug = null){
        $courses = config('courses', []);
        $slug = $slug ?? $request->query('slug');

        $course = null;
        if ($slug) {
            foreach ($courses as $c) {
                if ($c['slug'] === $slug || (string)$c['id'] === (string)$slug) {
                    $course = $c;
                    break;
                }
            }
        }

        if (!$course && !empty($courses)) {
            $course = reset($courses);
        }

        return view('frontend.pages.courses.course-details', compact('course', 'courses'));
    }

    public function Frontend_MyCourses(Request $request, $slug = null){
        $courses = config('courses', []);
        $courseParam = $slug ?: $request->query('course');

        $activeCourse = null;
        if ($courseParam) {
            foreach ($courses as $c) {
                if ($c['slug'] === $courseParam || (string)$c['id'] === (string)$courseParam) {
                    $activeCourse = $c;
                    break;
                }
            }
        }

        if (!$activeCourse && !empty($courses)) {
            $activeCourse = reset($courses);
        }

        $activeCourseSlug = $activeCourse['slug'] ?? 'mdcat-reboot-60-day';

        return view('frontend.pages.courses.my-courses', compact('courses', 'activeCourse', 'activeCourseSlug'));
    }

    public function Frontend_Cart(){
        // Cart page removed — redirect to courses
        return redirect()->route('course');
    }

    public function Frontend_Checkout(Request $request){
        $courses = config('courses', []);
        $slug = $request->query('course');

        $course = null;
        if ($slug) {
            foreach ($courses as $c) {
                if ($c['slug'] === $slug || (string)$c['id'] === (string)$slug) {
                    $course = $c;
                    break;
                }
            }
        }

        // If no course found, redirect to courses page
        if (!$course) {
            return redirect()->route('course');
        }

        return view('frontend.pages.courses.checkout', compact('course'));
    }

    // Authentication
    public function Frontend_Login(){
        return view('frontend.pages.authentication.login');
    }

    public function Frontend_Register(){
        return view('frontend.pages.authentication.register');
    }

    public function Frontend_ForgotPassword(){
        return view('frontend.pages.authentication.forgot-password');
    }

    public function Frontend_VerifyCode(){
        return view('frontend.pages.authentication.verify-code');
    }

    public function Frontend_ResetPassword(){
        return view('frontend.pages.authentication.reset-password');
    }

    // User Account
    public function Frontend_Profile(){
        $courses = config('courses', []);
        return view('frontend.pages.authentication.profile', compact('courses'));
    }

    public function Frontend_Notifications(){
        return view('frontend.pages.notifications');
    }

}
