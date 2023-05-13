<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IsVerifiedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /*
        if (!($request->user()) && !$request->user()->is_verified)
        {
            return route('welcome');
        }
*/
        return $next($request);
    }
}
