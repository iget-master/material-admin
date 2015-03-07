<?php namespace IgetMaster\MaterialAdmin;
use Carbon\Carbon;

class Helper {
	static public function checkRoutePermission($route) {
		if (array_key_exists($route, \Config::get('materialadmin.route_permission'))) {
			$route_permission = \Config::get('materialadmin.route_permission')[$route];
		} else {
			$route_permission = \Config::get('materialadmin.default_permission');
		}

		// if (\Auth::check()) {
		// 	return (\Auth::user()->level >= $route_permission);
		// } else {
		// 	return ($route_permission == 0);
		// }

		return true;
	}

	static public function getLanguagesSelectOptions()
	{
		return \Config::get('materialadmin.languages');
	}
}