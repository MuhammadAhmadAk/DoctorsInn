@extends('student.layouts.master')
@section('title', 'LMS Classroom Video Player & Quiz Studio — DoctorsInn Elite')

@section('extra_css')
<link rel="stylesheet" href="https://vjs.zencdn.net/8.10.0/video-js.css">
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
    /* Module Accordion (Collapsible Modules, Default Module 1 Open) */
    .module-accordion-item {
        border: none;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 6px;
        background: transparent;
    }
    .module-accordion-item:last-child {
        border-bottom: none;
    }
    .module-accordion-btn {
        padding: 9px 10px;
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        display: flex;
        align-items: center;
        width: 100%;
        text-align: left;
        box-shadow: none !important;
        transition: all 0.15s ease;
    }
    .module-accordion-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .module-accordion-btn:not(.collapsed) {
        background: #f8fafc;
        color: var(--std-primary);
        border-color: #e2e8f0;
    }
    .module-accordion-btn::after {
        width: 10px;
        height: 10px;
        background-size: 10px;
        opacity: 0.5;
        margin-left: 6px;
    }
    .module-accordion-body {
        padding: 4px 0 4px 4px;
    }

    /* Chapter Accordion (Light, borderless, seamless) */
    .chapter-accordion-item {
        border: none;
        border-bottom: 1px solid #f8fafc;
        background: transparent;
        margin-bottom: 2px;
    }
    .chapter-accordion-btn {
        padding: 8px 8px;
        background: transparent;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        border: none;
        box-shadow: none !important;
        display: flex;
        align-items: center;
        width: 100%;
        text-align: left;
        border-radius: 6px;
        transition: background 0.15s ease;
    }
    .chapter-accordion-btn:hover {
        background: #f8fafc;
    }
    .chapter-accordion-btn:not(.collapsed) {
        background: #f8fafc;
        color: var(--std-primary);
    }
    .chapter-accordion-btn::after {
        width: 9px;
        height: 9px;
        background-size: 9px;
        opacity: 0.45;
        margin-left: 6px;
    }
    .syllabus-accordion-wrap {
        max-height: 650px;
        overflow-y: auto;
        padding-right: 2px;
    }
    .syllabus-accordion-wrap::-webkit-scrollbar {
        width: 4px;
    }
    .syllabus-accordion-wrap::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 4px;
    }

    /* Topic & Quiz Rows (Clean, Single Line, ZERO Clutter Badges) */
    .topic-row, .topic-study-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 7px 10px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.12s ease;
        font-size: 12px;
        color: #334155;
        background: transparent;
        margin-bottom: 2px;
        border: 1px solid transparent;
    }
    .topic-row:hover, .topic-study-item:hover {
        background: #f8fafc;
        color: #0f172a;
    }
    .topic-row.active, .topic-study-item.active {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #0f172a;
        font-weight: 600;
    }
    .topic-row.active .topic-title, .topic-study-item.active .topic-title {
        color: #0f172a;
        font-weight: 600;
    }
    .topic-row-start {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
        flex: 1;
    }
    .topic-type-icon {
        width: 16px;
        text-align: center;
        font-size: 11px;
        flex-shrink: 0;
        color: #94a3b8;
    }
    .topic-row.active .topic-type-icon, .topic-study-item.active .topic-type-icon {
        color: var(--std-primary);
    }
    .topic-type-icon.icon-quiz {
        color: #d97706;
    }
    .topic-type-icon.icon-assessment {
        color: #7c3aed;
    }
    .topic-title {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 12.5px;
        line-height: 1.4;
    }
    .topic-row-end {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        font-size: 11px;
        color: #94a3b8;
    }
    .topic-row.active .topic-row-end, .topic-study-item.active .topic-row-end {
        color: var(--std-primary);
    }
    .topic-check .checkmark {
        display: none;
        color: #10b981;
        font-size: 11.5px;
    }
    .topic-check .bullet {
        display: inline-block;
        color: #cbd5e1;
        font-size: 10px;
    }
    .topic-row.completed .topic-check .checkmark, .topic-study-item.completed .topic-check .checkmark {
        display: inline-block;
    }
    .topic-row.completed .topic-check .bullet, .topic-study-item.completed .topic-check .bullet {
        display: none;
    }
    .topic-row.completed .topic-title, .topic-study-item.completed .topic-title {
        color: #64748b;
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

    /* =========================================================================
       QUIZ STUDIO UI STYLES
       ========================================================================= */
    .quiz-studio-box {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius);
        overflow: hidden;
        box-shadow: var(--std-shadow-md);
    }
    .quiz-studio-header {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        color: #ffffff;
        padding: 20px 24px;
        position: relative;
    }
    .quiz-timer-pill {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .quiz-question-card {
        background: #ffffff;
        padding: 24px;
    }
    .quiz-qnum-badge {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--std-primary);
        background: rgba(92, 50, 255, 0.08);
        padding: 3px 10px;
        border-radius: 12px;
        display: inline-block;
        margin-bottom: 10px;
    }
    .quiz-question-text {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.5;
        margin-bottom: 20px;
    }
    .quiz-options-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 24px;
    }
    .quiz-option-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 13px 16px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.15s ease;
        font-size: 14px;
        color: #334155;
    }
    .quiz-option-card:hover {
        border-color: var(--std-primary);
        background: rgba(92, 50, 255, 0.03);
    }
    .quiz-option-card.selected {
        border-color: var(--std-primary);
        background: rgba(92, 50, 255, 0.08);
        font-weight: 600;
        color: var(--std-primary);
    }
    .quiz-option-card.correct {
        border-color: #10b981 !important;
        background: #ecfdf5 !important;
        color: #065f46 !important;
        font-weight: 600;
    }
    .quiz-option-card.incorrect {
        border-color: #ef4444 !important;
        background: #fef2f2 !important;
        color: #991b1b !important;
    }
    .quiz-option-letter {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1.5px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12.5px;
        color: #64748b;
        flex-shrink: 0;
        background: #ffffff;
        transition: all 0.15s ease;
    }
    .quiz-option-card.selected .quiz-option-letter {
        border-color: var(--std-primary);
        background: var(--std-primary);
        color: #ffffff;
    }
    .quiz-option-card.correct .quiz-option-letter {
        border-color: #10b981;
        background: #10b981;
        color: #ffffff;
    }
    .quiz-option-card.incorrect .quiz-option-letter {
        border-color: #ef4444;
        background: #ef4444;
        color: #ffffff;
    }
    .quiz-explanation-box {
        background: #f8fafc;
        border-left: 4px solid var(--std-primary);
        border-radius: 8px;
        padding: 16px;
        margin-top: 16px;
        font-size: 13.5px;
        line-height: 1.6;
    }
    .quiz-nav-dots {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .quiz-dot {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #64748b;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .quiz-dot.active {
        border-color: var(--std-primary);
        background: var(--std-primary);
        color: #ffffff;
    }
    .quiz-dot.answered {
        background: #e2e8f0;
        color: #334155;
    }
    .quiz-dot.correct {
        background: #10b981;
        border-color: #10b981;
        color: #ffffff;
    }
    .quiz-dot.wrong {
        background: #ef4444;
        border-color: #ef4444;
        color: #ffffff;
    }

    /* Scorecard Screen */
    .quiz-scorecard-card {
        padding: 40px 24px;
        text-align: center;
    }
    .quiz-score-badge {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff;
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
    }
    .quiz-score-badge.passed {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
    }
    .quiz-score-badge.failed {
        background: linear-gradient(135deg, #dc2626 0%, #f59e0b 100%);
        box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.4);
    }
    .quiz-stat-tile {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px;
        text-align: center;
    }
    .up-next-banner {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px 20px;
        margin-top: 24px;
    }

    /* =========================================================================
       SECURE LECTURE PLAYER (Video.js / HLS)
       ========================================================================= */
    .lecture-player-shell {
        overflow: hidden;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #e6eaf2;
    }
    .lecture-player-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 12px 14px;
        background: #ffffff;
        border-bottom: 1px solid #eef1f6;
    }
    .lecture-player-heading {
        min-width: 0;
    }
    .lecture-player-title {
        margin: 5px 0 1px;
        color: #0f172a;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.35;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .lecture-player-subtitle {
        color: #94a3b8;
        font-size: 11px;
    }
    .lecture-secure-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 7px;
        border-radius: 8px;
        background: #ecfdf5;
        border: 1px solid #d1fae5;
        color: #047857;
        font-size: 9.5px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }
    .lecture-secure-pill.is-processing {
        background: #eef2ff;
        border-color: #e0e7ff;
        color: #4f46e5;
    }
    .lecture-player-tools {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .lecture-tool {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #94a3b8;
        font-size: 9.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .lecture-tool select {
        height: 30px;
        padding: 2px 24px 2px 9px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        color: #334155;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }
    .lecture-tool select:focus {
        outline: none;
        border-color: #5c32ff;
        box-shadow: 0 0 0 3px rgba(92, 50, 255, .1);
    }
    .lecture-nav-btns {
        display: flex;
        gap: 4px;
    }
    .lecture-nav-btns button {
        width: 30px;
        height: 30px;
        display: inline-grid;
        place-items: center;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        transition: all .15s ease;
    }
    .lecture-nav-btns button:hover {
        border-color: #cbd5e1;
        background: #f1f5f9;
        color: #0f172a;
    }
    .lecture-nav-btns button:disabled {
        opacity: .45;
        cursor: not-allowed;
    }
    .lecture-player-stage {
        position: relative;
        background: #000;
    }
    .lecture-player-stage .video-js {
        width: 100%;
        background: #000;
    }
    .lecture-player-stage .video-js .vjs-control-bar {
        background: linear-gradient(0deg, rgba(2, 6, 23, .9), rgba(2, 6, 23, .35));
        height: 40px;
    }
    .lecture-player-stage .video-js .vjs-play-progress,
    .lecture-player-stage .video-js .vjs-volume-level {
        background: #5c32ff;
    }
    .lecture-player-stage .video-js .vjs-slider {
        background-color: rgba(148, 163, 184, .3);
    }
    .lecture-player-stage .video-js .vjs-big-play-button {
        width: 56px;
        height: 56px;
        line-height: 54px;
        margin-left: -28px;
        margin-top: -28px;
        border: 0;
        border-radius: 50%;
        background: rgba(92, 50, 255, .92);
        box-shadow: 0 10px 24px -8px rgba(2, 6, 23, .6);
    }
    .lecture-player-stage .video-js:hover .vjs-big-play-button,
    .lecture-player-stage .video-js:focus .vjs-big-play-button {
        background: #5c32ff;
    }
    .lecture-overlay {
        position: absolute;
        inset: 0;
        z-index: 5;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 24px;
        background: rgba(2, 6, 23, .82);
        color: #cbd5e1;
        text-align: center;
        font-size: 12.5px;
        backdrop-filter: blur(3px);
    }
    .lecture-spinner {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 3px solid rgba(148, 163, 184, .25);
        border-top-color: #818cf8;
        animation: lectureSpin .8s linear infinite;
    }
    @keyframes lectureSpin {
        to { transform: rotate(360deg); }
    }
    .lecture-overlay i {
        font-size: 24px;
        color: #818cf8;
    }
    .lecture-processing p,
    .lecture-error p {
        max-width: 440px;
        margin: 0;
        line-height: 1.55;
    }
    .lecture-processing-track {
        width: 220px;
        height: 6px;
        overflow: hidden;
        border-radius: 8px;
        background: rgba(148, 163, 184, .2);
    }
    .lecture-processing-track span {
        display: block;
        height: 100%;
        width: 0;
        background: linear-gradient(90deg, #6366f1, #a855f7);
        transition: width .4s ease;
    }
    .lecture-error i {
        color: #f87171;
    }
    .lecture-player-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        padding: 8px 14px;
        background: #ffffff;
        border-top: 1px solid #eef1f6;
        color: #94a3b8;
        font-size: 10.5px;
    }
    .lecture-skip-group {
        display: flex;
        gap: 6px;
    }
    .lecture-skip-group button {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 9px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        color: #475569;
        font-size: 10px;
        font-weight: 600;
        transition: all .15s ease;
    }
    .lecture-skip-group button:hover {
        border-color: #cbd5e1;
        background: #f1f5f9;
        color: #0f172a;
    }
    .lecture-progress-meta {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .lecture-percent {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #64748b;
        font-weight: 600;
    }
    .lecture-percent i {
        color: #5c32ff;
        font-size: 9px;
    }
    @media (max-width: 767.98px) {
        .lecture-player-header {
            flex-direction: column;
            align-items: stretch;
        }
        .lecture-player-tools {
            justify-content: flex-start;
        }
        .lecture-player-title {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')

<div class="classroom-container">

    {{-- Top Action Bar --}}
    <div class="classroom-header-bar">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 480px;">
                <a href="{{ route('student.courses') }}" class="btn btn-sm btn-light border py-1.5 px-2.5 rounded-2 text-secondary flex-shrink-0" title="Back to Courses">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <select id="enrolledCourseSelect"
                    class="form-select form-select-sm rounded-3 fw-bold text-dark"
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

            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <div class="text-xs text-secondary fw-semibold mb-1" style="font-size: 11.5px;">
                        <span id="progress-percent" class="fw-bold text-primary">0%</span> Complete &bull; <span id="progress-ratio">0/0 Lessons</span>
                    </div>
                    <div class="std-progress-track mt-0" style="width: 130px; height: 5px;">
                        <div class="std-progress-fill fill-success" id="study-progress-bar" style="width: 0%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Classroom Layout --}}
    <div class="row gy-4">

        {{-- Left Area: Video Player / Quiz Studio / Notes Tabs --}}
        <div class="col-xl-8">
            <div class="std-card p-4 mb-4">

                {{-- =========================================================
                     0. SECURE HLS LECTURE PLAYER (Signed, adaptive streaming)
                     ========================================================= --}}
                <div id="lecture-player-container" class="lecture-player-shell mb-4 d-none">
                    <div class="lecture-player-header">
                        <div class="lecture-player-heading">
                            <span class="lecture-secure-pill" id="lecture-status-pill"><i class="fa-solid fa-shield-halved"></i> Secure HLS</span>
                            <h3 class="lecture-player-title" id="lecture-player-title">Lecture</h3>
                            <div class="lecture-player-subtitle" id="lecture-player-subtitle">Adaptive HLS streaming</div>
                        </div>
                        <div class="lecture-player-tools">
                            <label class="lecture-tool">
                                <span>Quality</span>
                                <select id="lecture-quality-select" aria-label="Video quality">
                                    <option value="auto">Auto</option>
                                </select>
                            </label>
                            <label class="lecture-tool">
                                <span>Speed</span>
                                <select id="lecture-speed-select" aria-label="Playback speed">
                                    <option value="0.5">0.5x</option>
                                    <option value="0.75">0.75x</option>
                                    <option value="1" selected>1x</option>
                                    <option value="1.25">1.25x</option>
                                    <option value="1.5">1.5x</option>
                                    <option value="1.75">1.75x</option>
                                    <option value="2">2x</option>
                                </select>
                            </label>
                            <div class="lecture-nav-btns">
                                <button type="button" id="lecture-prev-btn" title="Previous topic" aria-label="Previous topic"><i class="fa-solid fa-backward-step"></i></button>
                                <button type="button" id="lecture-next-btn" title="Next topic" aria-label="Next topic"><i class="fa-solid fa-forward-step"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="lecture-player-stage">
                        <video id="lecture-video-player" class="video-js vjs-big-play-centered" controls playsinline preload="auto"></video>
                        <div id="lecture-player-loading" class="lecture-overlay d-none">
                            <div class="lecture-spinner"></div>
                            <span data-loading-text>Preparing secure stream…</span>
                        </div>
                        <div id="lecture-player-processing" class="lecture-overlay lecture-processing d-none">
                            <i class="fa-solid fa-gear fa-spin"></i>
                            <p id="lecture-processing-text">This lecture is being processed…</p>
                            <div class="lecture-processing-track"><span id="lecture-processing-bar"></span></div>
                        </div>
                        <div id="lecture-player-error" class="lecture-overlay lecture-error d-none">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <p id="lecture-error-text">Playback failed.</p>
                            <button type="button" class="btn btn-sm btn-light" id="lecture-retry-btn"><i class="fa-solid fa-rotate-right me-1"></i> Retry Playback</button>
                        </div>
                    </div>
                    <div class="lecture-player-footer">
                        <div class="lecture-skip-group">
                            <button type="button" data-lecture-skip="-10" title="Back 10 seconds"><i class="fa-solid fa-rotate-left"></i><span>10s</span></button>
                            <button type="button" data-lecture-skip="10" title="Forward 10 seconds"><span>10s</span><i class="fa-solid fa-rotate-right"></i></button>
                        </div>
                        <div class="lecture-progress-meta">
                            <span class="lecture-percent"><i class="fa-solid fa-circle-play"></i><span id="lecture-percent-label">0% watched</span></span>
                            <span id="lecture-resume-label"></span>
                        </div>
                    </div>
                </div>

                {{-- =========================================================
                     1. VIDEO PLAYER CONTAINER (Visible when Topic Type == video)
                     ========================================================= --}}
                <div id="video-player-container" class="classroom-video-box mb-4">
                    <video id="main-video-player" controls controlslist="nodownload" playsinline preload="metadata">
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                {{-- =========================================================
                     2. READING BANNER (Visible when Topic Type == reading/text)
                     ========================================================= --}}
                <div id="text-lesson-banner" class="text-lesson-banner mb-4 d-none">
                    <div class="py-5 px-4 rounded-4 text-center bg-light border">
                        <i class="fa-solid fa-book-open-reader text-primary mb-3 fs-1"></i>
                        <h4 class="h5 fw-bold text-dark mb-2" id="text-banner-title">High-Yield Topic Notes</h4>
                        <p class="text-muted text-sm mb-0">Study the comprehensive syllabus breakdown, mnemonics, and PMDC key points below.</p>
                    </div>
                </div>

                {{-- =========================================================
                     3. QUIZ STUDIO UI CONTAINER (Visible when Topic Type == quiz)
                     ========================================================= --}}
                <div id="quiz-studio-container" class="quiz-studio-box mb-4 d-none">
                    {{-- Quiz Dynamic Header --}}
                    <div class="quiz-studio-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                            <span class="text-white-50 text-xs" id="quiz-breadcrumb">Module 1: Biology &bull; Chapter 1 &bull; Quiz</span>
                            <div class="quiz-timer-pill" id="quiz-timer-pill">
                                <i class="fa-regular fa-clock"></i>
                                <span id="quiz-timer-display">08:00</span>
                            </div>
                        </div>
                        <h3 class="h5 fw-bold text-white mb-1" id="quiz-title-display">Cell Biology Checkpoint Quiz</h3>
                        <p class="text-white-50 text-xs mb-0" id="quiz-subtitle-display">Test your conceptual retention with high-yield MDCAT MCQs.</p>
                    </div>

                    {{-- Quiz View A: Start / Overview Screen --}}
                    <div id="quiz-start-screen" class="p-4 text-center">
                        <div class="p-4 bg-light rounded-4 border mb-4 text-start">
                            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-circle-info text-primary me-2"></i> Quiz Guidelines &amp; Marking Scheme</h5>
                            <ul class="text-sm text-secondary mb-0 ps-3">
                                <li class="mb-1"><strong>Format:</strong> Single Best Answer Multiple Choice Questions (PMDC Standard).</li>
                                <li class="mb-1"><strong>Instant Feedback:</strong> You can check explanations after each question to reinforce concepts.</li>
                                <li class="mb-1"><strong>Passing Benchmark:</strong> 80% score required to earn the Chapter Mastery checkmark.</li>
                                <li><strong>Retakes:</strong> You can retake this quiz anytime to practice weak concepts.</li>
                            </ul>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-6 col-sm-3">
                                <div class="quiz-stat-tile">
                                    <div class="text-xs text-muted mb-1">Questions</div>
                                    <div class="h5 fw-bold text-dark mb-0" id="quiz-stat-total-q">5 MCQs</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="quiz-stat-tile">
                                    <div class="text-xs text-muted mb-1">Time Allowed</div>
                                    <div class="h5 fw-bold text-dark mb-0" id="quiz-stat-duration">8 Mins</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="quiz-stat-tile">
                                    <div class="text-xs text-muted mb-1">Pass Score</div>
                                    <div class="h5 fw-bold text-dark mb-0" id="quiz-stat-pass">80%</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="quiz-stat-tile">
                                    <div class="text-xs text-muted mb-1">Difficulty</div>
                                    <div class="h5 fw-bold text-primary mb-0">High-Yield</div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary px-4 py-2.5 fw-bold d-inline-flex align-items-center gap-2 rounded-3" id="start-quiz-btn" style="font-size: 14.5px;">
                            <i class="fa-solid fa-play"></i>
                            <span>Start Quiz Now</span>
                        </button>
                    </div>

                    {{-- Quiz View B: Active Question Player Screen --}}
                    <div id="quiz-player-screen" class="quiz-question-card d-none">
                        {{-- Top Question Tracker & Dots --}}
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-bottom">
                            <div>
                                <span class="quiz-qnum-badge" id="quiz-qnum-label">Question 1 of 5</span>
                            </div>
                            <div class="quiz-nav-dots" id="quiz-nav-dots">
                                <!-- Injected dynamically via JS -->
                            </div>
                        </div>

                        {{-- Question Statement --}}
                        <div class="quiz-question-text" id="quiz-question-statement">
                            Loading question...
                        </div>

                        {{-- 4 Options Choices --}}
                        <div class="quiz-options-list" id="quiz-options-container">
                            <!-- Injected dynamically via JS -->
                        </div>

                        {{-- Explanation Card (revealed after Check Answer) --}}
                        <div class="quiz-explanation-box d-none" id="quiz-explanation-box">
                            <div class="d-flex align-items-center gap-2 fw-bold text-primary mb-1">
                                <i class="fa-solid fa-lightbulb"></i>
                                <span>High-Yield PMDC Solution &amp; Reference</span>
                            </div>
                            <div class="text-secondary" id="quiz-explanation-text"></div>
                        </div>

                        {{-- Action Buttons Row --}}
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-3 mt-4 border-top">
                            <div>
                                <button class="btn btn-sm btn-outline-secondary px-3 py-2 fw-semibold rounded-2" id="quiz-prev-btn" disabled>
                                    <i class="fa-solid fa-arrow-left me-1"></i> Previous
                                </button>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-sm btn-outline-primary px-3 py-2 fw-semibold rounded-2" id="quiz-check-btn">
                                    <i class="fa-solid fa-circle-check me-1"></i> Check Answer
                                </button>
                                <button class="btn btn-sm btn-primary px-3 py-2 fw-semibold rounded-2" id="quiz-next-btn">
                                    <span>Next Question</span> <i class="fa-solid fa-arrow-right ms-1"></i>
                                </button>
                                <button class="btn btn-sm btn-success px-3 py-2 fw-semibold rounded-2 d-none" id="quiz-finish-btn">
                                    <i class="fa-solid fa-flag-checkered me-1"></i> Submit Quiz
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Quiz View C: Result & Scorecard Screen --}}
                    <div id="quiz-scorecard-screen" class="quiz-scorecard-card d-none">
                        <div class="quiz-score-badge" id="quiz-score-badge">
                            <span class="fs-2 fw-bold mb-0" id="quiz-score-percent">80%</span>
                            <span class="text-xs uppercase fw-bold" id="quiz-score-status">Passed</span>
                        </div>

                        <h4 class="h5 fw-bold text-dark mb-1" id="quiz-result-title">Quiz Completed Successfully!</h4>
                        <p class="text-muted text-sm mb-4" id="quiz-result-msg">Great job! You have demonstrated solid conceptual grasp of this chapter.</p>

                        <div class="row g-3 justify-content-center max-w-md mx-auto mb-4" style="max-width: 520px;">
                            <div class="col-4">
                                <div class="quiz-stat-tile">
                                    <div class="text-xs text-muted mb-1">Score</div>
                                    <div class="h5 fw-bold text-dark mb-0" id="quiz-score-ratio">4/5</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="quiz-stat-tile">
                                    <div class="text-xs text-muted mb-1">Accuracy</div>
                                    <div class="h5 fw-bold text-success mb-0" id="quiz-accuracy-ratio">80%</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="quiz-stat-tile">
                                    <div class="text-xs text-muted mb-1">Time Spent</div>
                                    <div class="h5 fw-bold text-primary mb-0" id="quiz-time-spent">03:42</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                            <button class="btn btn-outline-secondary px-3 py-2 fw-semibold rounded-3 text-sm" id="quiz-retake-btn">
                                <i class="fa-solid fa-rotate-right me-1"></i> Retake Practice Quiz
                            </button>
                            <button class="btn btn-primary px-4 py-2 fw-semibold rounded-3 text-sm" id="quiz-proceed-btn">
                                <span>Continue to Next Item</span> <i class="fa-solid fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- =========================================================
                     TOPIC TITLE & ACTION ROW
                     ========================================================= --}}
                <div id="topic-control-row" class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-3 mb-3 border-bottom">
                    <div>
                        <div class="text-muted mb-1" style="font-size: 11.5px;">
                            <span class="fw-semibold text-primary" id="active-module-name">Module 1: Biology</span>
                            <span class="mx-1">&bull;</span>
                            <span class="text-secondary" id="active-chapter-name">Chapter 1: Cell Biology &amp; Cytology</span>
                        </div>
                        <h2 class="h5 fw-bold text-dark mb-1" id="active-topic-title">Select a Topic</h2>
                        <div class="text-muted" style="font-size: 11.5px;">
                            <i class="fa-regular fa-clock me-1 text-primary"></i> <span id="active-topic-duration">0 min</span>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-2 px-3 py-1.5 fw-semibold rounded-pill" id="complete-lesson-btn" style="font-size: 12.5px;">
                            <i class="fa-regular fa-circle-check"></i>
                            <span>Mark Complete</span>
                        </button>
                    </div>
                </div>

                {{-- =========================================================
                     TOPIC STUDY TABS (Notes / Resources / Doubt Clearance)
                     ========================================================= --}}
                <div id="topic-tabs-wrapper">
                    <ul class="nav classroom-tab-nav mb-4" id="studyTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="read-tab" data-bs-toggle="tab" data-bs-target="#read-pane" type="button" role="tab">
                                <i class="fa-solid fa-book-open-reader me-2"></i>Topic Notes
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
                                <i class="fa-solid fa-comments me-2"></i>Doubt Forum
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="studyTabsContent">

                        {{-- Tab 1: Topic Notes Body --}}
                        <div class="tab-pane fade show active" id="read-pane" role="tabpanel">
                            <div class="lesson-reading-body text-dark" id="lesson-reading-body" style="font-size: 14px; line-height: 1.7;">
                                <!-- Injected dynamically via JS -->
                            </div>

                            {{-- Up Next Recommendation Banner --}}
                            <div class="up-next-banner d-flex align-items-center justify-content-between flex-wrap gap-3" id="up-next-banner">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                        <i class="fa-solid fa-forward-step fs-5"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs fw-bold text-uppercase text-primary d-block">Up Next in Chapter</span>
                                        <h6 class="fw-bold text-dark mb-0" id="up-next-title">Topic Practice Quiz</h6>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-primary px-3 py-2 fw-semibold rounded-2" id="up-next-btn">
                                    <span>Proceed Next</span> <i class="fa-solid fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Tab 2: Notes Editor --}}
                        <div class="tab-pane fade" id="notes-pane" role="tabpanel">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h5 class="fw-bold text-dark mb-0" style="font-size: 15px;">Personal Study Notes</h5>
                                <span class="text-xs text-success d-none" id="notes-save-status"><i class="fa-solid fa-check me-1"></i> Saved automatically!</span>
                            </div>
                            <p class="text-muted text-xs mb-3">Save your mnemonics, numerical shortcuts, or doubt points. Stored securely on your device.</p>
                            <textarea id="lesson-notes-textarea" class="form-control rounded-3 p-3 mb-3" rows="7" placeholder="Type your personal notes for this topic here..." style="font-size: 13.5px;"></textarea>
                            <div class="text-end">
                                <button class="btn btn-sm btn-primary px-3 py-2 fw-semibold" id="save-notes-btn">
                                    <i class="fa-regular fa-floppy-disk me-1"></i> Save Notes
                                </button>
                            </div>
                        </div>

                        {{-- Tab 3: Resource PDFs --}}
                        <div class="tab-pane fade" id="resources-pane" role="tabpanel">
                            <h5 class="fw-bold text-dark mb-1" style="font-size: 15px;">Official Topic Handouts &amp; Formula Sheets</h5>
                            <p class="text-muted text-xs mb-3">Download high-yield slides, past question references, and answer keys.</p>
                            <div id="lesson-resources-list" class="d-flex flex-column gap-2">
                                <!-- Injected dynamically via JS -->
                            </div>
                        </div>

                        {{-- Tab 4: Q&A Doubt Discussion --}}
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
        </div>

        {{-- Right Area: Course Content Outline --}}
        <div class="col-xl-4">
            <div class="syllabus-card">
                <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                    <span class="fw-bold text-dark" style="font-size: 14px;">Curriculum Outline</span>
                    <span class="text-muted text-xs font-11" id="syllabus-items-count">0 items</span>
                </div>

                <div class="syllabus-accordion-wrap flex-grow-1">
                    <div class="accordion syllabus-accordion" id="syllabusAccordion">
                        <!-- Direct tree structure injected dynamically by course-portal.js -->
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@section('extra_js')
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-levels@4.1.0/dist/videojs-contrib-quality-levels.min.js"></script>
    <script>
        window.APP_BASE_URL = @json(url('/'));
        window.activeDbCourses = @json($courses);
        window.activeCourseData = @json($activeCourse);
        window.lectureLibrary = @json((object) $lectureLibrary);
        window.lectureProgressMap = @json((object) $lectureProgressMap);
        window.lectureEndpoints = {
            base: @json(url('/student/lectures')),
            csrf: @json(csrf_token())
        };
        window.lectureCompletionThreshold = {{ (int) config('video.completion_threshold', 90) }};
    </script>
    <script src="{{ asset('frontend/js/lecture-player.js') }}?v={{ file_exists(public_path('frontend/js/lecture-player.js')) ? filemtime(public_path('frontend/js/lecture-player.js')) : time() }}"></script>
    <script src="{{ asset('frontend/js/course-portal.js') }}?v={{ file_exists(public_path('frontend/js/course-portal.js')) ? filemtime(public_path('frontend/js/course-portal.js')) : time() }}"></script>
@endsection
