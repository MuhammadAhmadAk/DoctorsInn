<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Login — DoctorsInn</title>

    <link rel="shortcut icon" href="{{ asset('frontend/img/logo/favicon.svg') }}" type="image/x-icon">

    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{ asset('frontend/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fonts.css') }}">

    <style>
        :root {
            --theme-color: #5C32FF;
            --theme-color-hover: #4b26df;
            --theme-bg: #F6F6FE;
            --title-color: #050310;
            --text-muted: #64748b;
            --border-color: rgba(92, 50, 255, 0.15);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow: hidden !important;
            font-family: "Plus Jakarta Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--theme-bg);
            background-image:
                radial-gradient(circle at 12% 18%, rgba(92, 50, 255, 0.07) 0%, transparent 40%),
                radial-gradient(circle at 88% 82%, rgba(239, 172, 6, 0.05) 0%, transparent 40%);
        }

        .login-wrapper {
            height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            background: #ffffff;
            border-radius: 14px;
            padding: 26px 24px;
            box-shadow: 0 10px 30px rgba(92, 50, 255, 0.08), 0 2px 6px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--border-color);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 18px;
        }

        .brand-logo {
            height: 32px;
            width: auto;
            max-width: 140px;
            object-fit: contain;
            display: inline-block;
            margin-bottom: 8px;
        }

        .badge-admin {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 4px;
            background: rgba(92, 50, 255, 0.08);
            color: var(--theme-color);
        }

        .login-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--title-color);
            margin-top: 6px;
            margin-bottom: 2px;
        }

        .login-sub {
            font-size: 12px;
            color: var(--text-muted);
        }

        .form-group-custom {
            margin-bottom: 13px;
            position: relative;
        }

        .form-label-custom {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 4px;
        }

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-box i.input-icon {
            position: absolute;
            left: 12px;
            font-size: 13px;
            color: #94a3b8;
            pointer-events: none;
        }

        .form-control-custom {
            width: 100%;
            height: 38px;
            padding: 6px 36px 6px 34px;
            font-size: 13px;
            color: #0f172a;
            background: #fbfbfe;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            transition: all 0.15s ease;
            outline: none;
        }

        .form-control-custom:focus {
            background: #ffffff;
            border-color: var(--theme-color);
            box-shadow: 0 0 0 3px rgba(92, 50, 255, 0.12);
        }

        .btn-eye {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            font-size: 13px;
        }

        .btn-eye:hover {
            color: var(--theme-color);
        }

        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11.5px;
            margin-bottom: 16px;
            color: var(--text-muted);
        }

        .options-row label {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            user-select: none;
        }

        .options-row input[type="checkbox"] {
            accent-color: var(--theme-color);
            width: 13px;
            height: 13px;
            cursor: pointer;
        }

        .demo-tag {
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            color: #475569;
            font-size: 11px;
            font-family: monospace;
        }

        .btn-theme-login {
            width: 100%;
            height: 40px;
            background: var(--theme-color);
            color: #ffffff;
            border: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s, transform 0.1s;
        }

        .btn-theme-login:hover {
            background: var(--theme-color-hover);
            transform: translateY(-1px);
        }

        .btn-theme-login:active {
            transform: translateY(0);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 13px;
            font-size: 11.5px;
            color: var(--text-muted);
            text-decoration: none;
        }

        .back-link:hover {
            color: var(--theme-color);
        }

        .alert-mini {
            padding: 7px 10px;
            border-radius: 6px;
            font-size: 11.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            line-height: 1.3;
        }

        .alert-mini-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-mini-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Brand Header -->
            <div class="brand-header">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('frontend/img/logo/logo.svg') }}" alt="DoctorsInn" class="brand-logo">
                </a>
                <div><span class="badge-admin">Admin Portal</span></div>
                <h1 class="login-title">Sign In</h1>
                <p class="login-sub">Enter credentials to manage courses & LMS</p>
            </div>

            <!-- Alerts -->
            @if (session('error'))
                <div class="alert-mini alert-mini-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if (session('success'))
                <div class="alert-mini alert-mini-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="form-group-custom">
                    <label class="form-label-custom" for="email">Email</label>
                    <div class="input-box">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-control-custom"
                            placeholder="admin@doctorsinn.pk" value="{{ old('email', 'admin@doctorsinn.pk') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom" for="password">Password</label>
                    <div class="input-box">
                        <i class="fa-regular fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-control-custom"
                            placeholder="••••••••" value="admin123" required>
                        <button type="button" class="btn-eye" onclick="togglePassword()" aria-label="Toggle password">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="options-row">
                    <label>
                        <input type="checkbox" name="remember" value="1" checked>
                        <span>Remember me</span>
                    </label>
                    <span class="demo-tag" title="Demo password">admin123</span>
                </div>

                <button type="submit" class="btn-theme-login">
                    <span>Sign In</span>
                    <i class="fa-solid fa-arrow-right font-11"></i>
                </button>
            </form>

            <a href="{{ route('home') }}" class="back-link">
                <i class="fa-solid fa-arrow-left font-10 me-1"></i> Return to Website
            </a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                pwd.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
