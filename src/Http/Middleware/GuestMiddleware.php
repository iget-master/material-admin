<?php namespace IgetMaster\MaterialAdmin\Http\Middleware;

use Closure;

class GuestMiddleware
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
        if (\Auth::check()) {
            return redirect()->route(\Config::get('admin.home_route'));
        }

        return $next($request);
    }
}