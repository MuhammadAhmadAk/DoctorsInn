@extends('frontend.layouts.main')
@section('title', ($course['title'] ?? 'Course Details') . ' | DoctorsInnElite')
@section('meta_description', 'Get complete details about our MDCAT preparation courses — curriculum, instructor info, student reviews, and pricing. Enroll now and start your journey to medical college.')
@section('meta_keywords', 'MDCAT course details, online MDCAT class, MDCAT course Pakistan, medical prep course details')
@section('content')

    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">{{ $course['title'] ?? 'Course Details' }}</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('course') }}">Course</a></li>
                            <li>Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="space-top space-extra-bottom overflow-hidden">
        <div class="container">
            <div class="row gx-40 gy-4">

                <div class="col-xxl-8 col-lg-7">
                    <div class="course-single mb-30">

                        <div class="course-single-top">
                            <div class="course-img">
                                <img src="{{ asset($course['detail_image'] ?? $course['image']) }}"
                                    alt="{{ $course['title'] }}">
                            </div>
                            <h2 class="course-title">{{ $course['title'] }}</h2>
                            <div class="course-rating">
                                <div class="star-rating" role="img" aria-label="Rated {{ $course['rating'] }} out of 5">
                                    <span class="star-rating-full">Rated <strong
                                            class="rating">{{ $course['rating'] }}</strong> out of 5</span>
                                </div>
                                <span>⭐ {{ $course['rating'] }} ({{ $course['rating_count'] ?? '1k+' }})</span>
                            </div>
                            <div class="box-content">
                                <div class="meta-box">
                                    <div class="meta-thumb">
                                        <img src="{{ asset($course['instructor_image'] ?? 'frontend/img/course/course-thumb1-1.png') }}"
                                            alt="{{ $course['instructor'] }}">
                                    </div>
                                    <div class="media-body">
                                        <h3 class="box-name">{{ $course['instructor'] }}</h3>
                                    </div>
                                </div>
                                <div class="course-info">
                                    <div class="box-icon"><i class="fal fa-file-lines"></i></div>
                                    <div class="course-info-details">
                                        <span class="course-info-title">Lessons:</span>
                                        <h4 class="course-info-text">{{ $course['lessons'] }}</h4>
                                    </div>
                                </div>
                                <div class="course-info">
                                    <div class="box-icon"><i class="fal fa-users"></i></div>
                                    <div class="course-info-details">
                                        <span class="course-info-title">Students:</span>
                                        <h4 class="course-info-text">{{ $course['students'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="course-single-bottom">
                            <ul class="nav course-tab" id="courseTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        href="#coursedescription" role="tab" aria-controls="coursedescription"
                                        aria-selected="true">
                                        <i class="fa-regular fa-bookmark"></i>Overview
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="curriculam-tab" data-bs-toggle="tab" href="#curriculam"
                                        role="tab" aria-controls="curriculam" aria-selected="false">
                                        <i class="fa-regular fa-book"></i>Curriculum
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="instructor-tab" data-bs-toggle="tab" href="#instructor"
                                        role="tab" aria-controls="instructor" aria-selected="false">
                                        <i class="fa-regular fa-user"></i>Instructor
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab"
                                        aria-controls="reviews" aria-selected="false">
                                        <i class="fa-regular fa-star-sharp"></i>Reviews
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="courseTabContent">

                                {{-- Tab 1: Overview --}}
                                <div class="tab-pane fade show active" id="coursedescription" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    <div class="course-description">
                                        <h5 class="h5 mb-4">Description</h5>
                                        <p class="lead text-body mb-4 legacy-inline-a4639a186a">
                                            {{ $course['overview'] }}</p>

                                        @if (!empty($course['what_will_you_learn']))
                                            <h5 class="h5 mt-40">What Will You Learn?</h5>
                                            <div class="row gy-3 mt-10">
                                                @foreach ($course['what_will_you_learn'] as $item)
                                                    <div class="col-md-6">
                                                        <div class="checklist style3">
                                                            <ul class="mb-0">
                                                                <li>{{ $item }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Tab 2: Curriculum --}}
                                <div class="tab-pane fade" id="curriculam" role="tabpanel"
                                    aria-labelledby="curriculam-tab">
                                    <div class="course-curriculam">
                                        <h5 class="h5 mb-3">The Course Curriculum</h5>
                                        <p class="text-muted mb-30">Follow our structured, step-by-step curriculum prepared
                                            specifically for medical entrance test success.</p>

                                        @if (!empty($course['curriculum']))
                                            <div class="course-curriculam-list">
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($course['curriculum'] as $curr)
                                                        <li class="p-3 mb-3 rounded-3 legacy-inline-f5d80dce85"
                                                           >
                                                            <div class="d-flex align-items-center">
                                                                <i
                                                                    class="fa-solid fa-circle-check text-theme me-3 fs-5"></i>
                                                                <div>
                                                                    <h6 class="mb-1 fw-bold text-title">
                                                                        {{ $curr['title'] }}</h6>
                                                                    <p class="mb-0 text-body small">{{ $curr['desc'] }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Tab 3: Instructor --}}
                                <div class="tab-pane fade" id="instructor" role="tabpanel"
                                    aria-labelledby="instructor-tab">
                                    <div class="course-instructor">
                                        <div class="course-author-box">
                                            <div class="auhtor-img">
                                                <img src="{{ asset($course['instructor_info']['image'] ?? $course['instructor_image'] ?? 'frontend/img/course/course-thumb1-1.png') }}"
                                                    alt="{{ $course['instructor_info']['name'] ?? $course['instructor'] }}">
                                            </div>
                                            <div class="media-body">
                                                <h3 class="author-name"><a class="text-inherit"
                                                        href="#">{{ $course['instructor_info']['name'] ?? $course['instructor'] }}</a>
                                                </h3>
                                                <p class="author-text">{{ $course['instructor_info']['bio'] ?? '' }}</p>
                                                <div class="author-meta">
                                                    <a href="{{ route('course') }}"><i
                                                            class="fal fa-file-video"></i>{{ $course['instructor_info']['courses'] ?? '8+ Courses' }}</a>
                                                    <span><i
                                                            class="fal fa-users"></i>{{ $course['instructor_info']['students'] ?? '1000+ Students' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tab 4: Reviews --}}
                                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                    <div class="course-reviews">
                                        <div class="th-comments-wrap mt-0">
                                            <ul class="comment-list">
                                                @if (!empty($course['reviews']))
                                                    @foreach ($course['reviews'] as $rev)
                                                        <li class="review th-comment-item">
                                                            <div class="th-post-comment">
                                                                <div class="comment-avater">
                                                                    @if (!empty($rev['image']))
                                                                        <img src="{{ asset($rev['image']) }}"
                                                                            alt="{{ $rev['name'] }}">
                                                                    @else
                                                                        <span class="review-avatar-initials"
                                                                            aria-label="{{ $rev['name'] }}">{{ strtoupper(substr($rev['name'], 0, 1)) }}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="comment-content">
                                                                    <h4 class="name">{{ $rev['name'] }}</h4>
                                                                    <span class="commented-on"><i
                                                                            class="fal fa-calendar-alt"></i>{{ $rev['date'] ?? 'Recently' }}</span>
                                                                    <div class="star-rating" role="img"
                                                                        aria-label="Rated {{ $rev['rating'] }}.00 out of 5">
                                                                        <span class="star-rating-full">
                                                                            @for ($i = 0; $i < $rev['rating']; $i++)
                                                                                ★
                                                                            @endfor
                                                                        </span>
                                                                    </div>
                                                                    <p class="text">{{ $rev['comment'] }}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>

                                        {{-- Add a review form --}}
                                        <div class="th-comment-form mb-0 mt-40">
                                            <div class="form-title">
                                                <h3 class="blog-inner-title">Add a review</h3>
                                            </div>
                                            <div class="row">
                                                <div class="form-group rating-select d-flex align-items-center">
                                                    <label>Your Rating</label>
                                                    <p class="stars"><span><a class="star-1" href="#">1</a> <a
                                                                class="star-2" href="#">2</a> <a class="star-3"
                                                                href="#">3</a> <a class="star-4"
                                                                href="#">4</a> <a class="star-5"
                                                                href="#">5</a></span></p>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <textarea placeholder="Write a Message" class="form-control"></textarea>
                                                    <i class="text-title far fa-pencil-alt"></i>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" placeholder="Your Name" class="form-control">
                                                    <i class="text-title far fa-user"></i>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" placeholder="Your Email" class="form-control">
                                                    <i class="text-title far fa-envelope"></i>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <input id="reviewcheck" name="reviewcheck" type="checkbox">
                                                    <label for="reviewcheck">Save my name, email, and website in this
                                                        browser for the next time I comment.</label>
                                                </div>
                                                <div class="col-12 form-group mb-0">
                                                    <button class="th-btn">POST REVIEW</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                {{-- Right Side Info Box --}}
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area pt-0">
                        <div class="widget widget_info widget_course_info">

                            <div class="th-video">
                                <img src="{{ asset($course['detail_image'] ?? $course['image']) }}"
                                    alt="{{ $course['title'] }}">
                                <a href="https://www.youtube.com/watch?v=_sI_Ps7JSEk" class="play-btn popup-video"><i
                                        class="far fa-play"></i></a>
                            </div>

                            <h4 class="course-price">
                                {{ $course['price'] }}
                                @if (!empty($course['original_price']))
                                    <del class="text-muted ms-2 fs-6">{{ $course['original_price'] }}</del>
                                @endif
                                @if (!empty($course['discount_tag']))
                                    <span class="tag ms-2">{{ $course['discount_tag'] }}</span>
                                @endif
                            </h4>

                            <div class="btn-wrap">
                                <a href="{{ route('checkout', ['course' => $course['slug']]) }}" class="th-btn w-100" id="buy-now-btn">
                                    <i class="fal fa-bolt me-2"></i>BUY NOW
                                    <svg class="ms-2" width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0" stroke="currentColor" stroke-width="1.5"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('course') }}" class="th-btn style-border2 w-100 mt-2">
                                    <i class="fal fa-graduation-cap me-2"></i>Browse All Courses
                                </a>
                            </div>

                            <h3 class="widget_title">Course Information</h3>

                            <div class="info-list">
                                <ul>
                                    <li><i class="fa-light fa-user"></i> <strong>Instructor:
                                        </strong><span>{{ $course['instructor'] }}</span></li>
                                    <li><i class="fa-light fa-file"></i> <strong>Lessons:
                                        </strong><span>{{ $course['lessons'] }}</span></li>
                                    <li><i class="fa-light fa-clock"></i> <strong>Duration:
                                        </strong><span>{{ $course['duration'] }}</span></li>
                                    <li><i class="fa-light fa-tag"></i> <strong>Course Level:
                                        </strong><span>{{ $course['level'] }}</span></li>
                                    <li><i class="fa-light fa-globe"></i> <strong>Language:
                                        </strong><span>{{ $course['language'] }}</span></li>
                                    <li><i class="fal fa-users"></i> <strong>Students:
                                        </strong><span>{{ $course['students'] }}</span></li>
                                </ul>
                            </div>

                        </div>
                    </aside>
                </div>

            </div>
        </div>
    </section>

    @php
        $successStories = collect($courses)
            ->flatMap(function ($storyCourse) {
                return collect($storyCourse['success_stories'] ?? [])->map(function ($story) use ($storyCourse) {
                    $story['course_title'] = $storyCourse['title'];
                    return $story;
                });
            })
            ->take(4);
    @endphp

 
    <section class="overflow-hidden space bg-color overflow-hidden">
        <div class="container">
            <div class="title-area text-center"><span class="sub-title text-theme th_fade_anim"><img
                        src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Student Selected</span>
                <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">Our Students' Success Stories</span>
                </h2>
            </div>
            @if ($successStories->isNotEmpty())
                <div class="row gy-4">
                    @foreach ($successStories as $story)
                        <div class="col-md-6 col-xl-4">
                            <article class="course-success-card h-100">
                                <div class="course-success-card-content">
                                    <div class="course-success-header">
                                        <img class="course-success-avatar" src="{{ asset($story['profile_image']) }}"
                                            alt="{{ $story['name'] }}">
                                        <div class="course-success-identity">
                                            <h3>{{ $story['name'] }}</h3>
                                            <p><i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                                {{ $story['college'] }}</p>
                                        </div>
                                    </div>
                                    <span class="course-success-course">{{ $story['course_label'] }}</span>
                                    <div class="course-success-selection">
                                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                                        Selected in: {{ $story['selection'] }}
                                    </div>
                                    <div class="course-success-score">
                                        <span><i class="fa-solid fa-star" aria-hidden="true"></i> Score</span>
                                        <strong>{{ $story['score'] }}</strong>
                                    </div>
                                    <p class="course-success-quote">“{{ $story['quote'] }}”</p>
                                    @if (!empty($story['proof_image']))
                                        <a class="course-success-proof-link" href="{{ asset($story['proof_image']) }}"
                                            target="_blank" rel="noopener">
                                            <i class="fa-regular fa-image" aria-hidden="true"></i> View result proof
                                        </a>
                                    @endif
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="course-success-empty text-center">
                    <i class="fa-regular fa-image" aria-hidden="true"></i>
                    <p class="mb-0">Verified student success stories will be added here.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
