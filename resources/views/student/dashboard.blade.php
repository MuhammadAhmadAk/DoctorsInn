@extends('student.layouts.master')
@section('title', 'My Study Hub — DoctorsInn Elite')

@section('extra_css')
<style>
    .dash-welcome-card {
        background: linear-gradient(135deg, #FFFFFF 0%, #F4F0FF 100%);
        border: 1px solid var(--std-primary-border);
        border-radius: var(--std-radius);
        padding: 18px 22px;
        margin-bottom: 18px;
        box-shadow: var(--std-shadow);
    }
    .dash-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2.5px solid #FFFFFF;
        box-shadow: 0 3px 10px rgba(92, 50, 255, 0.18);
    }
    .countdown-widget {
        background: #FFFFFF;
        border: 1px solid var(--std-primary-border);
        border-radius: 8px;
        padding: 10px 16px;
        text-align: center;
    }
    .countdown-num {
        font-size: 20px;
        font-weight: 800;
        color: var(--std-primary);
        letter-spacing: -0.02em;
        line-height: 1.1;
    }
    .countdown-label {
        font-size: 11.5px;
        color: var(--std-text-muted);
        font-weight: 600;
        margin-top: 3px;
    }
    .resume-course-card {
        background: #FFFFFF;
        border: 1px solid var(--std-border);
        border-left: 4px solid var(--std-primary);
        border-radius: var(--std-radius);
        padding: 16px 20px;
        margin-bottom: 18px;
        box-shadow: var(--std-shadow);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }
    .resume-play-badge {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: var(--std-primary-light);
        color: var(--std-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .subject-row {
        padding: 14px 16px;
        border: 1px solid var(--std-border-subtle);
        border-radius: 12px;
        background: #FCFCFF;
        margin-bottom: 10px;
        transition: border-color 0.15s ease, background 0.15s ease;
    }
    .subject-row:hover {
        border-color: var(--std-primary-border);
        background: #FAF9FF;
    }
    .subject-icon-pill {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .vault-file-row {
        background: #FCFCFF;
        border: 1px solid var(--std-border-subtle);
        border-radius: 12px;
        padding: 10px 14px;
        transition: border-color 0.15s ease, background 0.15s ease;
    }
    .vault-file-row:hover {
        border-color: var(--std-primary-border);
        background: #FAF9FF;
    }
    .enroll-modal .modal-content { border: 0; border-radius: 8px; box-shadow: 0 24px 60px rgba(5, 3, 16, .18); }
    .enroll-check {
        width: 58px;
        height: 58px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: #ECFDF3;
        color: #12B76A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 0 0 6px #F3FEF7;
    }
    .enroll-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: #0F0C1D;
        letter-spacing: -0.01em;
        margin-bottom: 6px;
    }
    .enroll-sub {
        font-size: 13px;
        color: #6B6780;
        line-height: 1.55;
        margin-bottom: 20px;
    }
    .enroll-course {
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: left;
        background: #FBFAFF;
        border: 1px solid var(--std-border-subtle);
        border-radius: 8px;
        padding: 12px;
    }
    .enroll-course-thumb {
        width: 48px;
        height: 48px;
        border-radius: 6px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .enroll-course-icon {
        width: 48px;
        height: 48px;
        border-radius: 6px;
        background: var(--std-primary-light);
        color: var(--std-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .enroll-course-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #0F0C1D;
        line-height: 1.35;
    }
    .enroll-course-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        font-size: 11.5px;
        color: #8B85A8;
        margin-top: 5px;
    }
    .enroll-actions .btn { border-radius: 8px; font-size: 13.5px; }
</style>
@endsection

@section('content')

    {{-- 1. Warm Student Welcome Header & Countdown --}}
    <div class="dash-welcome-card">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8 d-flex align-items-center gap-3">
                <img src="{{ asset($studentData['avatar']) }}" alt="{{ $studentData['name'] }}" class="dash-avatar">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <h1 class="h5 fw-bold text-dark mb-0" style="letter-spacing: -0.015em;">Welcome back, {{ $studentData['name'] }}! 👋</h1>
                        <span class="badge-status badge-status-primary">
                            <i class="fa-solid fa-stethoscope"></i> {{ $studentData['target_exam'] }} 2026
                        </span>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 13px;">Every lecture &amp; MCQ brings you closer to your medical college dream. Keep going!</p>
                </div>
            </div>

            <div class="col-lg-4 text-lg-end">
                <div class="countdown-widget d-inline-block">
                    <div class="countdown-num">{{ $daysRemaining }} Days</div>
                    <div class="countdown-label">⏳ Left for {{ $studentData['target_exam'] }} 2026</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Student Study Progress KPIs --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon kpi-purple">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['enrolled_batches'] }} Batch</div>
                    <div class="std-kpi-lbl">Active Enrollment</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon kpi-emerald">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['tests_completed'] }} Tests</div>
                    <div class="std-kpi-lbl">Mock Quizzes Solved</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon kpi-sky">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['avg_score'] }}%</div>
                    <div class="std-kpi-lbl">Average Accuracy</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon kpi-amber">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['study_streak_days'] }} Days</div>
                    <div class="std-kpi-lbl">Daily Study Streak</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Jump Back Into Study Card --}}
    <div class="resume-course-card">
        <div class="d-flex align-items-center gap-3 flex-grow-1" style="min-width: 240px;">
            <div class="resume-play-badge d-none d-sm-flex">
                <i class="fa-solid fa-play"></i>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge-status badge-status-primary">Continue Studying</span>
                    <span class="text-muted fw-semibold" style="font-size: 12px;">{{ $stats['syllabus_completed'] ?? 42 }}% Syllabus Covered</span>
                </div>
                <h2 class="h6 fw-bold text-dark mb-1">{{ $stats['active_batch_name'] ?? 'MDCAT Reboot: 60-Day Prep Program' }}</h2>
                <div class="text-muted mb-2" style="font-size: 12.5px;">Biology • Cell Structure, Organelles &amp; Biological Molecules</div>
                <div class="std-progress-track" style="max-width: 360px;">
                    <div class="std-progress-fill" style="width: {{ $stats['syllabus_completed'] ?? 42 }}%;"></div>
                </div>
            </div>
        </div>
        <div>
            <a href="{{ route('student.classroom', 'mdcat-reboot-60-day') }}" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill d-inline-flex align-items-center gap-2" style="font-size: 13.5px;">
                <span>Resume Lecture</span>
                <i class="fa-solid fa-arrow-right" style="font-size: 12px;"></i>
            </a>
        </div>
    </div>

    {{-- 4. Main Two-Column Learning Area --}}
    <div class="row g-4">

        {{-- Left: Subject Mastery & Recent Tests --}}
        <div class="col-lg-7">
            {{-- Subject Mastery --}}
            <div class="std-card">
                <div class="std-card-header">
                    <div>
                        <h3 class="h6 fw-bold text-dark mb-0">Subject Mastery</h3>
                        <span class="text-muted" style="font-size: 12px;">Based on your practice MCQs &amp; mock exams</span>
                    </div>
                    <span class="badge-status badge-status-success">
                        <i class="fa-solid fa-circle-check"></i> On Track
                    </span>
                </div>

                <div class="d-flex flex-column">
                    @foreach ($subjectReadiness as $subKey => $subject)
                        @php
                            $statusClass = match ($subject['status']) {
                                'Strong' => 'badge-status-success',
                                'Good' => 'badge-status-info',
                                'Weak' => 'badge-status-danger',
                                default => 'badge-status-warning',
                            };
                            $fillClass = match ($subject['status']) {
                                'Strong' => 'fill-success',
                                'Good' => 'fill-info',
                                'Weak' => 'fill-danger',
                                default => 'fill-warning',
                            };
                            $subColor = $subject['color'] ?? '#5C32FF';
                            $subIcon = $subject['icon'] ?? 'fa-solid fa-book';
                        @endphp
                        <div class="subject-row">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="subject-icon-pill" style="background: {{ $subColor }}1A; color: {{ $subColor }};">
                                        <i class="{{ $subIcon }}"></i>
                                    </span>
                                    <span class="fw-bold text-dark" style="font-size: 13.5px;">{{ $subject['name'] }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge-status {{ $statusClass }}">{{ $subject['status'] }}</span>
                                    <span class="fw-bold text-dark" style="font-size: 13.5px;">{{ $subject['percentage'] }}%</span>
                                </div>
                            </div>
                            <div class="std-progress-track">
                                <div class="std-progress-fill {{ $fillClass }}" style="width: {{ $subject['percentage'] }}%;"></div>
                            </div>
                            <div class="text-muted mt-2" style="font-size: 12px;">
                                <span class="fw-semibold" style="color: var(--std-primary);">Next focus:</span> {{ $subject['weak_areas'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent Practice Tests --}}
            <div class="std-card">
                <div class="std-card-header">
                    <div>
                        <h3 class="h6 fw-bold text-dark mb-0">Recent Practice Tests</h3>
                        <span class="text-muted" style="font-size: 12px;">Your latest mock test scores</span>
                    </div>
                    <a href="{{ route('student.tests') }}" class="text-primary fw-bold text-decoration-none" style="font-size: 12.5px;">
                        All Mock Tests →
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead>
                            <tr class="text-muted border-bottom" style="font-size: 12px;">
                                <th class="fw-semibold pb-2">Test Name</th>
                                <th class="fw-semibold pb-2">Date</th>
                                <th class="fw-semibold pb-2">Score</th>
                                <th class="fw-semibold pb-2 text-end">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentTestHistory as $test)
                                <tr>
                                    <td class="fw-semibold text-dark py-3">
                                        @if (!empty($test['url']))
                                            <a href="{{ $test['url'] }}" class="text-dark text-decoration-none">{{ $test['title'] }}</a>
                                        @else
                                            {{ $test['title'] }}
                                        @endif
                                    </td>
                                    <td class="text-muted py-3" style="font-size: 12px;">{{ $test['date'] }}</td>
                                    <td class="py-3">
                                        <span class="fw-bold text-dark">{{ $test['score'] }}</span><span class="text-muted" style="font-size: 12px;">/{{ $test['total'] }}</span>
                                        <span class="text-muted ms-1" style="font-size: 12px;">({{ $test['percentage'] }}%)</span>
                                    </td>
                                    <td class="text-end py-3">
                                        @if ($test['status'] === 'Passed')
                                            <span class="badge-status badge-status-success">Passed</span>
                                        @else
                                            <span class="badge-status badge-status-warning">Revise</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4" style="font-size: 12.5px;">
                                        No mock tests attempted yet. <a href="{{ route('student.tests') }}" class="fw-semibold text-decoration-none">Start your first test →</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Mentor Updates & Study Notes --}}
        <div class="col-lg-5">
            {{-- Academy Notice Board --}}
            <div class="std-card">
                <div class="std-card-header">
                    <h3 class="h6 fw-bold text-dark mb-0">Batch Updates</h3>
                    <span class="badge-status badge-status-light">DoctorsInn Mentors</span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @foreach ($announcements as $ann)
                        <div class="pb-3 border-bottom last-border-0">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="badge-status badge-status-primary">{{ $ann['badge'] }}</span>
                                <span class="text-muted" style="font-size: 11.5px;">{{ $ann['date'] }}</span>
                            </div>
                            <h4 class="fw-semibold text-dark mb-0" style="font-size: 13.5px; line-height: 1.45;">{{ $ann['title'] }}</h4>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Quick Study Notes & PDFs --}}
            <div class="std-card">
                <div class="std-card-header">
                    <h3 class="h6 fw-bold text-dark mb-0">Quick Notes &amp; PDFs</h3>
                    <a href="{{ route('student.elibrary') }}" class="text-primary fw-bold text-decoration-none" style="font-size: 12.5px;">
                        Open E-Library →
                    </a>
                </div>

                <div class="d-flex flex-column gap-2">
                    @foreach (array_slice($resources, 0, 4) as $res)
                        <div class="vault-file-row d-flex align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-3 overflow-hidden">
                                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 36px; height: 36px; background: #FEF2F2; color: #EF4444;">
                                    <i class="fa-regular fa-file-pdf fs-6"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-semibold text-dark text-truncate" style="font-size: 13px;">{{ $res['title'] }}</div>
                                    <div class="text-muted" style="font-size: 11.5px;">Official PMC Solved PDF</div>
                                </div>
                            </div>
                            <a href="{{ route('e-library.download', $res['slug']) }}" class="btn btn-sm btn-light border py-1 px-2 rounded-3 flex-shrink-0 text-primary" title="Download PDF">
                                <i class="fa-solid fa-download" style="font-size: 12px;"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- Enrollment success popup (one-time flash) --}}
    @if (session('enrollment_success'))
        @php $enrolled = session('enrollment_success'); @endphp
        <div class="modal fade enroll-modal" id="enrollmentSuccessModal" tabindex="-1"
            aria-labelledby="enrollmentSuccessTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-4 p-sm-5 text-center">
                        <div class="enroll-check">
                            <i class="fa-solid fa-check"></i>
                        </div>

                        <h2 class="enroll-title" id="enrollmentSuccessTitle">Enrollment confirmed</h2>
                        <p class="enroll-sub">
                            @if (! empty($enrolled['paid']))
                                Payment received. You are now enrolled in this course. Your classroom is ready — start learning right away.
                            @else
                                You are now enrolled in this course. Your classroom is ready — start learning right away.
                            @endif
                        </p>

                        <div class="enroll-course">
                            @if (! empty($enrolled['image']))
                                <img src="{{ asset($enrolled['image']) }}" alt="{{ $enrolled['title'] }}" class="enroll-course-thumb">
                            @else
                                <div class="enroll-course-icon">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                </div>
                            @endif
                            <div>
                                <div class="enroll-course-title">{{ $enrolled['title'] }}</div>
                                <div class="enroll-course-meta">
                                    <span class="badge-status badge-status-success">
                                        <i class="fa-solid fa-circle-check"></i> Access active
                                    </span>
                                    @if (! empty($enrolled['lessons']))
                                        <span>{{ $enrolled['lessons'] }}</span>
                                    @endif
                                    @if (! empty($enrolled['paid']))
                                        <span>{{ $enrolled['amount'] }} paid</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="enroll-actions d-grid gap-2 mt-4">
                            <a href="{{ route('student.classroom', $enrolled['slug']) }}" class="btn btn-primary py-2 fw-semibold">
                                <i class="fa-solid fa-play me-2" style="font-size: 11px;"></i>Start Learning
                            </a>
                            <button type="button" class="btn btn-link text-muted text-decoration-none py-1" data-bs-dismiss="modal">
                                Stay on dashboard
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('extra_js')
    @if (session('enrollment_success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modalEl = document.getElementById('enrollmentSuccessModal');
                if (modalEl && window.bootstrap) {
                    window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
                }
            });
        </script>
    @endif
@endsection
