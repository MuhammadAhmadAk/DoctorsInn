@php
    $navbarStreak = 0;
    $navbarUnread = 0;
    $navbarUser = auth()->user();
    if ($navbarUser) {
        try {
            $navbarMetrics = app(\App\Services\StudentMetricsService::class);
            $navbarStreak = $navbarMetrics->stats($navbarUser->id)['study_streak_days'];
            $navbarUnread = $navbarMetrics->unreadNotifications($navbarUser->id);
        } catch (\Throwable $e) {
            $navbarStreak = 0;
            $navbarUnread = 0;
        }
    }
@endphp
<header class="student-navbar">
    <!-- Left: Mobile Toggle & Study Streak -->
    <div class="d-flex align-items-center gap-3">
        <button type="button" class="btn btn-sm btn-light d-lg-none p-2 border rounded-3" id="sidebarToggleBtn" aria-label="Toggle Sidebar">
            <img src="{{ asset('student/img/icons/menu.png') }}" alt="" width="16" height="16" style="display: block; object-fit: contain;">
        </button>

        <div class="d-none d-sm-flex align-items-center gap-2">
            <span class="navbar-streak-pill">
                <img src="{{ asset('student/img/icons/fire.png') }}" class="pill-ic" alt="" width="15" height="15">
                <span>{{ $navbarStreak }}-Day Study Streak</span>
            </span>
        </div>
    </div>

    <!-- Center: MDCAT Countdown Pill -->
    <div class="d-none d-md-flex align-items-center">
        @php
            $examDate = \Carbon\Carbon::create(2026, 8, 25);
            $daysLeft = max(1, (int) now()->diffInDays($examDate, false));
        @endphp
        <div class="navbar-countdown-pill">
            <img src="{{ asset('student/img/icons/calendar.png') }}" class="pill-ic" alt="" width="15" height="15">
            <span>MDCAT 2026: <b>{{ $daysLeft }} Days Left</b></span>
        </div>
    </div>

    <!-- Right Controls -->
    <div class="d-flex align-items-center gap-2 gap-sm-3">
        <!-- Quick Resume Classroom Button -->
        <a href="{{ route('student.classroom', 'mdcat-reboot-60-day') }}" class="btn btn-sm btn-primary d-none d-xl-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill fw-semibold" style="font-size: 12.5px;">
            <img src="{{ asset('student/img/icons/play-w.png') }}" class="pill-ic" alt="" width="13" height="13">
            <span>Resume Study</span>
        </a>

        <!-- Notifications -->
        <a href="{{ route('notifications') }}" class="btn btn-sm position-relative rounded-circle border bg-white" title="Notifications" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-color: var(--std-border) !important;">
            <img src="{{ asset('student/img/icons/bell.png') }}" alt="" width="17" height="17" style="display: block; object-fit: contain;">
            @if ($navbarUnread > 0)
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
            @endif
        </a>

        <!-- Profile Dropdown -->
        @php
            $user = auth()->user() ?? session('user');
            $studentName = is_array($user) ? ($user['name'] ?? 'Student') : ($user->name ?? 'Student');
            $studentEmail = is_array($user) ? ($user['email'] ?? 'student@doctorsinn.pk') : ($user->email ?? 'student@doctorsinn.pk');
            $studentAvatar = is_array($user) ? ($user['avatar'] ?? 'frontend/img/testimonial/testi_2_1.png') : ($user->avatar ?? 'frontend/img/testimonial/testi_2_1.png');
        @endphp
        <div class="dropdown">
            <button class="navbar-user-btn dropdown-toggle" type="button" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset($studentAvatar) }}" alt="{{ $studentName }}" class="navbar-user-avatar">
                <span class="d-none d-md-inline fw-bold text-dark" style="font-size: 13px;">{{ Str::limit($studentName, 16) }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border py-2" aria-labelledby="userMenuBtn" style="border-radius: 14px; min-width: 215px; border-color: var(--std-border) !important;">
                <li class="px-3 py-2 border-bottom" style="border-color: var(--std-border-subtle) !important;">
                    <div class="fw-bold text-dark" style="font-size: 13.5px;">{{ $studentName }}</div>
                    <div class="text-muted text-xs" style="font-size: 11.5px;">{{ $studentEmail }}</div>
                </li>
                <li><a class="dropdown-item py-2 px-3 fw-semibold text-secondary" style="font-size: 13px;" href="{{ route('student.dashboard') }}"><img src="{{ asset('student/img/icons/home.png') }}" class="pill-ic me-2" alt="" width="15" height="15"> Study Hub</a></li>
                <li><a class="dropdown-item py-2 px-3 fw-semibold text-secondary" style="font-size: 13px;" href="{{ route('student.settings') }}"><img src="{{ asset('student/img/icons/profile.png') }}" class="pill-ic me-2" alt="" width="15" height="15"> Profile &amp; Settings</a></li>
                <li><a class="dropdown-item py-2 px-3 fw-semibold text-secondary" style="font-size: 13px;" href="{{ route('home') }}"><img src="{{ asset('student/img/icons/globe.png') }}" class="pill-ic me-2" alt="" width="15" height="15"> Main Website</a></li>
                <li><hr class="dropdown-divider my-1"></li>
                <li><a class="dropdown-item py-2 px-3 fw-semibold text-danger" style="font-size: 13px;" href="{{ route('logout') }}"><img src="{{ asset('student/img/icons/logout.png') }}" class="pill-ic me-2" alt="" width="15" height="15"> Logout</a></li>
            </ul>
        </div>
    </div>
</header>
