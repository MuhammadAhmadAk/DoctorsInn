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
        <button type="button" class="btn-adm btn-adm-primary" onclick="document.getElementById('elibraryFormCard').classList.toggle('d-none')">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <span>Upload Resource</span>
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="adm-card mb-4 d-none" id="elibraryFormCard">
    <div class="adm-card-header">
        <h2 class="adm-card-title"><i class="fa-solid fa-book-medical text-primary"></i> Add E-Library Resource</h2>
    </div>
    <div class="adm-card-body">
        <form action="{{ route('admin.elibrary.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-bold">Resource Title</label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. Chemistry Formula Handbook">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Category</label>
                    <select name="category" class="form-select">
                        <option value="mdcat">MDCAT</option>
                        <option value="nums">NUMS</option>
                        <option value="army">Army / AMC</option>
                        <option value="past-papers">Past Papers</option>
                        <option value="notes">Short Notes</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Subject</label>
                    <input type="text" name="subject" class="form-control" value="All Subjects">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Size</label>
                    <input type="text" name="size" class="form-control" value="4.2 MB">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Description</label>
                    <input type="text" name="description" class="form-control" placeholder="Brief overview of PDF study guide...">
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn-adm btn-adm-primary"><i class="fa-solid fa-floppy-disk"></i> Save Resource</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- E-Library Summary Table -->
<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-book-bookmark text-primary"></i>
            Resource Catalog ({{ count($resources) }})
        </h2>
        <span class="adm-badge adm-badge-primary">Database Synced</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Resource Details</th>
                    <th>Category</th>
                    <th>File Format &amp; Size</th>
                    <th>Total Downloads</th>
                    <th>Access Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $res)
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
                        <span class="adm-badge adm-badge-warning text-uppercase">{{ $res['category_name'] ?? ($res['category'] ?? 'Notes') }}</span>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">{{ $res['size'] ?? ($res['file_size'] ?? '4.2 MB') }}</span>
                        <div class="small text-muted">{{ $res['pages'] ?? '85 Pages' }} • PDF</div>
                    </td>
                    <td>
                        <span class="fw-bold text-primary">{{ $res['downloads'] ?? ($res['downloads_count'] ?? '2.5k+') }}</span>
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
                            <form action="{{ route('admin.elibrary.delete', $res['slug'] ?? 'resource') }}" method="POST" onsubmit="return confirm('Delete this resource?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
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
