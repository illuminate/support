<?php namespace Illuminate\Support;

class Helpers {

	/**
	 * Load the global helpers file for Illuminate.
	 *
	 * @return void
	 */
	public static function register()
	{
		require_once __DIR__.'/functions.php';
	}

}