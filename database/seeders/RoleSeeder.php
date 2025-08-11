<?php

// namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// class RoleSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         $roles = ['superadmin','admin','instructure','student'];

//         foreach($roles as $role){
//             Role::firstOrCreate(['name'=> $role]);
//         }
//     }
// }


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('role_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $roles = ['superadmin', 'admin','instructor', 'student',];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
    }
}
