@extends('student.layouts.master')
@section('title', 'E-Library Vault & Study Notes — DoctorsInn Elite')

@section('extra_css')
<style>
    .elib-portal-card {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius-lg);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .elib-portal-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(92, 50, 255, 0.08);
        border-color: rgba(92, 50, 255, 0.3);
    }
    .elib-thumb-wrap {
        position: relative;
        height: 160px;
        background: #0b0e14;
        overflow: hidden;
    }
    .elib-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.9;
        transition: transform 0.3s ease;
    }
    .elib-portal-card:hover .elib-thumb-wrap img {
        transform: scale(1.05);
    }
    .elib-badge-pill {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(11, 14, 20, 0.85);
        backdrop-filter: blur(6px);
        color: #FBBF24;
        font-weight: 700;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid rgba(251, 191, 36, 0.3);
    }
    .elib-format-pill {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: #ef4444;
        color: #ffffff;
        font-weight: 700;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .elib-card-body {
        padding: 18px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .elib-meta-chip {
        font-size: 11.5px;
        color: var(--std-text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .elib-filter-pill {
        border: 1px solid var(--std-border);
        background: #ffffff;
        color: var(--std-text-dark);
        border-radius: 30px;
        padding: 6px 16px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .elib-filter-pill:hover,
    .elib-filter-pill.active {
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
            <h1 class="h4 fw-bold text-dark mb-1">E-Library Study Vault</h1>
            <p class="text-muted text-sm mb-0">Official PMC syllabus guidelines, solved past papers, formula sheets, and chapter summaries in 1-click PDF.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2 rounded-pill" style="font-size: 12.5px;">
                <i class="fa-solid fa-cloud-arrow-down me-1"></i> 100% Free Student Access
            </span>
        </div>
    </div>

    {{-- Search & Filter Controls --}}
    <div class="std-card p-3 mb-4">
        <div class="row align-items-center gy-3">
            <div class="col-lg-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 10px 0 0 10px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" id="elibSearchInput" class="form-control border-start-0" placeholder="Search past papers, formula sheets, notes (e.g. Biology, 2025)..." style="border-radius: 0 10px 10px 0; font-size: 13.5px;">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 flex-wrap justify-content-lg-end" id="elibFilterButtons">
                    <button type="button" class="elib-filter-pill active" data-filter="all">
                        <i class="fa-solid fa-border-all me-1"></i> All ({{ count($resources) }})
                    </button>
                    @foreach ($categories as $catKey => $cat)
                        @if ($catKey !== 'all')
                            <button type="button" class="elib-filter-pill" data-filter="{{ $catKey }}">
                                <i class="{{ $cat['icon'] ?? 'fa-solid fa-tag' }} me-1"></i> {{ $cat['label'] }}
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Resource Cards Grid --}}
    <div class="row gy-4 mb-5" id="elibResourceGrid">
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
                                <i class="fa-solid fa-award me-1"></i> {{ $res['badge'] }}
                            </span>
                        @endif
                        <span class="elib-format-pill">
                            <i class="fa-solid fa-file-pdf"></i> PDF
                        </span>
                    </div>

                    {{-- Body --}}
                    <div class="elib-card-body">
                        <div class="d-flex align-items-center justify-content-between text-xs text-muted mb-2">
                            <span><i class="fa-solid fa-book-open text-primary me-1"></i> {{ $res['subject'] ?? 'General' }}</span>
                            <span>⭐ {{ $res['rating'] ?? '4.9' }}</span>
                        </div>

                        <h3 class="fw-bold text-dark mb-2" style="font-size: 15px; line-height: 1.4; min-height: 42px;">
                            {{ $res['title'] }}
                        </h3>

                        <p class="text-muted text-xs mb-3" style="line-height: 1.5; min-height: 36px;">
                            {{ Str::limit($res['description'] ?? 'Official high-yield PDF resource for medical entrance test preparations.', 80) }}
                        </p>

                        {{-- Metadata Row --}}
                        <div class="d-flex align-items-center justify-content-between border-top border-bottom py-2 mb-3">
                            <span class="elib-meta-chip"><i class="fa-regular fa-file-lines text-primary"></i> {{ $res['pages'] ?? '40+ Pages' }}</span>
                            <span class="elib-meta-chip"><i class="fa-solid fa-hard-drive text-warning"></i> {{ $res['size'] ?? '5 MB' }}</span>
                            <span class="elib-meta-chip"><i class="fa-solid fa-download text-success"></i> {{ $res['downloads'] ?? '5k+' }}</span>
                        </div>

                        {{-- Action Button --}}
                        <div class="mt-auto">
                            <a href="{{ route('e-library.download', $res['slug']) }}" target="_blank" class="btn btn-primary w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; font-size: 13px;">
                                <i class="fa-solid fa-arrow-down-to-bracket"></i>
                                <span>Download PDF Free</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="std-card text-center py-5">
                    <i class="fa-solid fa-book-bookmark text-muted mb-3" style="font-size: 44px;"></i>
                    <h4 class="fw-bold text-dark">No Resources Available</h4>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Request Resource Box --}}
    <div class="std-card p-4 border" style="background: #ffffff;">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-file-circle-question text-success fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 16px;">Can't Find a Specific Past Paper or Chapter Summary?</h4>
                        <p class="text-muted text-xs mb-0">Drop the book name or past paper year on our WhatsApp help desk. Our academic team will upload it within 24 hours.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20am%20requesting%20a%20study%20resource%20PDF." target="_blank" class="btn btn-success fw-bold px-4 py-2" style="border-radius: 8px; font-size: 13px;">
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
