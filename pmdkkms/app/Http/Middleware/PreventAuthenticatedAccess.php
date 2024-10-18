<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAuthenticatedAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Allow access to the QR scan route, even if the user is authenticated
        if ($request->is('attendance/scan')) {
            return $next($request);
        }

        // Redirect based on user role if authenticated
        if ($user) {
            switch ($user->account_role) {
                case 1: // Archer
                    return redirect()->route('archer.dashboard');
                case 2: // Coach
                    return redirect()->route('coach.dashboard');
                case 3: // Committee member
                    return redirect()->route('committee.dashboard');
                default:
                    return redirect()->route('home');
            }
        }

        return $next($request);
    }
}

