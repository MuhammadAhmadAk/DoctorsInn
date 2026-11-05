@extends('student.layouts.master')
@section('title', 'Performance & Diagnostic Analytics — DoctorsInn Elite')

@section('extra_css')
<style>
    .analytics-metric-box {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius);
        padding: 18px 20px;
        box-shadow: var(--std-shadow);
    }
    .subject-stat-card {
        background: #FAFAFA;
        border: 1px solid var(--std-border-subtle);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 10px;
    }
    .action-plan-item {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-left: 3px solid var(--std-primary);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 10px;
    }
    .action-plan-item.priority-danger {
        border-left-color: #DC2626;
    }
    .action-plan-item.priority-warning {
        border-left-color: #D97706;
    }
    .action-plan-item.priority-success {
        border-left-color: #16A34A;
    }
</style>
@endsection

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h5 fw-bold text-dark mb-1" style="letter-spacing: -0.015em;">Performance &amp; Diagnostics</h1>
            <p class="text-muted text-xs mb-0">Mock test scores, subject accuracy, and personalized revision advice.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('student.tests') }}" class="btn btn-sm btn-outline-primary fw-semibold px-3 py-2" style="border-radius: 6px;">
                <span>Solve New Mock Test</span>
                <i class="fa-solid fa-arrow-right text-xs ms-1"></i>
            </a>
        </div>
    </div>

    {{-- Top Overview Metrics --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="analytics-metric-box">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-semibold text-muted">Overall Accuracy</span>
                    <span class="badge-status badge-status-success">Top 15%</span>
                </div>
                <div class="h4 fw-bold text-dark mb-1">{{ $stats['accuracy_rate'] }}%</div>
                <p class="text-muted text-xs mb-0">{{ $stats['correct_mcqs'] }} of 600 MCQs correct</p>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="analytics-metric-box">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-semibold text-muted">Average Score</span>
                    <span class="badge-status badge-status-primary">Steady</span>
                </div>
                <div class="h4 fw-bold text-dark mb-1">{{ $stats['avg_score'] }}%</div>
                <p class="text-muted text-xs mb-0">Across 6 solved tests</p>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="analytics-metric-box">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-semibold text-muted">Study Hours</span>
                    <span class="badge-status badge-status-warning">5-Day Streak</span>
                </div>
                <div class="h4 fw-bold text-dark mb-1">{{ $stats['hours_studied'] }} hrs</div>
                <p class="text-muted text-xs mb-0">Lectures &amp; practice time</p>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="analytics-metric-box">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-semibold text-muted">Projected MDCAT</span>
                    <span class="badge-status badge-status-info">Target Ready</span>
                </div>
                <div class="h4 fw-bold text-dark mb-1">168 - 176</div>
                <p class="text-muted text-xs mb-0">Out of 200 (Merit Zone)</p>
            </div>
        </div>
    </div>

    <div class="row gy-4 mb-4">

        {{-- Left Column: Subject Mastery Analysis --}}
        <div class="col-lg-6">
            <div class="std-card h-100">
                <div class="std-card-header">
                    <div>
                        <h2 class="h6 fw-bold text-dark mb-0">Subject Accuracy</h2>
                        <span class="text-muted text-xs">Calculated from mock test question history</span>
                    </div>
                    <span class="badge-status badge-status-light">PMDC Pattern</span>
                </div>

                @foreach ($subjectReadiness as $subKey => $subject)
                    @php
                        $statusClass = $subject['status'] === 'Strong' ? 'badge-status-success' : ($subject['status'] === 'Good' ? 'badge-status-info' : 'badge-status-warning');
                        $fillClass = $subject['status'] === 'Strong' ? 'fill-success' : ($subject['status'] === 'Good' ? 'fill-info' : 'fill-warning');
                    @endphp
                    <div class="subject-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fw-semibold text-dark text-xs">{{ $subject['name'] }}</span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge-status {{ $statusClass }}">{{ $subject['status'] }}</span>
                                <span class="fw-bold text-dark text-xs">{{ $subject['percentage'] }}%</span>
                            </div>
                        </div>

                        {{-- Progress Track --}}
                        <div class="std-progress-track">
                            <div class="std-progress-fill {{ $fillClass }}" style="width: {{ $subject['percentage'] }}%;"></div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between text-xs text-muted mt-2 pt-1" style="font-size: 11.5px;">
                            <span><b>Solved:</b> {{ $subject['correct'] }}/{{ $subject['attempted'] }} Correct</span>
                            <span class="text-danger fw-semibold">Focus: {{ $subject['weak_areas'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Right Column: Diagnostic Revision Plan --}}
        <div class="col-lg-6">
            <div class="std-card h-100">
                <div class="std-card-header">
                    <div>
                        <h2 class="h6 fw-bold text-dark mb-0">Recommended Revision</h2>
                        <span class="text-muted text-xs">Priority topics to raise your test percentage</span>
                    </div>
                    <span class="badge-status badge-status-primary">Action List</span>
                </div>

                <div class="d-flex flex-column gap-2 mb-3">
                    @foreach ($actionPlan as $plan)
                        @php
                            $planBadgeClass = $plan['badge_color'] === 'danger' ? 'badge-status-danger' : ($plan['badge_color'] === 'warning' ? 'badge-status-warning' : 'badge-status-success');
                        @endphp
                        <div class="action-plan-item priority-{{ $plan['badge_color'] }}">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-semibold text-dark text-xs">
                                    {{ $plan['subject'] }} • {{ $plan['topic'] }}
                                </span>
                                <span class="badge-status {{ $planBadgeClass }}">
                                    {{ $plan['badge'] }}
                                </span>
                            </div>
                            <p class="text-muted text-xs mb-2">{{ $plan['recommendation'] }}</p>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('student.classroom') }}" class="btn btn-sm btn-light border py-1 px-2 text-xs fw-medium text-dark">
                                    Lecture
                                </a>
                                <a href="{{ route('student.elibrary') }}" class="btn btn-sm btn-light border py-1 px-2 text-xs fw-medium text-dark">
                                    PDF Notes
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- Past Tests Performance History Table --}}
    <div class="std-card">
        <div class="std-card-header">
            <div>
                <h2 class="h6 fw-bold text-dark mb-0">Mock Test History</h2>
                <span class="text-muted text-xs">Review questions and score breakdown</span>
            </div>
            <a href="{{ route('student.tests') }}" class="text-primary text-xs fw-semibold text-decoration-none">
                Take Test →
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                <thead>
                    <tr class="text-muted text-xs border-bottom">
                        <th class="fw-semibold pb-2">Test Name</th>
                        <th class="fw-semibold pb-2">Attempt Date</th>
                        <th class="fw-semibold pb-2">Raw Score</th>
                        <th class="fw-semibold pb-2">Percentage</th>
                        <th class="fw-semibold pb-2">Status</th>
                        <th class="fw-semibold pb-2 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentTestHistory as $test)
                        <tr>
                            <td class="fw-medium text-dark py-3">{{ $test['title'] }}</td>
                            <td class="text-muted text-xs py-3">{{ $test['date'] }}</td>
                            <td class="py-3">
                                <span class="fw-bold text-dark">{{ $test['score'] }}</span><span class="text-muted text-xs">/{{ $test['total'] }}</span>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-dark">{{ $test['percentage'] }}%</span>
                                    <div class="std-progress-track mt-0" style="width: 50px; height: 5px;">
                                        <div class="std-progress-fill {{ $test['percentage'] >= 70 ? 'fill-success' : 'fill-warning' }}" style="width: {{ $test['percentage'] }}%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if ($test['status'] === 'Passed')
                                    <span class="badge-status badge-status-success">Passed</span>
                                @else
                                    <span class="badge-status badge-status-warning">Review</span>
                                @endif
                            </td>
                            <td class="text-end py-3">
                                <a href="{{ route('student.tests') }}" class="text-primary text-xs fw-semibold text-decoration-none">
                                    Retake
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
