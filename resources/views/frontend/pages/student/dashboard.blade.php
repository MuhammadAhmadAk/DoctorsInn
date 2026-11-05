@extends('frontend.layouts.main')
@section('title', 'Student LMS Dashboard | DoctorsInnElite')
@section('meta_description', 'DoctorsInnElite Student Portal — Track your MDCAT syllabus progress, attempt online mock tests, watch video lectures, and access study material.')
@section('meta_keywords', 'DoctorsInn student portal, MDCAT LMS, student dashboard, online medical prep Pakistan')

@section('extra_css')
<style>
    .student-dashboard-area {
        background-color: #F6F6FE;
        min-height: 85vh;
        padding: 40px 0 70px 0;
    }
    .sp-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(92, 50, 255, 0.1);
        box-shadow: 0 4px 20px rgba(92, 50, 255, 0.04);
        padding: 24px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .sp-card:hover {
        box-shadow: 0 8px 26px rgba(92, 50, 255, 0.08);
    }
    .sp-header-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        border-radius: 20px;
        padding: 32px 36px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow: 0 10px 30px rgba(30, 27, 75, 0.2);
    }
    .sp-header-banner::before {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(239, 172, 6, 0.25) 0%, transparent 70%);
        pointer-events: none;
    }
    .sp-header-banner::after {
        content: "";
        position: absolute;
        bottom: -50px;
        left: 20%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(92, 50, 255, 0.3) 0%, transparent 70%);
        pointer-events: none;
    }
    .sp-avatar-frame {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        object-fit: cover;
    }
    .sp-target-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(239, 172, 6, 0.2);
        border: 1px solid rgba(239, 172, 6, 0.4);
        color: #FBBF24;
        font-weight: 700;
        font-size: 12.5px;
        padding: 4px 12px;
        border-radius: 20px;
    }
    .sp-countdown-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-size: 13px;
        color: #f1f5f9;
    }
    .sp-kpi-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(92, 50, 255, 0.08);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.02);
        transition: transform 0.2s ease;
    }
    .sp-kpi-card:hover {
        transform: translateY(-2px);
    }
    .sp-kpi-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .sp-kpi-num {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }
    .sp-kpi-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }
    .sp-resume-box {
        background: linear-gradient(135deg, #ffffff 0%, #faf8ff 100%);
        border: 1.5px solid #5C32FF;
        border-radius: 16px;
        padding: 22px 26px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 28px;
        box-shadow: 0 6px 20px rgba(92, 50, 255, 0.08);
    }
    .sp-resume-btn {
        background: #5C32FF;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 14px;
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(92, 50, 255, 0.3);
    }
    .sp-resume-btn:hover {
        background: #4a24e0;
        transform: scale(1.02);
    }
    .sp-nav-tabs {
        display: flex;
        gap: 8px;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 24px;
        overflow-x: auto;
        padding-bottom: 2px;
    }
    .sp-tab-btn {
        background: none;
        border: none;
        font-size: 14.5px;
        font-weight: 600;
        color: #64748b;
        padding: 10px 18px;
        border-radius: 8px 8px 0 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        position: relative;
        transition: all 0.2s ease;
    }
    .sp-tab-btn:hover {
        color: #5C32FF;
    }
    .sp-tab-btn.active {
        color: #5C32FF;
        font-weight: 700;
    }
    .sp-tab-btn.active::after {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 3px;
        background: #5C32FF;
        border-radius: 3px 3px 0 0;
    }
    .subject-pill {
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        margin-bottom: 12px;
        transition: transform 0.15s ease;
    }
    .subject-pill:hover {
        transform: translateY(-2px);
    }
    .sp-progress-bar {
        height: 8px;
        border-radius: 10px;
        background: #e2e8f0;
        overflow: hidden;
        margin-top: 8px;
    }
    .sp-progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.5s ease;
    }
    .sp-table-card {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .sp-table-card table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }
    .sp-table-card th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
    }
    .sp-table-card td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }
    .sp-table-card tr:last-child td {
        border-bottom: none;
    }
    .sp-action-btn-sm {
        font-size: 12.5px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
</style>
@endsection

@section('content')

    <section class="student-dashboard-area">
        <div class="container">

            {{-- 1. Top Greeting & Exam Countdown Banner --}}
            <div class="sp-header-banner">
                <div class="row align-items-center gy-3 position-relative z-index-common">
                    <div class="col-lg-7 d-flex align-items-center gap-3">
                        <img src="{{ asset($studentData['avatar']) }}" alt="{{ $studentData['name'] }}" class="sp-avatar-frame">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                <h2 class="mb-0 text-white fw-bold" style="font-size: 24px;">Welcome back, {{ $studentData['name'] }}!</h2>
                                <span class="sp-target-badge"><i class="fa-solid fa-stethoscope"></i> Target: {{ $studentData['target_exam'] }} 2026</span>
                            </div>
                            <p class="mb-0 text-white text-opacity-75" style="font-size: 13.5px;">
                                <i class="fa-solid fa-graduation-cap me-1"></i> DoctorsInn Elite Student Portal • Member since {{ $studentData['joined_date'] }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-5 text-lg-end">
                        <div class="sp-countdown-pill">
                            <i class="fa-solid fa-hourglass-half text-warning fs-5"></i>
                            <div>
                                <span class="fw-bold fs-6 text-white">{{ $daysRemaining }} Days</span> remaining to MDCAT 2026
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. KPI Statistics Summary Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-sm-6">
                    <div class="sp-kpi-card">
                        <div class="sp-kpi-icon" style="background: rgba(92, 50, 255, 0.1); color: #5C32FF;">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <div>
                            <div class="sp-kpi-num">{{ $stats['enrolled_batches'] }} Batch</div>
                            <div class="sp-kpi-label">Active Enrollment</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="sp-kpi-card">
                        <div class="sp-kpi-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div>
                            <div class="sp-kpi-num">{{ $stats['tests_completed'] }} Tests</div>
                            <div class="sp-kpi-label">Mock Tests Solved</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="sp-kpi-card">
                        <div class="sp-kpi-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="sp-kpi-num">{{ $stats['avg_score'] }}%</div>
                            <div class="sp-kpi-label">Average Test Score</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="sp-kpi-card">
                        <div class="sp-kpi-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                            <i class="fa-solid fa-fire"></i>
                        </div>
                        <div>
                            <div class="sp-kpi-num">{{ $stats['study_streak_days'] }} Days</div>
                            <div class="sp-kpi-label">Study Streak Active</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Hero "Resume Learning" Action Widget --}}
            <div class="sp-resume-box">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-none d-md-flex align-items-center justify-content-center rounded-3" style="width: 50px; height: 50px; background: rgba(92, 50, 255, 0.12); color: #5C32FF; font-size: 22px;">
                        <i class="fa-solid fa-circle-play"></i>
                    </div>
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-1 mb-1" style="font-size: 11px;">CONTINUE LEARNING</span>
                        <h4 class="mb-1 fw-bold text-dark" style="font-size: 17px;">MDCAT Reboot: 60-Day Prep Program</h4>
                        <p class="mb-0 text-muted" style="font-size: 13px;">
                            <i class="fa-solid fa-video me-1"></i> Week 1-2 • Biology: Cell Structure, Organelles &amp; Genetics
                        </p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('my-courses', ['course' => 'mdcat-reboot-60-day']) }}" class="sp-resume-btn">
                        <i class="fa-solid fa-play"></i>
                        <span>Enter Classroom</span>
                    </a>
                </div>
            </div>

            {{-- 4. Interactive LMS Navigation Tabs --}}
            <div class="sp-nav-tabs" role="tablist">
                <button class="sp-tab-btn active" data-tab="tab-overview">
                    <i class="fa-solid fa-chart-pie"></i> Overview
                </button>
                <button class="sp-tab-btn" data-tab="tab-courses">
                    <i class="fa-solid fa-graduation-cap"></i> My Batches ({{ count($courses) }})
                </button>
                <button class="sp-tab-btn" data-tab="tab-tests">
                    <i class="fa-solid fa-list-check"></i> Mock Tests ({{ count($tests) }})
                </button>
                <button class="sp-tab-btn" data-tab="tab-vault">
                    <i class="fa-solid fa-book-bookmark"></i> E-Library Vault ({{ count($resources) }})
                </button>
                <button class="sp-tab-btn" data-tab="tab-profile">
                    <i class="fa-solid fa-user-gear"></i> Student Profile
                </button>
            </div>

            {{-- Tab 1: Overview --}}
            <div id="tab-overview" class="sp-tab-content">
                <div class="row g-4">
                    {{-- Left Column: Diagnostic Radar & Readiness --}}
                    <div class="col-lg-7">
                        <div class="sp-card mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h4 class="fw-bold mb-1" style="font-size: 18px; color: #0f172a;">Subject Readiness Diagnosis</h4>
                                    <p class="text-muted mb-0" style="font-size: 13px;">AI analysis based on your recent practice questions.</p>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fw-bold" style="font-size: 12px;">On Track</span>
                            </div>

                            <div class="row g-2">
                                @foreach ($subjectReadiness as $subKey => $subject)
                                    <div class="col-sm-6">
                                        <div class="subject-pill">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div style="color: {{ $subject['color'] }}; font-size: 16px;">
                                                        <i class="{{ $subject['icon'] }}"></i>
                                                    </div>
                                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $subject['name'] }}</span>
                                                </div>
                                                <span class="fw-bold" style="color: {{ $subject['color'] }}; font-size: 14px;">{{ $subject['percentage'] }}%</span>
                                            </div>
                                            <div class="sp-progress-bar">
                                                <div class="sp-progress-fill" style="width: {{ $subject['percentage'] }}%; background: {{ $subject['color'] }};"></div>
                                            </div>
                                            <div class="mt-2 text-muted" style="font-size: 11.5px;">
                                                <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i> Weakness: {{ $subject['weak_areas'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Recent Test History --}}
                        <div class="sp-card">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h4 class="fw-bold mb-0" style="font-size: 18px; color: #0f172a;">Recent Mock Test Results</h4>
                                <a href="{{ route('tests') }}" class="text-primary fw-bold text-decoration-none" style="font-size: 13px;">View All Tests →</a>
                            </div>

                            <div class="sp-table-card">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Test Name</th>
                                            <th>Date</th>
                                            <th>Score</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentTestHistory as $item)
                                            <tr>
                                                <td class="fw-semibold">{{ $item['title'] }}</td>
                                                <td class="text-muted">{{ $item['date'] }}</td>
                                                <td>
                                                    <span class="fw-bold text-dark">{{ $item['score'] }}/{{ $item['total'] }}</span>
                                                    <span class="text-muted text-xs ms-1">({{ $item['percentage'] }}%)</span>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $item['status'] === 'Passed' ? 'bg-success' : 'bg-warning' }} bg-opacity-10 {{ $item['status'] === 'Passed' ? 'text-success' : 'text-warning' }} px-2 py-1">
                                                        {{ $item['status'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Notices & Quick Links --}}
                    <div class="col-lg-5">
                        {{-- Academy Announcements --}}
                        <div class="sp-card mb-4">
                            <h4 class="fw-bold mb-3" style="font-size: 18px; color: #0f172a;">
                                <i class="fa-solid fa-bullhorn text-warning me-2"></i> Academy Notice Board
                            </h4>

                            @foreach ($announcements as $ann)
                                <div class="p-3 mb-2 rounded-3 border bg-light bg-opacity-50">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <span class="badge bg-primary text-white text-xs px-2 py-1">{{ $ann['badge'] }}</span>
                                        <span class="text-muted" style="font-size: 11.5px;">{{ $ann['date'] }}</span>
                                    </div>
                                    <h6 class="mb-0 fw-semibold text-dark" style="font-size: 13.5px;">{{ $ann['title'] }}</h6>
                                </div>
                            @endforeach
                        </div>

                        {{-- Study Resources Quick Access --}}
                        <div class="sp-card">
                            <h4 class="fw-bold mb-3" style="font-size: 18px; color: #0f172a;">
                                <i class="fa-solid fa-bookmark text-primary me-2"></i> High-Yield PDF Vault
                            </h4>
                            <div class="d-flex flex-column gap-2">
                                @foreach (array_slice($resources, 0, 4) as $res)
                                    <div class="d-flex align-items-center justify-content-between p-2 rounded-3 border bg-white">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-file-pdf text-danger fs-5"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 13px;">{{ Str::limit($res['title'] ?? 'MDCAT Resource', 32) }}</div>
                                                <div class="text-muted" style="font-size: 11px;">PDF Document • Free Download</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('e-library.download', $res['slug']) }}" class="btn btn-sm btn-outline-primary py-1 px-2" style="font-size: 12px;">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab 2: My Courses & Available Batches --}}
            <div id="tab-courses" class="sp-tab-content d-none">
                <div class="sp-card mb-4">
                    <h3 class="fw-bold mb-1" style="font-size: 20px;">Your Enrolled Prep Programs</h3>
                    <p class="text-muted mb-4" style="font-size: 13.5px;">Access video lectures, structured daily plans, and syllabus progress.</p>

                    <div class="row g-3">
                        @foreach ($courses as $c)
                            <div class="col-md-6 col-lg-4">
                                <div class="border rounded-3 overflow-hidden bg-white shadow-sm h-100 d-flex flex-column">
                                    <img src="{{ asset($c['image']) }}" alt="{{ $c['title'] }}" style="height: 160px; width: 100%; object-fit: cover;">
                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $c['category_name'] ?? 'MDCAT' }}</span>
                                            <span class="badge bg-success bg-opacity-10 text-success">Active Batch</span>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-2" style="font-size: 15px;">{{ $c['title'] }}</h5>
                                        <p class="text-muted mb-3" style="font-size: 12.5px;">{{ Str::limit($c['overview'] ?? '', 80) }}</p>

                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between text-muted mb-1" style="font-size: 12px;">
                                                <span>Syllabus Covered</span>
                                                <span class="fw-bold text-dark">42%</span>
                                            </div>
                                            <div class="sp-progress-bar mb-3">
                                                <div class="sp-progress-fill bg-primary" style="width: 42%;"></div>
                                            </div>
                                            <a href="{{ route('my-courses', ['course' => $c['slug']]) }}" class="btn btn-primary w-100 py-2 fw-semibold" style="background: #5C32FF; border: none; font-size: 13.5px;">
                                                <i class="fa-solid fa-play me-1"></i> Open Video Classroom
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tab 3: Mock Tests & Quizzes --}}
            <div id="tab-tests" class="sp-tab-content d-none">
                <div class="sp-card">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <h3 class="fw-bold mb-1" style="font-size: 20px;">Online Mock Tests &amp; Quizzes</h3>
                            <p class="text-muted mb-0" style="font-size: 13.5px;">Timed exam practice with PMDC negative marking patterns.</p>
                        </div>
                        <a href="{{ route('tests') }}" class="btn btn-outline-primary btn-sm px-3 py-2 fw-semibold">View All Tests Catalog</a>
                    </div>

                    <div class="row g-3">
                        @foreach ($tests as $testSlug => $t)
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 border bg-white d-flex align-items-center justify-content-between gap-3 shadow-sm">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(92, 50, 255, 0.1); color: #5C32FF; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1 text-dark" style="font-size: 14.5px;">{{ $t['title'] }}</h6>
                                            <div class="text-muted" style="font-size: 12px;">
                                                <i class="fa-regular fa-clock me-1"></i> {{ $t['duration_minutes'] }} mins &nbsp;•&nbsp; 
                                                <i class="fa-solid fa-list-ol me-1"></i> {{ $t['total_questions'] }} MCQs &nbsp;•&nbsp; 
                                                <span class="badge bg-warning bg-opacity-25 text-dark">{{ $t['difficulty'] ?? 'Medium' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('test.take', $testSlug) }}" class="btn btn-sm btn-primary py-2 px-3 fw-bold" style="background: #5C32FF; border: none; font-size: 13px; white-space: nowrap;">
                                            Start Test →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tab 4: E-Library Vault --}}
            <div id="tab-vault" class="sp-tab-content d-none">
                <div class="sp-card">
                    <h3 class="fw-bold mb-1" style="font-size: 20px;">Downloadable E-Library Notes &amp; Solved Papers</h3>
                    <p class="text-muted mb-4" style="font-size: 13.5px;">Instant high-yield revision material for MDCAT, NUMS &amp; AMC.</p>

                    <div class="row g-3">
                        @foreach ($resources as $res)
                            <div class="col-md-6 col-lg-4">
                                <div class="p-3 rounded-3 border bg-white h-100 d-flex flex-column justify-content-between shadow-sm">
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        <i class="fa-solid fa-file-pdf text-danger fs-3 flex-shrink-0 mt-1"></i>
                                        <div>
                                            <span class="badge bg-primary bg-opacity-10 text-primary text-xs mb-1">{{ strtoupper($res['category'] ?? 'MDCAT') }}</span>
                                            <h6 class="fw-bold mb-1 text-dark" style="font-size: 14px;">{{ $res['title'] }}</h6>
                                            <p class="text-muted mb-0" style="font-size: 12px;">{{ Str::limit($res['description'] ?? 'Official study material prepared by DoctorsInn faculty.', 60) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('e-library.download', $res['slug']) }}" class="btn btn-outline-primary btn-sm w-100 py-2 fw-semibold">
                                        <i class="fa-solid fa-download me-1"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tab 5: Student Profile --}}
            <div id="tab-profile" class="sp-tab-content d-none">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="sp-card">
                            <h3 class="fw-bold mb-1" style="font-size: 20px;">Student Profile &amp; Account Settings</h3>
                            <p class="text-muted mb-4" style="font-size: 13.5px;">Manage your personal details and target medical examination.</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-semibold" style="font-size: 12.5px;">Full Name</label>
                                    <input type="text" class="form-control" value="{{ $studentData['name'] }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-semibold" style="font-size: 12.5px;">Email Address</label>
                                    <input type="email" class="form-control" value="{{ $studentData['email'] }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-semibold" style="font-size: 12.5px;">WhatsApp / Phone</label>
                                    <input type="text" class="form-control" value="{{ $studentData['phone'] }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-semibold" style="font-size: 12.5px;">Target Medical Exam</label>
                                    <input type="text" class="form-control" value="{{ $studentData['target_exam'] }} 2026" readonly>
                                </div>
                                <div class="col-12 mt-4 pt-3 border-top">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-muted" style="font-size: 13px;">Need to update your credentials or enrolled batch?</span>
                                        <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20want%20to%20update%20my%20student%20profile%20details." target="_blank" class="btn btn-outline-success btn-sm px-3 py-2 fw-semibold">
                                            <i class="fa-brands fa-whatsapp me-1"></i> Contact Coordinator
                                        </a>
                                    </div>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.sp-tab-btn');
    const tabContents = document.querySelectorAll('.sp-tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetTab = this.getAttribute('data-tab');

            tabButtons.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.add('d-none'));

            this.classList.add('active');
            const targetElement = document.getElementById(targetTab);
            if (targetElement) {
                targetElement.classList.remove('d-none');
            }
        });
    });
});
</script>
@endsection
