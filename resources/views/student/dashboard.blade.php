@extends('student.layouts.master')
@section('title', 'Student Dashboard — DoctorsInn Elite')

@section('extra_css')
<style>
    .dash-welcome-card {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius);
        padding: 24px 28px;
        margin-bottom: 20px;
        box-shadow: var(--std-shadow);
    }
    .dash-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid var(--std-border);
    }
    .countdown-widget {
        background: #F8FAFC;
        border: 1px solid var(--std-border);
        border-radius: 8px;
        padding: 10px 18px;
        text-align: right;
    }
    .countdown-num {
        font-size: 22px;
        font-weight: 700;
        color: var(--std-text-title);
        letter-spacing: -0.02em;
        line-height: 1.1;
    }
    .countdown-label {
        font-size: 11.5px;
        color: var(--std-text-muted);
        font-weight: 500;
        margin-top: 2px;
    }
    .resume-course-card {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius);
        padding: 18px 22px;
        margin-bottom: 20px;
        box-shadow: var(--std-shadow);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .subject-row {
        padding: 12px 14px;
        border: 1px solid var(--std-border-subtle);
        border-radius: 8px;
        background: #FAFAFA;
        margin-bottom: 8px;
    }
</style>
@endsection

@section('content')

    {{-- 1. Calm Welcome Header & Countdown --}}
    <div class="dash-welcome-card">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8 d-flex align-items-center gap-3">
                <img src="{{ asset($studentData['avatar']) }}" alt="{{ $studentData['name'] }}" class="dash-avatar">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <h1 class="h5 fw-bold text-dark mb-0" style="letter-spacing: -0.015em;">Welcome back, {{ $studentData['name'] }}</h1>
                        <span class="badge-status badge-status-primary">
                            <i class="fa-solid fa-stethoscope"></i> {{ $studentData['target_exam'] }} 2026 Batch
                        </span>
                    </div>
                    <p class="text-muted text-xs mb-0">DoctorsInn Medical Entry Test Preparation • Session {{ date('Y') }}</p>
                </div>
            </div>

            <div class="col-lg-4 text-lg-end">
                <div class="countdown-widget d-inline-block">
                    <div class="countdown-num text-primary">{{ $daysRemaining }} Days</div>
                    <div class="countdown-label">Until MDCAT 2026 Exam</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Clean 4 Metrics Overview --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['enrolled_batches'] }}</div>
                    <div class="std-kpi-lbl">Active Enrolled Batch</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['tests_completed'] }}</div>
                    <div class="std-kpi-lbl">Mock Tests Solved</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['avg_score'] }}%</div>
                    <div class="std-kpi-lbl">Average Test Score</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon">
                    <i class="fa-solid fa-fire text-warning"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['study_streak_days'] }} Days</div>
                    <div class="std-kpi-lbl">Study Streak</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Resume Active Classroom --}}
    <div class="resume-course-card">
        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-sm-flex align-items-center justify-content-center rounded-2 bg-light border" style="width: 44px; height: 44px; font-size: 16px; color: var(--std-primary);">
                <i class="fa-solid fa-play"></i>
            </div>
            <div>
                <span class="badge-status badge-status-primary mb-1">Ongoing Lecture</span>
                <h2 class="h6 fw-bold text-dark mb-1">MDCAT Reboot: 60-Day Prep Program</h2>
                <div class="text-muted text-xs">Biology • Cell Structure, Organelles &amp; Biological Molecules</div>
            </div>
        </div>
        <div>
            <a href="{{ route('student.classroom', 'mdcat-reboot-60-day') }}" class="btn btn-sm btn-primary px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2" style="border-radius: 6px;">
                <span>Continue Lesson</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

    {{-- 4. Main Two-Column Layout --}}
    <div class="row g-4">

        {{-- Left: Subject Readiness & Test History --}}
        <div class="col-lg-7">
            {{-- Subject Readiness --}}
            <div class="std-card">
                <div class="std-card-header">
                    <div>
                        <h3 class="h6 fw-bold text-dark mb-0">Subject Readiness</h3>
                        <span class="text-muted text-xs">Performance computed from solved mock tests</span>
                    </div>
                    <span class="badge-status badge-status-success">
                        <i class="fa-solid fa-check"></i> On Track
                    </span>
                </div>

                <div class="d-flex flex-column gap-2">
                    @foreach ($subjectReadiness as $subKey => $subject)
                        @php
                            $statusClass = $subject['status'] === 'Strong' ? 'badge-status-success' : ($subject['status'] === 'Good' ? 'badge-status-info' : 'badge-status-warning');
                            $fillClass = $subject['status'] === 'Strong' ? 'fill-success' : ($subject['status'] === 'Good' ? 'fill-info' : 'fill-warning');
                        @endphp
                        <div class="subject-row">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-semibold text-dark text-xs">{{ $subject['name'] }}</span>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge-status {{ $statusClass }}">{{ $subject['status'] }}</span>
                                    <span class="fw-bold text-dark text-xs">{{ $subject['percentage'] }}%</span>
                                </div>
                            </div>
                            <div class="std-progress-track">
                                <div class="std-progress-fill {{ $fillClass }}" style="width: {{ $subject['percentage'] }}%;"></div>
                            </div>
                            <div class="text-muted text-xs mt-2" style="font-size: 11px;">
                                <span class="text-danger fw-semibold">Review:</span> {{ $subject['weak_areas'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent Tests Table --}}
            <div class="std-card">
                <div class="std-card-header">
                    <div>
                        <h3 class="h6 fw-bold text-dark mb-0">Recent Mock Tests</h3>
                        <span class="text-muted text-xs">Submissions &amp; scores</span>
                    </div>
                    <a href="{{ route('student.tests') }}" class="text-primary text-xs fw-semibold text-decoration-none">
                        View All →
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead>
                            <tr class="text-muted text-xs border-bottom">
                                <th class="fw-semibold pb-2">Test Name</th>
                                <th class="fw-semibold pb-2">Date</th>
                                <th class="fw-semibold pb-2">Score</th>
                                <th class="fw-semibold pb-2 text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentTestHistory as $test)
                                <tr>
                                    <td class="fw-medium text-dark py-3">{{ $test['title'] }}</td>
                                    <td class="text-muted text-xs py-3">{{ $test['date'] }}</td>
                                    <td class="py-3">
                                        <span class="fw-bold text-dark">{{ $test['score'] }}</span><span class="text-muted text-xs">/{{ $test['total'] }}</span>
                                        <span class="text-muted text-xs ms-1">({{ $test['percentage'] }}%)</span>
                                    </td>
                                    <td class="text-end py-3">
                                        @if ($test['status'] === 'Passed')
                                            <span class="badge-status badge-status-success">Passed</span>
                                        @else
                                            <span class="badge-status badge-status-warning">Review</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Notices & Resources --}}
        <div class="col-lg-5">
            {{-- Notice Board --}}
            <div class="std-card">
                <div class="std-card-header">
                    <h3 class="h6 fw-bold text-dark mb-0">Announcements</h3>
                    <span class="badge-status badge-status-light">Academy Desk</span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @foreach ($announcements as $ann)
                        <div class="pb-3 border-bottom last-border-0">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="badge-status badge-status-primary">{{ $ann['badge'] }}</span>
                                <span class="text-muted text-xs">{{ $ann['date'] }}</span>
                            </div>
                            <h4 class="fw-semibold text-dark mb-0" style="font-size: 13px; line-height: 1.4;">{{ $ann['title'] }}</h4>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Study Vault Downloads --}}
            <div class="std-card">
                <div class="std-card-header">
                    <h3 class="h6 fw-bold text-dark mb-0">Study Material Vault</h3>
                    <a href="{{ route('student.elibrary') }}" class="text-primary text-xs fw-semibold text-decoration-none">
                        All PDFs →
                    </a>
                </div>

                <div class="d-flex flex-column gap-2">
                    @foreach (array_slice($resources, 0, 4) as $res)
                        <div class="d-flex align-items-center justify-content-between p-2 rounded-2 border" style="background: #FAFAFA;">
                            <div class="d-flex align-items-center gap-2 overflow-hidden">
                                <i class="fa-regular fa-file-pdf text-danger fs-5 flex-shrink-0"></i>
                                <div class="overflow-hidden">
                                    <div class="fw-medium text-dark text-truncate text-xs">{{ $res['title'] }}</div>
                                    <div class="text-muted" style="font-size: 11px;">Official PMC Solved PDF</div>
                                </div>
                            </div>
                            <a href="{{ route('e-library.download', $res['slug']) }}" class="btn btn-sm btn-light border py-1 px-2 rounded-1 flex-shrink-0 text-muted" title="Download">
                                <i class="fa-solid fa-download text-xs"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection
