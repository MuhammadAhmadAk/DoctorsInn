@extends('frontend.layouts.auth')
@section('title', 'Login | DoctorsInnElite')
@section('meta_description', 'Login to your DoctorsInnElite account to access your enrolled MDCAT courses, track your progress, and continue your medical entry test preparation.')
@section('meta_keywords', 'DoctorsInnElite login, student login, MDCAT course login, access my courses')
@section('content')

    <div class="auth-page-area overflow-hidden contact-area-1 position-relative z-index-common" id="login-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="contact-page-form-wrap">
                        <div class="contact-form contact-page-form">
                            @if (session('warning'))
                                <div class="alert alert-warning auth-alert auth-alert-warning d-flex align-items-center mb-4" role="alert">
                                    <i class="fa-solid fa-triangle-exclamation me-3 fs-4"></i>
                                    <div>{{ session('warning') }}</div>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger auth-alert d-flex align-items-center mb-4" role="alert">
                                    <i class="fa-solid fa-circle-exclamation me-3 fs-4"></i>
                                    <div>{{ session('error') }}</div>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success auth-alert d-flex align-items-center mb-4" role="alert">
                                    <i class="fa-solid fa-circle-check me-3 fs-4"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                            @endif

                            <form action="{{ route('login.submit') }}" method="POST" class="contact-form">
                                @csrf
                                <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                                <div class="auth-form-header text-center mb-4">
                                    <h3 class="auth-form-title">Student Login</h3>
                                    <p class="auth-form-desc">Login to access online mock tests, MCQs practice, and free study dashboard.</p>
                                </div>

                                {{-- Continue with Google Button --}}
                                <div class="mb-4">
                                    <a href="{{ route('auth.google', ['redirect' => request('redirect')]) }}" 
                                       class="btn w-100 d-flex align-items-center justify-content-center gap-2 py-3 px-4 rounded-3 text-decoration-none" 
                                       style="background: #ffffff; border: 1.5px solid #e2e8f0; color: #1e293b; font-weight: 600; font-size: 15px; box-shadow: 0 2px 6px rgba(0,0,0,0.04); transition: all 0.2s ease;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" class="flex-shrink-0">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                        </svg>
                                        <span>Continue with Google</span>
                                    </a>

                                    <div class="d-flex align-items-center my-3 text-muted" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">
                                        <hr class="flex-grow-1 my-0" style="border-color: #e2e8f0;">
                                        <span class="px-3" style="color: #94a3b8; font-weight: 600;">or login with email</span>
                                        <hr class="flex-grow-1 my-0" style="border-color: #e2e8f0;">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 form-group style-border3">
                                        <input type="email" name="email" id="email" placeholder="Your Email (e.g. student@doctorsinn.pk)"
                                            class="form-control" value="student@doctorsinn.pk" required>
                                        <i class="fal fa-envelope"></i>
                                    </div>
                                    <div class="col-12 form-group style-border3">
                                        <input type="password" name="password" id="password" placeholder="Your Password"
                                            class="form-control" value="12345678" required>
                                        <i class="fal fa-lock"></i>
                                    </div>
                                    <div
                                        class="form-group col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <div class="custom-checkbox">
                                            <input type="checkbox" id="rememberMe" name="remember" checked>
                                            <label for="rememberMe">Remember me</label>
                                        </div>
                                        <a href="{{ route('forgot-password') }}" class="text-theme">Forgot Password?</a>
                                    </div>
                                    <div class="form-btn col-12">
                                        <button type="submit" class="th-btn w-100">LOGIN & CONTINUE <svg class="ms-2" width="16"
                                                height="16" viewbox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_458_9379)">
                                                    <path
                                                        d="M14.0331 2.03512C12.5811 0.471411 1.65895 4.30197 1.66797 5.7005C1.6782 7.28644 5.93336 7.7743 7.11277 8.10524C7.82203 8.30417 8.01197 8.50817 8.1755 9.2519C8.91617 12.6202 9.28803 14.2955 10.1356 14.3329C11.4865 14.3926 15.4502 3.56117 14.0331 2.03512Z"
                                                        fill="transparent" stroke="currentColor" stroke-width="1.5">
                                                    </path>
                                                    <path d="M7.66797 8.33333L10.0013 6" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </g>
                                                <defs>
                                                    <clippath id="clip0_458_9379">
                                                        <rect width="16" height="16" fill="currentColor"></rect>
                                                    </clippath>
                                                </defs>
                                            </svg></button>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <p class="mb-0">Don't have an account? <a href="{{ route('register') }}"
                                                class="text-theme fw-semibold">Register Free</a></p>
                                    </div>
                                </div>
                                <p class="form-messages mb-0 mt-3"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
