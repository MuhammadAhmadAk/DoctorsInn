@extends('frontend.layouts.main')
@section('title', 'Our Courses | DoctorsInnElite')
@section('meta_description', 'Browse all MDCAT, NUMS, AMC and AFNS preparation courses by DoctorsInnElite. Affordable prices, expert instructors, and proven results. Enroll today!')
@section('meta_keywords', 'MDCAT courses online, NUMS prep course, AMC preparation, AFNS courses, medical entry test courses Pakistan, online medical courses')
@section('content')

    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Course</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Course</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="overflow-hidden th-anim-trigger space overflow-hidden" id="course-sec">
        <div class="course-bg-shape1-1 shape-mockup th_fade_anim" data-speed="0.9" data-left="6%" data-top="20%"><img
                src="{{ asset('frontend/img/home/icons/wave_shape_2.svg') }}" alt="img"></div>
        <div class="course-bg-shape1-2 shape-mockup" data-right="6%" data-bottom="20%">
            <div class="thumb th-anim-spin"><img src="{{ asset('frontend/img/shape/course_shape1_2.png') }}" alt="img">
            </div>
        </div>

        <div class="container">
            <div class="th-course-row columns-3">
                @foreach ($courses as $courseItem)
                    <div class="th-course-single th_fade_anim" data-delay=".3">
                        <div class="course-card">
                            <div class="box-img">
                                <a href="{{ route('course-details', $courseItem['slug']) }}"><img
                                        src="{{ asset($courseItem['image']) }}" alt="{{ $courseItem['title'] }}"></a>
                                @if (!empty($courseItem['success_badge']))
                                    <span class="course-success-badge"><i class="fa-solid fa-award"
                                            aria-hidden="true"></i>{{ $courseItem['success_badge'] }}</span>
                                @endif
                                <span class="box-price">
                                    {{ $courseItem['price'] }}
                                    @if (!empty($courseItem['original_price']))
                                        <del class="text-muted ms-1 small legacy-inline-c3b97501f8"
                                           >{{ $courseItem['original_price'] }}</del>
                                    @endif
                                </span>
                            </div>
                            <h3 class="box-title"><a
                                    href="{{ route('course-details', $courseItem['slug']) }}">{{ $courseItem['title'] }}</a>
                            </h3>
                            <div class="box-rating">
                                <div class="star-rating" role="img"
                                    aria-label="Rated {{ $courseItem['rating'] }} out of 5"><span
                                        class="star-rating-full">Rated <strong
                                            class="rating">{{ $courseItem['rating'] }}</strong> out of
                                        5</span></div><span class="ms-2">⭐ {{ $courseItem['rating'] }}
                                    ({{ $courseItem['rating_count'] ?? '1k+' }})</span>
                            </div>
                            <div class="box-content">
                                <div class="course-info">
                                    <div class="box-icon"><i class="fal fa-file-lines"></i></div>
                                    <div class="course-info-details"><span class="course-info-title">Lessons:</span>
                                        <h4 class="course-info-text">{{ $courseItem['lessons'] }}</h4>
                                    </div>
                                </div>
                                <div class="course-info">
                                    <div class="box-icon"><i class="fal fa-users"></i></div>
                                    <div class="course-info-details"><span class="course-info-title">Students:</span>
                                        <h4 class="course-info-text">{{ $courseItem['students'] }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-wrap">
                                <div class="meta-box">
                                    <div class="meta-thumb"><img src="{{ asset($courseItem['instructor_image']) }}"
                                            alt="{{ $courseItem['instructor'] }}">
                                    </div>
                                    <div class="media-body">
                                        <h5 class="box-name"><a href="#">{{ $courseItem['instructor'] }}</a></h5>
                                    </div>
                                </div><a href="{{ route('course-details', $courseItem['slug']) }}"
                                    class="th-btn btn-sm style-border2">VIEW
                                    DETAILS<svg class="ms-2" width="16" height="14" viewbox="0 0 16 14"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                    </svg></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="space bg-theme overflow-hidden" data-bg-src="{{ asset('frontend/img/bg/cta-bg5-1.png') }}">
        <div class="container">
            <div class="row gy-40 justify-content-between align-items-center">
                <div class="col-xxl-6 col-xl-7 col-lg-7">
                    <div class="title-area mb-0 text-lg-start text-center">
                        <h2 class="sec-title text-white">Get 30% Off On All MDCAT <span class="fw-normal">Courses —
                                Limited Time!</span></h2>
                        <p class="text-white mb-0 mt-30">Enroll now to unlock full course access, mock tests, and expert
                            mentorship.</p>
                    </div>
                </div>
                <div class="col-lg-auto">
                    <div class="btn-wrap justify-content-center"><a href="{{ route('register') }}"
                            class="th-btn style5">ENROLL NOW
                            <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                    stroke="currentColor" stroke-width="1.5"></path>
                            </svg></a></div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.components.course-promo-cards')

@endsection
