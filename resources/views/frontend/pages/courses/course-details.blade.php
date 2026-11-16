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
                                                        @php
                                                            $currTitle = $curr['title'] ?? ($curr['name'] ?? 'Module');
                                                            $currDesc = $curr['desc'] ?? ($curr['description'] ?? '');
                                                            if (empty($currDesc) && !empty($curr['chapters']) && is_array($curr['chapters'])) {
                                                                $chCount = count($curr['chapters']);
                                                                $topCount = 0;
                                                                foreach ($curr['chapters'] as $chItem) {
                                                                    $topCount += count($chItem['topics'] ?? []);
                                                                }
                                                                $currDesc = "{$chCount} Chapters • {$topCount} Topics & Quizzes";
                                                            }
                                                        @endphp
                                                        <li class="p-3 mb-3 rounded-3 legacy-inline-f5d80dce85">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-solid fa-circle-check text-theme me-3 fs-5"></i>
                                                                <div>
                                                                    <h6 class="mb-1 fw-bold text-title">{{ $currTitle }}</h6>
                                                                    @if(!empty($currDesc))
                                                                        <p class="mb-0 text-body small">{{ $currDesc }}</p>
                                                                    @endif
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
                                                    alt="{{ $course['instructor_info']['name'] ?? $course['instructor'] }}" loading="lazy" decoding="async">
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

                                        @if(session('review_success') || session('success'))
                                        <div class="alert alert-success d-flex align-items-center gap-2 py-2.5 px-3 mb-3 border-0 rounded-3 text-white font-13" style="background: #10B981;">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <span>{{ session('review_success') ?? session('success') }}</span>
                                        </div>
                                        @endif

                                        @if($errors->any())
                                        <div class="alert alert-danger py-2 px-3 mb-3 rounded-3 font-12 border-0" style="background: #FEF2F2; color: #991B1B;">
                                            <ul class="mb-0 ps-3">
                                                @foreach($errors->all() as $err)
                                                    <li>{{ $err }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        <div class="th-comments-wrap mt-0">
                                            <ul class="comment-list">
                                                @if (!empty($course['reviews']))
                                                    @foreach ($course['reviews'] as $rev)
                                                        <li class="review th-comment-item">
                                                            <div class="th-post-comment">
                                                                <div class="comment-avater">
                                                                    @if (!empty($rev['image']))
                                                                        <img src="{{ asset($rev['image']) }}"
                                                                            alt="{{ $rev['name'] }}" loading="lazy" decoding="async">
                                                                    @else
                                                                        <span class="review-avatar-initials"
                                                                            aria-label="{{ $rev['name'] }}">{{ strtoupper(substr($rev['name'] ?? 'S', 0, 1)) }}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="comment-content">
                                                                    <h4 class="name">{{ $rev['name'] }}</h4>
                                                                    <span class="commented-on"><i
                                                                            class="fal fa-calendar-alt"></i>{{ $rev['date'] ?? 'Recently' }}</span>
                                                                    <div class="star-rating" role="img"
                                                                        aria-label="Rated {{ $rev['rating'] }}.00 out of 5">
                                                                        <span class="star-rating-full">
                                                                            @for ($i = 0; $i < ($rev['rating'] ?? 5); $i++)
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
                                            <form method="POST" action="{{ route('courses.review.store', $course['slug']) }}">
                                                @csrf
                                                <input type="hidden" name="rating" id="reviewRatingInput" value="5">
                                                <div class="row">
                                                    <div class="form-group rating-select d-flex align-items-center">
                                                        <label>Your Rating</label>
                                                        <p class="stars selected"><span><a class="star-1" href="#" data-rating="1">1</a> <a
                                                                    class="star-2" href="#" data-rating="2">2</a> <a class="star-3"
                                                                    href="#" data-rating="3">3</a> <a class="star-4"
                                                                    href="#" data-rating="4">4</a> <a class="star-5 active"
                                                                    href="#" data-rating="5">5</a></span></p>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <textarea name="comment" placeholder="Write a Message" class="form-control" required>{{ old('comment') }}</textarea>
                                                        <i class="text-title far fa-pencil-alt"></i>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="text" name="name" placeholder="Your Name" class="form-control" value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" required>
                                                        <i class="text-title far fa-user"></i>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <input type="email" name="email" placeholder="Your Email" class="form-control" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}">
                                                        <i class="text-title far fa-envelope"></i>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <input id="reviewcheck" name="reviewcheck" type="checkbox" checked>
                                                        <label for="reviewcheck">Save my name, email, and website in this
                                                            browser for the next time I comment.</label>
                                                    </div>
                                                    <div class="col-12 form-group mb-0">
                                                        <button type="submit" class="th-btn">POST REVIEW</button>
                                                    </div>
                                                </div>
                                            </form>
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
                        <div class="widget widget_info widget_course_info course-sidebar-card">

                            <div class="th-video sidebar-video-frame">
                                <img src="{{ asset($course['detail_image'] ?? $course['image']) }}"
                                    alt="{{ $course['title'] }}">
                                <a href="https://www.youtube.com/watch?v=_sI_Ps7JSEk" class="play-btn popup-video" aria-label="Play course overview video">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>

                            @php
                                $priceRaw = trim((string)($course['price'] ?? 'Free'));
                                $numericPrice = preg_replace('/[^0-9]/', '', $priceRaw);
                                $isFree = empty($numericPrice) || $numericPrice === '0' || stripos($priceRaw, 'free') !== false;
                                $formattedPrice = $isFree ? 'Free' : ('Rs. ' . number_format((int)$numericPrice));

                                $origRaw = trim((string)($course['original_price'] ?? ''));
                                $numericOrig = preg_replace('/[^0-9]/', '', $origRaw);
                                $formattedOrig = ($numericOrig !== '' && $numericOrig !== '0') ? ('Rs. ' . number_format((int)$numericOrig)) : '';

                                $enrolled = auth()->check() && !empty($course['id'])
                                    && auth()->user()->hasAccessToCourse($course['id']);
                            @endphp

                            <div class="course-price-wrap">
                                <span class="course-price-main">{{ $formattedPrice }}</span>
                                @if(!empty($formattedOrig))
                                    <del class="course-price-del">{{ $formattedOrig }}</del>
                                @endif
                                @if(!empty($course['discount_tag']))
                                    <span class="course-price-badge">{{ $course['discount_tag'] }}</span>
                                @endif
                            </div>

                            <div class="sidebar-action-btns">
                                @if ($enrolled)
                                    <a href="{{ route('student.classroom', $course['slug']) }}" class="btn-course-action btn-course-primary">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        <span>Go to Classroom</span>
                                    </a>
                                @else
                                    <a href="{{ route('checkout', ['course' => $course['slug']]) }}" class="btn-course-action btn-course-primary" id="buy-now-btn">
                                        <i class="fa-solid fa-bolt"></i>
                                        <span>{{ !empty($course['is_free']) ? 'Enroll Free' : 'Enroll Now' }}</span>
                                        <i class="fa-solid fa-arrow-right font-11"></i>
                                    </a>
                                @endif
                                <a href="{{ route('course') }}" class="btn-course-action btn-course-secondary">
                                    <i class="fa-solid fa-compass"></i>
                                    <span>Browse All Courses</span>
                                </a>
                            </div>

                            <div class="sidebar-info-block">
                                <h3 class="sidebar-info-header">Course Information</h3>
                                <div class="sidebar-info-list">
                                    <ul>
                                        <li>
                                            <span class="info-label"><i class="fa-solid fa-user-tie"></i> Instructor:</span>
                                            <span class="info-val">{{ $course['instructor'] ?? 'DoctorsInn Faculty' }}</span>
                                        </li>
                                        <li>
                                            <span class="info-label"><i class="fa-solid fa-book-open"></i> Lessons:</span>
                                            <span class="info-val">{{ $course['lessons'] ?? '6 Lectures • 3 Quizzes' }}</span>
                                        </li>
                                        <li>
                                            <span class="info-label"><i class="fa-solid fa-clock"></i> Duration:</span>
                                            <span class="info-val">{{ $course['duration'] ?? 'Self-paced' }}</span>
                                        </li>
                                        <li>
                                            <span class="info-label"><i class="fa-solid fa-layer-group"></i> Course Level:</span>
                                            <span class="info-val">{{ $course['level'] ?? 'MDCAT Prep' }}</span>
                                        </li>
                                        <li>
                                            <span class="info-label"><i class="fa-solid fa-globe"></i> Language:</span>
                                            <span class="info-val">{{ $course['language'] ?? 'English / Urdu' }}</span>
                                        </li>
                                        <li>
                                            <span class="info-label"><i class="fa-solid fa-user-graduate"></i> Enrolled:</span>
                                            <span class="info-val">{{ $course['students'] ?? '500+ Students' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </aside>
                </div>

            </div>
        </div>
    </section>

    @php
        $currentStories = collect($course['success_stories'] ?? [])->map(function ($story) use ($course) {
            $story['course_title'] = $course['title'];
            return $story;
        });

        $otherStories = collect($courses)
            ->filter(fn($c) => ($c['slug'] ?? '') !== ($course['slug'] ?? ''))
            ->flatMap(function ($storyCourse) {
                return collect($storyCourse['success_stories'] ?? [])->map(function ($story) use ($storyCourse) {
                    $story['course_title'] = $storyCourse['title'];
                    return $story;
                });
            });

        $successStories = $currentStories->concat($otherStories)->take(6)->values();

        $proofJsonData = $successStories->map(function ($story) {
            return [
                'name' => $story['name'],
                'college' => $story['college'],
                'selection' => $story['selection'],
                'score' => $story['score'],
                'quote' => $story['quote'],
                'img' => asset($story['proof_image'] ?? 'frontend/img/proof/proof-1.png'),
            ];
        })->values();
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
                                            alt="{{ $story['name'] }}" loading="lazy" decoding="async">
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
                                    <button type="button" 
                                            class="whatsapp-proof-btn" data-proof-index="{{ $loop->index }}">
                                        <i class="fab fa-whatsapp me-2" aria-hidden="true"></i> View WhatsApp Proof
                                        <span class="proof-verified-chip ms-auto"><i class="fa-solid fa-check-double me-1"></i> Verified</span>
                                    </button>
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

<style>
/* Sleek Modern Course Details Card Proportions */
.course-single .course-single-top,
.course-single .course-single-bottom,
.widget_course_info.course-sidebar-card {
    border-radius: 14px !important;
    border: 1px solid rgba(15, 23, 42, 0.08) !important;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05) !important;
    padding: 22px !important;
}

/* Sidebar Video Preview */
.sidebar-video-frame {
    border-radius: 10px !important;
    overflow: hidden !important;
    position: relative !important;
    max-height: 200px !important;
    margin-bottom: 18px !important;
}
.sidebar-video-frame img {
    height: 190px !important;
    object-fit: cover !important;
    width: 100% !important;
}
.sidebar-video-frame .play-btn {
    --icon-size: 50px !important;
    width: 50px !important;
    height: 50px !important;
    font-size: 15px !important;
}

/* Price Box */
.course-price-wrap {
    display: flex !important;
    align-items: baseline !important;
    gap: 10px !important;
    margin: 16px 0 18px 0 !important;
    flex-wrap: wrap !important;
}
.course-price-main {
    font-size: 28px !important;
    font-weight: 800 !important;
    color: #0F172A !important;
    line-height: 1 !important;
    letter-spacing: -0.5px !important;
}
.course-price-del {
    font-size: 15px !important;
    color: #94A3B8 !important;
    font-weight: 500 !important;
}
.course-price-badge {
    font-size: 11px !important;
    font-weight: 700 !important;
    padding: 3px 8px !important;
    border-radius: 12px !important;
    background: #ECFDF5 !important;
    color: #059669 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.3px !important;
}

/* Sidebar Buttons Aligned */
.sidebar-action-btns {
    display: flex !important;
    flex-direction: column !important;
    gap: 9px !important;
    margin-bottom: 22px !important;
}
.btn-course-action {
    height: 46px !important;
    border-radius: 10px !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    letter-spacing: 0.2px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    padding: 0 16px !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
}
.btn-course-primary {
    background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%) !important;
    color: #FFFFFF !important;
    border: none !important;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.22) !important;
}
.btn-course-primary:hover {
    background: linear-gradient(135deg, #4338CA 0%, #3730A3 100%) !important;
    color: #FFFFFF !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(79, 70, 229, 0.3) !important;
}
.btn-course-secondary {
    background: #FFFFFF !important;
    color: #334155 !important;
    border: 1.5px solid #CBD5E1 !important;
}
.btn-course-secondary:hover {
    background: #F8FAFC !important;
    color: #0F172A !important;
    border-color: #94A3B8 !important;
    transform: translateY(-1px);
}

/* Course Information List */
.sidebar-info-header {
    font-size: 14.5px !important;
    font-weight: 700 !important;
    color: #0F172A !important;
    margin-bottom: 12px !important;
    padding-bottom: 8px !important;
    border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
}
.sidebar-info-list ul {
    list-style: none !important;
    padding: 0 !important;
    margin: 0 !important;
}
.sidebar-info-list li {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 8.5px 0 !important;
    font-size: 12.5px !important;
    border-bottom: 1px dashed rgba(15, 23, 42, 0.06) !important;
}
.sidebar-info-list li:last-child {
    border-bottom: none !important;
}
.sidebar-info-list li .info-label {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    color: #64748B !important;
    font-weight: 500 !important;
}
.sidebar-info-list li .info-label i {
    font-size: 13px !important;
    color: #6366F1 !important;
    width: 16px !important;
    text-align: center !important;
}
.sidebar-info-list li .info-val {
    color: #0F172A !important;
    font-weight: 600 !important;
}

/* Top Overview Card Clean Proportions */
.course-single-top .course-img {
    margin-bottom: 18px !important;
    border-radius: 10px !important;
    overflow: hidden !important;
}
.course-single-top .course-title {
    font-size: 26px !important;
    font-weight: 700 !important;
    margin-bottom: 6px !important;
}
.course-single-top .box-content {
    margin-top: 18px !important;
    padding: 12px 18px !important;
    gap: 24px !important;
    border-radius: 10px !important;
    background: #F8FAFC !important;
    border: 1px solid rgba(15, 23, 42, 0.06) !important;
}
.course-single-top .meta-box .meta-thumb img {
    width: 36px !important;
    height: 36px !important;
    border-radius: 50% !important;
}
.course-single-top .meta-box .box-name {
    font-size: 13px !important;
    font-weight: 700 !important;
}
.course-single-top .course-info .box-icon {
    font-size: 18px !important;
}
.course-single-top .course-info .course-info-title {
    font-size: 11px !important;
}
.course-single-top .course-info .course-info-text {
    font-size: 12.5px !important;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var starLinks = document.querySelectorAll('.rating-select p.stars a');
    var ratingInput = document.getElementById('reviewRatingInput');
    starLinks.forEach(function (star, index) {
        star.addEventListener('click', function (e) {
            e.preventDefault();
            var rating = index + 1;
            if (ratingInput) ratingInput.value = rating;
            var parentStars = this.closest('.stars');
            if (parentStars) {
                parentStars.classList.add('selected');
                parentStars.querySelectorAll('a').forEach(function (a, aIdx) {
                    if (aIdx === index) {
                        a.classList.add('active');
                    } else {
                        a.classList.remove('active');
                    }
                });
            }
        });
    });
});
</script>

