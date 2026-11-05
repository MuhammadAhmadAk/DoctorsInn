@extends('student.layouts.master')
@section('title', 'LMS Classroom Video Player — DoctorsInn Elite')

@section('extra_css')
<style>
    .classroom-container {
        padding-bottom: 30px;
    }
    .classroom-header-bar {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius);
        padding: 14px 18px;
        margin-bottom: 20px;
        box-shadow: var(--std-shadow);
    }
    .classroom-video-box {
        background: #000000;
        border-radius: var(--std-radius);
        overflow: hidden;
        box-shadow: var(--std-shadow-md);
        position: relative;
    }
    .classroom-video-box video {
        width: 100%;
        height: auto;
        max-height: 520px;
        display: block;
        background: #000;
    }
    .syllabus-card {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius);
        padding: 18px;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: var(--std-shadow);
    }
    .syllabus-accordion-wrap {
        max-height: 650px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .syllabus-accordion-wrap::-webkit-scrollbar {
        width: 5px;
    }
    .syllabus-accordion-wrap::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .lesson-study-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.15s ease;
        margin-bottom: 4px;
        font-size: 13px;
        border: 1px solid transparent;
    }
    .lesson-study-item:hover {
        background: #f1f5f9;
    }
    .lesson-study-item.active {
        background: rgba(92, 50, 255, 0.08);
        border-color: rgba(92, 50, 255, 0.25);
        font-weight: 600;
        color: var(--std-primary);
    }
    .lesson-study-item.completed .status-indicator .checkmark {
        display: inline-block;
        color: #10b981;
    }
    .lesson-study-item.completed .status-indicator .bullet {
        display: none;
    }
    .lesson-study-item:not(.completed) .status-indicator .checkmark {
        display: none;
    }
    .lesson-study-item:not(.completed) .status-indicator .bullet {
        display: inline-block;
        color: #94a3b8;
    }
    .lesson-icon-wrapper {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 12px;
    }
    .classroom-tab-nav {
        border-bottom: 1px solid var(--std-border);
        gap: 8px;
    }
    .classroom-tab-nav .nav-link {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--std-text-muted);
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 16px;
        background: transparent;
        border-radius: 0;
    }
    .classroom-tab-nav .nav-link.active {
        color: var(--std-primary);
        border-bottom-color: var(--std-primary);
        background: transparent;
    }
</style>
@endsection

@section('content')

