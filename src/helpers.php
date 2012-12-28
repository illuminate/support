<?php

/**
 * Generate a URL to a controller action.
 *
 * @param  string  $name
 * @param  string  $parameters
 * @param  bool    $absolute
 * @return string
 */
function action($name, $parameters = array(), $absolute = true)
{
	$app = app();

	return $app['url']->action($name, $parameters, $absolute);
}

/**
 * Get the root Facade application instance.
 *
 * @return Illuminate\Foundation\Application
 */
function app()
{
	return Illuminate\Support\Facades\Facade::getFacadeApplication();
}

/**
 * Get the path to the application folder.
 *
 * @return  string
 */
function app_path()
{
	return app()->make('path');
}

/**
 * Divide an array into two arrays. One with keys and the other with values.
 *
 * @param  array  $array
 * @return array
 */
function array_divide($array)
{
	return array(array_keys($array), array_values($array));
}

/**
 * Flatten a multi-dimensional associative array with dots.
 *
 * @param  array   $array
 * @param  string  $prepend
 * @return array
 */
function array_dot($array, $prepend = '')
{
	$results = array();

	foreach ($array as $key => $value)
	{
		if (is_array($value))
		{
			$results = array_merge($results, array_dot($value, $prepend.$key.'.'));
		}
		else
		{
			$results[$prepend.$key] = $value;
		}
	}

	return $results;
}

/**
 * Get all of the given array except for a specified array of items.
 *
 * @param  array  $array
 * @param  array  $keys
 * @return array
 */
function array_except($array, $keys)
{
	return array_diff_key($array, array_flip((array) $keys));
}

/**
 * Return the first element in an array passing a given truth test.
 *
 * @param  array    $array
 * @param  Closure  $callback
 * @param  mixed    $default
 * @return mixed
 */
function array_first($array, $callback, $default = null)
{
	foreach ($array as $key => $value)
	{
		if (call_user_func($callback, $key, $value)) return $value;
	}

	return value($default);
}

/**
 * Remove an array item from a given array using "dot" notation.
 *
 * @param  array   $array
 * @param  string  $key
 * @return void
 */
function array_forget(&$array, $key)
{
	$keys = explode('.', $key);

	while (count($keys) > 1)
	{
		$key = array_shift($keys);

		if ( ! isset($array[$key]) or ! is_array($array[$key]))
		{
			return;
		}

		$array =& $array[$key];
	}

	unset($array[array_shift($keys)]);
}

/**
 * Get an item from an array using "dot" notation.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function array_get($array, $key, $default = null)
{
	if (is_null($key)) return $array;

	foreach (explode('.', $key) as $segment)
	{
		if ( ! is_array($array) or ! array_key_exists($segment, $array))
		{
			return value($default);
		}

		$array = $array[$segment];
	}

	return $array;
}

/**
 * Get a subset of the items from the given array.
 *
 * @param  array  $array
 * @param  array  $keys
 * @return array
 */
function array_only($array, $keys)
{
	return array_intersect_key($array, array_flip((array) $keys));
}

/**
 * Pluck an array of values from an array.
 *
 * @param  array   $array
 * @param  string  $key
 * @return array
 */
function array_pluck($array, $key)
{
	return array_map(function($v) use ($key)
	{
		return is_object($v) ? $v->$key : $v[$key];

	}, $array);
}

/**
 * Set an array item to a given value using "dot" notation.
 *
 * If no key is given to the method, the entire array will be replaced.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $value
 * @return void
 */
function array_set(&$array, $key, $value)
{
	if (is_null($key)) return $array = $value;

	$keys = explode('.', $key);

	while (count($keys) > 1)
	{
		$key = array_shift($keys);

		// If the key doesn't exist at this depth, we will just create an empty array
		// to hold the next value, allowing us to create the arrays to hold final
		// values at the correct depth. Then we'll keep digging into the array.
		if ( ! isset($array[$key]) or ! is_array($array[$key]))
		{
			$array[$key] = array();
		}

		$array =& $array[$key];
	}

	$array[array_shift($keys)] = $value;
}

/**
 * Generate an asset path for the application.
 *
 * @param  string  $path
 * @param  bool    $secure
 * @return string
 */
function asset($path, $secure = null)
{
	$app = app();

	return $app['url']->asset($path, $secure);
}

/**
 * Get the base to the base of the install.
 *
 * @return string
 */
function base_path()
{
	return app()->make('path.base');
}

