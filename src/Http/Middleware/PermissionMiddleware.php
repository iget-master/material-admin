<?php namespace IgetMaster\MaterialAdmin\Http\Middleware;

use Carbon\Carbon;
use Closure;

class PermissionMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * If user isn't authenticated or has not permission for that route
         * show a `403 - Unauthorized` error.
         */
        if (!\Auth::user() || !\Auth::user()->hasRole($request->route()->getName())) {
            return response()->view('materialadmin::error.403', [], 403);
        }

        return $next($request);
    }
}
