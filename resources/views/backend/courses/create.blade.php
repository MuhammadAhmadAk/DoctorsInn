@extends('backend.layouts.master')

@section('title', isset($course) ? 'Edit Course: ' . $course->title : 'Add New Course')

@section('extra_css')
<style>
    /* Course Studio & 3-Tier Builder Refined Styling */
    .builder-module-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-bottom: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease;
    }
    .builder-module-card:hover {
        border-color: #cbd5e1;
    }
    .builder-module-header {
        padding: 10px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        border-top-left-radius: 9px;
        border-top-right-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .builder-module-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #5C32FF;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }
    .builder-chapter-card {
        background: #fcfcfd;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 10px;
        overflow: hidden;
    }
    .builder-chapter-header {
        padding: 8px 12px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        border-bottom: 1px solid #e5e7eb;
    }
    .builder-topic-row {
        padding: 8px 12px;
        border-bottom: 1px solid #f1f5f9;
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
        background: #f8fafc;
    }
    .type-badge-video {
        background: #eff6ff;
        color: #2563eb;
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 4px;
        border: 1px solid #bfdbfe;
    }
    .type-badge-reading {
        background: #ecfdf5;
        color: #059669;
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 4px;
        border: 1px solid #a7f3d0;
    }
    .type-badge-topic-quiz {
        background: #fffbeb;
        color: #d97706;
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 4px;
        border: 1px solid #fde68a;
    }
    .type-badge-chapter-quiz {
        background: #f5f3ff;
        color: #7c3aed;
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 4px;
        border: 1px solid #ddd6fe;
    }
    .action-icon-btn {
        width: 26px;
        height: 26px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        font-size: 11px;
        color: #64748b;
        background: transparent;
        border: 1px solid transparent;
        transition: all 0.15s ease;
    }
    .action-icon-btn:hover {
        color: #0f172a;
        background: #e2e8f0;
    }
    .action-icon-btn.danger:hover {
        color: #ef4444;
        background: #fee2e2;
    }
    .mcq-question-block {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
    }
</style>
@endsection

@section('content')
<form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" id="courseForm">
    @csrf
    @if(isset($course))
        <input type="hidden" name="slug" value="{{ $course->slug }}">
    @endif
    <input type="hidden" name="curriculum_json" id="curriculumJsonInput" value="">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 font-11">
                    <li class="breadcrumb-item"><a href="{{ route('admin.courses') }}" class="text-decoration-none text-muted">Courses</a></li>
                    <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">
                        {{ isset($course) ? 'Edit Course & Curriculum' : 'New Course Studio' }}
                    </li>
                </ol>
            </nav>
            <h1 class="page-title mb-0">
                <i class="fa-solid fa-graduation-cap text-primary me-2"></i>
                {{ isset($course) ? 'Edit: ' . $course->title : 'Course Studio & Curriculum Builder' }}
            </h1>
        </div>
        <div class="d-flex align-items-center gap-2">
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
                <span>{{ isset($course) ? 'Save & Update Course' : 'Create Course' }}</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #EF4444; font-size: 12.5px;">
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
                               value="{{ old('title', $course->title ?? 'MDCAT 2026: Complete All-Subject Medical Prep Batch') }}" required>
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
                                   value="{{ old('instructor', $course->instructor ?? 'DoctorsInn Medical Faculty Panel') }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Success Highlight Badge</label>
                            <input type="text" name="success_badge" class="form-control font-12" 
                                   placeholder="e.g. 300+ Qualifiers in Top Medical Colleges" 
                                   value="{{ old('success_badge', $course->success_badge ?? '300+ Qualifiers in Top Medical Colleges') }}">
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
                        <textarea name="overview" class="form-control font-12" rows="3" placeholder="Course overview, syllabus breakdown, and live mentorship features...">{{ old('overview', $course->overview ?? 'This comprehensive MDCAT program provides end-to-end preparation for all 5 core subjects: Biology, Chemistry, Physics, English, and Logical Reasoning. Built specifically around the updated PMDC syllabus, each subject is taught from foundational fundamentals to advanced exam-trap MCQs, supplemented by weekly unit tests and full-length simulated mock exams.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 2. 3-Tier Dynamic Course Curriculum Studio (Matching Student Portal) -->
            <div class="adm-card mb-3">
                <div class="adm-card-header pb-2.5">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h2 class="adm-card-title mb-0">2. 3-Tier Course Curriculum Builder</h2>
                            <span class="badge bg-primary text-white font-11 px-2 py-0.5 rounded-pill">Student Portal Synced</span>
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
                <div class="px-3 py-2 bg-light border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2 font-12 text-muted">
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

                <div class="adm-card-body p-3">
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
                            <div class="border rounded-2 p-3 bg-white h-100">
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
                            <div class="border rounded-2 p-3 bg-white h-100">
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
                            <div class="border rounded-2 p-3 bg-white h-100">
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
                                   value="{{ old('duration', $course->duration ?? '90 Days') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Seat Limit</label>
                            <input type="number" name="seats" class="form-control font-12" value="350">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Language of Instruction</label>
                        <input type="text" name="language" class="form-control font-12" 
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
                                   value="{{ old('price', $course->price ?? '3,500') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Compare-at Price (Original)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted font-12">Rs.</span>
                            <input type="text" name="original_price" class="form-control font-12 text-muted" 
                                   value="{{ old('original_price', $course->original_price ?? '6,000') }}">
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
                    <div class="border rounded-2 p-1.5 bg-light mb-2">
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
<div class="modal fade" id="modalModule" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 10px;">
            <div class="modal-header py-2.5 px-3 border-bottom bg-light">
                <h5 class="modal-title font-13 fw-bold text-dark" id="modalModuleTitle">Configure Module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;"></button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" id="inputModuleIdx" value="-1">
                <div class="mb-3">
                    <label class="form-label font-12">Module / Subject Name <span class="text-danger">*</span></label>
                    <input type="text" id="inputModuleName" class="form-control font-12" placeholder="e.g. Module 1: Biology" required>
                </div>
                <div class="mb-3">
                    <label class="form-label font-12">Module Icon</label>
                    <select id="inputModuleIcon" class="form-select font-12">
                        <option value="fa-solid fa-dna">🧬 DNA / Biology (fa-solid fa-dna)</option>
                        <option value="fa-solid fa-flask-vial">🧪 Flask / Chemistry (fa-solid fa-flask-vial)</option>
                        <option value="fa-solid fa-bolt">⚡ Bolt / Physics (fa-solid fa-bolt)</option>
                        <option value="fa-solid fa-brain">🧠 Brain / Logic & Reasoning (fa-solid fa-brain)</option>
                        <option value="fa-solid fa-book-open">📖 Book / English & Grammar (fa-solid fa-book-open)</option>
                        <option value="fa-solid fa-stethoscope">🩺 Stethoscope / Clinical (fa-solid fa-stethoscope)</option>
                        <option value="fa-solid fa-layer-group">📂 Layer Group / General (fa-solid fa-layer-group)</option>
                    </select>
                </div>
                <div class="mb-0">
                    <label class="form-label font-12">Description / Syllabus Scope</label>
                    <textarea id="inputModuleDesc" class="form-control font-11" rows="2" placeholder="Brief subject description, e.g. Core PMDC syllabus topics"></textarea>
                </div>
            </div>
            <div class="modal-footer py-2 px-3 bg-light border-top">
                <button type="button" class="btn-adm btn-adm-outline py-1 px-3 font-11" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-adm btn-adm-primary py-1 px-3 font-11" id="btnSaveModule">Save Module</button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Chapter Modal -->
<div class="modal fade" id="modalChapter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 10px;">
            <div class="modal-header py-2.5 px-3 border-bottom bg-light">
                <h5 class="modal-title font-13 fw-bold text-dark" id="modalChapterTitle">Configure Chapter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;"></button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" id="inputChapterModuleIdx" value="-1">
                <input type="hidden" id="inputChapterIdx" value="-1">
                <div class="mb-3">
                    <label class="form-label font-12">Chapter Title <span class="text-danger">*</span></label>
                    <input type="text" id="inputChapterName" class="form-control font-12" placeholder="e.g. Chapter 1: Cell Biology & Cytology" required>
                </div>
                <div class="mb-0">
                    <label class="form-label font-12">Chapter Summary / Description</label>
                    <textarea id="inputChapterDesc" class="form-control font-11" rows="2" placeholder="Brief chapter overview and key learning targets..."></textarea>
                </div>
            </div>
            <div class="modal-footer py-2 px-3 bg-light border-top">
                <button type="button" class="btn-adm btn-adm-outline py-1 px-3 font-11" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-adm btn-adm-primary py-1 px-3 font-11" id="btnSaveChapter">Save Chapter</button>
            </div>
        </div>
    </div>
</div>

<!-- 3. Topic Modal (Video Lecture or Reading Topic) -->
<div class="modal fade" id="modalTopic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow" style="border-radius: 10px;">
            <div class="modal-header py-2.5 px-3 border-bottom bg-light">
                <h5 class="modal-title font-13 fw-bold text-dark" id="modalTopicTitle">Configure Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;"></button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" id="inputTopicModuleIdx" value="-1">
                <input type="hidden" id="inputTopicChapterIdx" value="-1">
                <input type="hidden" id="inputTopicIdx" value="-1">

                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label class="form-label font-12">Topic Format <span class="text-danger">*</span></label>
                        <select id="inputTopicType" class="form-select font-12" onchange="toggleTopicTypeFields()">
                            <option value="video">🎥 Video Lecture</option>
                            <option value="reading">📖 Reading / High-Yield Notes</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label font-12">Topic Title <span class="text-danger">*</span></label>
                        <input type="text" id="inputTopicName" class="form-control font-12" placeholder="e.g. 1.1 Cell Membrane & Fluid Mosaic Architecture" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-12">Duration <span class="text-danger">*</span></label>
                        <input type="text" id="inputTopicDuration" class="form-control font-12" placeholder="e.g. 35 min" value="35 min">
                    </div>
                </div>

                <div class="mb-3" id="videoUrlGroup">
                    <label class="form-label font-12">Video Stream URL (MP4 / YouTube / Vimeo / CDN) <span class="text-danger">*</span></label>
                    <input type="text" id="inputTopicVideoUrl" class="form-control font-12" placeholder="https://commondatastorage.googleapis.com/... or YouTube link">
                    <div class="font-10 text-muted mt-1">Direct MP4 or unlisted YouTube video playable in student video player.</div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label font-12">Attached PDF Handout Title</label>
                        <input type="text" id="inputTopicHandout" class="form-control font-12" placeholder="e.g. Chapter 1 High-Yield Handout.pdf">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-12">PDF Handout Download Link</label>
                        <input type="text" id="inputTopicHandoutUrl" class="form-control font-12" placeholder="e.g. /downloads/notes/ch1.pdf or external URL">
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label font-12">Lesson Reading Notes / Summary (HTML or Markdown)</label>
                    <textarea id="inputTopicNotes" class="form-control font-11" rows="4" placeholder="Enter high-yield notes, key formulas, or summary points shown to students in the classroom..."></textarea>
                </div>
            </div>
            <div class="modal-footer py-2 px-3 bg-light border-top">
                <button type="button" class="btn-adm btn-adm-outline py-1 px-3 font-11" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-adm btn-adm-primary py-1 px-3 font-11" id="btnSaveTopic">Save Topic</button>
            </div>
        </div>
    </div>
</div>

<!-- 4. Quiz Modal (Topic Quiz or Chapter Quiz with MCQ Builder) -->
<div class="modal fade" id="modalQuiz" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow" style="border-radius: 10px;">
            <div class="modal-header py-2.5 px-3 border-bottom bg-light">
                <h5 class="modal-title font-13 fw-bold text-dark" id="modalQuizTitle">Configure Quiz Assessment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;"></button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" id="inputQuizModuleIdx" value="-1">
                <input type="hidden" id="inputQuizChapterIdx" value="-1">
                <input type="hidden" id="inputQuizIdx" value="-1">

                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label class="form-label font-12">Quiz Level <span class="text-danger">*</span></label>
                        <select id="inputQuizType" class="form-select font-12">
                            <option value="topic">📝 Topic Quiz (Quick Checkpoint)</option>
                            <option value="chapter">🏆 Chapter Quiz (Comprehensive Mastery)</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label font-12">Quiz Title <span class="text-danger">*</span></label>
                        <input type="text" id="inputQuizName" class="form-control font-12" placeholder="e.g. Topic 1.1 Quick Quiz: Cell Transport" required>
                    </div>
                    <div class="col-md-3">
                        <div class="row g-1">
                            <div class="col-6">
                                <label class="form-label font-12">Duration</label>
                                <input type="text" id="inputQuizDuration" class="form-control font-12" value="5 min">
                            </div>
                            <div class="col-6">
                                <label class="form-label font-12">Pass %</label>
                                <input type="number" id="inputQuizPass" class="form-control font-12" value="80" min="1" max="100">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MCQs Questions Builder -->
                <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                    <div class="fw-bold text-dark font-12">
                        <i class="fa-solid fa-list-check text-primary me-1"></i> Questions & MCQs Builder
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2 font-11" id="btnAddMcqQuestion">
                        <i class="fa-solid fa-plus me-1"></i> Add Question
                    </button>
                </div>

                <div id="quizQuestionsContainer" style="max-height: 380px; overflow-y: auto; padding-right: 4px;">
                    <!-- Question blocks rendered here -->
                </div>
            </div>
            <div class="modal-footer py-2 px-3 bg-light border-top">
                <button type="button" class="btn-adm btn-adm-outline py-1 px-3 font-11" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-adm btn-adm-primary py-1 px-3 font-11" id="btnSaveQuiz">Save Quiz</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script>
/**
 * DoctorsInn Admin Course & 3-Tier Hierarchy Studio
 * Modules -> Chapters -> Topics & Quizzes
 */

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
        icon: "fa-solid fa-dna",
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
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
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
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
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

// If no modules exist yet, initialize with standard template by default so user has an immediate working setup
if (!Array.isArray(courseModules) || courseModules.length === 0) {
    courseModules = JSON.parse(JSON.stringify(standardPmdcTemplate));
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
            <div class="text-center py-5 border border-dashed rounded-3 bg-light">
                <i class="fa-solid fa-folder-open text-muted font-24 mb-2"></i>
                <div class="fw-bold text-dark font-13">No Modules Added Yet</div>
                <p class="text-muted font-11 mb-3">Add subjects/modules or load the PMDC Starter Template.</p>
                <button type="button" class="btn btn-sm btn-primary px-3 font-11" onclick="openModuleModal(-1)">
                    <i class="fa-solid fa-plus me-1"></i> Add First Module
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
        const modIcon = mod.icon || 'fa-solid fa-dna';
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
                    <div class="d-flex align-items-center gap-2.5 flex-grow-1 text-truncate">
                        <div class="builder-module-icon">
                            <i class="${escapeHtml(modIcon)}"></i>
                        </div>
                        <div class="text-truncate">
                            <div class="fw-bold text-dark font-13 text-truncate">${escapeHtml(modName)}</div>
                            <div class="text-muted font-10">
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

                <div class="p-2.5">
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
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary font-10">${topics.length} items</span>
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

                                        let badgeHtml = '';
                                        let iconHtml = '';
                                        if (isQuiz) {
                                            if (quizType === 'chapter') {
                                                badgeHtml = `<span class="type-badge-chapter-quiz">Chapter Quiz</span>`;
                                                iconHtml = `<i class="fa-solid fa-trophy text-purple font-12" style="color: #7c3aed;"></i>`;
                                            } else {
                                                badgeHtml = `<span class="type-badge-topic-quiz">Topic Quiz</span>`;
                                                iconHtml = `<i class="fa-solid fa-pen-clip text-warning font-12"></i>`;
                                            }
                                        } else if (top.type === 'reading') {
                                            badgeHtml = `<span class="type-badge-reading">Reading</span>`;
                                            iconHtml = `<i class="fa-solid fa-book-open text-success font-12"></i>`;
                                        } else {
                                            badgeHtml = `<span class="type-badge-video">Video</span>`;
                                            iconHtml = `<i class="fa-solid fa-circle-play text-primary font-12"></i>`;
                                        }

                                        return `
                                            <div class="builder-topic-row">
                                                <div class="d-flex align-items-center gap-2 flex-grow-1 text-truncate">
                                                    ${iconHtml}
                                                    <div class="text-truncate">
                                                        <div class="fw-semibold text-dark font-12 text-truncate">${escapeHtml(top.title || 'Untitled Topic')}</div>
                                                        <div class="d-flex align-items-center gap-2 font-10 text-muted">
                                                            ${badgeHtml}
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
        document.getElementById('inputModuleIcon').value = courseModules[idx].icon || 'fa-solid fa-dna';
        document.getElementById('inputModuleDesc').value = courseModules[idx].description || '';
    } else {
        document.getElementById('modalModuleTitle').textContent = 'Add New Module / Subject';
        document.getElementById('inputModuleName').value = `Module ${courseModules.length + 1}: Subject Name`;
        document.getElementById('inputModuleIcon').value = 'fa-solid fa-dna';
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

function openTopicModal(modIdx, chIdx, topIdx = -1, defaultType = 'video') {
    document.getElementById('inputTopicModuleIdx').value = modIdx;
    document.getElementById('inputTopicChapterIdx').value = chIdx;
    document.getElementById('inputTopicIdx').value = topIdx;

    const ch = courseModules[modIdx]?.chapters[chIdx];
    if (topIdx >= 0 && ch && ch.topics[topIdx]) {
        const top = ch.topics[topIdx];
        document.getElementById('modalTopicTitle').textContent = 'Edit Topic';
        document.getElementById('inputTopicType').value = top.type || 'video';
        document.getElementById('inputTopicName').value = top.title || '';
        document.getElementById('inputTopicDuration').value = top.duration || '35 min';
        document.getElementById('inputTopicVideoUrl').value = top.videoUrl || '';
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

    toggleTopicTypeFields();
    if (bsModalTopic) bsModalTopic.show();
}

function saveTopic() {
    const modIdx = parseInt(document.getElementById('inputTopicModuleIdx').value, 10);
    const chIdx = parseInt(document.getElementById('inputTopicChapterIdx').value, 10);
    const topIdx = parseInt(document.getElementById('inputTopicIdx').value, 10);

    const type = document.getElementById('inputTopicType').value;
    const title = document.getElementById('inputTopicName').value.trim();
    const duration = document.getElementById('inputTopicDuration').value.trim();
    const videoUrl = document.getElementById('inputTopicVideoUrl').value.trim();
    const notes = document.getElementById('inputTopicNotes').value.trim();
    const handout = document.getElementById('inputTopicHandout').value.trim();
    const handoutUrl = document.getElementById('inputTopicHandoutUrl').value.trim();

    if (!title) {
        alert('Please enter a topic title');
        return;
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
        videoUrl: videoUrl,
        readContent: notes,
        resources: resources
    };

    if (topIdx >= 0 && ch.topics[topIdx]) {
        ch.topics[topIdx] = topicData;
    } else {
        ch.topics.push(topicData);
    }

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
