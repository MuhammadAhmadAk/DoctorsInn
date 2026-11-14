<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminStaffController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $roles = config('staff.roles', []);

        $query = User::query()->whereIn('role', array_keys($roles));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $staff = $query
            ->orderByRaw("FIELD(role, 'admin', 'instructor', 'staff')")
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $permissions = config('staff.permissions', []);
        $defaults = config('staff.role_defaults', []);
        $currentEmail = session('admin_user.email');

        return view('backend.staff.index', compact('staff', 'roles', 'permissions', 'defaults', 'search', 'currentEmail'));
    }

    public function store(Request $request)
    {
        $roles = array_keys(config('staff.roles', []));

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:190|unique:users,email',
            'role' => ['required', Rule::in($roles)],
            'password' => 'required|string|min:8',
            'permissions' => 'nullable|array',
            'permissions.*' => ['string', Rule::in(array_keys(config('staff.permissions', [])))],
        ]);

        User::create([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'permissions' => $this->resolvePermissions($data['role'], $data['permissions'] ?? []),
            'is_active' => true,
        ]);

        return back()->with('success', $data['name'] . ' can now sign in to the admin studio.');
    }

    public function update(Request $request, User $staff)
    {
        $this->ensureStaffUser($staff);
        $roles = array_keys(config('staff.roles', []));

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => ['required', 'email', 'max:190', Rule::unique('users', 'email')->ignore($staff->id)],
            'role' => ['required', Rule::in($roles)],
            'password' => 'nullable|string|min:8',
            'permissions' => 'nullable|array',
            'permissions.*' => ['string', Rule::in(array_keys(config('staff.permissions', [])))],
            'is_active' => 'nullable|boolean',
        ]);

        $isSelf = session('admin_user.email') === $staff->email;
        $isActive = $request->boolean('is_active');

        if ($isSelf && $data['role'] !== 'admin') {
            return back()->with('error', 'You cannot remove your own administrator access.');
        }

        if ($isSelf && ! $isActive) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        if ($staff->role === 'admin' && $data['role'] !== 'admin' && ! $this->anotherActiveAdmin($staff->id)) {
            return back()->with('error', 'At least one active administrator must remain.');
        }

        $staff->fill([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'role' => $data['role'],
            'permissions' => $this->resolvePermissions($data['role'], $data['permissions'] ?? []),
            'is_active' => $isActive,
        ]);

        if (! empty($data['password'])) {
            $staff->password = Hash::make($data['password']);
        }

        $staff->save();

        if ($isSelf) {
            session([
                'admin_user.name' => $staff->name,
                'admin_user.email' => $staff->email,
                'admin_user.role_key' => $staff->role,
                'admin_user.permissions' => (array) ($staff->permissions ?? []),
            ]);
        }

        return back()->with('success', 'Staff account updated.');
    }

    public function destroy(Request $request, User $staff)
    {
        $this->ensureStaffUser($staff);

        if (session('admin_user.email') === $staff->email) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($staff->role === 'admin' && ! $this->anotherActiveAdmin($staff->id)) {
            return back()->with('error', 'At least one active administrator must remain.');
        }

        $staff->delete();

        return back()->with('success', 'Staff account removed.');
    }

    protected function ensureStaffUser(User $user): void
    {
        if (! array_key_exists($user->role, config('staff.roles', []))) {
            abort(404);
        }
    }

    protected function anotherActiveAdmin(int $exceptId): bool
    {
        return User::query()
            ->where('role', 'admin')
            ->where('is_active', true)
            ->whereKeyNot($exceptId)
            ->exists();
    }

    protected function resolvePermissions(string $role, array $selected): array
    {
        if ($role === 'admin') {
            return [];
        }

        $allowed = array_keys(config('staff.permissions', []));
        $selected = array_values(array_intersect($selected, $allowed));

        if (empty($selected)) {
            $selected = (array) config('staff.role_defaults.' . $role, []);
        }

        return $selected;
    }
}
