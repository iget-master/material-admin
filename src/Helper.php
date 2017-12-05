<?php namespace IgetMaster\MaterialAdmin;

class Helper
{
    public static function checkRoutePermission($route)
    {
        // If route name is at admin.roles config array
        if (in_array($route, \Config::get('admin.roles'))) {
            // Check if user is guest
            if (!\Auth::user()->hasRole($route)) {
                // Show Permission denied
                return false;
            }
        }

        return true;
    }

    /**
     * Get options for Language Select
     * @return array
     */
    public static function getLanguagesSelectOptions()
    {
        return array_merge(
            [
                "" => trans('materialadmin::admin.select_default')
            ],
            config('admin.languages')
        );
    }
}
