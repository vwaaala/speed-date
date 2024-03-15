<?php

namespace Bunker\LaravelSpeedDate;

use Illuminate\Support\ServiceProvider;


class DatingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Load routes for the support ticket package
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Load views for the support ticket package
        $this->loadViewsFrom(__DIR__ . '/resources/views/speed-date', 'speed_date');

        // Load migrations for the support ticket package
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Load translations for the support ticket package
         $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'speed_date');

        // Merge configuration for the support ticket package
        // $this->mergeConfigFrom(__DIR__ . '/config/speed_date.php', 'speed-date');

        // Publish configuration, language files, views, and seeders for the support ticket package
        $this->publishes([
            // __DIR__ . '/config/speed_date.php' => config_path('speed_date.php'),
            // __DIR__ . '/resources/lang' => resource_path('lang/'),
            // __DIR__ . '/resources/views/speed-date' => resource_path('views/pages/speed-date'),
            // __DIR__ . '/database/seeders/SpeedDateSeeder.php' => database_path('seeders/SpeedDateSeeder.php')
        ], 'speed_date');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Placeholder for any registration logic if needed
    }
}
