<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::whereIn('name', ['admin', 'instructure'])->pluck('name');
        $permissions = Permission::all();

        return view('admin.users.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6|confirmed',
            'role'        => 'required|exists:roles,name',
            'permissions' => 'array',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        if (!empty($validated['permissions'])) {
            $user->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Batasi: superadmin hanya bisa diedit oleh dirinya sendiri
        if ($user->is_superadmin && Auth::id() !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengedit superadmin.');
        }

        $roles = Role::whereIn('name', ['admin', 'instructure'])->pluck('name');
        $permissions = Permission::all();
        $userPermissions = $user->permissions->pluck('name')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'permissions', 'userPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->is_superadmin && Auth::id() !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengedit superadmin.');
        }

        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'permissions' => 'array',
        ];

        // Tambah rule 'role' hanya jika bukan superadmin
        if (! $user->is_superadmin) {
            $rules['role'] = 'required|string|exists:roles,name';
        }

        $validated = $request->validate($rules);

        // Update data dasar
        $user->update([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password']
                ? Hash::make($validated['password'])
                : $user->password,
        ]);

        // Sync role & permissions cuma untuk non-superadmin
        if (! $user->is_superadmin) {
            $user->syncRoles([$validated['role']]);
            $user->syncPermissions($validated['permissions'] ?? []);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Batasi: superadmin tidak bisa dihapus
        if ($user->is_superadmin) {
            return back()->with('error', 'Tidak bisa menghapus superadmin.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
