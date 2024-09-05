<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  $email
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $email): Response
    {
        $user = $request->user();

        // Check if the user is authenticated and if the email matches
        if ($user && $user->account_email_address == $email) {
            return $next($request);
        }

        // Redirect or abort if the user does not have the required email
        abort(403, 'Forbidden - Access Denied');
    }
}
