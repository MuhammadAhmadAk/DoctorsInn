@extends('student.layouts.master')
@section('title', 'My Courses & Enrolled Batches — DoctorsInn Elite')

@section('extra_css')
<style>
    .course-portal-card {
        background: #ffffff;
        border: 1px solid var(--std-border);
        border-radius: var(--std-radius-lg);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .course-portal-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(92, 50, 255, 0.08);
        border-color: rgba(92, 50, 255, 0.3);
    }
    .course-thumb-box {
        position: relative;
        height: 190px;
        background: #0f172a;
        overflow: hidden;
    }
    .course-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .course-portal-card:hover .course-thumb-box img {
        transform: scale(1.04);
    }
    .course-badge-pill {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(11, 14, 20, 0.85);
        backdrop-filter: blur(6px);
        color: #FBBF24;
        font-weight: 700;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid rgba(251, 191, 36, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .course-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .course-progress-bar {
        height: 6px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin: 10px 0 16px 0;
    }
    .course-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #5C32FF, #8b5cf6);
        border-radius: 10px;
    }
    .course-stat-chip {
        font-size: 12px;
        color: var(--std-text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        padding: 5px 10px;
        border-radius: 6px;
        border: 1px solid #edf2f7;
    }
</style>
@endsection

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h4 fw-bold text-dark mb-1">My Enrolled Courses &amp; Batches</h1>
            <p class="text-muted text-sm mb-0">Continue your medical syllabus, watch video lectures, and track completion progress.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('student.classroom') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold" style="font-size: 13.5px; border-radius: 10px;">
                <i class="fa-solid fa-play"></i>
                <span>Resume Active Classroom</span>
            </a>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="std-card p-3 mb-4">
        <div class="row align-items-center gy-2">
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge-status badge-status-primary px-3 py-2" style="font-size: 12px;">
                        <i class="fa-solid fa-graduation-cap me-1"></i> Active Enrolled ({{ count($courses) }})
                    </span>
                    <span class="badge-status badge-status-light px-3 py-2" style="font-size: 12px;">
                        <i class="fa-solid fa-stethoscope me-1 text-primary"></i> MDCAT / NUMS Track
                    </span>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <span class="text-muted" style="font-size: 12.5px;">
                    <i class="fa-solid fa-shield-check text-success me-1"></i> Full Access Active until MDCAT 2026 Examination
                </span>
            </div>
        </div>
    </div>

    {{-- Enrolled Courses Grid --}}
    <div class="row gy-4 mb-5">
        @forelse ($courses as $slug => $course)
            @php
                // Generate realistic syllabus progress
                $progressPercent = $loop->first ? 42 : ($loop->iteration == 2 ? 65 : 20);
                $totalLessons = count($course['curriculum'] ?? [1,2,3,4,5,6,7,8]);
                $completedLessons = (int) round(($progressPercent / 100) * $totalLessons);
            @endphp
            <div class="col-md-6 col-xl-4">
                <div class="course-portal-card">
                    {{-- Thumbnail & Badge --}}
                    <div class="course-thumb-box">
                        <img src="{{ asset($course['image'] ?? 'frontend/img/course/course1-1.jpg') }}" alt="{{ $course['title'] }}">
                        <span class="course-badge-pill">
                            <i class="fa-solid fa-bolt"></i>
                            <span>{{ $course['badge'] ?? 'PREP BATCH' }}</span>
                        </span>
                    </div>

                    {{-- Card Body --}}
                    <div class="course-card-body">
                        <div class="d-flex align-items-center justify-content-between text-xs text-muted mb-2">
                            <span><i class="fa-solid fa-graduation-cap text-primary me-1"></i> {{ $course['category'] ?? 'Medical Entry' }}</span>
                            <span><i class="fa-regular fa-clock me-1"></i> {{ $course['duration'] ?? '8 Weeks' }}</span>
                        </div>

                        <h3 class="fw-bold text-dark mb-2" style="font-size: 16px; line-height: 1.4; min-height: 44px;">
                            {{ $course['title'] }}
                        </h3>

                        {{-- Instructor --}}
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <img src="{{ asset($course['instructor_info']['image'] ?? $course['instructor_image'] ?? 'frontend/img/testimonial/testi_2_2.png') }}" alt="Instructor" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                            <span class="text-muted fw-semibold" style="font-size: 12.5px;">{{ $course['instructor_info']['name'] ?? $course['instructor'] ?? 'DoctorsInn Faculty' }}</span>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mt-auto">
                            <div class="d-flex align-items-center justify-content-between text-xs fw-bold mb-1">
                                <span style="color: #4338ca !important;">{{ $progressPercent }}% Syllabus Covered</span>
                                <span class="text-dark fw-bold">{{ $completedLessons }}/{{ $totalLessons }} Units</span>
                            </div>
                            <div class="std-progress-track mb-3">
                                <div class="std-progress-fill fill-primary" style="width: {{ $progressPercent }}%;"></div>
                            </div>
                            </div>

                            {{-- Chips --}}
                            <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                                <span class="course-stat-chip"><i class="fa-solid fa-circle-play text-primary"></i> Video Lectures</span>
                                <span class="course-stat-chip"><i class="fa-solid fa-file-lines text-warning"></i> Solved Notes</span>
                            </div>

                            {{-- Enter Classroom CTA --}}
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('student.classroom', $slug) }}" class="btn btn-primary w-100 py-2 fw-bold d-inline-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; font-size: 13.5px;">
                                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                    <span>Enter Classroom</span>
                                </a>
                                <a href="{{ route('course-details', $slug) }}" target="_blank" class="btn btn-light border py-2 px-3 text-secondary" title="View Syllabus Outline" style="border-radius: 8px;">
                                    <i class="fa-solid fa-circle-info"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="std-card text-center py-5">
                    <i class="fa-solid fa-folder-open text-muted mb-3" style="font-size: 48px;"></i>
                    <h4 class="fw-bold text-dark">No Enrolled Courses Found</h4>
                    <p class="text-muted text-sm mb-4">Contact your academic coordinator to activate your course enrollment key.</p>
                    <a href="https://wa.me/923001234567" target="_blank" class="btn btn-success px-4 py-2 fw-semibold">
                        <i class="fa-brands fa-whatsapp me-2"></i> WhatsApp Support
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Academic Advisory Banner --}}
    <div class="std-card p-4 border-primary border-opacity-25" style="background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(92, 50, 255, 0.12); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-user-doctor text-primary fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 16.5px;">Need Personalized Study Guidance or Fast-Track Revision?</h4>
                        <p class="text-muted text-sm mb-0">Our senior PMC faculty is available for 1-on-1 timetable planning, subject prioritization, and numerical tips.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20need%20academic%20mentorship%20for%20my%20courses." target="_blank" class="btn btn-outline-primary fw-bold px-4 py-2" style="border-radius: 8px; font-size: 13.5px;">
                    <i class="fa-brands fa-whatsapp me-2"></i> Talk to Mentor
                </a>
            </div>
        </div>
    </div>

@endsection
