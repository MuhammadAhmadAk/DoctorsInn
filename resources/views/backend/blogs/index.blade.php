@extends('backend.layouts.master')

@section('title', 'Blog & Articles Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Blog & Medical Insights</h1>
        <p class="page-subtitle">Publish MDCAT preparation guides, high-yield subject tips, syllabus news, and doctor interviews.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('blog') }}" target="_blank" class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>View Public Blog</span>
        </a>
        <button class="btn-adm btn-adm-primary" onclick="alert('Article Editor initialized!')">
            <i class="fa-solid fa-pen-nib"></i>
            <span>Write New Article</span>
        </button>
    </div>
</div>

<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-newspaper text-primary"></i>
            Published Articles ({{ count(config('blogs', [])) }})
        </h2>
        <span class="adm-badge adm-badge-success">SEO Synced</span>
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
                @foreach(config('blogs', []) as $slug => $b)
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
                            <a href="#" class="action-btn" title="Edit Article" onclick="alert('Editing {{ $slug }}')">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="action-btn delete" title="Delete" onclick="confirm('Delete article?')">
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
