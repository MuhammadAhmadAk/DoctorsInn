@extends('backend.layouts.master')

@section('title', 'Staff Access')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Staff Access</h1>
        <p class="page-subtitle">Create instructor and staff logins and control which studio sections they can open.</p>
    </div>
    <div class="page-actions d-flex align-items-center gap-2">
        <form action="{{ route('admin.staff') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm"
                placeholder="Search name or email…" style="min-width: 200px;">
            <button type="submit" class="btn-adm btn-adm-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if ($search !== '')
                <a href="{{ route('admin.staff') }}" class="btn-adm btn-adm-outline" title="Clear search"><i class="fa-solid fa-xmark"></i></a>
            @endif
        </form>
        <button type="button" class="btn-adm btn-adm-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
            <i class="fa-solid fa-user-plus"></i> Add Staff
        </button>
    </div>
</div>

@foreach (['success' => '#10B981', 'error' => '#EF4444', 'warning' => '#F59E0B'] as $key => $color)
    @if (session($key))
        <div class="alert d-flex align-items-center gap-2 py-2 px-3 mb-3 border-0 rounded-3 text-white" style="background: {{ $color }}; font-size: 12.5px;">
            <i class="fa-solid fa-circle-info"></i>
            <span>{{ session($key) }}</span>
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="alert alert-danger rounded-3 mb-3" style="font-size: 12.5px;">{{ $errors->first() }}</div>
@endif

