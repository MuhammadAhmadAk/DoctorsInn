@extends('backend.layouts.master')

@section('title', isset($course) ? 'Edit Course: ' . $course->title : 'Add New Course')

@section('extra_css')
<link rel="stylesheet" href="https://vjs.zencdn.net/8.10.0/video-js.css">
<style>
    /* Course Studio & 3-Tier Builder Refined Styling */
    .builder-module-card {
        background: #ffffff;
        border: 1px solid #eaedf3;
        border-radius: 8px;
        margin-bottom: 12px;
        transition: border-color 0.15s ease;
    }
    .builder-module-card:hover {
        border-color: #d8dee9;
    }
    .builder-module-header {
        padding: 12px 14px;
        background: #ffffff;
        border-bottom: 1px solid #eef1f6;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .builder-chapter-card {
        background: #ffffff;
        border: 1px solid #eef1f6;
        border-radius: 8px;
        margin-bottom: 8px;
        overflow: hidden;
    }
    .builder-module-body {
        padding: 10px 12px 12px;
        background: #ffffff;
    }
    #modulesContainer {
        padding-top: 12px;
    }
    .studio-empty {
        padding: 36px 16px;
        text-align: center;
        background: #fafbff;
        border: 1.5px dashed #e2e8f0;
        border-radius: 8px;
    }
    .studio-empty-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        margin-bottom: 8px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 15px;
    }
    .studio-empty-title {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
    }
    .studio-empty-text {
        margin: 3px 0 12px;
        font-size: 11.5px;
        color: #94a3b8;
    }
    .builder-chapter-card:last-child {
        margin-bottom: 0;
    }
    .builder-chapter-header {
        padding: 8px 12px;
        background: #fafbfd;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        border-bottom: 1px solid #eef1f6;
    }
    .builder-topic-row {
        padding: 8px 12px;
        border-bottom: 1px solid #f4f6fa;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        background: #ffffff;
        transition: background-color 0.15s ease;
    }
    .builder-topic-row:last-child {
        border-bottom: none;
    }
    .builder-topic-row:hover {
        background: #fafbfd;
    }
    .builder-module-header .btn,
    .builder-chapter-header .btn {
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 8px;
    }
    .action-icon-btn {
        width: 26px;
        height: 26px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 11px;
        color: #94a3b8;
        background: transparent;
        border: 1px solid transparent;
        transition: all 0.15s ease;
    }
    .action-icon-btn:hover {
        color: #0f172a;
        background: #f1f5f9;
    }
    .action-icon-btn.danger:hover {
        color: #ef4444;
        background: #fee2e2;
    }
    .hls-chip {
        display: inline-flex;
        align-items: center;
        margin-left: 5px;
        padding: 1px 6px;
        border-radius: 8px;
        background: #f1edff;
        color: #5c32ff;
        font-size: 9.5px;
        font-weight: 700;
        letter-spacing: 0.04em;
        vertical-align: middle;
    }
    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-chip.primary {
        background: #f1edff;
        color: #5c32ff;
    }
    .status-chip.success {
        background: #ecfdf5;
        color: #047857;
    }
    .mcq-question-block {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
    }

    /* ── Studio page shell ───────────────────────────────────────────── */
    .studio-page {
        max-width: 1360px;
        margin: 0 auto;
    }
    .studio-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        margin-bottom: 14px;
        background: #ffffff;
        border: 1px solid #eaeef4;
        border-radius: 8px;
    }
    .studio-head-main {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }
    .studio-head-icon {
        width: 46px;
        height: 46px;
        border-radius: 8px;
        background: #f1edff;
        color: #5c32ff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .studio-title {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #0f172a;
        line-height: 1.25;
    }
    .studio-subtitle {
        margin: 3px 0 0;
        font-size: 12px;
        color: #64748b;
    }
    .studio-head .breadcrumb {
        margin-bottom: 2px;
        font-size: 11.5px;
    }
    .studio-head .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
    }
    .studio-head .breadcrumb-item a:hover {
        color: #5c32ff;
    }
    .studio-head .breadcrumb-item.active {
        color: #94a3b8;
    }
    .studio-head .breadcrumb-item + .breadcrumb-item::before {
        color: #cbd5e1;
    }
    .studio-head-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .studio-head-actions .btn-adm {
        padding: 8px 14px;
        font-size: 12.5px;
        border-radius: 8px;
    }

    /* ── Curriculum stats strip ─────────────────────────────────────── */
    .studio-stats {
        background: #fafbfd;
        border-top: 1px solid #eef1f6;
        border-bottom: 1px solid #eef1f6;
        font-size: 12px;
        color: #64748b;
    }
    .studio-stats strong {
        color: #0f172a;
        font-weight: 700;
    }

    /* Lighten the standard admin cards inside the studio */
    .studio-page .adm-card {
        border-color: #eaedf3;
        border-radius: 8px;
        box-shadow: none;
    }
    .studio-page .adm-card-header {
        padding: 16px 18px 12px;
        border-bottom-color: #f1f4f9;
        flex-wrap: wrap;
        gap: 10px;
    }
    .studio-page .adm-card-title {
        font-size: 14px;
        letter-spacing: -0.01em;
    }
    .studio-page .adm-card-body {
        padding: 0 18px 18px;
    }

    /* ── Sidebar helpers ────────────────────────────────────────────── */
    .roadmap-card {
        height: 100%;
        padding: 14px;
        background: #fafbfd;
        border: 1px solid #eef1f6;
        border-radius: 8px;
    }
    .studio-thumb {
        padding: 6px;
        background: #f8fafc;
        border: 1px solid #eef1f6;
        border-radius: 8px;
    }
    .studio-page .form-label {
        margin-bottom: 5px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }
    .studio-page .form-control,
    .studio-page .form-select {
        border-color: #e2e8f0;
        border-radius: 8px;
    }
    .studio-page .form-control:focus,
    .studio-page .form-select:focus {
        border-color: #5c32ff;
        box-shadow: 0 0 0 3px rgba(92, 50, 255, 0.1);
    }
    .studio-page .btn,
    .studio-page .btn-adm,
    .studio-page .form-control,
    .studio-page .form-select,
    .studio-page .input-group-text {
        border-radius: 8px !important;
    }

    /* ── Topic / chapter / quiz modals ──────────────────────────────── */
    .studio-modal .modal-content {
        border: 0;
        border-radius: 8px;
        box-shadow: 0 24px 64px rgba(15, 23, 42, 0.18);
        overflow: hidden;
    }
    .studio-modal .modal-header {
        align-items: flex-start;
        padding: 18px 22px 14px;
        border-bottom: 1px solid #eef1f6;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .studio-modal .modal-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: -0.01em;
        color: #0f172a;
    }
    .studio-modal .studio-modal-sub {
        margin-top: 2px;
        font-size: 12px;
        color: #64748b;
    }
    .studio-modal .btn-close {
        margin-top: 2px;
        font-size: 10px;
    }
    .studio-modal .modal-body {
        max-height: calc(90vh - 150px);
        overflow-y: auto;
        padding: 18px 22px;
    }
    .studio-modal .modal-footer {
        gap: 8px;
        padding: 12px 22px;
        background: #f8fafc;
        border-top: 1px solid #eef1f6;
    }
    .studio-modal .modal-footer .btn-adm {
        padding: 8px 18px;
        font-size: 12.5px;
        border-radius: 8px;
    }
    .studio-modal .form-label {
        margin-bottom: 5px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }
    .studio-modal .form-control,
    .studio-modal .form-select {
        padding: 8px 11px;
        font-size: 13px;
        color: #0f172a;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #ffffff;
    }
    .studio-modal .form-control::placeholder {
        color: #a5b0c2;
    }
    .studio-modal .form-control:focus,
    .studio-modal .form-select:focus {
        border-color: #5c32ff;
        box-shadow: 0 0 0 3px rgba(92, 50, 255, 0.1);
    }
    .studio-modal textarea.form-control {
        resize: vertical;
    }

    .studio-section + .studio-section {
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
    }
    .studio-section-label {
        margin-bottom: 10px;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #94a3b8;
    }

    /* Segmented upload / URL switch */
    .studio-segmented {
        display: inline-flex;
        gap: 2px;
        padding: 3px;
        background: #f1f5f9;
        border-radius: 8px;
    }
    .studio-seg {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        line-height: 1.3;
        transition: background-color 0.15s ease, color 0.15s ease;
    }
    .studio-seg:hover {
        color: #0f172a;
    }
    .studio-seg.active {
        background: #ffffff;
        color: #5c32ff;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.12);
    }

    /* Upload dropzone */
    .studio-dropzone {
        padding: 22px 16px;
        text-align: center;
        background: #fafbff;
        border: 1.5px dashed #cbd5e1;
        border-radius: 8px;
        cursor: pointer;
        transition: border-color 0.15s ease, background-color 0.15s ease;
    }
    .studio-dropzone:hover,
    .studio-dropzone.dragover {
        background: #f6f2ff;
        border-color: #5c32ff;
    }
    .studio-dropzone-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        margin-bottom: 8px;
        border-radius: 8px;
        background: #f1edff;
        color: #5c32ff;
        font-size: 16px;
    }
    .studio-dropzone-title {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
    }
    .studio-hint {
        font-size: 11.5px;
        line-height: 1.5;
        color: #94a3b8;
    }

    /* Upload / processing / preview panels */
    .studio-panel {
        padding: 12px 14px;
        background: #f8fafc;
        border: 1px solid #eef1f6;
        border-radius: 8px;
    }
    .studio-panel .progress {
        height: 6px;
        border-radius: 8px;
        background: #e2e8f0;
    }
    .studio-panel .progress-bar {
        border-radius: 8px;
        font-size: 0;
    }
    .studio-panel .btn-sm {
        border-radius: 8px;
        font-weight: 600;
    }

    /* External URL field */
    .studio-url-field {
        position: relative;
        display: flex;
        align-items: center;
    }
    .studio-url-field > i {
        position: absolute;
        left: 12px;
        font-size: 12px;
        color: #94a3b8;
        pointer-events: none;
    }
    .studio-url-field .form-control {
        padding-left: 34px;
    }
    .studio-link-btn {
        padding: 0;
        border: 0;
        background: none;
        font-size: 11.5px;
        font-weight: 600;
        color: #5c32ff;
    }
    .studio-link-btn:hover {
        color: #4b28d6;
    }
    .studio-modal .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .studio-modal .input-group .btn {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        font-size: 12.5px;
        border-color: #e2e8f0;
        color: #64748b;
    }

    /* Utility shims used by the studio markup (not in the global bundles) */
    .studio-page .font-10 { font-size: 10px; }
    .studio-page .font-11 { font-size: 11px; }
    .studio-page .font-12 { font-size: 12px; }
    .studio-page .font-13 { font-size: 13px; }
    .studio-page .gap-2\.5 { gap: 8px; }
    .studio-page .py-0\.5 { padding-top: 2px; padding-bottom: 2px; }
    .studio-page .px-2\.5 { padding-left: 10px; padding-right: 10px; }
    .studio-page .border-dashed { border-style: dashed !important; }

    .builder-module-title-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-grow: 1;
        min-width: 0;
    }
    .builder-module-icon {
        width: 18px;
        text-align: center;
        font-size: 12px;
        color: #5c32ff;
    }
    .builder-module-name {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }
    .builder-module-meta {
        margin-top: 1px;
        font-size: 10.5px;
        color: #94a3b8;
    }
</style>
@endsection

