<aside class="student-sidebar" id="studentSidebar">
    <!-- Brand Header (Full Color Student Identity) -->
    <div class="sidebar-brand">
        <a href="{{ route('student.dashboard') }}" class="d-flex align-items-center justify-content-between w-100 text-decoration-none">
            <img src="{{ asset('frontend/img/logo/logo.svg') }}" alt="DoctorsInn" style="height: 26px; width: auto; max-width: 130px; object-fit: contain; display: block;">
            <span class="brand-badge">Study Hub</span>
        </a>
    </div>

    @php
        $user = auth()->user() ?? session('user');
        $studentName = is_array($user) ? ($user['name'] ?? 'MDCAT Aspirant') : ($user->name ?? 'MDCAT Aspirant');
        $studentAvatar = is_array($user) ? ($user['avatar'] ?? 'frontend/img/testimonial/testi_2_1.png') : ($user->avatar ?? 'frontend/img/testimonial/testi_2_1.png');
        $targetExam = strtoupper(is_array($user) ? ($user['target_exam'] ?? 'MDCAT') : ($user->target_exam ?? 'MDCAT'));
        $coursesCount = count($courses ?? \App\Services\SiteContentService::getAllCourses());
        $testsCount = count(config('tests.tests', []));
        $libraryCount = count(config('elibrary.resources', []));
    @endphp

    <!-- Student Study Card -->
    <div class="sidebar-profile-card">
        <img src="{{ asset($studentAvatar) }}" alt="{{ $studentName }}">
        <div class="overflow-hidden">
            <div class="sidebar-profile-name" title="{{ $studentName }}">{{ $studentName }}</div>
            <div class="sidebar-profile-exam">🎯 {{ $targetExam }} 2026 Aspirant</div>
        </div>
    </div>

    <!-- Learning Navigation Menu -->
    <ul class="sidebar-menu">
        <li class="menu-label">My Learning</li>

        <li>
            <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house-chimney"></i>
                <span>Study Hub</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.courses') }}" class="sidebar-link {{ request()->routeIs('student.courses*') || request()->routeIs('student.classroom*') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-play"></i>
                <span>Video Lectures</span>
                <span class="badge-counter">{{ $coursesCount }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.tests') }}" class="sidebar-link {{ request()->routeIs('student.tests*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pen"></i>
                <span>Practice &amp; Mocks</span>
                <span class="badge-counter">{{ $testsCount }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.elibrary') }}" class="sidebar-link {{ request()->routeIs('student.elibrary*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open"></i>
                <span>Notes &amp; E-Library</span>
                <span class="badge-counter">{{ $libraryCount }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.analytics') }}" class="sidebar-link {{ request()->routeIs('student.analytics*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-simple"></i>
                <span>My Progress</span>
            </a>
        </li>

        <li class="menu-label">Account &amp; Help</li>

        <li>
            <a href="{{ route('student.settings') }}" class="sidebar-link {{ request()->routeIs('student.settings*') ? 'active' : '' }}">
                <i class="fa-regular fa-circle-user"></i>
                <span>Profile &amp; Settings</span>
            </a>
        </li>

        <li>
            <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20am%20a%20student%20and%20need%20academic%20assistance." target="_blank" class="sidebar-link" style="color: #059669;">
                <i class="fa-brands fa-whatsapp" style="color: #10B981;"></i>
                <span>Ask a Mentor</span>
            </a>
        </li>

        <li>
            <a href="{{ route('home') }}" class="sidebar-link">
                <i class="fa-solid fa-globe"></i>
                <span>Back to Website</span>
            </a>
        </li>

        <li class="mt-auto pt-3" style="border-top: 1px solid var(--std-border-subtle);">
            <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                <i class="fa-solid fa-arrow-right-from-bracket text-danger"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>
