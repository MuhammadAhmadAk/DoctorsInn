@extends('frontend.layouts.main')
@section('title', 'About Us | DoctorsInnElite')
@section('meta_description', 'Learn about DoctorsInnElite — Pakistan trusted MDCAT preparation platform. Our mission is to empower every medical aspirant with expert guidance, structured courses, and proven results.')
@section('meta_keywords', 'about DoctorsInnElite, MDCAT platform Pakistan, medical entry test preparation, MDCAT experts Pakistan')
@section('content')


    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">About Us</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>About us</li>
                        </ul>
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
                            <p class="th_fade_anim">DoctorsInnElite is dedicated to helping aspiring medical students crack
                                MDCAT and secure admissions in top medical colleges. With expert instructors, structured
                                course, and real exam-style mock tests — we prepare you
                                for success.</p>
                        </div>
                        <div class="row gy-40 gx-40">
                            <div class="col-md-6">
                                <div class="about-info-card">
                                    <h3 class="box-title th_fade_anim">OUR MISSION:</h3>
                                    <p class="box-text th_fade_anim">To provide every medical aspirant with affordable,
                                        high-quality MDCAT preparation through structured course, mock tests, and expert
                                        mentorship.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="about-info-card">
                                    <h3 class="box-title th_fade_anim">OUR VISION:</h3>
                                    <p class="box-text th_fade_anim">To become Pakistan's #1 online platform for medical
                                        entry test preparation — empowering students from every city and background.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-bottom overflow-hidden">
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
    </div>

    <section class="space-bottom overflow-hidden">
        <div class="why-bg-shape2-1 shape-mockup th_fade_anim" data-speed="0.9" data-right="6%" data-bottom="18%"><img
                src="{{ asset('frontend/img/shape/hero_shape10_1.png') }}" alt="img"></div>
        <div class="container">
            <div class="row gy-40">
                <div class="col-xl-6">
                    <div class="why-img-box2">
                        <div class="img1 th_fade_anim"><img src="{{ asset('frontend/img/normal/why-thumb2-1.png') }}" alt="img">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 align-self-end">
                    <div class="why-wrap2">
                        <div class="title-area mb-30"><span class="sub-title text-theme th_fade_anim"><img
                                    src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Why Choose Us</span>
                            <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">Built For
                                    Medical Aspirants, By Experts</span></h2>
                            <p class="th_fade_anim">DoctorsInnElite offers a focused, exam-ready learning experience
                                designed specifically for MDCAT, NUMS, and AMC students</p>
                        </div>
                        <div class="checklist style2 th_fade_anim">
                            <ul>
                                <li>Learn from MDCAT Expert Instructors</li>
                                <li>100% Online & Study Anytime</li>
                                <li>Affordable course, Big Results</li>
                                <li>Mock Tests & Progress Tracking</li>
                            </ul>
                        </div>
                        <div class="btn-wrap mt-35 th_fade_anim"><a href="{{ route('contact') }}" class="th-btn">GET
                                STARTED <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="feature-area-1 position-relative bg-color space overflow-hidden">
        <div class="about-bg-shape3-1 shape-mockup th_fade_anim" data-speed="0.9" data-left="6%" data-top="20%">
            <img src="{{ asset('frontend/img/home/icons/wave_shape_2.svg') }}" alt="img">
        </div>
        <div class="about-bg-shape3-2 shape-mockup th_fade_anim" data-speed="0.9" data-right="6%" data-bottom="20%"><img
                src="{{ asset('frontend/img/home/icons/wave_shape_1.svg') }}" alt="img"></div>
        <div class="container">
            <div class="title-area text-center"><span class="sub-title text-theme th_fade_anim"><img
                        src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">What we do</span>
                <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">Your Path To Medical
                        Success Starts Here</span></h2>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".3">
                    <div class="feature-card">
                        <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/feature_card_icon1.svg') }}" alt="icon">
                        </div>
                        <h3 class="box-title">Learn From Anywhere</h3>
                        <p class="box-text">Study MDCAT, NUMS, and AMC course online — anytime, anywhere, at your own pace.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".5">
                    <div class="feature-card">
                        <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/feature_card_icon2.svg') }}" alt="icon">
                        </div>
                        <h3 class="box-title">Expert Instructor</h3>
                        <p class="box-text">Learn from experienced medical educators who know exactly what it takes to
                            crack entry tests.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".7">
                    <div class="feature-card">
                        <div class="box-icon"><img src="{{ asset('frontend/img/home/icons/feature_card_icon3.svg') }}" alt="icon">
                        </div>
                        <h3 class="box-title">24/7 Student Support</h3>
                        <p class="box-text">Got a question? Our support team is available around the clock via WhatsApp and
                            email.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="testi-area-2 space overflow-hidden" id="testi-sec">
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
                                <p class="box-text">DoctorsInnElite gave me the structure I needed. Their mock tests were
                                    exactly like the real exam!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> </span><span class="rating-title">4.8
                                        (8k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}" alt="img"></div>
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
                                <p class="box-text">The 60-day program kept me consistent. I improved my score by 40 marks
                                    in just 3 weeks!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> </span><span class="rating-title">4.6
                                        (5k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_2.png') }}"
                                            alt="img"></div>
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
                                <p class="box-text">Amazing course quality at a very affordable price. The instructor
                                    support is outstanding!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> </span><span class="rating-title">4.9
                                        (10k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_3.png') }}"
                                            alt="img"></div>
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
                                <p class="box-text">DoctorsInnElite gave me the structure I needed. Their mock tests were
                                    exactly like the real exam!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> </span><span class="rating-title">4.8
                                        (8k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}"
                                            alt="img"></div>
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
                                <p class="box-text">The 60-day program kept me consistent. I improved my score by 40 marks
                                    in just 3 weeks!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> </span><span class="rating-title">4.6
                                        (5k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_2.png') }}"
                                            alt="img"></div>
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
                                <p class="box-text">Amazing course quality at a very affordable price. The instructor
                                    support is outstanding!</p>
                                <div class="testi-review-wrap"><span class="testi-card_review"><i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> <i class="fas fa-star"></i> <i
                                            class="fas fa-star"></i> </span><span class="rating-title">4.9
                                        (10k)</span></div>
                                <div class="testi-card-profile">
                                    <div class="box-thumb"><img src="{{ asset('frontend/img/testimonial/testi_2_3.png') }}"
                                            alt="img"></div>
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

    @include('frontend.components.course-promo-cards')

@endsection
