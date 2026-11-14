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
            <span>Courses Studio</span>
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- KPI Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon primary"><i class="fa-solid fa-comments"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($totalReviews) }}</div>
                    <div class="small text-muted">Total Reviews</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon success"><i class="fa-solid fa-circle-check"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($approvedReviews) }}</div>
                    <div class="small text-muted">Approved Live</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon warning"><i class="fa-solid fa-star"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($overallAvgRating, 1) }} / 5.0</div>
                    <div class="small text-muted">Avg Overall Rating</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="adm-card h-100">
            <div class="adm-card-body d-flex align-items-center gap-3">
                <div class="stat-icon info"><i class="fa-solid fa-award"></i></div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 20px;">{{ number_format($fiveStarCount) }}</div>
                    <div class="small text-muted">5-Star Ratings</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Courses Breakdown Row -->
<div class="adm-card mb-4">
    <div class="adm-card-body py-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2.5">
            <div class="fw-semibold text-dark font-12 d-flex align-items-center gap-2">
                <i class="fa-solid fa-layer-group text-primary"></i>
                <span>Filter by Course</span>
            </div>
            <span class="small text-muted">{{ $courses->count() }} Total Courses</span>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('admin.reviews', ['status' => $selectedStatus, 'q' => $searchQuery]) }}"
               class="btn-adm {{ empty($selectedCourseId) ? 'btn-adm-primary' : 'btn-adm-outline' }} py-1 px-3 font-12 d-inline-flex align-items-center gap-1.5 text-decoration-none">
                <span>All Courses</span>
                <span class="adm-badge {{ empty($selectedCourseId) ? 'adm-badge-light text-dark' : 'adm-badge-primary' }} px-1.5 py-0 font-10">
                    {{ $totalReviews }}
                </span>
            </a>
            @foreach($courses as $c)
            <a href="{{ route('admin.reviews', ['course_id' => $c->id, 'status' => $selectedStatus, 'q' => $searchQuery]) }}"
               class="btn-adm {{ (string)$selectedCourseId === (string)$c->id ? 'btn-adm-primary' : 'btn-adm-outline' }} py-1 px-3 font-12 d-inline-flex align-items-center gap-1.5 text-decoration-none">
                <span>{{ $c->title }}</span>
                <span class="adm-badge {{ (string)$selectedCourseId === (string)$c->id ? 'adm-badge-light text-dark' : 'adm-badge-primary' }} px-1.5 py-0 font-10">
                    {{ $c->approved_reviews_count ?? 0 }}
                </span>
                @if(!empty($c->avg_rating))
                    <span class="text-warning font-10">★ {{ number_format($c->avg_rating, 1) }}</span>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Search & Filters -->
<div class="adm-card mb-4">
    <div class="adm-card-body py-3">
        <form method="GET" action="{{ route('admin.reviews') }}" class="row align-items-center g-2">
            @if($selectedCourseId)
                <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">
            @endif
            <div class="col-md-8">
                <div class="nav-search w-100">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Search by student name, email, or review text...">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-2">
                <button type="submit" class="btn-adm btn-adm-primary py-1 px-3 font-12">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                @if($searchQuery || $selectedCourseId)
                    <a href="{{ route('admin.reviews') }}" class="btn-adm btn-adm-outline py-1 px-3 font-12" title="Reset all filters">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
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
            <i class="fa-solid fa-comments text-primary"></i>
            <span>Student Reviews ({{ $reviews->total() }})</span>
        </h2>
        @if($selectedCourseId)
            @php $filteredCourse = $courses->firstWhere('id', $selectedCourseId); @endphp
            @if($filteredCourse)
                <span class="adm-badge adm-badge-primary">Course: {{ $filteredCourse->title }}</span>
            @endif
        @endif
    </div>

    @if($reviews->isEmpty())
        <div class="text-center py-5">
            <i class="fa-regular fa-comment-dots text-muted font-32 mb-2"></i>
            <div class="fw-bold text-dark font-14">No Reviews Found</div>
            <p class="text-muted font-12 mb-0">No student reviews match the active filter criteria.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th style="min-width: 220px;">Student</th>
                        <th style="min-width: 160px;">Course</th>
                        <th style="min-width: 130px;">Rating</th>
                        <th style="min-width: 320px;">Review Feedback</th>
                        <th style="min-width: 120px;">Date</th>
                        <th style="min-width: 80px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $rev)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold font-12 flex-shrink-0"
                                     style="width: 34px; height: 34px; background: var(--adm-primary); box-shadow: 0 2px 6px rgba(92, 50, 255, 0.25);">
                                    {{ strtoupper(substr($rev->name, 0, 1)) }}
                                </div>
                                <div class="text-truncate">
                                    <div class="fw-bold text-dark font-12 text-truncate">{{ $rev->name }}</div>
                                    <div class="small text-muted text-truncate">{{ $rev->email ?: ($rev->user?->email ?: 'Student') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="adm-badge adm-badge-primary font-11">
                                <i class="fa-solid fa-graduation-cap me-1"></i>
                                {{ $rev->course?->title ?? 'Unknown Course' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-bold text-dark font-12">{{ $rev->rating }}.0</span>
                                <div class="text-warning font-11">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $rev->rating ? 'text-warning' : 'text-muted text-opacity-25' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-12 text-dark" style="max-width: 520px; line-height: 1.5;">
                                {{ $rev->comment }}
                            </div>
                        </td>
                        <td>
                            <span class="font-11 text-muted">{{ $rev->created_at ? $rev->created_at->format('M d, Y') : '—' }}</span>
                        </td>
                        <td class="text-end">
                            <div class="table-actions justify-content-end">
                                <form method="POST" action="{{ route('admin.reviews.delete', $rev->id) }}" class="d-inline" onsubmit="return confirm('Permanently delete this student review?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Delete Review">
                                        <i class="fa-solid fa-trash-can"></i>
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
        <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="small text-muted">Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews</span>
            {{ $reviews->links() }}
        </div>
        @endif
    @endif
</div>
@endsection
