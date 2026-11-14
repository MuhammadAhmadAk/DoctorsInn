@extends('backend.layouts.master')

@section('title', 'MCQs · ' . $test->title)

@section('content')
@php
    $optOld = fn (string $key) => old('options.' . $key, $editing?->options[$key] ?? '');
@endphp

<div class="page-header">
    <div>
        <h1 class="page-title">Manage MCQs</h1>
        <p class="page-subtitle">{{ $test->title }} — {{ $questions->count() }} {{ Str::plural('question', $questions->count()) }} in the bank</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('test.take', $test->slug) }}" target="_blank" class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>Preview Test</span>
        </a>
        <a href="{{ route('admin.tests') }}" class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-arrow-left"></i>
            <span>All Tests</span>
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
<div class="alert alert-danger py-2 px-3 mb-3 border-0 rounded-3" style="font-size: 12.5px;">
    <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i>Please fix the following:</div>
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-3">
    <div class="col-xl-5">
        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid {{ $editing ? 'fa-pen-to-square' : 'fa-circle-plus' }} text-primary"></i>
                    {{ $editing ? 'Edit MCQ' : 'Add New MCQ' }}
                </h2>
                @if($editing)
                    <a href="{{ route('admin.tests.questions', $test->slug) }}" class="small text-decoration-none">Cancel edit</a>
                @endif
            </div>
            <div class="adm-card-body">
                <form action="{{ $editing ? route('admin.tests.questions.update', [$test->slug, $editing->id]) : route('admin.tests.questions.store', $test->slug) }}" method="POST">
                    @csrf
                    @if($editing)
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-8">
                            <label class="form-label small fw-bold">Subject</label>
                            <input type="text" name="subject" class="form-control" list="subjectOptions"
                                   value="{{ old('subject', $editing->subject ?? '') }}" placeholder="e.g. Biology">
                            <datalist id="subjectOptions">
                                <option value="Biology"></option>
                                <option value="Chemistry"></option>
                                <option value="Physics"></option>
                                <option value="English"></option>
                                <option value="Logical Reasoning"></option>
                            </datalist>
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-bold">Order</label>
                            <input type="number" name="sort_order" class="form-control" min="0"
                                   value="{{ old('sort_order', $editing->sort_order ?? '') }}" placeholder="Auto">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Question</label>
                            <textarea name="question" rows="3" class="form-control" required
                                      placeholder="Type the MCQ statement...">{{ old('question', $editing->question ?? '') }}</textarea>
                        </div>

                        @foreach(['A', 'B', 'C', 'D'] as $key)
                            <div class="col-12">
                                <label class="form-label small fw-bold">Option {{ $key }}</label>
                                <input type="text" name="options[{{ $key }}]" class="form-control" required
                                       value="{{ $optOld($key) }}" placeholder="Option {{ $key }} text">
                            </div>
                        @endforeach

                        <div class="col-6">
                            <label class="form-label small fw-bold">Correct Option</label>
                            <select name="correct_option" class="form-select" required>
                                @foreach(['A', 'B', 'C', 'D'] as $key)
                                    <option value="{{ $key }}" @selected(old('correct_option', $editing->correct_option ?? 'A') === $key)>{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Explanation <span class="text-muted fw-normal">(shown on the result page)</span></label>
                            <textarea name="explanation" rows="2" class="form-control"
                                      placeholder="Why is this the correct answer?">{{ old('explanation', $editing->explanation ?? '') }}</textarea>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn-adm btn-adm-primary">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>{{ $editing ? 'Update MCQ' : 'Add MCQ' }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-7">
        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-list-check text-primary"></i>
                    Question Bank ({{ $questions->count() }})
                </h2>
            </div>
            <div class="table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th style="width: 44px;">#</th>
                            <th>Question</th>
                            <th>Subject</th>
                            <th>Answer</th>
                            <th style="width: 92px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $index => $q)
                        <tr>
                            <td class="fw-bold text-dark">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ Str::limit($q->question, 90) }}</div>
                                <div class="small text-muted">
                                    {{ count($q->options ?? []) }} options ·
                                    {{ $q->explanation ? 'Explanation added' : 'No explanation' }}
                                </div>
                            </td>
                            <td><span class="adm-badge adm-badge-primary">{{ $q->subject }}</span></td>
                            <td><span class="adm-badge adm-badge-success">{{ $q->correct_option }}</span></td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.tests.questions', ['slug' => $test->slug, 'edit' => $q->id]) }}"
                                       class="action-btn" title="Edit MCQ">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.tests.questions.destroy', [$test->slug, $q->id]) }}"
                                          method="POST" onsubmit="return confirm('Delete this MCQ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Delete MCQ">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No MCQs yet. Add the first question using the form.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
