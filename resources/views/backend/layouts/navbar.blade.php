<header class="admin-navbar">
    <div class="d-flex align-items-center gap-3">
        <button class="sidebar-toggle-btn" aria-label="Toggle Navigation">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="nav-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search courses, test series, or students... (Ctrl + /)">
        </div>
    </div>

    <div class="navbar-actions">
        <!-- Quick Action Button -->
        <a href="{{ route('admin.courses') }}" class="btn-adm btn-adm-primary d-none d-sm-inline-flex">
            <i class="fa-solid fa-plus"></i>
            <span>Add Course</span>
        </a>

        <!-- Notifications -->
        <a href="#" class="nav-btn-icon" title="Notifications">
            <i class="fa-regular fa-bell"></i>
            <span class="indicator"></span>
        </a>

        <!-- Admin Profile Dropdown -->
        <div class="dropdown">
            <button class="admin-profile-pill border-0 bg-transparent p-1" type="button" id="adminProfileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset(session('admin_user.avatar', 'frontend/img/team/team_2_1.jpg')) }}" alt="Admin Avatar">
                <div class="profile-meta d-none d-md-block text-start">
                    <div class="name">{{ session('admin_user.name', 'Dr. M. Ahmad') }}</div>
                    <div class="role">{{ session('admin_user.role', 'Chief Administrator') }}</div>
                </div>
                <i class="fa-solid fa-chevron-down font-10 text-muted ms-1"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border mt-2 py-2" aria-labelledby="adminProfileMenu" style="min-width: 200px; border-radius: 10px; font-size: 13px;">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-semibold text-dark">{{ session('admin_user.name', 'Dr. M. Ahmad') }}</div>
                    <div class="text-muted font-11">{{ session('admin_user.email', 'admin@doctorsinn.pk') }}</div>
                </li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('admin.settings') }}">
                        <i class="fa-solid fa-sliders text-muted font-12" style="width: 16px;"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('home') }}" target="_blank">
                        <i class="fa-solid fa-globe text-muted font-12" style="width: 16px;"></i>
                        <span>Live Website</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <a class="dropdown-item py-2 text-danger d-flex align-items-center gap-2" href="{{ route('admin.logout') }}">
                        <i class="fa-solid fa-arrow-right-from-bracket font-12" style="width: 16px;"></i>
                        <span>Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
