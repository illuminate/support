<?php namespace Illuminate\Support;

abstract class Facade {

	/**
	 * The application instance being facaded.
	 *
	 * @var Illuminate\Foundation\Application
	 */
	protected static $app;

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		throw new \RuntimeException("Facade does not implement getFacadeAccessor method.");
	}

	/**
	 * Get the application instance behind the facade.
	 *
	 * @return Illuminate\Foundation\Application
	 */
	public static function getFacadeApplication()
	{
		return static::$app;
	}

	/**
	 * Set the application instance.
	 *
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public static function setFacadeApplication($app)
	{
		static::$app = $app;
	}

	/**
	 * Handle dynamic, static calls to the object.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public static function __callStatic($method, $parameters)
	{
		$name = static::getFacadeAccessor();

		$instance = is_object($name) ? $name : static::$app[$name];

		return call_user_func_array(array($instance, $method), $parameters);
	}

}