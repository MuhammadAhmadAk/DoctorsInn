@extends('frontend.layouts.auth')
@section('title', 'Student Login | DoctorsInnElite')
@section('meta_description', 'Login to DoctorsInnElite student portal to access MDCAT mock tests, video lectures, and learning resources.')
@section('meta_keywords', 'DoctorsInn login, student login MDCAT, google sign in MDCAT')

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
                    <h2 class="auth-visual-title">Unlock Your <span>MDCAT Potential</span></h2>
                    <p class="auth-visual-text">Learn with expert-led courses, realistic mock tests and free e-library resources — all in one place.</p>
                </div>
                <div class="auth-visual-art">
                    <img src="{{ asset('frontend/img/auth/login-illustration.png') }}" alt="" loading="eager" decoding="async">
                </div>
            </aside>

            {{-- Form panel --}}
            <div class="auth-panel">
                <div class="auth-panel-inner">

                    <a href="{{ route('home') }}" class="auth-mobile-logo">
                        <img src="{{ asset('frontend/img/logo/logo.svg') }}" alt="DoctorsInn">
                    </a>

                    <h1 class="auth-card-title">Welcome Back</h1>
                    <p class="auth-card-sub">Sign in to continue your MDCAT preparation.</p>

                    {{-- Flash Alerts --}}
                    @if (session('warning'))
                        <div class="auth-alert-box alert-warning">
                            <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                            <span>{{ session('warning') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="auth-alert-box alert-danger">
                            <i class="fa-solid fa-circle-exclamation text-danger"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="auth-alert-box alert-success">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- 1-Click Google Sign-In --}}
                    <a href="{{ route('auth.google', ['redirect' => request('redirect')]) }}" class="btn-google-auth">
                        <svg width="18" height="18" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Continue with Google</span>
                    </a>

                    {{-- Divider --}}
                    <div class="auth-divider">
                        <span>or email login</span>
                    </div>

                    {{-- Login Form --}}
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                        {{-- Email Field --}}
                        <div class="auth-field-group">
                            <label class="auth-field-label" for="email">Email Address</label>
                            <div class="auth-input-wrap">
                                <input type="email" name="email" id="email" placeholder="student@doctorsinn.pk" value="{{ old('email') }}" required>
                                <i class="fal fa-envelope"></i>
                            </div>
                        </div>

                        {{-- Password Field --}}
                        <div class="auth-field-group">
                            <label class="auth-field-label" for="password">Password</label>
                            <div class="auth-input-wrap">
                                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                                <i class="fal fa-lock"></i>
                            </div>
                        </div>

                        {{-- Meta Row --}}
                        <div class="auth-meta-row">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="remember" id="remember" checked>
                                <label for="remember" class="mb-0">Remember me</label>
                            </div>
                            <a href="{{ route('forgot-password') }}">Forgot Password?</a>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="auth-submit-btn">
                            <span>LOGIN &amp; CONTINUE</span>
                            <i class="fal fa-arrow-right"></i>
                        </button>

                        {{-- Footer Link --}}
                        <p class="auth-footer-text">
                            Don't have an account?
                            <a href="{{ route('register', ['redirect' => request('redirect')]) }}">Register Free</a>
                        </p>
                    </form>

                    <p class="auth-panel-foot">&copy; {{ date('Y') }} DoctorsInnElite. All rights reserved.</p>

                </div>
            </div>

        </div>
    </div>

@endsection
