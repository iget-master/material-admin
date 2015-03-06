<?php namespace IgetMaster\MaterialAdmin;

use Illuminate\Support\ServiceProvider;

class MaterialAdminServiceProvider extends ServiceProvider {

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
    	require __DIR__.'/Http/routes.php';
    	require __DIR__.'/Http/filters.php';

    	// Publish migrations
		$this->publishes([
		    __DIR__.'/database/migrations/' => base_path('/database/migrations')
		], 'migrations');

		// Publish seeds
		$this->publishes([
		    __DIR__.'/database/seeds/' => base_path('/database/seeds')
		], 'seeds');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
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
