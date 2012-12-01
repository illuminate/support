<?php

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
 * Return the default value of the given value.
 *
 * @param  mixed  $value
 * @return mixed
 */
function value($value)
{
	return $value instanceof Closure ? $value() : $value;
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