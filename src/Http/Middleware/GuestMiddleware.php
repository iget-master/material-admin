<?php namespace IgetMaster\MaterialAdmin\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class GuestMiddleware implements Middleware {

    public function handle($request, Closure $next)
    {
    	if (\Auth::check()) {
    		return redirect()->guest(\Config::get('admin.home_route'));
    	}

        return $next($request);
    }
}