<?php namespace IgetMaster\MaterialAdmin\Http\Middlewares;

class PermissionMiddleware implements Middleware {

    public function handle($request, Closure $next)
    {
    	dd($request->route());
        \Auth::user()->hasRole($request->route());

        return $next($request);
    }
}