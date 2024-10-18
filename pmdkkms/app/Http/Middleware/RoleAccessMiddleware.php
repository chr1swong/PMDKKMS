<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

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
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        // Allow unrestricted access to the QR scan route
        if ($request->is('attendance/scan')) {
            return $next($request);
        }

        $user = $request->user();

        // Restrict access by role if authenticated
        if ($user && $user->account_role == $role) {
            return $next($request);
        }

        // Log unauthorized access attempts (Optional)
        if ($user) {
            Log::warning("Unauthorized access attempt by user: {$user->id}");
        }

        abort(403, 'Forbidden');
    }

}
