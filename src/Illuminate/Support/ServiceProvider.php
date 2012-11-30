<?php namespace Illuminate\Support;

abstract class ServiceProvider {

	/**
	 * The application instance.
	 *
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Create a new service provider instance.
	 *
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function __construct($app)
	{
		$this->app = $app;
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot() {}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	abstract public function register();

	/**
	 * Register the package's component namespaces.
	 *
	 * @param  string  $package
	 * @param  string  $path
	 * @param  string  $namespace
	 * @return void
	 */
	public function package($package, $path, $namespace = null)
	{
		$namespace = $this->getPackageNamespace($package, $namespace);

		// In this method we will register the configuration package for the package
		// so that the configuration options cleanly cascade into the application
		// folder to make the developers lives much easier in maintaining them.
		$config = $path.'/config';

		if ($this->app['files']->isDirectory($config))
		{
			$this->app['config']->package($package, $config, $namespace);
		}

		// Next we will check for any "language" components. If language files exist
		// we will register them with this given package's namespace so that they
		// may be accessed using the translation facilities of the application.
		$lang = $path.'/lang';

		if ($this->app['files']->isDirectory($lang))
		{
			$this->app['translator']->addNamespace($namespace, $lang);
		}

		// Finally we will register the view namespace so that we can access each of
		// the views available in this package. We use a standard convention when
		// registering the paths to every package's views and other components.
		$view = $path.'/views';

		if ($this->app['files']->isDirectory($view))
		{
			$this->app['view']->addNamespace($namespace, $view);
		}
	}

	/**
	 * Determine the namespace for a package.
	 *
	 * @param  string  $package
	 * @param  string  $namespace
	 * @return string
	 */
	protected function getPackageNamespace($package, $namespace)
	{
		if (is_null($namespace))
		{
			list($vendor, $namespace) = explode('/', $package);
		}

		return $namespace;
	}

	/**
	 * Register the package's custom Artisan commands.
	 *
	 * @param  dynamic  string
	 * @return void
	 */
	public function commands()
	{
		$commands = func_get_args();

		// To register the commands with Artisan, we will grab each of the arguments
		// passed into the method and listen for Artisan "start" event which will
		// give us the Artisan console instance which we will give commands to.
		$events = $this->app['events'];

		$events->listen('artisan.start', function($artisan) use ($commands)
		{
			$artisan->resolveCommands($commands);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
	 * Determine if the provider is deferred.
	 *
	 * @return bool
	 */
	public function isDeferred()
	{
		return $this->defer;
	}

}