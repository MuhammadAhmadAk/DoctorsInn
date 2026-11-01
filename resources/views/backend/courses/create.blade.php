@extends('backend.layouts.master')

@section('title', 'Add New Course')

@section('content')
<form action="{{ route('admin.courses.store') }}" method="POST">
    @csrf

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 font-11">
                    <li class="breadcrumb-item"><a href="{{ route('admin.courses') }}" class="text-decoration-none text-muted">Courses</a></li>
                    <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">New Course</li>
                </ol>
            </nav>
            <h1 class="page-title">New Course Batch</h1>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.courses') }}" class="btn-adm btn-adm-outline">Discard</a>
            <button type="submit" name="status" value="draft" class="btn-adm btn-adm-outline">
                <i class="fa-regular fa-bookmark"></i>
                <span>Save Draft</span>
            </button>
            <button type="submit" name="status" value="published" class="btn-adm btn-adm-primary">
                <i class="fa-solid fa-check"></i>
                <span>Create Course</span>
            </button>
        </div>
    </div>

    <div class="row g-3">
        <!-- Main Content Column -->
        <div class="col-lg-8">
            <!-- Course Details Card -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <div>
                        <h2 class="adm-card-title">Course Information</h2>
                        <div class="text-muted font-11">Core program details, title, and public syllabus description.</div>
                    </div>
                </div>
                <div class="adm-card-body">
                    <div class="mb-3">
                        <label class="form-label">Course Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control font-13" placeholder="e.g. MDCAT 2026: Complete All-Subject Medical Prep Batch" value="MDCAT 2026: Complete All-Subject Medical Prep Batch" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Target Exam Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select font-12" required>
                                <option value="mdcat" selected>MDCAT Full (5 PMDC Subjects Bundle)</option>
                                <option value="nums">NUMS Medical Entrance (Army Medical College Pattern)</option>
                                <option value="army">Army / AMC (Cadet & Intelligence Prep)</option>
                                <option value="past_papers">FLPs & 10-Year Solved Past Papers Series</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lead Faculty / Department</label>
                            <input type="text" name="instructor" class="form-control font-12" value="DoctorsInn Medical Faculty Panel">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Success Highlight Badge</label>
                            <input type="text" name="success_badge" class="form-control font-12" placeholder="e.g. 300+ Qualifiers in Top Medical Colleges" value="300+ Qualifiers in Top Medical Colleges">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Target Audience / Subtitle</label>
                            <input type="text" name="tagline" class="form-control font-12" value="Comprehensive prep covering PMDC syllabus, 5,000+ MCQs, and 10 FLPs.">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Detailed Course Overview</label>
                        <textarea name="overview" class="form-control font-12" rows="4" placeholder="Course overview, syllabus breakdown, and live mentorship features...">This comprehensive MDCAT program provides end-to-end preparation for all 5 core subjects: Biology, Chemistry, Physics, English, and Logical Reasoning. Built specifically around the updated PMDC syllabus, each subject is taught from foundational fundamentals to advanced exam-trap MCQs, supplemented by weekly unit tests and full-length simulated mock exams.</textarea>
                    </div>
                </div>
            </div>

            <!-- Subject-Wise Curriculum & Lectures -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <div>
                        <h2 class="adm-card-title">Curriculum & Video Lessons</h2>
                        <div class="text-muted font-11">Organize chapters, video lectures, attached PDF notes, and topical quizzes.</div>
                    </div>
                </div>

                <!-- Clean Subject Pills Navigation -->
                <div class="p-3 border-bottom bg-light bg-opacity-50">
                    <ul class="nav nav-pills gap-2" id="curriculumTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active font-12 py-1.5 px-3 fw-semibold" id="tab-bio" data-bs-toggle="tab" data-bs-target="#pane-bio" type="button" role="tab">
                                Biology <span class="badge bg-white text-dark ms-1">45</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-12 py-1.5 px-3 fw-semibold" id="tab-chem" data-bs-toggle="tab" data-bs-target="#pane-chem" type="button" role="tab">
                                Chemistry <span class="badge bg-white text-dark ms-1">38</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-12 py-1.5 px-3 fw-semibold" id="tab-phy" data-bs-toggle="tab" data-bs-target="#pane-phy" type="button" role="tab">
                                Physics <span class="badge bg-white text-dark ms-1">32</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-12 py-1.5 px-3 fw-semibold" id="tab-eng" data-bs-toggle="tab" data-bs-target="#pane-eng" type="button" role="tab">
                                English <span class="badge bg-white text-dark ms-1">16</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-12 py-1.5 px-3 fw-semibold" id="tab-logic" data-bs-toggle="tab" data-bs-target="#pane-logic" type="button" role="tab">
                                Logical Reasoning <span class="badge bg-white text-dark ms-1">10</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="adm-card-body p-3">
                    <div class="tab-content">
                        <!-- BIOLOGY PANE -->
                        <div class="tab-pane fade show active" id="pane-bio" role="tabpanel">
                            <!-- Chapter 1 Box -->
                            <div class="border rounded-2 mb-3 bg-white overflow-hidden">
                                <div class="p-2.5 px-3 bg-light d-flex align-items-center justify-content-between border-bottom">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-folder text-muted font-13"></i>
                                        <span class="fw-bold text-dark font-12">Chapter 1: Cell Biology & Division</span>
                                        <span class="text-muted font-11">• 3 Lessons</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 font-11" data-bs-toggle="modal" data-bs-target="#lessonModal">
                                        <i class="fa-solid fa-plus me-1"></i> Add Lesson
                                    </button>
                                </div>
                                <div class="p-2">
                                    <!-- Lesson 1.1 -->
                                    <div class="d-flex align-items-center justify-content-between p-2 mb-1 rounded border bg-light bg-opacity-25 hover-bg">
                                        <div class="d-flex align-items-center gap-2.5">
                                            <i class="fa-regular fa-circle-play text-primary font-14"></i>
                                            <div>
                                                <div class="fw-semibold text-dark font-12">1.1 Cell Wall, Plasma Membrane & Fluid Mosaic Model</div>
                                                <div class="text-muted font-10">45 mins • Notes Attached • 30 Practice MCQs</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-link text-muted p-0 font-11" data-bs-toggle="modal" data-bs-target="#lessonModal">Edit</button>
                                            <span class="text-muted font-10">|</span>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 font-11" onclick="return confirm('Remove lesson?')">Delete</button>
                                        </div>
                                    </div>

                                    <!-- Lesson 1.2 -->
                                    <div class="d-flex align-items-center justify-content-between p-2 mb-1 rounded border bg-light bg-opacity-25 hover-bg">
                                        <div class="d-flex align-items-center gap-2.5">
                                            <i class="fa-regular fa-circle-play text-primary font-14"></i>
                                            <div>
                                                <div class="fw-semibold text-dark font-12">1.2 Endoplasmic Reticulum, Golgi Complex & Lysosomes</div>
                                                <div class="text-muted font-10">40 mins • Notes Attached • 25 Practice MCQs</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-link text-muted p-0 font-11" data-bs-toggle="modal" data-bs-target="#lessonModal">Edit</button>
                                            <span class="text-muted font-10">|</span>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 font-11" onclick="return confirm('Remove lesson?')">Delete</button>
                                        </div>
                                    </div>

                                    <!-- Lesson 1.3 -->
                                    <div class="d-flex align-items-center justify-content-between p-2 rounded border bg-light bg-opacity-25 hover-bg">
                                        <div class="d-flex align-items-center gap-2.5">
                                            <i class="fa-regular fa-circle-play text-primary font-14"></i>
                                            <div>
                                                <div class="fw-semibold text-dark font-12">1.3 Mitosis, Meiosis & Cell Cycle Checkpoints</div>
                                                <div class="text-muted font-10">50 mins • Notes Attached • 35 Practice MCQs</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-link text-muted p-0 font-11" data-bs-toggle="modal" data-bs-target="#lessonModal">Edit</button>
                                            <span class="text-muted font-10">|</span>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 font-11" onclick="return confirm('Remove lesson?')">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chapter 2 Box -->
                            <div class="border rounded-2 mb-3 bg-white overflow-hidden">
                                <div class="p-2.5 px-3 bg-light d-flex align-items-center justify-content-between border-bottom">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-folder text-muted font-13"></i>
                                        <span class="fw-bold text-dark font-12">Chapter 2: Biological Molecules</span>
                                        <span class="text-muted font-11">• 1 Lesson</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 font-11" data-bs-toggle="modal" data-bs-target="#lessonModal">
                                        <i class="fa-solid fa-plus me-1"></i> Add Lesson
                                    </button>
                                </div>
                                <div class="p-2">
                                    <div class="d-flex align-items-center justify-content-between p-2 rounded border bg-light bg-opacity-25 hover-bg">
                                        <div class="d-flex align-items-center gap-2.5">
                                            <i class="fa-regular fa-circle-play text-primary font-14"></i>
                                            <div>
                                                <div class="fw-semibold text-dark font-12">2.1 Carbohydrates, Lipids & Nucleic Acids (DNA & RNA)</div>
                                                <div class="text-muted font-10">48 mins • Notes Attached • 40 Practice MCQs</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="btn btn-sm btn-link text-muted p-0 font-11" data-bs-toggle="modal" data-bs-target="#lessonModal">Edit</button>
                                            <span class="text-muted font-10">|</span>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 font-11" onclick="return confirm('Remove lesson?')">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn-adm btn-adm-outline w-100 py-1.5 font-11" onclick="alert('Add Chapter: Enter chapter name')">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add New Chapter</span>
                            </button>
                        </div>

                        <!-- CHEMISTRY PANE -->
                        <div class="tab-pane fade" id="pane-chem" role="tabpanel">
                            <div class="border rounded-2 p-2.5 mb-2 bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold text-dark font-12">Unit 1: Fundamental Concepts & Stoichiometry</span>
                                    <span class="text-muted font-11">3 Lessons</span>
                                </div>
                                <div class="text-muted font-10">Formula cheat sheets, molar ratios, and topical unit quizzes.</div>
                            </div>
                            <div class="border rounded-2 p-2.5 mb-3 bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold text-dark font-12">Unit 2: Atomic Structure & Quantum Mechanics</span>
                                    <span class="text-muted font-11">4 Lessons</span>
                                </div>
                                <div class="text-muted font-10">Orbital hybridization, electron configurations, and practice MCQs.</div>
                            </div>
                            <button type="button" class="btn-adm btn-adm-outline w-100 py-1.5 font-11">+ Add Chemistry Chapter</button>
                        </div>

                        <!-- PHYSICS PANE -->
                        <div class="tab-pane fade" id="pane-phy" role="tabpanel">
                            <div class="border rounded-2 p-2.5 mb-2 bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold text-dark font-12">Unit 1: Force, Motion & Work Energy</span>
                                    <span class="text-muted font-11">4 Lessons</span>
                                </div>
                                <div class="text-muted font-10">Calculations, motion graphs, and projectile shortcuts.</div>
                            </div>
                            <div class="border rounded-2 p-2.5 mb-3 bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold text-dark font-12">Unit 2: Electromagnetism & Current Electricity</span>
                                    <span class="text-muted font-11">5 Lessons</span>
                                </div>
                                <div class="text-muted font-10">Ohm's law, Kirchhoff's laws, capacitors, and circuit MCQs.</div>
                            </div>
                            <button type="button" class="btn-adm btn-adm-outline w-100 py-1.5 font-11">+ Add Physics Chapter</button>
                        </div>

                        <!-- ENGLISH PANE -->
                        <div class="tab-pane fade" id="pane-eng" role="tabpanel">
                            <div class="border rounded-2 p-2.5 mb-3 bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold text-dark font-12">High-Yield Grammar & Tenses</span>
                                    <span class="text-muted font-11">16 Lessons</span>
                                </div>
                                <div class="text-muted font-10">Subject-verb agreement, prepositions, conditionals, and vocabulary drills.</div>
                            </div>
                            <button type="button" class="btn-adm btn-adm-outline w-100 py-1.5 font-11">+ Add English Unit</button>
                        </div>

                        <!-- LOGICAL REASONING PANE -->
                        <div class="tab-pane fade" id="pane-logic" role="tabpanel">
                            <div class="border rounded-2 p-2.5 mb-3 bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold text-dark font-12">Critical Logic & Deductions</span>
                                    <span class="text-muted font-11">10 Lessons</span>
                                </div>
                                <div class="text-muted font-10">Syllogisms, number/letter series, assumptions, and cause-effect reasoning.</div>
                            </div>
                            <button type="button" class="btn-adm btn-adm-outline w-100 py-1.5 font-11">+ Add Logic Unit</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preparation Roadmap Card -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <div>
                        <h2 class="adm-card-title">Preparation Roadmap</h2>
                        <div class="text-muted font-11">Define the weekly milestones and study targets for students.</div>
                    </div>
                </div>
                <div class="adm-card-body">
                    <div class="row g-3">
                        <!-- Phase 1 -->
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
                                    <textarea name="roadmap[0][description]" class="form-control font-11" rows="3">100% PMDC syllabus coverage across Biology, Chemistry & Physics with daily topic quizzes.</textarea>
                                </div>
                                <div class="small text-muted font-11 pt-1 border-top">
                                    <i class="fa-solid fa-bullseye text-primary me-1"></i> Target: 1,500 MCQs
                                </div>
                            </div>
                        </div>

                        <!-- Phase 2 -->
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
                                    <textarea name="roadmap[1][description]" class="form-control font-11" rows="3">Chapter-wise past 10-year PMDC/UHS questions, speed elimination, and formula drills.</textarea>
                                </div>
                                <div class="small text-muted font-11 pt-1 border-top">
                                    <i class="fa-solid fa-bullseye text-warning me-1"></i> Target: 2,500 Past MCQs
                                </div>
                            </div>
                        </div>

                        <!-- Phase 3 -->
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
                                    <textarea name="roadmap[2][description]" class="form-control font-11" rows="3">10 Full-Length Simulated Papers (200 MCQs, 3.5 hrs timer) with provincial merit ranking.</textarea>
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
                            <input type="text" name="duration" class="form-control font-12" value="90 Days" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Seat Limit</label>
                            <input type="number" name="seats" class="form-control font-12" value="350">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Language of Instruction</label>
                        <input type="text" name="language" class="form-control font-12" value="Urdu / English">
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="adm-card mb-3">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">Pricing</h2>
                </div>
                <div class="adm-card-body">
                    <div class="mb-3">
                        <label class="form-label">Price (PKR) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted font-12">₨</span>
                            <input type="text" name="price" class="form-control font-13 fw-bold" value="3,500" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Compare-at Price (Original)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted font-12">₨</span>
                            <input type="text" name="original_price" class="form-control font-12 text-muted" value="6,000">
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
                        <img src="{{ asset('frontend/img/course/course1-1.jpg') }}" alt="Course Thumbnail" class="img-fluid rounded" style="max-height: 140px; width: 100%; object-fit: cover;">
                    </div>
                    <button type="button" class="btn-adm btn-adm-outline w-100 py-1.5 font-11 mb-1" onclick="alert('Select image dialog')">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>Upload Image</span>
                    </button>
                    <div class="text-muted font-10">Recommended 1200×800px (16:9 ratio).</div>
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

