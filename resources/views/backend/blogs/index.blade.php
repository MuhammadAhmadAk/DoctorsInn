@extends('backend.layouts.master')

@section('title', 'Blog & Articles Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Blog &amp; Medical Insights</h1>
        <p class="page-subtitle">Publish MDCAT preparation guides, high-yield subject tips, syllabus news, and doctor interviews.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('blog') }}" target="_blank" class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>View Public Blog</span>
        </a>
        <button type="button" class="btn-adm btn-adm-primary" onclick="document.getElementById('blogFormCard').classList.toggle('d-none')">
            <i class="fa-solid fa-pen-nib"></i>
            <span>Write New Article</span>
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Quick Write / Edit Article Drawer Card -->
<div class="adm-card mb-4 d-none" id="blogFormCard">
    <div class="adm-card-header">
        <h2 class="adm-card-title"><i class="fa-solid fa-pen-nib text-primary"></i> Publish / Edit Blog Article</h2>
    </div>
    <div class="adm-card-body">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Article Title</label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. How to Score 185+ in MDCAT 2026">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Category</label>
                    <input type="text" name="category" class="form-control" value="MDCAT Preparation" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Read Time</label>
                    <input type="text" name="read_time" class="form-control" value="5 min read">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Cover Image</label>
                    <input type="file" name="image_file" accept="image/*" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Short Summary</label>
                    <input type="text" name="short_description" class="form-control" placeholder="Brief summary for blog cards...">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Article Content (HTML or plain text)</label>
                    <textarea name="content" rows="4" class="form-control" placeholder="<p>Full article content...</p>"></textarea>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn-adm btn-adm-primary">
                        <i class="fa-solid fa-paper-plane"></i> Publish Article Live
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-newspaper text-primary"></i>
            Published Articles ({{ count($blogs) }})
        </h2>
        <span class="adm-badge adm-badge-success">Database Synced</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Article Details</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Read Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $slug => $b)
                <tr>
                    <td>
                        <div class="item-thumb-box">
                            <img src="{{ asset($b['image'] ?? 'frontend/img/blog/blog_1_1.jpg') }}" alt="Post Thumb">
                            <div>
                                <a href="{{ route('blog-details', $slug) }}" target="_blank" class="title text-decoration-none hover-primary">
                                    {{ Str::limit($b['title'] ?? 'Blog Title', 45) }}
                                </a>
                                <div class="subtitle">{{ Str::limit($b['short_description'] ?? 'Article excerpt...', 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-primary">{{ $b['category'] ?? 'Preparation' }}</span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ is_array($b['author'] ?? null) ? ($b['author']['name'] ?? 'Faculty') : ($b['author'] ?? 'Faculty') }}</div>
                        <div class="small text-muted">{{ ($b['date_day'] ?? '') . ' ' . ($b['date_month'] ?? '') . ' ' . ($b['date_year'] ?? '') }}</div>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">{{ $b['read_time'] ?? '5 min' }}</span>
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-success">Published</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('blog-details', $slug) }}" target="_blank" class="action-btn" title="View Article">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                            <form action="{{ route('admin.blogs.delete', $slug) }}" method="POST" onsubmit="return confirm('Delete this article?')">
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
