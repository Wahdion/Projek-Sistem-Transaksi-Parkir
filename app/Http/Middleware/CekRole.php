<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (session('role') !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
