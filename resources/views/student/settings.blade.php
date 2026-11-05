@extends('student.layouts.master')
@section('title', 'Student Profile & Settings — DoctorsInn Elite')

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h5 fw-bold text-dark mb-1" style="letter-spacing: -0.015em;">Profile &amp; Settings</h1>
            <p class="text-muted text-xs mb-0">Contact details, target medical entrance exam, and account security.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-status badge-status-success">
                <i class="fa-solid fa-check"></i> Enrolled Medical Aspirant
            </span>
        </div>
    </div>

    {{-- Profile Overview Card --}}
    <div class="std-card p-4 mb-4">
        <div class="row align-items-center gy-3">
            <div class="col-md-8 d-flex align-items-center gap-3">
                <img src="{{ asset($studentData['avatar']) }}" alt="{{ $studentData['name'] }}" style="width: 54px; height: 54px; border-radius: 50%; border: 1px solid var(--std-border); object-fit: cover;">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <h2 class="h6 fw-bold text-dark mb-0">{{ $studentData['name'] }}</h2>
                        <span class="badge-status badge-status-primary">{{ $studentData['target_exam'] }} 2026</span>
                    </div>
                    <div class="text-muted text-xs mb-1">
                        <i class="fa-regular fa-envelope me-1"></i> {{ $studentData['email'] }}
                    </div>
                    <div class="text-muted text-xs">
                        <i class="fa-regular fa-calendar-check me-1"></i> Enrolled since {{ $studentData['joined_date'] }}
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20am%20contacting%20regarding%20my%20student%20profile." target="_blank" class="btn btn-sm btn-outline-success fw-semibold px-3 py-2 text-xs" style="border-radius: 6px;">
                    <i class="fa-brands fa-whatsapp me-1"></i> Coordinator Desk
                </a>
            </div>
        </div>
    </div>

    <div class="row gy-4">

        {{-- Left Column: Personal Information Form --}}
        <div class="col-lg-7">
            <div class="std-card h-100">
                <div class="std-card-header">
                    <div>
                        <h3 class="h6 fw-bold text-dark mb-0">Personal Information</h3>
                        <span class="text-muted text-xs">Update your display name, phone, and target exam</span>
                    </div>
                    <i class="fa-regular fa-id-card text-muted"></i>
                </div>

                <form action="{{ route('student.settings.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="studentNameInput" class="form-label text-xs fw-semibold text-dark mb-1">Full Name</label>
                        <input type="text" name="name" id="studentNameInput" class="form-control" value="{{ old('name', $studentData['name']) }}" required style="font-size: 13px; border-radius: 6px;">
                    </div>

                    <div class="mb-3">
                        <label for="studentEmailInput" class="form-label text-xs fw-semibold text-dark mb-1">Email Address</label>
                        <input type="email" id="studentEmailInput" class="form-control bg-light text-muted" value="{{ $studentData['email'] }}" readonly style="font-size: 13px; border-radius: 6px;">
                        <span class="text-muted text-xs mt-1 d-block" style="font-size: 11px;">
                            Email is linked to your Google enrollment and cannot be modified directly.
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="studentPhoneInput" class="form-label text-xs fw-semibold text-dark mb-1">WhatsApp / Phone</label>
                        <input type="text" name="phone" id="studentPhoneInput" class="form-control" value="{{ old('phone', $studentData['phone']) }}" placeholder="+92 300 1234567" style="font-size: 13px; border-radius: 6px;">
                        <span class="text-muted text-xs mt-1 d-block" style="font-size: 11px;">Used for mock test alerts and PDF updates.</span>
                    </div>

                    <div class="mb-4">
                        <label for="targetExamSelect" class="form-label text-xs fw-semibold text-dark mb-1">Target Medical Entrance Exam</label>
                        <select name="target_exam" id="targetExamSelect" class="form-select" style="font-size: 13px; border-radius: 6px;">
                            <option value="MDCAT" {{ strtoupper($studentData['target_exam']) === 'MDCAT' ? 'selected' : '' }}>MDCAT (PMDC National Medical &amp; Dental)</option>
                            <option value="NUMS" {{ strtoupper($studentData['target_exam']) === 'NUMS' ? 'selected' : '' }}>NUMS (National University of Medical Sciences)</option>
                            <option value="AMC" {{ strtoupper($studentData['target_exam']) === 'AMC' ? 'selected' : '' }}>Army Medical College (AMC / Armed Forces)</option>
                            <option value="AKU" {{ strtoupper($studentData['target_exam']) === 'AKU' ? 'selected' : '' }}>Aga Khan University Entrance (AKU)</option>
                        </select>
                    </div>

                    <div class="text-end pt-1">
                        <button type="submit" class="btn btn-sm btn-primary px-3 py-2 fw-semibold" style="border-radius: 6px;">
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right Column: Security & Academic Desk --}}
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-4">

                {{-- Change Password Form --}}
                <div class="std-card">
                    <div class="std-card-header">
                        <div>
                            <h3 class="h6 fw-bold text-dark mb-0">Security</h3>
                            <span class="text-muted text-xs">Set a password for direct login</span>
                        </div>
                        <i class="fa-solid fa-key text-muted"></i>
                    </div>

                    <form action="{{ route('student.settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="name" value="{{ $studentData['name'] }}">
                        <input type="hidden" name="phone" value="{{ $studentData['phone'] }}">
                        <input type="hidden" name="target_exam" value="{{ $studentData['target_exam'] }}">

                        <div class="mb-3">
                            <label for="newPasswordInput" class="form-label text-xs fw-semibold text-dark mb-1">New Password</label>
                            <input type="password" name="password" id="newPasswordInput" class="form-control" placeholder="Min. 6 characters" required style="font-size: 13px; border-radius: 6px;">
                        </div>

                        <div class="mb-3">
                            <label for="confirmPasswordInput" class="form-label text-xs fw-semibold text-dark mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="confirmPasswordInput" class="form-control" placeholder="Re-type password" required style="font-size: 13px; border-radius: 6px;">
                        </div>

                        <button type="submit" class="btn btn-sm btn-light border w-100 py-2 fw-semibold text-dark" style="border-radius: 6px;">
                            Update Password
                        </button>
                    </form>
                </div>

                {{-- Academic Help Desk Box (Clean) --}}
                <div class="std-card p-4">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div style="width: 38px; height: 38px; border-radius: 8px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--std-text-title);">
                            <i class="fa-solid fa-headset fs-6"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-0" style="font-size: 14px;">Academic Coordinator Desk</h4>
                            <span class="text-muted" style="font-size: 11.5px;">Direct student support</span>
                        </div>
                    </div>
                    <p class="text-muted text-xs mb-3">
                        Need assistance with test timings, batch schedules, or lecture playback? Contact your coordinator.
                    </p>
                    <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%20Academic%20Desk%2C%20I%20need%20student%20assistance." target="_blank" class="btn btn-sm btn-outline-success w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2" style="border-radius: 6px;">
                        <i class="fa-brands fa-whatsapp fs-6"></i>
                        <span>WhatsApp (+92 300 1234567)</span>
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection
