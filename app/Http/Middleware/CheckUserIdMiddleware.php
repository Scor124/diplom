<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckUserIdMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && auth()->user()->id === 1017) {
            // Разрешаем действие
            return $next($request);
        }

        // Запрещаем действие
        abort(403, 'Доступ запрещён');
    }
}
