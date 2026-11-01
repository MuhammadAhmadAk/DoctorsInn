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
    
    <section class="overflow-hidden space bg-color" id="course-sec">
        <div class="container">
            <div class="title-area text-center mb-35">
                <span class="sub-title text-theme th_fade_anim">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Our Courses
                </span>
                <h2 class="sec-title th_fade_anim">
                    <span class="th-text-perspective">Our Featured Courses</span>
                </h2>
            </div>

            @php
                $sliderCourses = $courses ?? config('courses', []);
                $courseCategories = [
                    'all' => [
                        'label' => 'All Courses',
                        'icon' => 'fa-solid fa-layer-group',
                        'courses' => collect($sliderCourses),
                    ],
                    'mdcat' => [
                        'label' => 'MDCAT',
                        'icon' => 'fa-solid fa-stethoscope',
                        'courses' => collect($sliderCourses)->where('category', 'mdcat'),
                    ],
                    'nums' => [
                        'label' => 'NUMS',
                        'icon' => 'fa-solid fa-hospital-user',
                        'courses' => collect($sliderCourses)->where('category', 'nums'),
                    ],
                    'army' => [
                        'label' => 'Army / AMC',
                        'icon' => 'fa-solid fa-shield-halved',
                        'courses' => collect($sliderCourses)->where('category', 'army'),
                    ],
                ];
            @endphp

            <!-- Course Category Tabs -->
            <div class="course-tab-wrap text-center mb-45 th_fade_anim" data-delay=".2">
                <div class="tab-menu1 course-category-tabs" role="tablist">
                    @foreach ($courseCategories as $catKey => $catData)
                        <button class="tab-btn {{ $loop->first ? 'active' : '' }}" 
                                id="tab-btn-{{ $catKey }}" 
                                data-category="{{ $catKey }}"
                                type="button">
                            <i class="{{ $catData['icon'] }} me-2"></i>{{ $catData['label'] }}
                            <span class="tab-badge ms-2">{{ $catData['courses']->count() }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Tab Panes with Sliders -->
            <div class="tab-content" id="courseCategoryTabContent">
                @foreach ($courseCategories as $catKey => $catData)
                    <div class="course-tab-pane {{ $loop->first ? 'active' : '' }}" 
                         id="tab-pane-{{ $catKey }}" 
                         >
                        <div class="slider-area">
                            <div class="swiper th-slider course-slider2 has-shadow" id="courselider-{{ $catKey }}"
                                data-slider-options='{"observer": true, "observeParents": true, "autoHeight": "true", "breakpoints": {"0": {"slidesPerView": 1}, "576": {"slidesPerView": "1"}, "768": {"slidesPerView": "2"}, "992": {"slidesPerView": "2"}, "1200": {"slidesPerView": "3"}}}'>
                                <div class="swiper-wrapper">
                                    @forelse ($catData['courses'] as $courseItem)
                                        <div class="swiper-slide">
                                            @include('frontend.components.course-card', ['courseItem' => $courseItem])
                                        </div>
                                    @empty
                                        <div class="text-center py-5 w-100">
                                            <p class="text-muted">No courses available in this category yet.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <button data-slider-prev="#courselider-{{ $catKey }}" class="slider-arrow style5 slider-prev" aria-label="Previous">
                                <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.4672 0C8.4672 0.783225 7.69103 1.95525 6.90638 2.93955C5.89598 4.20682 4.69013 5.3139 3.30645 6.15915C2.26988 6.79208 1.01115 7.39965 1.90735e-06 7.39965M8.4672 14.8176C8.4672 14.0344 7.69103 12.8623 6.90638 11.878C5.89598 10.6108 4.69013 9.5037 3.30645 8.65845C2.26988 8.02552 1.01115 7.41795 1.90735e-06 7.41795M1.90735e-06 7.4088H16.9344" stroke="currentColor"></path>
                                </svg>
                            </button>
                            <button data-slider-next="#courselider-{{ $catKey }}" class="slider-arrow style5 slider-next" aria-label="Next">
                                <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.4672 0C8.4672 0.783225 9.24338 1.95525 10.028 2.93955C11.0384 4.20682 12.2443 5.3139 13.628 6.15915C14.6645 6.79208 15.9233 7.39965 16.9344 7.39965M8.4672 14.8176C8.4672 14.0344 9.24338 12.8623 10.028 11.878C11.0384 10.6108 12.2443 9.5037 13.628 8.65845C14.6645 8.02552 15.9233 7.41795 16.9344 7.41795M16.9344 7.4088H0" stroke="currentColor"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="btn-wrap mt-60 justify-content-center th_fade_anim">
                <a href="{{ route('course') }}" class="th-btn">
                    VIEW ALL COURSES
                    <svg class="ms-2" width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0" stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                </a>
            </div>
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
                                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/process-card-icon1.svg') }}"
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
                                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/process-card-icon2.svg') }}"
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
                                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/process-card-icon3.svg') }}"
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
                    <div class="process-img-box2 th_fade_anim"><img src="{{ asset('frontend/img/normal/process-thumb2-1.png') }}"
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
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">AMC Exam Mein Pass Ho Gaya!</h3>
                                <p class="box-text">Every topic ka lecture, notes, aur MCQ practice sab kuch tha. Koi bhi problem hoti toh turant solve ho jati. Only because of this course I passed the AMC test!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Muhammad Abdul Rafay</h4><span class="testi-card_desig">AMC — Ansaar Batch | Gujrat</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Best Choice for PMA Preparation!</h3>
                                <p class="box-text">Lessons were clear, well-structured and easy to follow. I passed all my tests with excellent results. Truly the best choice for PMA prep!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_2.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Hammad Gulzar</h4><span class="testi-card_desig">PMA — Iqbal Batch | Bahawalpur</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Anytime Support — Always Available!</h3>
                                <p class="box-text">Lectures include all books and they give their best to make us understand everything. We asked any question anytime and they were always available. Thanks Sir!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_3.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Amna</h4><span class="testi-card_desig">MDCAT Student</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Yaqeen Batch Bohat Zabardast Hai!</h3>
                                <p class="box-text">MDCAT ke liye yahan bahut zaroori information aur helpful resources milte hain. Group administration friendly hai aur overall bahut useful Online Educational Centre hai.</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Ali Khan</h4><span class="testi-card_desig">MDCAT — Yaqeen Batch Group B | Quetta</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Outstanding Teachers &amp; Methodology!</h3>
                                <p class="box-text">The teachers are highly professional, cooperative and supportive. Test sessions are very helpful. Highly recommended for serious aspirants!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_2.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Noor Khan</h4><span class="testi-card_desig">MDCAT Enrolled Student | Swat</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">High-Quality Notes &amp; Strong Commitment!</h3>
                                <p class="box-text">Impressed with this platform! High-quality notes and strong commitment to users. Truly delivered on its promise!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_3.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Armish Shoukat</h4><span class="testi-card_desig">AFNS — Afaaq Batch | Abbottabad</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Concept Clear Karne Ka Tareeqa Unique Hai!</h3>
                                <p class="box-text">MDCAT ka syllabus samajhna bohot easy ho gaya. Har concept clear kiya jata hai. Group bohot kind aur cooperative hai — bohot motivate bhi karte hain!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Amina Tousif</h4><span class="testi-card_desig">MDCAT — Yaqeen Batch Group B | Chawinda, Punjab</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Learning Made Easy!</h3>
                                <p class="box-text">DoctorsInn mein joining ke baad MDCAT notes milte hain, doubts discuss kar sakte hain, aur learning bohot easy ho jati hai. Highly recommended!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_2.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Asma Barkat</h4><span class="testi-card_desig">MDCAT Student | Turbat</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Turned Our Dreams Into Reality!</h3>
                                <p class="box-text">It's incredible to join Doctor's Inn. Amazing methodology and cooperation with students. Truly turns dreams into reality!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_3.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Madeha</h4><span class="testi-card_desig">DoctorsInn Student | Muzaffargarh</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon">
                                </div>
                                <h3 class="box-title">Blown Away by Academy's Excellence!</h3>
                                <p class="box-text">Instructors are super knowledgeable, patient and genuinely invested in our growth. Gained so much confidence and insight. Huge thumbs up!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">5.0</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}"
                                            alt="img"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">Malaika</h4><span class="testi-card_desig">MDCAT Student</span>
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
            <img src="{{ asset('frontend/img/icon/wave_shape_2.svg') }}" alt="img">
        </div>
        <div class="faq-bg-shape1-2 shape-mockup th_fade_anim" data-speed="0.9" data-right="-15%" data-bottom="5%"><img
                src="{{ asset('frontend/img/icon/wave_bg_3.svg') }}" alt="img"></div>
        <div class="container">
            <div class="row gy-40">
                <div class="col-xl-6">
                    <div class="faq-img-box1">
                        <div class="img1 th--hover-item th_fade_anim">
                            <div class="thumb th--hover-img" data-displacement="{{ asset('frontend/img/imghover/fluid.jpg') }}"
                                data-intensity="0.2" data-speedin="1" data-speedout="1"><img class="img-cover"
                                    src="{{ asset('frontend/img/normal/faq_1_1.jpg') }}" alt="img"></div>
                        </div>
                        <div class="img2 th--hover-item th_fade_anim">
                            <div class="thumb th--hover-img" data-displacement="{{ asset('frontend/img/imghover/fluid.jpg') }}"
                                data-intensity="0.2" data-speedin="1" data-speedout="1"><img class="img-cover"
                                    src="{{ asset('frontend/img/normal/faq_1_2.jpg') }}" alt="img"></div>
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

    <!--==============================
    Blog Area
    ==============================-->
    <section class="space overflow-hidden bg-color" id="blog-sec">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title text-theme th_fade_anim">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Latest News & Articles
                </span>
                <h2 class="sec-title th_fade_anim">
                    <span class="th-text-perspective">Our Latest Blogs & Updates</span>
                </h2>
            </div>
            @php
                $homeBlogs = array_slice(config('blogs', []), 0, 3);
            @endphp
            <div class="row gy-40 justify-content-center">
                @foreach ($homeBlogs as $blog)
                    <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".2">
                        <div class="modern-blog-card">
                            <div class="blog-img">
                                <a href="{{ route('blog-details', $blog['slug']) }}">
                                    <img src="{{ url($blog['image']) }}" alt="{{ $blog['title'] }}">
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
                @endforeach
            </div>
            <div class="text-center mt-50 th_fade_anim">
                <a href="{{ route('blog') }}" class="th-btn">
                    VIEW ALL ARTICLES
                    <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                            stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

@endsection