@section('content')
<div class="studio-page">
<form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" id="courseForm">
    @csrf
    @if(isset($course))
        <input type="hidden" name="slug" value="{{ $course->slug }}">
    @endif
    <input type="hidden" name="curriculum_json" id="curriculumJsonInput" value="">

    <!-- Page Header -->
    <div class="studio-head">
        <div class="studio-head-main">
            <span class="studio-head-icon"><i class="fa-solid fa-graduation-cap"></i></span>
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.courses') }}">Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($course) ? 'Edit course' : 'New course' }}</li>
                    </ol>
                </nav>
                <h1 class="studio-title">{{ isset($course) ? $course->title : 'Course Studio' }}</h1>
                <p class="studio-subtitle">Manage course details, pricing and the 3-tier curriculum synced with the student portal.</p>
            </div>
        </div>
        <div class="studio-head-actions">
            <a href="{{ route('admin.courses') }}" class="btn-adm btn-adm-outline">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Courses</span>
            </a>
            @if(isset($course))
            <a href="{{ route('course-details', $course->slug) }}" target="_blank" class="btn-adm btn-adm-outline" title="Preview Public Page">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Preview</span>
            </a>
            @endif
            <button type="submit" class="btn-adm btn-adm-primary" id="saveCourseBtn">
                <i class="fa-solid fa-check"></i>
                <span>{{ isset($course) ? 'Save changes' : 'Create course' }}</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3" style="background: #ecfdf5; color: #047857; font-size: 12.5px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger py-2 px-3 mb-3 border-0 rounded-3" style="background: #fef2f2; color: #b91c1c; font-size: 12.5px;">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row g-3">
        <!-- Main Content Column -->
        <div class="col-lg-8">
            <!-- 1. Course Information Card -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <div>
                        <h2 class="adm-card-title">1. Course Information</h2>
                        <div class="text-muted font-11">Core program details, category, pricing, and public batch description.</div>
                    </div>
                </div>
                <div class="adm-card-body">
                    <div class="mb-3">
                        <label class="form-label">Course Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control font-13 fw-semibold" 
                               placeholder="e.g. MDCAT 2026: Complete All-Subject Medical Prep Batch" 
                               value="{{ old('title', $course->title ?? '') }}" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Target Exam Category <span class="text-danger">*</span></label>
                            @php $cat = old('category', $course->category ?? 'mdcat'); @endphp
                            <select name="category" class="form-select font-12" required>
                                <option value="mdcat" {{ $cat == 'mdcat' ? 'selected' : '' }}>MDCAT Full (5 PMDC Subjects Bundle)</option>
                                <option value="nums" {{ $cat == 'nums' ? 'selected' : '' }}>NUMS Medical Entrance (Army Medical College Pattern)</option>
                                <option value="army" {{ $cat == 'army' ? 'selected' : '' }}>Army / AMC (Cadet & Intelligence Prep)</option>
                                <option value="past_papers" {{ $cat == 'past_papers' ? 'selected' : '' }}>FLPs & 10-Year Solved Past Papers Series</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lead Faculty / Department</label>
                            <input type="text" name="instructor" class="form-control font-12" 
                                   placeholder="e.g. DoctorsInn Medical Faculty Panel"
                                   value="{{ old('instructor', $course->instructor ?? '') }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Success Highlight Badge</label>
                            <input type="text" name="success_badge" class="form-control font-12" 
                                   placeholder="e.g. 300+ Qualifiers in Top Medical Colleges" 
                                   value="{{ old('success_badge', $course->success_badge ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lectures & Quizzes Badge Label</label>
                            <input type="text" name="lessons" id="lessonsBadgeInput" class="form-control font-12" 
                                   placeholder="e.g. 140+ Lectures • 40 Quizzes (Auto-calculated if blank)" 
                                   value="{{ old('lessons', $course->lessons ?? '') }}">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Detailed Course Overview</label>
                        <textarea name="overview" class="form-control font-12" rows="3" placeholder="Course overview, syllabus breakdown, and live mentorship features...">{{ old('overview', $course->overview ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 2. 3-Tier Dynamic Course Curriculum Studio (Matching Student Portal) -->
            <div class="adm-card mb-3">
                <div class="adm-card-header pb-2.5">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h2 class="adm-card-title mb-0">2. 3-Tier Course Curriculum Builder</h2>
                            <span class="status-chip primary">Student Portal Synced</span>
                        </div>
                        <div class="text-muted font-11">
                            Build the exact 3-tier hierarchy: <strong>Modules &rarr; Chapters &rarr; Topics & Quizzes (Video, Reading, Topic Quiz, Chapter Quiz)</strong>.
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2 font-11" id="btnLoadTemplate" title="Quickly fill with sample Biology, Chemistry, Physics curriculum">
                            <i class="fa-solid fa-wand-magic-sparkles me-1 text-warning"></i> Load PMDC Starter
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 font-11" id="btnClearCurriculum" title="Empty all modules">
                            <i class="fa-solid fa-trash me-1"></i> Clear
                        </button>
                        <button type="button" class="btn btn-sm btn-primary py-1 px-2.5 font-11 fw-semibold" id="btnAddModuleBtn">
                            <i class="fa-solid fa-plus me-1"></i> Add Module
                        </button>
                    </div>
                </div>

                <!-- Live Summary Statistics Bar -->
                <div class="studio-stats px-3 py-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span><strong class="text-dark" id="statModulesCount">0</strong> Modules</span>
                        <span>&bull;</span>
                        <span><strong class="text-dark" id="statChaptersCount">0</strong> Chapters</span>
                        <span>&bull;</span>
                        <span><strong class="text-dark" id="statTopicsCount">0</strong> Lectures</span>
                        <span>&bull;</span>
                        <span><strong class="text-dark" id="statQuizzesCount">0</strong> Quizzes</span>
                    </div>
                    <div class="font-11 text-secondary">
                        <i class="fa-solid fa-circle-info me-1"></i> Changes auto-sync to student classroom
                    </div>
                </div>

                <div class="adm-card-body">
                    <!-- Tree Container rendered dynamically by JS -->
                    <div id="modulesContainer">
                        <!-- Dynamic Module Cards Injected Here -->
                    </div>

                    <!-- Bottom Add Module Trigger -->
                    <div class="text-center pt-2">
                        <button type="button" class="btn-adm btn-adm-outline w-100 py-2 font-12 text-primary border-dashed" id="btnBottomAddModule">
                            <i class="fa-solid fa-folder-plus me-1"></i>
                            <span>+ Add Another Subject / Module</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- 3. Preparation Roadmap Card -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <div>
                        <h2 class="adm-card-title">3. Preparation Roadmap Milestones</h2>
                        <div class="text-muted font-11">Define 3-phase weekly milestones shown to prospective students.</div>
                    </div>
                </div>
                <div class="adm-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="roadmap-card h-100">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-dark font-12">Phase 1</span>
                                    <span class="text-muted font-11">Weeks 1 – 4</span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label font-10 text-muted mb-0">Phase Title</label>
                                    <input type="text" name="roadmap[0][title]" class="form-control font-12" value="Foundation & Concepts">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label font-10 text-muted mb-0">Weekly Focus</label>
                                    <textarea name="roadmap[0][description]" class="form-control font-11" rows="2">100% PMDC syllabus coverage across Biology, Chemistry & Physics with daily topic quizzes.</textarea>
                                </div>
                                <div class="small text-muted font-11 pt-1 border-top">
                                    <i class="fa-solid fa-bullseye text-primary me-1"></i> Target: 1,500 MCQs
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="roadmap-card h-100">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-dark font-12">Phase 2</span>
                                    <span class="text-muted font-11">Weeks 5 – 8</span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label font-10 text-muted mb-0">Phase Title</label>
                                    <input type="text" name="roadmap[1][title]" class="form-control font-12" value="Past Papers & Speed Drills">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label font-10 text-muted mb-0">Weekly Focus</label>
                                    <textarea name="roadmap[1][description]" class="form-control font-11" rows="2">Chapter-wise past 10-year PMDC/UHS questions, speed elimination, and formula drills.</textarea>
                                </div>
                                <div class="small text-muted font-11 pt-1 border-top">
                                    <i class="fa-solid fa-bullseye text-warning me-1"></i> Target: 2,500 Past MCQs
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="roadmap-card h-100">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-dark font-12">Phase 3</span>
                                    <span class="text-muted font-11">Weeks 9 – 12</span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label font-10 text-muted mb-0">Phase Title</label>
                                    <input type="text" name="roadmap[2][title]" class="form-control font-12" value="Grand FLPs Simulation">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label font-10 text-muted mb-0">Weekly Focus</label>
                                    <textarea name="roadmap[2][description]" class="form-control font-11" rows="2">10 Full-Length Simulated Papers (200 MCQs, 3.5 hrs timer) with provincial merit ranking.</textarea>
                                </div>
                                <div class="small text-muted font-11 pt-1 border-top">
                                    <i class="fa-solid fa-bullseye text-success me-1"></i> Target: 180+ MDCAT Score
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options Column -->
        <div class="col-lg-4">
            <!-- Publishing & Enrollment -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">Enrollment & Status</h2>
                </div>
                <div class="adm-card-body">
                    <div class="mb-3">
                        <label class="form-label">Batch Status</label>
                        <select name="batch_status" class="form-select font-12">
                            <option value="active" selected>Active (Open for Admissions)</option>
                            <option value="upcoming">Upcoming (Pre-Registration)</option>
                            <option value="draft">Draft (Unlisted)</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Duration <span class="text-danger">*</span></label>
                            <input type="text" name="duration" class="form-control font-12" 
                                   placeholder="e.g. 60 Days"
                                   value="{{ old('duration', $course->duration ?? '') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Seat Limit</label>
                            <input type="number" name="seats" class="form-control font-12" value="{{ old('seats', $course->seats ?? 350) }}">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Language of Instruction</label>
                        <input type="text" name="language" class="form-control font-12" 
                               placeholder="e.g. Urdu / English"
                               value="{{ old('language', $course->language ?? 'Urdu / English') }}">
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">Course Fee & Pricing</h2>
                </div>
                <div class="adm-card-body">
                    <div class="mb-3">
                        <label class="form-label">Price (PKR) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted font-12">Rs.</span>
                            <input type="text" name="price" class="form-control font-13 fw-bold" 
                                   placeholder="e.g. 3,500"
                                   value="{{ old('price', $course->price ?? '') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Compare-at Price (Original)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted font-12">Rs.</span>
                            <input type="text" name="original_price" class="form-control font-12 text-muted" 
                                   placeholder="e.g. 6,000"
                                   value="{{ old('original_price', $course->original_price ?? '') }}">
                        </div>
                        <div class="text-muted font-10 mt-1">Displays strike-through discount to students.</div>
                    </div>

                    <div class="form-check form-switch p-0 ps-4">
                        <input class="form-check-input" type="checkbox" id="acceptDirectPay" checked>
                        <label class="form-check-label font-11 text-muted" for="acceptDirectPay">Allow Direct Bank / JazzCash / EasyPaisa</label>
                    </div>
                </div>
            </div>

            <!-- Course Thumbnail -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">Course Banner</h2>
                </div>
                <div class="adm-card-body text-center">
                    <div class="studio-thumb mb-2">
                        @php 
                            $thumb = isset($course) && $course->image ? $course->image : 'frontend/img/course/course1-1.jpg';
                        @endphp
                        <img src="{{ asset($thumb) }}" id="courseThumbPreview" alt="Course Thumbnail" class="img-fluid rounded" style="max-height: 140px; width: 100%; object-fit: cover;">
                        <input type="hidden" name="existing_image" value="{{ $thumb }}">
                    </div>
                    <input type="file" name="thumbnail" id="courseThumbInput" accept="image/*" class="form-control mb-1 font-11"
                           onchange="if(this.files[0]){ document.getElementById('courseThumbPreview').src = URL.createObjectURL(this.files[0]); }">
                    <div class="text-muted font-10">Recommended 1200×800px. Auto-optimized to WebP on upload.</div>
                </div>
            </div>

            <!-- Inclusions Checklist -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">Package Inclusions</h2>
                </div>
                <div class="adm-card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="inc1" checked>
                        <label class="form-check-label font-12 text-dark" for="inc1">10 Full-Length Simulated Papers (FLPs)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="inc2" checked>
                        <label class="form-check-label font-12 text-dark" for="inc2">140+ HD Chapter Video Lectures</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="inc3" checked>
                        <label class="form-check-label font-12 text-dark" for="inc3">5,500+ Practice MCQs with Rationales</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="inc4" checked>
                        <label class="form-check-label font-12 text-dark" for="inc4">WhatsApp Mentorship Group</label>
                    </div>
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="inc5" checked>
                        <label class="form-check-label font-12 text-dark" for="inc5">E-Library Vault & Notes</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- ========================================================================= --}}
{{-- MODALS FOR MODULES, CHAPTERS, TOPICS & QUIZZES                            --}}
{{-- ========================================================================= --}}

<!-- 1. Module Modal -->
<div class="modal fade studio-modal" id="modalModule" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="modalModuleTitle">Configure module</h5>
                    <div class="studio-modal-sub">Group chapters under a subject or module.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputModuleIdx" value="-1">
                <div class="mb-3">
                    <label class="form-label">Module / subject name <span class="text-danger">*</span></label>
                    <input type="text" id="inputModuleName" class="form-control" placeholder="e.g. Module 1: Biology" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Module icon</label>
                    <select id="inputModuleIcon" class="form-select">
                        <option value="fa-solid fa-microscope">Microscope &middot; Biology</option>
                        <option value="fa-solid fa-flask-vial">Flask &middot; Chemistry</option>
                        <option value="fa-solid fa-bolt">Bolt &middot; Physics</option>
                        <option value="fa-solid fa-brain">Brain &middot; Logic &amp; Reasoning</option>
                        <option value="fa-solid fa-book-open">Book &middot; English &amp; Grammar</option>
                        <option value="fa-solid fa-stethoscope">Stethoscope &middot; Clinical</option>
                        <option value="fa-solid fa-layer-group">Layer group &middot; General</option>
                    </select>
                </div>
                <div class="mb-0">
                    <label class="form-label">Description / syllabus scope</label>
                    <textarea id="inputModuleDesc" class="form-control" rows="2" placeholder="Brief subject description, e.g. core PMDC syllabus topics"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-adm btn-adm-outline" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-adm btn-adm-primary" id="btnSaveModule">Save module</button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Chapter Modal -->
<div class="modal fade studio-modal" id="modalChapter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="modalChapterTitle">Configure chapter</h5>
                    <div class="studio-modal-sub">Add a chapter inside the selected module.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputChapterModuleIdx" value="-1">
                <input type="hidden" id="inputChapterIdx" value="-1">
                <div class="mb-3">
                    <label class="form-label">Chapter title <span class="text-danger">*</span></label>
                    <input type="text" id="inputChapterName" class="form-control" placeholder="e.g. Chapter 1: Cell Biology & Cytology" required>
                </div>
                <div class="mb-0">
                    <label class="form-label">Chapter summary / description</label>
                    <textarea id="inputChapterDesc" class="form-control" rows="2" placeholder="Brief chapter overview and key learning targets"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-adm btn-adm-outline" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-adm btn-adm-primary" id="btnSaveChapter">Save chapter</button>
            </div>
        </div>
    </div>
</div>

<!-- 3. Topic Modal (Video Lecture or Reading Topic) -->
<div class="modal fade studio-modal" id="modalTopic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="modalTopicTitle">Configure Topic</h5>
                    <div class="studio-modal-sub">Add a lesson, its video source and supporting study material.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cancelVideoUpload(); cancelHandoutUpload();"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputTopicModuleIdx" value="-1">
                <input type="hidden" id="inputTopicChapterIdx" value="-1">
                <input type="hidden" id="inputTopicIdx" value="-1">

                <div class="studio-section">
                    <div class="studio-section-label">Lecture details</div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Topic format <span class="text-danger">*</span></label>
                            <select id="inputTopicType" class="form-select" onchange="toggleTopicTypeFields()">
                                <option value="video">Video lecture</option>
                                <option value="reading">Reading notes</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Topic title <span class="text-danger">*</span></label>
                            <input type="text" id="inputTopicName" class="form-control" placeholder="e.g. 1.1 Cell Membrane & Fluid Mosaic Architecture" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Duration <span class="text-danger">*</span></label>
                            <input type="text" id="inputTopicDuration" class="form-control" placeholder="e.g. 35 min" value="35 min">
                        </div>
                    </div>
                </div>

                <div class="studio-section" id="videoUrlGroup">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                        <div class="studio-section-label mb-0">Video source</div>
                        <div class="studio-segmented" role="group">
                            <button type="button" class="studio-seg active" id="btnTabUploadVideo" onclick="switchVideoMode('upload')">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Upload file
                            </button>
                            <button type="button" class="studio-seg" id="btnTabUrlVideo" onclick="switchVideoMode('url')">
                                <i class="fa-solid fa-link"></i> External URL
                            </button>
                        </div>
                    </div>

                    <!-- Mode A: Secure HLS Lecture Upload -->
                    <div id="videoUploadBox">
                        <input type="hidden" id="inputTopicLectureId" value="">
                        <div class="studio-dropzone" id="videoDropZone" onclick="document.getElementById('videoFileInput').click();">
                            <span class="studio-dropzone-icon"><i class="fa-solid fa-film"></i></span>
                            <div class="studio-dropzone-title">Click to upload or drag &amp; drop</div>
                            <div class="studio-hint">MP4, MOV, WebM, MKV or AVI &middot; up to {{ $maxUploadMb ?? 40 }} MB &middot; private, adaptive HLS streaming</div>
                            <input type="file" id="videoFileInput" accept="video/mp4,video/webm,video/quicktime,video/x-matroska,video/x-msvideo,video/*" class="d-none">
                        </div>

                        <!-- Upload Progress Bar with Cancel Button -->
                        <div id="videoUploadProgressWrapper" class="d-none mt-2 studio-panel">
                            <div class="d-flex align-items-center justify-content-between font-11 mb-2">
                                <div class="d-flex align-items-center gap-2 text-truncate me-2">
                                    <span class="spinner-border spinner-border-sm text-primary flex-shrink-0" style="width: 13px; height: 13px;" role="status"></span>
                                    <span class="text-dark fw-semibold text-truncate" id="videoUploadProgressText">Uploading video to server...</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    <span class="text-primary fw-bold font-12" id="videoUploadPercent">0%</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger py-0.5 px-2 font-11 rounded" id="btnCancelVideoUpload" onclick="cancelVideoUpload()" title="Abort this video upload immediately">
                                        <i class="fa-solid fa-xmark me-1"></i> Cancel Upload
                                    </button>
                                </div>
                            </div>
                            <div class="progress" id="videoUploadProgressTrack">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" id="videoProgressBar" role="progressbar" style="width: 0%;"></div>
                            </div>
                        </div>

                        <!-- Background Processing / Transcoding Status -->
                        <div id="videoProcessingWrapper" class="d-none mt-2 studio-panel">
                            <div class="d-flex align-items-center justify-content-between font-11 mb-2">
                                <div class="d-flex align-items-center gap-2 text-truncate me-2">
                                    <span class="spinner-border spinner-border-sm text-primary flex-shrink-0" style="width: 13px; height: 13px;" role="status"></span>
                                    <span class="text-dark fw-semibold text-truncate" id="videoProcessingText">Processing lecture into HLS…</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    <span class="text-primary fw-bold font-12" id="videoProcessingPercent">0%</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary py-0.5 px-2 font-11 rounded" onclick="stopLecturePolling()" title="Continue processing in the background">
                                        <i class="fa-solid fa-eye-slash me-1"></i> Hide
                                    </button>
                                </div>
                            </div>
                            <div class="progress" id="videoProcessingProgressTrack">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="videoProcessingBar" role="progressbar" style="width: 0%;"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <div class="font-10 text-danger d-none" id="videoProcessingError"></div>
                                <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2 font-10 rounded d-none" id="btnRetryLectureProcessing" onclick="retryLectureProcessing()">
                                    <i class="fa-solid fa-rotate-right me-1"></i> Retry Processing
                                </button>
                            </div>
                        </div>

                        <!-- Video Preview Box -->
                        <div id="videoPreviewWrapper" class="d-none mt-2 studio-panel">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2 text-truncate">
                                    <span class="status-chip success" id="videoPreviewBadge"><i class="fa-solid fa-circle-check"></i> HLS Ready</span>
                                    <span class="font-11 fw-semibold text-dark text-truncate" id="videoPreviewName">video.mp4</span>
                                    <span class="font-10 text-muted" id="videoPreviewSize">0 MB</span>
                                </div>
                                <button type="button" class="btn btn-sm btn-link text-danger p-0 font-11 text-decoration-none" onclick="clearUploadedVideo()">
                                    <i class="fa-solid fa-trash me-1"></i> Remove
                                </button>
                            </div>
                            <video id="videoModalPlayer" class="video-js vjs-big-play-centered w-100 rounded" controls preload="auto" playsinline style="max-height: 220px; background: #000;"></video>
                        </div>
                    </div>

                    <!-- Mode B: External Stream / URL Box -->
                    <div id="videoUrlBox" class="d-none">
                        <div class="studio-url-field">
                            <i class="fa-solid fa-link"></i>
                            <input type="text" id="inputTopicVideoUrl" class="form-control" placeholder="https://... direct stream or unlisted video link" oninput="onVideoUrlManualInput(this.value)">
                        </div>
                        <div class="studio-hint mt-2">Use a direct stream URL or an unlisted YouTube / Vimeo / CDN link.</div>
                    </div>
                </div>

                <div class="studio-section">
                    <div class="studio-section-label">Study material</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Handout title</label>
                            <input type="text" id="inputTopicHandout" class="form-control" placeholder="e.g. Chapter 1 High-Yield Handout.pdf">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-flex align-items-center justify-content-between">
                                <span>Handout link</span>
                                <button type="button" class="studio-link-btn" onclick="document.getElementById('handoutFileInput').click();">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Upload PDF
                                </button>
                            </label>
                            <div class="input-group">
                                <input type="text" id="inputTopicHandoutUrl" class="form-control" placeholder="Upload a file or paste a URL">
                                <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('handoutFileInput').click();" title="Upload handout PDF">
                                    <i class="fa-solid fa-file-arrow-up"></i>
                                </button>
                            </div>
                            <input type="file" id="handoutFileInput" accept="application/pdf,.doc,.docx" class="d-none">
                            <div id="handoutUploadIndicator" class="studio-hint mt-1"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Lesson notes / summary</label>
                            <textarea id="inputTopicNotes" class="form-control" rows="4" placeholder="High-yield notes, key formulas or summary points shown to students in the classroom."></textarea>
                            <div class="studio-hint mt-1">HTML or Markdown is supported.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-adm btn-adm-outline" data-bs-dismiss="modal" onclick="cancelVideoUpload(); cancelHandoutUpload();">Cancel</button>
                <button type="button" class="btn-adm btn-adm-primary" id="btnSaveTopic">Save topic</button>
            </div>
        </div>
    </div>
</div>

<!-- 4. Quiz Modal (Topic Quiz or Chapter Quiz with MCQ Builder) -->
<div class="modal fade studio-modal" id="modalQuiz" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="modalQuizTitle">Configure quiz</h5>
                    <div class="studio-modal-sub">Set the assessment scope, timing and MCQ bank.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputQuizModuleIdx" value="-1">
                <input type="hidden" id="inputQuizChapterIdx" value="-1">
                <input type="hidden" id="inputQuizIdx" value="-1">

                <div class="studio-section">
                    <div class="studio-section-label">Quiz settings</div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Quiz level <span class="text-danger">*</span></label>
                            <select id="inputQuizType" class="form-select">
                                <option value="topic">Topic quiz &middot; quick checkpoint</option>
                                <option value="chapter">Chapter quiz &middot; comprehensive</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Quiz title <span class="text-danger">*</span></label>
                            <input type="text" id="inputQuizName" class="form-control" placeholder="e.g. Topic 1.1 Quick Quiz: Cell Transport" required>
                        </div>
                        <div class="col-md-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label">Duration</label>
                                    <input type="text" id="inputQuizDuration" class="form-control" value="5 min">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Pass %</label>
                                    <input type="number" id="inputQuizPass" class="form-control" value="80" min="1" max="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MCQs Questions Builder -->
                <div class="studio-section">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="studio-section-label mb-0">Questions &amp; MCQs builder</div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-3" id="btnAddMcqQuestion">
                            <i class="fa-solid fa-plus me-1"></i> Add question
                        </button>
                    </div>

                    <div id="quizQuestionsContainer" style="max-height: 380px; overflow-y: auto; padding-right: 4px;">
                        <!-- Question blocks rendered here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-adm btn-adm-outline" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-adm btn-adm-primary" id="btnSaveQuiz">Save quiz</button>
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
/**
 * DoctorsInn Admin Course & 3-Tier Hierarchy Studio
 * Modules -> Chapters -> Topics & Quizzes
 */

const COURSE_STUDIO_ID = @json($course->id ?? null);
const COURSE_STUDIO_UPLOAD_MAX_MB = {{ $maxUploadMb ?? 40 }};
const COURSE_STUDIO_BASE_URL = @json(url('/'));

// Initial Seed Data (from DB or default starter)
@php
    $initialModules = [];
    if (isset($course)) {
        if (!empty($course->curriculum) && is_array($course->curriculum) && isset($course->curriculum[0]['chapters'])) {
            $initialModules = $course->curriculum;
        } elseif (!empty($course->modules) && is_array($course->modules)) {
            $initialModules = $course->modules;
        }
    }
@endphp

let courseModules = @json($initialModules);

// Fallback Standard PMDC Template for 1-Click Setup
const standardPmdcTemplate = [
    {
        id: "mod-bio",
        name: "Module 1: Biology",
        icon: "fa-solid fa-microscope",
        description: "Core PMDC Biology syllabus: Cell Biology, Biological Molecules & Genetics.",
        chapters: [
            {
                id: "bio-ch-1",
                name: "Chapter 1: Cell Biology & Cytology",
                description: "Plasma membrane dynamics, organelle functions & cell division.",
                topics: [
                    {
                        id: "bio-top-1-1",
                        title: "1.1 Cell Membrane & Fluid Mosaic Architecture",
                        type: "video",
                        duration: "35 min",
                        videoUrl: "https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4",
                        readContent: "<p><strong>Summary:</strong> Covers Singer & Nicolson's Fluid Mosaic Model, lipid bilayer, cholesterol buffer and transport mechanisms.</p>",
                        resources: [{ name: "Cell Biology Chapter Notes — PDF", type: "pdf" }]
                    },
                    {
                        id: "bio-quiz-1-1",
                        title: "Topic 1.1 Quick Quiz: Membrane Transport",
                        type: "quiz",
                        isQuiz: true,
                        quizType: "topic",
                        duration: "5 min",
                        quizData: {
                            title: "Topic 1.1 Checkpoint: Cell Membrane",
                            passingScore: 80,
                            timeLimitMinutes: 5,
                            questions: [
                                {
                                    question: "Which component of the plasma membrane acts as a fluidity buffer across temperature fluctuations in animal cells?",
                                    options: ["Peripheral glycoproteins", "Cholesterol molecules", "Sphingomyelin lipids", "Oligosaccharide chains"],
                                    correctIndex: 1,
                                    explanation: "Cholesterol prevents phospholipid fatty acid chains from crystallization at low temperatures and excessive fluidity at high temperatures."
                                },
                                {
                                    question: "In the Sodium-Potassium ATPase pump, what is the stoichiometric exchange ratio per ATP hydrolyzed?",
                                    options: ["3 Na+ out, 2 K+ in", "2 Na+ out, 3 K+ in", "3 Na+ in, 2 K+ out", "1 Na+ out, 1 K+ in"],
                                    correctIndex: 0,
                                    explanation: "The primary active Na+/K+ ATPase pumps 3 Sodium ions OUT and 2 Potassium ions IN per ATP hydrolyzed."
                                }
                            ]
                        }
                    },
                    {
                        id: "bio-top-1-2",
                        title: "1.2 Endomembrane System & Mitochondria",
                        type: "video",
                        duration: "42 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
                        readContent: "<p>Endoplasmic reticulum, Golgi trafficking, lysosomes, peroxisomes and mitochondrial oxidative phosphorylation.</p>",
                        resources: [{ name: "Organelles Quick Sheet — PDF", type: "pdf" }]
                    },
                    {
                        id: "bio-top-1-3",
                        title: "1.3 Mitosis, Meiosis & Karyotyping High-Yield Notes",
                        type: "reading",
                        duration: "15 min",
                        readContent: "<h4>Cell Cycle Checkpoints & Karyotypes</h4><p>G1/S, G2/M and Spindle assembly checkpoints ensure genetic fidelity.</p>",
                        resources: [{ name: "Mitosis & Meiosis Tables — PDF", type: "pdf" }]
                    },
                    {
                        id: "bio-exam-ch-1",
                        title: "Chapter 1 Comprehensive Mastery Assessment",
                        type: "quiz",
                        isQuiz: true,
                        quizType: "chapter",
                        duration: "10 min",
                        quizData: {
                            title: "Chapter 1 Comprehensive Mastery Assessment",
                            passingScore: 75,
                            timeLimitMinutes: 10,
                            questions: [
                                {
                                    question: "Which checkpoint in eukaryotic cell division is predominantly regulated by p53 protein activation?",
                                    options: ["G1 to S restriction checkpoint", "G2 to M transition", "Spindle assembly Metaphase checkpoint", "Cytokinesis initiation"],
                                    correctIndex: 0,
                                    explanation: "The G1/S checkpoint arrests cell cycle via p53-mediated p21 induction upon DNA damage."
                                }
                            ]
                        }
                    }
                ]
            },
            {
                id: "bio-ch-2",
                name: "Chapter 2: Biological Molecules & Enzymology",
                description: "Carbohydrates, proteins, lipids, nucleic acids & enzyme kinetics.",
                topics: [
                    {
                        id: "bio-top-2-1",
                        title: "2.1 Carbohydrates, Glycosidic Bonds & Polysaccharides",
                        type: "video",
                        duration: "38 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
                        readContent: "<p>Monosaccharides, alpha/beta linkages, starch, glycogen and cellulose architecture.</p>",
                        resources: [{ name: "Biomolecules Formula Sheet — PDF", type: "pdf" }]
                    }
                ]
            }
        ]
    },
    {
        id: "mod-chem",
        name: "Module 2: Chemistry",
        icon: "fa-solid fa-flask-vial",
        description: "Stoichiometry, Atomic Structure, Chemical Bonding & Organic Chemistry.",
        chapters: [
            {
                id: "chem-ch-1",
                name: "Chapter 1: Chemical Bonding & Hybridization",
                description: "VSEPR theory, sp3/sp2/sp orbital hybridization & molecular geometry.",
                topics: [
                    {
                        id: "chem-top-1-1",
                        title: "1.1 Orbital Hybridization & Bond Angles",
                        type: "video",
                        duration: "40 min",
                        videoUrl: "https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4",
                        readContent: "<p>Determining steric numbers, hybrid orbitals and geometry deviations.</p>",
                        resources: [{ name: "Hybridization Shortcut Chart — PDF", type: "pdf" }]
                    },
                    {
                        id: "chem-quiz-1-1",
                        title: "Topic 1.1 Quick Quiz: Hybridization & Shapes",
                        type: "quiz",
                        isQuiz: true,
                        quizType: "topic",
                        duration: "5 min",
                        quizData: {
                            title: "Topic 1.1 Checkpoint: Bonding & Geometry",
                            passingScore: 80,
                            timeLimitMinutes: 5,
                            questions: [
                                {
                                    question: "What is the hybridization and molecular geometry of Xenon Tetrafluoride (XeF4)?",
                                    options: ["sp3d2, Square Planar", "sp3d, Trigonal Bipyramidal", "sp3, Tetrahedral", "sp3d2, Octahedral"],
                                    correctIndex: 0,
                                    explanation: "XeF4 has 4 bond pairs and 2 lone pairs giving an octahedral electron geometry and square planar molecular shape."
                                }
                            ]
                        }
                    }
                ]
            }
        ]
    },
    {
        id: "mod-phy",
        name: "Module 3: Physics",
        icon: "fa-solid fa-bolt",
        description: "Mechanics, Work & Energy, Electromagnetism & Modern Physics.",
        chapters: [
            {
                id: "phy-ch-1",
                name: "Chapter 1: Vectors, Equilibrium & Motion",
                description: "Vector resolution, Newton laws, projectile motion & drag force.",
                topics: [
                    {
                        id: "phy-top-1-1",
                        title: "1.1 Projectile Trajectories & Range Formulas",
                        type: "video",
                        duration: "45 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
                        readContent: "<p>Maximum height, time of flight, horizontal range and complementary angle rules.</p>",
                        resources: [{ name: "Physics Mechanics Cheat Sheet — PDF", type: "pdf" }]
                    }
                ]
            }
        ]
    }
];

// Clean default: empty modules if creating new course (template can be loaded manually via 'Load PMDC Starter')
if (!Array.isArray(courseModules)) {
    courseModules = [];
}

// Global Modal Instances
let bsModalModule, bsModalChapter, bsModalTopic, bsModalQuiz;
let currentQuizWorkingQuestions = [];

document.addEventListener('DOMContentLoaded', function () {
    // Initialize Bootstrap Modals
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bsModalModule = new bootstrap.Modal(document.getElementById('modalModule'));
        bsModalChapter = new bootstrap.Modal(document.getElementById('modalChapter'));
        bsModalTopic = new bootstrap.Modal(document.getElementById('modalTopic'));
        bsModalQuiz = new bootstrap.Modal(document.getElementById('modalQuiz'));
    }

    // Attach Top Header Action Buttons
    document.getElementById('btnAddModuleBtn')?.addEventListener('click', () => openModuleModal(-1));
    document.getElementById('btnBottomAddModule')?.addEventListener('click', () => openModuleModal(-1));
    document.getElementById('btnSaveModule')?.addEventListener('click', saveModule);
    document.getElementById('btnSaveChapter')?.addEventListener('click', saveChapter);
    document.getElementById('btnSaveTopic')?.addEventListener('click', saveTopic);
    document.getElementById('btnSaveQuiz')?.addEventListener('click', saveQuiz);
    document.getElementById('btnAddMcqQuestion')?.addEventListener('click', addMcqQuestionField);

    document.getElementById('btnLoadTemplate')?.addEventListener('click', function () {
        if (confirm('Load standard PMDC MDCAT Curriculum Template? Any unsaved changes in current structure will be replaced.')) {
            courseModules = JSON.parse(JSON.stringify(standardPmdcTemplate));
            renderBuilder();
        }
    });

    document.getElementById('btnClearCurriculum')?.addEventListener('click', function () {
        if (confirm('Clear all modules and chapters from this course?')) {
            courseModules = [];
            renderBuilder();
        }
    });

    // Video File Upload Drag & Drop and File Input
    const videoInput = document.getElementById('videoFileInput');
    if (videoInput) {
        videoInput.addEventListener('change', function () {
            if (this.files && this.files[0]) uploadVideoFile(this.files[0]);
        });
    }

    const videoDropZone = document.getElementById('videoDropZone');
    if (videoDropZone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            videoDropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                videoDropZone.classList.add('dragover');
            }, false);
        });
        ['dragleave', 'drop'].forEach(eventName => {
            videoDropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                videoDropZone.classList.remove('dragover');
            }, false);
        });
        videoDropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files[0]) uploadVideoFile(files[0]);
        }, false);
    }

    // Handout File Input
    const handoutInput = document.getElementById('handoutFileInput');
    if (handoutInput) {
        handoutInput.addEventListener('change', function () {
            if (this.files && this.files[0]) uploadHandoutPdf(this.files[0]);
        });
    }

    // Modal Close Cleanup: abort upload if modal is closed via Backdrop or Escape key
    const modalTopicEl = document.getElementById('modalTopic');
    if (modalTopicEl) {
        modalTopicEl.addEventListener('hidden.bs.modal', function () {
        cancelVideoUpload();
        cancelHandoutUpload();
        stopLecturePolling();
        if (topicVideoJs) { try { topicVideoJs.pause(); } catch (e) {} }
    });
    }

    // Form Submit Hook to ensure curriculum_json is populated
    document.getElementById('courseForm')?.addEventListener('submit', function () {
        syncHiddenInput();
    });

    // Initial Render
    renderBuilder();
});

