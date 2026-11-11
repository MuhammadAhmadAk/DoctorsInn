<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Student LMS Portal') — DoctorsInn Elite</title>

    <link rel="shortcut icon" href="{{ asset('frontend/img/logo/favicon.svg') }}" type="image/x-icon">

    <!-- CSS Assets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{ asset('frontend/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('student/css/student-portal.css') }}?v={{ time() }}">

    @yield('extra_css')
</head>

<body>

    <div class="student-wrapper">
        <!-- Mobile Sidebar Backdrop -->
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <!-- Sidebar Navigation -->
        @include('student.layouts.sidebar')

        <!-- Main Content Area -->
        <div class="student-main">
            <!-- Top Navbar -->
            @include('student.layouts.navbar')

            <!-- Dynamic Page Content -->
            <main class="student-content">
                {{-- Flash Notifications --}}
                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center mb-4 py-2 px-3 rounded-3" role="alert" style="font-size: 13.5px; border-left: 4px solid #10b981;">
                        <i class="fa-solid fa-circle-check me-2 fs-5 text-success"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning d-flex align-items-center mb-4 py-2 px-3 rounded-3" role="alert" style="font-size: 13.5px; border-left: 4px solid #f59e0b;">
                        <i class="fa-solid fa-triangle-exclamation me-2 fs-5 text-warning"></i>
                        <div>{{ session('warning') }}</div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('frontend/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('studentSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    if (backdrop) backdrop.classList.toggle('show');
                });
            }
            if (backdrop && sidebar) {
                backdrop.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                });
            }
        });
    </script>
    @yield('extra_js')
</body>

</html>
