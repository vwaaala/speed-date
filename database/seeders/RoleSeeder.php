<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard',
            'permission_show',
            'role_create',
            'role_edit',
            'role_delete',
            'role_show',
            'user_create',
            'user_edit',
            'user_delete',
            'user_show'
         ];
        $super = Role::create(['name' => 'Super Admin']);
        $user = Role::create(['name' => 'User']);
        $super->givePermissionTo($permissions);

        $user->givePermissionTo([
            'dashboard',
            'user_show',
            'user_edit',
        ]);
    }
}
