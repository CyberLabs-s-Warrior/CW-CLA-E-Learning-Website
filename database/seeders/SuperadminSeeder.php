<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'superadmin',
                'password'=> hash::make('password123'),
                'is_superadmin' => true,
            ]
            );
            $user->assignRole('superadmin'); 

            $permissions = [Permission::pluck('name')->toArray()];
            $user->syncPermissions(($permissions));
         }
}
