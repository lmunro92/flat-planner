<?php

class OrganizationController extends \BaseController {

	/**
	 * Show a single Organization page
	 *
	 * @param string $organization
	 * @return response
	 */
	public function getOrganization ($organization)
	{
		return View::make('viewOrganization');
	}

	/**
	* Create a new Organization
	*
	*	@return Response
	*/
	public function getCreateOrganization ()
	{
			return View::make('createOrganization');
	}

	/**
	 * Store the new organization.
	 *
	 * @return Response
	 */
	public function postCreateOrganization()
	{
		
		$org = new Organization();
		$org->name = Input::get('organization-name');
		$slug = $this->create_slug(Input::get('organization-name'));
		$org->slug = $slug;
		$org->image_url = Input::get('image_url');
		$org->description = Input::get('description');
		$org->city = Input::get('city');
		$org->state = Input::get('state');
		$org->country = Input::get('country');
		//$org->save();
		return Redirect::to('/'.$slug);
	}



	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 *	Helper function for creating slugs
	 *
	 *	@param the name to be slugged
	 *	@return string 
	 */
	private static function create_slug($name)
	{
		$slug = strtolower($name);
		$slug = preg_replace('#[^a-z0-9 ]#', '', $slug);
		$slug = preg_replace('#\s+#', ' ', $slug);
		$slug = preg_replace('#\s#', '-', $slug);
		echo $slug;
		return $slug;
	}
}