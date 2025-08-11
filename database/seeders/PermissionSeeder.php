<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Buat permission
        $permissions = [
            'manage_users',
            'edit_course',
            'view_reports',
            'kelola_about',
            'kelola_contact',
            'kelola_course',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Ambil roles
        $admin = Role::where('name', 'admin')->first();
        $instructor = Role::where('name', 'instructor')->first();
        $superadmin = Role::where('name', 'superadmin')->first();

        // Assign permissions ke masing-masing role
        if ($admin) {
            $admin->syncPermissions([
                'manage_users',
                'edit_course',
                'view_reports',
                'kelola_about',
                'kelola_contact',
                'kelola_course',
            ]);
        }

        if ($instructor) {
            $instructor->syncPermissions([
                'edit_course',
                'kelola_course',
            ]);
        }

        if ($superadmin) {
            $superadmin->syncPermissions(Permission::all()); // Semua permission
        }
    }
}
