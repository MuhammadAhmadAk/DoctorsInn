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
                <h3 class="number">{{ number_format($totalStudents) }}</h3>
                <div class="growth up">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>{{ array_sum($chartData['students']) }} joined in last 7 months</span>
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
                <h3 class="number">{{ count($courses ?? []) }}</h3>
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
                <h3 class="number">{{ number_format($totalAttempts) }}</h3>
                <div class="growth up">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>{{ array_sum($chartData['attempts']) }} attempts in last 7 months</span>
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
                <h3 class="number">{{ number_format($totalDownloads) }}</h3>
                <div class="growth up">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>Tracked across all resources</span>
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
                @php $examColors = ['#5C32FF', '#EFAC06', '#10B981']; @endphp
                <div class="d-flex justify-content-around w-100 mt-2 text-center">
                    @foreach ($chartData['exam_labels'] as $i => $label)
                        <div>
                            <div class="fw-bold" style="color: {{ $examColors[$i] ?? '#64748b' }};">{{ $chartData['exam_distribution'][$i] ?? 0 }}%</div>
                            <div class="small text-muted" style="font-size: 11px;">{{ $label }}</div>
                        </div>
                    @endforeach
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
                <table class="adm-table" data-no-paginate="true">
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
                        @forelse ($recentAttempts as $attempt)
                        <tr>
                            <td>
                                <div class="item-thumb-box">
                                    <img src="{{ asset($attempt->user->avatar ?: 'student/img/icons/avatar.png') }}" alt="Student">
                                    <div>
                                        <div class="title">{{ $attempt->user->name ?? 'Student' }}</div>
                                        <div class="subtitle">{{ $attempt->user->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">{{ Str::limit($attempt->test_title, 28) }}</span>
                                <div class="small text-muted">{{ $attempt->total_questions }} MCQs • {{ $attempt->created_at?->diffForHumans() }}</div>
                            </td>
                            <td><span class="fw-bold text-dark">{{ (int) $attempt->score }} / {{ (int) $attempt->total_marks }}</span> ({{ (int) round($attempt->percentage) }}%)</td>
                            <td>
                                @if ($attempt->passed)
                                    <span class="adm-badge adm-badge-success">Passed</span>
                                @else
                                    <span class="adm-badge adm-badge-warning">Retake Needed</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.students', ['search' => $attempt->user->email ?? '']) }}" class="action-btn" title="View Student"><i class="fa-solid fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">No mock test submissions yet.</td>
                        </tr>
                        @endforelse
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
                <table class="adm-table" data-no-paginate="true">
                    <thead>
                        <tr>
                            <th>Batch</th>
                            <th>Enrolled</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(array_slice($courses ?? [], 0, 4) as $key => $course)
                        <tr>
                            <td>
                                <div class="item-thumb-box">
                                    <img src="{{ asset($course['thumbnail'] ?? ($course['image'] ?? 'frontend/img/normal/about_2_1.jpg')) }}" alt="Course">
                                    <div>
                                        <div class="title">{{ Str::limit($course['title'] ?? 'Course Title', 22) }}</div>
                                        <div class="subtitle">{{ $course['category'] ?? 'MDCAT' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="fw-bold text-dark">{{ $course['students'] ?? 'Active' }}</span></td>
                            <td><span class="fw-bold text-primary">{{ $course['price'] ?? 'Rs. 15,000' }}</span></td>
                            <td><span class="adm-badge adm-badge-success">Active</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">No courses created in database yet. <a href="{{ route('admin.courses.create') }}">Add new course</a></td>
                        </tr>
                        @endforelse
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
            labels: @json($chartData['labels']),
            datasets: [
                {
                    label: 'Mock Tests Taken',
                    data: @json($chartData['attempts']),
                    borderColor: '#5C32FF',
                    backgroundColor: 'rgba(92, 50, 255, 0.08)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#5C32FF',
                    pointRadius: 4,
                },
                {
                    label: 'New Students',
                    data: @json($chartData['students']),
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
            labels: @json($chartData['exam_labels']),
            datasets: [{
                data: @json($chartData['exam_distribution']),
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
