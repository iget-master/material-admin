# material-admin
Material Design based administration interface for Laravel 5

To use Material Admin you need to:

* Change `model` to `IgetMaster\MaterialAdmin\Models\User` at `config\auth.php`
* Add `IgetMaster\MaterialAdmin\MaterialAdminServiceProvider` service provider at `config\app.php`
* Add `'permission' => 'IgetMaster\MaterialAdmin\Http\Middleware\PermissionMiddleware'` to $routeMiddleware array at `app\http\Kernel.php`