/**
 * Convert a value to camel case.
 *
 * @param  string  $value
 * @return string
 */
function camel_case($value)
{
	$value = ucwords(str_replace(array('-', '_'), ' ', $value));

	return str_replace(' ', '', $value);
}

/**
 * Get the class "basename" of the given object / class.
 *
 * @param  string|object  $class
 * @return string
 */
function class_basename($class)
{
	$class = is_object($class) ? get_class($class) : $class;

	return basename(str_replace('\\', '/', $class));
}

/**
 * Get the CSRF token value.
 *
 * @return string
 */
function csrf_token()
{
	$app = app();

	if (isset($app['session']))
	{
		return $app['session']->getToken();
	}
	else
	{
		throw new RuntimeException("Application session store not set.");
	}
}

/**
 * Dump and die; var_dump the value and die().
 *
 * @param  mixed  $value
 * @return void
 */
function dd($value)
{
	die(var_dump($value));
}

/**
 * Determine if a given string ends with a given needle.
 *
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function ends_with($haystack, $needle)
{
	return $needle == substr($haystack, strlen($haystack) - strlen($needle));
}

/**
 * Generate a path for the application.
 *
 * @param  string  $path
 * @param  array   $parameters
 * @param  bool    $secure
 * @return string
 */
function path($path = null, array $parameters = array(), $secure = null)
{
	$app = app();

	return $app['url']->to($path, $parameters, $secure);
}

/**
 * Generate a URL to a named route.
 *
 * @param  string  $route
 * @param  string  $parameters
 * @param  bool    $absolute
 * @return string
 */
function route($route, $parameters = array(), $absolute = true)
{
	$app = app();

	return $app['url']->route($route, $parameters, $absolute);
}

/**
 * Generate an asset path for the application.
 *
 * @param  string  $path
 * @return string
 */
function secure_asset($path)
{
	return asset($path, true);
}

/**
 * Generate a HTTPS path for the application.
 *
 * @param  string  $path
 * @param  array   $parameters
 * @return string
 */
function secure_path($path, array $parameters = array())
{
	return path($path, $parameters, true);
}

/**
 * Convert a string to snake case.
 *
 * @param  string  $value
 * @return string
 */
function snake_case($value)
{
	return trim(preg_replace_callback('/[A-Z]/', function($match)
	{
		return '_'.strtolower($match[0]);

	}, $value), '_');
}

/**
 * Determine if a string starts with a given needle.
 *
 * @param  string  $haystack
 * @param  string  $needle
 * @return bool
 */
function starts_with($haystack, $needle)
{
	return strpos($haystack, $needle) === 0;
}

/**
 * Determine if a given string contains a given sub-string.
 *
 * @param  string        $haystack
 * @param  string|array  $needle
 * @return bool
 */
function str_contains($haystack, $needle)
{
	foreach ((array) $needle as $n)
	{
		if (strpos($haystack, $n) !== false) return true;
	}

	return false;
}

/**
 * Determine if a given string matches a given pattern.
 *
 * @param  string  $pattern
 * @param  string  $value
 * @return bool
 */
function str_is($pattern, $value)
{
	// Asterisks are translated into zero-or-more regular expression wildcards
	// to make it convenient to check if the strings starts with the given
	// pattern such as "library/*", making any string check convenient.
	if ($pattern !== '/')
	{
		$pattern = str_replace('*', '(.*)', $pattern).'\z';
	}
	else
	{
		$pattern = '/$';
	}

	return (bool) preg_match('#^'.$pattern.'#', $value);
}

/**
 * Translate the given message.
 *
 * @param  string  $id
 * @param  array   $parameters
 * @param  string  $domain
 * @param  string  $locale
 * @return string
 */
function trans($id, $parameters = array(), $domain = 'messages', $locale = null)
{
	$app = app();

	return $app['translator']->trans($id, $parameters, $domain, $locale);
}

/**
 * Translates the given message based on a count.
 *
 * @param  string  $id
 * @param  int     $number
 * @param  array   $parameters
 * @param  string  $domain
 * @param  string  $locale
 * @return string
 */
function trans_choice($id, $number, array $parameters = array(), $domain = 'messages', $locale = null)
{
	$app = app();

	return $app['translator']->transChoice($id, $number, $parameters, $domain, $locale);
}

/**
 * Return the default value of the given value.
 *
 * @param  mixed  $value
 * @return mixed
 */
function value($value)
{
	return $value instanceof Closure ? $value() : $value;
}