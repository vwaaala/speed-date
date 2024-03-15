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
            'name' => 'Abdul Muqeet',
            'email' => 'users@bunk3r.net',
            'password' => bcrypt('secret')
        ]);
        $user->assignRole('User');
    }
}
