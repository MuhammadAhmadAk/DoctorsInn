@extends('backend.layouts.master')

@section('title', 'Enrollments & Payments')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Enrollments & Payments</h1>
        <p class="page-subtitle">Manual access control, wallet/card orders and course activation history.</p>
    </div>
    <div class="page-actions">
        <form action="{{ route('admin.enrollments') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm"
                placeholder="Student, email or course…" style="min-width: 220px;">
            <select name="status" class="form-select form-select-sm" style="min-width: 130px;">
                <option value="">All statuses</option>
                <option value="active" @selected($status === 'active')>Active</option>
                <option value="revoked" @selected($status === 'revoked')>Revoked</option>
            </select>
            <button type="submit" class="btn-adm btn-adm-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if ($search !== '' || $status !== '')
                <a href="{{ route('admin.enrollments') }}" class="btn-adm btn-adm-outline" title="Clear filters"><i class="fa-solid fa-xmark"></i></a>
            @endif
        </form>
    </div>
</div>

@foreach (['success' => '#10B981', 'error' => '#EF4444', 'warning' => '#F59E0B'] as $key => $color)
    @if (session($key))
        <div class="alert d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: {{ $color }}; font-size: 12.5px;">
            <i class="fa-solid fa-circle-info"></i>
            <span>{{ session($key) }}</span>
        </div>
    @endif
@endforeach

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon success" style="width: 44px; height: 44px; font-size: 18px;"><i class="fa-solid fa-user-check"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($stats['active']) }}</div>
                    <div class="small text-muted">Active Enrollments</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon info" style="width: 44px; height: 44px; font-size: 18px;"><i class="fa-solid fa-sack-dollar"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">Rs {{ number_format($stats['paid_total'] / 100) }}</div>
                    <div class="small text-muted">Paid Revenue</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon warning" style="width: 44px; height: 44px; font-size: 18px;"><i class="fa-solid fa-hourglass-half"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($stats['pending_orders']) }}</div>
                    <div class="small text-muted">Pending Orders</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="width: 44px; height: 44px; font-size: 18px; background: #FEE2E2; color: #DC2626;"><i class="fa-solid fa-user-slash"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($stats['revoked']) }}</div>
                    <div class="small text-muted">Revoked Access</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="adm-card mb-4">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-graduation-cap text-primary"></i>
            Student Enrollments ({{ number_format($enrollments->total()) }})
        </h2>
        <span class="adm-badge adm-badge-success">Live Database</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Source</th>
                    <th>Enrolled</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($enrollments as $enrollment)
                    @php
                        $student = $enrollment->user;
                        $course = $enrollment->course;
                        $active = $enrollment->isActive();
                    @endphp
                    <tr>
                        <td>
                            <div class="item-thumb-box">
                                <img src="{{ asset($student->avatar ?: 'frontend/img/testimonial/testi_2_1.png') }}" alt="{{ $student->name ?? 'Student' }}">
                                <div>
                                    <div class="title">{{ $student->name ?? 'Deleted student' }}</div>
                                    <div class="subtitle">{{ $student->email ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $course->title ?? 'Deleted course' }}</div>
                            @if ($enrollment->order)
                                <div class="small text-muted">{{ $enrollment->order->reference }}</div>
                            @endif
                        </td>
                        <td><span class="adm-badge adm-badge-primary text-capitalize">{{ $enrollment->source }}</span></td>
                        <td><span class="fw-bold text-dark">{{ $enrollment->enrolled_at?->format('d M Y') ?? '—' }}</span></td>
                        <td>
                            @if ($active)
                                <span class="adm-badge adm-badge-success">Active</span>
                            @else
                                <span class="adm-badge" style="background: #FEE2E2; color: #B91C1C;">Revoked</span>
                            @endif
                        </td>
                        <td>
                            @if ($active)
                                <form action="{{ route('admin.enrollments.revoke', $enrollment) }}" method="POST" onsubmit="return confirm('Revoke this student\'s access to the course?');">
                                    @csrf
                                    <button type="submit" class="btn-adm btn-adm-outline" style="color: #DC2626; border-color: #FCA5A5;">Revoke</button>
                                </form>
                            @else
                                <form action="{{ route('admin.enrollments.restore', $enrollment) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-adm btn-adm-outline" style="color: #059669; border-color: #A7F3D0;">Restore</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No enrollments match these filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($enrollments->hasPages())
        <div class="p-3 border-top">{{ $enrollments->links() }}</div>
    @endif
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="adm-card h-100">
            <div class="adm-card-header">
                <h2 class="adm-card-title"><i class="fa-solid fa-user-plus text-primary"></i> Manual Enroll</h2>
            </div>
            <div class="adm-card-body">
                <p class="small text-muted mb-3">Give a registered student access without a payment. Use it for scholarships, demos or bank transfers.</p>
                <form action="{{ route('admin.enrollments.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Student Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-sm" placeholder="student@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Course</label>
                        <select name="course_id" class="form-select form-select-sm" required>
                            <option value="">Select a course…</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->title }} ({{ $course->price ?: 'Free' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Note <span class="text-muted">(optional)</span></label>
                        <input type="text" name="notes" value="{{ old('notes') }}" class="form-control form-control-sm" maxlength="255" placeholder="Scholarship, bank transfer, etc.">
                    </div>
                    <button type="submit" class="btn-adm btn-adm-primary w-100">
                        <i class="fa-solid fa-circle-plus"></i> Enroll Student
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="adm-card h-100">
            <div class="adm-card-header">
                <h2 class="adm-card-title"><i class="fa-solid fa-receipt text-primary"></i> Recent Payment Orders</h2>
            </div>
            <div class="table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $badge = [
                                    'paid' => ['adm-badge-success', 'Paid'],
                                    'pending' => ['adm-badge-warning', 'Pending'],
                                    'failed' => ['adm-badge-danger', 'Failed'],
                                    'cancelled' => ['adm-badge-danger', 'Cancelled'],
                                ][$order->status] ?? ['adm-badge-primary', ucfirst($order->status)];
                            @endphp
                            <tr>
                                <td><span class="fw-bold text-dark" style="font-size: 12px;">{{ $order->reference }}</span></td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $order->user->name ?? '—' }}</div>
                                    <div class="small text-muted">{{ $order->user->email ?? '' }}</div>
                                </td>
                                <td>{{ $order->course->title ?? '—' }}</td>
                                <td><span class="fw-bold text-dark">{{ $order->amountLabel() }}</span></td>
                                <td>
                                    <span class="adm-badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                                </td>
                                <td><span class="small text-muted">{{ $order->created_at?->format('d M, h:i A') }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No payment orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
