<?php namespace Illuminate\Support;

interface JsonableInterface {

	/**
	 * Convert the object to its JSON representation.
	 *
	 * @return string
	 */
	public function toJson();

}