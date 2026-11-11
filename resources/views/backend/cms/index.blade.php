@extends('backend.layouts.master')

@section('title', 'Website Content & Images CMS')

@section('extra_css')
<style>
    .cms-nav-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 14px;
        border-radius: 9px;
        border: 1px solid var(--adm-border-color);
        background: #FFFFFF;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .cms-nav-pill:hover {
        border-color: var(--adm-primary);
        color: var(--adm-primary);
    }
    .cms-nav-pill.active {
        background: var(--adm-primary);
        color: #FFFFFF;
        border-color: var(--adm-primary);
        box-shadow: 0 2px 8px rgba(92, 50, 255, 0.22);
    }
    .cms-img-preview-box {
        width: 72px;
        height: 54px;
        border-radius: 8px;
        border: 1px solid var(--adm-border-color);
        background: #F8FAFC;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        padding: 4px;
    }
    .cms-img-preview-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Website Content &amp; Media Manager</h1>
        <p class="page-subtitle">Edit homepage text, upload photos/logos, and manage faculty, testimonials, and FAQs live.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('home') }}" target="_blank" class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>Preview Live Site</span>
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger py-2 px-3 mb-3 rounded-3" style="font-size: 12.5px;">
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- CMS Navigation Tabs -->
<div class="adm-card mb-4">
    <div class="adm-card-body py-3">
        <div class="d-flex flex-wrap gap-2">
            @foreach($sectionsMeta as $secKey => $meta)
                <a href="{{ route('admin.cms', ['tab' => $secKey]) }}"
                   class="cms-nav-pill {{ $activeTab === $secKey ? 'active' : '' }}">
                    <i class="{{ $meta['icon'] }}"></i>
                    <span>{{ $meta['label'] }}</span>
                </a>
            @endforeach
            <a href="{{ route('admin.cms', ['tab' => 'instructors']) }}"
               class="cms-nav-pill {{ $activeTab === 'instructors' ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Faculty ({{ $instructors->count() }})</span>
            </a>
            <a href="{{ route('admin.cms', ['tab' => 'testimonials']) }}"
               class="cms-nav-pill {{ $activeTab === 'testimonials' ? 'active' : '' }}">
                <i class="fa-solid fa-quote-left"></i>
                <span>Testimonials ({{ $testimonials->count() }})</span>
            </a>
            <a href="{{ route('admin.cms', ['tab' => 'faqs']) }}"
               class="cms-nav-pill {{ $activeTab === 'faqs' ? 'active' : '' }}">
                <i class="fa-solid fa-circle-question"></i>
                <span>FAQs ({{ $faqs->count() }})</span>
            </a>
        </div>
    </div>
</div>

@if(array_key_exists($activeTab, $sectionsMeta))
    {{-- Standard Section Key-Value & Image Upload Form --}}
    @php $sectionFields = $items[$activeTab] ?? collect(); @endphp
    <form action="{{ route('admin.cms.section.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="section" value="{{ $activeTab }}">

        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="{{ $sectionsMeta[$activeTab]['icon'] }} text-primary"></i>
                    {{ $sectionsMeta[$activeTab]['label'] }} Settings
                </h2>
                <button type="submit" class="btn-adm btn-adm-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save &amp; Publish</span>
                </button>
            </div>
            <div class="adm-card-body">
                <div class="row g-3">
                    @forelse($sectionFields as $field)
                        @if($field->type === 'image')
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 border bg-light bg-opacity-50 h-100">
                                    <label class="form-label fw-bold small text-dark mb-2">{{ $field->label }}</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="cms-img-preview-box">
                                            <img src="{{ asset($field->value) }}" alt="{{ $field->label }}" id="prev-{{ $field->key }}">
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="images[{{ $field->key }}]" accept="image/*" class="form-control mb-1"
                                                   onchange="if(this.files[0]){ document.getElementById('prev-{{ $field->key }}').src = URL.createObjectURL(this.files[0]); }">
                                            <div class="small text-muted" style="font-size: 11px;">Auto-optimized to fast WebP (or edit path below):</div>
                                        </div>
                                    </div>
                                    <input type="text" name="values[{{ $field->key }}]" class="form-control" value="{{ $field->value }}" placeholder="frontend/img/...">
                                </div>
                            </div>
                        @elseif($field->type === 'textarea')
                            <div class="col-12">
                                <label class="form-label fw-bold small text-dark">{{ $field->label }}</label>
                                <textarea name="values[{{ $field->key }}]" rows="2" class="form-control">{{ $field->value }}</textarea>
                            </div>
                        @else
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">{{ $field->label }}</label>
                                <input type="{{ $field->type === 'url' ? 'url' : 'text' }}" name="values[{{ $field->key }}]" class="form-control" value="{{ $field->value }}">
                            </div>
                        @endif
                    @empty
                        <div class="col-12 text-center py-4 text-muted">
                            No fields seeded yet for this section. Run <code>php artisan db:seed --class=SiteCmsSeeder</code>.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </form>

