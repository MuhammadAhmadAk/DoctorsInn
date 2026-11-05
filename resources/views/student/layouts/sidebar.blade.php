<aside class="student-sidebar" id="studentSidebar">
    <!-- Brand Header -->
    <div class="sidebar-brand">
        <a href="{{ route('student.dashboard') }}" class="d-flex align-items-center justify-content-between w-100 text-decoration-none">
            <img src="{{ asset('frontend/img/logo/logo-white.svg') }}" alt="DoctorsInn" style="height: 26px; width: auto; max-width: 130px; object-fit: contain; display: block;">
            <span class="brand-badge">LMS PORTAL</span>
        </a>
    </div>

    @php
        $user = auth()->user() ?? session('user');
        $studentName = $user['name'] ?? 'MDCAT Aspirant';
        $studentAvatar = $user['avatar'] ?? 'frontend/img/testimonial/testi_2_1.png';
        $targetExam = strtoupper($user['target_exam'] ?? 'MDCAT');
        $coursesCount = count(config('courses', []));
        $testsCount = count(config('tests.tests', []));
        $libraryCount = count(config('elibrary.resources', []));
    @endphp

    <!-- Student Mini Profile Card -->
    <div class="sidebar-profile-card">
        <img src="{{ asset($studentAvatar) }}" alt="{{ $studentName }}">
        <div class="overflow-hidden">
            <div class="sidebar-profile-name" title="{{ $studentName }}">{{ $studentName }}</div>
            <div class="sidebar-profile-exam">🎯 {{ $targetExam }} 2026 Batch</div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <ul class="sidebar-menu">
        <li class="menu-label">Main Menu</li>

        <li>
            <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.courses') }}" class="sidebar-link {{ request()->routeIs('student.courses*') || request()->routeIs('student.classroom*') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>My Courses</span>
                <span class="badge-counter">{{ $coursesCount }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.tests') }}" class="sidebar-link {{ request()->routeIs('student.tests*') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i>
                <span>Mock Tests</span>
                <span class="badge-counter">{{ $testsCount }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.elibrary') }}" class="sidebar-link {{ request()->routeIs('student.elibrary*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-bookmark"></i>
                <span>E-Library Vault</span>
                <span class="badge-counter">{{ $libraryCount }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.analytics') }}" class="sidebar-link {{ request()->routeIs('student.analytics*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Performance</span>
            </a>
        </li>

        <li class="menu-label">Account &amp; Support</li>

        <li>
            <a href="{{ route('student.settings') }}" class="sidebar-link {{ request()->routeIs('student.settings*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Profile &amp; Settings</span>
            </a>
        </li>

        <li>
            <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20am%20a%20student%20and%20need%20academic%20assistance." target="_blank" class="sidebar-link text-success">
                <i class="fa-brands fa-whatsapp"></i>
                <span>Academic Support</span>
            </a>
        </li>

        <li>
            <a href="{{ route('home') }}" class="sidebar-link text-muted">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Visit Main Site</span>
            </a>
        </li>

        <li class="mt-auto pt-3 border-top border-secondary border-opacity-10">
            <a href="{{ route('logout') }}" class="sidebar-link text-danger text-opacity-75">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Sign Out</span>
            </a>
        </li>
    </ul>
</aside>
