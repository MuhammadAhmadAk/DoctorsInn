@extends('frontend.layouts.main')
@section('title', 'My Profile | DoctorsInnElite')
@section('meta_description', 'Manage your DoctorsInnElite student profile. Update your personal information, change password, and track your MDCAT preparation progress.')
@section('meta_keywords', 'DoctorsInnElite profile, student profile, account settings, update profile')
@section('content')


    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">My Profile</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>My Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Area -->
    <section class="space-top space-bottom overflow-hidden bg-color" id="profile-section">
        <div class="container">
            <div class="row gy-40">

                <!-- Left Panel: User Information -->
                <div class="col-xl-4 col-lg-5">
                    <div class="profile-container-card text-center">
                        <div class="avatar-upload-wrapper">
                            <img src="{{ asset('frontend/img/normal/faq_1_2.jpg') }}" alt="Profile Picture"
                                id="profileImage">
                            <label for="imageUpload" class="avatar-edit-btn" title="Change Profile Picture">
                                <i class="fal fa-camera"></i>
                            </label>
                            <input type="file" id="imageUpload" accept="image/*" class="hidden-file-input">
                        </div>
                        <h2 class="student-name">Ahmed Khan</h2>
                        <p class="student-email">ahmed.khan@email.com</p>
                        <!-- <span class="status-badge">Active Student</span> -->

                        <div class="student-stats-row">
                            <div class="stat-item">
                                <div class="stat-val">{{ count($courses) }}</div>
                                <div class="stat-lbl">Courses</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-val">5</div>
                                <div class="stat-lbl">Enrolled</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-val">100%</div>
                                <div class="stat-lbl">Active</div>
                            </div>
                        </div>

                        <div class="member-since-box">
                            <span>Member Since</span>
                            <strong>October 2025</strong>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Navigation Tabs & Forms -->
                <div class="col-xl-8 col-lg-7">
                    <div class="profile-container-card">

                        <!-- Tabs Navigation -->
                        <nav class="profile-nav-tabs" role="tablist">
                            <button class="nav-link active" id="tab-my-courses" data-profile-tab="my-courses">
                                <i class="fal fa-graduation-cap me-2"></i>My Courses
                            </button>
                            <button class="nav-link" id="tab-personal-info" data-profile-tab="personal-info">
                                <i class="fal fa-user-cog me-2"></i>Personal Info
                            </button>
                            <button class="nav-link" id="tab-change-password" data-profile-tab="change-password">
                                <i class="fal fa-lock-keyhole me-2"></i>Change Password
                            </button>
                            <button class="nav-link" id="tab-payment-history" data-profile-tab="payment-history">
                                <i class="fal fa-file-invoice-dollar me-2"></i>Payment History
                            </button>
                        </nav>

                        <!-- Tab Contents -->
                        <div class="profile-tab-content">

                            <!-- Tab: My Enrolled Courses -->
                            <div class="tab-pane-content active" id="pane-my-courses">
                                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                                    <div>
                                        <h3 class="profile-form-heading mb-1">My Enrolled Courses</h3>
                                        <p class="text-muted text-sm mb-0">Select a course to resume your lessons, notes,
                                            and mock tests.</p>
                                    </div>
                                    <span class="badge bg-primary text-white px-3 py-2 radius-4"><i
                                            class="fal fa-shield-check me-1"></i> {{ count($courses) }} Enrolled</span>
                                </div>

                                <div class="row g-3">
                                    @foreach ($courses as $c)
                                        <div class="col-md-6 col-12">
                                            <div class="card border rounded-3 p-3 h-100 shadow-sm legacy-inline-9adb5d62cb"
                                               >
                                                <div class="d-flex gap-3 align-items-end mb-3">
                                                    <img src="{{ asset($c['image']) }}" alt="{{ $c['title'] }}"
                                                        class="rounded-3 legacy-inline-c39ed86628"
                                                       >
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <span
                                                            class="badge bg-success-subtle text-xs px-2 py-1 radius-4 font-semibold mb-1">Active
                                                            Enrollment</span>
                                                        <h5 class="text-sm fw-bold text-title mb-1 text-truncate legacy-inline-40138cfd60"
                                                            title="{{ $c['title'] }}">
                                                            {{ $c['title'] }}</h5>
                                                        <span class="text-xs text-muted"><i
                                                                class="fal fa-book-open me-1 text-primary"></i>{{ $c['lessons'] }}
                                                            &bull; <i
                                                                class="fal fa-clock me-1 text-primary"></i>{{ $c['duration'] }}</span>
                                                    </div>
                                                </div>

                                                <!-- Dynamic Course Progress -->
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between text-xs mb-1">
                                                        <span class="text-muted">Learning Progress</span>
                                                        <span class="fw-bold text-theme-color"
                                                            id="course-prog-txt-{{ $c['slug'] }}">In Progress</span>
                                                    </div>
                                                    <div class="progress legacy-inline-ba6efd825c"
                                                       >
                                                        <div class="progress-bar rounded-pill legacy-inline-9cdad43877"
                                                            id="course-prog-bar-{{ $c['slug'] }}" role="progressbar"
                                                           >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    class="mt-auto pt-2 border-top d-flex align-items-center justify-content-between">
                                                    <span class="text-xs text-muted">By
                                                        <strong>{{ $c['instructor'] }}</strong></span>
                                                    <a href="{{ route('my-courses', ['course' => $c['slug']]) }}"
                                                        class="th-btn btn-sm py-2 px-3 text-white profile-study-btn">
                                                        <i class="fa-regular fa-book-open me-1"></i> STUDY NOW
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tab 1: Personal Info -->
                            <div class="tab-pane-content" id="pane-personal-info">
                                <h3 class="profile-form-heading">Personal Information</h3>
                                <form id="personalInfoForm" data-success-message="Personal Information updated successfully!">
                                    <div class="row">
                                        <div class="col-md-6 custom-form-group">
                                            <label for="firstName">First Name</label>
                                            <input type="text" id="firstName" class="custom-form-control"
                                                value="Ahmed" required>
                                        </div>
                                        <div class="col-md-6 custom-form-group">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" id="lastName" class="custom-form-control"
                                                value="Khan" required>
                                        </div>
                                        <div class="col-md-6 custom-form-group">
                                            <label for="emailAddr">Email Address</label>
                                            <input type="email" id="emailAddr" class="custom-form-control"
                                                value="ahmed.khan@email.com" required>
                                        </div>
                                        <div class="col-md-6 custom-form-group">
                                            <label for="phoneNo">Phone Number</label>
                                            <input type="tel" id="phoneNo" class="custom-form-control"
                                                value="+92 300 1234567" required>
                                        </div>
                                        <div class="col-12 mt-10">
                                            <button type="submit" class="th-btn btn-sm">Save Changes</button>
                                            <button type="reset" class="th-btn btn-sm style4 ms-2">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab 2: Change Password -->
                            <div class="tab-pane-content" id="pane-change-password">
                                <h3 class="profile-form-heading">Change Password</h3>
                                <form id="changePasswordForm">
                                    <div class="row">
                                        <div class="col-12 custom-form-group">
                                            <label for="currentPass">Current Password</label>
                                            <div class="password-toggle-wrapper">
                                                <input type="password" id="currentPass" class="custom-form-control"
                                                    placeholder="••••••••" required>
                                                <button type="button" class="password-toggle-btn"
                                                    data-password-target="currentPass">
                                                    <i class="fal fa-eye" id="currentPass-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-form-group">
                                            <label for="newPass">New Password</label>
                                            <div class="password-toggle-wrapper">
                                                <input type="password" id="newPass" class="custom-form-control"
                                                    placeholder="••••••••" required>
                                                <button type="button" class="password-toggle-btn"
                                                    data-password-target="newPass">
                                                    <i class="fal fa-eye" id="newPass-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-form-group">
                                            <label for="confirmNewPass">Confirm New Password</label>
                                            <div class="password-toggle-wrapper">
                                                <input type="password" id="confirmNewPass" class="custom-form-control"
                                                    placeholder="••••••••" required>
                                                <button type="button" class="password-toggle-btn"
                                                    data-password-target="confirmNewPass">
                                                    <i class="fal fa-eye" id="confirmNewPass-icon"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="requirements-card">
                                                <i class="fal fa-shield-check"></i>
                                                <div>
                                                    <h4 class="requirements-card-title">Password Requirements
                                                    </h4>
                                                    <ul class="requirements-list">
                                                        <li>At least 8 characters long</li>
                                                        <li>Contains uppercase and lowercase letters</li>
                                                        <li>Contains at least one number</li>
                                                        <li>Contains at least one special character</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="th-btn btn-sm">Update Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab 3: Payment History -->
                            <div class="tab-pane-content" id="pane-payment-history">
                                <h3 class="profile-form-heading">Payment History &amp; Purchased Courses</h3>
                                <div class="table-responsive">
                                    <table class="purchased-courses-table">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Purchase Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courses as $c)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('my-courses', ['course' => $c['slug']]) }}"
                                                            class="course-study-link">
                                                            <strong class="course-meta-title">{{ $c['title'] }}</strong>
                                                        </a><br>
                                                        <span class="course-meta-desc">{{ $c['lessons'] }} &bull;
                                                            {{ $c['duration'] }} &bull; {{ $c['instructor'] }}</span>
                                                    </td>
                                                    <td>Jan 15, 2026</td>
                                                    <td><span class="course-price">{{ $c['price'] }}</span></td>
                                                    <td><span class="paid-status-badge">Paid</span></td>
                                                    <td>
                                                        <button class="invoice-btn" data-course-name="{{ $c['title'] }}"
                                                            data-amount="{{ $c['price'] }}" data-date="Jan 15, 2026">
                                                            <i class="fal fa-download"></i> Invoice
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="total-spent-row">
                                    <span class="total-spent-lbl">Total Enrolled Courses</span>
                                    <span class="total-spent-val">{{ count($courses) }} Programs</span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


@endsection

@section('extra_js')
    <script src="{{ asset('frontend/js/profile-page.js') }}"></script>
@endsection
