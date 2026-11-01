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

        <!-- Admin Profile -->
        <div class="admin-profile-pill">
            <img src="{{ asset('frontend/img/team/team_2_1.jpg') }}" alt="Admin Avatar">
            <div class="profile-meta d-none d-md-block text-start">
                <div class="name">Dr. M. Ahmad</div>
                <div class="role">Chief Administrator</div>
            </div>
            <i class="fa-solid fa-chevron-down font-10 text-muted ms-1"></i>
        </div>
    </div>
</header>
