<?php namespace IgetMaster\MaterialAdmin\Http\Middleware;

use Closure;

class AuthMiddleware
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
        $route = $request->route()->getName();

        if (\Auth::guest()) {
            // Redirect to login page
            return redirect()->guest('login');
        }

        // If route name is at admin.roles config array
        if (in_array($route, \Config::get('admin.roles'))) {
            // Check if user is guest
            if (!\Auth::user()->hasRole($route)) {
                // Show Permission denied
                return response()->view('materialadmin::error.403');
            }
        }

        return $next($request);
    }
}
