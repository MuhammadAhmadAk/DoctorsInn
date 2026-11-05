<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class StudentAuthController extends Controller
{
    /**
     * Show Student Login Form
     */
    public function showLoginForm(Request $request)
    {
        if (Auth::check() || session()->has('user')) {
            $redirect = $request->query('redirect');
            return $redirect ? redirect($redirect) : redirect()->route('my-courses');
        }

        return view('frontend.pages.authentication.login');
    }

    /**
     * Handle Student Login Submit
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = trim(strtolower($request->email));
        $password = $request->password;
        $remember = $request->boolean('remember', true);

        // 1. Attempt Database Authentication
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);

            // Sync session format for all frontend components
            session([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'target_exam' => $user->target_exam ?? 'mdcat',
                    'avatar' => $user->avatar ?: 'frontend/img/testimonial/testi_2_1.png',
                    'role' => $user->role,
                    'enrolled_date' => $user->created_at ? $user->created_at->format('M Y') : now()->format('M Y'),
                ],
            ]);

            $redirectUrl = $request->input('redirect');
            if ($redirectUrl && filter_var($redirectUrl, FILTER_VALIDATE_URL)) {
                return redirect($redirectUrl)->with('success', 'Welcome back, ' . $user->name . '!');
            }

            return redirect()->route('my-courses')->with('success', 'Welcome back, ' . $user->name . '!');
        }

        // 2. Demo fallback for student@doctorsinn.pk
        if ($email === 'student@doctorsinn.pk' && in_array($password, ['12345678', 'student123', 'password'])) {
            session([
                'user' => [
                    'id' => 2,
                    'name' => 'MDCAT Aspirant',
                    'email' => 'student@doctorsinn.pk',
                    'phone' => '+92 312 9876543',
                    'target_exam' => 'mdcat',
                    'avatar' => 'frontend/img/testimonial/testi_2_1.png',
                    'role' => 'student',
                    'enrolled_date' => now()->format('M Y'),
                ],
            ]);

            return redirect()->route('my-courses')->with('success', 'Welcome back, MDCAT Aspirant!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid email or password. Please verify your credentials or register a free account.');
    }

    /**
     * Show Student Registration Form
     */
    public function showRegisterForm(Request $request)
    {
        if (Auth::check() || session()->has('user')) {
            return redirect()->route('my-courses');
        }

        return view('frontend.pages.authentication.register');
    }

    /**
     * Handle Student Registration Submit
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|string|email|max:150|unique:users,email',
            'phone' => 'required|string|max:25',
            'target_exam' => 'nullable|string|in:mdcat,nums,army,other',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'This email address is already registered. Please log in instead.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 6 characters long.',
            'phone.required' => 'Please provide your active WhatsApp or mobile number.',
        ]);

        // Clean name
        $name = trim($request->name);
        $email = strtolower(trim($request->email));
        $phone = trim($request->phone);
        $targetExam = $request->target_exam ?: 'mdcat';

        // Create new student in database
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'target_exam' => $targetExam,
            'role' => 'student',
            'avatar' => 'frontend/img/testimonial/testi_2_1.png',
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        // Auto-login newly registered student
        Auth::login($user, true);

        session([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'target_exam' => $user->target_exam,
                'avatar' => $user->avatar,
                'role' => $user->role,
                'enrolled_date' => now()->format('M Y'),
            ],
        ]);

        $redirectUrl = $request->input('redirect');
        if ($redirectUrl && filter_var($redirectUrl, FILTER_VALIDATE_URL)) {
            return redirect($redirectUrl)->with('success', 'Account created successfully! Welcome to DoctorsInn, ' . $user->name . '.');
        }

        return redirect()->route('my-courses')->with('success', 'Account created successfully! Welcome to DoctorsInn, ' . $user->name . '. Explore your courses below.');
    }

    /**
     * Redirect to Google OAuth Provider
     */
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('redirect')) {
            session(['auth_redirect' => $request->input('redirect')]);
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        // Check if Google credentials are configured
        if (empty($clientId) || empty($clientSecret) || $clientId === 'your-google-client-id') {
            return redirect()->route('login')->with('warning', 'Google Sign-In is ready! To activate, add your GOOGLE_CLIENT_ID & GOOGLE_CLIENT_SECRET from Google Cloud Console into .env.');
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Throwable $e) {
            return redirect()->route('login')->with('error', 'Google Sign-In error: ' . $e->getMessage());
        }
    }

    /**
     * Handle Google OAuth Callback
     */
    public function handleGoogleCallback(Request $request)
    {
        $redirectUrl = session()->pull('auth_redirect', route('my-courses'));

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->with('error', 'Unable to authenticate with Google. Please try again or use email login.');
        }

        $googleId = $googleUser->getId();
        $email = strtolower(trim($googleUser->getEmail()));
        $name = $googleUser->getName() ?: 'Student';
        $avatar = $googleUser->getAvatar();

        // 1. Check if user exists by google_id OR by email
        $user = User::where('google_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        if ($user) {
            // Existing user — link google_id & avatar if not set
            $user->google_id = $googleId;
            if (empty($user->avatar) && $avatar) {
                $user->avatar = $avatar;
            }
            $user->save();
        } else {
            // New user registration via Google
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleId,
                'avatar' => $avatar ?: 'frontend/img/testimonial/testi_2_1.png',
                'role' => 'student',
                'target_exam' => 'mdcat',
                'email_verified_at' => now(),
            ]);
        }

        // Log the student in
        Auth::login($user, true);

        session([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'target_exam' => $user->target_exam ?? 'mdcat',
                'avatar' => $user->avatar ?: 'frontend/img/testimonial/testi_2_1.png',
                'role' => $user->role,
                'enrolled_date' => $user->created_at ? $user->created_at->format('M Y') : now()->format('M Y'),
            ],
        ]);

        return redirect($redirectUrl)->with('success', 'Signed in successfully with Google! Welcome, ' . $user->name . '.');
    }

    /**
     * Student Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('user');
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been successfully logged out.');
    }
}
