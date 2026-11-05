@extends('student.layouts.master')
@section('title', 'Student Profile & Settings — DoctorsInn Elite')

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">Student Profile &amp; Settings</h1>
            <p class="text-muted text-sm mb-0">Manage your contact details, target medical entrance exam, and account security.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2 rounded-pill" style="font-size: 12.5px;">
                <i class="fa-solid fa-user-check me-1"></i> Verified Medical Aspirant
            </span>
        </div>
    </div>

    {{-- Profile Overview Banner --}}
    <div class="std-card p-4 mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);">
        <div class="row align-items-center gy-3">
            <div class="col-md-7 d-flex align-items-center gap-3">
                <img src="{{ asset($studentData['avatar']) }}" alt="{{ $studentData['name'] }}" style="width: 72px; height: 72px; border-radius: 50%; border: 3px solid #5C32FF; object-fit: cover;">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <h2 class="h5 fw-bold text-dark mb-0">{{ $studentData['name'] }}</h2>
                        <span class="badge bg-primary px-2 py-1 text-xs fw-semibold">🎯 {{ $studentData['target_exam'] }} 2026</span>
                    </div>
                    <div class="text-muted text-xs mb-1">
                        <i class="fa-regular fa-envelope me-1"></i> {{ $studentData['email'] }}
                    </div>
                    <div class="text-muted text-xs">
                        <i class="fa-regular fa-calendar-check me-1"></i> Enrolled Member since {{ $studentData['joined_date'] }}
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-md-end">
                <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20am%20contacting%20regarding%20my%20student%20profile." target="_blank" class="btn btn-outline-success fw-semibold px-3 py-2 text-xs" style="border-radius: 8px;">
                    <i class="fa-brands fa-whatsapp me-1"></i> Coordinator Desk
                </a>
            </div>
        </div>
    </div>

    <div class="row gy-4">

        {{-- Left Column: Personal Information Form --}}
        <div class="col-lg-7">
            <div class="std-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                    <div>
                        <h3 class="h5 fw-bold text-dark mb-0">Personal &amp; Exam Information</h3>
                        <span class="text-muted text-xs">Update your display name, contact phone, and exam stream</span>
                    </div>
                    <i class="fa-solid fa-id-card text-primary fs-4"></i>
                </div>

                <form action="{{ route('student.settings.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="studentNameInput" class="form-label text-xs fw-bold text-dark mb-1">Full Student Name</label>
                        <input type="text" name="name" id="studentNameInput" class="form-control" value="{{ old('name', $studentData['name']) }}" required style="font-size: 13.5px; border-radius: 8px;">
                    </div>

                    <div class="mb-3">
                        <label for="studentEmailInput" class="form-label text-xs fw-bold text-dark mb-1">Account Email Address</label>
                        <input type="email" id="studentEmailInput" class="form-control bg-light text-muted" value="{{ $studentData['email'] }}" readonly style="font-size: 13.5px; border-radius: 8px;">
                        <span class="text-muted text-xs mt-1 d-block">
                            <i class="fa-solid fa-lock me-1"></i> Email address is linked to your Google / Enrollment ID and cannot be modified directly.
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="studentPhoneInput" class="form-label text-xs fw-bold text-dark mb-1">WhatsApp / Phone Number</label>
                        <input type="text" name="phone" id="studentPhoneInput" class="form-control" value="{{ old('phone', $studentData['phone']) }}" placeholder="+92 300 1234567" style="font-size: 13.5px; border-radius: 8px;">
                        <span class="text-muted text-xs mt-1 d-block">Required for important mock test schedules and PDF updates via WhatsApp.</span>
                    </div>

                    <div class="mb-4">
                        <label for="targetExamSelect" class="form-label text-xs fw-bold text-dark mb-1">Primary Target Medical Entrance Exam</label>
                        <select name="target_exam" id="targetExamSelect" class="form-select" style="font-size: 13.5px; border-radius: 8px;">
                            <option value="MDCAT" {{ strtoupper($studentData['target_exam']) === 'MDCAT' ? 'selected' : '' }}>MDCAT (PMDC National Medical &amp; Dental)</option>
                            <option value="NUMS" {{ strtoupper($studentData['target_exam']) === 'NUMS' ? 'selected' : '' }}>NUMS (National University of Medical Sciences)</option>
                            <option value="AMC" {{ strtoupper($studentData['target_exam']) === 'AMC' ? 'selected' : '' }}>Army Medical College (AMC / Armed Forces)</option>
                            <option value="AKU" {{ strtoupper($studentData['target_exam']) === 'AKU' ? 'selected' : '' }}>Aga Khan University Entrance (AKU)</option>
                        </select>
                    </div>

                    <div class="text-end pt-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold" style="border-radius: 8px; font-size: 13.5px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right Column: Security & Password + Academic Desk --}}
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-4">

                {{-- Change Password Form --}}
                <div class="std-card p-4">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <div>
                            <h3 class="h5 fw-bold text-dark mb-0">Update Password</h3>
                            <span class="text-muted text-xs">Set a new secure password for direct login</span>
                        </div>
                        <i class="fa-solid fa-key text-warning fs-4"></i>
                    </div>

                    <form action="{{ route('student.settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="name" value="{{ $studentData['name'] }}">
                        <input type="hidden" name="phone" value="{{ $studentData['phone'] }}">
                        <input type="hidden" name="target_exam" value="{{ $studentData['target_exam'] }}">

                        <div class="mb-3">
                            <label for="newPasswordInput" class="form-label text-xs fw-bold text-dark mb-1">New Password</label>
                            <input type="password" name="password" id="newPasswordInput" class="form-control" placeholder="Min. 6 characters" required style="font-size: 13.5px; border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="confirmPasswordInput" class="form-label text-xs fw-bold text-dark mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="confirmPasswordInput" class="form-control" placeholder="Re-type new password" required style="font-size: 13.5px; border-radius: 8px;">
                        </div>

                        <button type="submit" class="btn btn-warning w-100 py-2 fw-semibold text-dark" style="border-radius: 8px; font-size: 13.5px;">
                            <i class="fa-solid fa-shield-halved me-1"></i> Update Password
                        </button>
                    </form>
                </div>

                {{-- Academic Help Desk Box --}}
                <div class="std-card p-4" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); color: #ffffff;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(239, 172, 6, 0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-headset text-warning fs-5"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-white mb-0" style="font-size: 15px;">Student Support Hotline</h4>
                            <span class="text-white text-opacity-75 text-xs">Official DoctorsInn Academic Desk</span>
                        </div>
                    </div>
                    <p class="text-white text-opacity-75 text-xs mb-3">
                        Need assistance with test timings, roll number slips, batch transfers, or video lecture playback? Reach out anytime.
                    </p>
                    <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%20Academic%20Desk%2C%20I%20need%20student%20assistance." target="_blank" class="btn btn-success w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; font-size: 13px;">
                        <i class="fa-brands fa-whatsapp fs-5"></i>
                        <span>Chat on WhatsApp (+92 300 1234567)</span>
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection
