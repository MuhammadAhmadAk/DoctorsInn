@extends('frontend.layouts.main')
@section('title', 'Online Mock Tests & MCQs Practice | DoctorsInnElite')
@section('meta_description', 'Attempt free online MDCAT, NUMS & AMC mock tests and MCQs with instant scoring, timer, and detailed explanations.')
@section('meta_keywords', 'MDCAT mock test online, NUMS biology MCQs test, AMC practice test, free medical test simulator, PMDC mock exam')
@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Online Mock Tests & MCQs</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Mock Tests</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tests Section --}}
    <section class="space bg-white" id="tests-list-section">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title text-theme th_fade_anim">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Exam Practice Simulator
                </span>
                <h2 class="sec-title th_fade_anim">
                    <span class="th-text-perspective">Medical Entrance Exam Mock Tests</span>
                </h2>
                <p class="th_fade_anim max-width-700 mx-auto">
                    Practice with realistic online test simulations. Instant results, detailed answer explanations, and negative marking analysis to boost your preparation.
                </p>
            </div>

            {{-- Category Filter Tabs (Same pill style as courses & e-library) --}}
            <div class="course-tab-wrap text-center mb-45 th_fade_anim" data-delay=".2">
                <div class="tab-menu1 course-category-tabs" role="tablist">
                    @foreach ($testCategories as $catKey => $catData)
                        <button class="tab-btn test-filter-btn {{ $loop->first ? 'active' : '' }}" 
                                data-filter="{{ $catKey }}" 
                                type="button">
                            <i class="{{ $catData['icon'] }} me-2"></i>{{ $catData['label'] }}
                            <span class="tab-badge ms-2">{{ $catData['tests']->count() }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Login Status Notice --}}
            @php
                $currentUser = auth()->user() ?? session('user');
            @endphp

            @if (!$currentUser)
                <div class="test-auth-notice mb-40 text-center th_fade_anim">
                    <div class="notice-pill d-inline-flex align-items-center gap-2 px-3 py-2">
                        <i class="fa-solid fa-circle-info text-theme"></i>
                        <span>Please <strong>Log In</strong> to your student account to attempt mock tests.</span>
                        <a href="{{ route('login', ['redirect' => route('tests')]) }}" class="text-theme fw-bold text-decoration-underline ms-1">Log In Now &rarr;</a>
                    </div>
                </div>
            @endif

            {{-- Test Cards Grid --}}
            <div class="th-course-row columns-3" id="testsGrid">
                @forelse ($allTests as $testItem)
                    <div class="th-course-single test-filter-item th_fade_anim" 
                         data-delay=".3" 
                         data-category="{{ $testItem['category'] ?? 'mdcat' }}">
                        
                        <div class="course-card">
                            <div class="box-img">
                                <a href="{{ route('test.take', $testItem['slug']) }}">
                                    <img src="{{ asset($testItem['image']) }}" alt="{{ $testItem['title'] }}">
                                </a>
                                @if (!empty($testItem['badge']))
                                    <span class="course-success-badge">
                                        <i class="fa-solid fa-award" aria-hidden="true"></i>{{ $testItem['badge'] }}
                                    </span>
                                @endif
                                <span class="box-price">FREE</span>
                            </div>

                            <h3 class="box-title">
                                <a href="{{ route('test.take', $testItem['slug']) }}">
                                    {{ $testItem['title'] }}
                                </a>
                            </h3>

                            <div class="box-rating">
                                <div class="star-rating" role="img" aria-label="Rated 5 out of 5">
                                    <span class="star-rating-full">
                                        Rated <strong class="rating">5.0</strong> out of 5
                                    </span>
                                </div>
                                <span class="ms-2">⭐ 5.0 ({{ $testItem['attempts'] ?? '1k+' }} attempts)</span>
                            </div>

                            <div class="box-content">
                                <div class="course-info">
                                    <div class="box-icon"><i class="fal fa-list-check"></i></div>
                                    <div class="course-info-details">
                                        <span class="course-info-title">Questions:</span>
                                        <h4 class="course-info-text">{{ $testItem['total_questions'] }} MCQs</h4>
                                    </div>
                                </div>
                                <div class="course-info">
                                    <div class="box-icon"><i class="fal fa-stopwatch"></i></div>
                                    <div class="course-info-details">
                                        <span class="course-info-title">Time Limit:</span>
                                        <h4 class="course-info-text">{{ $testItem['duration_minutes'] }} Mins</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="btn-wrap">
                                <div class="meta-box">
                                    <div class="meta-thumb test-card-thumb-badge">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="box-name"><a href="#">{{ $testItem['category_name'] }}</a></h5>
                                    </div>
                                </div>
                                <a href="{{ route('test.take', $testItem['slug']) }}" class="th-btn btn-sm style-border2">
                                    START TEST
                                    <svg class="ms-2" width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0" stroke="currentColor" stroke-width="1.5"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No mock tests available at the moment. Please check back soon.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    {{-- How It Works Section --}}
    <section class="space bg-smoke overflow-hidden">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title text-theme">Exam Practice Guide</span>
                <h2 class="sec-title">How To Take Online Tests</h2>
            </div>
            <div class="row gy-30 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="test-step-card text-center">
                        <div class="step-num">1</div>
                        <div class="step-icon">
                            <i class="fa-solid fa-user-lock"></i>
                        </div>
                        <h4 class="step-title">Login Your Account</h4>
                        <p class="step-text">Sign in to your free student account so your test score, progress, and review are saved.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="test-step-card text-center">
                        <div class="step-num">2</div>
                        <div class="step-icon">
                            <i class="fa-solid fa-stopwatch-20"></i>
                        </div>
                        <h4 class="step-title">Attempt MCQs With Timer</h4>
                        <p class="step-text">Solve high-yield MCQs within the realistic exam time limit using our interactive question palette.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="test-step-card text-center">
                        <div class="step-num">3</div>
                        <div class="step-icon">
                            <i class="fa-solid fa-square-poll-vertical"></i>
                        </div>
                        <h4 class="step-title">Instant Scorecard & Review</h4>
                        <p class="step-text">Receive an immediate result with percentage, correct/wrong breakdown, and detailed explanations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
