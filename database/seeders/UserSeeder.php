<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
 

        // Assign permissions ke admin
        $adminRole = Role::findByName('admin');
        $adminRole->syncPermissions([
            'manage_users',
            'edit_course',
            'view_reports',
            'kelola_about',
            'kelola_contact',
            'kelola_course',
            'kelola_showcase'
        ]);
    }
}
