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
        // Bersihkan relasi role & permission
        \DB::table('model_has_roles')->delete();
        \DB::table('model_has_permissions')->delete();

        // Assign permissions ke admin
        $adminRole = Role::findByName('admin');
        $adminRole->syncPermissions([
            'manage_users',
            'edit_course',
            'view_reports',
            'kelola_about',
            'kelola_contact',
            'kelola_course',
        ]);

        // Assign permissions ke instructor
        $instructorRole = Role::findByName('instructor');
        $instructorRole->syncPermissions([
            'edit_course',
            'kelola_course',
        ]);

        // Buat user admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        // Buat user instructor
        $instructor = User::factory()->create([
            'name' => 'Instructor User',
            'email' => 'instructor@example.com',
        ]);
        $instructor->assignRole('instructor');

        // Buat user student
        $student = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
        ]);
        $student->assignRole('student');

        // Buat 20 user random
        $roles = ['admin', 'instructor', 'student'];
        User::factory(20)->create()->each(function ($user) use ($roles) {
            $role = fake()->randomElement($roles);
            $user->assignRole($role);
        });
    }
}
