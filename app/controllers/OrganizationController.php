<?php

class OrganizationController extends \BaseController {

	private $rules = array(
			'organization-name'=>'required|unique:organizations,name',
			'image_url' => 'url',
			'website' => 'url',
		);
	
	private $updateRules = array(
			'image_url' => 'url',
			'website' => 'url',
		);
	
	private $roleRules = array(
			'title' => 'required',
			'permissions' => 'required'
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
		$validator = Validator::make(Input::all(), $this->rules);
		if($validator->fails()) {
			dd($validator->messages());
			return Redirect::back()->withInput()->withErrors($validator)->with('flash_message', 'Organization could not be created. Please try again.');
		}
		else{
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
			return Redirect::to('/'.$slug)->with('flash_message', 'Organization successfully created.');
		}
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
			$org = Organization::whereSlug($slug)->firstOrFail();
			$roles = Role::where('organization_id', '=', $org->id)->get();
			$flatplans = Flatplan::where('organization_id', '=', $org->id)->get();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
			if(Auth::check()){;
				try{
					$permission = $org->roles->filter(function($item){return $item->user_id == Auth::user()->id;})->first()->permissions;
				}
				catch(Exception $e){
					$permission = 'guest';
				}
			}
			else{
				$permission = 'guest';
			}
		return View::make('viewOrganization')->with('org', $org)
															->with('roles', $roles)
															->with('flatplans', $flatplans)
															->with('permission', $permission);
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
		if(Auth::check()){
			try{
				$role = $org->roles->filter(function($item){return $item->user_id == Auth::user()->id;})->first();
			}
			catch (Exception $e) {
				return Redirect::to('/'.$slug)->with('flash_message', 'You do not have permission to edit this organization.');
			}
			if ($role->permissions == 'edit'){ 
				return View::make('editOrganization')->with('org', $org);
			}
			else {
				return Redirect::to('/'.$slug)->with('flash_message', 'You do not have permission to edit this organization.');
			}
		}
		else{
			return Redirect::to('/login');
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
			$org = Organization::whereSlug($slug)->with('roles.user')->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		if(Auth::check()){
			try{
				$role = $org->roles->filter(function($item){return $item->user_id == Auth::user()->id;})->first();
			}
			catch (Exception $e){
				return Redirect::to('/'.$slug)->with('flash_message', 'You do not have permission to add members to this organization.');
			}
			if ($role->permissions == 'edit'){
				$validator = Validator::make(Input::all(), $this->updateRules);
				if($validator->fails()){
					return Redirect::back()->withInput()->withErrors->with('flash_message', 'Organization could not be updated. Please try again.');
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
			else{
				return Redirect::to('/'.$slug)->with('flash_message', 'You do not have permission to edit this organization.');
			}
		}
		else{
			return Redirect::to('/login');
		}
	}

	/*
	* Add a member to an organization.
	*
	* @return response
	*/
	public function postAddMember($slug) {
		try{ 
			$org = Organization::whereSlug($slug)->with('roles.user')->firstOrFail();
		}
		catch(Exception $e){
			return View::make('fourOhFour');
		}
		try{
			$user = User::Where('username', '=', Input::get('username'))->orWhere('email', '=', Input::get('username'))->firstOrFail();
		}		
		catch (Exception $e) {
			return Redirect::back()->with('flash_message', 'No such user');
		}
		if(Auth::check()){
			try{
				$role = $org->roles->filter(function($item){return $item->user_id == Auth::user()->id;})->first();
			}
			catch (Exception $e){
				return Redirect::to('/'.$slug)->with('flash_message', 'You do not have permission to add members to this organization.');
			}
			if ($role->permissions == 'edit'){
				$validator = Validator::make(Input::all(), $this->roleRules);
				if($validator->fails()){
					return Redirect::back()->withInput()->withErrors->with('flash_message', 'User could not be added. Please try again.');
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
			else{
				return Redirect::to('/'.$slug)->with('flash_message', 'You do not have permission to add members to this organization.');
			}
		}
		else{
			return Redirect::to('/login');
		}
	}
}