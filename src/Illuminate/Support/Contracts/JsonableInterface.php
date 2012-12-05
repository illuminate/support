<?php namespace Illuminate\Support\Contracts;

interface JsonableInterface {

	/**
	 * Convert the object to its JSON representation.
	 *
	 * @return string
	 */
	public function toJson();

}