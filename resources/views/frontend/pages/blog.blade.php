@extends('frontend.layouts.main')
@section('title', 'Medical Entry Test Blog & Insights | DoctorsInnElite')
@section('meta_description', 'Read expert preparation guides, study tips, syllabus updates, and success strategies for MDCAT, NUMS, and AMC by DoctorsInnElite.')
@section('meta_keywords', 'MDCAT blog, NUMS prep tips, AMC intelligence test guide, medical entry test Pakistan, DoctorsInn articles')
@section('content')

    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Our Blog & Articles</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            @if (!empty($selectedCategory))
                                <li><a href="{{ route('blog') }}">Blog</a></li>
                                <li>{{ $selectedCategory }}</li>
                            @elseif(!empty($selectedTag))
                                <li><a href="{{ route('blog') }}">Blog</a></li>
                                <li>#{{ $selectedTag }}</li>
                            @else
                                <li>Blog</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="space-top space-extra-bottom" id="blog-sec">
        <div class="container">

            {{-- Active Filter Notification --}}
            @if (!empty($selectedCategory) || !empty($selectedTag) || !empty($searchQuery))
                <div class="alert alert-light border d-flex justify-content-between align-items-center mb-40 p-3"
                    class="blog-filter-bar p-3 mb-40">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-filter text-theme"></i>
                        <span>
                            Showing results for:
                            @if (!empty($selectedCategory))
                                <strong>Category: {{ $selectedCategory }}</strong>
                            @endif
                            @if (!empty($selectedTag))
                                <strong>Tag: #{{ $selectedTag }}</strong>
                            @endif
                            @if (!empty($searchQuery))
                                <strong>Search: "{{ $searchQuery }}"</strong>
                            @endif
                            ({{ count($blogs) }} {{ Str::plural('article', count($blogs)) }} found)
                        </span>
                    </div>
                    <a href="{{ route('blog') }}" class="btn btn-sm btn-outline-danger blog-reset-filter-btn">
                        <i class="fal fa-times me-1"></i> Clear Filter
                    </a>
                </div>
            @endif

            <div class="row gy-40">
                @forelse ($blogs as $blog)
                    <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".2">
                        <div class="modern-blog-card">
                            <div class="blog-img">
                                <a href="{{ route('blog-details', $blog['slug']) }}">
                                    <img src="{{ url($blog['image']) }}" alt="{{ $blog['title'] }}" loading="lazy" decoding="async">
                                </a>
                                <div class="blog-date-badge">
                                    <span class="date-day">{{ $blog['date_day'] }}</span>
                                    <span class="date-my">
                                        <span>{{ $blog['date_month'] }}</span>
                                        <span>{{ $blog['date_year'] }}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta-wrapper">
                                    <a href="{{ route('blog', ['category' => $blog['category']]) }}" class="blog-meta-pill">
                                        <i class="fal fa-folder-open"></i>{{ $blog['category'] }}
                                    </a>
                                    @if (!empty($blog['read_time']))
                                        <span class="blog-meta-pill">
                                            <i class="fal fa-clock"></i>{{ $blog['read_time'] }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="box-title">
                                    <a href="{{ route('blog-details', $blog['slug']) }}" title="{{ $blog['title'] }}">
                                        {{ $blog['title'] }}
                                    </a>
                                </h3>
                                <p class="blog-text">
                                    {{ $blog['short_description'] }}
                                </p>
                                <div class="mt-auto pt-2">
                                    <a href="{{ route('blog-details', $blog['slug']) }}" class="blog-read-more-btn">
                                        READ MORE
                                        <svg width="14" height="12" viewbox="0 0 16 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                                stroke="currentColor" stroke-width="1.8"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="blog-empty-state-box">
                            <div class="mb-3 text-muted blog-empty-icon">
                                <i class="fal fa-file-search"></i>
                            </div>
                            <h3 class="h4">No Articles Found</h3>
                            <p class="text-muted">No blog posts match your current search or filter criteria. Try searching
                                for something else or browse all posts.</p>
                            <a href="{{ route('blog') }}" class="th-btn btn-sm mt-3">View All Articles</a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if (count($blogs) > 0)
                <div class="text-center mt-60">
                    <p class="text-muted blog-empty-hint">
                        Showing {{ count($blogs) }} {{ Str::plural('article', count($blogs)) }} from DoctorsInn Knowledge
                        Base
                    </p>
                </div>
            @endif

        </div>
    </section>

@endsection
