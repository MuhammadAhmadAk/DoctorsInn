@extends('frontend.layouts.main')
@section('title', 'Scorecard: ' . $test['title'] . ' | DoctorsInnElite')
@section('meta_description', 'Official test results, performance scorecard, and detailed solutions for ' . $test['title'])
@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Test Result & Performance Review</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('tests') }}">Mock Tests</a></li>
                            <li>Result</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scorecard Section --}}
    <section class="space-top space-extra-bottom bg-smoke" id="test-result-sec">
        <div class="container">

            {{-- Result Main Hero Card --}}
            <div class="result-hero-card bg-white p-4 p-md-5 rounded-4 shadow-sm mb-5">
                <div class="row align-items-center g-4">
                    {{-- Left: Score Circle and Status --}}
                    <div class="col-lg-5 text-center border-lg-end">
                        <div class="score-circle-wrapper mx-auto mb-3 position-relative {{ $resultData['passed'] ? 'passed' : 'failed' }}">
                            <div class="score-circle-inner">
                                <span class="score-percentage fw-bold">{{ $resultData['percentage'] }}%</span>
                                <span class="score-marks text-muted">{{ $resultData['score'] }} / {{ $resultData['total_marks'] }} Marks</span>
                            </div>
                        </div>

                        @if ($resultData['passed'])
                            <div class="status-badge passed d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill mb-2">
                                <i class="fa-solid fa-circle-check"></i>
                                <span class="fw-bold">TEST PASSED (Congratulations!)</span>
                            </div>
                            <p class="text-muted small mb-0">Congratulations! You scored above the passing benchmark ({{ $resultData['passing_percentage'] }}%).</p>
                        @else
                            <div class="status-badge failed d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill mb-2">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span class="fw-bold">KEEP PRACTICING</span>
                            </div>
                            <p class="text-muted small mb-0">The passing benchmark was {{ $resultData['passing_percentage'] }}%. Review the detailed explanations below and retake the test to improve!</p>
                        @endif
                    </div>

                    {{-- Right: Test Details & Metrics --}}
                    <div class="col-lg-7">
                        <div class="ps-lg-3">
                            <span class="badge bg-theme-subtle text-theme fw-semibold mb-2">{{ $test['category_name'] }} Mock Test</span>
                            <h3 class="result-test-title mb-2">{{ $test['title'] }}</h3>
                            <div class="d-flex flex-wrap align-items-center gap-3 text-muted small mb-4">
                                <span><i class="fa-solid fa-user-graduate me-1 text-theme"></i>Student: <strong>{{ $resultData['user']['name'] ?? 'Student' }}</strong></span>
                                <span><i class="fa-regular fa-calendar-check me-1 text-theme"></i>Date: {{ $resultData['submitted_at'] }}</span>
                                <span><i class="fa-solid fa-stopwatch me-1 text-theme"></i>Time Spent: <strong>{{ $resultData['time_spent'] }}</strong></span>
                            </div>

                            {{-- Metric Badges Row --}}
                            <div class="row g-3">
                                <div class="col-sm-4 col-6">
                                    <div class="metric-card metric-correct p-3 rounded-3 text-center">
                                        <div class="metric-icon text-success mb-1"><i class="fa-solid fa-check-circle fs-4"></i></div>
                                        <h4 class="metric-val text-success mb-0">{{ $resultData['correct_count'] }}</h4>
                                        <span class="metric-label text-muted small">Correct</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="metric-card metric-wrong p-3 rounded-3 text-center">
                                        <div class="metric-icon text-danger mb-1"><i class="fa-solid fa-times-circle fs-4"></i></div>
                                        <h4 class="metric-val text-danger mb-0">{{ $resultData['incorrect_count'] }}</h4>
                                        <span class="metric-label text-muted small">Incorrect</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <div class="metric-card metric-skipped p-3 rounded-3 text-center">
                                        <div class="metric-icon text-secondary mb-1"><i class="fa-solid fa-minus-circle fs-4"></i></div>
                                        <h4 class="metric-val text-secondary mb-0">{{ $resultData['skipped_count'] }}</h4>
                                        <span class="metric-label text-muted small">Skipped</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                                <a href="{{ route('test.take', $test['slug']) }}" class="th-btn btn-sm">
                                    <i class="fa-solid fa-rotate-right me-2"></i>RETAKE TEST
                                </a>
                                <a href="{{ route('tests') }}" class="th-btn btn-sm style-border2">
                                    <i class="fa-solid fa-layer-group me-2"></i>ALL MOCK TESTS
                                </a>
                                <a href="{{ route('e-library') }}" class="th-btn btn-sm style-border2">
                                    <i class="fa-solid fa-book me-2"></i>FREE STUDY MATERIAL
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detailed Question Solutions Section --}}
            <div class="solutions-header mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h3 class="h4 mb-1">Detailed Solutions & Explanations</h3>
                    <p class="text-muted small mb-0">Check answers, mistake analysis, and concept clarity for every question.</p>
                </div>
                <div class="d-flex align-items-center gap-2 small">
                    <span class="badge bg-success-subtle text-success px-2 py-1"><i class="fa-solid fa-check me-1"></i>Correct</span>
                    <span class="badge bg-danger-subtle text-danger px-2 py-1"><i class="fa-solid fa-times me-1"></i>Incorrect</span>
                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1"><i class="fa-solid fa-minus me-1"></i>Skipped</span>
                </div>
            </div>

            {{-- Questions Solutions Loop --}}
            <div class="solutions-list d-flex flex-column gap-4">
                @foreach ($resultData['breakdown'] as $idx => $item)
                    @php
                        $q = $item['question'];
                        $isCorrect = $item['is_correct'];
                        $isSkipped = $item['is_skipped'];
                    @endphp

                    <div class="solution-card bg-white p-4 p-md-5 rounded-4 shadow-sm border-start border-4 {{ $isCorrect ? 'border-success' : ($isSkipped ? 'border-secondary' : 'border-danger') }}">
                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="q-number-pill">Question {{ $idx + 1 }}</span>
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $q['subject'] }}</span>
                            </div>

                            @if ($isCorrect)
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">
                                    <i class="fa-solid fa-circle-check me-1"></i>Correct (+{{ $test['marks_per_question'] ?? 1 }})
                                </span>
                            @elseif ($isSkipped)
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-bold">
                                    <i class="fa-solid fa-circle-minus me-1"></i>Skipped (0)
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold">
                                    <i class="fa-solid fa-circle-xmark me-1"></i>Incorrect (0)
                                </span>
                            @endif
                        </div>

                        {{-- Question Text --}}
                        <h5 class="lh-base mb-4 text-dark">{{ $q['question'] }}</h5>

                        {{-- Options List with Solution Highlights --}}
                        <div class="row g-2 mb-4">
                            @foreach ($q['options'] as $key => $text)
                                @php
                                    $isThisCorrect = ($key === $item['correct_choice']);
                                    $isThisUserChoice = ($key === $item['user_choice']);
                                    
                                    $optClass = 'option-neutral';
                                    if ($isThisCorrect) {
                                        $optClass = 'option-correct';
                                    } elseif ($isThisUserChoice && !$isCorrect) {
                                        $optClass = 'option-wrong';
                                    }
                                @endphp

                                <div class="col-md-6">
                                    <div class="solution-option-box p-3 rounded-3 d-flex align-items-center gap-3 {{ $optClass }}">
                                        <span class="sol-letter-badge">{{ $key }}</span>
                                        <span class="sol-text flex-grow-1">{{ $text }}</span>
                                        
                                        @if ($isThisCorrect)
                                            <span class="badge bg-success text-white small" title="Correct Answer">
                                                <i class="fa-solid fa-check me-1"></i>Correct
                                            </span>
                                        @elseif ($isThisUserChoice)
                                            <span class="badge bg-danger text-white small" title="Your Choice">
                                                <i class="fa-solid fa-xmark me-1"></i>Your Answer
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Concept Explanation Box --}}
                        <div class="explanation-box p-3 p-md-4 rounded-3 d-flex align-items-start gap-3">
                            <div class="exp-icon-wrap text-theme fs-4">
                                <i class="fa-solid fa-lightbulb"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1 text-theme">Explanation & Key Concept:</h6>
                                <p class="mb-0 text-muted lh-base small">{{ $item['explanation'] }}</p>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Bottom CTA --}}
            <div class="text-center mt-5">
                <a href="{{ route('tests') }}" class="th-btn">
                    EXPLORE MORE MOCK TESTS <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>

        </div>
    </section>

@endsection
