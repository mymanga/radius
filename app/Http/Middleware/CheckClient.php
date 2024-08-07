<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is a client or lead
        if (auth()->check() && (auth()->user()->type == 'client' || auth()->user()->type == 'lead')) {
            // Allow the request to proceed
            return $next($request);
        }

        // If the user is not authenticated or is not a client or lead,
        // log them out, invalidate their session, regenerate CSRF token,
        // and redirect them to the login page with an error message
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('error', 'Your account cannot access this page.');
    }
}