@extends('backend.layouts.master')

@section('title', 'Enrolled Students Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Enrolled Students & Candidates</h1>
        <p class="page-subtitle">Track registered students, exam targets, mock test activity, and average scores.</p>
    </div>
    <div class="page-actions">
        <form action="{{ route('admin.students') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm"
                placeholder="Search name or email…" style="min-width: 220px;">
            <button type="submit" class="btn-adm btn-adm-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if ($search !== '')
                <a href="{{ route('admin.students') }}" class="btn-adm btn-adm-outline" title="Clear search"><i class="fa-solid fa-xmark"></i></a>
            @endif
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon info" style="width: 44px; height: 44px; font-size: 18px;"><i class="fa-solid fa-users"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($totals['students']) }}</div>
                    <div class="small text-muted">Registered Students</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon success" style="width: 44px; height: 44px; font-size: 18px;"><i class="fa-solid fa-clipboard-check"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($totals['attempts']) }}</div>
                    <div class="small text-muted">Mock Test Attempts</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon warning" style="width: 44px; height: 44px; font-size: 18px;"><i class="fa-solid fa-chart-line"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ $totals['avg_score'] }}%</div>
                    <div class="small text-muted">Average Test Score</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon info" style="width: 44px; height: 44px; font-size: 18px;"><i class="fa-solid fa-bolt"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($totals['active_today']) }}</div>
                    <div class="small text-muted">Active Today</div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-users text-primary"></i>
            Student Directory ({{ number_format($students->total()) }}{{ $search !== '' ? ' matching "' . $search . '"' : '' }})
        </h2>
        <span class="adm-badge adm-badge-success">Live Database</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Target Exam</th>
                    <th>Joined</th>
                    <th>Mock Tests Taken</th>
                    <th>Average Score</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                @php
                    $attemptCount = (int) ($student->test_attempts_count ?? 0);
                    $avgScore = $student->test_attempts_avg_percentage !== null ? round((float) $student->test_attempts_avg_percentage, 1) : null;
                    $avatar = $student->avatar ?: 'frontend/img/testimonial/testi_2_1.png';
                @endphp
                <tr>
                    <td>
                        <div class="item-thumb-box">
                            <img src="{{ asset($avatar) }}" alt="{{ $student->name }}">
                            <div>
                                <div class="title">{{ $student->name }}</div>
                                <div class="subtitle">{{ $student->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="adm-badge adm-badge-primary">{{ strtoupper($student->target_exam ?: 'MDCAT') }}</span></td>
                    <td><span class="fw-bold text-dark">{{ $student->created_at?->format('d M Y') ?? '—' }}</span></td>
                    <td><span class="fw-bold text-dark">{{ $attemptCount }} {{ Str::plural('Test', $attemptCount) }}</span></td>
                    <td>
                        @if ($avgScore !== null)
                            <span class="fw-bold {{ $avgScore >= 70 ? 'text-success' : ($avgScore >= 50 ? 'text-warning' : 'text-danger') }}">{{ $avgScore }}%</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if (!empty($student->email_verified_at))
                            <span class="adm-badge adm-badge-success">Verified</span>
                        @elseif (!empty($student->google_id))
                            <span class="adm-badge adm-badge-success">Google</span>
                        @else
                            <span class="adm-badge adm-badge-primary">Enrolled</span>
                        @endif
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="mailto:{{ $student->email }}" class="action-btn" title="Send Email">
                                <i class="fa-regular fa-envelope"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4" style="font-size: 13px;">
                        {{ $search !== '' ? 'No students match your search.' : 'No students have registered yet.' }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($students->hasPages())
        <div class="adm-card-body d-flex align-items-center justify-content-between" style="font-size: 12.5px;">
            @if ($students->onFirstPage())
                <span class="text-muted">Previous</span>
            @else
                <a href="{{ $students->previousPageUrl() }}" class="text-primary fw-semibold">Previous</a>
            @endif
            <span class="text-muted">Page {{ $students->currentPage() }} of {{ $students->lastPage() }}</span>
            @if ($students->hasMorePages())
                <a href="{{ $students->nextPageUrl() }}" class="text-primary fw-semibold">Next</a>
            @else
                <span class="text-muted">Next</span>
            @endif
        </div>
    @endif
</div>
@endsection
