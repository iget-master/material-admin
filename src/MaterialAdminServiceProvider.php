<?php namespace IgetMaster\MaterialAdmin;

use Illuminate\Support\ServiceProvider;

class MaterialAdminServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Load routes if app is not caching routes.
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        require_once __DIR__.'/helpers.php';

        // Publish migrations
        $this->publishes([
            __DIR__.'/Database/migrations/' => base_path('/database/migrations')
        ], 'migrations');

        // Publish seeds
        $this->publishes([
            __DIR__.'/Database/seeds/' => base_path('/database/seeds')
        ], 'seeds');

        // Publish assets
        $this->publishes([
            __DIR__.'/../Assets' => public_path('iget-master/material-admin'),
        ], 'public');

        $this->loadViewsFrom(__DIR__.'/Views', 'materialadmin');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'materialadmin');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Publish configs
        $this->mergeConfigFrom(
            __DIR__.'/Config/admin.php',
            'admin'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
