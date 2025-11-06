<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Flash a friendly message so guests see why they were redirected.
            // StartSession middleware runs earlier in the 'web' group so session is available.
            try {
                session()->flash('info', 'Faz login para continuar.');
            } catch (\Exception $e) {
                // ignore if session not available for some reason
            }

            return route('login');
        }
    }
}
