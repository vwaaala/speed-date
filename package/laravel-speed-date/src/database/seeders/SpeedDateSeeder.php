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

        UserBio::create([
            'user_id'  => 2,
            'nickname'=> 'Muqeet',
            'lastname'=> 'Last',
            'city' => 'New York',
            'occupation' => 'Web Designer',
            'phone' => '1234567890',
            'birthdate' => '1988-12-13',
            'gender' => 'female',
            'looking_for' => 'male'
        ]);

        UserBio::create([
            'user_id'  => 3,
            'nickname'=> 'Baul',
            'lastname'=> 'Last',
            'city' => 'New York',
            'occupation' => 'Web Designer',
            'phone' => '1234567890',
            'birthdate' => '1988-12-13',
            'gender' => 'female',
            'looking_for' => 'male'
        ]);

        UserBio::create([
            'user_id'  => 4,
            'nickname'=> 'Nogor',
            'lastname'=> 'Last',
            'city' => 'New York',
            'occupation' => 'Web Designer',
            'phone' => '1234567890',
            'birthdate' => '1988-12-13',
            'gender' => 'male',
            'looking_for' => 'female'
        ]);

        UserBio::create([
            'user_id'  => 5,
            'nickname'=> 'Manager',
            'lastname'=> 'Last',
            'city' => 'New York',
            'occupation' => 'Web Designer',
            'phone' => '1234567890',
            'birthdate' => '1988-12-13',
            'gender' => 'male',
            'looking_for' => 'female'
        ]);

        UserBio::create([
            'user_id'  => 6,
            'nickname'=> 'Live',
            'lastname'=> 'Last',
            'city' => 'New York',
            'occupation' => 'Web Designer',
            'phone' => '1234567890',
            'birthdate' => '1988-12-13',
            'gender' => 'male',
            'looking_for' => 'male'
        ]);

        UserBio::create([
            'user_id'  => 7,
            'nickname'=> 'Bapi',
            'lastname'=> 'Last',
            'city' => 'New York',
            'occupation' => 'Web Designer',
            'phone' => '1234567890',
            'birthdate' => '1988-12-13',
            'gender' => 'male',
            'looking_for' => 'male'
        ]);

        UserBio::create([
            'user_id'  => 8,
            'nickname'=> 'Bai',
            'lastname'=> 'Last',
            'city' => 'New York',
            'occupation' => 'Web Designer',
            'phone' => '1234567890',
            'birthdate' => '1988-12-13',
            'gender' => 'female',
            'looking_for' => 'female'
        ]);

        UserBio::create([
            'user_id'  => 9,
            'nickname'=> 'Lead',
            'lastname'=> 'Last',
            'city' => 'New York',
            'occupation' => 'Web Designer',
            'phone' => '1234567890',
            'birthdate' => '1988-12-13',
            'gender' => 'female',
            'looking_for' => 'female'
        ]);

        $event = DatingEvent::create([
            'name' => 'gay',
            'happens_on' => '03/13/2024 14:30',
            'type' => 'gay',
            'status' => 1,
        ]);
        DatingEvent::create([
            'name' => 'straight',
            'happens_on' => '03/13/2024 14:30',
            'type' => 'straight',
            'status' => 1,
        ]);
        $event->participants()->syncWithoutDetaching([2,3,4,5,6,7,8,9]);
    }
}
