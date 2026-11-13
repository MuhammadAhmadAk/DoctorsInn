@extends('student.layouts.master')
@section('title', 'My Courses & Enrolled Batches — DoctorsInn Elite')

@section('extra_css')
<style>
    .course-portal-card {
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
    .course-portal-card:hover {
        border-color: #CBD5E1;
        box-shadow: var(--std-shadow-md);
    }
    .course-thumb-box {
        position: relative;
        height: 155px;
        background: #0f172a;
        overflow: hidden;
    }
    .course-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .course-badge-pill {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(15, 23, 42, 0.85);
        color: #F8FAFC;
        font-weight: 600;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .course-card-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
</style>
@endsection

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h5 fw-bold text-dark mb-1" style="letter-spacing: -0.015em;">My Enrolled Courses</h1>
            <p class="text-muted text-xs mb-0">Video lectures, syllabus curriculum, and live batch sessions</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('student.classroom') }}" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold" style="border-radius: 6px;">
                <i class="fa-solid fa-play text-xs"></i>
                <span>Resume Active Classroom</span>
            </a>
        </div>
    </div>

    {{-- Enrolled Courses Grid --}}
    <div class="row gy-4 mb-4">
        @forelse ($courses as $slug => $course)
            @php
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
                            {{ $course['badge'] ?? 'Active Batch' }}
                        </span>
                    </div>

                    {{-- Card Body --}}
                    <div class="course-card-body">
                        <div class="d-flex align-items-center justify-content-between text-xs text-muted mb-2">
                            <span><i class="fa-solid fa-stethoscope me-1 text-primary"></i> {{ $course['category'] ?? 'Medical Entry' }}</span>
                            <span>{{ $course['duration'] ?? '8 Weeks' }}</span>
                        </div>

                        <h2 class="fw-bold text-dark mb-2" style="font-size: 15px; line-height: 1.4; min-height: 42px;">
                            {{ $course['title'] }}
                        </h2>

                        {{-- Instructor --}}
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <img src="{{ asset($course['instructor_info']['image'] ?? $course['instructor_image'] ?? 'frontend/img/testimonial/testi_2_2.png') }}" alt="Instructor" style="width: 26px; height: 26px; border-radius: 50%; object-fit: cover;">
                            <span class="text-muted" style="font-size: 12px;">{{ $course['instructor_info']['name'] ?? $course['instructor'] ?? 'DoctorsInn Faculty' }}</span>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mt-auto">
                            <div class="d-flex align-items-center justify-content-between text-xs mb-1">
                                <span class="fw-semibold text-dark">{{ $progressPercent }}% Completed</span>
                                <span class="text-muted">{{ $completedLessons }}/{{ $totalLessons }} Lessons</span>
                            </div>
                            <div class="std-progress-track mb-3">
                                <div class="std-progress-fill" style="width: {{ $progressPercent }}%;"></div>
                            </div>

                            {{-- Enter Classroom CTA --}}
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('student.classroom', $slug) }}" class="btn btn-sm btn-primary w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2" style="border-radius: 6px;">
                                    <span>Enter Classroom</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                                <a href="{{ route('course-details', $slug) }}" target="_blank" class="btn btn-sm btn-light border py-2 px-3 text-muted" title="View Outline" style="border-radius: 6px;">
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
                    <h4 class="fw-bold text-dark">No Enrolled Courses Found</h4>
                    <p class="text-muted text-sm mb-4">Contact your academic coordinator to activate your enrollment.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Academic Advisory Banner (Clean, Minimal) --}}
    <div class="std-card p-4">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 8px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--std-text-title);">
                        <i class="fa-solid fa-user-doctor fs-5"></i>
                    </div>
                    <div>
                        <h3 class="h6 fw-bold text-dark mb-1">Need Timetable Planning or Subject Prioritization?</h3>
                        <p class="text-muted text-xs mb-0">Reach out to our academic desk for 1-on-1 guidance on MDCAT chapter weightage and time management.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="https://wa.me/923001234567?text=Hello%20DoctorsInn%2C%20I%20need%20academic%20mentorship." target="_blank" class="btn btn-sm btn-outline-success fw-semibold px-3 py-2" style="border-radius: 6px;">
                    <i class="fa-brands fa-whatsapp me-1"></i> Contact Mentor Desk
                </a>
            </div>
        </div>
    </div>

@endsection
