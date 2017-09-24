<?php

namespace App\Http\Middleware;

use Closure;
use App, Auth;

class BasicAuthOnStaging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (App::environment(['local', 'staging'])) {
            return Auth::onceBasic() ?: $next($request);
        }

    }
}