<!-- Modal: Lesson Editor -->
<div class="modal fade" id="lessonModal" tabindex="-1" aria-labelledby="lessonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm" style="border-radius: 8px;">
            <div class="modal-header py-2.5 px-3 border-bottom">
                <h5 class="modal-title font-13 fw-bold text-dark" id="lessonModalLabel">Configure Video Lesson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;"></button>
            </div>
            <div class="modal-body p-3">
                <div class="mb-3">
                    <label class="form-label">Lesson Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control font-12" value="1.1 Cell Wall, Plasma Membrane & Fluid Mosaic Model">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label">Subject</label>
                        <select class="form-select font-12">
                            <option selected>Biology</option>
                            <option>Chemistry</option>
                            <option>Physics</option>
                            <option>English</option>
                            <option>Logical Reasoning</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Duration</label>
                        <input type="text" class="form-control font-12" value="45 Mins">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Video Stream Source</label>
                    <select class="form-select font-12">
                        <option selected>Direct MP4 / CDN Fast Stream</option>
                        <option>YouTube (Unlisted)</option>
                        <option>Vimeo (Domain-Protected)</option>
                        <option>BunnyCDN / HLS Encrypted</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stream Link / Source <span class="text-danger">*</span></label>
                    <input type="text" class="form-control font-12" placeholder="Paste video link or CDN stream URL">
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label">Attached PDF Notes</label>
                        <input type="text" class="form-control font-12" value="Cell_Biology_Notes.pdf">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Practice MCQs</label>
                        <input type="number" class="form-control font-12" value="30">
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2 px-3 bg-light border-top">
                <button type="button" class="btn-adm btn-adm-outline py-1 px-3 font-11" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-adm btn-adm-primary py-1 px-3 font-11" data-bs-dismiss="modal" onclick="alert('Lesson updated')">Save Lesson</button>
            </div>
        </div>
    </div>
</div>
@endsection
