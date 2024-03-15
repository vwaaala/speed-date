<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CheckAvatarMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();

            // Check if the user's avatar matches the default
            if ($user->avatar == Config::get('panel.avatar')) {
                // If the avatar matches the default, allow access to users.edit and users.update routes
                if (!$request->routeIs('users.update') && !$request->routeIs('users.edit')) {
                    // Redirect to the users.edit page with an error message
                    return redirect()->route('users.edit', $user->id)->with('error', 'Please change your profile photo.');
                }
            }
        } else {
            // If the user is not authenticated, redirect to the login page
            return redirect()->route('login');
        }

        // Allow access to the requested page
        return $next($request);
    }
}
