@extends('frontend.layouts.auth')
@section('title', 'Reset Password | DoctorsInnElite')
@section('meta_description', 'Set a new password for your DoctorsInnElite account and regain access to your MDCAT preparation courses.')
@section('meta_keywords', 'reset password DoctorsInnElite, new password, account recovery')
@section('content')

    <div class="auth-page-area overflow-hidden contact-area-1 position-relative z-index-common" id="reset-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="contact-page-form-wrap">
                        <div class="contact-form contact-page-form">
                            <form action="{{ route('login') }}" method="POST" class="contact-form">
                                <div class="auth-form-header text-center mb-4">
                                    <h3 class="auth-form-title">New Password</h3>
                                    <p class="auth-form-desc">Please set a new secure password for your account.</p>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group style-border3">
                                        <input type="password" name="password" id="password"
                                            placeholder="New Password" class="form-control" required minlength="6">
                                        <i class="fal fa-lock"></i>
                                    </div>
                                    <div class="col-12 form-group style-border3">
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            placeholder="Confirm New Password" class="form-control" required minlength="6">
                                        <i class="fal fa-lock"></i>
                                    </div>
                                    <div class="form-btn col-12">
                                        <button type="submit" class="th-btn w-100">RESET PASSWORD <svg class="ms-2"
                                                width="16" height="16" viewbox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_458_9379)">
                                                    <path
                                                        d="M14.0331 2.03512C12.5811 0.471411 1.65895 4.30197 1.66797 5.7005C1.6782 7.28644 5.93336 7.7743 7.11277 8.10524C7.82203 8.30417 8.01197 8.50817 8.1755 9.2519C8.91617 12.6202 9.28803 14.2955 10.1356 14.3329C11.4865 14.3926 15.4502 3.56117 14.0331 2.03512Z"
                                                        fill="transparent" stroke="currentColor" stroke-width="1.5">
                                                    </path>
                                                    <path d="M7.66797 8.33333L10.0013 6" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </g>
                                                <defs>
                                                    <clippath id="clip0_458_9379">
                                                        <rect width="16" height="16" fill="currentColor"></rect>
                                                    </clippath>
                                                </defs>
                                            </svg></button>
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