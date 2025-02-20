<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            abort(403, 'Unauthorized (Not Authenticated).');
        }

        $userRole = Auth::user()->role;
        Log::info("RoleMiddleware: User Role = " . $userRole);

        // Check if user has the required role
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized (Invalid Role).');
        }

        return $next($request);
    }
}
