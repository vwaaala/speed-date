<?php

namespace Database\Seeders;

use App\Enums\UserStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'uuid' => str()->uuid(),
            'name' => 'Oliver Brown',
            'email' => 'super@bunk3r.net',
            'password' => bcrypt('secret')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Product Manager User
        $user = User::create([
            'uuid' => str()->uuid(),
            'name' => 'Abdul',
            'email' => 'users@bunk3r.net',
            'password' => bcrypt('secret')
        ]);
        $user1 = User::create([
            'uuid' => str()->uuid(),
            'name' => 'Nagar',
            'email' => 'users1@bunk3r.net',
            'password' => bcrypt('secret')
        ]);
        // Creating Product Manager User
        $user2 = User::create([
            'uuid' => str()->uuid(),
            'name' => 'Jantrik',
            'email' => 'users2@bunk3r.net',
            'password' => bcrypt('secret')
        ]);
        $user3 = User::create([
            'uuid' => str()->uuid(),
            'name' => 'Sabbir',
            'email' => 'users3@bunk3r.net',
            'password' => bcrypt('secret')
        ]);
        // Creating Product Manager User
        $user4 = User::create([
            'uuid' => str()->uuid(),
            'name' => 'Seattle',
            'email' => 'users4@bunk3r.net',
            'password' => bcrypt('secret')
        ]);

        // Creating Product Manager User
        $user5 = User::create([
            'uuid' => str()->uuid(),
            'name' => 'Pother',
            'email' => 'users5@bunk3r.net',
            'password' => bcrypt('secret')
        ]);
        $user6 = User::create([
            'uuid' => str()->uuid(),
            'name' => 'Mira',
            'email' => 'users6@bunk3r.net',
            'password' => bcrypt('secret')
        ]);
        // Creating Product Manager User
        $user7 = User::create([
            'uuid' => str()->uuid(),
            'name' => 'Vocale',
            'email' => 'users7@bunk3r.net',
            'password' => bcrypt('secret')
        ]);
        $user->assignRole('User');
        $user1->assignRole('User');
        $user2->assignRole('User');
        $user3->assignRole('User');
        $user4->assignRole('User');
        $user5->assignRole('User');
        $user6->assignRole('User');
        $user7->assignRole('User');
    }
}
