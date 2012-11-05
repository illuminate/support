<?php namespace Illuminate\Support;

interface RenderableInterface {

	/**
	 * Get the evaluated contents of the object.
	 *
	 * @return string
	 */
	public function render();

}