<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotAuthenticatedWithFlash
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            return $next($request);
        }

        // redirect to login and flash a helpful message
        return redirect()->guest(route('login'))
            ->with('info', 'Faz login para continuar.');
    }
}
