@extends('student.layouts.master')
@section('title', 'Student LMS Dashboard')

@section('extra_css')
<style>
    .std-header-box {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 60%, #4338ca 100%);
        border-radius: var(--std-radius-lg);
        padding: 28px 30px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px rgba(30, 27, 75, 0.18);
    }
    .std-header-box::after {
        content: "";
        position: absolute;
        right: -40px;
        top: -40px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(239, 172, 6, 0.25) 0%, transparent 70%);
        pointer-events: none;
    }
    .std-target-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(239, 172, 6, 0.18);
        border: 1px solid rgba(239, 172, 6, 0.4);
        color: #FBBF24;
        font-weight: 700;
        font-size: 12px;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .std-countdown-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 7px 14px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-size: 12.5px;
        color: #f8fafc;
    }
    .std-resume-banner {
        background: linear-gradient(135deg, #ffffff 0%, #fbfaff 100%);
        border: 1.5px solid #5C32FF;
        border-radius: var(--std-radius-lg);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        box-shadow: 0 4px 18px rgba(92, 50, 255, 0.06);
    }
    .subject-radar-card {
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        margin-bottom: 12px;
        transition: transform 0.15s ease;
    }
    .subject-radar-card:hover {
        transform: translateY(-2px);
    }
    .std-progress-track {
        height: 7px;
        border-radius: 8px;
        background: #e2e8f0;
        overflow: hidden;
        margin-top: 8px;
    }
    .std-progress-fill {
        height: 100%;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')

    {{-- Top Student Welcome & Countdown Banner --}}
    <div class="std-header-box">
        <div class="row align-items-center gy-3 position-relative z-index-1">
            <div class="col-lg-7 d-flex align-items-center gap-3">
                <img src="{{ asset($studentData['avatar']) }}" alt="{{ $studentData['name'] }}" style="width: 60px; height: 60px; border-radius: 50%; border: 3px solid rgba(255,255,255,0.3); object-fit: cover;">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <h2 class="mb-0 text-white fw-bold" style="font-size: 22px;">Welcome back, {{ $studentData['name'] }}!</h2>
                        <span class="std-target-pill"><i class="fa-solid fa-stethoscope"></i> Target: {{ $studentData['target_exam'] }} 2026</span>
                    </div>
                    <p class="mb-0 text-white text-opacity-75" style="font-size: 13px;">
                        <i class="fa-solid fa-shield-halved me-1 text-warning"></i> Enrolled in DoctorsInn Elite Preparation Program • Session {{ date('Y') }}
                    </p>
                </div>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="std-countdown-pill">
                    <i class="fa-solid fa-hourglass-half text-warning fs-5"></i>
                    <div>
                        <span class="fw-bold fs-6 text-white">{{ $daysRemaining }} Days</span> remaining to MDCAT 2026
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4 Metric Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon" style="background: rgba(92, 50, 255, 0.1); color: #5C32FF;">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['enrolled_batches'] }} Batch</div>
                    <div class="std-kpi-lbl">Active Enrolled Course</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['tests_completed'] }} Tests</div>
                    <div class="std-kpi-lbl">Mock Tests Solved</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['avg_score'] }}%</div>
                    <div class="std-kpi-lbl">Average Testing Score</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="std-kpi">
                <div class="std-kpi-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ $stats['study_streak_days'] }} Days</div>
                    <div class="std-kpi-lbl">Continuous Study Streak</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hero "Continue Learning" Quick Action --}}
    <div class="std-resume-banner">
        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-md-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 48px; height: 48px; background: rgba(92, 50, 255, 0.1); color: #5C32FF; font-size: 20px;">
                <i class="fa-solid fa-circle-play"></i>
            </div>
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-1 mb-1" style="font-size: 11px;">CONTINUE WATCHING</span>
                <h4 class="mb-1 fw-bold text-dark" style="font-size: 16px;">MDCAT Reboot: 60-Day Prep Program</h4>
                <p class="mb-0 text-muted" style="font-size: 12.5px;">
                    <i class="fa-solid fa-video me-1 text-primary"></i> Week 1-2 • Biology: Cell Structure, Organelles &amp; Biological Molecules
                </p>
            </div>
        </div>
        <div>
            <a href="{{ route('student.classroom', 'mdcat-reboot-60-day') }}" class="btn btn-primary px-4 py-2 fw-bold d-inline-flex align-items-center gap-2 rounded-3 text-nowrap" style="background: #5C32FF; border: none; font-size: 13.5px;">
                <i class="fa-solid fa-play"></i>
                <span>Resume Classroom</span>
            </a>
        </div>
    </div>

    {{-- Main Grid: Left Diagnostic & History + Right Notices & Vault --}}
    <div class="row g-4">
        {{-- Left: Subject Readiness & Test History --}}
        <div class="col-lg-7">
            {{-- Readiness Radar --}}
            <div class="std-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="font-size: 17px; color: #0f172a;">Subject Readiness Diagnosis</h4>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Performance analysis calculated from your solved practice MCQs.</p>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 fw-bold" style="font-size: 11.5px;">On Track</span>
                </div>

                <div class="row g-2">
                    @foreach ($subjectReadiness as $subKey => $subject)
                        <div class="col-sm-6">
                            <div class="subject-radar-card">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="color: {{ $subject['color'] }}; font-size: 15px;">
                                            <i class="{{ $subject['icon'] }}"></i>
                                        </div>
                                        <span class="fw-bold text-dark" style="font-size: 13.5px;">{{ $subject['name'] }}</span>
                                    </div>
                                    <span class="fw-bold" style="color: {{ $subject['color'] }}; font-size: 13.5px;">{{ $subject['percentage'] }}%</span>
                                </div>
                                <div class="std-progress-track">
                                    <div class="std-progress-fill" style="width: {{ $subject['percentage'] }}%; background: {{ $subject['color'] }};"></div>
                                </div>
                                <div class="mt-2 text-muted" style="font-size: 11px;">
                                    <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i> Weakness: {{ $subject['weak_areas'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent Test History --}}
            <div class="std-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="fw-bold mb-0" style="font-size: 17px; color: #0f172a;">Recent Mock Test History</h4>
                    <a href="{{ route('student.tests') }}" class="text-primary fw-bold text-decoration-none" style="font-size: 12.5px;">Open Test Center →</a>
                </div>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="table-light">
                            <tr>
                                <th>Test Title</th>
                                <th>Date</th>
                                <th>Score</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentTestHistory as $test)
                                <tr>
                                    <td class="fw-semibold text-dark">{{ $test['title'] }}</td>
                                    <td class="text-muted">{{ $test['date'] }}</td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $test['score'] }}/{{ $test['total'] }}</span>
                                        <span class="text-muted text-xs ms-1">({{ $test['percentage'] }}%)</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $test['status'] === 'Passed' ? 'bg-success' : 'bg-warning' }} bg-opacity-10 {{ $test['status'] === 'Passed' ? 'text-success' : 'text-warning' }} px-2 py-1">
                                            {{ $test['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Notice Board & E-Library Vault --}}
        <div class="col-lg-5">
            {{-- Academy Notice Board --}}
            <div class="std-card">
                <h4 class="fw-bold mb-3" style="font-size: 17px; color: #0f172a;">
                    <i class="fa-solid fa-bullhorn text-warning me-2"></i> Academy Notice Board
                </h4>

                @foreach ($announcements as $ann)
                    <div class="p-3 mb-2 rounded-3 border bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="badge bg-primary text-white" style="font-size: 10px;">{{ $ann['badge'] }}</span>
                            <span class="text-muted" style="font-size: 11px;">{{ $ann['date'] }}</span>
                        </div>
                        <h6 class="mb-0 fw-semibold text-dark" style="font-size: 13px;">{{ $ann['title'] }}</h6>
                    </div>
                @endforeach
            </div>

            {{-- E-Library Vault Quick Downloads --}}
            <div class="std-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="fw-bold mb-0" style="font-size: 17px; color: #0f172a;">
                        <i class="fa-solid fa-bookmark text-primary me-2"></i> High-Yield PDF Vault
                    </h4>
                    <a href="{{ route('student.elibrary') }}" class="text-primary fw-bold text-decoration-none" style="font-size: 12.5px;">All PDFs →</a>
                </div>

                <div class="d-flex flex-column gap-2">
                    @foreach (array_slice($resources, 0, 4) as $res)
                        <div class="d-flex align-items-center justify-content-between p-2 rounded-3 border bg-white">
                            <div class="d-flex align-items-center gap-2 overflow-hidden">
                                <i class="fa-solid fa-file-pdf text-danger fs-5 flex-shrink-0"></i>
                                <div class="overflow-hidden">
                                    <div class="fw-semibold text-dark text-truncate" style="font-size: 13px;">{{ $res['title'] }}</div>
                                    <div class="text-muted text-xs">PDF Document • High Yield</div>
                                </div>
                            </div>
                            <a href="{{ route('e-library.download', $res['slug']) }}" class="btn btn-sm btn-outline-primary py-1 px-2 rounded-2 flex-shrink-0" style="font-size: 12px;">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
