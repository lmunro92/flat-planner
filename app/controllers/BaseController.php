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

	/**
	 * Helper function to generate an array of members in an organization, keyed by their id
	 *
	 * @param $slug slug of the organization
	 * @return array of members
	 */

	function member_list($slug)
	{
		$members = array();
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
		}
		catch (Exception $e){
			return $members;
		}
		$roles = Role::where('organization_id', '=', $org->id)->with('user')->get();
		foreach($roles as $role){
			$members[$role->user->id] = $role->user->username;
		}
		return $members;
	}
}
