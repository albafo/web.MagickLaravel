<?php namespace Magia;

use Illuminate\Support\ServiceProvider;

class MagiaServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $viewPath = __DIR__.'/View';
        $this->loadViewsFrom($viewPath, 'magia');

        $this->publishes([
            __DIR__.'/../public' => base_path('public/packages/magia'),
        ]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        include __DIR__.'/routes.php';
        include __DIR__.'/viewComposers.php';

        $this->app['admin_menu'] = $this->app->share(function($app)
        {
            return new Menu();
        });

    }

}
