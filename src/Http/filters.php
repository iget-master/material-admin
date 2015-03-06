<?php

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('materialadmin.auth', function($route)
{
	if (array_key_exists($route->getName(), \Config::get('materialadmin.route_permission'))) {
		$route_permission = \Config::get('materialadmin.route_permission')[$route->getName()];
	} else {
		$route_permission = \Config::get('materialadmin.default_permission');
	}
	
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		return Redirect::guest('login');
	} else if (Auth::user()->level < $route_permission) {
		//return Response::make('Unauthorized', 401);
	}
});


Route::filter('materialadmin.guest', function()
{
	if (Auth::check()) return Redirect::route(\Config::get('materialadmin.home_route'));
});