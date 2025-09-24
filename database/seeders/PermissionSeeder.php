<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
  // database/seeders/PermissionSeeder.php

public function run(): void
{
    // Wajib: bersihkan cache permission Spatie
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    $perms = [
        'manage_users',
        'edit_course',
        'view_reports',
        'kelola_about',
        'kelola_contact',
        'kelola_course',
        'kelola_showcase',
        'kelola_testimoni',
        'kelola_instructor',
        'kelola_forum',
    ];

    foreach ($perms as $p) {
        Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
    }

    $admin      = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    $instructor = Role::firstOrCreate(['name' => 'instructor', 'guard_name' => 'web']);
    $superadmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);

    // ❗ Admin & Instructor: mulai TANPA permission
    $admin->syncPermissions([]);
    $instructor->syncPermissions([]);

    // Superadmin: semua
    $superadmin->syncPermissions(Permission::all());

    app()[PermissionRegistrar::class]->forgetCachedPermissions();
}

}
