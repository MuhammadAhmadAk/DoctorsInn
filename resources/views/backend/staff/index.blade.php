@extends('backend.layouts.master')

@section('title', 'Staff Access')

@section('extra_css')
<style>
    .staff-access-page {
        --staff-primary: #5C32FF;
        --staff-border: #E5E7EB;
        --staff-muted: #64748B;
        color: #1E293B;
        font-size: 12.5px;
    }
    .staff-access-page .page-header {
        margin-bottom: 16px;
    }
    .staff-access-page .page-title {
        font-size: 20px;
        margin-bottom: 3px;
    }
    .staff-access-page .page-subtitle {
        font-size: 12px;
        margin-bottom: 0;
    }
    .staff-access-page .btn-adm {
        border-radius: 8px;
        font-size: 12px;
        padding: 8px 12px;
    }
    .staff-access-page .preview-note {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        padding: 9px 12px;
        border: 1px solid #DCE7F8;
        border-radius: 8px;
        background: #F7FAFF;
        color: #52647D;
        font-size: 11.5px;
    }
    .staff-access-page .access-stat,
    .staff-access-page .staff-table-card {
        background: #FFFFFF;
        border: 1px solid var(--staff-border);
        border-radius: 8px;
    }
    .staff-access-page .access-stat {
        display: flex;
        align-items: center;
        gap: 11px;
        min-height: 76px;
        padding: 13px 15px;
    }
    .staff-access-page .stat-icon {
        display: grid;
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        place-items: center;
        border-radius: 8px;
        background: #F3F0FF;
        color: var(--staff-primary);
        font-size: 14px;
    }
    .staff-access-page .stat-label {
        margin-bottom: 2px;
        color: var(--staff-muted);
        font-size: 11px;
        font-weight: 600;
    }
    .staff-access-page .stat-value {
        color: #111827;
        font-size: 19px;
        font-weight: 700;
        line-height: 1.15;
    }
    .staff-access-page .staff-table-card {
        overflow: hidden;
    }
    .staff-access-page .table-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 15px;
        border-bottom: 1px solid var(--staff-border);
    }
    .staff-access-page .table-heading {
        margin: 0;
        color: #1E293B;
        font-size: 13px;
        font-weight: 700;
    }
    .staff-access-page .staff-filters {
        display: flex;
        gap: 4px;
        padding: 3px;
        border: 1px solid var(--staff-border);
        border-radius: 8px;
        background: #F8FAFC;
    }
    .staff-access-page .filter-tab {
        padding: 5px 10px;
        border: 0;
        border-radius: 6px;
        background: transparent;
        color: #64748B;
        font-size: 11.5px;
        font-weight: 600;
    }
    .staff-access-page .filter-tab.active {
        background: #FFFFFF;
        color: var(--staff-primary);
        box-shadow: 0 1px 2px rgba(15, 23, 42, .08);
    }
    .staff-access-page .staff-search {
        width: 200px;
        min-height: 32px;
        padding: 6px 9px;
        border: 1px solid var(--staff-border);
        border-radius: 7px;
        font-size: 11.5px;
    }
    .staff-access-page .table-responsive {
        min-height: 180px;
    }
    .staff-access-page .staff-table {
        width: 100%;
        min-width: 760px;
        margin: 0;
        border-collapse: collapse;
    }
    .staff-access-page .staff-table th {
        padding: 9px 14px;
        background: #F8FAFC;
        color: #64748B;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .035em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .staff-access-page .staff-table td {
        padding: 11px 14px;
        border-top: 1px solid #EEF1F5;
        vertical-align: middle;
        font-size: 11.5px;
    }
    .staff-access-page .staff-identity {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 185px;
    }
    .staff-access-page .staff-avatar {
        display: grid;
        width: 32px;
        height: 32px;
        flex: 0 0 32px;
        place-items: center;
        border-radius: 50%;
        background: #F1EDFF;
        color: #5630D9;
        font-size: 10px;
        font-weight: 700;
    }
    .staff-access-page .staff-name {
        display: block;
        color: #1E293B;
        font-size: 11.5px;
        font-weight: 700;
    }
    .staff-access-page .staff-id {
        display: block;
        margin-top: 2px;
        color: #8792A2;
        font-size: 10px;
    }
    .staff-access-page .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 20px;
        background: #F1EDFF;
        color: #5630D9;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }
    .staff-access-page .role-badge.staff {
        background: #EAF7F1;
        color: #16794B;
    }
    .staff-access-page .assignment-count {
        color: #334155;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }
    .staff-access-page .task-summary {
        min-width: 112px;
    }
    .staff-access-page .task-summary .progress {
        height: 4px;
        margin-top: 5px;
        border-radius: 8px;
        background: #EEF0F5;
    }
    .staff-access-page .task-summary .progress-bar {
        border-radius: 8px;
        background: var(--staff-primary);
    }
    .staff-access-page .assign-btn {
        padding: 6px 9px;
        border: 1px solid #DDD6FE;
        border-radius: 7px;
        background: #FFFFFF;
        color: #5630D9;
        font-size: 10.5px;
        font-weight: 700;
        white-space: nowrap;
    }
    .staff-access-page .assign-btn:hover {
        background: #F8F6FF;
    }
    .staff-access-page .empty-row {
        display: none;
        padding: 28px 12px;
        color: #64748B;
        text-align: center;
    }
    .staff-access-page .modal-content {
        border: 0;
        border-radius: 10px;
        box-shadow: 0 18px 50px rgba(15, 23, 42, .18);
    }
    .staff-access-page .modal-header {
        padding: 14px 18px;
        border-bottom: 1px solid #EEF1F5;
    }
    .staff-access-page .modal-title {
        color: #172033;
        font-size: 14px;
        font-weight: 700;
    }
    .staff-access-page .modal-body {
        padding: 14px 18px;
    }
    .staff-access-page .modal-footer {
        padding: 10px 18px;
        border-top: 1px solid #EEF1F5;
    }
    .staff-access-page .permission-meta {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #64748B;
        font-size: 11px;
    }
    .staff-access-page .permission-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 11px;
    }
    .staff-access-page .permission-actions {
        display: flex;
        gap: 6px;
    }
    .staff-access-page .permission-actions button {
        padding: 5px 8px;
        border: 1px solid var(--staff-border);
        border-radius: 6px;
        background: #FFFFFF;
        color: #475569;
        font-size: 10.5px;
        font-weight: 600;
    }
    .staff-access-page .permission-total {
        color: #64748B;
        font-size: 10.5px;
        white-space: nowrap;
    }
    .staff-access-page .permission-section {
        margin-bottom: 7px;
        overflow: hidden;
        border: 1px solid #E8EBF0;
        border-radius: 8px;
    }
    .staff-access-page .permission-section-head {
        display: flex;
        align-items: center;
        min-height: 40px;
        background: #FFFFFF;
    }
    .staff-access-page .section-open {
        display: flex;
        flex: 1;
        align-items: center;
        gap: 8px;
        min-width: 0;
        padding: 9px 11px;
        border: 0;
        background: transparent;
        color: #334155;
        text-align: left;
    }
    .staff-access-page .section-open i:first-child {
        width: 16px;
        color: #7252DB;
        text-align: center;
    }
    .staff-access-page .section-name {
        overflow: hidden;
        font-size: 11.5px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .staff-access-page .section-count {
        margin-left: auto;
        color: #778397;
        font-size: 10px;
        white-space: nowrap;
    }
    .staff-access-page .section-select {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0 11px;
        color: #64748B;
        font-size: 10px;
        white-space: nowrap;
    }
    .staff-access-page .permission-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 7px;
        padding: 10px;
        border-top: 1px solid #EEF1F5;
        background: #FBFCFE;
    }
    .staff-access-page .permission-option {
        display: flex;
        align-items: flex-start;
        gap: 7px;
        min-width: 0;
        margin: 0;
        padding: 7px 8px;
        border: 1px solid #E9EDF2;
        border-radius: 6px;
        background: #FFFFFF;
        color: #475569;
        font-size: 10.5px;
        line-height: 1.35;
        cursor: pointer;
    }
    .staff-access-page .permission-option input,
    .staff-access-page .section-select input {
        accent-color: var(--staff-primary);
    }
    .staff-access-page .permission-option input {
        flex: 0 0 auto;
        margin: 1px 0 0;
    }
    .staff-access-page .permission-kind {
        display: inline-block;
        margin-left: 3px;
        color: #8A94A4;
        font-size: 9px;
    }
    .staff-access-page .form-label {
        margin-bottom: 4px;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
    }
    .staff-access-page .form-control,
    .staff-access-page .form-select {
        min-height: 35px;
        border-color: #DDE3EA;
        border-radius: 7px;
        font-size: 11.5px;
    }
    .staff-access-page .modal .btn {
        border-radius: 7px;
        font-size: 11px;
        padding: 7px 11px;
    }
    .staff-access-page .preview-toast {
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 1090;
        display: none;
        max-width: min(360px, calc(100vw - 32px));
        padding: 10px 13px;
        border: 1px solid #DCE7F8;
        border-radius: 8px;
        background: #FFFFFF;
        color: #334155;
        font-size: 11.5px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, .12);
    }
    @media (max-width: 767.98px) {
        .staff-access-page .table-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }
        .staff-access-page .toolbar-controls {
            display: flex;
            width: 100%;
            flex-wrap: wrap;
            gap: 8px;
        }
        .staff-access-page .staff-search {
            flex: 1;
            width: auto;
        }
        .staff-access-page .permission-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .staff-access-page .permission-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }
    }
    @media (max-width: 420px) {
        .staff-access-page .permission-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $permissionSections = [
        ['id' => 'dashboard', 'name' => 'Dashboard', 'icon' => 'fa-chart-pie', 'actions' => [
            ['key' => 'view', 'label' => 'View dashboard', 'description' => 'Open the admin overview and summary metrics.', 'shared' => true],
            ['key' => 'export', 'label' => 'Export reports', 'description' => 'Download dashboard reports.', 'shared' => true],
        ]],
        ['id' => 'cms', 'name' => 'Website CMS', 'icon' => 'fa-pen-ruler', 'actions' => [
            ['key' => 'view', 'label' => 'View content', 'description' => 'View website content sections.', 'shared' => true],
            ['key' => 'edit', 'label' => 'Edit sections', 'description' => 'Update text, images, and section content.', 'shared' => true],
            ['key' => 'instructors', 'label' => 'Manage instructors', 'description' => 'Add, update, and remove instructor profiles.', 'shared' => false],
            ['key' => 'approve', 'label' => 'Approve testimonials', 'description' => 'Review and approve testimonials for publishing.', 'shared' => false],
        ]],
        ['id' => 'courses', 'name' => 'Courses', 'icon' => 'fa-graduation-cap', 'actions' => [
            ['key' => 'view', 'label' => 'View courses', 'description' => 'View course details and batches.', 'shared' => true],
            ['key' => 'create', 'label' => 'Create course', 'description' => 'Add a course and its initial details.', 'shared' => true],
            ['key' => 'edit', 'label' => 'Edit course', 'description' => 'Update course details and curriculum.', 'shared' => true],
            ['key' => 'delete', 'label' => 'Delete course', 'description' => 'Remove a course from the catalogue.', 'shared' => true],
            ['key' => 'upload', 'label' => 'Upload course media', 'description' => 'Upload lecture videos and course resources.', 'shared' => false],
        ]],
        ['id' => 'tests', 'name' => 'Mock Tests', 'icon' => 'fa-clipboard-check', 'actions' => [
            ['key' => 'view', 'label' => 'View tests', 'description' => 'View test series and questions.', 'shared' => true],
            ['key' => 'create', 'label' => 'Create test', 'description' => 'Create a test and add questions.', 'shared' => true],
            ['key' => 'edit', 'label' => 'Edit test', 'description' => 'Update a test and its questions.', 'shared' => true],
            ['key' => 'delete', 'label' => 'Delete test', 'description' => 'Remove a test from the portal.', 'shared' => true],
        ]],
        ['id' => 'elibrary', 'name' => 'E-Library', 'icon' => 'fa-book-bookmark', 'actions' => [
            ['key' => 'view', 'label' => 'View resources', 'description' => 'View study resources in the library.', 'shared' => true],
            ['key' => 'create', 'label' => 'Add resource', 'description' => 'Upload and publish a new resource.', 'shared' => true],
            ['key' => 'edit', 'label' => 'Edit resource', 'description' => 'Update resource details and files.', 'shared' => true],
            ['key' => 'delete', 'label' => 'Delete resource', 'description' => 'Remove a resource from the library.', 'shared' => true],
        ]],
        ['id' => 'blogs', 'name' => 'Blog Posts', 'icon' => 'fa-newspaper', 'actions' => [
            ['key' => 'view', 'label' => 'View posts', 'description' => 'View existing blog posts.', 'shared' => true],
            ['key' => 'create', 'label' => 'Create post', 'description' => 'Draft a new blog post.', 'shared' => true],
            ['key' => 'edit', 'label' => 'Edit post', 'description' => 'Update post content and metadata.', 'shared' => true],
            ['key' => 'publish', 'label' => 'Publish / unpublish', 'description' => 'Change the publication status of a post.', 'shared' => false],
            ['key' => 'delete', 'label' => 'Delete post', 'description' => 'Remove a post from the website.', 'shared' => true],
        ]],
        ['id' => 'students', 'name' => 'Students', 'icon' => 'fa-user-graduate', 'actions' => [
            ['key' => 'view', 'label' => 'View student records', 'description' => 'View student directory and profiles.', 'shared' => true],
            ['key' => 'edit', 'label' => 'Manage enrollments', 'description' => 'Update student course enrollments.', 'shared' => true],
            ['key' => 'export', 'label' => 'Export roster', 'description' => 'Download the student roster.', 'shared' => true],
            ['key' => 'status', 'label' => 'Toggle account status', 'description' => 'Activate or deactivate a student account.', 'shared' => false],
        ]],
        ['id' => 'settings', 'name' => 'Settings', 'icon' => 'fa-sliders', 'actions' => [
            ['key' => 'view', 'label' => 'View settings', 'description' => 'View platform configuration.', 'shared' => true],
            ['key' => 'edit', 'label' => 'Edit settings', 'description' => 'Update platform configuration.', 'shared' => true],
            ['key' => 'manage', 'label' => 'Manage platform data', 'description' => 'Manage global platform settings and data.', 'shared' => false],
        ]],
    ];

    $staffMembers = [
        ['id' => 'MGR-001', 'name' => 'Nadia Farooq', 'initials' => 'NF', 'role' => 'Management', 'email' => 'nadia@doctorsinn.pk', 'permissions' => [
            'dashboard' => ['view', 'export'], 'cms' => ['view', 'edit'], 'courses' => ['view', 'create', 'edit', 'upload'], 'tests' => ['view', 'create'], 'students' => ['view', 'export'],
        ]],
        ['id' => 'MGR-002', 'name' => 'Tahir Mahmood', 'initials' => 'TM', 'role' => 'Management', 'email' => 'tahir@doctorsinn.pk', 'permissions' => [
            'dashboard' => ['view'], 'courses' => ['view', 'edit'], 'tests' => ['view', 'create', 'edit'], 'elibrary' => ['view', 'create', 'edit'], 'blogs' => ['view', 'create', 'publish'],
        ]],
        ['id' => 'STF-001', 'name' => 'Ayesha Khan', 'initials' => 'AK', 'role' => 'Staff', 'email' => 'ayesha@doctorsinn.pk', 'permissions' => [
            'courses' => ['view', 'create', 'upload'],
        ]],
        ['id' => 'STF-002', 'name' => 'Bilal Raza', 'initials' => 'BR', 'role' => 'Staff', 'email' => 'bilal@doctorsinn.pk', 'permissions' => [
            'tests' => ['view', 'create', 'edit', 'delete'],
        ]],
        ['id' => 'STF-003', 'name' => 'Sara Ahmed', 'initials' => 'SA', 'role' => 'Staff', 'email' => 'sara@doctorsinn.pk', 'permissions' => [
            'elibrary' => ['view', 'create', 'edit'], 'blogs' => ['view', 'create'],
        ]],
        ['id' => 'STF-004', 'name' => 'Hamza Ali', 'initials' => 'HA', 'role' => 'Staff', 'email' => 'hamza@doctorsinn.pk', 'permissions' => [
            'students' => ['view', 'edit', 'export'],
        ]],
    ];

    $sectionCount = count($permissionSections);
    $taskCount = array_sum(array_map(fn ($section) => count($section['actions']), $permissionSections));
@endphp

<div class="staff-access-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Staff Access</h1>
            <p class="page-subtitle">Manage team roles and section-level responsibilities.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn-adm btn-adm-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="fa-solid fa-user-plus me-1"></i>
                Add Staff
            </button>
        </div>
    </div>

    <div class="preview-note" role="note">
        <i class="fa-solid fa-circle-info"></i>
        <span>Design preview only. Staff and permission changes are not saved.</span>
    </div>

    <div class="row g-2 mb-3">
        <div class="col-6 col-xl-3">
            <div class="access-stat">
                <div class="stat-icon"><i class="fa-solid fa-user-shield"></i></div>
                <div><div class="stat-label">Super Admin</div><div class="stat-value">1</div></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="access-stat">
                <div class="stat-icon"><i class="fa-solid fa-user-tie"></i></div>
                <div><div class="stat-label">Management</div><div class="stat-value">2</div></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="access-stat">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div><div class="stat-label">Employee Staff</div><div class="stat-value">4</div></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="access-stat">
                <div class="stat-icon"><i class="fa-solid fa-list-check"></i></div>
                <div><div class="stat-label">Sections / Tasks</div><div class="stat-value">{{ $sectionCount }} <span class="text-muted fw-normal">/ {{ $taskCount }}</span></div></div>
            </div>
        </div>
    </div>

    <section class="staff-table-card" aria-labelledby="staffTableTitle">
        <div class="table-toolbar">
            <h2 class="table-heading" id="staffTableTitle">Team Permissions</h2>
            <div class="toolbar-controls d-flex align-items-center gap-2">
                <div class="staff-filters" role="tablist" aria-label="Filter by role">
                    <button class="filter-tab active" type="button" data-role-filter="all" aria-pressed="true">All <span>6</span></button>
                    <button class="filter-tab" type="button" data-role-filter="Management" aria-pressed="false">Management <span>2</span></button>
                    <button class="filter-tab" type="button" data-role-filter="Staff" aria-pressed="false">Staff <span>4</span></button>
                </div>
                <input type="search" class="staff-search" id="staffSearch" placeholder="Search name or ID" aria-label="Search staff">
            </div>
        </div>
        <div class="table-responsive">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th scope="col">Staff name &amp; ID</th>
                        <th scope="col">Role</th>
                        <th scope="col">Active sections</th>
                        <th scope="col">Enabled tasks</th>
                        <th scope="col"><span class="visually-hidden">Actions</span></th>
                    </tr>
                </thead>
                <tbody id="staffTableBody">
                    @foreach ($staffMembers as $member)
                        @php
                            $activeSections = count($member['permissions']);
                            $enabledTasks = array_sum(array_map('count', $member['permissions']));
                            $progress = $taskCount > 0 ? round(($enabledTasks / $taskCount) * 100) : 0;
                        @endphp
                        <tr class="staff-row" data-role="{{ $member['role'] }}" data-search="{{ strtolower($member['name'] . ' ' . $member['id']) }}">
                            <td>
                                <div class="staff-identity">
                                    <span class="staff-avatar">{{ $member['initials'] }}</span>
                                    <span>
                                        <span class="staff-name">{{ $member['name'] }}</span>
                                        <span class="staff-id">{{ $member['id'] }}</span>
                                    </span>
                                </div>
                            </td>
                            <td><span class="role-badge {{ $member['role'] === 'Staff' ? 'staff' : '' }}">{{ $member['role'] }}</span></td>
                            <td><span class="assignment-count">{{ $activeSections }} / {{ $sectionCount }}</span></td>
                            <td>
                                <div class="task-summary">
                                    <span class="assignment-count">{{ $enabledTasks }} / {{ $taskCount }} tasks</span>
                                    <div class="progress" role="progressbar" aria-label="{{ $enabledTasks }} enabled tasks" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <button
                                    type="button"
                                    class="assign-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#permissionsModal"
                                    data-staff-id="{{ $member['id'] }}"
                                    data-staff-name="{{ $member['name'] }}"
                                    data-staff-role="{{ $member['role'] }}"
                                    data-permissions="{{ base64_encode(json_encode($member['permissions'])) }}"
                                >
                                    <i class="fa-solid fa-sliders me-1"></i> Assign Permissions
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    <tr id="emptyStaffRow"><td class="empty-row" colspan="5">No staff members match your search.</td></tr>
                </tbody>
            </table>
        </div>
    </section>
</div>

<div class="modal fade staff-access-page" id="permissionsModal" tabindex="-1" aria-labelledby="permissionsModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h2 class="modal-title" id="permissionsModalTitle">Assign Permissions</h2>
                    <div class="permission-meta mt-1">
                        <span id="permissionStaffName">Staff member</span>
                        <span aria-hidden="true">·</span>
                        <span id="permissionStaffId">ID</span>
                        <span class="role-badge" id="permissionStaffRole">Staff</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="permission-toolbar">
                    <div class="permission-actions">
                        <button type="button" id="selectAllPermissions">Select All</button>
                        <button type="button" id="clearAllPermissions">Clear All</button>
                    </div>
                    <div class="permission-total" id="permissionTotal">0 / {{ $taskCount }} tasks enabled</div>
                </div>
                <div class="accordion" id="permissionSections"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="savePermissionsPreview">Save Permissions</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade staff-access-page" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" id="addStaffForm">
            <div class="modal-header">
                <div>
                    <h2 class="modal-title" id="addStaffModalTitle">Add Staff Member</h2>
                    <div class="permission-meta mt-1">Create a Management or Staff account</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col-12">
                        <label class="form-label" for="newStaffName">Full name</label>
                        <input class="form-control" id="newStaffName" type="text" placeholder="e.g. Ayesha Khan" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="newStaffUsername">Username</label>
                        <input class="form-control" id="newStaffUsername" type="text" placeholder="ayesha.khan" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="newStaffEmail">Work email</label>
                        <input class="form-control" id="newStaffEmail" type="email" placeholder="name@doctorsinn.pk" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="newStaffRole">Role</label>
                        <select class="form-select" id="newStaffRole" required>
                            <option value="Staff">Employee Staff</option>
                            <option value="Management">Management / Sub-Admin</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="newStaffPassword">Temporary password</label>
                        <input class="form-control" id="newStaffPassword" type="password" placeholder="••••••••" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Staff</button>
            </div>
        </form>
    </div>
</div>

<div class="preview-toast" id="staffPreviewToast" role="status" aria-live="polite"></div>
@endsection

@section('extra_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sections = @json($permissionSections);
        const taskCount = {{ $taskCount }};
        const permissionModal = document.getElementById('permissionsModal');
        const sectionContainer = document.getElementById('permissionSections');
        const permissionTotal = document.getElementById('permissionTotal');
        const toast = document.getElementById('staffPreviewToast');
        let activeFilter = 'all';
        let currentMember = null;
        let toastTimer;

        function showPreviewMessage(message) {
            toast.textContent = message;
            toast.style.display = 'block';
            window.clearTimeout(toastTimer);
            toastTimer = window.setTimeout(function () {
                toast.style.display = 'none';
            }, 3200);
        }

        function getCheckedActions(sectionId) {
            return Array.from(sectionContainer.querySelectorAll('[data-section="' + sectionId + '"]:checked'))
                .map(function (checkbox) { return checkbox.value; });
        }

        function updatePermissionCounts() {
            let enabledCount = 0;
            sections.forEach(function (section) {
                const checked = getCheckedActions(section.id);
                enabledCount += checked.length;
                const countElement = document.getElementById('section-count-' + section.id);
                const sectionToggle = document.getElementById('section-select-' + section.id);
                countElement.textContent = checked.length + '/' + section.actions.length;
                sectionToggle.checked = checked.length === section.actions.length;
                sectionToggle.indeterminate = checked.length > 0 && checked.length < section.actions.length;
            });
            permissionTotal.textContent = enabledCount + ' / ' + taskCount + ' tasks enabled';
        }

        function renderPermissionSections(permissions) {
            sectionContainer.innerHTML = sections.map(function (section, index) {
                const actions = section.actions.map(function (action) {
                    const checked = (permissions[section.id] || []).includes(action.key) ? ' checked' : '';
                    const type = action.shared ? 'Common' : 'Section-specific';
                    return '<label class="permission-option" title="' + action.description.replace(/"/g, '&quot;') + '">' +
                        '<input type="checkbox" data-section="' + section.id + '" value="' + action.key + '"' + checked + '>' +
                        '<span>' + action.label + '<span class="permission-kind">' + type + '</span></span>' +
                    '</label>';
                }).join('');

                return '<div class="permission-section">' +
                    '<div class="permission-section-head">' +
                        '<button class="section-open" type="button" data-bs-toggle="collapse" data-bs-target="#permission-collapse-' + section.id + '" aria-expanded="' + (index === 0 ? 'true' : 'false') + '" aria-controls="permission-collapse-' + section.id + '">' +
                            '<i class="fa-solid ' + section.icon + '"></i><span class="section-name">' + section.name + '</span>' +
                            '<span class="section-count" id="section-count-' + section.id + '">0/' + section.actions.length + '</span>' +
                            '<i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size:9px"></i>' +
                        '</button>' +
                        '<label class="section-select"><input type="checkbox" id="section-select-' + section.id + '" data-select-section="' + section.id + '"> Select</label>' +
                    '</div>' +
                    '<div class="collapse ' + (index === 0 ? 'show' : '') + '" id="permission-collapse-' + section.id + '">' +
                        '<div class="permission-grid">' + actions + '</div>' +
                    '</div>' +
                '</div>';
            }).join('');
            updatePermissionCounts();
        }

        function filterStaff() {
            const query = document.getElementById('staffSearch').value.trim().toLowerCase();
            let visibleCount = 0;
            document.querySelectorAll('.staff-row').forEach(function (row) {
                const matchesRole = activeFilter === 'all' || row.dataset.role === activeFilter;
                const matchesQuery = row.dataset.search.includes(query);
                const isVisible = matchesRole && matchesQuery;
                row.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });
            document.getElementById('emptyStaffRow').style.display = visibleCount ? 'none' : '';
            document.querySelector('#emptyStaffRow .empty-row').style.display = visibleCount ? 'none' : 'table-cell';
        }

        document.querySelectorAll('[data-role-filter]').forEach(function (button) {
            button.addEventListener('click', function () {
                activeFilter = button.dataset.roleFilter;
                document.querySelectorAll('[data-role-filter]').forEach(function (tab) {
                    const isActive = tab === button;
                    tab.classList.toggle('active', isActive);
                    tab.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                });
                filterStaff();
            });
        });
        document.getElementById('staffSearch').addEventListener('input', filterStaff);

        permissionModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button || !button.dataset.staffId) return;
            currentMember = button;
            document.getElementById('permissionStaffName').textContent = button.dataset.staffName;
            document.getElementById('permissionStaffId').textContent = button.dataset.staffId;
            const roleBadge = document.getElementById('permissionStaffRole');
            roleBadge.textContent = button.dataset.staffRole;
            roleBadge.classList.toggle('staff', button.dataset.staffRole === 'Staff');
            renderPermissionSections(JSON.parse(atob(button.dataset.permissions)));
        });

        sectionContainer.addEventListener('change', function (event) {
            if (event.target.matches('[data-select-section]')) {
                const sectionId = event.target.dataset.selectSection;
                sectionContainer.querySelectorAll('[data-section="' + sectionId + '"]').forEach(function (checkbox) {
                    checkbox.checked = event.target.checked;
                });
            }
            updatePermissionCounts();
        });

        document.getElementById('selectAllPermissions').addEventListener('click', function () {
            sectionContainer.querySelectorAll('[data-section]').forEach(function (checkbox) {
                checkbox.checked = true;
            });
            updatePermissionCounts();
        });
        document.getElementById('clearAllPermissions').addEventListener('click', function () {
            sectionContainer.querySelectorAll('[data-section]').forEach(function (checkbox) {
                checkbox.checked = false;
            });
            updatePermissionCounts();
        });
        document.getElementById('savePermissionsPreview').addEventListener('click', function () {
            showPreviewMessage(currentMember
                ? 'Preview only — changes for ' + currentMember.dataset.staffName + ' were not saved.'
                : 'Preview only — changes were not saved.');
        });
        document.getElementById('addStaffForm').addEventListener('submit', function (event) {
            event.preventDefault();
            showPreviewMessage('Preview only — the staff account was not created.');
        });

        filterStaff();
    });
</script>
@endsection
