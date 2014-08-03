<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 *	Helper function for creating slugs
	 *
	 *	@param the name to be slugged
	 *	@return string 
	 */
	function create_slug($name)
	{
		$slug = strtolower($name);
		$slug = preg_replace('#[^a-z0-9 ]#', '', $slug);
		$slug = preg_replace('#\s+#', ' ', $slug);
		$slug = preg_replace('#\s#', '-', $slug);
		echo $slug;
		return $slug;
	}
}
