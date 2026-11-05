@extends('frontend.layouts.auth')
@section('title', 'Student Registration | DoctorsInnElite')
@section('meta_description', 'Create your free DoctorsInnElite student account to start preparing for MDCAT, NUMS, and AMC entrance tests.')
@section('meta_keywords', 'DoctorsInn register, student sign up MDCAT, google register MDCAT')

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
        max-width: 480px;
        background: #ffffff;
        border-radius: 16px;
        padding: 24px 28px;
        box-shadow: 0 10px 30px rgba(92, 50, 255, 0.08), 0 2px 8px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(92, 50, 255, 0.12);
    }
    .auth-brand-logo, img.auth-brand-logo {
        height: 26px !important;
        max-height: 26px !important;
        width: auto !important;
        max-width: 130px !important;
        display: block !important;
        margin: 0 auto 8px auto !important;
        object-fit: contain !important;
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
        margin-bottom: 14px;
        text-align: center;
    }
    .btn-google-auth {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        height: 40px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
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
        margin: 12px 0 14px 0;
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
        margin-bottom: 10px;
        position: relative;
    }
    .auth-field-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 3px;
    }
    .auth-input-wrap {
        position: relative;
    }
    .auth-input-wrap input {
        width: 100%;
        height: 38px;
        padding: 0 34px 0 11px;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        font-size: 13px;
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
        right: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
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
        margin-top: 12px;
    }
    .auth-submit-btn:hover {
        background: #4b26df;
    }
    .auth-footer-text {
        font-size: 12.5px;
        color: #64748b;
        text-align: center;
        margin-top: 12px;
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
    .auth-alert-box {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        margin-bottom: 10px;
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
            <a href="{{ route('home') }}" class="d-block text-center mb-2 text-decoration-none">
                <img src="{{ asset('frontend/img/logo/logo.svg') }}" alt="DoctorsInn" class="auth-brand-logo" style="height: 26px !important; max-height: 26px !important; width: auto !important; max-width: 130px !important; display: inline-block !important; margin: 0 auto !important; object-fit: contain !important;">
            </a>

            {{-- Title & Subtitle --}}
            <h1 class="auth-card-title">Create Free Account</h1>
            <p class="auth-card-sub">Start your MDCAT 2026 preparation journey.</p>

            {{-- Flash & Error Alerts --}}
            @if (session('error'))
                <div class="auth-alert-box alert-danger bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                    <i class="fa-solid fa-circle-exclamation text-danger"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-alert-box alert-danger bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
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
                    <div class="col-6 auth-field-group">
                        <label class="auth-field-label" for="firstname">First Name</label>
                        <div class="auth-input-wrap">
                            <input type="text" name="firstname" id="firstname" placeholder="First Name" value="{{ old('firstname') }}" required>
                            <i class="fal fa-user"></i>
                        </div>
                    </div>
                    <div class="col-6 auth-field-group">
                        <label class="auth-field-label" for="lastname">Last Name</label>
                        <div class="auth-input-wrap">
                            <input type="text" name="lastname" id="lastname" placeholder="Last Name" value="{{ old('lastname') }}" required>
                            <i class="fal fa-user"></i>
                        </div>
                    </div>
                </div>

                {{-- Row 2: Email & Phone Number --}}
                <div class="row g-2">
                    <div class="col-6 auth-field-group">
                        <label class="auth-field-label" for="email">Email Address</label>
                        <div class="auth-input-wrap">
                            <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
                            <i class="fal fa-envelope"></i>
                        </div>
                    </div>
                    <div class="col-6 auth-field-group">
                        <label class="auth-field-label" for="phone">WhatsApp / Phone</label>
                        <div class="auth-input-wrap">
                            <input type="text" name="phone" id="phone" placeholder="0300 1234567" value="{{ old('phone') }}" required>
                            <i class="fal fa-phone-alt"></i>
                        </div>
                    </div>
                </div>

                {{-- Row 3: Password & Confirm Password --}}
                <div class="row g-2">
                    <div class="col-6 auth-field-group">
                        <label class="auth-field-label" for="password">Password</label>
                        <div class="auth-input-wrap">
                            <input type="password" name="password" id="password" placeholder="Min 6 chars" required>
                            <i class="fal fa-lock"></i>
                        </div>
                    </div>
                    <div class="col-6 auth-field-group">
                        <label class="auth-field-label" for="confirm_password">Confirm Password</label>
                        <div class="auth-input-wrap">
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="Repeat pass" required>
                            <i class="fal fa-shield-halved"></i>
                        </div>
                    </div>
                </div>

                {{-- Terms Checkbox --}}
                <div class="d-flex align-items-center gap-1 mt-1 mb-2" style="font-size: 11.5px; color: #64748b;">
                    <input type="checkbox" name="privacy" id="privacy" checked required style="accent-color: #5C32FF;">
                    <label for="privacy" class="mb-0 cursor-pointer">
                        I agree to the <a href="{{ route('privacy-policy') }}" target="_blank" style="color: #5C32FF; font-weight: 600; text-decoration: none;">Privacy Policy</a> &amp; <a href="{{ route('terms-conditions') }}" target="_blank" style="color: #5C32FF; font-weight: 600; text-decoration: none;">Terms</a>
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

        </div>
    </div>

@endsection
