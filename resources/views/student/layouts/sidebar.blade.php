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
        $studentAvatar = is_array($user) ? ($user['avatar'] ?? 'student/img/icons/avatar.png') : ($user->avatar ?? 'student/img/icons/avatar.png');
        $targetExam = strtoupper(is_array($user) ? ($user['target_exam'] ?? 'MDCAT') : ($user->target_exam ?? 'MDCAT'));
        $coursesCount = count($courses ?? \App\Services\SiteContentService::getAllCourses());
        $testsCount = count(\App\Services\SiteContentService::getAllTests());
        $libraryCount = count(\App\Services\SiteContentService::getAllResources());
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
                <span class="nav-ic-wrap"><img src="{{ asset('student/img/icons/home.png') }}" class="nav-ic" alt="" width="20" height="20"></span>
                <span>Study Hub</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.courses') }}" class="sidebar-link {{ request()->routeIs('student.courses*') || request()->routeIs('student.classroom*') ? 'active' : '' }}">
                <span class="nav-ic-wrap"><img src="{{ asset('student/img/icons/courses.png') }}" class="nav-ic" alt="" width="20" height="20"></span>
                <span>Enroll Courses</span>
                <span class="badge-counter">{{ $coursesCount }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.tests') }}" class="sidebar-link {{ request()->routeIs('student.tests*') ? 'active' : '' }}">
                <span class="nav-ic-wrap"><img src="{{ asset('student/img/icons/mocks.png') }}" class="nav-ic" alt="" width="20" height="20"></span>
                <span>Practice &amp; Mocks</span>
                <span class="badge-counter">{{ $testsCount }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.elibrary') }}" class="sidebar-link {{ request()->routeIs('student.elibrary*') ? 'active' : '' }}">
                <span class="nav-ic-wrap"><img src="{{ asset('student/img/icons/library.png') }}" class="nav-ic" alt="" width="20" height="20"></span>
                <span>Notes &amp; E-Library</span>
                <span class="badge-counter">{{ $libraryCount }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.analytics') }}" class="sidebar-link {{ request()->routeIs('student.analytics*') ? 'active' : '' }}">
                <span class="nav-ic-wrap"><img src="{{ asset('student/img/icons/progress.png') }}" class="nav-ic" alt="" width="20" height="20"></span>
                <span>My Progress</span>
            </a>
        </li>

        <li class="menu-label">Account &amp; Help</li>

        <li>
            <a href="{{ route('student.settings') }}" class="sidebar-link {{ request()->routeIs('student.settings*') ? 'active' : '' }}">
                <span class="nav-ic-wrap"><img src="{{ asset('student/img/icons/profile.png') }}" class="nav-ic" alt="" width="20" height="20"></span>
                <span>Profile &amp; Settings</span>
            </a>
        </li>

        <li>
            <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20am%20a%20student%20and%20need%20academic%20assistance." target="_blank" class="sidebar-link">
                <span class="nav-ic-wrap"><img src="{{ asset('student/img/icons/whatsapp.png') }}" class="nav-ic" alt="" width="20" height="20"></span>
                <span>Ask a Mentor</span>
            </a>
        </li>

        <li>
            <a href="{{ route('home') }}" class="sidebar-link">
                <span class="nav-ic-wrap"><img src="{{ asset('student/img/icons/globe.png') }}" class="nav-ic" alt="" width="20" height="20"></span>
                <span>Back to Website</span>
            </a>
        </li>

        <li class="mt-auto pt-3" style="border-top: 1px solid var(--std-border-subtle);">
            <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                <span class="nav-ic-wrap"><img src="{{ asset('student/img/icons/logout.png') }}" class="nav-ic" alt="" width="20" height="20"></span>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>
