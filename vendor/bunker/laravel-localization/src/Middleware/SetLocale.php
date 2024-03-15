<?php

namespace Bunker\LaravelLocalization\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if ($request->has('lang')) {
            $language = $request->input('lang');
            Cookie::queue('language', $language, 60 * 24 * 365 * 10); // Lifetime cookie (10 years)
        } elseif (Cookie::has('language')) {
            $language = Cookie::get('language');
        } elseif (config('panel.primary_language')) {
            $language = config('panel.primary_language');
        }

        if (isset($language)) {
            app()->setLocale($language);
        }

        return $next($request);
    }
}
