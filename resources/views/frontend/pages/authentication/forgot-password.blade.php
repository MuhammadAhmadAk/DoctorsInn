@extends('frontend.layouts.auth')
@section('title', 'Forgot Password | DoctorsInnElite')
@section('meta_description', 'Reset your DoctorsInnElite account password quickly and securely. Enter your email to receive a password reset code.')
@section('meta_keywords', 'DoctorsInnElite forgot password, reset password, account recovery')

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
                    <h2 class="auth-visual-title">Recover Your <span>Account</span></h2>
                    <p class="auth-visual-text">Enter your email and we'll send you a 6-digit verification code to reset your password safely.</p>
                </div>
                <div class="auth-visual-art">
                    <img src="{{ asset('frontend/img/auth/recovery-illustration.webp') . '?v=' . filemtime(public_path('frontend/img/auth/recovery-illustration.webp')) }}" alt="" loading="eager" decoding="async">
                </div>
            </aside>

            {{-- Form panel --}}
            <div class="auth-panel">
                <div class="auth-panel-inner">

                    <a href="{{ route('home') }}" class="auth-mobile-logo">
                        <img src="{{ asset('frontend/img/logo/logo.svg') }}" alt="DoctorsInn">
                    </a>

                    <h1 class="auth-card-title">Recover Password</h1>
                    <p class="auth-card-sub">Enter your email address and we'll send you a verification code to reset your password. If you signed up with Google, you can set a password here too — it stays linked to the same account.</p>

                    {{-- Flash & Error Alerts --}}
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

                    @if ($errors->any())
                        <div class="auth-alert-box alert-danger">
                            <i class="fa-solid fa-circle-exclamation text-danger"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form action="{{ route('forgot-password.submit') }}" method="POST">
                        @csrf

                        <div class="auth-field-group">
                            <label class="auth-field-label" for="email">Email Address</label>
                            <div class="auth-input-wrap">
                                <input type="email" name="email" id="email" placeholder="Your Email Address"
                                    value="{{ old('email', session('password_reset_email')) }}" required autocomplete="email">
                                <i class="fal fa-envelope"></i>
                            </div>
                        </div>

                        <button type="submit" class="auth-submit-btn">
                            <span>SEND CODE</span>
                            <i class="fal fa-arrow-right"></i>
                        </button>

                        <p class="auth-footer-text">
                            Remember your password?
                            <a href="{{ route('login') }}">Sign In</a>
                        </p>
                    </form>

                    <p class="auth-panel-foot">&copy; {{ date('Y') }} DoctorsInnElite. All rights reserved.</p>

                </div>
            </div>

        </div>
    </div>

@endsection
