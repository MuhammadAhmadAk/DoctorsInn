@extends('backend.layouts.master')

@section('title', 'Enrolled Students Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Enrolled Students & Candidates</h1>
        <p class="page-subtitle">Track student progress, enrolled batches, mock test scores, and account credentials.</p>
    </div>
    <div class="page-actions">
        <button class="btn-adm btn-adm-outline">
            <i class="fa-solid fa-file-excel"></i>
            <span>Export Roster</span>
        </button>
        <button class="btn-adm btn-adm-primary" onclick="alert('Manual Student Enrollment Form opened!')">
            <i class="fa-solid fa-user-plus"></i>
            <span>Enroll Student</span>
        </button>
    </div>
</div>

<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-users text-primary"></i>
            Student Directory (1,482 Active)
        </h2>
        <span class="adm-badge adm-badge-success">Session 2026</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Target Exam</th>
                    <th>Enrolled Course</th>
                    <th>Mock Tests Taken</th>
                    <th>Average Score</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $mockStudents = [
                    ['name' => 'Usman Tariq', 'email' => 'usman.tariq@gmail.com', 'exam' => 'MDCAT 2026', 'course' => 'MDCAT Reboot (60 Days)', 'tests' => 14, 'avg' => '91.2%', 'avatar' => 'team_2_1.jpg'],
                    ['name' => 'Ali Hassan', 'email' => 'ali.hassan@gmail.com', 'exam' => 'NUMS & AMC', 'course' => 'NUMS Medical Crash Prep', 'tests' => 11, 'avg' => '87.5%', 'avatar' => 'team_2_4.jpg'],
                    ['name' => 'Fahad Noor', 'email' => 'fahad.noor@yahoo.com', 'exam' => 'MDCAT 2026', 'course' => 'PMC High-Yield Mastery', 'tests' => 9, 'avg' => '84.0%', 'avatar' => 'team_2_1.jpg'],
                    ['name' => 'Hamza Malik', 'email' => 'hamza.malik@outlook.com', 'exam' => 'Army / AMC', 'course' => 'Army Medical College Elite', 'tests' => 16, 'avg' => '94.0%', 'avatar' => 'team_2_4.jpg'],
                    ['name' => 'Bilal Ahmed', 'email' => 'bilal.ahmed@gmail.com', 'exam' => 'MDCAT 2026', 'course' => 'MDCAT Comprehensive 2026', 'tests' => 6, 'avg' => '78.5%', 'avatar' => 'team_2_1.jpg'],
                ];
                @endphp

                @foreach($mockStudents as $st)
                <tr>
                    <td>
                        <div class="item-thumb-box">
                            <img src="{{ asset('frontend/img/team/' . $st['avatar']) }}" alt="Avatar">
                            <div>
                                <div class="title">{{ $st['name'] }}</div>
                                <div class="subtitle">{{ $st['email'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="adm-badge adm-badge-primary">{{ $st['exam'] }}</span></td>
                    <td><span class="fw-bold text-dark">{{ $st['course'] }}</span></td>
                    <td><span class="fw-bold text-dark">{{ $st['tests'] }} Tests</span></td>
                    <td><span class="fw-bold text-success">{{ $st['avg'] }}</span></td>
                    <td><span class="adm-badge adm-badge-success">Enrolled</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="#" class="action-btn" title="View Student Report" onclick="alert('Student Analytics for {{ $st['name'] }}')">
                                <i class="fa-solid fa-chart-line"></i>
                            </a>
                            <a href="#" class="action-btn" title="Send Email" onclick="alert('Message {{ $st['email'] }}')">
                                <i class="fa-regular fa-envelope"></i>
                            </a>
                            <a href="#" class="action-btn" title="Edit Access" onclick="alert('Editing permissions for {{ $st['name'] }}')">
                                <i class="fa-solid fa-user-pen"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
