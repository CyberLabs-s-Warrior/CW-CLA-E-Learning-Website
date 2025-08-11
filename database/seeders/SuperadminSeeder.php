<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role superadmin kalau belum ada
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);

        // Buat user superadmin
        $user = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'superadmin',
                'password' => Hash::make('password123'),
                'is_superadmin' => true,
            ]
        );

        // Assign role superadmin jika belum punya
        if (!$user->hasRole('superadmin')) {
            $user->assignRole($superadminRole);
        }

        // Sync semua permission
        $permissions = Permission::pluck('name')->toArray();
        $user->syncPermissions($permissions);
    }
}
