<?php namespace IgetMaster\MaterialAdmin\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class PermissionMiddleware implements Middleware {

    public function handle($request, Closure $next)
    {
    	$route = $request->route()->getName();
    	// If route name is at admin.roles config array
    	if (in_array($route, \Config::get('admin.roles'))) {
    		// Check if user is guest
	    	if (\Auth::guest()) {
	    		// Redirect to login page
	    		return redirect()->guest('login');
	    	} else if (!\Auth::user()->hasRole($route)) {
	    		// Show Permission denied
                return view('materialadmin::error.403');
	    	}
    	}

        return $next($request);
    }
}