@endsection

@section('extra_modal')
    <!-- WhatsApp Proof Modal Popup (Rendered outside smooth-wrapper) -->
    <div class="wa-proof-modal-overlay" id="waProofModal" >
        <div class="wa-proof-modal-card" >
            <div class="wa-proof-modal-header">
                <div class="wa-brand">
                    <div class="wa-icon-box">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-white font-weight-bold" id="waModalStudentName" class="wa-modal-student-title">Student Name</h4>
                        <small class="text-white-50" class="wa-modal-subtext"><i class="fa-solid fa-shield-check me-1"></i> Verified WhatsApp Chat Record</small>
                    </div>
                </div>
                <button type="button" class="wa-proof-modal-close"  aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <div class="wa-proof-modal-meta">
                <div>
                    <span class="me-3"><i class="fa-solid fa-graduation-cap me-1 text-success"></i> <strong id="waModalSelection">Selected</strong></span>
                    <span><i class="fa-solid fa-star me-1 text-warning"></i> <strong id="waModalScore">Status: PASS</strong></span>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <button type="button" class="wa-proof-nav-btn" id="waProofNavPrev" title="Previous Proof">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <span id="waModalCounter" class="px-2" class="wa-modal-counter-badge px-2">1 / 6</span>
                    <button type="button" class="wa-proof-nav-btn" id="waProofNavNext" title="Next Proof">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <div class="wa-proof-modal-body">
                <div class="wa-proof-img-frame">
                    <img id="waModalProofImg" src="" alt="WhatsApp Result Proof">
                </div>
            </div>

            <div class="wa-proof-modal-footer">
                <small class="text-muted" class="wa-modal-meta-hint">
                    <i class="fa-solid fa-circle-check text-success me-1"></i> 100% Authentic Result Feedback
                </small>
                <div class="d-flex gap-2">
                    <a id="waModalFullLink" href="#" target="_blank" class="btn btn-sm btn-outline-secondary" class="wa-modal-btn-view btn btn-sm btn-outline-secondary">
                        <i class="fa-solid fa-expand me-1"></i> Full Size
                    </a>
                    <button type="button" class="btn btn-sm btn-dark"  class="wa-modal-btn-view btn btn-sm btn-outline-secondary">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script type="application/json" id="wa-proofs-data">@json($proofJsonData)</script>
@endsection
