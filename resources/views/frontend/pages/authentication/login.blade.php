@extends('frontend.layouts.auth')
@section('title', 'Student Login | DoctorsInnElite')
@section('meta_description', 'Login to your DoctorsInnElite account with email or 1-Click Google Sign-In to access MDCAT mock tests, video lectures, and learning resources.')
@section('meta_keywords', 'DoctorsInn login, student login MDCAT, google sign in MDCAT, DoctorsInnElite login')
@section('content')

    <div class="auth-page-area overflow-hidden contact-area-1 position-relative z-index-common" id="login-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="contact-page-form-wrap" style="background: #ffffff; border-radius: 20px; box-shadow: 0 10px 40px rgba(110, 86, 248, 0.08); border: 1px solid rgba(110, 86, 248, 0.12); padding: 35px 30px;">
                        <div class="contact-form contact-page-form">

                            {{-- Alert Messages --}}
                            @if (session('warning'))
                                <div class="alert alert-warning auth-alert auth-alert-warning d-flex align-items-center mb-3 py-2 px-3 rounded-3" role="alert" style="font-size: 13.5px; border-left: 4px solid #f59e0b;">
                                    <i class="fa-solid fa-triangle-exclamation me-2 fs-5 text-warning"></i>
                                    <div>{{ session('warning') }}</div>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger auth-alert d-flex align-items-center mb-3 py-2 px-3 rounded-3" role="alert" style="font-size: 13.5px; border-left: 4px solid #ef4444;">
                                    <i class="fa-solid fa-circle-exclamation me-2 fs-5 text-danger"></i>
                                    <div>{{ session('error') }}</div>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success auth-alert d-flex align-items-center mb-3 py-2 px-3 rounded-3" role="alert" style="font-size: 13.5px; border-left: 4px solid #10b981;">
                                    <i class="fa-solid fa-circle-check me-2 fs-5 text-success"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger auth-alert mb-3 py-2 px-3 rounded-3" style="font-size: 13px;">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Header --}}
                            <div class="auth-form-header text-center mb-4">
                                <h3 class="auth-form-title mb-1" style="font-weight: 700; color: #1e1b4b; font-size: 26px;">Student Login</h3>
                                <p class="auth-form-desc mb-0 text-muted" style="font-size: 14px;">Welcome back! Sign in to continue your MDCAT prep.</p>
                            </div>

                            {{-- Google Sign-In Button --}}
                            <div class="mb-3">
                                <a href="{{ route('auth.google', ['redirect' => request('redirect')]) }}" 
                                   class="btn w-100 d-flex align-items-center justify-content-center gap-2 py-2 px-3 rounded-3" 
                                   style="background: #ffffff; border: 1.5px solid #e2e8f0; color: #1e293b; font-weight: 600; font-size: 14.5px; transition: all 0.25s ease; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                                    <svg width="20" height="20" viewBox="0 0 24 24" class="flex-shrink-0">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                    </svg>
                                    <span>Continue with Google</span>
                                </a>
                            </div>

                            {{-- Divider --}}
                            <div class="d-flex align-items-center my-3 text-muted" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">
                                <hr class="flex-grow-1 my-0" style="border-color: #e2e8f0;">
                                <span class="px-3" style="color: #94a3b8; font-weight: 600;">or login with email</span>
                                <hr class="flex-grow-1 my-0" style="border-color: #e2e8f0;">
                            </div>

                            {{-- Email Form --}}
                            <form action="{{ route('login.submit') }}" method="POST" class="contact-form">
                                @csrf
                                <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="email" class="form-label fw-semibold text-dark mb-1" style="font-size: 13.5px;">Email Address <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="email" name="email" id="email" 
                                                   placeholder="student@doctorsinn.pk"
                                                   class="form-control rounded-3 ps-3 pe-5 py-2" 
                                                   style="border: 1.5px solid #e2e8f0; font-size: 14px;"
                                                   value="{{ old('email', 'student@doctorsinn.pk') }}" required>
                                            <i class="fa-solid fa-envelope position-absolute text-muted" style="right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label fw-semibold text-dark mb-1" style="font-size: 13.5px;">Password <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" name="password" id="password" 
                                                   placeholder="••••••••"
                                                   class="form-control rounded-3 ps-3 pe-5 py-2" 
                                                   style="border: 1.5px solid #e2e8f0; font-size: 14px;"
                                                   value="12345678" required>
                                            <i class="fa-solid fa-eye-slash position-absolute text-muted cursor-pointer" 
                                               id="togglePassBtn"
                                               style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"
                                               onclick="togglePasswordVisibility()"></i>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2 pt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" checked>
                                            <label class="form-check-label text-muted" for="rememberMe" style="font-size: 13.5px;">Remember me</label>
                                        </div>
                                        <a href="{{ route('forgot-password') }}" class="text-decoration-none" style="color: #6e56f8; font-size: 13px; font-weight: 600;">Forgot Password?</a>
                                    </div>

                                    <div class="col-12 pt-2">
                                        <button type="submit" class="th-btn w-100 py-2 rounded-3 text-white fw-bold d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #6e56f8 0%, #4f46e5 100%); border: none; font-size: 15px; letter-spacing: 0.5px;">
                                            <span>SIGN IN & CONTINUE</span>
                                            <i class="fa-solid fa-arrow-right fs-6"></i>
                                        </button>
                                    </div>

                                    <div class="col-12 text-center pt-2">
                                        <p class="mb-0 text-muted" style="font-size: 14px;">
                                            New to DoctorsInn? 
                                            <a href="{{ route('register', ['redirect' => request('redirect')]) }}" class="fw-bold text-decoration-none" style="color: #6e56f8;">
                                                Create Free Account
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')
<script>
function togglePasswordVisibility() {
    const passInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePassBtn');
    if (passInput.type === 'password') {
        passInput.type = 'text';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
        toggleIcon.classList.add('text-primary');
    } else {
        passInput.type = 'password';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.remove('text-primary');
        toggleIcon.classList.add('fa-eye-slash');
    }
}
</script>
@endsection
