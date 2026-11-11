@extends('backend.layouts.master')

@section('title', 'Platform Settings')

@section('content')
<form action="{{ route('admin.settings.save') }}" method="POST">
    @csrf
    <div class="page-header">
        <div>
            <h1 class="page-title">Platform &amp; Academy Settings</h1>
            <p class="page-subtitle">Configure medical examination policies, contact hotlines, payment instructions, and SEO.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.cms') }}" class="btn-adm btn-adm-outline">
                <i class="fa-solid fa-pen-ruler"></i>
                <span>Website CMS &amp; Images</span>
            </a>
            <button type="submit" class="btn-adm btn-adm-primary">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save All Settings</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: #10B981; font-size: 12.5px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="row g-3">
        <!-- General Settings -->
        <div class="col-lg-6">
            <div class="adm-card h-100">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-sliders text-primary"></i>
                        Academy Contact &amp; Hotline
                    </h2>
                </div>
                <div class="adm-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Platform Name</label>
                        <input type="text" name="site_name" class="form-control py-2" value="{{ $cms['site_name'] ?? 'DoctorsInnElite' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Official Helpline Phone</label>
                        <input type="text" name="contact_phone_1" class="form-control py-2" value="{{ $cms['contact_phone_1'] ?? '+92 300 1234567' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">WhatsApp Number (digits only)</label>
                        <input type="text" name="whatsapp_number" class="form-control py-2" value="{{ $cms['whatsapp_number'] ?? '923001234567' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Official Email Address</label>
                        <input type="email" name="contact_email_1" class="form-control py-2" value="{{ $cms['contact_email_1'] ?? 'info@doctorsinnelite.com' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Campus Address</label>
                        <textarea name="contact_address" class="form-control" rows="2">{{ $cms['contact_address'] ?? 'DoctorsInn Main Campus, Lahore, Pakistan' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Policy Settings -->
        <div class="col-lg-6">
            <div class="adm-card h-100">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-graduation-cap text-warning"></i>
                        Mock Exam Engine Defaults
                    </h2>
                </div>
                <div class="adm-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Default Passing Threshold (%)</label>
                        <input type="number" class="form-control py-2" value="70">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Negative Marking Policy</label>
                        <select class="form-select py-2">
                            <option value="none" selected>No Negative Marking (Standard MDCAT)</option>
                            <option value="nums">NUMS Standard (-0.25 mark per wrong answer)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Test Access Control</label>
                        <select class="form-select py-2">
                            <option value="login_required" selected>Enforce Student Login to Attempt</option>
                            <option value="open">Open Access (Public Demo)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Auto-Show Explanation After Submission</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="showExp" checked>
                            <label class="form-check-label small" for="showExp">Display detailed rationales &amp; textbook references immediately</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
