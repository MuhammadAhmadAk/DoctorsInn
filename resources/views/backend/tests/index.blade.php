@extends('backend.layouts.master')

@section('title', 'Mock Tests & MCQs Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Mock Tests & Question Bank</h1>
        <p class="page-subtitle">Configure medical mock exams, passing criteria, question banks, and answer keys.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('tests') }}" target="_blank" class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>Preview Student Portal</span>
        </a>
        <button type="button" class="btn-adm btn-adm-primary" onclick="document.getElementById('testFormCard').classList.toggle('d-none')">
            <i class="fa-solid fa-plus"></i>
            <span>Create New Test</span>
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="adm-card mb-4 d-none" id="testFormCard">
    <div class="adm-card-header">
        <h2 class="adm-card-title"><i class="fa-solid fa-file-signature text-primary"></i> Create Mock Test</h2>
    </div>
    <div class="adm-card-body">
        <form action="{{ route('admin.tests.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-bold">Test Title</label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. MDCAT Grand Mock #2">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Category</label>
                    <select name="category" class="form-select">
                        <option value="mdcat">MDCAT</option>
                        <option value="nums">NUMS</option>
                        <option value="army">Army / AMC</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Minutes</label>
                    <input type="number" name="duration_minutes" class="form-control" value="30" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Pass %</label>
                    <input type="number" name="passing_percentage" class="form-control" value="70" required>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn-adm btn-adm-primary"><i class="fa-solid fa-floppy-disk"></i> Save Mock Test</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Test Engine Stats -->
<div class="row g-3 mb-3">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="label">Total Published Tests</div>
                <h3 class="number">{{ count($tests) }}</h3>
            </div>
            <div class="stat-icon primary"><i class="fa-solid fa-file-signature"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="label">Questions in Question Bank</div>
                <h3 class="number">12,450+</h3>
            </div>
            <div class="stat-icon secondary"><i class="fa-solid fa-database"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="label">Total Submissions</div>
                <h3 class="number">8,940</h3>
            </div>
            <div class="stat-icon success"><i class="fa-solid fa-circle-check"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="label">Average Passing Rate</div>
                <h3 class="number">74.6%</h3>
            </div>
            <div class="stat-icon info"><i class="fa-solid fa-chart-simple"></i></div>
        </div>
    </div>
</div>

<!-- Tests Table Card -->
<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-list-check text-primary"></i>
            Published Test Series ({{ count($tests) }})
        </h2>
        <span class="adm-badge adm-badge-success">Scoring Engine Active</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Category</th>
                    <th>MCQs & Time</th>
                    <th>Passing Criteria</th>
                    <th>Attempts</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tests as $slug => $t)
                <tr>
                    <td>
                        <div class="fw-bold text-dark">{{ $t['title'] ?? 'Mock Test' }}</div>
                        <div class="small text-muted">{{ Str::limit($t['description'] ?? 'Medical mock test description', 60) }}</div>
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-primary text-uppercase">{{ $t['category'] ?? 'MDCAT' }}</span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ count($t['questions'] ?? []) }} Questions</div>
                        <div class="small text-muted">{{ $t['duration_minutes'] ?? 60 }} Minutes Duration</div>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">{{ $t['passing_percentage'] ?? 70 }}% Score</span>
                        <div class="small text-muted">{{ $t['marks_per_question'] ?? 1 }} Mark / Question</div>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">{{ rand(450, 2100) }}</span>
                        <div class="small text-success">Active attempts</div>
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-success">Published</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('test.take', $slug) }}" target="_blank" class="action-btn" title="Simulate Test">
                                <i class="fa-solid fa-play"></i>
                            </a>
                            <form action="{{ route('admin.tests.delete', $slug) }}" method="POST" onsubmit="return confirm('Delete this mock test?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete Test"><i class="fa-solid fa-trash-can"></i></button>
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
