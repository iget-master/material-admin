<?php namespace IgetMaster\MaterialAdmin;

class Helper
{
    public static function checkRoutePermission($route)
    {
        // if (array_key_exists($route, \Config::get('admin.route_permission'))) {
        // 	$route_permission = \Config::get('admin.route_permission')[$route];
        // } else {
        // 	$route_permission = \Config::get('admin.default_permission');
        // }

        // if (\Auth::check()) {
        // 	return (\Auth::user()->level >= $route_permission);
        // } else {
        // 	return ($route_permission == 0);
        // }

        return true;
    }

    public static function getLanguagesSelectOptions()
    {
        return \Config::get('admin.languages');
    }
}
