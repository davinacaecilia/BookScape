<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Redirect user yang belum login.
     */
    protected function redirectTo($request)
    {
        // Kalau bukan request API, arahkan ke login
        if (! $request->expectsJson()) {
            return route('login'); // atau '/login'
        }
    }
}
