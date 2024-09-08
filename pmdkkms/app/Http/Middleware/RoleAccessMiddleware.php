<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if the user's role matches the required role
        if (Auth::user()->account_role != $role) {
            return redirect()->route('login')->with('error', 'You do not have access to this page.');
        }

        // Allow the request to proceed
        return $next($request);
    }
}
