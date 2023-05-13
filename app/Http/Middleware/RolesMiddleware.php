<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolesMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /*
        if (!$request->user() && !$request->user()->is_teacher)
        {
            return route('welcome');

        }
        */
        return $next($request);
    }
}
