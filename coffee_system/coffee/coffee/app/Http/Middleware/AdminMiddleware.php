<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in AND is an admin
        if (auth()->check() && auth()->user()->is_admin) 
        {
            return $next($request);
        }

        // Show a clear 403 error instead of silent redirect
        abort(403, 'You do not have admin access.');
    }
}
    