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
            'kelola_showcase',
            'kelola_testimoni'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat roles kalau belum ada
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $instructor = Role::firstOrCreate(['name' => 'instructor']);
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);

        // Assign permissions
        $admin->syncPermissions($permissions);
        $instructor->syncPermissions(['edit_course', 'kelola_course']);
        $superadmin->syncPermissions(Permission::all());
    }
}

