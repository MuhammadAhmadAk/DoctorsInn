@extends('frontend.layouts.auth')
@section('title', 'Verify Your Account | DoctorsInnElite')
@section('meta_description', 'Enter the verification code sent to your email to verify your DoctorsInnElite account and get started with your MDCAT preparation.')
@section('meta_keywords', 'verify account DoctorsInnElite, email verification, account confirm')

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
                    <h2 class="auth-visual-title">Almost <span>There!</span></h2>
                    <p class="auth-visual-text">Enter the 6-digit code we emailed you to verify your account and start learning.</p>
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

                    <h1 class="auth-card-title">Enter Code</h1>
                    <p class="auth-card-sub">
                        We have sent a verification code to <strong>{{ $email ?? session('password_reset_email') }}</strong>.
                        Please enter the 6-digit code below.
                    </p>

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

                    @if (session('password_reset_google'))
                        <div class="auth-alert-box alert-info">
                            <i class="fa-solid fa-circle-info text-info"></i>
                            <span>Your account uses Google Sign-In. Enter the code below to set a password — after that you can sign in with either Google or your email.</span>
                        </div>
                    @endif

                    @if (session('dev_code'))
                        <div class="auth-alert-box alert-info">
                            <i class="fa-solid fa-circle-info text-info"></i>
                            <span>Email delivery is not configured on this server. Your code is
                                <strong style="letter-spacing: 2px;">{{ session('dev_code') }}</strong></span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="auth-alert-box alert-danger">
                            <i class="fa-solid fa-circle-exclamation text-danger"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form action="{{ route('verify-code.submit') }}" method="POST">
                        @csrf

                        <div class="auth-field-group">
                            <label class="auth-field-label" for="code">Verification Code</label>
                            <div class="auth-input-wrap">
                                <input type="text" name="code" id="code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                                    placeholder="6-digit code" required autocomplete="one-time-code">
                                <i class="fal fa-key"></i>
                            </div>
                        </div>

                        <button type="submit" class="auth-submit-btn">
                            <span>VERIFY CODE</span>
                            <i class="fal fa-arrow-right"></i>
                        </button>

                        <p class="auth-footer-text">
                            Didn't receive the code?
                            <a href="{{ route('forgot-password') }}">Resend</a>
                        </p>
                    </form>

                    <p class="auth-panel-foot">&copy; {{ date('Y') }} DoctorsInnElite. All rights reserved.</p>

                </div>
            </div>

        </div>
    </div>

@endsection
