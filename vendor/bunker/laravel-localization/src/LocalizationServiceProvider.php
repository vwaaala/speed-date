<?php

namespace Bunker\LaravelLocalization;

use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Publish middleware
        $this->publishes([
            __DIR__ . '/Middleware/SetLocale.php' => app_path('App/Http/Middleware/SetLocale.php'),
        ],'localization');
    }

    public function register()
    {

    }
}