@elseif($activeTab === 'instructors')
    {{-- Faculty / Teachers CRUD --}}
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title"><i class="fa-solid fa-user-plus text-primary"></i> Add / Update Teacher</h2>
                </div>
                <div class="adm-card-body">
                    <form action="{{ route('admin.cms.instructors.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="instId">
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Teacher Name</label>
                            <input type="text" name="name" id="instName" class="form-control" required placeholder="e.g. Dr. Salman Tariq">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Subject / Title</label>
                            <input type="text" name="designation" id="instDesig" class="form-control" required placeholder="e.g. Biology Lead Instructor">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Rating</label>
                            <input type="text" name="rating" id="instRating" class="form-control" value="4.9">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Upload Photo</label>
                            <input type="file" name="image_file" accept="image/*" class="form-control">
                            <div class="small text-muted mt-1" style="font-size: 11px;">Auto-resized &amp; converted to fast WebP.</div>
                        </div>
                        <button type="submit" class="btn-adm btn-adm-primary w-100 justify-content-center">
                            <i class="fa-solid fa-floppy-disk"></i> Save Instructor
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title"><i class="fa-solid fa-chalkboard-user text-primary"></i> Active Faculty ({{ $instructors->count() }})</h2>
                </div>
                <div class="table-responsive">
                    <table class="adm-table" data-per-page="5">
                        <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>Designation</th>
                                <th>Rating</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instructors as $inst)
                            <tr>
                                <td>
                                    <div class="item-thumb-box">
                                        <img src="{{ asset($inst->image ?: 'frontend/img/team/team_2_1.jpg') }}" alt="{{ $inst->name }}">
                                        <div class="title">{{ $inst->name }}</div>
                                    </div>
                                </td>
                                <td>{{ $inst->designation }}</td>
                                <td><span class="adm-badge adm-badge-warning">★ {{ $inst->rating }}</span></td>
                                <td>
                                    <div class="table-actions">
                                        <button type="button" class="action-btn" title="Edit"
                                                onclick="document.getElementById('instId').value='{{ $inst->id }}';document.getElementById('instName').value='{{ addslashes($inst->name) }}';document.getElementById('instDesig').value='{{ addslashes($inst->designation) }}';document.getElementById('instRating').value='{{ $inst->rating }}';">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('admin.cms.instructors.delete', $inst->id) }}" method="POST" onsubmit="return confirm('Delete this teacher?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@elseif($activeTab === 'testimonials')
    {{-- Testimonials CRUD --}}
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title"><i class="fa-solid fa-quote-left text-primary"></i> Add / Edit Testimonial</h2>
                </div>
                <div class="adm-card-body">
                    <form action="{{ route('admin.cms.testimonials.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="testiId">
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Headline</label>
                            <input type="text" name="headline" id="testiHeadline" class="form-control" required placeholder="Best MDCAT Platform!">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Student Quote</label>
                            <textarea name="quote" id="testiQuote" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Student Name</label>
                            <input type="text" name="student_name" id="testiName" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Batch &amp; City</label>
                            <input type="text" name="student_batch" id="testiBatch" class="form-control" placeholder="MDCAT Batch | Lahore">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Student Photo</label>
                            <input type="file" name="avatar_file" accept="image/*" class="form-control">
                            <div class="small text-muted mt-1" style="font-size: 11px;">Auto-resized &amp; converted to fast WebP.</div>
                        </div>
                        <button type="submit" class="btn-adm btn-adm-primary w-100 justify-content-center">
                            <i class="fa-solid fa-floppy-disk"></i> Save Testimonial
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title"><i class="fa-solid fa-comments text-primary"></i> Student Reviews ({{ $testimonials->count() }})</h2>
                </div>
                <div class="table-responsive">
                    <table class="adm-table" data-per-page="5">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Review Headline</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $t)
                            <tr>
                                <td>
                                    <div class="item-thumb-box">
                                        <img src="{{ asset($t->avatar ?: 'frontend/img/testimonial/testi_2_1.png') }}" alt="{{ $t->student_name }}">
                                        <div>
                                            <div class="title">{{ $t->student_name }}</div>
                                            <div class="subtitle">{{ $t->student_batch }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ Str::limit($t->headline, 40) }}</div>
                                    <div class="small text-muted">{{ Str::limit($t->quote, 60) }}</div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button type="button" class="action-btn" title="Edit"
                                                onclick="document.getElementById('testiId').value='{{ $t->id }}';document.getElementById('testiHeadline').value='{{ addslashes($t->headline) }}';document.getElementById('testiQuote').value=`{{ addslashes($t->quote) }}`;document.getElementById('testiName').value='{{ addslashes($t->student_name) }}';document.getElementById('testiBatch').value='{{ addslashes($t->student_batch) }}';">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('admin.cms.testimonials.delete', $t->id) }}" method="POST" onsubmit="return confirm('Delete this testimonial?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@elseif($activeTab === 'faqs')
    {{-- FAQs CRUD --}}
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title"><i class="fa-solid fa-circle-question text-primary"></i> Add / Edit FAQ</h2>
                </div>
                <div class="adm-card-body">
                    <form action="{{ route('admin.cms.faqs.save') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="faqId">
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Question</label>
                            <input type="text" name="question" id="faqQ" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Answer</label>
                            <textarea name="answer" id="faqA" rows="4" class="form-control" required></textarea>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="show_on_home" value="1" id="faqHome" checked>
                            <label class="form-check-label small" for="faqHome">Show on Homepage</label>
                        </div>
                        <button type="submit" class="btn-adm btn-adm-primary w-100 justify-content-center">
                            <i class="fa-solid fa-floppy-disk"></i> Save FAQ
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title"><i class="fa-solid fa-list text-primary"></i> Published FAQs ({{ $faqs->count() }})</h2>
                </div>
                <div class="table-responsive">
                    <table class="adm-table" data-per-page="5">
                        <thead>
                            <tr>
                                <th>Question &amp; Answer</th>
                                <th>Homepage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($faqs as $f)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $f->question }}</div>
                                    <div class="small text-muted">{{ Str::limit($f->answer, 80) }}</div>
                                </td>
                                <td>
                                    <span class="adm-badge {{ $f->show_on_home ? 'adm-badge-success' : 'adm-badge-primary' }}">
                                        {{ $f->show_on_home ? 'Homepage' : 'FAQ Page' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <button type="button" class="action-btn" title="Edit"
                                                onclick="document.getElementById('faqId').value='{{ $f->id }}';document.getElementById('faqQ').value='{{ addslashes($f->question) }}';document.getElementById('faqA').value=`{{ addslashes($f->answer) }}`;document.getElementById('faqHome').checked={{ $f->show_on_home ? 'true' : 'false' }};">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('admin.cms.faqs.delete', $f->id) }}" method="POST" onsubmit="return confirm('Delete this FAQ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
