<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->role;
        $permission = $request->permission;
        $search = $request->search; // Tambahan

        $query = User::with(['roles', 'permissions', 'profile']);

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        if ($permission) {
            $query->whereHas('permissions', function ($q) use ($permission) {
                $q->where('name', $permission);
            });
        }

        $users = $query->paginate(10)->withQueryString();

        // Semua permission untuk select option
        $allPermissions = \Spatie\Permission\Models\Permission::all();

        return view('admin.users.index', compact('users', 'role', 'permission', 'allPermissions', 'search'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::whereIn('name', ['admin', 'instructor'])->pluck('name');
        $permissions = Permission::all();

        // Biar bisa tahu default permission masing-masing role
        $rolePermissions = [];
        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            $rolePermissions[$roleName] = $role?->permissions->pluck('name')->toArray() ?? [];
        }

        return view('admin.users.create', compact('roles', 'permissions', 'rolePermissions'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => ['required', Rule::in(['admin','instructor'])],
            'permissions' => 'array',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        if ($request->hasFile('foto')) {
            $userData['foto'] = $request->file('foto')->store('foto_user', 'public');
        }

        $user = User::create($userData);
        $user->assignRole($validated['role']);
        if (!empty($validated['permissions'])) {
            $user->syncPermissions($validated['permissions']);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->hasRole('superadmin') && !auth()->user()->hasRole('superadmin')) {
            abort(403, 'Anda tidak diizinkan mengedit superadmin.');
        }

         if ($user->hasRole('student')) {
        abort(403, 'Akun student tidak dapat diedit dari panel admin.');
    }

        $roles = Role::whereIn('name', ['admin', 'instructor'])->pluck('name');
        $permissions = Permission::all();
        $userDirectPerms = $user->getDirectPermissions()->pluck('name')->toArray();
        $userRolePerms   = $user->getPermissionsViaRoles()->pluck('name')->toArray();


        return view('admin.users.edit', compact(
    'user', 'roles', 'permissions', 'userDirectPerms', 'userRolePerms'
        ));
    }


    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, User $user)
    {
        if ($user->hasRole('superadmin') && !auth()->user()->hasRole('superadmin')) {
            abort(403, 'Anda tidak diizinkan mengedit superadmin.');
        }
           if ($user->hasRole('student')) {
        abort(403, 'Akun student tidak dapat diedit dari panel admin.');
    }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'permissions' => 'array',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        

         if (!$user->hasRole('superadmin')) {
        $rules['role'] = ['required', Rule::in(['admin','instructor'])];
    }

        $validated = $request->validate($rules);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $userData['foto'] = $request->file('foto')->store('foto_user', 'public');
        }

        $user->update($userData);

        if (!$user->hasRole('superadmin')) {
            $user->syncRoles([$validated['role']]);
            $user->syncPermissions($validated['permissions'] ?? []);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->is_superadmin) {
            return back()->with('error', 'Tidak bisa menghapus superadmin.');
        }
           if ($user->hasRole('student')) {
        return back()->with('error', 'Akun student tidak dapat dihapus dari panel admin.');
    }
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }
        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
