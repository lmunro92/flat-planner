<?php

class OrganizationController extends \BaseController {

	private $rules = array(
			'name'=>'required|unique:organizations,name';
			'image_url' => 'active_url';
			'website_url' => 'active_url';
		);
	private $updateRules = array(
		'image_url' => 'active_url';
		'website_url' => 'active_url';
		);

 	public function __contruct()
	{
		$this->beforeFilter('auth', array('except' => array('getOrganization')));
	}

	/**
	* Create a new Organization
	*
	*	@return Response
	*/
	public function getCreate()
	{
			return View::make('createOrganization');
	}

	/**
	 * Store the new organization.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$validator = Validator::make(Input::all(), $rules);
		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors->with('flash_message', 'Organization could not be created. Please try again.');
		}
		$org = new Organization();
		$org->name = Input::get('organization-name');
		$slug = parent::create_slug(Input::get('organization-name'));
		$org->slug = $slug;
		$org->image_url = Input::get('image_url');
		$org->website_url= Input::get('website');
		$org->description = Input::get('description');
		$org->city = Input::get('city');
		$org->state = Input::get('state');
		$org->country = Input::get('country');
		$org->save();
		$role = new Role();
		$role->title = 'creator';
		$role->permissions = 'edit';
		$role->user_id = Auth::user()->id;
		$role->organization_id = $org->id;
		$role->save();
		return Redirect::to('/'.$slug)->with('flash_message', 'Organization successfully create.';
	}

	/**
	 * Show a single Organization page
	 *
	 * @param string $slug
	 * @return response
	 */
	public function getOrganization ($slug)
	{
		try {
			$org = Organization::whereSlug($slug)->('roles.user')->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		return View::make('viewOrganization')->with('organization', $org);
		}
	}

	/**
	 * Edit an organization's details
	 *
	 *	@param string $slug
	 *	@return response
	 */
	public function getEdit ($slug)
	{
		try {
			$org = Organization::whereSlug($slug)->with('roles.user')->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		if(Auth::check() && $org->roles()->contains(Auth::user()->id)){ 
			//add constraint to check that user can edit
			return View::make('editOrganization')->with('organization', $org);	
		}
	}
	
	/**
	 * Edit an organization's details
	 *
	 *	@param string $slug
	 *	@return response
	 */
	public function putEdit ($slug)
	{
		try {
			$org = Organization::whereSlug($slug)->first();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		if($org == null){
			return View::make('fourOhFour');
		}
		else{	
			$org->name = Input::get('organization-name');
			$org->image_url = Input::get('image_url');
			$org->website_url = Input::get('website');
			$org->description = Input::get('description');
			$org->city = Input::get('city');
			$org->state = Input::get('state');
			$org->country = Input::get('country');
			$org->save();
			return Redirect::to('/'.$slug)->with('flash_message', 'Update Successful');
		}
	}

	/*
	* Add a member to an organization.
	*
	* @return response
	*/
	public function postAddMember($slug) {
		try{ 
			$org = Organization::whereSlug($slug)->first();
		}
		catch(Exception $e){
			return View::make('fourOhFour');
		}
		if ($org == null) {
			Return View::make('fourOhFour');
		}
		else{
			try{
				$user = User::Where('username', '=', Input::get('username'))->orWhere('email', '=', Input::get('username'))->first();
			}
			catch (Exception $e) {
				return Redirect::back()->with('flash_message', 'No such user');
			}
			if($user == null) {
				return Redirect::back()->with('flash_message', 'No such user');
			}
			else{
				$role = new Role();
				$role->title = Input::get('title');
				$role->permissions = Input::get('permissions');
				$role->user_id = $user->id;
				$role->organization_id = $org->id;
				$role->save();
				return Redirect::back()->with('flash_message', 'user added');
			}
		}
		}

}