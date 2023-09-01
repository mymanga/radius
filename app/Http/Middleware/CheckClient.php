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
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && (auth()->user()->type == 'client' || auth()->user()->type == 'lead')){
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Your Account cannot access admin panel.');

        }

        return $next($request);
    }
}
