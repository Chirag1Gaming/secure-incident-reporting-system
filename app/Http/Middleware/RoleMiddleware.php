<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized.');
        }

        if (!auth()->user()->hasAnyRole($roles)) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
