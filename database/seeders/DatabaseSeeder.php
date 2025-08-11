<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class, 
            ContactSeeder::class,
            UserSeeder::class,
            SuperadminSeeder::class,
            AboutSeeder::class,
        ]);
    }
}
