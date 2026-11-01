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
        <button class="btn-adm btn-adm-primary" onclick="alert('MCQ Creator modal ready for question entries!')">
            <i class="fa-solid fa-plus"></i>
            <span>Create New Test</span>
        </button>
    </div>
</div>

<!-- Test Engine Stats -->
<div class="row g-3 mb-3">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="label">Total Published Tests</div>
                <h3 class="number">{{ count(config('tests.tests', [])) }}</h3>
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
            Published Test Series ({{ count(config('tests.tests', [])) }})
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
                @foreach(config('tests.tests', []) as $slug => $t)
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
                            <a href="#" class="action-btn" title="Manage MCQs" onclick="alert('Managing MCQs for {{ $slug }}')">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="action-btn" title="Analytics" onclick="alert('Viewing score analytics for {{ $slug }}')">
                                <i class="fa-solid fa-chart-pie"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
