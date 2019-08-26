<?php

namespace TNM\AuthService\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TNM\AuthService\Exceptions\PermissionDeniedException;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws PermissionDeniedException
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route()->getName() ?: $request->route()->uri();
        if (!$request->user()->hasPermission($route)) throw new PermissionDeniedException();

        return $next($request);
    }
}
