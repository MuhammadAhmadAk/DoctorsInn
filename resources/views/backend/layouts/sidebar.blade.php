<aside class="admin-sidebar">
    <!-- Brand Header with White Logo -->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center justify-content-between w-100 text-decoration-none">
            <img src="{{ asset('frontend/img/logo/logo-white.svg') }}?v={{ time() }}" alt="DoctorsInn" style="height: 30px; width: auto; max-width: 140px; object-fit: contain; display: block;">
            <span class="brand-badge">ADMIN</span>
        </a>
    </div>

    @php
        $navCoursesCount = count(\App\Services\SiteContentService::getAllCourses());
        $navTestsCount = count(\App\Services\SiteContentService::getAllTests());
        $navElibraryCount = count(\App\Services\SiteContentService::getAllResources());
        $navBlogsCount = count(\App\Services\SiteContentService::getAllBlogs());

        $adminSession = session('admin_user', []);
        $isAdminRole = ($adminSession['role_key'] ?? 'admin') === 'admin';
        $canAccess = fn (string $permission) => $isAdminRole
            || in_array($permission, (array) ($adminSession['permissions'] ?? []), true);
    @endphp

    <!-- Clean Minimal Navigation Menu -->
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if ($canAccess('cms'))
        <li class="sidebar-item">
            <a href="{{ route('admin.cms') }}" class="sidebar-link {{ request()->routeIs('admin.cms*') ? 'active' : '' }}">
                <i class="fa-solid fa-pen-ruler"></i>
                <span>Website CMS</span>
            </a>
        </li>
        @endif

        @if ($canAccess('courses'))
        <li class="sidebar-item">
            <a href="{{ route('admin.courses') }}" class="sidebar-link {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Courses</span>
                <span class="badge-count">{{ $navCoursesCount }}</span>
            </a>
        </li>
        @endif

        @if ($canAccess('tests'))
        <li class="sidebar-item">
            <a href="{{ route('admin.tests') }}" class="sidebar-link {{ request()->routeIs('admin.tests*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Mock Tests</span>
                <span class="badge-count">{{ $navTestsCount }}</span>
            </a>
        </li>
        @endif

        @if ($canAccess('library'))
        <li class="sidebar-item">
            <a href="{{ route('admin.elibrary') }}" class="sidebar-link {{ request()->routeIs('admin.elibrary*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-bookmark"></i>
                <span>E-Library</span>
                <span class="badge-count">{{ $navElibraryCount }}</span>
            </a>
        </li>
        @endif

        @if ($canAccess('blogs'))
        <li class="sidebar-item">
            <a href="{{ route('admin.blogs') }}" class="sidebar-link {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper"></i>
                <span>Blog Posts</span>
                <span class="badge-count">{{ $navBlogsCount }}</span>
            </a>
        </li>
        @endif

        @if ($canAccess('students'))
        <li class="sidebar-item">
            <a href="{{ route('admin.students') }}" class="sidebar-link {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Students</span>
            </a>
        </li>
        @endif

        @if ($canAccess('enrollments'))
        <li class="sidebar-item">
            <a href="{{ route('admin.enrollments') }}" class="sidebar-link {{ request()->routeIs('admin.enrollments*') ? 'active' : '' }}">
                <i class="fa-solid fa-credit-card"></i>
                <span>Enrollments</span>
            </a>
        </li>
        @endif

        @if ($canAccess('staff'))
        <li class="sidebar-item">
            <a href="{{ route('admin.staff') }}" class="sidebar-link {{ request()->routeIs('admin.staff*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-shield"></i>
                <span>Staff Access</span>
            </a>
        </li>
        @endif

        @if ($canAccess('settings'))
        <li class="sidebar-item mt-2 pt-2 border-top border-secondary border-opacity-10">
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i>
                <span>Settings</span>
            </a>
        </li>
        @endif

        <li class="sidebar-item">
            <a href="{{ route('admin.logout') }}" class="sidebar-link text-danger text-opacity-75">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Sign Out</span>
            </a>
        </li>
    </ul>

    <!-- Footer Action -->
    <div class="sidebar-footer">
        <a href="{{ route('home') }}" target="_blank" class="live-badge">
            <span class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-globe text-primary"></i>
                <span>Live Website</span>
            </span>
            <i class="fa-solid fa-arrow-up-right-from-square font-12 opacity-50"></i>
        </a>
    </div>
</aside>
