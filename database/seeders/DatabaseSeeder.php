<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            LaraEnvSeeder::class,
            \Bunker\LaravelSpeedDate\database\seeders\SpeedDateSeeder::class
        ]);
    }
}
