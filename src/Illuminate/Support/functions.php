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
	// pattern such as "library/*". Useful for checking basic strings.
	if ($pattern !== '/')
	{
		$pattern = str_replace('*', '(.*)', $pattern).'\z';
	}
	else
	{
		$pattern = '^/$';
	}

	return (bool) preg_match('#'.$pattern.'#', $value);
}