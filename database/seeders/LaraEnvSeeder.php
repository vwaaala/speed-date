<?php

namespace Database\Seeders;

use Bunker\SupportTicket\Models\Reply;
use Bunker\SupportTicket\Models\Ticket;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LaraEnvSeeder extends Seeder
{
    public function run(): void
    {
        // table permissions
        $permissions = [
            'settings_create',
            'settings_edit',
            'settings_delete',
            'settings_show',
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $super = Role::where(['name' => 'Super Admin'])->first();
        $super->givePermissionTo($permissions);
    }
}
