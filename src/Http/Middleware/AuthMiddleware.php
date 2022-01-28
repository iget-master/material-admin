<?php namespace IgetMaster\MaterialAdmin\Http\Middleware;

use Carbon\Carbon;
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
        /**
         * If user isn't authenticated, redirect it to the login page
         */
        if (\Auth::guest()) {
            return redirect()->guest(env('WEBAPP_URL') . '/login?legacy=true');
        }

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        /**
         * Add Session-Timeout header to allow front-end
         * identifying when the session is about to expire.
         */
        $response->headers->add(['Session-Timeout' => Carbon::now()->addMinutes(config('session.lifetime'))->toIso8601String()]);

        return $response;
    }
}
