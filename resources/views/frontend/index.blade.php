@extends('frontend.layouts.main')
@section('title', 'DoctorsInnElite | Pakistan #1 MDCAT Preparation Platform')
@section('meta_description', 'DoctorsInnElite offers expert-led MDCAT, NUMS, AMC and AFNS preparation courses, full-length mock tests, and mentorship to help you secure your seat in top medical colleges of Pakistan.')
@section('meta_keywords', 'MDCAT preparation, MDCAT 2026, NUMS preparation, AMC prep, medical entry test Pakistan, online MDCAT courses, DoctorsInnElite')
@section('content')


    <div class="th-hero-wrapper hero-2 bg-gradient" id="hero">
        <div class="container">
            <div class="row gx-40 align-items-center">
                <div class="col-xl-7">
                    <div class="hero-style2"><span class="sub-title wow animate__fadeInUp" data-wow-delay="0.2s">PREPARE.
                            PRACTICE. SUCCEED.</span>
                        <h2 class="hero-title"><span class="title1 wow animate__fadeInUp" data-wow-delay="0.4s">Crack
                                MDCAT,</span> <span class="title2 wow animate__fadeInUp" data-wow-delay="0.6s">Build Your
                                Medical Career</span></h2>
                        <p class="hero-text wow animate__fadeInUp" data-wow-delay="0.8s">DoctorsInnElite
                            provides structured MDCAT preparation, expert-led course, and full-length mock tests
                            to help you secure your seat in top medical colleges.</p>
                        <div class="btn-wrap wow animate__fadeInUp" data-wow-delay="0.9s">
                            <a href="{{ route('contact') }}" class="th-btn">ENROLL NOW <svg class="ms-2" width="16"
                                    height="14" viewbox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg> </a>
                            <a href="{{ route('course') }}" class="th-btn style4">EXPLORE COURSE <svg class="ms-2"
                                    width="16" height="14" viewbox="0 0 16 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row gy-50 align-items-center">
                <div class="col-xl-6 col-lg-10">
                    <div class="img-box2">
                        <div class="img1 th--hover-item th_fade_anim">
                            <div class="thumb th--hover-img" data-displacement="{{ asset('frontend/img/imghover/fluid.jpg') }}"
                                data-intensity="0.2" data-speedin="1" data-speedout="1"><img class="img-cover"
                                    src="{{ asset('frontend/img/normal/about_2_1.jpg') }}" alt="About"></div>
                        </div>
                        <div class="img2 th--hover-item th_fade_anim">
                            <div class="thumb th--hover-img" data-displacement="{{ asset('frontend/img/imghover/fluid.jpg') }}"
                                data-intensity="0.2" data-speedin="1" data-speedout="1"><img class="img-cover"
                                    src="{{ asset('frontend/img/normal/about_2_2.jpg') }}" alt="About"></div>
                        </div>
                        <div class="about-shape2-1 jump"><img src="{{ asset('frontend/img/shape/about_shape2_1.png') }}" alt="img">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-wrap2">
                        <div class="title-area mb-35"><span class="sub-title text-theme th_fade_anim"><img
                                    src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img"> Get To Know About Us</span>
                            <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">Pakistan's
                                    Trusted MDCAT Preparation Platform</span></h2>
                            <p class="th_fade_anim">DoctorsInnElite is dedicated to helping aspiring medical
                                students crack MDCAT and secure admissions in top medical colleges. With expert
                                instructors, structured course, and real exam-style mock tests — we prepare you
                                for success.</p>
                        </div>
                        <div class="row gy-40 gx-40">
                            <div class="col-md-6">
                                <div class="about-info-card">
                                    <h3 class="box-title th_fade_anim">OUR MISSION:</h3>
                                    <p class="box-text th_fade_anim">To provide every medical aspirant with
                                        affordable, high-quality MDCAT preparation through structured course,
                                        mock tests, and expert mentorship.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="about-info-card">
                                    <h3 class="box-title th_fade_anim">OUR VISION:</h3>
                                    <p class="box-text th_fade_anim">To become Pakistan's #1 online platform for
                                        medical entry test preparation — empowering students from every city and
                                        background.</p>
                                </div>
                            </div>
                        </div>
                        <div class="btn-wrap mt-40 th_fade_anim"><a href="{{ route('about') }}" class="th-btn">GET STARTED
                                <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="space-bottom overflow-hidden">
        <div class="container">
            <div class="counter-wrap8 th_fade_anim">
                <div class="counter-card style8 hover-item">
                    <div class="media-body">
                        <h2 class="box-number"><span class="counter-number">3.9</span>k<span
                                class="text-theme2 fw-normal">+</span></h2>
                        <p class="box-text">Total Student Enrolled</p>
                    </div>
                </div>
                <div class="counter-card style8 hover-item item-active">
                    <div class="media-body">
                        <h2 class="box-number"><span class="counter-number">1.2</span>k<span
                                class="text-theme2 fw-normal">+</span></h2>
                        <p class="box-text">Active course</p>
                    </div>
                </div>
                <div class="counter-card style8 hover-item">
                    <div class="media-body">
                        <h2 class="box-number"><span class="counter-number">850</span><span
                                class="text-theme2 fw-normal">+</span></h2>
                        <p class="box-text">Qualified Instructors</p>
                    </div>
                </div>
                <div class="counter-card style8 hover-item">
                    <div class="media-body">
                        <h2 class="box-number"><span class="counter-number">5.5</span>k<span
                                class="text-theme2 fw-normal">+</span></h2>
                        <p class="box-text">course Completions</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <section class="overflow-hidden space bg-color overflow-hidden" id="course-sec">
        <div class="container">
            <div class="title-area text-center"><span class="sub-title text-theme th_fade_anim"><img
                        src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Our course</span>
                <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">Our Featured course</span>
                </h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider course-slider2 has-shadow" id="courselider2"
                    data-slider-options='{"autoHeight": "true","breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}'>
                    <div class="swiper-wrapper">
                        @php
                            $sliderCourses = $courses ?? config('courses', []);
                        @endphp
                        @foreach ($sliderCourses as $courseItem)
                            <div class="swiper-slide th_fade_anim" data-delay=".3">
                                <div class="course-card">
                                    <div class="box-img">
                                        <a href="{{ route('course-details', $courseItem['slug']) }}"><img
                                                src="{{ asset($courseItem['image']) }}"
                                                alt="{{ $courseItem['title'] }}"></a>
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
                                            ({{ $courseItem['rating_count'] ?? '1k+' }})
                                        </span>
                                    </div>
                                    <div class="box-content">
                                        <div class="course-info">
                                            <div class="box-icon"><i class="fal fa-file-lines"></i></div>
                                            <div class="course-info-details"><span
                                                    class="course-info-title">Lessons:</span>
                                                <h4 class="course-info-text">{{ $courseItem['lessons'] }}</h4>
                                            </div>
                                        </div>
                                        <div class="course-info">
                                            <div class="box-icon"><i class="fal fa-users"></i></div>
                                            <div class="course-info-details"><span
                                                    class="course-info-title">Students:</span>
                                                <h4 class="course-info-text">{{ $courseItem['students'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-wrap">
                                        <div class="meta-box">
                                            <div class="meta-thumb"><img
                                                    src="{{ asset($courseItem['instructor_image']) }}"
                                                    alt="{{ $courseItem['instructor'] }}">
                                            </div>
                                            <div class="media-body">
                                                <h5 class="box-name"><a
                                                        href="#">{{ $courseItem['instructor'] }}</a></h5>
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
                </div><button data-slider-prev="#courselider2" class="slider-arrow style5 slider-prev"><svg
                        width="17" height="15" viewbox="0 0 17 15" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.4672 0C8.4672 0.783225 7.69103 1.95525 6.90638 2.93955C5.89598 4.20682 4.69013 5.3139 3.30645 6.15915C2.26988 6.79208 1.01115 7.39965 1.90735e-06 7.39965M8.4672 14.8176C8.4672 14.0344 7.69103 12.8623 6.90638 11.878C5.89598 10.6108 4.69013 9.5037 3.30645 8.65845C2.26988 8.02552 1.01115 7.41795 1.90735e-06 7.41795M1.90735e-06 7.4088H16.9344"
                            stroke="currentColor"></path>
                    </svg></button> <button data-slider-next="#courselider2" class="slider-arrow style5 slider-next"><svg
                        width="17" height="15" viewbox="0 0 17 15" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.4672 0C8.4672 0.783225 9.24338 1.95525 10.028 2.93955C11.0384 4.20682 12.2443 5.3139 13.628 6.15915C14.6645 6.79208 15.9233 7.39965 16.9344 7.39965M8.4672 14.8176C8.4672 14.0344 9.24338 12.8623 10.028 11.878C11.0384 10.6108 12.2443 9.5037 13.628 8.65845C14.6645 8.02552 15.9233 7.41795 16.9344 7.41795M16.9344 7.4088H0"
                            stroke="currentColor"></path>
                    </svg></button>
            </div>
            <div class="btn-wrap mt-60 justify-content-center th_fade_anim"><a href="{{ route('course') }}"
                    class="th-btn">VIEW ALL
                    COURSE<svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                            stroke="currentColor" stroke-width="1.5"></path>
                    </svg></a></div>
        </div>
    </section>

    <div class="space overflow-hidden bg-gradient">
        <div class="container">
            <div class="counter-wrap2">
                <div class="counter-card2 th_fade_anim" data-delay=".2">
                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/counter-icon2-1.svg') }}" alt="icon"></div>
                    <div class="box-content">
                        <h4 class="box-title">8+ Online course</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".3">
                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/counter-icon2-2.svg') }}" alt="icon"></div>
                    <div class="box-content">
                        <h4 class="box-title">Lifetime Access</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".4">
                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/counter-icon2-3.svg') }}" alt="icon"></div>
                    <div class="box-content">
                        <h4 class="box-title">Value For Money</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".5">
                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/counter-icon2-4.svg') }}" alt="icon"></div>
                    <div class="box-content">
                        <h4 class="box-title">24/7 Student Support</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".6">
                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/counter-icon2-5.svg') }}" alt="icon"></div>
                    <div class="box-content">
                        <h4 class="box-title">WhatsApp Community</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="space overflow-hidden">
        <div class="container">
            <div class="row gy-50 flex-row-reverse">
                <div class="col-xl-6">
                    <div class="process-wrap2">
                        <div class="title-area"><span class="sub-title text-theme th_fade_anim"><img
                                    src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Work Process</span>
                            <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">How It
                                    Works</span></h2>
                        </div>
                        <div class="process-card-wrap2">
                            <div class="process-card2 th_fade_anim">
                                <div class="box-number">01</div>
                                <div class="process-card-content">
                                    <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/process-card-icon1.svg') }}"
                                            alt="img">
                                    </div>
                                    <div class="box-content">
                                        <h3 class="box-title">Register & Create Your Account</h3>
                                        <p class="box-text">Sign up on DoctorsInnElite and create your free
                                            student account in minutes.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="process-card2 th_fade_anim">
                                <div class="box-number">02</div>
                                <div class="process-card-content">
                                    <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/process-card-icon2.svg') }}"
                                            alt="img">
                                    </div>
                                    <div class="box-content">
                                        <h3 class="box-title">Choose Your course</h3>
                                        <p class="box-text">Pick your MDCAT, NUMS, or AMC course and enroll
                                            instantly.".</p>
                                    </div>
                                </div>
                            </div>
                            <div class="process-card2 th_fade_anim">
                                <div class="box-number">03</div>
                                <div class="process-card-content">
                                    <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/process-card-icon3.svg') }}"
                                            alt="img">
                                    </div>
                                    <div class="box-content">
                                        <h3 class="box-title">Learn & Ace Your Exam</h3>
                                        <p class="box-text">Study lessons, attempt mock tests, and track your
                                            progress.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 align-self-end">
                    <div class="process-img-box2 th_fade_anim"><img src="{{ asset('frontend/img/normal/mdcat_student.jpg') }}"
                            alt="img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.components.team-section')
    @include('frontend.components.course-promo-cards')

    <section class="testi-area-2 bg-color space overflow-hidden" id="testi-sec">
        <div class="container">

            <div class="title-area text-center"><span class="sub-title text-theme th_fade_anim"><img
                        src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Testimonials</span>
                <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">What Our Students
                        Say!</span></h2>
            </div>

            <div class="testi-slider2 slider-area">
                <div class="swiper th-slider has-shadow" id="testiSlide2"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}},"autoHeight": "true"}'>
                    <div class="swiper-wrapper">

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Best MDCAT Prep Platform!</h3>
                                <p class="box-text">DoctorsInnElite gave me the structure I needed. Their mock
                                    tests were exactly like the real exam!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">4.8
                                        (8k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}"
                                            alt="img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Alex James</h4><span class="testi-card_desig">MDCAT
                                            Student 2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Cracked MDCAT With Their Help!</h3>
                                <p class="box-text">The 60-day program kept me consistent. I improved my score
                                    by 40 marks in just 3 weeks!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">4.6
                                        (5k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_2.png') }}"
                                            alt="img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Maria Gonzalez</h4><span class="testi-card_desig">NUMS
                                            Qualifier 2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Affordable & Super Effective!</h3>
                                <p class="box-text">Amazing course quality at a very affordable price. The
                                    instructor support is outstanding!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">4.9
                                        (10k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_3.png') }}"
                                            alt="img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">David Lee</h4><span class="testi-card_desig">MDCAT
                                            Aspirant 2026</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Best MDCAT Prep Platform!</h3>
                                <p class="box-text">DoctorsInnElite gave me the structure I needed. Their mock
                                    tests were exactly like the real exam!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">4.8
                                        (8k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}"
                                            alt="img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Alex James</h4><span class="testi-card_desig">MDCAT
                                            Student 2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Cracked MDCAT With Their Help!</h3>
                                <p class="box-text">The 60-day program kept me consistent. I improved my score
                                    by 40 marks in just 3 weeks!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">4.6
                                        (5k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_2.png') }}"
                                            alt="img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Maria Gonzalez</h4><span class="testi-card_desig">NUMS
                                            Qualifier 2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Affordable & Super Effective!</h3>
                                <p class="box-text">Amazing course quality at a very affordable price. The
                                    instructor support is outstanding!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">4.9
                                        (10k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_3.png') }}"
                                            alt="img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">David Lee</h4><span class="testi-card_desig">MDCAT
                                            Aspirant 2026</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <button data-slider-prev="#testiSlide2" class="slider-arrow style3 slider-prev"><i
                        class="far fa-arrow-left"></i></button>
                <button data-slider-next="#testiSlide2" class="slider-arrow style3 slider-next"><i
                        class="far fa-arrow-right"></i></button>
            </div>
        </div>
    </section>

    <div class="space overflow-hidden">
        <div class="faq-bg-shape1-1 shape-mockup th_fade_anim" data-speed="0.9" data-left="4%" data-top="10%">
            <img src="{{ asset('frontend/img/home/icons/wave_shape_2.svg') }}" alt="img">
        </div>
        <div class="faq-bg-shape1-2 shape-mockup th_fade_anim" data-speed="0.9" data-right="-15%" data-bottom="5%"><img
                src="{{ asset('frontend/img/home/icons/wave_bg_3.svg') }}" alt="img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"></div>
        <div class="container">
            <div class="row gy-40">
                <div class="col-xl-6">
                    <div class="faq-img-box1">
                        <div class="img1 th--hover-item th_fade_anim">
                            <div class="thumb th--hover-img" data-displacement="{{ asset('frontend/img/imghover/fluid.jpg') }}"
                                data-intensity="0.2" data-speedin="1" data-speedout="1"><img class="img-cover"
                                    src="{{ asset('frontend/img/normal/faq_1_1.jpg') }}" alt="img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"></div>
                        </div>
                        <div class="img2 th--hover-item th_fade_anim">
                            <div class="thumb th--hover-img" data-displacement="{{ asset('frontend/img/imghover/fluid.jpg') }}"
                                data-intensity="0.2" data-speedin="1" data-speedout="1"><img class="img-cover"
                                    src="{{ asset('frontend/img/normal/faq_1_2.jpg') }}" alt="img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"></div>
                        </div>
                        <div class="faq-counter-wrap jump">
                            <div class="thumb"><img src="{{ asset('frontend/img/normal/volunteer-group2.png') }}" alt="img">
                            </div>
                            <div class="box-details">
                                <h3 class="box-title"><span class="counter-number">1</span>K +</h3>
                                <p class="box-text">Active students</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="faq-wrap1">
                        <div class="title-area"><span class="sub-title text-theme th_fade_anim"><img
                                    src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Faq’s</span>
                            <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">Frequently
                                    Asked Questions</span></h2>
                        </div>
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-card th_fade_anim">
                                <div class="accordion-header" id="collapse-item-1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">What
                                        course does DoctorsInnElite
                                        offer?</button>
                                </div>
                                <div id="collapse-1" class="accordion-collapse collapse show"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p class="faq-text">We offer MDCAT, NUMS, AMC, and AFNS preparation
                                            course including mock tests, full-length papers, and comprehensive
                                            test sessions.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-card th_fade_anim">
                                <div class="accordion-header" id="collapse-item-2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">Are
                                        the course
                                        available online?</button>
                                </div>
                                <div id="collapse-2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p class="faq-text">Yes! All our course are 100% online. Study anytime,
                                            anywhere at your own pace.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-card th_fade_anim">
                                <div class="accordion-header" id="collapse-item-3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">How
                                        do
                                        I enroll in a
                                        course?</button>
                                </div>
                                <div id="collapse-3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p class="faq-text">Simply create a free account, browse our course, and
                                            click Enroll Now to get started.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
