@extends('frontend.layouts.auth')
@section('title', 'Reset Password | DoctorsInnElite')
@section('meta_description', 'Set a new password for your DoctorsInnElite account and regain access to your MDCAT preparation courses.')
@section('meta_keywords', 'reset password DoctorsInnElite, new password, account recovery')

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
                    <h2 class="auth-visual-title">Create a <span>New Password</span></h2>
                    <p class="auth-visual-text">Choose a strong password to keep your MDCAT preparation progress safe.</p>
                </div>
                <div class="auth-visual-art">
                    <img src="{{ asset('frontend/img/auth/recovery-illustration.png') }}" alt="" loading="eager" decoding="async">
                </div>
            </aside>

            {{-- Form panel --}}
            <div class="auth-panel">
                <div class="auth-panel-inner">

                    <a href="{{ route('home') }}" class="auth-mobile-logo">
                        <img src="{{ asset('frontend/img/logo/logo.svg') }}" alt="DoctorsInn">
                    </a>

                    <h1 class="auth-card-title">New Password</h1>
                    <p class="auth-card-sub">Please set a new secure password for your account.</p>

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

                    <form action="{{ route('reset-password.submit') }}" method="POST">
                        @csrf

                        <div class="auth-field-group">
                            <label class="auth-field-label" for="password">New Password</label>
                            <div class="auth-input-wrap">
                                <input type="password" name="password" id="password" placeholder="Min 8 characters"
                                    required minlength="8" autocomplete="new-password">
                                <i class="fal fa-lock"></i>
                            </div>
                        </div>

                        <div class="auth-field-group">
                            <label class="auth-field-label" for="password_confirmation">Confirm New Password</label>
                            <div class="auth-input-wrap">
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repeat new password"
                                    required minlength="8" autocomplete="new-password">
                                <i class="fal fa-shield-check"></i>
                            </div>
                        </div>

                        <button type="submit" class="auth-submit-btn">
                            <span>RESET PASSWORD</span>
                            <i class="fal fa-arrow-right"></i>
                        </button>

                        <p class="auth-footer-text">
                            Back to
                            <a href="{{ route('login') }}">Sign In</a>
                        </p>
                    </form>

                    <p class="auth-panel-foot">&copy; {{ date('Y') }} DoctorsInnElite. All rights reserved.</p>

                </div>
            </div>

        </div>
    </div>

@endsection
