<?php namespace IgetMaster\MaterialAdmin\Middlewares;

class PermissionMiddleware implements Middleware {

    public function handle($request, Closure $next)
    {
        

        return $next($request);
    }
}