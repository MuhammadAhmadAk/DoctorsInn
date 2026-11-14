@extends('backend.layouts.master')

@section('title', 'Student Reviews Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Student Course Reviews</h1>
        <p class="page-subtitle">Track, moderate, and inspect student ratings and testimonials across all courses.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.courses') }}" class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Manage Courses</span>
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- KPI Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="adm-card p-3 d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(59, 130, 246, 0.1); color: #2563EB; font-size: 18px;">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <div class="text-muted font-11 fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Total Reviews</div>
                <div class="fw-bold text-dark font-20">{{ $totalReviews }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="adm-card p-3 d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1); color: #059669; font-size: 18px;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="text-muted font-11 fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Approved Live</div>
                <div class="fw-bold text-dark font-20">{{ $approvedReviews }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="adm-card p-3 d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.1); color: #D97706; font-size: 18px;">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <div class="text-muted font-11 fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Avg Rating</div>
                <div class="fw-bold text-dark font-20">{{ number_format($overallAvgRating, 1) }} <span class="text-warning font-14">★</span></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="adm-card p-3 d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(139, 92, 246, 0.1); color: #7C3AED; font-size: 18px;">
                <i class="fa-solid fa-award"></i>
            </div>
            <div>
                <div class="text-muted font-11 fw-semibold text-uppercase" style="letter-spacing: 0.5px;">5-Star Reviews</div>
                <div class="fw-bold text-dark font-20">{{ $fiveStarCount }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Courses Breakdown Cards -->
<div class="adm-card mb-4">
    <div class="adm-card-header py-2.5 px-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="fw-bold font-13 text-dark d-flex align-items-center gap-2">
            <i class="fa-solid fa-layer-group text-primary"></i>
            <span>Reviews Breakdown By Course</span>
        </div>
        <span class="font-11 text-muted">{{ $courses->count() }} Total Courses</span>
    </div>
    <div class="adm-card-body p-3">
        <div class="row g-2">
            <div class="col-auto">
                <a href="{{ route('admin.reviews') }}" class="btn btn-sm {{ empty($selectedCourseId) ? 'btn-primary' : 'btn-outline-secondary' }} font-12 py-1 px-3 rounded-pill d-inline-flex align-items-center gap-1.5 text-decoration-none">
                    <span>All Courses</span>
                    <span class="badge bg-white text-dark rounded-pill font-10 px-1.5">{{ $totalReviews }}</span>
                </a>
            </div>
            @foreach($courses as $c)
            <div class="col-auto">
                <a href="{{ route('admin.reviews', ['course_id' => $c->id]) }}" class="btn btn-sm {{ (string)$selectedCourseId === (string)$c->id ? 'btn-primary' : 'btn-outline-secondary' }} font-12 py-1 px-3 rounded-pill d-inline-flex align-items-center gap-1.5 text-decoration-none">
                    <span class="text-truncate" style="max-width: 180px;">{{ $c->title }}</span>
                    <span class="badge {{ (string)$selectedCourseId === (string)$c->id ? 'bg-white text-primary' : 'bg-light text-dark' }} rounded-pill font-10 px-1.5">
                        {{ $c->approved_reviews_count ?? 0 }}
                    </span>
                    @if(!empty($c->avg_rating))
                        <span class="text-warning font-10">★ {{ number_format($c->avg_rating, 1) }}</span>
                    @endif
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Filters Bar -->
<div class="adm-card mb-4">
    <div class="adm-card-body py-3">
        <form method="GET" action="{{ route('admin.reviews') }}" class="row align-items-center g-2">
            <div class="col-md-4">
                <div class="nav-search w-100">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Search by student, email, review...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="course_id" class="form-select form-select-sm font-12" onchange="this.form.submit()">
                    <option value="">Filter by Course: All</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ (string)$selectedCourseId === (string)$c->id ? 'selected' : '' }}>
                            {{ $c->title }} ({{ $c->approved_reviews_count ?? 0 }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm font-12" onchange="this.form.submit()">
                    <option value="">Filter by Status: All</option>
                    <option value="approved" {{ $selectedStatus === 'approved' ? 'selected' : '' }}>Approved Only</option>
                    <option value="rejected" {{ $selectedStatus === 'rejected' ? 'selected' : '' }}>Rejected Only</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn-adm btn-adm-primary py-1 px-3 font-12 w-100">Filter</button>
                @if($searchQuery || $selectedCourseId || $selectedStatus)
                    <a href="{{ route('admin.reviews') }}" class="btn-adm btn-adm-outline py-1 px-2 font-12" title="Clear Filters">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Reviews Table Card -->
<div class="adm-card">
    <div class="adm-card-header d-flex align-items-center justify-content-between">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-star text-warning"></i>
            <span>Student Reviews ({{ $reviews->total() }})</span>
        </h2>
        @if($selectedCourseId)
            @php $filteredCourse = $courses->firstWhere('id', $selectedCourseId); @endphp
            @if($filteredCourse)
                <span class="adm-badge adm-badge-primary">Filtered: {{ $filteredCourse->title }}</span>
            @endif
        @endif
    </div>

    @if($reviews->isEmpty())
        <div class="text-center py-5">
            <i class="fa-regular fa-comment-dots text-muted font-32 mb-2"></i>
            <div class="fw-bold text-dark font-14">No Reviews Found</div>
            <p class="text-muted font-12 mb-0">No student reviews match the selected filter criteria.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th style="width: 220px;">Student</th>
                        <th style="width: 180px;">Course</th>
                        <th style="width: 140px;">Rating</th>
                        <th>Review Feedback</th>
                        <th style="width: 120px;">Date</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 110px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $rev)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold font-12 flex-shrink-0" style="width: 34px; height: 34px; background: #3B82F6;">
                                    {{ strtoupper(substr($rev->name, 0, 1)) }}
                                </div>
                                <div class="text-truncate">
                                    <div class="fw-bold text-dark font-12 text-truncate">{{ $rev->name }}</div>
                                    <div class="text-muted font-11 text-truncate">{{ $rev->email ?: ($rev->user?->email ?: 'Student') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border font-11 fw-semibold py-1 px-2 rounded">
                                <i class="fa-solid fa-graduation-cap text-primary me-1"></i>
                                {{ $rev->course?->title ?? 'Unknown Course' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-bold text-dark font-12">{{ $rev->rating }}.0</span>
                                <div class="text-warning font-12">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $rev->rating ? 'text-warning' : 'text-muted text-opacity-25' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-12 text-dark" style="max-width: 480px; line-height: 1.45;">
                                "{{ $rev->comment }}"
                            </div>
                        </td>
                        <td>
                            <span class="font-11 text-muted">{{ $rev->created_at ? $rev->created_at->format('M d, Y') : '—' }}</span>
                        </td>
                        <td>
                            @if($rev->status === 'approved')
                                <span class="adm-badge adm-badge-success">Approved</span>
                            @else
                                <span class="adm-badge text-danger" style="background: rgba(239, 68, 68, 0.1);">Rejected</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex align-items-center gap-1">
                                <form method="POST" action="{{ route('admin.reviews.toggle', $rev->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-icon-btn" title="{{ $rev->status === 'approved' ? 'Hide Review' : 'Approve Review' }}">
                                        <i class="fa-solid {{ $rev->status === 'approved' ? 'fa-eye-slash text-warning' : 'fa-check text-success' }}"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.reviews.delete', $rev->id) }}" class="d-inline" onsubmit="return confirm('Delete this review permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-icon-btn danger" title="Delete Review">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
        <div class="p-3 border-top d-flex justify-content-between align-items-center">
            <span class="font-11 text-muted">Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews</span>
            {{ $reviews->links() }}
        </div>
        @endif
    @endif
</div>
@endsection
