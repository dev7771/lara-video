<?php
namespace Turanzamanli\LaraVideo;

use Illuminate\Support\ServiceProvider;

class LaraVideoServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services
	 *
	 * @return void
	 */
	public function boot() {

		$this->loadRoutesFrom(__DIR__.'/routes.php');
		$this->loadMigrationsFrom(__DIR__.'/migrations');
		$this->loadViewsFrom(__DIR__.'/views', 'laravideo');
		$this->publishes([
			__DIR__.'/views' => base_path('resources/views/turanzamali/lara-video');
		]);
	}


	/**
	 * Register the application services
	 *
	 * @return void
	 */
	public function register() {

		// $this->app->make('Turanzamanli\LaraVideo\VideoController');
	}



}
