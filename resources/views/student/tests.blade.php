@extends('student.layouts.master')
@section('title', 'Mock Tests & Exam Practice — DoctorsInn Elite')

@section('extra_css')
<style>
    .test-practice-card {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius-lg);
        padding: 22px;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .test-practice-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(92, 50, 255, 0.08);
        border-color: rgba(92, 50, 255, 0.3);
    }
    .test-badge-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(92, 50, 255, 0.08);
        color: var(--std-primary);
        font-weight: 700;
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 6px;
    }
    .test-meta-badge {
        font-size: 12px;
        color: var(--std-text-muted);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .test-filter-pill {
        border: 1px solid var(--std-border);
        background: #ffffff;
        color: var(--std-text-dark);
        border-radius: 30px;
        padding: 6px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .test-filter-pill:hover,
    .test-filter-pill.active {
        background: var(--std-primary);
        color: #ffffff;
        border-color: var(--std-primary);
    }
</style>
@endsection

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">Mock Test Practice Center</h1>
            <p class="text-muted text-sm mb-0">Simulate real PMDC &amp; NUMS computer-based exams with timer, negative marking, and instant solutions.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2 rounded-pill" style="font-size: 12.5px;">
                <i class="fa-solid fa-circle-check me-1"></i> PMDC 2026 Test Engine Active
            </span>
        </div>
    </div>

    {{-- Summary KPIs Bar --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="std-kpi-card">
                <div class="std-kpi-icon" style="background: rgba(92, 50, 255, 0.1); color: #5C32FF;">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <div class="std-kpi-value">{{ count($tests) }}</div>
                    <div class="std-kpi-label">Available Mock Tests</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="std-kpi-card">
                <div class="std-kpi-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div class="std-kpi-value">6</div>
                    <div class="std-kpi-label">Tests Attempted</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="std-kpi-card">
                <div class="std-kpi-icon" style="background: rgba(59, 130, 246, 0.1); color: #3B82F6;">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <div class="std-kpi-value">78.5%</div>
                    <div class="std-kpi-label">Average Score</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="std-kpi-card">
                <div class="std-kpi-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <div>
                    <div class="std-kpi-value">90%</div>
                    <div class="std-kpi-label">Highest Score</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Category Filters --}}
    <div class="d-flex align-items-center gap-2 mb-4 flex-wrap" id="testFilterButtons">
        <button type="button" class="test-filter-pill active" data-filter="all">
            <i class="fa-solid fa-border-all me-1"></i> All Tests ({{ count($tests) }})
        </button>
        @foreach ($categories as $catKey => $cat)
            @if ($catKey !== 'all')
                @php
                    $count = count(array_filter($tests, fn($t) => ($t['category'] ?? '') === $catKey));
                @endphp
                <button type="button" class="test-filter-pill" data-filter="{{ $catKey }}">
                    <i class="{{ $cat['icon'] ?? 'fa-solid fa-tag' }} me-1"></i> {{ $cat['label'] }} ({{ $count }})
                </button>
            @endif
        @endforeach
    </div>

    {{-- Tests List Grid --}}
    <div class="row gy-4 mb-5" id="testListGrid">
        @forelse ($tests as $slug => $test)
            @php
                $category = $test['category'] ?? 'mdcat';
                $duration = $test['duration_minutes'] ?? 15;
                $questions = $test['total_questions'] ?? count($test['questions'] ?? []);
                $difficulty = $test['difficulty'] ?? 'Medium';
            @endphp
            <div class="col-md-6 col-xl-4 test-card-item" data-category="{{ $category }}">
                <div class="test-practice-card">
                    {{-- Header Badges --}}
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="test-badge-chip">
                            <i class="fa-solid fa-stethoscope"></i>
                            <span>{{ strtoupper($test['category_name'] ?? $category) }}</span>
                        </span>
                        <span class="badge {{ $difficulty === 'Hard' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} px-2 py-1 rounded-2 fw-bold" style="font-size: 11px;">
                            {{ $difficulty }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h3 class="fw-bold text-dark mb-2" style="font-size: 16px; line-height: 1.4; min-height: 44px;">
                        {{ $test['title'] }}
                    </h3>

                    {{-- Description --}}
                    <p class="text-muted text-xs mb-4" style="line-height: 1.6; min-height: 38px;">
                        {{ Str::limit($test['description'] ?? 'Full length test based on latest examination pattern with timer and solutions.', 85) }}
                    </p>

                    {{-- Meta Badges --}}
                    <div class="d-flex align-items-center justify-content-between border-top border-bottom py-2 mb-4 flex-wrap gap-2">
                        <span class="test-meta-badge"><i class="fa-regular fa-clock text-primary"></i> {{ $duration }} Mins</span>
                        <span class="test-meta-badge"><i class="fa-solid fa-list-ol text-warning"></i> {{ $questions }} MCQs</span>
                        <span class="test-meta-badge"><i class="fa-solid fa-users text-muted"></i> {{ $test['attempts'] ?? '1.2k+' }}</span>
                    </div>

                    {{-- Action CTA --}}
                    <div class="mt-auto">
                        <a href="{{ route('test.take', $slug) }}" class="btn btn-primary w-100 py-2 fw-bold d-inline-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; font-size: 13.5px;">
                            <i class="fa-solid fa-play"></i>
                            <span>Start Online Test</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="std-card text-center py-5">
                    <i class="fa-solid fa-flask-vial text-muted mb-3" style="font-size: 44px;"></i>
                    <h4 class="fw-bold text-dark">No Mock Tests Available</h4>
                    <p class="text-muted text-sm">New PMDC diagnostic tests are uploaded every Friday.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Exam Hall Strategy Tips --}}
    <div class="std-card p-4" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); color: #ffffff;">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(239, 172, 6, 0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-lightbulb text-warning fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-white mb-1" style="font-size: 16px;">MDCAT Speed Strategy: The 45-Second Rule</h4>
                        <p class="text-white text-opacity-75 text-xs mb-0">Never spend more than 45 seconds on Biology or English questions. Save extra time for Physics numerical calculations and Organic Chemistry reactions.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('student.classroom') }}" class="btn btn-warning fw-bold px-4 py-2" style="border-radius: 8px; font-size: 13px;">
                    <i class="fa-solid fa-video me-1"></i> Watch Paper Attempt Technique
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
