@extends('frontend.layouts.auth')
@section('title', 'Student Registration | DoctorsInnElite')
@section('meta_description', 'Create your free DoctorsInnElite student account to start preparing for MDCAT, NUMS, and AMC entrance tests.')
@section('meta_keywords', 'DoctorsInn register, student sign up MDCAT, google register MDCAT')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}?v={{ filemtime(public_path('frontend/css/auth.css')) }}">
@endsection

@section('content')

    <div class="auth-shell">
        <div class="auth-card">

            {{-- Illustration panel --}}
            <aside class="auth-visual" aria-hidden="true">
                <a href="{{ route('home') }}" class="auth-visual-logo">
                    <img src="{{ asset('frontend/img/logo/logo.svg') }}" alt="">
                </a>
                <div class="auth-visual-copy">
                    <h2 class="auth-visual-title">Start Your <span>Medical Journey</span></h2>
                    <p class="auth-visual-text">Create a free account to track progress, attempt timed mock tests and download study notes.</p>
                </div>
                <div class="auth-visual-art">
                    <img src="{{ asset('frontend/img/auth/register-illustration.webp') . '?v=' . filemtime(public_path('frontend/img/auth/register-illustration.webp')) }}" alt="" loading="eager" decoding="async">
                </div>
            </aside>

            {{-- Form panel --}}
            <div class="auth-panel">
                <div class="auth-panel-inner">

                    <a href="{{ route('home') }}" class="auth-mobile-logo">
                        <img src="{{ asset('frontend/img/logo/logo.svg') }}" alt="DoctorsInn">
                    </a>

                    <h1 class="auth-card-title">Create Your Account</h1>
                    <p class="auth-card-sub">Start your MDCAT 2026 preparation journey.</p>

                    {{-- Flash & Error Alerts --}}
                    @if (session('error'))
                        <div class="auth-alert-box alert-danger">
                            <i class="fa-solid fa-circle-exclamation text-danger"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="auth-alert-box alert-danger">
                            <i class="fa-solid fa-circle-exclamation text-danger"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    {{-- 1-Click Google Sign-Up --}}
                    <a href="{{ route('auth.google', ['redirect' => request('redirect')]) }}" class="btn-google-auth">
                        <svg width="18" height="18" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Sign up with Google</span>
                    </a>

                    {{-- Divider --}}
                    <div class="auth-divider">
                        <span>or register with email</span>
                    </div>

                    {{-- Registration Form --}}
                    <form action="{{ route('register.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                        {{-- Row 1: First Name & Last Name --}}
                        <div class="row g-2">
                            <div class="col-12 col-sm-6 auth-field-group">
                                <label class="auth-field-label" for="firstname">First Name</label>
                                <div class="auth-input-wrap">
                                    <input type="text" name="firstname" id="firstname" placeholder="First Name" value="{{ old('firstname') }}" required>
                                    <i class="fal fa-user"></i>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 auth-field-group">
                                <label class="auth-field-label" for="lastname">Last Name</label>
                                <div class="auth-input-wrap">
                                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" value="{{ old('lastname') }}" required>
                                    <i class="fal fa-user"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Row 2: Email & Phone Number --}}
                        <div class="row g-2">
                            <div class="col-12 col-sm-6 auth-field-group">
                                <label class="auth-field-label" for="email">Email Address</label>
                                <div class="auth-input-wrap">
                                    <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
                                    <i class="fal fa-envelope"></i>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 auth-field-group">
                                <label class="auth-field-label" for="phone">WhatsApp / Phone</label>
                                <div class="auth-input-wrap">
                                    <input type="text" name="phone" id="phone" placeholder="0300 1234567" value="{{ old('phone') }}" required>
                                    <i class="fal fa-phone-alt"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Row 3: Password & Confirm Password --}}
                        <div class="row g-2">
                            <div class="col-12 col-sm-6 auth-field-group">
                                <label class="auth-field-label" for="password">Password</label>
                                <div class="auth-input-wrap">
                                    <input type="password" name="password" id="password" placeholder="Min 6 chars" required>
                                    <i class="fal fa-lock"></i>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 auth-field-group">
                                <label class="auth-field-label" for="confirm_password">Confirm Password</label>
                                <div class="auth-input-wrap">
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Repeat pass" required>
                                    <i class="fal fa-shield-check"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Terms Checkbox --}}
                        <div class="auth-terms-row">
                            <input type="checkbox" name="privacy" id="privacy" checked required>
                            <label for="privacy" class="mb-0 cursor-pointer">
                                I agree to the <a href="{{ route('privacy-policy') }}" target="_blank">Privacy Policy</a> &amp; <a href="{{ route('terms-conditions') }}" target="_blank">Terms</a>
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="auth-submit-btn">
                            <span>CREATE FREE ACCOUNT</span>
                            <i class="fal fa-arrow-right"></i>
                        </button>

                        {{-- Footer Link --}}
                        <p class="auth-footer-text">
                            Already have an account?
                            <a href="{{ route('login', ['redirect' => request('redirect')]) }}">Sign In Here</a>
                        </p>
                    </form>

                    <p class="auth-panel-foot">&copy; {{ date('Y') }} DoctorsInnElite. All rights reserved.</p>

                </div>
            </div>

        </div>
    </div>

@endsection
