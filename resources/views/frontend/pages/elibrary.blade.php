@extends('frontend.layouts.main')
@section('title', 'E-Library | DoctorsInnElite')
@section('meta_description', 'Access free and premium study resources on DoctorsInnElite E-Library — MDCAT notes, past papers, formula sheets, MCQ banks and revision guides all in one place.')
@section('meta_keywords', 'MDCAT notes PDF, MDCAT past papers, biology notes MDCAT, chemistry formula sheet, physics notes MDCAT, MDCAT MCQ bank, free MDCAT resources')
@section('content')

    {{-- ======================== BREADCRUMB ======================== --}}
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">E-Library</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>E-Library</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== STATS BAR (same as index counter-wrap2) ======================== --}}
    <div class="space overflow-hidden bg-gradient">
        <div class="container">
            <div class="counter-wrap2">
                <div class="counter-card2 th_fade_anim" data-delay=".2">
                    <div class="box-icon">
                        <img src="{{ asset('frontend/img/icon/counter-icon2-1.svg') }}" alt="icon">
                    </div>
                    <div class="box-content">
                        <h4 class="box-title">50+ Free Resources</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".3">
                    <div class="box-icon">
                        <img src="{{ asset('frontend/img/icon/counter-icon2-2.svg') }}" alt="icon">
                    </div>
                    <div class="box-content">
                        <h4 class="box-title">6 Years Past Papers</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".4">
                    <div class="box-icon">
                        <img src="{{ asset('frontend/img/icon/counter-icon2-3.svg') }}" alt="icon">
                    </div>
                    <div class="box-content">
                        <h4 class="box-title">5000+ MCQs</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".5">
                    <div class="box-icon">
                        <img src="{{ asset('frontend/img/icon/counter-icon2-4.svg') }}" alt="icon">
                    </div>
                    <div class="box-content">
                        <h4 class="box-title">1000+ Students</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".6">
                    <div class="box-icon">
                        <img src="{{ asset('frontend/img/icon/counter-icon2-5.svg') }}" alt="icon">
                    </div>
                    <div class="box-content">
                        <h4 class="box-title">100% Free Access</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== FREE RESOURCES (same as feature-area-1 section) ======================== --}}
    <section class="feature-area-1 position-relative bg-color space overflow-hidden" id="free-resources">
        <div class="about-bg-shape3-1 shape-mockup th_fade_anim" data-speed="0.9" data-left="6%" data-top="20%">
            <img src="{{ asset('frontend/img/home/icons/wave_shape_2.svg') }}" alt="img">
        </div>
        <div class="about-bg-shape3-2 shape-mockup th_fade_anim" data-speed="0.9" data-right="6%" data-bottom="20%">
            <img src="{{ asset('frontend/img/home/icons/wave_shape_1.svg') }}" alt="img">
        </div>
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title text-theme th_fade_anim">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Your Study Hub
                </span>
                <h2 class="sec-title th_fade_anim">
                    <span class="th-text-perspective">Free Resources — No Login Required</span>
                </h2>
                <p class="th_fade_anim">Access free notes, past papers, formula sheets, and MCQ banks — all in one place. Your complete study resource center by DoctorsInnElite.</p>
            </div>

            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".2">
                    <div class="feature-card">
                        <div class="box-icon">
                            <img src="{{ asset('frontend/img/home/icons/feature_card_icon1.svg') }}" alt="icon">
                        </div>
                        <h3 class="box-title">MDCAT 2026 Syllabus Guide</h3>
                        <p class="box-text">Complete PMC-approved syllabus breakdown for Biology, Chemistry, Physics, and English.</p>
                        <div class="btn-wrap mt-35">
                            <a href="#" class="th-btn btn-sm style4 elib-btn">DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".3">
                    <div class="feature-card">
                        <div class="box-icon">
                            <img src="{{ asset('frontend/img/home/icons/feature_card_icon2.svg') }}" alt="icon">
                        </div>
                        <h3 class="box-title">Biology Quick Revision Sheet</h3>
                        <p class="box-text">Important definitions, diagrams, and key concepts for MDCAT Biology in one sheet.</p>
                        <div class="btn-wrap mt-35">
                            <a href="#" class="th-btn btn-sm style4 elib-btn">DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".4">
                    <div class="feature-card">
                        <div class="box-icon">
                            <img src="{{ asset('frontend/img/home/icons/feature_card_icon3.svg') }}" alt="icon">
                        </div>
                        <h3 class="box-title">Chemistry Formula Sheet</h3>
                        <p class="box-text">All important organic and inorganic chemistry reactions, equations, and formulas.</p>
                        <div class="btn-wrap mt-35">
                            <a href="#" class="th-btn btn-sm style4 elib-btn">DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".5">
                    <div class="feature-card">
                        <div class="box-icon">
                            <img src="{{ asset('frontend/img/home/icons/feature_card_icon1.svg') }}" alt="icon">
                        </div>
                        <h3 class="box-title">Physics Formula Sheet</h3>
                        <p class="box-text">Complete list of physics formulas, units, and constants required for MDCAT.</p>
                        <div class="btn-wrap mt-35">
                            <a href="#" class="th-btn btn-sm style4 elib-btn">DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay=".6">
                    <div class="feature-card">
                        <div class="box-icon">
                            <img src="{{ asset('frontend/img/home/icons/feature_card_icon2.svg') }}" alt="icon">
                        </div>
                        <h3 class="box-title">MDCAT Preparation Tips &amp; Strategy</h3>
                        <p class="box-text">Expert tips on time management, exam strategy, and how to attempt MDCAT smartly.</p>
                        <div class="btn-wrap mt-35">
                            <a href="#" class="th-btn btn-sm style4 elib-btn">DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== MEMBERS ONLY — PAST PAPERS ======================== --}}
    <section class="overflow-hidden space" id="members-resources">
        <div class="container">

            <div class="title-area text-center">
                <span class="sub-title text-theme th_fade_anim">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Members Only
                </span>
                <h2 class="sec-title th_fade_anim">
                    <span class="th-text-perspective">Login or Enroll to Access Full Library</span>
                </h2>
                <p class="th_fade_anim">These resources are exclusively available for DoctorsInnElite registered students.</p>
            </div>

            {{-- Category: Past Papers --}}
            <div class="elib-cat-row th_fade_anim">
                <span class="sub-title text-theme">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Past Papers
                </span>
            </div>
            <div class="row gy-4 justify-content-center">
                @php
                $pastPapers = [
                    ['title' => 'MDCAT Past Papers 2019–2024', 'desc' => 'Complete past papers with answer keys and detailed explanations — 6 years collection.', 'icon' => 'feature_card_icon1.svg'],
                    ['title' => 'NUMS Past Papers 2020–2024',  'desc' => 'NUMS entry test past papers with complete solution keys and analysis.',              'icon' => 'feature_card_icon2.svg'],
                    ['title' => 'AMC Past Papers 2021–2024',   'desc' => 'Armed Forces Medical College entry test papers with detailed answer keys.',           'icon' => 'feature_card_icon3.svg'],
                ];
                @endphp
                @foreach ($pastPapers as $i => $item)
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay="{{ 0.1 * ($i + 2) }}">
                    <div class="feature-card elib-locked-card">
                        <div class="elib-lock-overlay">
                            <div class="elib-lock-inner">
                                <i class="fa-solid fa-lock"></i>
                                <span>Members Only</span>
                                <a href="{{ route('login') }}" class="th-btn btn-sm">LOGIN TO ACCESS <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0" stroke="currentColor" stroke-width="1.5"></path></svg></a>
                            </div>
                        </div>
                        <div class="box-icon">
                            <img src="{{ asset('frontend/img/home/icons/' . $item['icon']) }}" alt="icon">
                        </div>
                        <h3 class="box-title">{{ $item['title'] }}</h3>
                        <p class="box-text">{{ $item['desc'] }}</p>
                        <div class="btn-wrap mt-35">
                            <a href="{{ route('login') }}" class="th-btn btn-sm style4 elib-btn">DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ======================== COMPLETE NOTES (bg-color alternate) ======================== --}}
    <section class="overflow-hidden space bg-color" id="notes-sec">
        <div class="container">

            <div class="elib-cat-row th_fade_anim">
                <span class="sub-title text-theme">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Complete Notes
                </span>
            </div>
            <div class="row gy-4 justify-content-center">
                @php
                $notes = [
                    ['title' => 'Biology Complete Notes',             'desc' => 'Chapter-wise detailed notes covering entire MDCAT Biology syllabus with diagrams and MCQs.',  'icon' => 'feature_card_icon1.svg'],
                    ['title' => 'Chemistry Complete Notes',           'desc' => 'Organic, Inorganic and Physical Chemistry full notes with practice questions.',               'icon' => 'feature_card_icon2.svg'],
                    ['title' => 'Physics Complete Notes',             'desc' => 'All Physics chapters with solved numericals, key concepts and MDCAT MCQs.',                   'icon' => 'feature_card_icon3.svg'],
                    ['title' => 'English & Logical Reasoning Notes',  'desc' => 'Grammar rules, vocabulary lists, and logical reasoning practice questions.',                  'icon' => 'feature_card_icon1.svg'],
                ];
                @endphp
                @foreach ($notes as $i => $item)
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay="{{ 0.1 * ($i + 2) }}">
                    <div class="feature-card elib-locked-card">
                        <div class="elib-lock-overlay">
                            <div class="elib-lock-inner">
                                <i class="fa-solid fa-lock"></i>
                                <span>Members Only</span>
                                <a href="{{ route('login') }}" class="th-btn btn-sm">LOGIN TO ACCESS <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0" stroke="currentColor" stroke-width="1.5"></path></svg></a>
                            </div>
                        </div>
                        <div class="box-icon">
                            <img src="{{ asset('frontend/img/home/icons/' . $item['icon']) }}" alt="icon">
                        </div>
                        <h3 class="box-title">{{ $item['title'] }}</h3>
                        <p class="box-text">{{ $item['desc'] }}</p>
                        <div class="btn-wrap mt-35">
                            <a href="{{ route('login') }}" class="th-btn btn-sm style4 elib-btn">DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ======================== MCQ BANKS ======================== --}}
    <section class="overflow-hidden space" id="mcq-sec">
        <div class="container">

            <div class="elib-cat-row th_fade_anim">
                <span class="sub-title text-theme">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">MCQ Banks
                </span>
            </div>
            <div class="row gy-4 justify-content-center">
                @php
                $mcqs = [
                    ['title' => 'Biology MCQ Bank — 2000+ MCQs',   'desc' => 'Topic-wise MCQs with answers covering complete MDCAT Biology syllabus.',            'icon' => 'feature_card_icon1.svg'],
                    ['title' => 'Chemistry MCQ Bank — 1500+ MCQs', 'desc' => 'Chapter-wise chemistry MCQs with detailed explanations and answer keys.',           'icon' => 'feature_card_icon2.svg'],
                    ['title' => 'Physics MCQ Bank — 1000+ MCQs',   'desc' => 'Physics practice MCQs with solved solutions and concept explanations.',             'icon' => 'feature_card_icon3.svg'],
                    ['title' => 'English MCQ Bank — 500+ MCQs',    'desc' => 'Grammar, vocabulary and comprehension MCQs for MDCAT English preparation.',         'icon' => 'feature_card_icon1.svg'],
                ];
                @endphp
                @foreach ($mcqs as $i => $item)
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay="{{ 0.1 * ($i + 2) }}">
                    <div class="feature-card elib-locked-card">
                        <div class="elib-lock-overlay">
                            <div class="elib-lock-inner">
                                <i class="fa-solid fa-lock"></i>
                                <span>Members Only</span>
                                <a href="{{ route('login') }}" class="th-btn btn-sm">LOGIN TO ACCESS <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0" stroke="currentColor" stroke-width="1.5"></path></svg></a>
                            </div>
                        </div>
                        <div class="box-icon">
                            <img src="{{ asset('frontend/img/home/icons/' . $item['icon']) }}" alt="icon">
                        </div>
                        <h3 class="box-title">{{ $item['title'] }}</h3>
                        <p class="box-text">{{ $item['desc'] }}</p>
                        <div class="btn-wrap mt-35">
                            <a href="{{ route('login') }}" class="th-btn btn-sm style4 elib-btn">DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ======================== REVISION GUIDES (bg-color alternate) ======================== --}}
    <section class="overflow-hidden space bg-color" id="revision-sec">
        <div class="container">

            <div class="elib-cat-row th_fade_anim">
                <span class="sub-title text-theme">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Revision Guides
                </span>
            </div>
            <div class="row gy-4 justify-content-center">
                @php
                $guides = [
                    ['title' => '7-Day Rapid Revision Plan',     'desc' => 'Last week before MDCAT? This 7-day plan covers all high-yield topics quickly.',                  'icon' => 'feature_card_icon1.svg'],
                    ['title' => 'High-Yield Topics Guide',        'desc' => 'Most repeated MDCAT topics from last 5 years — focus here for maximum marks.',                    'icon' => 'feature_card_icon2.svg'],
                    ['title' => 'Mistakes to Avoid in MDCAT',    'desc' => 'Common mistakes students make in MDCAT and how to avoid them on exam day.',                       'icon' => 'feature_card_icon3.svg'],
                ];
                @endphp
                @foreach ($guides as $i => $item)
                <div class="col-lg-4 col-md-6 th_fade_anim" data-delay="{{ 0.1 * ($i + 2) }}">
                    <div class="feature-card elib-locked-card">
                        <div class="elib-lock-overlay">
                            <div class="elib-lock-inner">
                                <i class="fa-solid fa-lock"></i>
                                <span>Members Only</span>
                                <a href="{{ route('login') }}" class="th-btn btn-sm">LOGIN TO ACCESS <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0" stroke="currentColor" stroke-width="1.5"></path></svg></a>
                            </div>
                        </div>
                        <div class="box-icon">
                            <img src="{{ asset('frontend/img/home/icons/' . $item['icon']) }}" alt="icon">
                        </div>
                        <h3 class="box-title">{{ $item['title'] }}</h3>
                        <p class="box-text">{{ $item['desc'] }}</p>
                        <div class="btn-wrap mt-35">
                            <a href="{{ route('login') }}" class="th-btn btn-sm style4 elib-btn">DOWNLOAD PDF</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ======================== BOTTOM CTA (identical to index cta-area-2) ======================== --}}
    @include('frontend.components.course-promo-cards')

@endsection
