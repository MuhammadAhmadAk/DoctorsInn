@extends('student.layouts.master')
@section('title', 'Mock Tests & Exam Practice — DoctorsInn Elite')

@section('extra_css')
<style>
    .test-practice-card {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius);
        padding: 20px;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: var(--std-shadow);
    }
    .test-practice-card:hover {
        border-color: #CBD5E1;
        box-shadow: var(--std-shadow-md);
    }
    .test-filter-pill {
        border: 1px solid var(--std-border);
        background: #ffffff;
        color: var(--std-text-body);
        border-radius: 6px;
        padding: 5px 14px;
        font-size: 12.5px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .test-filter-pill:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
    }
    .test-filter-pill.active {
        background: var(--std-primary);
        color: #ffffff;
        border-color: var(--std-primary);
        font-weight: 600;
    }
</style>
@endsection

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h5 fw-bold text-dark mb-1" style="letter-spacing: -0.015em;">Mock Test Center</h1>
            <p class="text-muted text-xs mb-0">Simulate PMDC &amp; NUMS computer-based exams with timer, negative marking, and instant solutions.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-status badge-status-success">
                <i class="fa-solid fa-check"></i> PMDC 2026 Engine Active
            </span>
        </div>
    </div>

    {{-- Summary Metrics --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="std-kpi">
                <div class="std-kpi-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <div class="std-kpi-val">{{ count($tests) }}</div>
                    <div class="std-kpi-lbl">Available Mock Tests</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="std-kpi">
                <div class="std-kpi-icon">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <div class="std-kpi-val">6</div>
                    <div class="std-kpi-lbl">Tests Attempted</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="std-kpi">
                <div class="std-kpi-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <div class="std-kpi-val">78.5%</div>
                    <div class="std-kpi-lbl">Average Score</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="std-kpi">
                <div class="std-kpi-icon">
                    <i class="fa-solid fa-trophy text-warning"></i>
                </div>
                <div>
                    <div class="std-kpi-val">90%</div>
                    <div class="std-kpi-lbl">Highest Score</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Category Filters --}}
    <div class="d-flex align-items-center gap-2 mb-4 flex-wrap" id="testFilterButtons">
        <button type="button" class="test-filter-pill active" data-filter="all">
            All Tests ({{ count($tests) }})
        </button>
        @foreach ($categories as $catKey => $cat)
            @if ($catKey !== 'all')
                @php
                    $count = count(array_filter($tests, fn($t) => ($t['category'] ?? '') === $catKey));
                @endphp
                <button type="button" class="test-filter-pill" data-filter="{{ $catKey }}">
                    {{ $cat['label'] }} ({{ $count }})
                </button>
            @endif
        @endforeach
    </div>

    {{-- Tests List Grid --}}
    <div class="row gy-4 mb-4" id="testListGrid">
        @forelse ($tests as $slug => $test)
            @php
                $category = $test['category'] ?? 'mdcat';
                $duration = $test['duration_minutes'] ?? 15;
                $questions = $test['total_questions'] ?? count($test['questions'] ?? []);
                $difficulty = $test['difficulty'] ?? 'Medium';
                $diffClass = $difficulty === 'Hard' ? 'badge-status-danger' : 'badge-status-success';
            @endphp
            <div class="col-md-6 col-xl-4 test-card-item" data-category="{{ $category }}">
                <div class="test-practice-card">
                    {{-- Header Badges --}}
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge-status badge-status-primary">
                            {{ strtoupper($test['category_name'] ?? $category) }}
                        </span>
                        <span class="badge-status {{ $diffClass }}">
                            {{ $difficulty }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h2 class="fw-bold text-dark mb-1" style="font-size: 15px; line-height: 1.4; min-height: 42px;">
                        {{ $test['title'] }}
                    </h2>

                    {{-- Description --}}
                    <p class="text-muted text-xs mb-3" style="line-height: 1.5; min-height: 36px;">
                        {{ Str::limit($test['description'] ?? 'Full length practice test with timer, scoring, and solutions.', 80) }}
                    </p>

                    {{-- Meta Badges --}}
                    <div class="d-flex align-items-center justify-content-between border-top border-bottom py-2 mb-3 text-xs text-muted">
                        <span><i class="fa-regular fa-clock me-1 text-primary"></i> {{ $duration }} Mins</span>
                        <span><i class="fa-solid fa-list-ol me-1 text-primary"></i> {{ $questions }} MCQs</span>
                        <span><i class="fa-solid fa-users me-1"></i> {{ $test['attempts'] ?? '1.2k+' }}</span>
                    </div>

                    {{-- Action CTA --}}
                    <div class="mt-auto">
                        <a href="{{ route('test.take', $slug) }}" class="btn btn-sm btn-primary w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2" style="border-radius: 6px;">
                            <span>Start Online Test</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="std-card text-center py-5">
                    <h4 class="fw-bold text-dark">No Mock Tests Available</h4>
                    <p class="text-muted text-sm">New PMDC diagnostic tests are added regularly.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Exam Hall Strategy Tips (Clean, Minimalist) --}}
    <div class="std-card p-4">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 8px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--std-text-title);">
                        <i class="fa-solid fa-lightbulb fs-5"></i>
                    </div>
                    <div>
                        <h3 class="h6 fw-bold text-dark mb-1">MDCAT Speed Strategy: 45-Second Allocation</h3>
                        <p class="text-muted text-xs mb-0">Solve factual Biology and English questions within 40-45 seconds to preserve reserve minutes for Physics and Chemistry numerical calculations.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('student.classroom') }}" class="btn btn-sm btn-outline-primary fw-semibold px-3 py-2" style="border-radius: 6px;">
                    Review Strategy Videos →
                </a>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('.test-filter-pill');
        const testItems = document.querySelectorAll('.test-card-item');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                testItems.forEach(item => {
                    if (filter === 'all' || item.dataset.category === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection
