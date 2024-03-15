<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Link;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Define your menu here
        Menu::macro('main', function () {
            return Menu::new()
                ->addClass('navbar-nav me-auto')
                ->route('home', 'Dashboard')
                ->route('ticket', 'Query')
                ->route('users.index', 'User')
                ->each(function (Link $item) {
                    $item->addClass('nav-link')->addClass(request()->is($item->url()) ? 'active' : '');
                })
                ->render();
        });
    }
}
