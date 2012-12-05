<?php namespace Illuminate\Support\Facades;

use Illuminate\Support\Facade;

class Mail extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'mailer'; }

}