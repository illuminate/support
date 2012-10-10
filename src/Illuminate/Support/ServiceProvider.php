<?php namespace Illuminate\Support;

abstract class ServiceProvider {

	/**
	 * Indicates if the service provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function boot($app) {}

	/**
	 * Register the service provider.
	 *
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	abstract public function register($app);

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function getProvidedServices()
	{
		return array();
	}

	/**
	 * Determine if the service provider defers registration.
	 *
	 * @return bool
	 */
	public function isDeferred()
	{
		return $this->defer;
	}

}