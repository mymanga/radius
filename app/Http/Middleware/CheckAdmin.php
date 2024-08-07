<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if(auth()->check()) {
            // Check if the user type is 'client' or 'lead'
            if(auth()->user()->type == 'client' || auth()->user()->type == 'lead') {
                // Redirect clients and leads to their dashboard
                return redirect()->route('customer.dashboard');
            } else {
                // Allow admins to access the admin panel
                return $next($request);
            }
        } else {
            // If the user is not authenticated, redirect to login page
            return redirect()->route('login');
        }
    }
}
