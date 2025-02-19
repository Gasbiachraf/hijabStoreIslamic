<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ): Response
    {
        if (Auth::check()) { // first check if there is a logged in user

            $user_role = Auth::user()->role; // get user id

            if ($user_role !== "admin") {
                abort(403, 'Unauthorized action.');
            }
        }
        return $next($request);
    }
}
