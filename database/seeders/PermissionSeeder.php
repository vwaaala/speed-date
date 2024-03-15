<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'permission_show',
            'dashboard',
            'role_create',
            'role_edit',
            'role_delete',
            'role_show',
            'user_create',
            'user_edit',
            'user_delete',
            'user_show',
         ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
           Permission::create(['name' => $permission]);
        }
    }
}
