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
            if($user->id == 1){

            } else {
                $events = $user->events->pluck('id')->first();
                if(!$request->routeIs('speed_date.events.show') && !$request->routeIs('speed_date.ratings.store')  && !$request->routeIs('users.show')  && !$request->routeIs('users.edit')  && !$request->routeIs('users.update') ){
                    return redirect()->route('speed_date.events.show',$events);
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
