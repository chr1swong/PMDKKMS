<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAuthenticatedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            switch($user->account_role) {
                case 1: // Assuming 1 is the role ID for archer
                    return redirect()->route('archer.dashboard');
                    break;
                case 2: // Assuming 2 is the role ID for coach
                    return redirect()->route('coach.dashboard');
                    break;
                case 3: // Assuming 3 is the role ID for committee member
                    return redirect()->route('committee.dashboard');
                    break;
                default:
                    return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
