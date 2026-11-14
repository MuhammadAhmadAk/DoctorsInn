@extends('backend.layouts.master')

@section('title', 'E-Library Vault Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">E-Library Vault Management</h1>
        <p class="page-subtitle">Manage medical study guides, PMDC syllabus books, solved past papers, and formula summaries.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('e-library') }}" target="_blank" class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>View Public Library</span>
        </a>
        <button type="button" class="btn-adm btn-adm-primary" onclick="document.getElementById('elibraryFormCard').classList.toggle('d-none')">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <span>Upload Resource</span>
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="adm-card mb-4 d-none" id="elibraryFormCard">
    <div class="adm-card-header">
        <h2 class="adm-card-title"><i class="fa-solid fa-book-medical text-primary"></i> Add E-Library Resource</h2>
    </div>
    <div class="adm-card-body">
        <form id="elibraryUploadForm" action="{{ route('admin.elibrary.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3" style="font-size: 12.5px;">{{ $errors->first() }}</div>
            @endif
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-bold">Resource Title</label>
                    <input type="text" name="title" id="elibTitle" class="form-control" required placeholder="Auto-fills from file name">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Category</label>
                    <select name="category" id="elibCategory" class="form-select">
                        <option value="mdcat">MDCAT</option>
                        <option value="nums">NUMS</option>
                        <option value="army">Army / AMC</option>
                        <option value="past-papers">Past Papers</option>
                        <option value="notes">Short Notes</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Subject</label>
                    <input type="text" name="subject" id="elibSubject" class="form-control" value="All Subjects">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Size</label>
                    <input type="text" name="size" id="elibSize" class="form-control" placeholder="Auto-detect">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Resource File <span class="text-muted fw-normal">(PDF/DOC/PPT/ZIP, max 20 MB)</span></label>
                    <input type="file" name="file" id="elibFile" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip">
                    <div class="form-text" style="font-size: 11.5px;">Title, subject, category, size and pages are filled automatically from the file.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Pages</label>
                    <input type="text" name="pages" id="elibPages" class="form-control" placeholder="Auto-detect">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Description</label>
                    <input type="text" name="description" class="form-control" placeholder="Brief overview of PDF study guide...">
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn-adm btn-adm-primary"><i class="fa-solid fa-floppy-disk"></i> Save Resource</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- E-Library Summary Table -->
<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-book-bookmark text-primary"></i>
            Resource Catalog ({{ count($resources) }})
        </h2>
        <span class="adm-badge adm-badge-primary">Database Synced</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Resource Details</th>
                    <th>Category</th>
                    <th>File Format &amp; Size</th>
                    <th>Total Downloads</th>
                    <th>Access Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $res)
                <tr>
                    <td>
                        <div class="item-thumb-box">
                            <div class="stat-icon info" style="width: 42px; height: 42px; font-size: 18px;">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div>
                                <div class="title">{{ $res['title'] ?? 'Resource Title' }}</div>
                                <div class="subtitle">{{ Str::limit($res['description'] ?? 'Study guide', 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-warning text-uppercase">{{ $res['category_name'] ?? ($res['category'] ?? 'Notes') }}</span>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">{{ $res['size'] ?? ($res['file_size'] ?? '4.2 MB') }}</span>
                        <div class="small text-muted">{{ $res['pages'] ?? '85 Pages' }} • {{ $res['format'] ?? 'PDF' }}</div>
                        @if (empty($res['file_path']))
                            <span class="adm-badge adm-badge-warning" style="font-size: 10.5px;">No file uploaded</span>
                        @endif
                    </td>
                    <td>
                        <span class="fw-bold text-primary">{{ $res['downloads'] ?? ($res['downloads_count'] ?? '2.5k+') }}</span>
                        <div class="small text-success"><i class="fa-solid fa-arrow-up"></i> Popular</div>
                    </td>
                    <td>
                        <span class="adm-badge adm-badge-success">Free Student Access</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('e-library.download', $res['slug'] ?? 'resource') }}" class="action-btn" title="Direct Download Stream">
                                <i class="fa-solid fa-download"></i>
                            </a>
                            <form action="{{ route('admin.elibrary.delete', $res['slug'] ?? 'resource') }}" method="POST" onsubmit="return confirm('Delete this resource?')">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('elibraryUploadForm');
    if (!form) return;

    var fileInput = document.getElementById('elibFile');
    var titleInput = document.getElementById('elibTitle');
    var categorySelect = document.getElementById('elibCategory');
    var subjectInput = document.getElementById('elibSubject');
    var sizeInput = document.getElementById('elibSize');
    var pagesInput = document.getElementById('elibPages');

    var auto = { title: '', subject: '', size: '', pages: '' };

    function setAuto(input, key, value, replaceable) {
        if (!value) return;

        var current = input.value.trim();
        var canReplace = !current || current === auto[key]
            || (replaceable && replaceable.indexOf(current) !== -1);

        if (canReplace) {
            input.value = value;
            auto[key] = value;
        }
    }

    function humanize(name) {
        return name.replace(/\.[^.]+$/, '')
            .replace(/[-_]+/g, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .replace(/\b\w/g, function (c) { return c.toUpperCase(); })
            .replace(/\b(mdcat|nums|amc|pmdc|mcqs|ecat|css|pdf|docx?|pptx?)\b/gi, function (m) {
                return m.toUpperCase();
            });
    }

    function formatSize(bytes) {
        if (!bytes) return '';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return Math.round(bytes / 1024) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function guessSubject(name) {
        var lower = name.toLowerCase();
        if (/bio/.test(lower)) return 'Biology';
        if (/chem/.test(lower)) return 'Chemistry';
        if (/phy/.test(lower)) return 'Physics';
        if (/english/.test(lower)) return 'English';
        if (/logic|reasoning/.test(lower)) return 'Logical Reasoning';
        if (/math/.test(lower)) return 'Mathematics';
        return 'All Subjects';
    }

    function guessCategory(name) {
        var lower = name.toLowerCase();
        if (/nums/.test(lower)) return 'nums';
        if (/army|amc/.test(lower)) return 'army';
        if (/past\s*paper|solved|papers?/.test(lower)) return 'past-papers';
        return null;
    }

    function detectPdfPages(file) {
        return new Promise(function (resolve) {
            var reader = new FileReader();
            reader.onload = function () {
                try {
                    var text = new TextDecoder('latin1').decode(new Uint8Array(reader.result));
                    var pageObjects = text.match(/\/Type\s*\/Page(?![s])/g);
                    var pages = pageObjects ? pageObjects.length : 0;

                    if (!pages) {
                        var counts = [];
                        var match;
                        var re = /\/Count\s+(\d+)/g;
                        while ((match = re.exec(text)) !== null) {
                            counts.push(parseInt(match[1], 10));
                        }
                        pages = counts.length ? Math.max.apply(null, counts) : 0;
                    }

                    resolve(pages);
                } catch (e) {
                    resolve(0);
                }
            };
            reader.onerror = function () { resolve(0); };
            reader.readAsArrayBuffer(file);
        });
    }

    fileInput.addEventListener('change', function () {
        var file = fileInput.files && fileInput.files[0];
        if (!file) return;

        setAuto(titleInput, 'title', humanize(file.name));
        setAuto(subjectInput, 'subject', guessSubject(file.name), ['All Subjects']);
        setAuto(sizeInput, 'size', formatSize(file.size));

        var category = guessCategory(file.name);
        if (category && !categorySelect.dataset.touched) {
            categorySelect.value = category;
        }

        if (/\.pdf$/i.test(file.name)) {
            pagesInput.placeholder = 'Detecting pages...';
            detectPdfPages(file).then(function (pages) {
                if (pages > 0) {
                    setAuto(pagesInput, 'pages', pages + ' Pages');
                }
                pagesInput.placeholder = 'Auto-detect';
            });
        }
    });

    categorySelect.addEventListener('change', function () {
        categorySelect.dataset.touched = '1';
    });
});
</script>
@endsection
