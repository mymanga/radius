<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Portal
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
        if (!Auth::check()) {
            return redirect()->route('customer.login');
        }

        // // Check if the authenticated user is a customer
        // if (Auth::user()->type !== 'client') {
        //     // Redirect to appropriate page for non-customer users
        //     // For example, you can redirect them to the admin dashboard
        //     return redirect()->route('dashboard');
        // }

        return $next($request);
    }
}
