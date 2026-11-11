@extends('backend.layouts.master')

@section('title', 'Courses Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Courses & Prep Batches</h1>
        <p class="page-subtitle">Manage curriculum, pricing, faculty assignment, and enrolled batches.</p>
    </div>
    <div class="page-actions">
        <button class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-file-arrow-down"></i>
            <span>Export CSV</span>
        </button>
        <a href="{{ route('admin.courses.create') }}" class="btn-adm btn-adm-primary">
            <i class="fa-solid fa-plus"></i>
            <span>Create New Course</span>
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Courses Summary Filter Row -->
<div class="adm-card mb-4">
    <div class="adm-card-body py-3">
        <div class="row align-items-center g-3">
            <div class="col-md-5">
                <div class="nav-search w-100">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="courseSearchInput" placeholder="Filter courses by name or subject...">
                </div>
            </div>
            <div class="col-md-7 d-flex justify-content-md-end gap-2 flex-wrap">
                <button type="button" class="btn-adm btn-adm-primary py-2 px-3 font-12 course-cat-filter active" data-cat="all">All ({{ count($courses) }})</button>
                <button type="button" class="btn-adm btn-adm-outline py-2 px-3 font-12 course-cat-filter" data-cat="mdcat">MDCAT</button>
                <button type="button" class="btn-adm btn-adm-outline py-2 px-3 font-12 course-cat-filter" data-cat="nums">NUMS</button>
                <button type="button" class="btn-adm btn-adm-outline py-2 px-3 font-12 course-cat-filter" data-cat="amc">Army / AMC</button>
            </div>
        </div>
    </div>
</div>

<!-- Courses Table Card -->
<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-graduation-cap text-primary"></i>
            Active Course Catalog ({{ count($courses) }})
        </h2>
        <span class="adm-badge adm-badge-success">Database Synced</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table" id="coursesAdminTable">
            <thead>
                <tr>
                    <th>Course Details</th>
                    <th>Category</th>
                    <th>Duration & Tests</th>
                    <th>Enrollment</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $slug => $c)
                <tr>
                    <td>
                        <div class="item-thumb-box">
                            <img src="{{ asset($c['image'] ?? ($c['thumbnail'] ?? 'frontend/img/course/course1-1.jpg')) }}" alt="Course">
                            <div>
                                <a href="{{ route('course-details', $slug) }}" target="_blank" class="title text-decoration-none hover-primary">
                                    {{ $c['title'] ?? 'Course Title' }}
                                </a>
                                <div class="subtitle">Instructor: {{ $c['instructor'] ?? 'Dr. Expert Faculty' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-primary">{{ $c['category_name'] ?? strtoupper($c['category'] ?? 'MDCAT') }}</span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $c['duration'] ?? '10 Weeks' }}</div>
                        <div class="small text-muted">{{ $c['lessons'] ?? ($c['lectures_count'] ?? '60+ Lectures') }}</div>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">{{ $c['students'] ?? '500+ Students' }}</span>
                        <div class="small text-success"><i class="fa-solid fa-circle font-8"></i> Active</div>
                    </td>
                    <td>
                        <span class="fw-bold text-primary">{{ $c['price'] ?? 'Rs. 15,000' }}</span>
                        @if(!empty($c['original_price']))
                        <div class="small text-muted text-decoration-line-through">{{ $c['original_price'] }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-success">Live</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('course-details', $slug) }}" target="_blank" class="action-btn" title="View Public Page">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                            <form action="{{ route('admin.courses.delete', $slug) }}" method="POST" onsubmit="return confirm('Delete this course from live site?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete Course">
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
</div>
@endsection

@section('extra_js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('coursesAdminTable');
    const searchInput = document.getElementById('courseSearchInput');
    const filterButtons = document.querySelectorAll('.course-cat-filter');
    let activeCat = 'all';

    function applyCourseFilters() {
        if (!table || !table._admRows) return;
        const query = (searchInput ? searchInput.value : '').trim().toLowerCase();

        table._admRows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            const matchesSearch = !query || text.includes(query);
            const matchesCat = activeCat === 'all' || text.includes(activeCat);
            row.dataset.admFilteredOut = (matchesSearch && matchesCat) ? 'false' : 'true';
        });

        if (typeof table._admPaginate === 'function') {
            table._admPaginate(1);
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyCourseFilters);
    }

    filterButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterButtons.forEach(function (b) {
                b.classList.remove('btn-adm-primary', 'active');
                b.classList.add('btn-adm-outline');
            });
            btn.classList.remove('btn-adm-outline');
            btn.classList.add('btn-adm-primary', 'active');
            activeCat = btn.getAttribute('data-cat') || 'all';
            applyCourseFilters();
        });
    });
});
</script>
@endsection
