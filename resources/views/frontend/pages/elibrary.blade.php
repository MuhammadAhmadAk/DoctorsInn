@extends('frontend.layouts.main')
@section('title', 'Free E-Library — MDCAT, NUMS & AMC Study Resources | DoctorsInnElite')
@section('meta_description', 'Download free PMC approved MDCAT notes, NUMS solved past papers, AMC intelligence question banks, chemistry formula sheets, and physics numerical shortcuts — 100% free PDF download.')
@section('meta_keywords', 'MDCAT notes PDF, MDCAT past papers free download, NUMS past papers solved, AMC intelligence tests, free medical study resources, PMC syllabus 2026')
@section('content')

    {{-- ======================== BREADCRUMB ======================== --}}
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">E-Library & Study Resources</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>E-Library</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== STATS BAR ======================== --}}
    <div class="space overflow-hidden bg-gradient">
        <div class="container">
            <div class="counter-wrap2">
                <div class="counter-card2 th_fade_anim" data-delay=".2">
                    <div class="box-icon">
                        <img src="{{ asset('frontend/img/icon/counter-icon2-1.svg') }}" alt="icon">
                    </div>
                    <div class="box-content">
                        <h4 class="box-title">50+ Free PDFs</h4>
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
                        <h4 class="box-title">5000+ Solved MCQs</h4>
                    </div>
                </div>
                <div class="counter-card2 th_fade_anim" data-delay=".5">
                    <div class="box-icon">
                        <img src="{{ asset('frontend/img/icon/counter-icon2-4.svg') }}" alt="icon">
                    </div>
                    <div class="box-content">
                        <h4 class="box-title">10,000+ Downloads</h4>
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

    {{-- ======================== MAIN E-LIBRARY RESOURCES ======================== --}}
    <section class="space bg-white" id="elibrary-resources-section">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title text-theme th_fade_anim">
                    <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">DoctorsInn E-Library
                </span>
                <h2 class="sec-title th_fade_anim">
                    <span class="th-text-perspective">Free Study Resources & PDF Downloads</span>
                </h2>
                <p class="th_fade_anim max-width-700 mx-auto">
                    Download official past papers with keys, high-yield chapter notes, chemistry reaction sheets, and shortcut guides. All resources are completely free for all medical aspirants.
                </p>
            </div>

            {{-- Category Filter Tabs (Matching Courses Style) --}}
            <div class="course-tab-wrap text-center mb-45 th_fade_anim" data-delay=".2">
                <div class="tab-menu1 course-category-tabs" role="tablist">
                    @foreach ($resourceCategories as $catKey => $catData)
                        <button class="tab-btn elib-filter-btn {{ $loop->first ? 'active' : '' }}" 
                                data-filter="{{ $catKey }}" 
                                type="button">
                            <i class="{{ $catData['icon'] }} me-2"></i>{{ $catData['label'] }}
                            <span class="tab-badge ms-2">{{ $catData['resources']->count() }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Search & Live Filter Bar --}}
            <div class="row justify-content-center mb-40">
                <div class="col-lg-6 col-md-8">
                    <div class="elib-search-box">
                        <i class="fal fa-search search-icon"></i>
                        <input type="text" id="elibSearchInput" class="form-control" placeholder="Search notes, past papers, subjects (e.g. Biology, Chemistry, 2025)...">
                        <button type="button" id="elibSearchClear" class="clear-btn d-none">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Resource Cards Grid --}}
            <div class="th-course-row columns-3" id="elibResourceGrid">
                @forelse ($allResources as $resource)
                    <div class="th-course-single elib-resource-item th_fade_anim" 
                         data-delay=".3" 
                         data-category="{{ $resource['category'] ?? 'mdcat' }}"
                         data-exam="{{ $resource['exam_category'] ?? '' }}"
                         data-title="{{ strtolower($resource['title']) }}"
                         data-subject="{{ strtolower($resource['subject']) }}">
                        @include('frontend.components.elibrary-card', ['resource' => $resource])
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No resources available at the moment. Please check back soon.</p>
                    </div>
                @endforelse
            </div>

            {{-- No Results Match Placeholder --}}
            <div id="elibNoResults" class="text-center py-5 d-none">
                <div class="mb-3 text-muted elib-empty-icon">
                    <i class="fal fa-file-search"></i>
                </div>
                <h4 class="h5">No matching study material found</h4>
                <p class="text-muted">Try adjusting your search keyword or click "All Resources" above.</p>
                <button type="button" class="th-btn btn-sm mt-2 elib-reset-all-btn">View All Resources</button>
            </div>

        </div>
    </section>

    {{-- ======================== CTA BANNER FOR TESTS ======================== --}}
    <section class="space bg-theme overflow-hidden" data-bg-src="{{ asset('frontend/img/bg/cta-bg5-1.png') }}">
        <div class="container">
            <div class="row gy-40 justify-content-between align-items-center">
                <div class="col-xxl-7 col-xl-7 col-lg-7">
                    <div class="title-area mb-0 text-lg-start text-center">
                        <span class="sub-title text-white">Online Exam Simulator</span>
                        <h2 class="sec-title text-white">Ready to Test Your Knowledge? <span class="fw-normal">Take Free Mock Tests!</span></h2>
                        <p class="text-white mb-0 mt-20">Attempt realistic MDCAT, NUMS & AMC chapter-wise and full-length online MCQs tests with instant scorecard and detailed solutions.</p>
                    </div>
                </div>
                <div class="col-lg-auto text-center">
                    <div class="btn-wrap justify-content-center">
                        <a href="{{ route('tests') }}" class="th-btn style5">
                            START MOCK TEST
                            <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
