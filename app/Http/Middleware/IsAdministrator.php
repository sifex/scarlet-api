<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()->isAdministrator()) {
            throw new AuthorizationException('User is not an administrator');
        }

        return $next($request);
    }
}
