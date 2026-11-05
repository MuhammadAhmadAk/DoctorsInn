@extends('frontend.layouts.auth')
@section('title', 'Student Login | DoctorsInnElite')
@section('meta_description', 'Login to DoctorsInnElite student portal to access MDCAT mock tests, video lectures, and learning resources.')
@section('meta_keywords', 'DoctorsInn login, student login MDCAT, google sign in MDCAT')

@section('extra_css')
<style>
    body, html {
        overflow-x: hidden;
        background: #F6F6FE !important;
        font-family: "Plus Jakarta Sans", sans-serif;
    }
    .auth-compact-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 15px;
        background: #F6F6FE;
        background-image:
            radial-gradient(circle at 10% 20%, rgba(92, 50, 255, 0.05) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(239, 172, 6, 0.04) 0%, transparent 40%);
    }
    .auth-compact-card {
        width: 100%;
        max-width: 400px;
        background: #ffffff;
        border-radius: 16px;
        padding: 24px 26px;
        box-shadow: 0 10px 30px rgba(92, 50, 255, 0.08), 0 2px 8px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(92, 50, 255, 0.12);
    }
    .auth-brand-logo {
        height: 28px;
        width: auto;
        display: block;
        margin: 0 auto 12px auto;
        object-fit: contain;
    }
    .auth-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #050310;
        margin-bottom: 2px;
        text-align: center;
    }
    .auth-card-sub {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 16px;
        text-align: center;
    }
    .btn-google-auth {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        height: 42px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        color: #1e293b;
        font-weight: 600;
        font-size: 13.5px;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .btn-google-auth:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }
    .auth-divider {
        display: flex;
        align-items: center;
        margin: 14px 0 16px 0;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .auth-divider::before, .auth-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }
    .auth-divider span {
        padding: 0 10px;
    }
    .auth-field-group {
        margin-bottom: 12px;
        position: relative;
    }
    .auth-field-label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .auth-input-wrap {
        position: relative;
    }
    .auth-input-wrap input {
        width: 100%;
        height: 40px;
        padding: 0 38px 0 12px;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        font-size: 13.5px;
        color: #0f172a;
        background: #ffffff;
        transition: all 0.2s ease;
        outline: none;
    }
    .auth-input-wrap input:focus {
        border-color: #5C32FF;
        box-shadow: 0 0 0 3px rgba(92, 50, 255, 0.1);
    }
    .auth-input-wrap i {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }
    .auth-submit-btn {
        width: 100%;
        height: 42px;
        border-radius: 8px;
        background: #5C32FF;
        color: #ffffff;
        border: none;
        font-weight: 700;
        font-size: 13.5px;
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        margin-top: 14px;
    }
    .auth-submit-btn:hover {
        background: #4b26df;
    }
    .auth-footer-text {
        font-size: 13px;
        color: #64748b;
        text-align: center;
        margin-top: 14px;
        margin-bottom: 0;
    }
    .auth-footer-text a {
        color: #5C32FF;
        font-weight: 700;
        text-decoration: none;
    }
    .auth-footer-text a:hover {
        text-decoration: underline;
    }
    .auth-meta-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        margin-top: 2px;
        color: #64748b;
    }
    .auth-meta-row a {
        color: #5C32FF;
        font-weight: 600;
        text-decoration: none;
    }
    .auth-alert-box {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12.5px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>
@endsection

@section('content')

    <div class="auth-compact-wrapper">
        <div class="auth-compact-card">

            {{-- Brand Logo --}}
            <a href="{{ route('home') }}">
                <img src="{{ asset('frontend/img/logo/logo.svg') }}" alt="DoctorsInn" class="auth-brand-logo">
            </a>

            {{-- Title & Subtitle --}}
            <h1 class="auth-card-title">Student Login</h1>
            <p class="auth-card-sub">Sign in to access your MDCAT courses & tests.</p>

            {{-- Flash Alerts --}}
            @if (session('warning'))
                <div class="auth-alert-box alert-warning bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25">
                    <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="auth-alert-box alert-danger bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                    <i class="fa-solid fa-circle-exclamation text-danger"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="auth-alert-box alert-success bg-success bg-opacity-10 text-success border border-success border-opacity-25">
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
                        <input type="email" name="email" id="email" placeholder="student@doctorsinn.pk" value="{{ old('email', 'student@doctorsinn.pk') }}" required>
                        <i class="fal fa-envelope"></i>
                    </div>
                </div>

                {{-- Password Field --}}
                <div class="auth-field-group">
                    <label class="auth-field-label" for="password">Password</label>
                    <div class="auth-input-wrap">
                        <input type="password" name="password" id="password" placeholder="••••••••" value="12345678" required>
                        <i class="fal fa-lock"></i>
                    </div>
                </div>

                {{-- Meta Row --}}
                <div class="auth-meta-row">
                    <label class="d-flex align-items-center gap-1 mb-0 cursor-pointer">
                        <input type="checkbox" name="remember" checked style="accent-color: #5C32FF;">
                        <span>Remember me</span>
                    </label>
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

        </div>
    </div>

@endsection
