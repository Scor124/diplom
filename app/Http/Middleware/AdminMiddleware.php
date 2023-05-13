<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()  && \Auth::user()->id != 1)
        {
            return response('Error, your dont have a permissions');
        }
        return $next($request);

    }
}
