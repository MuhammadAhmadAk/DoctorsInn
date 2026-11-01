<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'DoctorsInn Admin Portal') — Elite Medical LMS</title>

    <link rel="shortcut icon" href="{{ asset('frontend/img/logo/favicon.svg') }}" type="image/x-icon">

    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{ asset('frontend/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/admin.css') }}?v={{ time() }}">

    <style>
        /* Force eliminate any Windows Chrome default scrollbars on sidebar */
        .admin-sidebar,
        .admin-sidebar *,
        .sidebar-menu {
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        .admin-sidebar::-webkit-scrollbar,
        .admin-sidebar *::-webkit-scrollbar,
        .sidebar-menu::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            background: transparent !important;
        }
    </style>

    @yield('extra_css')
</head>

<body>

    <div class="admin-wrapper">
        <!-- Sidebar Navigation -->
        @include('backend.layouts.sidebar')

        <!-- Main Content Area -->
        <div class="admin-main">
            <!-- Top Navbar -->
            @include('backend.layouts.navbar')

            <!-- Dynamic Content -->
            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('frontend/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('backend/js/admin.js') }}"></script>
    @yield('extra_js')
</body>

</html>
