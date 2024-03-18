<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RedirectUserToEvent
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->id != 1) {
                // If the user is not the admin, redirect to the event page
                if (!$this->isUsersRoute($request)) {
                    $eventid = $user->events->pluck('id')->first();
                    return redirect()->route('speed_date.events.show', $eventid);
                }
            }
        } else {
            // If the user is not authenticated, redirect to the login page
            return redirect()->route('login');
        }

        // Allow access to the requested page
        return $next($request);
    }
    private function isUsersRoute($request)
    {
        $usersRoutes = [
            'users.index',
            'users.create',
            'users.store',
            'users.show',
            'users.edit',
            'users.update',
            'users.updatebio',
            'speed_date.events.show',
            'speed_date.ratings.store',
        ];

        // Check if the requested route belongs to the 'users' resource
        return in_array($request->route()->getName(), $usersRoutes);
    }
}
