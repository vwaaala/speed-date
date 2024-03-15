<?php

namespace Bunker\LaravelSpeedDate\database\seeders;

use Bunker\LaravelSpeedDate\Models\UserBio;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Bunker\LaravelSpeedDate\Models\DatingEvent;

class SpeedDateSeeder extends Seeder
{
    public function run(): void
    {
        // table permissions
        $permissions = [
            'sd_event_create',
            'sd_event_edit',
            'sd_event_delete',
            'sd_event_show',
            'sd_rating_create',
            'sd_rating_edit',
            'sd_rating_delete',
            'sd_rating_show',
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $super = Role::where(['name' => 'Super Admin'])->first();
        $user = Role::where(['name' => 'User'])->first();
        $super->givePermissionTo($permissions);
        $user->givePermissionTo(['sd_event_show', 'sd_rating_create']);

        DatingEvent::create([
            'name' => 'name',
            'happens_on' => '03/13/2024 14:30',
            'type' => 'gay',
            'status' => 1,
        ]);

        UserBio::create([
            'user_id'  => 2,
            'nickname'=> 'JDoe',
            'city' => 'New York',
            'occupation' => 'Web Designer',
            'phone' => '1234567890',
            'birthdate' => '1988-12-13',
            'gender' => 'female',
            'looking_for' => 'male'
        ]);
    }
}
