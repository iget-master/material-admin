# Material Admin [BETA]
Material Design based administration interface for Laravel 5

**THIS PACKAGE ISN'T READY.**
**The full documentation should be provided only in a few months**


# Installation

Add `"iget-master/material-admin": "dev-master"` to `"require"` in your app composer.json file, then run `composer update` to get the package.

* Change `model` to `IgetMaster\MaterialAdmin\Models\User` at `config\auth.php`
* Add `IgetMaster\MaterialAdmin\MaterialAdminServiceProvider` service provider at `config\app.php`
* Add following lines to $routeMiddleware array at `app\http\Kernel.php` (replace `guest` and `auth` if exists):
  * `'auth' => 'IgetMaster\MaterialAdmin\Http\Middleware\AuthMiddleware',`
  * `'guest' => 'IgetMaster\MaterialAdmin\Http\Middleware\GuestMiddleware'`


