<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,         // BUAT roles (tanpa sync permission)
            PermissionSeeder::class,   // BUAT permissions & SYNC ke roles
            UserSeeder::class,         // BUAT user & assign role
            SuperadminSeeder::class,
            ContactSeeder::class,
            AboutSeeder::class,
            ShowcaseSeeder::class,
            ForumCategorySeeder::class,

        ]);

        $this->command->call('permission:cache-reset');
    }
}
