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
                            <form action="{{ route('profile') }}" method="POST" class="contact-form">
                                <div class="auth-form-header text-center mb-4">
                                    <h3 class="auth-form-title">Welcome Back</h3>
                                    <p class="auth-form-desc">Login to access your MDCAT course, mock tests, and study
                                        dashboard.</p>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group style-border3">
                                        <input type="email" name="email" id="email" placeholder="Your Email"
                                            class="form-control" required>
                                        <i class="fal fa-envelope"></i>
                                    </div>
                                    <div class="col-12 form-group style-border3">
                                        <input type="password" name="password" id="password" placeholder="Your Password"
                                            class="form-control" required>
                                        <i class="fal fa-lock"></i>
                                    </div>
                                    <div
                                        class="form-group col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <div class="custom-checkbox">
                                            <input type="checkbox" id="rememberMe" name="remember">
                                            <label for="rememberMe">Remember me</label>
                                        </div>
                                        <a href="{{ route('forgot-password') }}" class="text-theme">Forgot Password?</a>
                                    </div>
                                    <div class="form-btn col-12">
                                        <button type="submit" class="th-btn w-100">LOGIN <svg class="ms-2" width="16"
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
                                                class="text-theme fw-semibold">Register</a></p>
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
