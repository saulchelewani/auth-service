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
        if (!$request->user()->hasPermission($request->route()->getName()))
            throw new PermissionDeniedException();

        return $next($request);
    }
}