<div class="classroom-container">

    {{-- Top Action Bar --}}
    <div class="classroom-header-bar">
        <div class="row align-items-center gy-3">
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('student.courses') }}" class="btn btn-sm btn-light border py-1 px-2 rounded-2 text-secondary" title="Back to Courses">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div class="flex-grow-1">
                        <span class="text-xs fw-bold text-uppercase text-primary tracking-wide">Classroom &bull; Enrolled Track</span>
                        <select id="enrolledCourseSelect"
                            class="form-select form-select-sm rounded-3 fw-bold text-dark mt-1"
                            data-instructor-image="{{ asset($activeCourse['instructor_info']['image'] ?? $activeCourse['instructor_image'] ?? 'frontend/img/testimonial/testi_2_2.png') }}"
                            data-student-avatar="{{ asset($studentData['avatar']) }}"
                            data-course-url="{{ route('student.classroom') }}">
                            @foreach ($courses as $c)
                                <option value="{{ $c['slug'] }}" {{ ($activeCourse['slug'] ?? '') === $c['slug'] ? 'selected' : '' }}>
                                    {{ $c['title'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="d-flex align-items-center justify-content-lg-end gap-3">
                    {{-- Progress Summary --}}
                    <div class="text-end d-none d-sm-block">
                        <div class="text-xs text-dark fw-bold mb-1" id="progress-ratio">0/0 Lessons Done</div>
                        <div class="std-progress-track mt-0" style="width: 140px; height: 8px;">
                            <div class="std-progress-fill fill-success" id="study-progress-bar" style="width: 0%;"></div>
                        </div>
                    </div>
                    <span class="badge-status badge-status-primary px-3 py-2 fw-bold" id="progress-percent" style="font-size: 12px;">0% Complete</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Classroom Layout --}}
    <div class="row gy-4">

        {{-- Left Area: Video Player & Tabs --}}
        <div class="col-xl-8">
            <div class="std-card p-4 mb-4">

                {{-- Video Player --}}
                <div id="video-player-container" class="classroom-video-box mb-4">
                    <video id="main-video-player" controls controlslist="nodownload" playsinline>
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                {{-- Text Lesson Placeholder Banner --}}
                <div id="text-lesson-banner" class="text-lesson-banner mb-4 d-none">
                    <div class="py-5 px-4 rounded-4 text-center bg-light border">
                        <i class="fa-solid fa-file-lines text-primary mb-3 fs-1"></i>
                        <h4 class="h5 fw-bold text-dark mb-2" id="text-banner-title">Written Lecture Material</h4>
                        <p class="text-muted text-sm mb-0">Read the high-yield syllabus notes and chapter breakdown below.</p>
                    </div>
                </div>

                {{-- Lesson Control Row --}}
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-3 mb-3 border-bottom">
                    <div>
                        <span class="text-xs fw-bold text-uppercase text-primary" id="active-module-name">Module Index</span>
                        <h2 class="h5 fw-bold text-dark mb-1 mt-1" id="active-lesson-title">Select a Lesson</h2>
                        <div class="d-flex align-items-center gap-3 text-muted text-xs mt-1">
                            <span><i class="fa-regular fa-clock me-1 text-primary"></i> <span id="active-lesson-duration">0 min</span></span>
                            <span><i class="fa-solid fa-layer-group me-1 text-primary"></i> <span id="active-lesson-type">Lesson</span></span>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold" id="complete-lesson-btn" style="border-radius: 8px; font-size: 13.5px;">
                            <i class="fa-regular fa-circle-check"></i>
                            <span>Mark Complete</span>
                        </button>
                    </div>
                </div>

                {{-- Detail Content Tabs --}}
                <ul class="nav classroom-tab-nav mb-4" id="studyTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="read-tab" data-bs-toggle="tab" data-bs-target="#read-pane" type="button" role="tab">
                            <i class="fa-solid fa-book-open-reader me-2"></i>Lesson Notes
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes-pane" type="button" role="tab">
                            <i class="fa-solid fa-note-sticky me-2"></i>My Private Notes
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="resources-tab" data-bs-toggle="tab" data-bs-target="#resources-pane" type="button" role="tab">
                            <i class="fa-solid fa-file-pdf me-2"></i>PDF Handouts
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="qa-tab" data-bs-toggle="tab" data-bs-target="#qa-pane" type="button" role="tab">
                            <i class="fa-solid fa-comments me-2"></i>Doubt Discussion
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="studyTabsContent">

                    {{-- Tab 1: Reading Area --}}
                    <div class="tab-pane fade show active" id="read-pane" role="tabpanel">
                        <div class="lesson-reading-body text-dark" id="lesson-reading-body" style="font-size: 14px; line-height: 1.7;">
                            <!-- Injected dynamically via JS -->
                        </div>
                    </div>

                    {{-- Tab 2: Notes Editor --}}
                    <div class="tab-pane fade" id="notes-pane" role="tabpanel">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="fw-bold text-dark mb-0" style="font-size: 15px;">Personal Study Notes</h5>
                            <span class="text-xs text-success d-none" id="notes-save-status"><i class="fa-solid fa-check me-1"></i> Saved automatically!</span>
                        </div>
                        <p class="text-muted text-xs mb-3">Save your mnemonics, numerical shortcuts, or doubt points. Stored securely on your device.</p>
                        <textarea id="lesson-notes-textarea" class="form-control rounded-3 p-3 mb-3" rows="7" placeholder="Type your personal notes for this lesson here..." style="font-size: 13.5px;"></textarea>
                        <div class="text-end">
                            <button class="btn btn-sm btn-primary px-3 py-2 fw-semibold" id="save-notes-btn">
                                <i class="fa-regular fa-floppy-disk me-1"></i> Save Notes
                            </button>
                        </div>
                    </div>

                    {{-- Tab 3: Resource PDFs --}}
                    <div class="tab-pane fade" id="resources-pane" role="tabpanel">
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 15px;">Official Lesson Handouts &amp; Formula Sheets</h5>
                        <p class="text-muted text-xs mb-3">Download high-yield slides, past question references, and answer keys.</p>
                        <div id="lesson-resources-list" class="d-flex flex-column gap-2">
                            <!-- Injected dynamically via JS -->
                        </div>
                    </div>

                    {{-- Tab 4: Q&A Discussion --}}
                    <div class="tab-pane fade" id="qa-pane" role="tabpanel">
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 15px;">Doubt Clearance Forum</h5>
                        <p class="text-muted text-xs mb-3">Ask doubts directly to DoctorsInn faculty and discussion mentors.</p>

                        <div class="bg-light p-3 rounded-3 mb-4 border">
                            <form id="qa-form">
                                <div class="mb-2">
                                    <label class="form-label text-xs fw-bold text-dark mb-1">Post a Question / Doubt</label>
                                    <textarea id="qa-input-text" class="form-control text-sm rounded-3" rows="3" placeholder="Explain what concept or MCQ you need help with..." required></textarea>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted text-xs">Response time: usually under 2 hours</span>
                                    <button type="submit" class="btn btn-sm btn-primary px-3 py-2 fw-semibold">
                                        <i class="fa-regular fa-paper-plane me-1"></i> Post Question
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div id="qa-thread-feed">
                            <!-- Injected dynamically via JS -->
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- Right Area: Syllabus Curriculum Accordion --}}
        <div class="col-xl-4">
            <div class="syllabus-card">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <div>
                        <h3 class="fw-bold text-dark mb-0" style="font-size: 15.5px;">Curriculum Outline</h3>
                        <span class="text-muted text-xs">Select lecture to switch stream</span>
                    </div>
                    <span class="badge bg-light text-dark border px-2 py-1 text-xs fw-semibold">
                        <i class="fa-solid fa-list-ol text-primary me-1"></i> Syllabus
                    </span>
                </div>

                <div class="syllabus-accordion-wrap flex-grow-1">
                    <div class="accordion syllabus-accordion" id="syllabusAccordion">
                        <!-- Injected dynamically by course-portal.js -->
                    </div>
                </div>

                {{-- WhatsApp Assistance --}}
                <div class="mt-3 pt-3 border-top">
                    <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20have%20a%20doubt%20in%20the%20active%20lecture." target="_blank" class="btn btn-outline-success w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2" style="font-size: 13px; border-radius: 8px;">
                        <i class="fa-brands fa-whatsapp fs-5"></i>
                        <span>Ask Teacher on WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@section('extra_js')
    <script src="{{ asset('frontend/js/my-courses-data.js') }}"></script>
    <script src="{{ asset('frontend/js/course-portal.js') }}"></script>
@endsection
