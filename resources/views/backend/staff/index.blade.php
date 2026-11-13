@extends('backend.layouts.master')

@section('title', 'Staff Access')

@section('extra_css')
<style>
    .staff-access {
        --staff-primary: var(--adm-primary, #5C32FF);
        --staff-border: var(--adm-border-color, #E2E8F0);
        color: var(--adm-title-color, #0F172A);
        font-size: 12px;
    }
    .staff-access .page-header {
        margin-bottom: 14px;
    }
    .staff-access .page-title {
        font-size: 18px;
    }
    .staff-access .page-subtitle {
        font-size: 11.5px;
    }
    .staff-access .btn-adm {
        padding: 6px 10px;
        font-size: 11px;
    }
    .staff-access .preview-note {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 12px;
        padding: 8px 10px;
        border: 1px solid #DCE7F8;
        border-radius: 7px;
        background: #F7FAFF;
        color: #52647D;
        font-size: 10.5px;
    }
    .staff-access .access-stat,
    .staff-access .staff-table-card {
        border: 1px solid var(--staff-border);
        border-radius: 8px;
        background: #FFFFFF;
        box-shadow: var(--adm-shadow, 0 1px 3px rgba(0, 0, 0, .04));
    }
    .staff-access .access-stat {
        display: flex;
        min-height: 68px;
        align-items: center;
        gap: 9px;
        padding: 10px 12px;
    }
    .staff-access .stat-icon {
        display: grid;
        width: 32px;
        height: 32px;
        flex: 0 0 32px;
        place-items: center;
        border-radius: 7px;
        background: var(--adm-primary-light, #F1EDFF);
        color: var(--staff-primary);
        font-size: 13px;
    }
    .staff-access .stat-label {
        margin-bottom: 2px;
        color: var(--adm-text-muted, #64748B);
        font-size: 10px;
        font-weight: 600;
    }
    .staff-access .stat-value {
        color: var(--adm-title-color, #0F172A);
        font-size: 17px;
        font-weight: 700;
        line-height: 1.1;
    }
    .staff-access .stat-value small {
        color: var(--adm-text-muted, #64748B);
        font-size: 11px;
        font-weight: 500;
    }
    .staff-access .table-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 12px;
        border-bottom: 1px solid var(--staff-border);
    }
    .staff-access .table-heading {
        margin: 0;
        color: var(--adm-title-color, #0F172A);
        font-size: 12.5px;
        font-weight: 700;
    }
    .staff-access .toolbar-controls {
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .staff-access .staff-filters {
        display: flex;
        gap: 2px;
        padding: 2px;
        border: 1px solid var(--staff-border);
        border-radius: 6px;
        background: #F8FAFC;
    }
    .staff-access .filter-tab {
        padding: 4px 8px;
        border: 0;
        border-radius: 4px;
        background: transparent;
        color: var(--adm-text-muted, #64748B);
        font-size: 10.5px;
        font-weight: 600;
    }
    .staff-access .filter-tab.active {
        background: #FFFFFF;
        color: var(--staff-primary);
        box-shadow: 0 1px 2px rgba(15, 23, 42, .08);
    }
    .staff-access .staff-search {
        width: 165px;
        height: 29px;
        padding: 4px 8px;
        border: 1px solid var(--staff-border);
        border-radius: 6px;
        font-size: 10.5px;
    }
    .staff-access .table-responsive {
        max-height: calc(100vh - 330px);
        min-height: 150px;
    }
    .staff-access .staff-table {
        width: 100%;
        min-width: 1150px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }
    .staff-access .staff-table th {
        position: sticky;
        top: 0;
        z-index: 2;
        padding: 8px 9px;
        border-bottom: 1px solid var(--staff-border);
        background: #F7F8FC;
        color: var(--adm-text-muted, #64748B);
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .025em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .staff-access .staff-table th:first-child,
    .staff-access .staff-table td:first-child {
        position: sticky;
        left: 0;
        z-index: 1;
        background: #FFFFFF;
    }
    .staff-access .staff-table th:first-child {
        z-index: 3;
        background: #F7F8FC;
    }
    .staff-access .staff-table td {
        padding: 8px 9px;
        border-bottom: 1px solid #EEF1F5;
        vertical-align: middle;
        font-size: 10.5px;
    }
    .staff-access .staff-table tbody tr:last-child td {
        border-bottom: 0;
    }
    .staff-access .staff-table tbody tr:hover td {
        background: #FAFAFD;
    }
    .staff-access .staff-table tbody tr:hover td:first-child {
        background: #FAFAFD;
    }
    .staff-access .identity-column {
        width: 165px;
        min-width: 165px;
    }
    .staff-access .role-column {
        width: 105px;
        min-width: 105px;
    }
    .staff-access .section-column {
        width: 165px;
        min-width: 165px;
    }
    .staff-access .staff-identity {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .staff-access .staff-avatar {
        display: grid;
        width: 29px;
        height: 29px;
        flex: 0 0 29px;
        place-items: center;
        border-radius: 50%;
        background: var(--adm-primary-light, #F1EDFF);
        color: var(--staff-primary);
        font-size: 9px;
        font-weight: 700;
    }
    .staff-access .staff-name {
        display: block;
        color: #1E293B;
        font-size: 10.5px;
        font-weight: 700;
        white-space: nowrap;
    }
    .staff-access .staff-id {
        display: block;
        margin-top: 1px;
        color: #8792A2;
        font-size: 9px;
    }
    .staff-access .role-badge {
        display: inline-flex;
        padding: 3px 6px;
        border-radius: 4px;
        background: var(--adm-primary-light, #F1EDFF);
        color: var(--staff-primary);
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }
    .staff-access .role-badge.staff {
        background: var(--adm-success-light, #EAF7F1);
        color: #16794B;
    }
    .staff-access .permission-list {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .staff-access .permission-check {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        width: fit-content;
        margin: 0;
        color: #475569;
        font-size: 9.5px;
        line-height: 1.2;
        cursor: pointer;
        white-space: nowrap;
    }
    .staff-access .permission-check input {
        width: 12px;
        height: 12px;
        margin: 0;
        accent-color: var(--staff-primary);
        cursor: pointer;
    }
    .staff-access .permission-check input:focus-visible,
    .staff-access .filter-tab:focus-visible {
        outline: 2px solid rgba(92, 50, 255, .35);
        outline-offset: 2px;
    }
    .staff-access .empty-row {
        padding: 24px;
        color: var(--adm-text-muted, #64748B);
        text-align: center;
    }
    .staff-access .save-button {
        padding: 5px 9px;
        border: 0;
        border-radius: 6px;
        background: var(--staff-primary);
        color: #FFFFFF;
        font-size: 10.5px;
        font-weight: 600;
    }
    .staff-access .staff-modal .modal-content {
        border: 1px solid var(--staff-border);
        border-radius: 9px;
    }
    .staff-access .staff-modal .modal-header,
    .staff-access .staff-modal .modal-footer {
        padding: 10px 14px;
    }
    .staff-access .staff-modal .modal-body {
        padding: 12px 14px;
    }
    .staff-access .staff-modal .modal-title {
        font-size: 13px;
        font-weight: 700;
    }
    .staff-access .staff-modal .form-label {
        margin-bottom: 3px;
        color: #475569;
        font-size: 10.5px;
        font-weight: 600;
    }
    .staff-access .staff-modal .form-control,
    .staff-access .staff-modal .form-select {
        min-height: 32px;
        border-color: #DDE3EA;
        border-radius: 6px;
        font-size: 10.5px;
    }
    .staff-access .staff-modal .btn {
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 10.5px;
    }
    .staff-access .preview-toast {
        position: fixed;
        right: 18px;
        bottom: 18px;
        z-index: 1090;
        display: none;
        padding: 9px 12px;
        border: 1px solid var(--staff-border);
        border-radius: 7px;
        background: #FFFFFF;
        color: #334155;
        font-size: 10.5px;
        box-shadow: var(--adm-shadow, 0 1px 3px rgba(0, 0, 0, .04));
    }
    @media (max-width: 767.98px) {
        .staff-access .table-toolbar,
        .staff-access .toolbar-controls {
            align-items: flex-start;
            flex-direction: column;
        }
        .staff-access .toolbar-controls,
        .staff-access .staff-search {
            width: 100%;
        }
        .staff-access .table-responsive {
            max-height: none;
        }
    }
</style>
@endsection

@section('content')
@php
    $permissionSections = [
        ['id' => 'cms', 'name' => 'Website CMS', 'icon' => 'fa-pen-ruler', 'actions' => ['view' => 'View', 'edit' => 'Edit', 'instructors' => 'Instructors', 'approve' => 'Approve']],
        ['id' => 'courses', 'name' => 'Courses', 'icon' => 'fa-graduation-cap', 'actions' => ['view' => 'View', 'create' => 'Create', 'edit' => 'Edit', 'delete' => 'Delete', 'upload' => 'Upload']],
        ['id' => 'tests', 'name' => 'Mock Tests', 'icon' => 'fa-clipboard-check', 'actions' => ['view' => 'View', 'create' => 'Create', 'edit' => 'Edit', 'delete' => 'Delete']],
        ['id' => 'elibrary', 'name' => 'E-Library', 'icon' => 'fa-book-bookmark', 'actions' => ['view' => 'View', 'create' => 'Add', 'edit' => 'Edit', 'delete' => 'Delete']],
        ['id' => 'blogs', 'name' => 'Blog Posts', 'icon' => 'fa-newspaper', 'actions' => ['view' => 'View', 'create' => 'Create', 'edit' => 'Edit', 'publish' => 'Publish', 'delete' => 'Delete']],
        ['id' => 'students', 'name' => 'Students', 'icon' => 'fa-user-graduate', 'actions' => ['view' => 'View', 'edit' => 'Enrollment', 'export' => 'Export', 'status' => 'Status']],
    ];

    $staffMembers = [
        ['id' => 'MGR-001', 'name' => 'Nadia Farooq', 'initials' => 'NF', 'role' => 'Management', 'permissions' => [
            'cms' => ['view', 'edit'], 'courses' => ['view', 'create', 'edit', 'upload'], 'tests' => ['view', 'create'], 'students' => ['view', 'export'],
        ]],
        ['id' => 'MGR-002', 'name' => 'Tahir Mahmood', 'initials' => 'TM', 'role' => 'Management', 'permissions' => [
            'courses' => ['view', 'edit'], 'tests' => ['view', 'create', 'edit'], 'elibrary' => ['view', 'create', 'edit'], 'blogs' => ['view', 'create', 'publish'],
        ]],
        ['id' => 'STF-001', 'name' => 'Ayesha Khan', 'initials' => 'AK', 'role' => 'Staff', 'permissions' => [
            'courses' => ['view', 'create', 'upload'],
        ]],
        ['id' => 'STF-002', 'name' => 'Bilal Raza', 'initials' => 'BR', 'role' => 'Staff', 'permissions' => [
            'tests' => ['view', 'create', 'edit', 'delete'],
        ]],
        ['id' => 'STF-003', 'name' => 'Sara Ahmed', 'initials' => 'SA', 'role' => 'Staff', 'permissions' => [
            'elibrary' => ['view', 'create', 'edit'], 'blogs' => ['view', 'create'],
        ]],
        ['id' => 'STF-004', 'name' => 'Hamza Ali', 'initials' => 'HA', 'role' => 'Staff', 'permissions' => [
            'students' => ['view', 'edit', 'export'],
        ]],
    ];

    $sectionCount = count($permissionSections);
    $taskCount = array_sum(array_map(fn ($section) => count($section['actions']), $permissionSections));
    $managementCount = count(array_filter($staffMembers, fn ($member) => $member['role'] === 'Management'));
    $employeeCount = count(array_filter($staffMembers, fn ($member) => $member['role'] === 'Staff'));
@endphp

<div class="staff-access">
    <div class="page-header">
        <div>
            <h1 class="page-title">Staff Access</h1>
            <p class="page-subtitle">Assign team permissions by section.</p>
        </div>
        <div class="page-actions">
            <button type="button" class="btn-adm btn-adm-outline" id="savePermissions">
                <i class="fa-solid fa-check"></i> Save Changes
            </button>
            <button type="button" class="btn-adm btn-adm-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="fa-solid fa-user-plus"></i> Add Staff
            </button>
        </div>
    </div>

    <div class="preview-note" role="note">
        <i class="fa-solid fa-circle-info"></i>
        <span>Preview only — permission and staff changes are not saved.</span>
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
                <div><div class="stat-label">Management</div><div class="stat-value">{{ $managementCount }}</div></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="access-stat">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div><div class="stat-label">Employee Staff</div><div class="stat-value">{{ $employeeCount }}</div></div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="access-stat">
                <div class="stat-icon"><i class="fa-solid fa-list-check"></i></div>
                <div><div class="stat-label">Sections / Tasks</div><div class="stat-value">{{ $sectionCount }} <small>/ {{ $taskCount }}</small></div></div>
            </div>
        </div>
    </div>

    <section class="staff-table-card" aria-labelledby="staffTableTitle">
        <div class="table-toolbar">
            <h2 class="table-heading" id="staffTableTitle">Team Permissions</h2>
            <div class="toolbar-controls">
                <div class="staff-filters" role="group" aria-label="Filter staff by role">
                    <button class="filter-tab active" type="button" data-role-filter="all" aria-pressed="true">All <span>{{ count($staffMembers) }}</span></button>
                    <button class="filter-tab" type="button" data-role-filter="Management" aria-pressed="false">Management <span>{{ $managementCount }}</span></button>
                    <button class="filter-tab" type="button" data-role-filter="Staff" aria-pressed="false">Staff <span>{{ $employeeCount }}</span></button>
                </div>
                <input type="search" class="staff-search" id="staffSearch" placeholder="Search name or ID" aria-label="Search staff">
            </div>
        </div>
        <div class="table-responsive">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th class="identity-column" scope="col">Staff name &amp; ID</th>
                        <th class="role-column" scope="col">Role</th>
                        @foreach ($permissionSections as $section)
                            <th class="section-column" scope="col">
                                <i class="fa-solid {{ $section['icon'] }} me-1 text-primary"></i>{{ $section['name'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staffMembers as $member)
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
                            @foreach ($permissionSections as $section)
                                <td>
                                    <div class="permission-list">
                                        @foreach ($section['actions'] as $actionKey => $actionLabel)
                                            <label class="permission-check" title="{{ $section['name'] }}: {{ $actionLabel }}">
                                                <input
                                                    type="checkbox"
                                                    data-section="{{ $section['id'] }}"
                                                    data-action="{{ $actionKey }}"
                                                    aria-label="{{ $section['name'] }}: {{ $actionLabel }}"
                                                    {{ in_array($actionKey, $member['permissions'][$section['id']] ?? [], true) ? 'checked' : '' }}
                                                >
                                                <span>{{ $actionLabel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr id="emptyStaffRow" hidden>
                        <td class="empty-row" colspan="{{ $sectionCount + 2 }}">No staff members match your search.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>

<div class="modal fade staff-access staff-modal" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" id="addStaffForm">
            <div class="modal-header">
                <div>
                    <h2 class="modal-title" id="addStaffModalTitle">Add Staff Member</h2>
                    <div class="small text-muted">Create a Management or Staff account</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col-12">
                        <label class="form-label" for="newStaffName">Full name</label>
                        <input class="form-control" id="newStaffName" type="text" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="newStaffUsername">Username</label>
                        <input class="form-control" id="newStaffUsername" type="text" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="newStaffEmail">Work email</label>
                        <input class="form-control" id="newStaffEmail" type="email" required>
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
                        <input class="form-control" id="newStaffPassword" type="password" required>
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
        const toast = document.getElementById('staffPreviewToast');
        let activeFilter = 'all';
        let toastTimer;

        function showPreviewMessage(message) {
            toast.textContent = message;
            toast.style.display = 'block';
            window.clearTimeout(toastTimer);
            toastTimer = window.setTimeout(function () {
                toast.style.display = 'none';
            }, 3000);
        }

        function filterStaff() {
            const query = document.getElementById('staffSearch').value.trim().toLowerCase();
            const rows = Array.from(document.querySelectorAll('.staff-row'));
            let visibleCount = 0;

            rows.forEach(function (row) {
                const matchesRole = activeFilter === 'all' || row.dataset.role === activeFilter;
                const matchesQuery = row.dataset.search.includes(query);
                const visible = matchesRole && matchesQuery;
                row.hidden = !visible;
                if (visible) visibleCount++;
            });

            document.getElementById('emptyStaffRow').hidden = visibleCount > 0;
        }

        document.querySelectorAll('[data-role-filter]').forEach(function (button) {
            button.addEventListener('click', function () {
                activeFilter = button.dataset.roleFilter;
                document.querySelectorAll('[data-role-filter]').forEach(function (tab) {
                    const selected = tab === button;
                    tab.classList.toggle('active', selected);
                    tab.setAttribute('aria-pressed', selected ? 'true' : 'false');
                });
                filterStaff();
            });
        });

        document.getElementById('staffSearch').addEventListener('input', filterStaff);
        document.getElementById('savePermissions').addEventListener('click', function () {
            showPreviewMessage('Preview only — permission changes were not saved.');
        });
        document.getElementById('addStaffForm').addEventListener('submit', function (event) {
            event.preventDefault();
            showPreviewMessage('Preview only — the staff account was not created.');
        });

        filterStaff();
    });
</script>
@endsection
