<header class="student-navbar">
    <!-- Left: Mobile Toggle & Page Greeting -->
    <div class="d-flex align-items-center gap-3">
        <button type="button" class="btn btn-sm btn-light d-lg-none p-2 border" id="sidebarToggleBtn" aria-label="Toggle Sidebar">
            <i class="fa-solid fa-bars fs-6"></i>
        </button>

        <div class="d-none d-sm-block">
            <span class="text-muted fw-semibold" style="font-size: 13px;">Portal Session:</span>
            <span class="badge bg-success bg-opacity-10 text-success fw-bold ms-1" style="font-size: 11.5px;">Active Student</span>
        </div>
    </div>

    <!-- Center: MDCAT Countdown Pill -->
    <div class="d-none d-md-flex align-items-center">
        @php
            $examDate = \Carbon\Carbon::create(2026, 8, 25);
            $daysLeft = max(1, (int) now()->diffInDays($examDate, false));
        @endphp
        <div class="navbar-countdown-pill">
            <i class="fa-solid fa-hourglass-half text-warning"></i>
            <span>MDCAT 2026: <b>{{ $daysLeft }} Days Remaining</b></span>
        </div>
    </div>

    <!-- Right Controls -->
    <div class="d-flex align-items-center gap-3">
        <!-- WhatsApp Help Pill -->
        <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20am%20a%20student%20and%20need%20academic%20assistance." target="_blank" class="btn btn-sm btn-outline-success d-none d-sm-inline-flex align-items-center gap-2 py-1 px-3 rounded-pill fw-semibold" style="font-size: 12.5px;">
            <i class="fa-brands fa-whatsapp fs-6"></i>
            <span>Teacher Help</span>
        </a>

        <!-- Notifications -->
        <a href="{{ route('notifications') }}" class="btn btn-sm btn-light position-relative p-2 rounded-circle border" title="Notifications" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
            <i class="fa-regular fa-bell text-secondary"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
        </a>

        <!-- Profile Dropdown -->
        @php
            $user = auth()->user() ?? session('user');
            $studentName = $user['name'] ?? 'Student';
            $studentAvatar = $user['avatar'] ?? 'frontend/img/testimonial/testi_2_1.png';
        @endphp
        <div class="dropdown">
            <button class="navbar-user-btn dropdown-toggle" type="button" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset($studentAvatar) }}" alt="{{ $studentName }}" class="navbar-user-avatar">
                <span class="d-none d-md-inline fw-bold text-dark" style="font-size: 13.5px;">{{ Str::limit($studentName, 16) }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2" aria-labelledby="userMenuBtn" style="border-radius: 12px; min-width: 200px;">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-bold text-dark" style="font-size: 13.5px;">{{ $studentName }}</div>
                    <div class="text-muted text-xs">{{ $user['email'] ?? 'student@doctorsinn.pk' }}</div>
                </li>
                <li><a class="dropdown-item py-2 px-3 fw-semibold text-secondary" href="{{ route('student.dashboard') }}"><i class="fa-solid fa-chart-pie me-2"></i> Dashboard</a></li>
                <li><a class="dropdown-item py-2 px-3 fw-semibold text-secondary" href="{{ route('student.courses') }}"><i class="fa-solid fa-graduation-cap me-2"></i> My Courses</a></li>
                <li><a class="dropdown-item py-2 px-3 fw-semibold text-secondary" href="{{ route('student.tests') }}"><i class="fa-solid fa-list-check me-2"></i> Mock Tests</a></li>
                <li><a class="dropdown-item py-2 px-3 fw-semibold text-secondary" href="{{ route('student.settings') }}"><i class="fa-solid fa-user-gear me-2"></i> Account Settings</a></li>
                <li><hr class="dropdown-divider my-1"></li>
                <li><a class="dropdown-item py-2 px-3 fw-semibold text-danger" href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Sign Out</a></li>
            </ul>
        </div>
    </div>
</header>