<div class="adm-card">
    <div class="adm-card-header">
        <h2 class="adm-card-title">
            <i class="fa-solid fa-user-shield text-primary"></i>
            Team Accounts ({{ number_format($staff->total()) }})
        </h2>
        <span class="adm-badge adm-badge-success">Live Database</span>
    </div>
    <div class="table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Role</th>
                    <th>Access</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staff as $member)
                    @php
                        $isAdminRole = $member->role === 'admin';
                        $memberPermissions = (array) ($member->permissions ?? []);
                    @endphp
                    <tr>
                        <td>
                            <div class="item-thumb-box">
                                <img src="{{ asset($member->avatar ?: 'frontend/img/team/team_2_1.jpg') }}" alt="{{ $member->name }}">
                                <div>
                                    <div class="title">
                                        {{ $member->name }}
                                        @if ($member->email === $currentEmail)
                                            <span class="adm-badge adm-badge-primary ms-1">You</span>
                                        @endif
                                    </div>
                                    <div class="subtitle">{{ $member->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="adm-badge {{ $isAdminRole ? 'adm-badge-primary' : 'adm-badge-warning' }}">{{ $roles[$member->role] ?? $member->role }}</span></td>
                        <td>
                            @if ($isAdminRole)
                                <span class="small text-muted">Full access</span>
                            @elseif (empty($memberPermissions))
                                <span class="small text-muted">No sections</span>
                            @else
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($memberPermissions as $permissionKey)
                                        @if (isset($permissions[$permissionKey]))
                                            <span class="adm-badge adm-badge-success">{{ $permissions[$permissionKey] }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($member->is_active)
                                <span class="adm-badge adm-badge-success">Active</span>
                            @else
                                <span class="adm-badge adm-badge-danger">Disabled</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn-adm btn-adm-outline" data-bs-toggle="modal" data-bs-target="#editStaff{{ $member->id }}">
                                    Edit
                                </button>
                                @if ($member->email !== $currentEmail)
                                    <form action="{{ route('admin.staff.destroy', $member) }}" method="POST" onsubmit="return confirm('Remove {{ addslashes($member->name) }} from the studio?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-adm btn-adm-outline" style="color: #DC2626; border-color: #FCA5A5;">Remove</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No staff accounts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($staff->hasPages())
        <div class="p-3 border-top">{{ $staff->links() }}</div>
    @endif
</div>

{{-- Add staff --}}
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 680px;">
        <div class="modal-content border-0" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.12);">
            <form action="{{ route('admin.staff.store') }}" method="POST">
                @csrf
                <div class="modal-header py-3 px-4 border-bottom">
                    <h5 class="modal-title fw-bold font-16 text-dark mb-0">Add Staff Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name') }}" placeholder="e.g. Dr. Ayesha Khan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}" placeholder="staff@doctorsinnelite.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Role</label>
                            <select name="role" class="form-select form-select-sm staff-role-select" data-target="addPermissions" required>
                                @foreach ($roles as $key => $label)
                                    <option value="{{ $key }}" @selected(old('role') === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Password</label>
                            <input type="password" name="password" class="form-control form-control-sm" minlength="8" placeholder="Minimum 8 characters" required>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between mb-1.5">
                                <label class="form-label small fw-semibold text-dark mb-0">Section Access Permissions</label>
                                <span class="small text-muted font-11">Administrators always have full access</span>
                            </div>
                            <div id="addPermissions" class="row g-2 p-2.5 rounded-3" style="background: #F8FAFC; border: 1px solid #E2E8F0;">
                                @foreach ($permissions as $key => $label)
                                    <div class="col-md-4 col-sm-6">
                                        <label class="form-check m-0 d-flex align-items-center gap-2 py-1" style="font-size: 12.5px; cursor: pointer;">
                                            <input class="form-check-input m-0 staff-permission" type="checkbox" name="permissions[]" value="{{ $key }}">
                                            <span>{{ $label }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-2.5 px-4 border-top">
                    <button type="button" class="btn-adm btn-adm-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-adm btn-adm-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit staff --}}
@foreach ($staff as $member)
    <div class="modal fade" id="editStaff{{ $member->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 680px;">
            <div class="modal-content border-0" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.12);">
                <form action="{{ route('admin.staff.update', $member) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header py-3 px-4 border-bottom">
                        <h5 class="modal-title fw-bold font-16 text-dark mb-0">Edit {{ $member->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Full Name</label>
                                <input type="text" name="name" class="form-control form-control-sm" value="{{ $member->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-sm" value="{{ $member->email }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Role</label>
                                <select name="role" class="form-select form-select-sm" required>
                                    @foreach ($roles as $key => $label)
                                        <option value="{{ $key }}" @selected($member->role === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">New Password <span class="text-muted font-11">(Leave blank to keep)</span></label>
                                <input type="password" name="password" class="form-control form-control-sm" minlength="8" placeholder="••••••••">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-dark mb-1.5">Section Access Permissions</label>
                                <div class="row g-2 p-2.5 rounded-3" style="background: #F8FAFC; border: 1px solid #E2E8F0;">
                                    @foreach ($permissions as $key => $label)
                                        <div class="col-md-4 col-sm-6">
                                            <label class="form-check m-0 d-flex align-items-center gap-2 py-1" style="font-size: 12.5px; cursor: pointer;">
                                                <input class="form-check-input m-0" type="checkbox" name="permissions[]" value="{{ $key }}"
                                                    @checked(in_array($key, (array) ($member->permissions ?? []), true))>
                                                <span>{{ $label }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-check d-flex align-items-center gap-2 m-0" style="font-size: 13px; cursor: pointer;">
                                    <input class="form-check-input m-0" type="checkbox" name="is_active" value="1" @checked($member->is_active)>
                                    <span class="fw-semibold text-dark">Account is active and can sign in</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-2.5 px-4 border-top">
                        <button type="button" class="btn-adm btn-adm-outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-adm btn-adm-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection

@section('extra_js')
<script>
    (function () {
        var defaults = @json($defaults);

        document.querySelectorAll('.staff-role-select').forEach(function (select) {
            select.addEventListener('change', function () {
                var container = document.getElementById(select.dataset.target);
                if (!container) return;

                var checkboxes = container.querySelectorAll('.staff-permission');
                var roleDefaults = defaults[select.value] || [];
                var isAdmin = select.value === 'admin';

                checkboxes.forEach(function (box) {
                    box.checked = isAdmin ? true : roleDefaults.indexOf(box.value) !== -1;
                    box.disabled = isAdmin;
                });
            });
        });
    })();
</script>
@endsection
