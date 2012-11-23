<?php namespace Illuminate\Support;

abstract class ServiceProvider {

	/**
	 * The view engine used by the package's views.
	 *
	 * @var string
	 */
	protected $viewEngine = 'php';

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
	 * Register the package's component namespaces.
	 *
	 * @param  Illuminate\Foundation\Application  $app
	 * @param  string  $package
	 * @param  string  $path
	 * @return void
	 */
	public function registerComponents($app, $vendor, $package, $path)
	{
		// In this method we will register the configuration package for the package
		// so that the configuration options cleanly cascade into the application
		// folder to make the developers lives much easier in maintaining them.
		if ($app['files']->isDirectory($config = $path.'/config'))
		{
			$app['config']->package($vendor.'/'.$package, $config);
		}

		// Next we will check for any "language" components. If language files exist
		// we will register them with this given package's namespace so that they
		// may be accessed using the translation facilities of the application.
		if ($app['files']->isDirectory($lang = $path.'/lang'))
		{
			$app['translator']->addNamespace($package, $lang);
		}

		// Finally we will register the view namespace so that we can access each of
		// the views available in this package. We use a standard convention when
		// registering the paths to every package's views and other components.
		if ($app['files']->isDirectory($view = $path.'/views'))
		{
			$app['view']->addNamespace($package, $view);
		}
	}

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