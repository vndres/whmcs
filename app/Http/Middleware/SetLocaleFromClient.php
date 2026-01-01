<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetLocaleFromClient
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->client && in_array($user->client->language, ['es', 'en'])) {
            app()->setLocale($user->client->language);
        }

        return $next($request);
    }
}
