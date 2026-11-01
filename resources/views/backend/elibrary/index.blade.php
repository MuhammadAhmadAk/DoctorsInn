@extends('backend.layouts.master')

@section('title', 'E-Library Vault Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">E-Library Vault Management</h1>
        <p class="page-subtitle">Manage medical study guides, PMDC syllabus books, solved past papers, and formula summaries.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('e-library') }}" target="_blank" class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>View Public Library</span>
        </a>
        <button class="btn-adm btn-adm-primary" onclick="alert('Upload PDF Drawer ready!')">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <span>Upload Resource</span>
        </button>
    </div>
</div>

<!-- E-Library Summary Table -->
<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-book-bookmark text-primary"></i>
            Resource Catalog ({{ count(config('elibrary.resources', [])) }})
        </h2>
        <span class="adm-badge adm-badge-primary">Auto PDF Stream Enabled</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Resource Details</th>
                    <th>Category</th>
                    <th>File Format & Size</th>
                    <th>Total Downloads</th>
                    <th>Access Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach(config('elibrary.resources', []) as $res)
                <tr>
                    <td>
                        <div class="item-thumb-box">
                            <div class="stat-icon info" style="width: 42px; height: 42px; font-size: 18px;">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div>
                                <div class="title">{{ $res['title'] ?? 'Resource Title' }}</div>
                                <div class="subtitle">{{ Str::limit($res['description'] ?? 'Study guide', 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-warning text-uppercase">{{ $res['category'] ?? 'Notes' }}</span>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">{{ $res['file_size'] ?? '4.2 MB' }}</span>
                        <div class="small text-muted">{{ $res['pages'] ?? '85' }} Pages • PDF</div>
                    </td>
                    <td>
                        <span class="fw-bold text-primary">{{ $res['downloads_count'] ?? rand(500, 4800) }}</span>
                        <div class="small text-success"><i class="fa-solid fa-arrow-up"></i> Popular</div>
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-success">Free Student Access</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('e-library.download', $res['slug'] ?? 'resource') }}" class="action-btn" title="Direct Download Stream">
                                <i class="fa-solid fa-download"></i>
                            </a>
                            <a href="#" class="action-btn" title="Edit Resource" onclick="alert('Editing {{ $res['slug'] }}')">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="action-btn delete" title="Delete" onclick="confirm('Delete resource?')">
                                <i class="fa-solid fa-trash-can"></i>
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
