@extends('student.layouts.master')
@section('title', 'Performance & Diagnostic Analytics — DoctorsInn Elite')

@section('extra_css')
<style>
    .analytics-metric-box {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius-lg);
        padding: 22px;
        transition: transform 0.2s ease;
    }
    .analytics-metric-box:hover {
        transform: translateY(-2px);
    }
    .subject-stat-card {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius-md);
        padding: 18px 20px;
        margin-bottom: 14px;
        transition: all 0.2s ease;
    }
    .subject-stat-card:hover {
        border-color: rgba(92, 50, 255, 0.3);
        box-shadow: 0 4px 16px rgba(92, 50, 255, 0.05);
    }
    .accuracy-track {
        height: 8px;
        border-radius: 10px;
        background: #e2e8f0;
        overflow: hidden;
        margin-top: 8px;
    }
    .accuracy-fill {
        height: 100%;
        border-radius: 10px;
    }
    .action-plan-item {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-left: 4px solid var(--std-primary);
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 12px;
    }
    .action-plan-item.priority-danger {
        border-left-color: #ef4444;
    }
    .action-plan-item.priority-warning {
        border-left-color: #f59e0b;
    }
    .action-plan-item.priority-success {
        border-left-color: #10b981;
    }
</style>
@endsection

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">Performance &amp; Diagnostic Analytics</h1>
            <p class="text-muted text-sm mb-0">Detailed breakdown of your mock test scores, subject accuracy, and personalized weak-area revision plan.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('student.tests') }}" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold" style="font-size: 13px; border-radius: 8px;">
                <i class="fa-solid fa-play"></i>
                <span>Attempt New Mock Test</span>
            </a>
        </div>
    </div>

    {{-- Top Overview Metrics --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="analytics-metric-box">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-bold text-uppercase text-muted">Overall Accuracy</span>
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold">Top 15%</span>
                </div>
                <div class="h3 fw-bold text-dark mb-1">{{ $stats['accuracy_rate'] }}%</div>
                <p class="text-muted text-xs mb-0">{{ $stats['correct_mcqs'] }} Correct out of 600 MCQs</p>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="analytics-metric-box">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-bold text-uppercase text-muted">Average Score</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">Steady</span>
                </div>
                <div class="h3 fw-bold text-dark mb-1">{{ $stats['avg_score'] }}%</div>
                <p class="text-muted text-xs mb-0">Based on 6 grand &amp; unit tests</p>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="analytics-metric-box">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-bold text-uppercase text-muted">Study Dedication</span>
                    <span class="badge bg-warning bg-opacity-10 text-warning fw-bold">5-Day Streak</span>
                </div>
                <div class="h3 fw-bold text-dark mb-1">{{ $stats['hours_studied'] }} hrs</div>
                <p class="text-muted text-xs mb-0">Video lectures &amp; practice hours</p>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="analytics-metric-box">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-bold text-uppercase text-muted">Projected MDCAT</span>
                    <span class="badge bg-info bg-opacity-10 text-info fw-bold">Target Ready</span>
                </div>
                <div class="h3 fw-bold text-dark mb-1">168 - 176</div>
                <p class="text-muted text-xs mb-0">Out of 200 (Medical College Merit Zone)</p>
            </div>
        </div>
    </div>

    <div class="row gy-4 mb-4">

        {{-- Left Column: Subject Mastery Analysis --}}
        <div class="col-lg-6">
            <div class="std-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <div>
                        <h2 class="h5 fw-bold text-dark mb-0">Subject Accuracy &amp; Mastery</h2>
                        <span class="text-muted text-xs">Derived from your mock tests and quizzes</span>
                    </div>
                    <span class="badge bg-light text-dark border px-2 py-1 text-xs fw-semibold">PMDC Weightage</span>
                </div>

                @foreach ($subjectReadiness as $subKey => $subject)
                    <div class="subject-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <i class="{{ $subject['icon'] }}" style="color: {{ $subject['color'] }}; font-size: 16px;"></i>
                                <span class="fw-bold text-dark" style="font-size: 14.5px;">{{ $subject['name'] }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge" style="background: {{ $subject['color'] }}20; color: {{ $subject['color'] }}; font-size: 11px;">
                                    {{ $subject['status'] }}
                                </span>
                                <span class="fw-bold text-dark" style="font-size: 14px;">{{ $subject['percentage'] }}%</span>
                            </div>
                        </div>

                        {{-- Progress Track --}}
                        <div class="accuracy-track">
                            <div class="accuracy-fill" style="width: {{ $subject['percentage'] }}%; background: {{ $subject['color'] }};"></div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between text-xs text-muted mt-2 pt-1">
                            <span><b>Solved:</b> {{ $subject['correct'] }}/{{ $subject['attempted'] }} Correct</span>
                            <span class="text-danger text-opacity-80"><b>Weak:</b> {{ $subject['weak_areas'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Right Column: Diagnostic Revision Plan --}}
        <div class="col-lg-6">
            <div class="std-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <div>
                        <h2 class="h5 fw-bold text-dark mb-0">Diagnostic Revision Plan</h2>
                        <span class="text-muted text-xs">Targeted weak areas that will raise your score</span>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 text-xs fw-semibold">Action Items</span>
                </div>

                <div class="d-flex flex-column gap-2 mb-3">
                    @foreach ($actionPlan as $plan)
                        <div class="action-plan-item priority-{{ $plan['badge_color'] }}">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-bold text-dark" style="font-size: 14px;">
                                    <i class="fa-solid fa-triangle-exclamation text-{{ $plan['badge_color'] }} me-1"></i>
                                    {{ $plan['subject'] }}: {{ $plan['topic'] }}
                                </span>
                                <span class="badge bg-{{ $plan['badge_color'] }} bg-opacity-10 text-{{ $plan['badge_color'] }} text-xs">
                                    {{ $plan['badge'] }}
                                </span>
                            </div>
                            <p class="text-muted text-xs mb-2">{{ $plan['recommendation'] }}</p>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('student.classroom') }}" class="btn btn-sm btn-light border py-1 px-2 text-xs fw-semibold">
                                    <i class="fa-solid fa-play text-primary me-1"></i> Watch Topic
                                </a>
                                <a href="{{ route('student.elibrary') }}" class="btn btn-sm btn-light border py-1 px-2 text-xs fw-semibold">
                                    <i class="fa-solid fa-file-pdf text-danger me-1"></i> Topic Notes
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Teacher Consultation Banner --}}
                <div class="p-3 rounded-3 mt-auto" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="fw-bold text-dark text-xs d-block">Stuck on Physics Formulas?</span>
                            <span class="text-muted text-xs">Request 1-on-1 problem breakdown session.</span>
                        </div>
                        <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20need%20help%20with%20Physics%20numerical%20formulas." target="_blank" class="btn btn-sm btn-success px-3 fw-semibold text-xs">
                            <i class="fa-brands fa-whatsapp me-1"></i> Ask Faculty
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Past Tests Performance History Table --}}
    <div class="std-card p-4">
        <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
            <div>
                <h2 class="h5 fw-bold text-dark mb-0">Recent Mock Test Submissions</h2>
                <span class="text-muted text-xs">Review your questions, wrong options, and timing analysis</span>
            </div>
            <a href="{{ route('student.tests') }}" class="btn btn-sm btn-primary px-3 py-1 fw-semibold text-xs" style="border-radius: 6px;">
                Attempt More Tests
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead class="table-light">
                    <tr>
                        <th class="border-0">Mock Test Name</th>
                        <th class="border-0">Attempt Date</th>
                        <th class="border-0">Raw Score</th>
                        <th class="border-0">Percentage</th>
                        <th class="border-0">Result Status</th>
                        <th class="border-0 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentTestHistory as $test)
                        <tr>
                            <td class="fw-semibold text-dark">
                                <i class="fa-regular fa-file-lines text-primary me-2"></i> {{ $test['title'] }}
                            </td>
                            <td class="text-muted text-xs">{{ $test['date'] }}</td>
                            <td>
                                <b>{{ $test['score'] }}</b> <span class="text-muted text-xs">/ {{ $test['total'] }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold">{{ $test['percentage'] }}%</span>
                                    <div class="progress" style="width: 60px; height: 5px;">
                                        <div class="progress-bar {{ $test['percentage'] >= 70 ? 'bg-success' : 'bg-warning' }}" style="width: {{ $test['percentage'] }}%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $test['status'] === 'Passed' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} px-2 py-1 rounded-pill fw-semibold text-xs">
                                    {{ $test['status'] }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('student.tests') }}" class="btn btn-sm btn-light border py-1 px-3 text-xs fw-semibold text-primary">
                                    Retake Test
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
