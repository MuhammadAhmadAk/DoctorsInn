@extends('frontend.layouts.main')
@section('title', 'DoctorsInnElite | Pakistan #1 MDCAT Preparation Platform')
@section('meta_description', 'DoctorsInnElite offers expert-led MDCAT, NUMS, AMC and AFNS preparation courses, full-length mock tests, and mentorship to help you secure your seat in top medical colleges of Pakistan.')
@section('meta_keywords', 'MDCAT preparation, MDCAT 2026, NUMS preparation, AMC prep, medical entry test Pakistan, online MDCAT courses, DoctorsInnElite')
@section('content')


    <div class="th-hero-wrapper hero-2 bg-gradient" id="hero">
        <div class="container">
            <div class="row gx-40 align-items-center">
                <div class="col-xl-7">
                    <div class="hero-style2"><span class="sub-title wow animate__fadeInUp" data-wow-delay="0.2s">{{ $cms['hero_subtitle'] ?? 'PREPARE. PRACTICE. SUCCEED.' }}</span>
                        <h2 class="hero-title"><span class="title1 wow animate__fadeInUp" data-wow-delay="0.4s">{{ $cms['hero_title_1'] ?? 'Crack MDCAT,' }}</span> <span class="title2 wow animate__fadeInUp" data-wow-delay="0.6s">{{ $cms['hero_title_2'] ?? 'Build Your Medical Career' }}</span></h2>
                        <p class="hero-text wow animate__fadeInUp" data-wow-delay="0.8s">{{ $cms['hero_description'] ?? 'DoctorsInnElite provides structured MDCAT preparation, expert-led course, and full-length mock tests to help you secure your seat in top medical colleges.' }}</p>
                        <div class="btn-wrap wow animate__fadeInUp" data-wow-delay="0.9s">
                            <a href="{{ route('contact') }}" class="th-btn">{{ $cms['hero_btn_1_text'] ?? 'ENROLL NOW' }} <svg class="ms-2" width="16"
                                    height="14" viewbox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg> </a>
                            <a href="{{ route('course') }}" class="th-btn style4">{{ $cms['hero_btn_2_text'] ?? 'EXPLORE COURSE' }} <svg class="ms-2"
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
                        <div class="img1 th_fade_anim">
                            <div class="thumb"><img class="img-cover"
                                    src="{{ asset($cms['about_image_1'] ?? 'frontend/img/normal/about_2_1.jpg') }}" alt="About" loading="lazy" decoding="async"></div>
                        </div>
                        <div class="img2 th_fade_anim">
                            <div class="thumb"><img class="img-cover"
                                    src="{{ asset($cms['about_image_2'] ?? 'frontend/img/normal/about_2_2.jpg') }}" alt="About" loading="lazy" decoding="async"></div>
                        </div>
                        <div class="about-shape2-1 jump"><img src="{{ asset('frontend/img/shape/about_shape2_1.png') }}" alt="img" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-wrap2">
                        <div class="title-area mb-35"><span class="sub-title text-theme th_fade_anim"><img
                                    src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img"> {{ $cms['about_subtitle'] ?? 'Get To Know About Us' }}</span>
                            <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">{{ $cms['about_title'] ?? "Pakistan's Trusted MDCAT Preparation Platform" }}</span></h2>
                            <p class="th_fade_anim">{{ $cms['about_description'] ?? 'DoctorsInnElite is dedicated to helping aspiring medical students crack MDCAT and secure admissions in top medical colleges. With expert instructors, structured course, and real exam-style mock tests — we prepare you for success.' }}</p>
                        </div>
                        <div class="row gy-40 gx-40">
                            <div class="col-md-6">
                                <div class="about-info-card">
                                    <h3 class="box-title th_fade_anim">{{ $cms['about_mission_title'] ?? 'OUR MISSION:' }}</h3>
                                    <p class="box-text th_fade_anim">{{ $cms['about_mission_text'] ?? 'To provide every medical aspirant with affordable, high-quality MDCAT preparation through structured course, mock tests, and expert mentorship.' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="about-info-card">
                                    <h3 class="box-title th_fade_anim">{{ $cms['about_vision_title'] ?? 'OUR VISION:' }}</h3>
                                    <p class="box-text th_fade_anim">{{ $cms['about_vision_text'] ?? "To become Pakistan's #1 online platform for medical entry test preparation — empowering students from every city and background." }}</p>
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
                    <div class="box-icon"><img src="{{ asset($cms['feature_1_icon'] ?? 'frontend/img/icon/counter-icon2-1.svg') }}" alt="icon" loading="lazy" decoding="async"></div>
                    <div class="box-content">
                        <h4 class="box-title">{{ $cms['feature_1_title'] ?? '8+ Online Courses' }}</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".3">
                    <div class="box-icon"><img src="{{ asset($cms['feature_2_icon'] ?? 'frontend/img/icon/counter-icon2-2.svg') }}" alt="icon" loading="lazy" decoding="async"></div>
                    <div class="box-content">
                        <h4 class="box-title">{{ $cms['feature_2_title'] ?? 'Lifetime Access' }}</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".4">
                    <div class="box-icon"><img src="{{ asset($cms['feature_3_icon'] ?? 'frontend/img/icon/counter-icon2-3.svg') }}" alt="icon" loading="lazy" decoding="async"></div>
                    <div class="box-content">
                        <h4 class="box-title">{{ $cms['feature_3_title'] ?? 'Value For Money' }}</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".5">
                    <div class="box-icon"><img src="{{ asset($cms['feature_4_icon'] ?? 'frontend/img/icon/counter-icon2-4.svg') }}" alt="icon" loading="lazy" decoding="async"></div>
                    <div class="box-content">
                        <h4 class="box-title">{{ $cms['feature_4_title'] ?? '24/7 Student Support' }}</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".6">
                    <div class="box-icon"><img src="{{ asset($cms['feature_5_icon'] ?? 'frontend/img/icon/counter-icon2-5.svg') }}" alt="icon" loading="lazy" decoding="async"></div>
                    <div class="box-content">
                        <h4 class="box-title">{{ $cms['feature_5_title'] ?? 'WhatsApp Community' }}</h4>
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
                                    src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">{{ $cms['process_subtitle'] ?? 'Work Process' }}</span>
                            <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">{{ $cms['process_title'] ?? 'How It Works' }}</span></h2>
                        </div>
                        <div class="process-card-wrap2">
                            <div class="process-card2 th_fade_anim">
                                <div class="box-number">01</div>
                                <div class="process-card-content">
                                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/process-card-icon1.svg') }}"
                                            alt="img" loading="lazy" decoding="async">
                                    </div>
                                    <div class="box-content">
                                        <h3 class="box-title">{{ $cms['process_step1_title'] ?? 'Register & Create Your Account' }}</h3>
                                        <p class="box-text">{{ $cms['process_step1_text'] ?? 'Sign up on DoctorsInnElite and create your free student account in minutes.' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="process-card2 th_fade_anim">
                                <div class="box-number">02</div>
                                <div class="process-card-content">
                                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/process-card-icon2.svg') }}"
                                            alt="img" loading="lazy" decoding="async">
                                    </div>
                                    <div class="box-content">
                                        <h3 class="box-title">{{ $cms['process_step2_title'] ?? 'Choose Your Course' }}</h3>
                                        <p class="box-text">{{ $cms['process_step2_text'] ?? 'Pick your MDCAT, NUMS, or AMC course and enroll instantly.' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="process-card2 th_fade_anim">
                                <div class="box-number">03</div>
                                <div class="process-card-content">
                                    <div class="box-icon"><img src="{{ asset('frontend/img/icon/process-card-icon3.svg') }}"
                                            alt="img" loading="lazy" decoding="async">
                                    </div>
                                    <div class="box-content">
                                        <h3 class="box-title">{{ $cms['process_step3_title'] ?? 'Learn & Ace Your Exam' }}</h3>
                                        <p class="box-text">{{ $cms['process_step3_text'] ?? 'Study lessons, attempt mock tests, and track your progress.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 align-self-end">
                    <div class="process-img-box2 th_fade_anim"><img src="{{ asset($cms['process_image'] ?? 'frontend/img/normal/process-thumb2-1.png') }}"
                            alt="img" loading="lazy" decoding="async">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.components.team-section', ['instructors' => $instructors ?? []])
    @include('frontend.components.course-promo-cards')

    <section class="testi-area-2 bg-color space overflow-hidden" id="testi-sec">
        <div class="container">

            <div class="title-area text-center"><span class="sub-title text-theme th_fade_anim"><img
                        src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">{{ $cms['testi_subtitle'] ?? 'Testimonials' }}</span>
                <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">{{ $cms['testi_title'] ?? 'What Our Students Say!' }}</span></h2>
            </div>

            <div class="testi-slider2 slider-area">
                <div class="swiper th-slider has-shadow" id="testiSlide2"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}},"autoHeight": "true"}'>
                    <div class="swiper-wrapper">
                        @php
                            $displayTestimonials = !empty($testimonials) ? $testimonials : [
                                ['headline' => 'AMC Exam Mein Pass Ho Gaya!', 'quote' => 'Every topic ka lecture, notes, aur MCQ practice sab kuch tha. Koi bhi problem hoti toh turant solve ho jati. Only because of this course I passed the AMC test!', 'student_name' => 'Muhammad Abdul Rafay', 'student_batch' => 'AMC — Ansaar Batch | Gujrat', 'avatar' => 'frontend/img/testimonial/testi_2_1.png', 'rating' => '5.0'],
                                ['headline' => 'Best Choice for PMA Preparation!', 'quote' => 'Lessons were clear, well-structured and easy to follow. I passed all my tests with excellent results. Truly the best choice for PMA prep!', 'student_name' => 'Hammad Gulzar', 'student_batch' => 'PMA — Iqbal Batch | Bahawalpur', 'avatar' => 'frontend/img/testimonial/testi_2_2.png', 'rating' => '5.0'],
                                ['headline' => 'Anytime Support — Always Available!', 'quote' => 'Lectures include all books and they give their best to make us understand everything. We asked any question anytime and they were always available. Thanks Sir!', 'student_name' => 'Amna', 'student_batch' => 'MDCAT Student', 'avatar' => 'frontend/img/testimonial/testi_2_3.png', 'rating' => '5.0'],
                            ];
                        @endphp
                        @foreach($displayTestimonials as $testi)
                        <div class="swiper-slide th_fade_anim">
                            <div class="testi-card2">
                                <div class="box-icon"><img src="{{ asset('frontend/img/icon/quote.svg') }}" alt="icon" loading="lazy" decoding="async"></div>
                                <h3 class="box-title">{{ $testi['headline'] }}</h3>
                                <p class="box-text">{{ $testi['quote'] }}</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> </span><span class="rating-title">{{ $testi['rating'] ?? '5.0' }}</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset($testi['avatar'] ?: 'frontend/img/testimonial/testi_2_1.png') }}" alt="{{ $testi['student_name'] }}" loading="lazy" decoding="async"></div>
                                    <div class="media-left">
                                        <h4 class="testi-card_name">{{ $testi['student_name'] }}</h4><span class="testi-card_desig">{{ $testi['student_batch'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
            <img src="{{ asset('frontend/img/icon/wave_shape_2.svg') }}" alt="img" loading="lazy" decoding="async">
        </div>
        <div class="faq-bg-shape1-2 shape-mockup th_fade_anim" data-speed="0.9" data-right="-15%" data-bottom="5%"><img
                src="{{ asset('frontend/img/icon/wave_bg_3.svg') }}" alt="img" loading="lazy" decoding="async"></div>
        <div class="container">
            <div class="row gy-40">
                <div class="col-xl-6">
                    <div class="faq-img-box1">
                        <div class="img1 th_fade_anim">
                            <div class="thumb"><img class="img-cover"
                                    src="{{ asset($cms['faq_image_1'] ?? 'frontend/img/normal/faq_1_1.jpg') }}" alt="img" loading="lazy" decoding="async"></div>
                        </div>
                        <div class="img2 th_fade_anim">
                            <div class="thumb"><img class="img-cover"
                                    src="{{ asset($cms['faq_image_2'] ?? 'frontend/img/normal/faq_1_2.jpg') }}" alt="img" loading="lazy" decoding="async"></div>
                        </div>
                        <div class="faq-counter-wrap jump">
                            <div class="thumb"><img src="{{ asset($cms['faq_counter_image'] ?? 'frontend/img/normal/volunteer-group2.png') }}" alt="img" loading="lazy" decoding="async">
                            </div>
                            <div class="box-details">
                                <h3 class="box-title">{{ $cms['faq_counter_number'] ?? '1K +' }}</h3>
                                <p class="box-text">{{ $cms['faq_counter_label'] ?? 'Active students' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="faq-wrap1">
                        <div class="title-area"><span class="sub-title text-theme th_fade_anim"><img
                                    src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">{{ $cms['faq_subtitle'] ?? "Faq's" }}</span>
                            <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">{{ $cms['faq_title'] ?? 'Frequently Asked Questions' }}</span></h2>
                        </div>
                        <div class="accordion" id="faqAccordion">
                            @php
                                $displayFaqs = !empty($homeFaqs) ? $homeFaqs : [
                                    ['question' => 'What courses does DoctorsInnElite offer?', 'answer' => 'We offer MDCAT, NUMS, AMC, and AFNS preparation courses including mock tests, full-length papers, and comprehensive test sessions.'],
                                    ['question' => 'Are the courses available online?', 'answer' => 'Yes! All our courses are 100% online. Study anytime, anywhere at your own pace.'],
                                    ['question' => 'How do I enroll in a course?', 'answer' => 'Simply create a free account, browse our courses, and click Enroll Now to get started.'],
                                ];
                            @endphp
                            @foreach($displayFaqs as $idx => $faqItem)
                            <div class="accordion-card th_fade_anim">
                                <div class="accordion-header" id="collapse-item-{{ $idx + 1 }}">
                                    <button class="accordion-button {{ $idx === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $idx + 1 }}" aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $idx + 1 }}">{{ $faqItem['question'] }}</button>
                                </div>
                                <div id="collapse-{{ $idx + 1 }}" class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p class="faq-text">{{ $faqItem['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
                $homeBlogs = array_slice($blogs ?? config('blogs', []), 0, 3);
            @endphp
            <div class="row gy-40 justify-content-center">
                @foreach ($homeBlogs as $blog)
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
