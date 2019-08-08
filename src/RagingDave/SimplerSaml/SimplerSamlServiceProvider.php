<?php namespace RagingDave\SimplerSaml;

use Illuminate\Support\ServiceProvider;
use RagingDave\SimplerSaml\Services\SamlAuth;

class SimplerSamlServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$config = app()['config'];
		require_once( $config->get('simplersaml.spPath') .'/lib/_autoload.php');
		
		// Handle Config files
		$this->mergeConfigFrom(
			__DIR__. '/../../config/simplersaml.php', 'simplersaml'
		);

		// Handle registering the main integration layer
		$this->app->bind('RagingDave\SimplerSaml\Services\SamlAuth', function() {
			$config = app()['config'];
			$authSource = $config->get('simplersaml.sp');
			return new SamlAuth($config, new \SimpleSAML_Auth_Simple($authSource));
		});
	}

	/**
	 * Boots the service.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../../config/simplersaml.php' => config_path('simplersaml.php'),
		], 'config');

		// Only include routes if enabled in the config
		$config = app()['config'];

		if ($config->get('simplersaml.enableRoutes'))
		{
			include __DIR__.'/../../routes.php';
		}
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
