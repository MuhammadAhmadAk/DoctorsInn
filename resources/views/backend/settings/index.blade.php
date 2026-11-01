@extends('backend.layouts.master')

@section('title', 'Platform Settings')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Platform & Academy Settings</h1>
        <p class="page-subtitle">Configure medical examination policies, contact hotlines, payment instructions, and SEO.</p>
    </div>
    <div class="page-actions">
        <button class="btn-adm btn-adm-primary" onclick="alert('Platform Settings saved successfully!')">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Save All Settings</span>
        </button>
    </div>
</div>

<div class="row g-3">
    <!-- General Settings -->
    <div class="col-lg-6">
        <div class="adm-card h-100">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-sliders text-primary"></i>
                    Academy Contact & Hotline
                </h2>
            </div>
            <div class="adm-card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Platform Name</label>
                    <input type="text" class="form-control py-2" value="DoctorsInn Elite Medical Prep">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Official WhatsApp Helpline</label>
                    <input type="text" class="form-control py-2" value="+92 300 1234567">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Official Email Address</label>
                    <input type="email" class="form-control py-2" value="info@doctorsinnelite.com">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Campus Address</label>
                    <textarea class="form-control" rows="2">DoctorsInn Main Campus, Medical Enclave, Lahore, Pakistan</textarea>
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
                        <label class="form-check-label small" for="showExp">Display detailed rationales & textbook references immediately</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
