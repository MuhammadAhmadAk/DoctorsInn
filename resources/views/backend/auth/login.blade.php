<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Sign In — DoctorsInn Studio</title>

    <link rel="shortcut icon" href="{{ asset('frontend/img/logo/favicon.svg') }}" type="image/x-icon">

    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{ asset('frontend/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fonts.css') }}">

    <style>
        :root {
            --adm-bg: #080c16;
            --adm-card-bg: #0f172a;
            --adm-card-border: rgba(255, 255, 255, 0.08);
            --adm-input-bg: #141f36;
            --adm-input-border: #1e293b;
            --adm-primary: #0284c7;
            --adm-primary-hover: #0369a1;
            --adm-accent: #10b981;
            --adm-text: #f1f5f9;
            --adm-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--adm-bg);
            background-image:
                radial-gradient(circle at 15% 15%, rgba(14, 165, 233, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(16, 185, 129, 0.08) 0%, transparent 40%),
                linear-gradient(180deg, #070a12 0%, #0d1527 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            color: var(--adm-text);
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle grid background pattern */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
        }

        .auth-brand-wrap {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-brand-logo {
            height: 38px;
            width: auto;
            max-width: 180px;
            object-fit: contain;
            display: inline-block;
            margin-bottom: 12px;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 9999px;
            background: rgba(14, 165, 233, 0.12);
            color: #38bdf8;
            border: 1px solid rgba(14, 165, 233, 0.3);
        }

        .auth-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #38bdf8;
            box-shadow: 0 0 8px #38bdf8;
        }

        .auth-card {
            background: var(--adm-card-bg);
            border: 1px solid var(--adm-card-border);
            border-radius: 16px;
            padding: 32px 28px;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.7),
                0 0 0 1px rgba(255, 255, 255, 0.04);
            position: relative;
            backdrop-filter: blur(8px);
        }

        .auth-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 32px;
            right: 32px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #0284c7, #10b981, transparent);
        }

        .auth-card-title {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.3px;
            margin-bottom: 6px;
        }

        .auth-card-sub {
            font-size: 13px;
            color: var(--adm-muted);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Demo Credentials Pill */
        .demo-pill {
            background: rgba(2, 132, 199, 0.08);
            border: 1px dashed rgba(2, 132, 199, 0.3);
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
        }

        .demo-pill-info {
            color: #cbd5e1;
        }

        .demo-pill-info code {
            color: #38bdf8;
            background: rgba(14, 165, 233, 0.15);
            padding: 1px 6px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 11.5px;
        }

        .btn-autofill {
            background: #0284c7;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .btn-autofill:hover {
            background: #0369a1;
            transform: translateY(-1px);
        }

        /* Form Controls */
        .form-group-adm {
            margin-bottom: 18px;
        }

        .form-label-adm {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12.5px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 6px;
        }

        .input-wrap-adm {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 14px;
            color: #64748b;
            font-size: 14px;
            pointer-events: none;
            transition: color 0.15s;
        }

        .form-control-adm {
            width: 100%;
            background: var(--adm-input-bg);
            border: 1px solid var(--adm-input-border);
            border-radius: 8px;
            color: #ffffff;
            font-size: 13.5px;
            padding: 11px 40px 11px 38px;
            outline: none;
            transition: all 0.15s ease;
        }

        .form-control-adm:focus {
            background: #17243e;
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
        }

        .form-control-adm:focus ~ .input-icon-left {
            color: #38bdf8;
        }

        .btn-password-toggle {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 4px;
            font-size: 14px;
            transition: color 0.15s;
        }

        .btn-password-toggle:hover {
            color: #cbd5e1;
        }

        /* Checkbox & Options */
        .form-row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            font-size: 12.5px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-label input {
            accent-color: #0284c7;
            width: 14px;
            height: 14px;
            cursor: pointer;
        }

        .link-help {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 500;
        }

        .link-help:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit-adm {
            width: 100%;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 600;
            letter-spacing: 0.2px;
            padding: 12px 18px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
            transition: all 0.15s ease;
        }

        .btn-submit-adm:hover {
            background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.45);
        }

        .btn-submit-adm:active {
            transform: translateY(0);
        }

        /* Alerts */
        .adm-alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            margin-bottom: 18px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.4;
        }

        .adm-alert-danger {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .adm-alert-warning {
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fcd34d;
        }

        .adm-alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
        }

        /* Card Footer */
        .auth-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 12.5px;
        }

        .link-back {
            color: #94a3b8;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.15s;
        }

        .link-back:hover {
            color: #ffffff;
        }

        .auth-security-notice {
            margin-top: 14px;
            font-size: 11px;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
    </style>
</head>

<body>

    <div class="auth-container">
        <!-- Brand Header -->
        <div class="auth-brand-wrap">
            <a href="{{ route('home') }}" title="DoctorsInn Home">
                <img src="{{ asset('frontend/img/logo/logo-white.svg') }}?v={{ time() }}" alt="DoctorsInn" class="auth-brand-logo">
            </a>
            <div>
                <span class="auth-badge">
                    <span class="auth-badge-dot"></span>
                    Admin Console
                </span>
            </div>
        </div>

        <!-- Login Card -->
        <div class="auth-card">
            <h1 class="auth-card-title">Executive Sign In</h1>
            <p class="auth-card-sub">Authenticate to access DoctorsInn course studio, mock tests, and student records.</p>

            <!-- Alerts -->
            @if (session('error'))
                <div class="adm-alert adm-alert-danger">
                    <i class="fa-solid fa-circle-exclamation mt-1"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if (session('warning'))
                <div class="adm-alert adm-alert-warning">
                    <i class="fa-solid fa-triangle-exclamation mt-1"></i>
                    <div>{{ session('warning') }}</div>
                </div>
            @endif

            @if (session('success'))
                <div class="adm-alert adm-alert-success">
                    <i class="fa-solid fa-circle-check mt-1"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="adm-alert adm-alert-danger">
                    <i class="fa-solid fa-circle-exclamation mt-1"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <!-- Demo Quick Fill Pill -->
            <div class="demo-pill">
                <div class="demo-pill-info">
                    <i class="fa-solid fa-key me-1 text-primary"></i>
                    <strong>Demo:</strong> <code>admin@doctorsinn.pk</code> • <code>admin123</code>
                </div>
                <button type="button" class="btn-autofill" onclick="autoFillDemo()">
                    <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Auto-Fill
                </button>
            </div>

            <!-- Login Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" id="adminLoginForm">
                @csrf

                <!-- Email -->
                <div class="form-group-adm">
                    <label class="form-label-adm" for="adminEmail">
                        <span>Work Email</span>
                    </label>
                    <div class="input-wrap-adm">
                        <i class="fa-regular fa-envelope input-icon-left"></i>
                        <input type="email" id="adminEmail" name="email" class="form-control-adm"
                            placeholder="admin@doctorsinn.pk" value="{{ old('email', 'admin@doctorsinn.pk') }}" required autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group-adm">
                    <div class="form-label-adm">
                        <label for="adminPassword">Password</label>
                    </div>
                    <div class="input-wrap-adm">
                        <i class="fa-regular fa-lock input-icon-left"></i>
                        <input type="password" id="adminPassword" name="password" class="form-control-adm"
                            placeholder="••••••••" value="admin123" required>
                        <button type="button" class="btn-password-toggle" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
                            <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Help -->
                <div class="form-row-between">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" value="1" checked>
                        <span>Keep me signed in</span>
                    </label>
                    <span class="text-muted font-11">TLS 1.3 Active</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit-adm" id="submitBtn">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span id="btnText">Sign In to Dashboard</span>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="auth-footer">
            <a href="{{ route('home') }}" class="link-back">
                <i class="fa-solid fa-arrow-left font-11"></i>
                <span>Return to DoctorsInn Public Website</span>
            </a>

            <div class="auth-security-notice">
                <i class="fa-solid fa-shield-halved text-success"></i>
                <span>Protected Executive Management Gateway</span>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('adminPassword');
            const icon = document.getElementById('togglePasswordIcon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function autoFillDemo() {
            const emailInput = document.getElementById('adminEmail');
            const pwdInput = document.getElementById('adminPassword');
            emailInput.value = 'admin@doctorsinn.pk';
            pwdInput.value = 'admin123';
            emailInput.focus();
        }

        document.getElementById('adminLoginForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            btn.disabled = true;
            btnText.textContent = 'Verifying Credentials...';
        });
    </script>
</body>

</html>