// =============================================================================
// RENDER 3-TIER HIERARCHY (Modules -> Chapters -> Topics & Quizzes)
// =============================================================================

function renderBuilder() {
    const container = document.getElementById('modulesContainer');
    if (!container) return;

    if (!courseModules || courseModules.length === 0) {
        container.innerHTML = `
            <div class="studio-empty">
                <span class="studio-empty-icon"><i class="fa-solid fa-folder-open"></i></span>
                <div class="studio-empty-title">No modules yet</div>
                <p class="studio-empty-text">Add a subject, or start from the PMDC starter template.</p>
                <button type="button" class="btn-adm btn-adm-primary" onclick="openModuleModal(-1)">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add first module</span>
                </button>
            </div>
        `;
        updateStats();
        syncHiddenInput();
        return;
    }

    let html = '';

    courseModules.forEach((mod, modIdx) => {
        const modName = mod.name || `Module ${modIdx + 1}`;
        const modIcon = mod.icon === 'fa-solid fa-dna' ? 'fa-solid fa-microscope' : (mod.icon || 'fa-solid fa-microscope');
        const chapters = Array.isArray(mod.chapters) ? mod.chapters : [];

        let totalModTopics = 0;
        let totalModQuizzes = 0;
        chapters.forEach(ch => {
            (ch.topics || []).forEach(top => {
                if (top.isQuiz || top.type === 'quiz') totalModQuizzes++;
                else totalModTopics++;
            });
        });

        html += `
            <div class="builder-module-card" data-module-idx="${modIdx}">
                <div class="builder-module-header">
                    <div class="builder-module-title-row text-truncate">
                        <i class="${escapeHtml(modIcon)} builder-module-icon"></i>
                        <div class="text-truncate">
                            <div class="builder-module-name text-truncate">${escapeHtml(modName)}</div>
                            <div class="builder-module-meta">
                                ${chapters.length} Chapters &bull; ${totalModTopics} Lectures &bull; ${totalModQuizzes} Quizzes
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="action-icon-btn" title="Move Up" onclick="moveModule(${modIdx}, -1)">
                            <i class="fa-solid fa-arrow-up"></i>
                        </button>
                        <button type="button" class="action-icon-btn" title="Move Down" onclick="moveModule(${modIdx}, 1)">
                            <i class="fa-solid fa-arrow-down"></i>
                        </button>
                        <button type="button" class="action-icon-btn" title="Edit Module" onclick="openModuleModal(${modIdx})">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button type="button" class="action-icon-btn danger" title="Delete Module" onclick="deleteModule(${modIdx})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2 font-11 ms-1" onclick="openChapterModal(${modIdx}, -1)">
                            <i class="fa-solid fa-plus me-1"></i> Add Chapter
                        </button>
                    </div>
                </div>

                <div class="builder-module-body">
                    ${chapters.length === 0 ? `
                        <div class="text-center py-3 border border-dashed rounded bg-light text-muted font-11">
                            No chapters in this module. Click <strong>+ Add Chapter</strong> above.
                        </div>
                    ` : ''}

                    ${chapters.map((ch, chIdx) => {
                        const topics = Array.isArray(ch.topics) ? ch.topics : [];
                        return `
                            <div class="builder-chapter-card" data-chapter-idx="${chIdx}">
                                <div class="builder-chapter-header">
                                    <div class="d-flex align-items-center gap-2 text-truncate">
                                        <i class="fa-solid fa-folder text-warning font-12"></i>
                                        <span class="fw-semibold text-dark font-12 text-truncate">${escapeHtml(ch.name || `Chapter ${chIdx + 1}`)}</span>
                                        <span class="text-muted font-10">${topics.length} items</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary py-0.5 px-2 font-11 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-plus me-1"></i> Add Item
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm font-11 py-1">
                                                <li><a class="dropdown-item py-1 text-primary" href="javascript:void(0)" onclick="openTopicModal(${modIdx}, ${chIdx}, -1, 'video')"><i class="fa-solid fa-circle-play me-2"></i>+ Video Lecture</a></li>
                                                <li><a class="dropdown-item py-1 text-success" href="javascript:void(0)" onclick="openTopicModal(${modIdx}, ${chIdx}, -1, 'reading')"><i class="fa-solid fa-book-open me-2"></i>+ Reading Topic</a></li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li><a class="dropdown-item py-1 text-warning" href="javascript:void(0)" onclick="openQuizModal(${modIdx}, ${chIdx}, -1, 'topic')"><i class="fa-solid fa-pen-clip me-2"></i>+ Topic Quiz (Checkpoint)</a></li>
                                                <li><a class="dropdown-item py-1 text-purple" style="color: #7c3aed;" href="javascript:void(0)" onclick="openQuizModal(${modIdx}, ${chIdx}, -1, 'chapter')"><i class="fa-solid fa-trophy me-2"></i>+ Chapter Assessment Exam</a></li>
                                            </ul>
                                        </div>
                                        <button type="button" class="action-icon-btn" title="Edit Chapter" onclick="openChapterModal(${modIdx}, ${chIdx})">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button" class="action-icon-btn danger" title="Delete Chapter" onclick="deleteChapter(${modIdx}, ${chIdx})">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="builder-topics-list">
                                    ${topics.length === 0 ? `
                                        <div class="p-2 text-center text-muted font-10">No topics or quizzes yet. Use "+ Add Item" to add lectures or tests.</div>
                                    ` : ''}

                                    ${topics.map((top, topIdx) => {
                                        const isQuiz = top.isQuiz || top.type === 'quiz';
                                        const quizType = top.quizType || (top.title && top.title.toLowerCase().includes('chapter') ? 'chapter' : 'topic');
                                        const questionsCount = (top.quizData && Array.isArray(top.quizData.questions)) ? top.quizData.questions.length : 0;

                                        let iconHtml = '';
                                        if (isQuiz) {
                                            if (quizType === 'chapter') {
                                                iconHtml = `<i class="fa-solid fa-trophy text-purple font-12" style="color: #7c3aed;"></i>`;
                                            } else {
                                                iconHtml = `<i class="fa-solid fa-pen-clip text-warning font-12"></i>`;
                                            }
                                        } else if (top.type === 'reading') {
                                            iconHtml = `<i class="fa-solid fa-book-open text-success font-12"></i>`;
                                        } else {
                                            iconHtml = `<i class="fa-solid fa-circle-play text-primary font-12"></i>`;
                                        }

                                        return `
                                            <div class="builder-topic-row">
                                                <div class="d-flex align-items-center gap-2 flex-grow-1 text-truncate">
                                                    ${iconHtml}
                                                    <div class="text-truncate">
                                                        <div class="fw-semibold text-dark font-12 text-truncate">${escapeHtml(top.title || 'Untitled Topic')}
                                                            ${top.lectureId ? '<span class="hls-chip">HLS</span>' : ''}
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 font-10 text-muted">
                                                            <span>${top.duration || '15 min'}</span>
                                                            ${isQuiz ? `<span>&bull; ${questionsCount} Questions</span>` : ''}
                                                            ${top.resources && top.resources.length ? `<span>&bull; <i class="fa-regular fa-file-pdf text-danger"></i> Handout</span>` : ''}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <button type="button" class="action-icon-btn" title="Move Up" onclick="moveTopic(${modIdx}, ${chIdx}, ${topIdx}, -1)">
                                                        <i class="fa-solid fa-arrow-up"></i>
                                                    </button>
                                                    <button type="button" class="action-icon-btn" title="Move Down" onclick="moveTopic(${modIdx}, ${chIdx}, ${topIdx}, 1)">
                                                        <i class="fa-solid fa-arrow-down"></i>
                                                    </button>
                                                    <button type="button" class="action-icon-btn" title="Edit Item" onclick="${isQuiz ? `openQuizModal(${modIdx}, ${chIdx}, ${topIdx})` : `openTopicModal(${modIdx}, ${chIdx}, ${topIdx})`}">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <button type="button" class="action-icon-btn danger" title="Delete Item" onclick="deleteTopic(${modIdx}, ${chIdx}, ${topIdx})">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        `;
                                    }).join('')}
                                </div>
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
    updateStats();
    syncHiddenInput();
}

function updateStats() {
    let mods = courseModules.length;
    let chapters = 0;
    let topics = 0;
    let quizzes = 0;

    courseModules.forEach(m => {
        (m.chapters || []).forEach(ch => {
            chapters++;
            (ch.topics || []).forEach(t => {
                if (t.isQuiz || t.type === 'quiz') quizzes++;
                else topics++;
            });
        });
    });

    const statM = document.getElementById('statModulesCount');
    const statC = document.getElementById('statChaptersCount');
    const statT = document.getElementById('statTopicsCount');
    const statQ = document.getElementById('statQuizzesCount');

    if (statM) statM.textContent = mods;
    if (statC) statC.textContent = chapters;
    if (statT) statT.textContent = topics;
    if (statQ) statQ.textContent = quizzes;

    // Auto-update lectures badge input if user hasn't explicitly customized it
    const lessonsInput = document.getElementById('lessonsBadgeInput');
    if (lessonsInput && (!lessonsInput.value || lessonsInput.value.includes('Lectures'))) {
        lessonsInput.value = `${topics} Lectures • ${quizzes} Quizzes`;
    }
}

function syncHiddenInput() {
    const input = document.getElementById('curriculumJsonInput');
    if (input) {
        input.value = JSON.stringify(courseModules);
    }
}

// =============================================================================
// MODULE ACTIONS
// =============================================================================

function openModuleModal(idx = -1) {
    document.getElementById('inputModuleIdx').value = idx;
    if (idx >= 0 && courseModules[idx]) {
        document.getElementById('modalModuleTitle').textContent = 'Edit Module / Subject';
        document.getElementById('inputModuleName').value = courseModules[idx].name || '';
        const savedIcon = courseModules[idx].icon === 'fa-solid fa-dna' ? 'fa-solid fa-microscope' : courseModules[idx].icon;
        document.getElementById('inputModuleIcon').value = savedIcon || 'fa-solid fa-microscope';
        document.getElementById('inputModuleDesc').value = courseModules[idx].description || '';
    } else {
        document.getElementById('modalModuleTitle').textContent = 'Add New Module / Subject';
        document.getElementById('inputModuleName').value = `Module ${courseModules.length + 1}: Subject Name`;
        document.getElementById('inputModuleIcon').value = 'fa-solid fa-microscope';
        document.getElementById('inputModuleDesc').value = '';
    }
    if (bsModalModule) bsModalModule.show();
}

function saveModule() {
    const idx = parseInt(document.getElementById('inputModuleIdx').value, 10);
    const name = document.getElementById('inputModuleName').value.trim();
    const icon = document.getElementById('inputModuleIcon').value;
    const desc = document.getElementById('inputModuleDesc').value.trim();

    if (!name) {
        alert('Please enter a module name');
        return;
    }

    if (idx >= 0 && courseModules[idx]) {
        courseModules[idx].name = name;
        courseModules[idx].icon = icon;
        courseModules[idx].description = desc;
    } else {
        courseModules.push({
            id: 'mod-' + Date.now(),
            name: name,
            icon: icon,
            description: desc,
            chapters: []
        });
    }

    if (bsModalModule) bsModalModule.hide();
    renderBuilder();
}

function deleteModule(idx) {
    if (confirm(`Delete "${courseModules[idx].name}" and all its chapters?`)) {
        courseModules.splice(idx, 1);
        renderBuilder();
    }
}

function moveModule(idx, delta) {
    const target = idx + delta;
    if (target < 0 || target >= courseModules.length) return;
    const temp = courseModules[idx];
    courseModules[idx] = courseModules[target];
    courseModules[target] = temp;
    renderBuilder();
}

// =============================================================================
// CHAPTER ACTIONS
// =============================================================================

function openChapterModal(modIdx, chIdx = -1) {
    document.getElementById('inputChapterModuleIdx').value = modIdx;
    document.getElementById('inputChapterIdx').value = chIdx;

    const mod = courseModules[modIdx];
    if (chIdx >= 0 && mod && mod.chapters[chIdx]) {
        document.getElementById('modalChapterTitle').textContent = `Edit Chapter (${mod.name})`;
        document.getElementById('inputChapterName').value = mod.chapters[chIdx].name || '';
        document.getElementById('inputChapterDesc').value = mod.chapters[chIdx].description || '';
    } else {
        document.getElementById('modalChapterTitle').textContent = `Add Chapter to ${mod.name}`;
        const nextNum = (mod.chapters ? mod.chapters.length : 0) + 1;
        document.getElementById('inputChapterName').value = `Chapter ${nextNum}: New Chapter Title`;
        document.getElementById('inputChapterDesc').value = '';
    }
    if (bsModalChapter) bsModalChapter.show();
}

function saveChapter() {
    const modIdx = parseInt(document.getElementById('inputChapterModuleIdx').value, 10);
    const chIdx = parseInt(document.getElementById('inputChapterIdx').value, 10);
    const name = document.getElementById('inputChapterName').value.trim();
    const desc = document.getElementById('inputChapterDesc').value.trim();

    if (!name) {
        alert('Please enter a chapter name');
        return;
    }

    const mod = courseModules[modIdx];
    if (!mod) return;
    if (!Array.isArray(mod.chapters)) mod.chapters = [];

    if (chIdx >= 0 && mod.chapters[chIdx]) {
        mod.chapters[chIdx].name = name;
        mod.chapters[chIdx].description = desc;
    } else {
        mod.chapters.push({
            id: 'ch-' + Date.now(),
            name: name,
            description: desc,
            topics: []
        });
    }

    if (bsModalChapter) bsModalChapter.hide();
    renderBuilder();
}

function deleteChapter(modIdx, chIdx) {
    if (confirm('Delete this chapter and all its topics/quizzes?')) {
        courseModules[modIdx].chapters.splice(chIdx, 1);
        renderBuilder();
    }
}

// =============================================================================
// TOPIC ACTIONS (Video Lecture or Reading Notes)
// =============================================================================

function toggleTopicTypeFields() {
    const type = document.getElementById('inputTopicType').value;
    const videoGroup = document.getElementById('videoUrlGroup');
    if (videoGroup) {
        videoGroup.style.display = (type === 'video') ? 'block' : 'none';
    }
}

function switchVideoMode(mode) {
    const btnUpload = document.getElementById('btnTabUploadVideo');
    const btnUrl = document.getElementById('btnTabUrlVideo');
    const boxUpload = document.getElementById('videoUploadBox');
    const boxUrl = document.getElementById('videoUrlBox');

    if (mode === 'upload') {
        btnUpload?.classList.add('active');
        btnUrl?.classList.remove('active');
        boxUpload?.classList.remove('d-none');
        boxUrl?.classList.add('d-none');
    } else {
        btnUrl?.classList.add('active');
        btnUpload?.classList.remove('active');
        boxUrl?.classList.remove('d-none');
        boxUpload?.classList.add('d-none');
    }
}

// Active XHR Upload Trackers
let currentVideoXhr = null;
let currentHandoutXhr = null;

function cancelVideoUpload() {
    if (currentVideoXhr) {
        try {
            currentVideoXhr.abort();
        } catch (e) {}
        currentVideoXhr = null;
    }
    resetVideoUploadUi();
    if (!currentLecture) {
        const saveBtn = document.getElementById('btnSaveTopic');
        if (saveBtn) saveBtn.disabled = false;
    }
}

function cancelHandoutUpload() {
    if (currentHandoutXhr) {
        try {
            currentHandoutXhr.abort();
        } catch (e) {}
        currentHandoutXhr = null;
    }
    const indicator = document.getElementById('handoutUploadIndicator');
    const handoutInput = document.getElementById('handoutFileInput');
    if (indicator) indicator.innerHTML = '';
    if (handoutInput) handoutInput.value = '';
}

function resetVideoUploadUi() {
    const progressWrap = document.getElementById('videoUploadProgressWrapper');
    const progressBar = document.getElementById('videoProgressBar');
    const progressPercent = document.getElementById('videoUploadPercent');
    const progressText = document.getElementById('videoUploadProgressText');
    const fileInput = document.getElementById('videoFileInput');

    if (progressWrap) progressWrap.classList.add('d-none');
    if (progressBar) progressBar.style.width = '0%';
    if (progressPercent) progressPercent.textContent = '0%';
    if (progressText) progressText.textContent = 'Uploading video to server...';
    if (fileInput) fileInput.value = '';
}

// =============================================================================
// SECURE HLS LECTURE PIPELINE (upload -> background transcode -> signed preview)
// =============================================================================
let currentLecture = null;
let lecturePollTimer = null;
let topicVideoJs = null;

function getTopicPlayer() {
    if (!window.videojs) return null;
    if (!topicVideoJs) {
        topicVideoJs = videojs('videoModalPlayer', {
            controls: true,
            autoplay: false,
            preload: 'auto',
            fluid: false,
            aspectRatio: '16:9',
            html5: { vhs: { overrideNative: true } }
        });
        topicVideoJs.qualityLevels();
    }
    return topicVideoJs;
}

function resolveMediaUrl(url) {
    url = (url || '').trim();
    if (!url) return '';
    if (/^(https?:)?\/\//i.test(url) || /^(blob:|data:)/i.test(url)) return url;
    return COURSE_STUDIO_BASE_URL.replace(/\/+$/, '') + '/' + url.replace(/^\/+/, '');
}

function setTopicVideoSource(src, mime) {
    const el = document.getElementById('videoModalPlayer');
    if (!window.videojs) {
        if (!el) return;
        if (!src) { el.pause(); el.removeAttribute('src'); el.load(); return; }
        el.src = src;
        el.load();
        return;
    }
    const player = getTopicPlayer();
    if (!player) return;
    if (!src) {
        try { player.pause(); player.reset(); } catch (e) {}
        return;
    }
    player.src({ src: src, type: mime || (/\.m3u8(\?|$)/i.test(src) ? 'application/x-mpegURL' : 'video/mp4') });
    const playPromise = player.play();
    if (playPromise && playPromise.catch) playPromise.catch(function () {});
}

function stopLecturePolling() {
    if (lecturePollTimer) {
        window.clearTimeout(lecturePollTimer);
        lecturePollTimer = null;
    }
}

function formatLectureBytes(bytes) {
    if (!bytes) return '';
    if (bytes >= 1073741824) return (bytes / 1073741824).toFixed(1) + ' GB';
    return (bytes / 1048576).toFixed(1) + ' MB';
}

function updateLecturePreviewMeta(lecture) {
    const nameEl = document.getElementById('videoPreviewName');
    const sizeEl = document.getElementById('videoPreviewSize');
    if (nameEl && lecture.title) nameEl.textContent = lecture.title;
    if (sizeEl) {
        const size = formatLectureBytes(lecture.size_bytes);
        const qualities = (lecture.qualities && lecture.qualities.length)
            ? ' · HLS ' + lecture.qualities.join('/')
            : (lecture.ready && lecture.hls === false ? ' · Direct stream' : '');
        if (size || qualities) sizeEl.textContent = (size || 'Ready') + qualities;
    }
}

async function loadLecturePreview(lectureId) {
    try {
        const res = await fetch(`${COURSE_STUDIO_BASE_URL.replace(/\/+$/, '')}/admin/lectures/${lectureId}/preview-url`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        if (!res.ok || !data.ready) {
            showProcessingError(data.message || 'Lecture is still being processed.');
            return;
        }
        const previewWrap = document.getElementById('videoPreviewWrapper');
        if (previewWrap) previewWrap.classList.remove('d-none');
        setTopicVideoSource(data.url, data.type || 'application/x-mpegURL');
    } catch (e) {
        showProcessingError('Could not load the secure preview. Please try again.');
    }
}

function showProcessingError(message) {
    const errEl = document.getElementById('videoProcessingError');
    if (!errEl) return;
    errEl.textContent = message;
    errEl.classList.remove('d-none');
}

function applyLectureState(lecture, fromPoll = false) {
    if (!fromPoll) stopLecturePolling();
    currentLecture = lecture || null;

    const hidden = document.getElementById('inputTopicLectureId');
    const uploadWrap = document.getElementById('videoUploadProgressWrapper');
    const processingWrap = document.getElementById('videoProcessingWrapper');
    const previewWrap = document.getElementById('videoPreviewWrapper');
    const saveBtn = document.getElementById('btnSaveTopic');
    const errEl = document.getElementById('videoProcessingError');
    const retryBtn = document.getElementById('btnRetryLectureProcessing');
    const procText = document.getElementById('videoProcessingText');
    const procPercent = document.getElementById('videoProcessingPercent');
    const procBar = document.getElementById('videoProcessingBar');

    if (uploadWrap) uploadWrap.classList.add('d-none');

    if (!lecture) {
        if (hidden) hidden.value = '';
        if (processingWrap) processingWrap.classList.add('d-none');
        if (previewWrap) previewWrap.classList.add('d-none');
        if (errEl) errEl.classList.add('d-none');
        if (retryBtn) retryBtn.classList.add('d-none');
        if (saveBtn) saveBtn.disabled = false;
        stopLecturePolling();
        return;
    }

    if (hidden) hidden.value = lecture.id;
    updateLecturePreviewMeta(lecture);

    if (lecture.status === 'ready') {
        if (processingWrap) processingWrap.classList.add('d-none');
        if (retryBtn) retryBtn.classList.add('d-none');
        if (saveBtn) saveBtn.disabled = false;
        loadLecturePreview(lecture.id);
        stopLecturePolling();
        return;
    }

    if (previewWrap) previewWrap.classList.add('d-none');
    if (processingWrap) processingWrap.classList.remove('d-none');

    const pct = Math.max(0, Math.min(100, lecture.progress || 0));
    if (procPercent) procPercent.textContent = pct + '%';
    if (procBar) procBar.style.width = pct + '%';
    if (procText) {
        procText.textContent = lecture.status === 'failed'
            ? 'Processing failed'
            : (lecture.status === 'queued' ? 'Queued for background processing…' : 'Transcoding to adaptive HLS…');
    }
    if (errEl) {
        if (lecture.error) {
            errEl.textContent = lecture.error;
            errEl.classList.remove('d-none');
        } else {
            errEl.classList.add('d-none');
        }
    }

    if (lecture.status === 'failed') {
        if (retryBtn) retryBtn.classList.remove('d-none');
        if (saveBtn) saveBtn.disabled = true;
        stopLecturePolling();
        return;
    }

    // queued / processing
    if (retryBtn) retryBtn.classList.add('d-none');
    if (saveBtn) saveBtn.disabled = true;
    if (!fromPoll) startLecturePolling(lecture.id);
}

function startLecturePolling(lectureId) {
    stopLecturePolling();
    const id = String(lectureId);
    const tick = async function () {
        lecturePollTimer = null;
        let lecture = null;
        try {
            const res = await fetch(`${COURSE_STUDIO_BASE_URL.replace(/\/+$/, '')}/admin/lectures/${id}/status`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (res.ok) lecture = await res.json();
        } catch (e) { /* keep polling */ }

        if (!currentLecture || String(currentLecture.id) !== id) return;
        if (lecture) applyLectureState(lecture, true);

        if (!lecture || (currentLecture && currentLecture.status !== 'ready' && currentLecture.status !== 'failed')) {
            lecturePollTimer = window.setTimeout(tick, 3000);
        }
    };
    lecturePollTimer = window.setTimeout(tick, 3000);
}

async function loadLectureById(lectureId) {
    try {
        const res = await fetch(`${COURSE_STUDIO_BASE_URL.replace(/\/+$/, '')}/admin/lectures/${lectureId}/status`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) {
            applyLectureState({ id: lectureId, status: 'failed', progress: 0, error: 'This lecture could not be found. It may have been deleted.' });
            return;
        }
        applyLectureState(await res.json());
    } catch (e) {
        applyLectureState({ id: lectureId, status: 'failed', progress: 0, error: 'Could not load lecture status. Check your connection and retry.' });
    }
}

async function retryLectureProcessing() {
    if (!currentLecture || !currentLecture.id) return;
    const retryBtn = document.getElementById('btnRetryLectureProcessing');
    if (retryBtn) retryBtn.disabled = true;
    try {
        const res = await fetch(`${COURSE_STUDIO_BASE_URL.replace(/\/+$/, '')}/admin/lectures/${currentLecture.id}/retry`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await res.json();
        if (!res.ok) {
            showProcessingError(data.message || 'Could not retry processing.');
            return;
        }
        applyLectureState(data.lecture || { id: currentLecture.id, status: 'queued', progress: 0 });
    } catch (e) {
        showProcessingError('Network error while retrying processing.');
    } finally {
        if (retryBtn) retryBtn.disabled = false;
    }
}

function clearUploadedVideo() {
    cancelVideoUpload();
    stopLecturePolling();
    currentLecture = null;

    const lectureInput = document.getElementById('inputTopicLectureId');
    const urlInput = document.getElementById('inputTopicVideoUrl');
    const previewWrap = document.getElementById('videoPreviewWrapper');
    const fileInput = document.getElementById('videoFileInput');
    const processingWrap = document.getElementById('videoProcessingWrapper');
    const errEl = document.getElementById('videoProcessingError');
    const retryBtn = document.getElementById('btnRetryLectureProcessing');
    const saveBtn = document.getElementById('btnSaveTopic');

    if (lectureInput) lectureInput.value = '';
    if (urlInput) urlInput.value = '';
    if (previewWrap) previewWrap.classList.add('d-none');
    if (processingWrap) processingWrap.classList.add('d-none');
    if (errEl) errEl.classList.add('d-none');
    if (retryBtn) retryBtn.classList.add('d-none');
    if (saveBtn) saveBtn.disabled = false;
    if (fileInput) fileInput.value = '';
    setTopicVideoSource('');
}

function onVideoUrlManualInput(val) {
    val = (val || '').trim();
    const nameEl = document.getElementById('videoPreviewName');
    const sizeEl = document.getElementById('videoPreviewSize');

    if (val) {
        // Manual external URL replaces any uploaded lecture binding.
        const lectureInput = document.getElementById('inputTopicLectureId');
        if (lectureInput) lectureInput.value = '';
        stopLecturePolling();
        currentLecture = null;
        const processingWrap = document.getElementById('videoProcessingWrapper');
        if (processingWrap) processingWrap.classList.add('d-none');
    }

    if (val && !val.includes('youtube.com') && !val.includes('youtu.be') && !val.includes('vimeo.com')) {
        setTopicVideoSource(resolveMediaUrl(val));
        if (nameEl) nameEl.textContent = val.split('/').pop() || 'External Video';
        if (sizeEl) sizeEl.textContent = 'Stream Link';
        const previewWrap = document.getElementById('videoPreviewWrapper');
        if (previewWrap) previewWrap.classList.remove('d-none');
    }
}

function uploadVideoFile(file) {
    if (!file) return;

    // 1. Immediately abort any prior or lingering upload so there is ZERO overlap!
    cancelVideoUpload();
    stopLecturePolling();
    currentLecture = null;

    // 2. Validate type & size against the server upload limit.
    const ext = (file.name.split('.').pop() || '').toLowerCase();
    if (!['mp4', 'mov', 'm4v', 'webm', 'mkv', 'avi', 'qt'].includes(ext)) {
        alert('Unsupported video format. Please upload MP4, MOV, M4V, WebM, MKV or AVI.');
        resetVideoUploadUi();
        return;
    }
    const maxBytes = (COURSE_STUDIO_UPLOAD_MAX_MB || 40) * 1024 * 1024;
    if (file.size > maxBytes) {
        alert(`File size exceeds the server upload limit of ${COURSE_STUDIO_UPLOAD_MAX_MB} MB. Increase upload_max_filesize / post_max_size in php.ini.`);
        resetVideoUploadUi();
        return;
    }

    const progressWrap = document.getElementById('videoUploadProgressWrapper');
    const progressBar = document.getElementById('videoProgressBar');
    const progressPercent = document.getElementById('videoUploadPercent');
    const progressText = document.getElementById('videoUploadProgressText');
    const processingWrap = document.getElementById('videoProcessingWrapper');
    const previewWrap = document.getElementById('videoPreviewWrapper');
    const urlInput = document.getElementById('inputTopicVideoUrl');
    const saveBtn = document.getElementById('btnSaveTopic');

    if (urlInput) urlInput.value = '';
    if (progressWrap) progressWrap.classList.remove('d-none');
    if (processingWrap) processingWrap.classList.add('d-none');
    if (previewWrap) previewWrap.classList.add('d-none');
    if (progressBar) progressBar.style.width = '0%';
    if (progressPercent) progressPercent.textContent = '0%';
    if (progressText) progressText.textContent = `Preparing: ${file.name}...`;
    if (saveBtn) saveBtn.disabled = true;

    const formData = new FormData();
    formData.append('video', file);
    formData.append('title', document.getElementById('inputTopicName').value.trim());
    if (COURSE_STUDIO_ID) formData.append('course_id', COURSE_STUDIO_ID);
    const currentTopicId = document.getElementById('inputTopicModuleIdx').value !== '-1'
        ? (document.getElementById('inputTopicModuleIdx').value + '-' + document.getElementById('inputTopicChapterIdx').value + '-' + document.getElementById('inputTopicIdx').value)
        : '';
    if (currentTopicId) formData.append('topic_id', currentTopicId);

    const xhr = new XMLHttpRequest();
    currentVideoXhr = xhr;

    xhr.open('POST', '{{ route("admin.lectures.store") }}', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

    xhr.upload.onprogress = function (e) {
        if (currentVideoXhr !== xhr) return;
        if (e.lengthComputable) {
            const pct = Math.round((e.loaded / e.total) * 100);
            const loadedMb = (e.loaded / (1024 * 1024)).toFixed(1);
            const totalMb = (e.total / (1024 * 1024)).toFixed(1);
            if (progressBar) progressBar.style.width = pct + '%';
            if (progressPercent) progressPercent.textContent = pct + '%';
            if (progressText) progressText.textContent = `Uploading: ${loadedMb} MB / ${totalMb} MB (${pct}%)...`;
        }
    };

    xhr.onload = function () {
        if (currentVideoXhr !== xhr) return;
        currentVideoXhr = null;
        if (progressWrap) progressWrap.classList.add('d-none');
        if (progressBar) progressBar.style.width = '0%';

        let res = {};
        try { res = JSON.parse(xhr.responseText); } catch (e) {}

        if (xhr.status >= 200 && xhr.status < 300 && res.lecture) {
            const fileInput = document.getElementById('videoFileInput');
            if (fileInput) fileInput.value = '';
            applyLectureState(res.lecture);
        } else {
            const message = res.message || (res.errors && Object.values(res.errors).flat()[0]) || ('Upload failed (status ' + xhr.status + ').');
            alert(message);
            resetVideoUploadUi();
            if (saveBtn) saveBtn.disabled = false;
        }
    };

    xhr.onabort = function () {
        resetVideoUploadUi();
    };

    xhr.onerror = function () {
        if (currentVideoXhr !== xhr) return;
        currentVideoXhr = null;
        if (saveBtn) saveBtn.disabled = false;
        if (progressWrap) progressWrap.classList.add('d-none');
        alert('Network error occurred during video upload.');
        resetVideoUploadUi();
    };

    xhr.send(formData);
}

function uploadHandoutPdf(file) {
    if (!file) return;

    cancelHandoutUpload();

    const indicator = document.getElementById('handoutUploadIndicator');
    if (indicator) {
        indicator.innerHTML = `<span class="text-primary"><i class="fa-solid fa-spinner fa-spin me-1"></i> Uploading ${file.name}...</span>`;
    }

    const formData = new FormData();
    formData.append('resource', file);
    formData.append('_token', '{{ csrf_token() }}');

    const xhr = new XMLHttpRequest();
    currentHandoutXhr = xhr;

    xhr.open('POST', '{{ route("admin.courses.uploadResource") }}', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function () {
        if (currentHandoutXhr !== xhr) return;
        currentHandoutXhr = null;

        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.success) {
                    const titleInput = document.getElementById('inputTopicHandout');
                    const urlInput = document.getElementById('inputTopicHandoutUrl');

                    if (urlInput) urlInput.value = res.relative_url || res.url;
                    if (titleInput && (!titleInput.value || titleInput.value.includes('Handout.pdf'))) {
                        titleInput.value = res.filename;
                    }

                    if (indicator) {
                        indicator.innerHTML = `<span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Uploaded: ${res.filename} (${res.size})</span>`;
                    }
                    const hFileInput = document.getElementById('handoutFileInput');
                    if (hFileInput) hFileInput.value = '';
                } else {
                    if (indicator) indicator.innerHTML = `<span class="text-danger">Upload failed: ${res.message || 'Error'}</span>`;
                }
            } catch (err) {
                if (indicator) indicator.innerHTML = `<span class="text-danger">Invalid server response</span>`;
            }
        } else {
            if (indicator) indicator.innerHTML = `<span class="text-danger">Upload failed (${xhr.status})</span>`;
        }
    };

    xhr.onabort = function () {
        if (indicator) indicator.innerHTML = '';
    };

    xhr.onerror = function () {
        if (currentHandoutXhr !== xhr) return;
        currentHandoutXhr = null;
        if (indicator) indicator.innerHTML = `<span class="text-danger">Network error</span>`;
    };

    xhr.send(formData);
}

function openTopicModal(modIdx, chIdx, topIdx = -1, defaultType = 'video') {
    // Abort and reset any lingering uploads before opening any topic
    cancelVideoUpload();
    cancelHandoutUpload();
    stopLecturePolling();
    applyLectureState(null);

    document.getElementById('inputTopicModuleIdx').value = modIdx;
    document.getElementById('inputTopicChapterIdx').value = chIdx;
    document.getElementById('inputTopicIdx').value = topIdx;

    const ch = courseModules[modIdx]?.chapters[chIdx];
    let videoUrl = '';
    let lectureId = '';

    if (topIdx >= 0 && ch && ch.topics[topIdx]) {
        const top = ch.topics[topIdx];
        document.getElementById('modalTopicTitle').textContent = 'Edit Topic';
        document.getElementById('inputTopicType').value = top.type || 'video';
        document.getElementById('inputTopicName').value = top.title || '';
        document.getElementById('inputTopicDuration').value = top.duration || '35 min';
        videoUrl = top.videoUrl || '';
        lectureId = top.lectureId || '';
        document.getElementById('inputTopicVideoUrl').value = videoUrl;
        document.getElementById('inputTopicNotes').value = top.readContent || '';

        const res = (top.resources && top.resources[0]) || {};
        document.getElementById('inputTopicHandout').value = res.name || '';
        document.getElementById('inputTopicHandoutUrl').value = res.url || '';
    } else {
        document.getElementById('modalTopicTitle').textContent = defaultType === 'video' ? 'Add Video Lecture' : 'Add Reading Topic';
        document.getElementById('inputTopicType').value = defaultType;
        document.getElementById('inputTopicName').value = defaultType === 'video' ? '1.1 Video Lecture Title' : '1.2 High-Yield Notes';
        document.getElementById('inputTopicDuration').value = defaultType === 'video' ? '35 min' : '15 min';
        document.getElementById('inputTopicVideoUrl').value = '';
        document.getElementById('inputTopicNotes').value = '';
        document.getElementById('inputTopicHandout').value = '';
        document.getElementById('inputTopicHandoutUrl').value = '';
    }

    // Configure secure lecture preview & mode
    const progressWrap = document.getElementById('videoUploadProgressWrapper');
    const indicator = document.getElementById('handoutUploadIndicator');
    if (progressWrap) progressWrap.classList.add('d-none');
    if (indicator) indicator.innerHTML = '';

    if (lectureId) {
        switchVideoMode('upload');
        document.getElementById('inputTopicVideoUrl').value = '';
        loadLectureById(lectureId);
    } else if (videoUrl) {
        if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be') || videoUrl.includes('vimeo.com')) {
            switchVideoMode('url');
        } else {
            switchVideoMode('upload');
            setTopicVideoSource(resolveMediaUrl(videoUrl));
            const nameEl = document.getElementById('videoPreviewName');
            const sizeEl = document.getElementById('videoPreviewSize');
            if (nameEl) nameEl.textContent = videoUrl.split('/').pop() || 'Video Lecture';
            if (sizeEl) sizeEl.textContent = 'Legacy video';
            const previewWrap = document.getElementById('videoPreviewWrapper');
            if (previewWrap) previewWrap.classList.remove('d-none');
        }
    } else {
        switchVideoMode('upload');
        clearUploadedVideo();
    }

    toggleTopicTypeFields();
    if (bsModalTopic) bsModalTopic.show();
}

function saveTopic() {
    if (currentVideoXhr) {
        alert('A video lecture is currently uploading. Please wait for it to finish or click "Cancel Upload" before saving.');
        return;
    }

    const modIdx = parseInt(document.getElementById('inputTopicModuleIdx').value, 10);
    const chIdx = parseInt(document.getElementById('inputTopicChapterIdx').value, 10);
    const topIdx = parseInt(document.getElementById('inputTopicIdx').value, 10);

    const type = document.getElementById('inputTopicType').value;
    const title = document.getElementById('inputTopicName').value.trim();
    const duration = document.getElementById('inputTopicDuration').value.trim();
    const videoUrl = document.getElementById('inputTopicVideoUrl').value.trim();
    const lectureId = document.getElementById('inputTopicLectureId').value.trim();
    const notes = document.getElementById('inputTopicNotes').value.trim();
    const handout = document.getElementById('inputTopicHandout').value.trim();
    const handoutUrl = document.getElementById('inputTopicHandoutUrl').value.trim();

    if (!title) {
        alert('Please enter a topic title');
        return;
    }

    if (type === 'video') {
        if (!lectureId && !videoUrl) {
            alert('Please upload a lecture video or provide an external stream URL.');
            return;
        }
        if (lectureId && (!currentLecture || String(currentLecture.id) !== String(lectureId) || currentLecture.status !== 'ready')) {
            alert('This lecture is still being processed. Wait until it is ready before saving the topic.');
            return;
        }
    }

    const ch = courseModules[modIdx]?.chapters[chIdx];
    if (!ch) return;
    if (!Array.isArray(ch.topics)) ch.topics = [];

    const resources = handout ? [{ name: handout, url: handoutUrl, type: 'pdf' }] : [];

    const topicData = {
        id: (topIdx >= 0 && ch.topics[topIdx]?.id) ? ch.topics[topIdx].id : ('top-' + Date.now()),
        title: title,
        type: type,
        isQuiz: false,
        duration: duration || (type === 'video' ? '35 min' : '15 min'),
        videoUrl: lectureId ? '' : videoUrl,
        lectureId: lectureId || null,
        lectureTitle: lectureId ? title : null,
        readContent: notes,
        resources: resources
    };

    if (topIdx >= 0 && ch.topics[topIdx]) {
        ch.topics[topIdx] = topicData;
    } else {
        ch.topics.push(topicData);
    }

    stopLecturePolling();
    if (bsModalTopic) bsModalTopic.hide();
    renderBuilder();
}

function deleteTopic(modIdx, chIdx, topIdx) {
    if (confirm('Delete this item?')) {
        courseModules[modIdx].chapters[chIdx].topics.splice(topIdx, 1);
        renderBuilder();
    }
}

function moveTopic(modIdx, chIdx, topIdx, delta) {
    const topics = courseModules[modIdx]?.chapters[chIdx]?.topics;
    if (!topics) return;
    const target = topIdx + delta;
    if (target < 0 || target >= topics.length) return;
    const temp = topics[topIdx];
    topics[topIdx] = topics[target];
    topics[target] = temp;
    renderBuilder();
}

// =============================================================================
// QUIZ ACTIONS (Topic Quiz or Chapter Quiz)
// =============================================================================

function openQuizModal(modIdx, chIdx, topIdx = -1, defaultQuizType = 'topic') {
    document.getElementById('inputQuizModuleIdx').value = modIdx;
    document.getElementById('inputQuizChapterIdx').value = chIdx;
    document.getElementById('inputQuizIdx').value = topIdx;

    const ch = courseModules[modIdx]?.chapters[chIdx];
    if (topIdx >= 0 && ch && ch.topics[topIdx]) {
        const item = ch.topics[topIdx];
        const qData = item.quizData || {};
        document.getElementById('modalQuizTitle').textContent = 'Edit Quiz Assessment';
        document.getElementById('inputQuizType').value = item.quizType || defaultQuizType;
        document.getElementById('inputQuizName').value = item.title || '';
        document.getElementById('inputQuizDuration').value = item.duration || '5 min';
        document.getElementById('inputQuizPass').value = qData.passingScore || 80;

        currentQuizWorkingQuestions = Array.isArray(qData.questions) ? JSON.parse(JSON.stringify(qData.questions)) : [];
    } else {
        document.getElementById('modalQuizTitle').textContent = defaultQuizType === 'chapter' ? 'Add Chapter Assessment Exam' : 'Add Topic Quick Quiz';
        document.getElementById('inputQuizType').value = defaultQuizType;
        document.getElementById('inputQuizName').value = defaultQuizType === 'chapter' ? 'Chapter Mastery Assessment Exam' : 'Topic Quick Quiz Checkpoint';
        document.getElementById('inputQuizDuration').value = defaultQuizType === 'chapter' ? '15 min' : '5 min';
        document.getElementById('inputQuizPass').value = defaultQuizType === 'chapter' ? 75 : 80;

        // Default 1 starter question
        currentQuizWorkingQuestions = [
            {
                question: "Sample Question: What is the primary function of the plasma membrane?",
                options: [
                    "Selective permeability and homeostasis",
                    "Protein synthesis and translation",
                    "ATP production via glycolysis",
                    "DNA replication and repair"
                ],
                correctIndex: 0,
                explanation: "The plasma membrane provides selective permeability to maintain intracellular homeostasis."
            }
        ];
    }

    renderQuizQuestions();
    if (bsModalQuiz) bsModalQuiz.show();
}

function renderQuizQuestions() {
    const container = document.getElementById('quizQuestionsContainer');
    if (!container) return;

    if (!currentQuizWorkingQuestions || currentQuizWorkingQuestions.length === 0) {
        container.innerHTML = `<div class="text-center py-3 text-muted font-11">No MCQs added. Click "+ Add Question" above.</div>`;
        return;
    }

    container.innerHTML = currentQuizWorkingQuestions.map((q, qIdx) => `
        <div class="mcq-question-block" data-q-idx="${qIdx}">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-bold text-dark font-12">Question ${qIdx + 1}</span>
                <button type="button" class="btn btn-sm btn-link text-danger p-0 font-11" onclick="removeMcqQuestion(${qIdx})">
                    <i class="fa-solid fa-trash me-1"></i> Remove
                </button>
            </div>
            <div class="mb-2">
                <textarea class="form-control font-12" rows="2" placeholder="Question statement..." onchange="updateMcqStatement(${qIdx}, this.value)">${escapeHtml(q.question || '')}</textarea>
            </div>
            <div class="row g-2 mb-2">
                ${[0, 1, 2, 3].map(optIdx => `
                    <div class="col-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white">
                                <input class="form-check-input mt-0" type="radio" name="correctRadio_${qIdx}" value="${optIdx}" ${q.correctIndex === optIdx ? 'checked' : ''} onchange="updateMcqCorrect(${qIdx}, ${optIdx})">
                            </span>
                            <input type="text" class="form-control font-11" placeholder="Option ${String.fromCharCode(65 + optIdx)}" value="${escapeHtml((q.options && q.options[optIdx]) || '')}" onchange="updateMcqOption(${qIdx}, ${optIdx}, this.value)">
                        </div>
                    </div>
                `).join('')}
            </div>
            <div>
                <input type="text" class="form-control form-control-sm font-11 text-muted" placeholder="Explanation for correct answer (optional)..." value="${escapeHtml(q.explanation || '')}" onchange="updateMcqExplanation(${qIdx}, this.value)">
            </div>
        </div>
    `).join('');
}

function addMcqQuestionField() {
    currentQuizWorkingQuestions.push({
        question: "",
        options: ["", "", "", ""],
        correctIndex: 0,
        explanation: ""
    });
    renderQuizQuestions();
    const container = document.getElementById('quizQuestionsContainer');
    if (container) container.scrollTop = container.scrollHeight;
}

function removeMcqQuestion(qIdx) {
    currentQuizWorkingQuestions.splice(qIdx, 1);
    renderQuizQuestions();
}

function updateMcqStatement(qIdx, val) {
    if (currentQuizWorkingQuestions[qIdx]) currentQuizWorkingQuestions[qIdx].question = val;
}

function updateMcqOption(qIdx, optIdx, val) {
    if (currentQuizWorkingQuestions[qIdx]) {
        if (!currentQuizWorkingQuestions[qIdx].options) currentQuizWorkingQuestions[qIdx].options = [];
        currentQuizWorkingQuestions[qIdx].options[optIdx] = val;
    }
}

function updateMcqCorrect(qIdx, optIdx) {
    if (currentQuizWorkingQuestions[qIdx]) currentQuizWorkingQuestions[qIdx].correctIndex = optIdx;
}

function updateMcqExplanation(qIdx, val) {
    if (currentQuizWorkingQuestions[qIdx]) currentQuizWorkingQuestions[qIdx].explanation = val;
}

function saveQuiz() {
    const modIdx = parseInt(document.getElementById('inputQuizModuleIdx').value, 10);
    const chIdx = parseInt(document.getElementById('inputQuizChapterIdx').value, 10);
    const topIdx = parseInt(document.getElementById('inputQuizIdx').value, 10);

    const quizType = document.getElementById('inputQuizType').value;
    const title = document.getElementById('inputQuizName').value.trim();
    const duration = document.getElementById('inputQuizDuration').value.trim();
    const passScore = parseInt(document.getElementById('inputQuizPass').value, 10) || 80;

    if (!title) {
        alert('Please enter a quiz title');
        return;
    }

    const ch = courseModules[modIdx]?.chapters[chIdx];
    if (!ch) return;
    if (!Array.isArray(ch.topics)) ch.topics = [];

    const durationNum = parseInt(duration, 10) || (quizType === 'chapter' ? 10 : 5);

    const quizItem = {
        id: (topIdx >= 0 && ch.topics[topIdx]?.id) ? ch.topics[topIdx].id : ('quiz-' + Date.now()),
        title: title,
        type: 'quiz',
        isQuiz: true,
        quizType: quizType,
        duration: duration || `${durationNum} min`,
        quizData: {
            title: title,
            subtitle: `${quizType === 'chapter' ? 'Comprehensive Chapter Exam' : 'Quick Topic Checkpoint'} • ${currentQuizWorkingQuestions.length} Questions`,
            passingScore: passScore,
            timeLimitMinutes: durationNum,
            questions: currentQuizWorkingQuestions
        }
    };

    if (topIdx >= 0 && ch.topics[topIdx]) {
        ch.topics[topIdx] = quizItem;
    } else {
        ch.topics.push(quizItem);
    }

    if (bsModalQuiz) bsModalQuiz.hide();
    renderBuilder();
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
</script>
@endsection
