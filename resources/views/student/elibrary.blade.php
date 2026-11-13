@extends('student.layouts.master')
@section('title', 'E-Library Study Vault — DoctorsInn Elite')

@section('extra_css')
<style>
    .elib-portal-card {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius);
        overflow: hidden;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: var(--std-shadow);
    }
    .elib-portal-card:hover {
        border-color: #CBD5E1;
        box-shadow: var(--std-shadow-md);
    }
    .elib-thumb-wrap {
        position: relative;
        height: 140px;
        background: #0f172a;
        overflow: hidden;
    }
    .elib-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .elib-badge-pill {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        color: #F8FAFC;
        font-weight: 600;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .elib-format-pill {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #DC2626;
        color: #ffffff;
        font-weight: 700;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
    }
    .elib-card-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .elib-filter-pill {
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
    .elib-filter-pill:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
    }
    .elib-filter-pill.active {
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
            <h1 class="h5 fw-bold text-dark mb-1" style="letter-spacing: -0.015em;">E-Library Vault</h1>
            <p class="text-muted text-xs mb-0">Official PMC syllabus guidelines, solved past papers, formula sheets, and chapter summaries in PDF.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-status badge-status-primary">
                <i class="fa-solid fa-cloud-arrow-down"></i> Free Student Downloads
            </span>
        </div>
    </div>

    {{-- Search & Filter Controls --}}
    <div class="std-card p-3 mb-4">
        <div class="row align-items-center gy-3">
            <div class="col-lg-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 6px 0 0 6px;">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" id="elibSearchInput" class="form-control border-start-0" placeholder="Search notes, past papers, subjects..." style="border-radius: 0 6px 6px 0; font-size: 13px;">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 flex-wrap justify-content-lg-end" id="elibFilterButtons">
                    <button type="button" class="elib-filter-pill active" data-filter="all">
                        All ({{ count($resources) }})
                    </button>
                    @foreach ($categories as $catKey => $cat)
                        @if ($catKey !== 'all')
                            <button type="button" class="elib-filter-pill" data-filter="{{ $catKey }}">
                                {{ $cat['label'] }}
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Resource Cards Grid --}}
    <div class="row gy-4 mb-4" id="elibResourceGrid">
        @forelse ($resources as $res)
            @php
                $category = $res['category'] ?? 'notes';
                $examCat = $res['exam_category'] ?? '';
                $searchContent = strtolower(($res['title'] ?? '') . ' ' . ($res['subject'] ?? '') . ' ' . $category . ' ' . $examCat);
            @endphp
            <div class="col-md-6 col-xl-4 elib-resource-col" data-category="{{ $category }}" data-exam="{{ $examCat }}" data-search="{{ $searchContent }}">
                <div class="elib-portal-card">
                    {{-- Thumbnail & Badges --}}
                    <div class="elib-thumb-wrap">
                        <img src="{{ asset($res['image'] ?? 'frontend/img/course/course1-1.jpg') }}" alt="{{ $res['title'] }}">
                        @if (!empty($res['badge']))
                            <span class="elib-badge-pill">
                                {{ $res['badge'] }}
                            </span>
                        @endif
                        <span class="elib-format-pill">PDF</span>
                    </div>

                    {{-- Body --}}
                    <div class="elib-card-body">
                        <div class="d-flex align-items-center justify-content-between text-xs text-muted mb-2">
                            <span><i class="fa-solid fa-book-open text-primary me-1"></i> {{ $res['subject'] ?? 'General' }}</span>
                            <span>{{ $res['downloads'] ?? '5k+' }} downloads</span>
                        </div>

                        <h2 class="fw-bold text-dark mb-1" style="font-size: 14.5px; line-height: 1.4; min-height: 40px;">
                            {{ $res['title'] }}
                        </h2>

                        <p class="text-muted text-xs mb-3" style="line-height: 1.5; min-height: 34px;">
                            {{ Str::limit($res['description'] ?? 'Official high-yield PDF resource for medical entrance test preparations.', 75) }}
                        </p>

                        {{-- Metadata Row --}}
                        <div class="d-flex align-items-center justify-content-between border-top border-bottom py-2 mb-3 text-xs text-muted">
                            <span><i class="fa-regular fa-file-lines me-1"></i> {{ $res['pages'] ?? '40+ Pages' }}</span>
                            <span><i class="fa-solid fa-hard-drive me-1"></i> {{ $res['size'] ?? '5 MB' }}</span>
                            <span>⭐ {{ $res['rating'] ?? '4.9' }}</span>
                        </div>

                        {{-- Action Button --}}
                        <div class="mt-auto">
                            <a href="{{ route('e-library.download', $res['slug']) }}" target="_blank" class="btn btn-sm btn-primary w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2" style="border-radius: 6px;">
                                <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i>
                                <span>Download PDF</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="std-card text-center py-5">
                    <h4 class="fw-bold text-dark">No Resources Available</h4>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Request Resource Box (Clean, Minimalist) --}}
    <div class="std-card p-4">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 8px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--std-text-title);">
                        <i class="fa-solid fa-file-circle-question fs-5"></i>
                    </div>
                    <div>
                        <h3 class="h6 fw-bold text-dark mb-1">Looking for a Specific Past Paper or Chapter Summary?</h3>
                        <p class="text-muted text-xs mb-0">Send the title or past paper year to our academic desk. We will verify and upload it to the study vault.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20am%20requesting%20a%20study%20resource%20PDF." target="_blank" class="btn btn-sm btn-outline-success fw-semibold px-3 py-2" style="border-radius: 6px;">
                    <i class="fa-brands fa-whatsapp me-1"></i> Request Resource
                </a>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('elibSearchInput');
        const filterButtons = document.querySelectorAll('.elib-filter-pill');
        const cards = document.querySelectorAll('.elib-resource-col');

        let activeFilter = 'all';
        let searchQuery = '';

        function filterResources() {
            cards.forEach(card => {
                const category = card.dataset.category;
                const exam = card.dataset.exam;
                const search = card.dataset.search;

                const matchesFilter = (activeFilter === 'all') || (category === activeFilter) || (exam === activeFilter);
                const matchesSearch = !searchQuery || search.includes(searchQuery);

                if (matchesFilter && matchesSearch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilter = this.dataset.filter;
                filterResources();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                searchQuery = this.value.trim().toLowerCase();
                filterResources();
            });
        }
    });
</script>
@endsection
