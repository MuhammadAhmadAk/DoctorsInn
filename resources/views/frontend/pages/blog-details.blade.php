@extends('frontend.layouts.main')
@section('title', $blog['title'] . ' | DoctorsInnElite')
@section('meta_description', Str::limit(strip_tags($blog['short_description'] ?? ''), 160))
@section('meta_keywords', implode(', ', $blog['tags'] ?? ['MDCAT', 'NUMS', 'DoctorsInn']))
@section('content')

    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title blog-details-breadcumb-title">{{ $blog['title'] }}</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                            <li>Article</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="th-blog-wrapper blog-details space-top space-extra-bottom">
        <div class="container">
            <div class="row gx-40">

                {{-- Left Content Area --}}
                <div class="col-xxl-8 col-lg-7">
                    <div class="th-blog blog-single">

                        {{-- Blog Featured Image --}}
                        <div class="blog-img">
                            <img src="{{ url($blog['detail_image'] ?? $blog['image']) }}" alt="{{ $blog['title'] }}"
                                class="blog-details-banner-img">
                            <a class="blog-date" href="javascript:void(0)">
                                {{ $blog['date_day'] }}
                                <span class="year">{{ $blog['date_month'] }}, {{ $blog['date_year'] }}</span>
                            </a>
                        </div>

                        {{-- Blog Content --}}
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="{{ route('blog', ['category' => $blog['category']]) }}">
                                    <i class="fal fa-folder me-1"></i>{{ $blog['category'] }}
                                </a>
                                @if (!empty($blog['read_time']))
                                    <a href="javascript:void(0)">
                                        <i class="fal fa-clock me-1"></i>{{ $blog['read_time'] }}
                                    </a>
                                @endif
                                @if (!empty($blog['author']['name']))
                                    <a href="javascript:void(0)">
                                        <i class="fal fa-user me-1"></i>{{ $blog['author']['name'] }}
                                    </a>
                                @endif
                            </div>

                            <h2 class="blog-title blog-details-main-title">
                                {{ $blog['title'] }}
                            </h2>

                            @if (!empty($blog['content']) && is_array($blog['content']))
                                @foreach ($blog['content'] as $index => $paragraph)
                                    <p class="blog-details-lead-para">
                                        {{ $paragraph }}
                                    </p>

                                    {{-- Inject Blockquote after paragraph 1 if available --}}
                                    @if ($index === 1 && !empty($blog['quote']))
                                        <blockquote class="blog-details-quote">
                                            <p class="blog-details-quote-text">
                                                "{{ $blog['quote']['text'] }}"
                                            </p>
                                            <cite>{{ $blog['quote']['cite'] }}</cite>
                                        </blockquote>
                                    @endif
                                @endforeach
                            @endif

                            {{-- Inner Images Gallery --}}
                            @if (!empty($blog['inner_images']) && count($blog['inner_images']) >= 2)
                                <div class="row gx-30 mt-35 mb-20">
                                    <div class="col-md-6 mb-30">
                                        <div class="blog-radius-img overflow-hidden blog-radius-img-wrapper">
                                            <img class="w-100" src="{{ url($blog['inner_images'][0]) }}"
                                                alt="{{ $blog['title'] }}"
                                                class="blog-gallery-thumb">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-30">
                                        <div class="blog-radius-img overflow-hidden blog-radius-img-wrapper">
                                            <img class="w-100" src="{{ url($blog['inner_images'][1]) }}"
                                                alt="{{ $blog['title'] }}"
                                                class="blog-gallery-thumb">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Tags & Social Sharing --}}
                            <div class="share-links clearfix mt-40">
                                <div class="row justify-content-between align-items-center gy-3">
                                    <div class="col-md-auto">
                                        <span class="share-links-title">Tags:</span>
                                        <div class="tagcloud">
                                            @foreach ($blog['tags'] ?? [] as $tag)
                                                <a href="{{ route('blog', ['tag' => $tag]) }}">#{{ $tag }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-auto text-xl-end">
                                        <span class="share-links-title">Share Article:</span>
                                        <div class="th-social style3 align-items-center">
                                            <a href="https://api.whatsapp.com/send?text={{ urlencode($blog['title'] . ' ' . url()->current()) }}"
                                                target="_blank" title="Share on WhatsApp"><i
                                                    class="fab fa-whatsapp"></i></a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                                target="_blank" title="Share on Facebook"><i
                                                    class="fab fa-facebook-f"></i></a>
                                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog['title']) }}&url={{ urlencode(url()->current()) }}"
                                                target="_blank" title="Share on X / Twitter"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                                target="_blank" title="Share on LinkedIn"><i
                                                    class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Next & Previous Post Navigation --}}
                    <div class="blog-navigation my-40">
                        @if ($prevBlog)
                            <a href="{{ route('blog-details', $prevBlog['slug']) }}" class="nav-btn prev">
                                <img src="{{ url($prevBlog['image']) }}" alt="{{ $prevBlog['title'] }}" class="nav-img">
                                <span class="nav-text">
                                    <span class="nav-label"><i class="fal fa-arrow-left me-1"></i> Previous Post</span>
                                    <span class="nav-title" title="{{ $prevBlog['title'] }}">{{ $prevBlog['title'] }}</span>
                                </span>
                            </a>
                        @endif

                        <a href="{{ route('blog') }}" class="blog-btn" title="View All Articles">
                            <i class="fas fa-grid-2"></i>
                        </a>

                        @if ($nextBlog)
                            <a href="{{ route('blog-details', $nextBlog['slug']) }}" class="nav-btn next">
                                <span class="nav-text text-end">
                                    <span class="nav-label">Next Post <i class="fal fa-arrow-right ms-1"></i></span>
                                    <span class="nav-title" title="{{ $nextBlog['title'] }}">{{ $nextBlog['title'] }}</span>
                                </span>
                                <img src="{{ url($nextBlog['image']) }}" alt="{{ $nextBlog['title'] }}" class="nav-img">
                            </a>
                        @endif
                    </div>

                    {{-- Author Bio Card --}}
                    @if (!empty($blog['author']))
                        <div class="blog-author my-40">
                            <div class="author-img">
                                <img src="{{ url($blog['author']['image']) }}" alt="{{ $blog['author']['name'] }}">
                            </div>
                            <div class="media-body">
                                <div class="author-header">
                                    <h3 class="author-name">{{ $blog['author']['name'] }}</h3>
                                    <span class="author-desig">{{ $blog['author']['designation'] }}</span>
                                </div>
                                <p class="author-text">
                                    {{ $blog['author']['bio'] }}
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Comments Section --}}
                    @php
                        $comments = $blog['comments'] ?? [];
                        $totalComments = 0;
                        foreach ($comments as $c) {
                            $totalComments++;
                            if (!empty($c['replies'])) {
                                $totalComments += count($c['replies']);
                            }
                        }
                    @endphp

                    <div class="th-comments-wrap mb-40">
                        <h2 class="blog-inner-title h4">
                            Comments ({{ sprintf('%02d', $totalComments) }})
                        </h2>

                        @if (!empty($comments))
                            <ul class="comment-list">
                                @foreach ($comments as $comment)
                                    <li class="th-comment-item">
                                        <div class="th-post-comment">
                                            <div class="comment-avater">
                                                <img src="{{ url($comment['avatar']) }}" alt="{{ $comment['name'] }}"
                                                    class="blog-author-avatar">
                                            </div>
                                            <div class="comment-content">
                                                <h3 class="name">{{ $comment['name'] }}</h3>
                                                <span class="commented-on">
                                                    {{ $comment['date'] }}
                                                    <span class="ms-2">{{ $comment['time'] }}</span>
                                                </span>
                                                <p class="text">{{ $comment['text'] }}</p>
                                                <div class="reply_and_edit">
                                                    <a href="#comment-form-sec" class="reply-btn">
                                                        <i class="fas fa-reply"></i>Reply
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Nested Replies --}}
                                        @if (!empty($comment['replies']))
                                            <ul class="children">
                                                @foreach ($comment['replies'] as $reply)
                                                    <li class="th-comment-item">
                                                        <div class="th-post-comment">
                                                            <div class="comment-avater">
                                                                <img src="{{ url($reply['avatar']) }}"
                                                                    alt="{{ $reply['name'] }}"
                                                                    class="blog-comment-avatar">
                                                            </div>
                                                            <div class="comment-content">
                                                                <h3 class="name">{{ $reply['name'] }}</h3>
                                                                <span class="commented-on">
                                                                    {{ $reply['date'] }}
                                                                    <span class="ms-2">{{ $reply['time'] }}</span>
                                                                </span>
                                                                <p class="text">{{ $reply['text'] }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No comments yet. Be the first to share your thoughts!</p>
                        @endif
                    </div>

                    {{-- Leave a Reply Form --}}
                    <div class="th-comment-form" id="comment-form-sec">
                        <div class="form-title">
                            <h3 class="blog-inner-title h4 mb-2">Leave A Reply</h3>
                            <p class="form-text">Your email address will not be published. Required fields are marked *</p>
                        </div>
                        <form action="javascript:void(0)" id="blogCommentForm">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" placeholder="Your Name *" class="form-control" required>
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="email" placeholder="Your Email *" class="form-control" required>
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="col-12 form-group">
                                    <textarea placeholder="Write Your Message *" class="form-control" rows="4" required></textarea>
                                    <i class="far fa-pen"></i>
                                </div>
                                <div class="col-12 form-group mb-0">
                                    <button type="submit" class="th-btn">
                                        POST COMMENT
                                        <svg class="ms-2" width="16" height="16" viewbox="0 0 16 16"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.0331 2.03512C12.5811 0.471411 1.65895 4.30197 1.66797 5.7005C1.6782 7.28644 5.93336 7.7743 7.11277 8.10524C7.82203 8.30417 8.01197 8.50817 8.1755 9.2519C8.91617 12.6202 9.28803 14.2955 10.1356 14.3329C11.4865 14.3926 15.4502 3.56117 14.0331 2.03512Z"
                                                fill="transparent" stroke="currentColor" stroke-width="1.5"></path>
                                            <path d="M7.66797 8.33333L10.0013 6" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                {{-- Right Sidebar --}}
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">

                        {{-- Search Widget --}}
                        <div class="widget widget_search">
                            <form class="search-form" action="{{ route('blog') }}" method="GET">
                                <input type="text" name="search" placeholder="Search Articles..." required>
                                <button type="submit"><i class="fal fa-search"></i></button>
                            </form>
                        </div>

                        {{-- Categories Widget --}}
                        <div class="widget widget_categories">
                            <h3 class="widget_title">Categories</h3>
                            <ul>
                                @foreach ($categories as $cat)
                                    <li>
                                        <a href="{{ route('blog', ['category' => $cat['name']]) }}">
                                            {{ $cat['name'] }}
                                        </a>
                                        <span>({{ $cat['count'] }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Recent Posts Widget --}}
                        <div class="widget">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                                @foreach ($recentPosts as $recent)
                                    <div class="recent-post">
                                        <div class="media-img">
                                            <a href="{{ route('blog-details', $recent['slug']) }}">
                                                <img src="{{ url($recent['image']) }}" alt="{{ $recent['title'] }}"
                                                    class="blog-sidebar-recent-thumb">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="post-title">
                                                <a class="text-inherit"
                                                    href="{{ route('blog-details', $recent['slug']) }}">
                                                    {{ Str::limit($recent['title'], 45) }}
                                                </a>
                                            </h4>
                                            <div class="recent-post-meta">
                                                <a href="{{ route('blog-details', $recent['slug']) }}">
                                                    <i class="fal fa-calendar-days"></i>
                                                    {{ $recent['date_day'] }} {{ $recent['date_month'] }},
                                                    {{ $recent['date_year'] }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Popular Tags Widget --}}
                        <div class="widget widget_tag_cloud">
                            <h3 class="widget_title">Popular Tags</h3>
                            <div class="tagcloud">
                                @foreach ($popularTags as $tag)
                                    <a href="{{ route('blog', ['tag' => $tag]) }}">{{ $tag }}</a>
                                @endforeach
                            </div>
                        </div>

                    </aside>
                </div>

            </div>
        </div>
    </section>

@endsection
