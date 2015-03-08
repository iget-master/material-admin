# material-admin
Material Design based administration interface for Laravel 5


# Installation

Add `"iget-master/material-admin": "dev-master"` to `"require"` in your app composer.json file, then run `composer update` to get the package.

* Change `model` to `IgetMaster\MaterialAdmin\Models\User` at `config\auth.php`
* Add `IgetMaster\MaterialAdmin\MaterialAdminServiceProvider` service provider at `config\app.php`
* Add following lines to $routeMiddleware array at `app\http\Kernel.php` (replace `guest` if exists):
  * `'permission' => 'IgetMaster\MaterialAdmin\Http\Middleware\PermissionMiddleware'`
  * `'guest' => 'IgetMaster\MaterialAdmin\Http\Middleware\GuestMiddleware',`
