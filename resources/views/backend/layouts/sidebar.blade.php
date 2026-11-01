<aside class="admin-sidebar">
    <!-- Brand Header with White Logo -->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center justify-content-between w-100 text-decoration-none">
            <img src="{{ asset('frontend/img/logo/logo-white.svg') }}?v={{ time() }}" alt="DoctorsInn" style="height: 30px; width: auto; max-width: 140px; object-fit: contain; display: block;">
            <span class="brand-badge">ADMIN</span>
        </a>
    </div>

    <!-- Clean Minimal Navigation Menu -->
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="{{ route('admin.courses') }}" class="sidebar-link {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Courses</span>
                <span class="badge-count">{{ count(config('courses', [])) }}</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="{{ route('admin.tests') }}" class="sidebar-link {{ request()->routeIs('admin.tests*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Mock Tests</span>
                <span class="badge-count">{{ count(config('tests.tests', [])) }}</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="{{ route('admin.elibrary') }}" class="sidebar-link {{ request()->routeIs('admin.elibrary*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-bookmark"></i>
                <span>E-Library</span>
                <span class="badge-count">{{ count(config('elibrary.resources', [])) }}</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="{{ route('admin.blogs') }}" class="sidebar-link {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper"></i>
                <span>Blog Posts</span>
                <span class="badge-count">{{ count(config('blogs', [])) }}</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="{{ route('admin.students') }}" class="sidebar-link {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Students</span>
            </a>
        </li>

        <li class="sidebar-item mt-2 pt-2 border-top border-secondary border-opacity-10">
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i>
                <span>Settings</span>
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
