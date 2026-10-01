@extends('frontend.layouts.main')
@section('title', 'My Courses | DoctorsInnElite')
@section('meta_description', 'Access your enrolled courses on DoctorsInnElite. Continue your MDCAT preparation, track your progress, and access all lessons, notes and mock tests.')
@section('meta_keywords', 'my courses DoctorsInnElite, enrolled courses, MDCAT student dashboard, course progress')
@section('content')

    <!-- Banner Breadcrumb -->
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title" id="course-title-banner">{{ $activeCourse['title'] ?? 'My Courses' }}</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('my-courses') }}">My Courses</a></li>
                            <li id="course-breadcrumb-name">{{ $activeCourse['title'] ?? 'Course Content' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Learning Dashboard Grid -->
    <section class="space-top space-bottom bg-color overflow-hidden">
        <div class="container">
            <div class="row gy-4">

                <!-- Left Column: Syllabus Menu and Progress -->
                <div class="col-lg-4">
                    <div class="d-flex flex-column gap-4">

                        <!-- Enrolled Course Selector Card -->
                        <div class="sidebar-widget-card p-4 rounded-3 border legacy-inline-9adb5d62cb"
                           >
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-xs text-uppercase fw-bold text-muted"><i
                                        class="fal fa-graduation-cap me-1 text-theme-color"></i> Enrolled Course</span>
                                <span
                                    class="badge bg-success-subtle text-success text-xs px-2 py-1 radius-4 font-semibold">Active
                                    Enrollment</span>
                            </div>
                            <select id="enrolledCourseSelect"
                                class="form-select form-select-sm rounded-3 fw-semibold text-title"
                                data-instructor-image="{{ asset($activeCourse['instructor_info']['image'] ?? $activeCourse['instructor_image'] ?? 'frontend/img/course/course-thumb1-1.png') }}"
                                data-student-avatar="{{ asset('frontend/img/normal/faq_1_2.jpg') }}"
                                data-course-url="{{ route('my-courses') }}">
                                @foreach ($courses as $c)
                                    <option value="{{ $c['slug'] }}"
                                        {{ ($activeCourseSlug ?? '') === $c['slug'] ? 'selected' : '' }}>
                                        {{ $c['title'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Progress Tracker Card -->
                        <div class="sidebar-widget-card p-4 rounded-3 border legacy-inline-9adb5d62cb"
                           >
                            <h4 class="h5 fw-bold text-title mb-3 font-title">Learning Progress</h4>
                            <div class="progress-bar-container">
                                <div class="d-flex justify-content-between text-sm mb-2">
                                    <span class="fw-semibold text-theme-color" id="progress-percent">0% Completed</span>
                                    <span class="text-muted" id="progress-ratio">0/0 Lessons</span>
                                </div>
                                <div class="progress rounded-pill legacy-inline-1ea53ae754">
                                    <div class="progress-bar rounded-pill legacy-inline-25a52dbb2e" id="study-progress-bar" role="progressbar"
                                       >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Syllabus Accordion Menu -->
                        <div class="sidebar-widget-card p-4 rounded-3 border legacy-inline-9adb5d62cb"
                           >
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h4 class="h5 fw-bold text-title mb-0 font-title">Syllabus Curriculum</h4>
                                <span class="text-xs text-muted">Click lesson to view</span>
                            </div>
                            <div class="accordion syllabus-accordion" id="syllabusAccordion">
                                <!-- Injected Dynamically by course-portal.js -->
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Content Player -->
                <div class="col-lg-8">
                    <div class="study-content-card p-4 rounded-3 border legacy-inline-9adb5d62cb"
                       >

                        <!-- Video Player container (only displays for video-type lectures) -->
                        <div id="video-player-container" class="video-player-container mb-4 d-none">
                            <video id="main-video-player" controls controlslist="nodownload" oncontextmenu="return false;"
                                class="legacy-inline-d2688296bc">
                                <source src="" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <!-- Text-only lecture placeholder banner -->
                        <div id="text-lesson-banner" class="text-lesson-banner mb-4 d-none">
                            <div class="py-5 px-4 rounded-4 text-center legacy-inline-2dbcd51520"
                               >
                                <i class="fa-light fa-file-invoice text-theme-color mb-3 legacy-inline-b902eeb30e"></i>
                                <h4 class="h5 fw-bold text-title mb-2" id="text-banner-title">Written Lecture Material</h4>
                                <p class="text-muted text-sm mb-0">Read the course syllabus notes and study guides below.
                                </p>
                            </div>
                        </div>

                        <!-- Information Row & Mark as Completed Button -->
                        <div
                            class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-4 border-bottom">
                            <div>
                                <span class="text-uppercase text-theme-color text-xs fw-bold tracking-wider"
                                    id="active-module-name">Module Index</span>
                                <h2 class="h4 fw-bold text-title mb-1 mt-1" id="active-lesson-title">Select a Lesson</h2>
                                <div class="d-flex align-items-center gap-3 text-muted text-sm mt-2">
                                    <span><i class="fa-regular fa-clock me-1 text-theme-color"></i> <span
                                            id="active-lesson-duration">0 min</span></span>
                                    <span><i class="fa-regular fa-layer-group me-1 text-theme-color"></i> <span
                                            id="active-lesson-type">Lesson</span></span>
                                </div>
                            </div>
                            <div>
                                <button class="th-btn btn-sm" id="complete-lesson-btn">
                                    <i class="fa-regular fa-circle-check me-2"></i> Mark Complete
                                </button>
                            </div>
                        </div>

                        <!-- Detail Content Tabs Navigation -->
                        <ul class="nav course-tab mb-4 border-bottom" id="studyTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="read-tab" data-bs-toggle="tab"
                                    data-bs-target="#read-pane" type="button" role="tab">
                                    <i class="fa-regular fa-book-open-reader me-2"></i>Read Lesson
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes-pane"
                                    type="button" role="tab">
                                    <i class="fa-regular fa-note-sticky me-2"></i>My Notes
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="resources-tab" data-bs-toggle="tab"
                                    data-bs-target="#resources-pane" type="button" role="tab">
                                    <i class="fa-regular fa-file-pdf me-2"></i>Resources
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="qa-tab" data-bs-toggle="tab" data-bs-target="#qa-pane"
                                    type="button" role="tab">
                                    <i class="fa-regular fa-comments me-2"></i>Q&A Discussion
                                </button>
                            </li>
                        </ul>

                        <!-- Detail Content Tabs Panels -->
                        <div class="tab-content" id="studyTabsContent">

                            <!-- Tab 1: Reading Area -->
                            <div class="tab-pane fade show active" id="read-pane" role="tabpanel">
                                <div class="lesson-reading-body" id="lesson-reading-body">
                                    <!-- Injected dynamically via JS -->
                                </div>
                            </div>

                            <!-- Tab 2: Notes Editor -->
                            <div class="tab-pane fade" id="notes-pane" role="tabpanel">
                                <h4 class="h5 fw-bold text-title mb-2 font-title">My Study Notes</h4>
                                <p class="text-muted text-sm mb-3">Save personal lecture drafts, key points, or mnemonic
                                    formulas here. Automatically saved to your browser.</p>
                                <div class="notes-form mt-3">
                                    <textarea id="lesson-notes-textarea" class="form-control rounded-3 p-3 mb-3 text-sm" rows="8"
                                        placeholder="Draft your personal notes for this topic here..."></textarea>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-sm text-success d-none" id="notes-save-status"><i
                                                class="fa-regular fa-floppy-disk me-1"></i> Changes auto-saved!</span>
                                        <button class="th-btn btn-sm" id="save-notes-btn">Save Notes</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3: Resource PDFs -->
                            <div class="tab-pane fade" id="resources-pane" role="tabpanel">
                                <h4 class="h5 fw-bold text-title mb-2 font-title">Official Study Resources & PDFs</h4>
                                <p class="text-muted text-sm mb-4">Download official chapter notes, formula sheets, and
                                    past mock answer keys.</p>
                                <div id="lesson-resources-list" class="d-flex flex-column gap-2">
                                    <!-- Injected dynamically via JS -->
                                </div>
                            </div>

                            <!-- Tab 4: Discuss Feed -->
                            <div class="tab-pane fade" id="qa-pane" role="tabpanel">
                                <h4 class="h5 fw-bold text-title mb-2 font-title">Q&A Discussion Forum</h4>
                                <p class="text-muted text-sm mb-4">Discuss topics and tricky questions with course mentors
                                    and peer students.</p>

                                <!-- Ask box -->
                                <div class="qa-form-card p-3 rounded-3 mb-4 legacy-inline-ebb042579c"
                                   >
                                    <form id="qa-form">
                                        <div class="form-group mb-3">
                                            <label for="qa-input-text"
                                                class="form-label text-sm fw-bold text-title mb-2">Ask a Question</label>
                                            <textarea id="qa-input-text" class="form-control text-sm rounded-3" rows="3"
                                                placeholder="Post your doubt or question here..." required></textarea>
                                        </div>
                                        <button type="submit" class="th-btn btn-sm py-2 px-3">
                                            <i class="fa-regular fa-paper-plane me-1"></i> Post Question
                                        </button>
                                    </form>
                                </div>

                                <!-- Posts list -->
                                <div id="qa-thread-feed">
                                    <!-- Injected dynamically via JS -->
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


@endsection

@section('extra_js')
    <script src="{{ asset('frontend/js/my-courses-data.js') }}"></script>
    <script src="{{ asset('frontend/js/course-portal.js') }}"></script>
@endsection
