@extends('frontend.layouts.main')
@section('title', $test['title'] . ' | DoctorsInnElite')
@section('meta_description', 'Live interactive MCQ exam for ' . $test['title'])
@section('content')

    {{-- Test Top Status Header --}}
    <div class="test-runner-header py-3 bg-white border-bottom sticky-top shadow-sm">
        <div class="container">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col-lg-5 col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('tests') }}" class="btn-back-test text-muted" title="Back to Tests">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <span class="badge bg-theme-subtle text-theme fw-semibold mb-1">{{ $test['category_name'] }} • {{ $test['total_questions'] }} MCQs</span>
                            <h5 class="mb-0 test-header-title text-truncate test-header-title-max">{{ $test['title'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-6">
                    <div class="d-flex align-items-center justify-content-md-end justify-content-between gap-3">
                        {{-- Student Name Badge --}}
                        <div class="student-pill d-none d-sm-inline-flex align-items-center gap-2">
                            <div class="student-avatar-circle">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <span class="student-name text-truncate student-name-max">{{ $user['name'] ?? 'Student' }}</span>
                        </div>

                        {{-- Countdown Timer --}}
                        <div class="test-timer-box d-flex align-items-center gap-2" id="timerBox">
                            <i class="fa-solid fa-clock-rotate-left timer-icon"></i>
                            <div class="timer-digits">
                                <span class="timer-label">Time Remaining</span>
                                <span class="timer-clock fw-bold" id="timerDisplay">--:--</span>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <button type="button" class="th-btn btn-sm btn-submit-exam" id="btnSubmitExamTrigger" disabled title="Answer all questions to submit">
                            SUBMIT TEST
                            <i class="fa-solid fa-paper-plane ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main MCQ Exam Area --}}
    <section class="space-top space-extra-bottom bg-smoke" id="test-runner-body">
        <div class="container">
            <form id="mcqExamForm" action="{{ route('test.submit', $test['slug']) }}" method="POST" data-total-questions="{{ count($test['questions']) }}" data-duration-minutes="{{ $test['duration_minutes'] ?? 15 }}">
                @csrf
                <input type="hidden" name="time_spent_seconds" id="timeSpentSeconds" value="0">

                <div class="row g-4">
                    {{-- Questions Content Column (8 cols) --}}
                    <div class="col-lg-8">

                        <div class="test-progress-bar-wrap mb-3 p-3 bg-white rounded-3 shadow-sm d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-dark" id="currentQText">Question 1</span>
                                <span class="text-muted">of {{ count($test['questions']) }}</span>
                            </div>
                            <div class="progress flex-grow-1 mx-3 exam-progress-bar-wrap">
                                <div class="progress-bar bg-theme" id="examProgressBar" role="progressbar"></div>
                            </div>
                            <div class="answered-counter text-muted small">
                                <span id="answeredCount">0</span> / {{ count($test['questions']) }} Answered
                            </div>
                        </div>

                        {{-- Question Cards --}}
                        <div class="questions-container">
                            @foreach ($test['questions'] as $index => $q)
                                <div class="question-block bg-white p-4 p-md-5 rounded-4 shadow-sm mb-4 {{ $index === 0 ? 'active' : 'd-none' }}" 
                                     id="q-block-{{ $index + 1 }}" 
                                     data-index="{{ $index + 1 }}"
                                     data-qid="{{ $q['id'] }}">
                                    
                                    {{-- Question Header --}}
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="q-number-pill">Q{{ $index + 1 }}</span>
                                            <span class="badge bg-light text-primary border px-2 py-1">{{ $q['subject'] }}</span>
                                        </div>
                                        <span class="marks-badge text-muted small">
                                            <i class="fa-solid fa-award text-warning me-1"></i>{{ $test['marks_per_question'] ?? 1 }} Mark
                                        </span>
                                    </div>

                                    {{-- Question Text --}}
                                    <h4 class="question-text mb-4 text-dark lh-base">
                                        {{ $q['question'] }}
                                    </h4>

                                    {{-- Options List --}}
                                    <div class="mcq-options-wrap d-flex flex-column gap-3">
                                        @foreach ($q['options'] as $key => $optionText)
                                            <label class="mcq-option-card" for="q{{ $q['id'] }}_{{ $key }}">
                                                <input type="radio" 
                                                       name="answers[{{ $q['id'] }}]" 
                                                       id="q{{ $q['id'] }}_{{ $key }}" 
                                                       value="{{ $key }}"
                                                       class="mcq-radio-input"
                                                       data-qindex="{{ $index + 1 }}">
                                                <span class="option-letter-badge">{{ $key }}</span>
                                                <span class="option-text">{{ $optionText }}</span>
                                                <span class="option-check-icon"><i class="fa-solid fa-check"></i></span>
                                            </label>
                                        @endforeach
                                    </div>

                                    {{-- Bottom Question Action Controls --}}
                                    <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-outline-secondary btn-prev-q {{ $index === 0 ? 'disabled' : '' }}" data-target="{{ $index }}">
                                            <i class="fa-solid fa-chevron-left me-2"></i>Previous
                                        </button>

                                        <button type="button" class="btn btn-link text-muted btn-clear-q text-decoration-none small" data-qid="{{ $q['id'] }}" data-qindex="{{ $index + 1 }}">
                                            <i class="fa-solid fa-rotate-left me-1"></i>Clear Selection
                                        </button>

                                        @if ($index + 1 < count($test['questions']))
                                            <button type="button" class="btn btn-theme btn-next-q" data-target="{{ $index + 2 }}">
                                                Next<i class="fa-solid fa-chevron-right ms-2"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success btn-finish-q" id="btnFinishExamTrigger"  disabled title="Answer all questions to review and finish">
                                                Review & Finish<i class="fa-solid fa-flag-checkered ms-2"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Question Palette Sidebar (4 cols) --}}
                    <div class="col-lg-4">
                        <div class="palette-sidebar bg-white p-4 rounded-4 shadow-sm sticky-top test-palette-sticky">
                            <h5 class="palette-title mb-3 d-flex align-items-center justify-content-between">
                                <span>Question Palette</span>
                            </h5>

                            {{-- Legend --}}
                            <div class="palette-legend d-flex flex-wrap gap-3 mb-3 pb-3 border-bottom small text-muted">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="palette-indicator answered"></span>
                                    <span>Answered</span>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <span class="palette-indicator unanswered"></span>
                                    <span>Unanswered</span>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <span class="palette-indicator active"></span>
                                    <span>Current</span>
                                </div>
                            </div>

                            {{-- Question Buttons Grid --}}
                            <div class="palette-grid">
                                @foreach ($test['questions'] as $index => $q)
                                    <button type="button" 
                                            class="palette-btn {{ $index === 0 ? 'current' : '' }}" 
                                            id="palette-btn-{{ $index + 1 }}"
                                            data-target="{{ $index + 1 }}">
                                        {{ $index + 1 }}
                                    </button>
                                @endforeach
                            </div>

                            {{-- Summary Box --}}
                            <div class="test-quick-rules mt-4 pt-3 border-top small text-muted">
                                <h6 class="h6 mb-2 text-dark"><i class="fa-solid fa-circle-exclamation text-theme me-2"></i>Test Instructions:</h6>
                                <ul class="ps-3 mb-0">
                                    <li>Each question carries {{ $test['marks_per_question'] ?? 1 }} mark.</li>
                                    <li>Select your option by clicking the card.</li>
                                    <li>You can change your answer before final submission.</li>
                                    <li>Test auto-submits when timer expires.</li>
                                </ul>
                            </div>

                            <div class="mt-4">
                                <button type="button" class="th-btn w-100" id="btnFinishSidebarTrigger"  disabled title="Answer all questions to finish">
                                    FINISH TEST NOW
                                    <i class="fa-solid fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    {{-- High-End Confirmation Modal --}}
    <div class="modal fade custom-test-modal" id="submitConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg position-relative">
                {{-- Close Button (X) --}}
                <button type="button" class="btn-modal-close" id="closeModalXBtn" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="modal-body p-4 p-sm-5 text-center">
                    {{-- Animated Icon Badge --}}
                    <div class="modal-glow-badge mx-auto mb-3">
                        <div class="badge-icon-wrap">
                            <i class="fa-solid fa-paper-plane"></i>
                        </div>
                    </div>

                    <h3 class="modal-title fw-bold text-dark mb-1 test-modal-title">Ready to Submit Test?</h3>
                    <p class="text-muted small mb-4">
                        You are about to finish your test. Please review your attempt summary before final submission:
                    </p>

                    {{-- Live Summary Cards --}}
                    <div class="modal-summary-grid mb-4">
                        <div class="summary-pill-card pill-answered">
                            <span class="pill-number" id="modalStatAnswered">0</span>
                            <span class="pill-label">Answered</span>
                        </div>
                        <div class="summary-pill-card pill-unanswered">
                            <span class="pill-number" id="modalStatUnanswered">{{ count($test['questions']) }}</span>
                            <span class="pill-label">Unanswered</span>
                        </div>
                        <div class="summary-pill-card pill-time">
                            <span class="pill-number" id="modalStatTimeSpent">00:00</span>
                            <span class="pill-label">Time Spent</span>
                        </div>
                    </div>

                    {{-- Warning Note --}}
                    <div class="modal-alert-note mb-4 text-start d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-warning fs-5 flex-shrink-0"></i>
                        <span class="small text-muted">Once submitted, you cannot change your answers. Your detailed scorecard and explanations will be shown immediately.</span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold text-nowrap" id="cancelModalBtn">
                            <i class="fa-solid fa-arrow-left me-1"></i> Continue Test
                        </button>
                        <button type="button" class="btn-modal-submit px-4 py-2 rounded-pill fw-bold text-nowrap" id="confirmFinalSubmitBtn">
                             Submit Test Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
