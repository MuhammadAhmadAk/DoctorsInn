@extends('backend.layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Admin Dashboard</h1>
        <p class="page-subtitle">Welcome back, Dr. Ahmad. Here is what is happening across DoctorsInn today.</p>
    </div>
    <div class="page-actions">
        <button class="btn-adm btn-adm-outline" onclick="window.print()">
            <i class="fa-solid fa-file-export"></i>
            <span>Export Analytics</span>
        </button>
        <a href="{{ route('admin.courses') }}" class="btn-adm btn-adm-primary">
            <i class="fa-solid fa-bolt"></i>
            <span>Quick Action</span>
        </a>
    </div>
</div>

<!-- Key Stat Cards -->
<div class="row g-3 mb-3">
    <!-- Stat 1: Students -->
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="label">Total Enrolled Students</div>
                <h3 class="number">1,482</h3>
                <div class="growth up">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>+14.8% vs last month</span>
                </div>
            </div>
            <div class="stat-icon primary">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <!-- Stat 2: Active Courses -->
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="label">Active Courses & Batches</div>
                <h3 class="number">{{ count(config('courses', [])) }}</h3>
                <div class="growth up">
                    <i class="fa-solid fa-check"></i>
                    <span>100% Batches On Schedule</span>
                </div>
            </div>
            <div class="stat-icon secondary">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
        </div>
    </div>

    <!-- Stat 3: Mock Tests Attempted -->
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="label">Mock Tests Attempted</div>
                <h3 class="number">8,940</h3>
                <div class="growth up">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>+32.4% exam surge</span>
                </div>
            </div>
            <div class="stat-icon success">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>
        </div>
    </div>

    <!-- Stat 4: E-Library Downloads -->
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="label">E-Library Downloads</div>
                <h3 class="number">24.6k</h3>
                <div class="growth up">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>+18.1% this week</span>
                </div>
            </div>
            <div class="stat-icon info">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-3">
    <!-- Main Trend Chart -->
    <div class="col-xl-8">
        <div class="adm-card h-100">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-chart-line text-primary"></i>
                    Student Engagement & Mock Test Attempts
                </h2>
                <div class="d-flex gap-2">
                    <span class="adm-badge adm-badge-primary">2026 Season</span>
                </div>
            </div>
            <div class="adm-card-body">
                <div style="height: 250px; position: relative;">
                    <canvas id="engagementChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Doughnut Category Chart -->
    <div class="col-xl-4">
        <div class="adm-card h-100">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-chart-pie text-warning"></i>
                    Target Exam Distribution
                </h2>
                <span class="adm-badge adm-badge-warning">Active Applicants</span>
            </div>
            <div class="adm-card-body d-flex flex-column align-items-center justify-content-center">
                <div style="height: 180px; width: 100%; position: relative;">
                    <canvas id="examDistChart"></canvas>
                </div>
                <div class="d-flex justify-content-around w-100 mt-2 text-center">
                    <div>
                        <div class="fw-bold" style="color: #5C32FF;">58%</div>
                        <div class="small text-muted" style="font-size: 11px;">MDCAT</div>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: #EFAC06;">27%</div>
                        <div class="small text-muted" style="font-size: 11px;">NUMS</div>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: #10B981;">15%</div>
                        <div class="small text-muted" style="font-size: 11px;">Army / AMC</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row g-3">
    <!-- Recent Mock Test Attempts -->
    <div class="col-xl-7">
        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-user-check text-primary"></i>
                    Recent Mock Test Submissions
                </h2>
                <a href="{{ route('admin.tests') }}" class="btn-adm btn-adm-outline py-1 px-3 font-12">View All Tests</a>
            </div>
            <div class="table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Test Title</th>
                            <th>Score</th>
                            <th>Result</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="item-thumb-box">
                                    <img src="{{ asset('frontend/img/team/team_2_1.jpg') }}" alt="Student">
                                    <div>
                                        <div class="title">Usman Tariq</div>
                                        <div class="subtitle">usman.tariq@gmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">MDCAT Grand Mock #1</span>
                                <div class="small text-muted">200 MCQs • 3.5 hrs</div>
                            </td>
                            <td><span class="fw-bold text-dark">184 / 200</span> (92%)</td>
                            <td><span class="adm-badge adm-badge-success">Passed</span></td>
                            <td>
                                <div class="table-actions">
                                    <a href="#" class="action-btn" title="View Breakdown"><i class="fa-solid fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="item-thumb-box">
                                    <img src="{{ asset('frontend/img/team/team_2_4.jpg') }}" alt="Student">
                                    <div>
                                        <div class="title">Ali Hassan</div>
                                        <div class="subtitle">ali.hassan@gmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">NUMS Biology Special</span>
                                <div class="small text-muted">80 MCQs • 1.5 hrs</div>
                            </td>
                            <td><span class="fw-bold text-dark">71 / 80</span> (88.7%)</td>
                            <td><span class="adm-badge adm-badge-success">Passed</span></td>
                            <td>
                                <div class="table-actions">
                                    <a href="#" class="action-btn" title="View Breakdown"><i class="fa-solid fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="item-thumb-box">
                                    <img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}" alt="Student">
                                    <div>
                                        <div class="title">Fahad Noor</div>
                                        <div class="subtitle">fahad.noor@yahoo.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">AMC High-Yield Physics</span>
                                <div class="small text-muted">50 MCQs • 1 hr</div>
                            </td>
                            <td><span class="fw-bold text-dark">44 / 50</span> (88%)</td>
                            <td><span class="adm-badge adm-badge-success">Passed</span></td>
                            <td>
                                <div class="table-actions">
                                    <a href="#" class="action-btn" title="View Breakdown"><i class="fa-solid fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="item-thumb-box">
                                    <img src="{{ asset('frontend/img/testimonial/testi_2_2.png') }}" alt="Student">
                                    <div>
                                        <div class="title">Zainab Riaz</div>
                                        <div class="subtitle">zainab.r@gmail.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">MDCAT Full Chemistry</span>
                                <div class="small text-muted">60 MCQs • 1.2 hrs</div>
                            </td>
                            <td><span class="fw-bold text-dark">38 / 60</span> (63.3%)</td>
                            <td><span class="adm-badge adm-badge-warning">Retake Needed</span></td>
                            <td>
                                <div class="table-actions">
                                    <a href="#" class="action-btn" title="View Breakdown"><i class="fa-solid fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Courses Quick View -->
    <div class="col-xl-5">
        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-graduation-cap text-warning"></i>
                    Popular Flagship Batches
                </h2>
                <a href="{{ route('admin.courses') }}" class="btn-adm btn-adm-outline py-1 px-3 font-12">Manage</a>
            </div>
            <div class="table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Batch</th>
                            <th>Enrolled</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(array_slice(config('courses', []), 0, 4) as $key => $course)
                        <tr>
                            <td>
                                <div class="item-thumb-box">
                                    <img src="{{ asset($course['thumbnail'] ?? 'frontend/img/normal/about_2_1.jpg') }}" alt="Course">
                                    <div>
                                        <div class="title">{{ Str::limit($course['title'] ?? 'Course Title', 22) }}</div>
                                        <div class="subtitle">{{ $course['category'] ?? 'MDCAT' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="fw-bold text-dark">{{ rand(140, 480) }}</span></td>
                            <td><span class="fw-bold text-primary">{{ $course['price'] ?? 'Rs. 15,000' }}</span></td>
                            <td><span class="adm-badge adm-badge-success">Active</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Engagement Chart (Line & Bar)
    const ctx1 = document.getElementById('engagementChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
            datasets: [
                {
                    label: 'Mock Tests Taken',
                    data: [1200, 1900, 3100, 5200, 6800, 8100, 8940],
                    borderColor: '#5C32FF',
                    backgroundColor: 'rgba(92, 50, 255, 0.08)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#5C32FF',
                    pointRadius: 4,
                },
                {
                    label: 'Course Enrollments',
                    data: [350, 480, 690, 940, 1150, 1340, 1482],
                    borderColor: '#EFAC06',
                    backgroundColor: 'transparent',
                    borderDash: [5, 5],
                    tension: 0.4,
                    pointBackgroundColor: '#EFAC06',
                    pointRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', weight: '600' } } }
            },
            scales: {
                y: { grid: { color: '#F1F5F9' }, ticks: { font: { family: 'Plus Jakarta Sans' } } },
                x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans' } } }
            }
        }
    });

    // 2. Exam Distribution Doughnut Chart
    const ctx2 = document.getElementById('examDistChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['MDCAT', 'NUMS', 'Army/AMC'],
            datasets: [{
                data: [58, 27, 15],
                backgroundColor: ['#5C32FF', '#EFAC06', '#10B981'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endsection
