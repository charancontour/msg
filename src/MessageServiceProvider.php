<?php namespace Message;

use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
		$this->publishes([__DIR__.'/config/message.php' => config_path('message.php')]);
		$this->publishes([__DIR__.'/views/admin.blade.php' => base_path('resources/views/vendor/message/admin.blade.php')]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
        __DIR__.'/config/message.php', 'message'
    );
		include __DIR__.'/routes.php';
		// Let Laravel Ioc Container know about our Controller
		$this->app->make('Message\MessageController');

	}

}
