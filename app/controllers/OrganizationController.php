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
		parent::__construct();
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
			if(Input::get('image_url')){
				$org->image_url = Input::get('image_url');
			}
			else {
				$org->image_url = '/assets/image/logo.svg';
			}
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
					if(Input::get('image_url')){
						$org->image_url = Input::get('image_url');
					}
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

	/**
	 * Displays the page to confirm deleting an assignment
	 *
	 *	@param $slug slug of the organization
	 * @param $plan slug of the flatplan
	 * @param $number page number to be assigned
	 * @param $id the id of the assignment
	 * @return response
	 */
	public function getConfirmDelete ($slug, $user){	
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$user = User::where('username', '=', $user)->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		try{
			$role = Role::where('organization_id', '=', $org->id)->where('user_id', '=', $user->id)->firstOrFail();
		}
		catch(Exception $e){
			return Redirect::to('/'.$org->slug)->with('flash_message', 'That is not a member of this organization');
		}
		if($org->slug == $user->username){
			return Redirect::back()->with('flash_message', 'Users cannot be removed from their personal projects');
		}
		if ($user->id == Auth::user()->id){
			$action = 'remove yourself from this organization';
		}
		else {
			$action = 'remove '.$user->username.' from this organization';
		}
		if (count($org->roles) == 1){
			$additional = 'Since you are the only member, this will also delete the organization and all associated flatplans, pages, and assignment';
		}
		else {
			$additional = 'This will also delete all associated assignments';
		}
		$url = '/'.$org->slug.'/'.$user->username.'/remove';
		$back = '/'.$org->slug;
		return View::make('confirmDelete')->with('action', $action)
															->with('additional', $additional)
															->with('back', $back)
															->with('url', $url);
	}

	 /**
	 * handle removing a user. If the organization has no more users, delete the 
	 * organization. Users cannot be removed from their personal organizations.
	 *
	 *	@param $slug slug of the organization
	 * @param $plan slug of the flatplan
	 * @param $number page number to be assigned
	 * @param $id the id of the assignment
	 * @return response
	 */

	public function deleteRole ($slug, $user){
		try{
			$org = Organization::where('slug', '=', $slug)->with('flatplans.pages.assignments')->firstOrFail();
			$user = User::where('username', '=', $user)->firstOrFail();
			$role = Role::where('organization_id', '=', $org->id)->where('user_id', '=', $user->id)->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		if($org->slug == $user->username){
			return Redirect::to('/'.$org->slug)->with('flash_message', 'Users cannot be removed from their personal projects');
		}
		elseif(count($org->roles) > 1){
			DB::statement('SET FOREIGN_KEY_CHECKS = 0');
			if($org->flatplans){
				foreach($org->flatplans as $flatplan){
					foreach($flatplan->pages as $page){
						if($page->assignments){
							foreach($page->assignments  as $assignment){
								if($assignment->user_id == $user->id){
									$assignment->delete();
								}
							}
						}
					}
				}
			}
			$role->delete();
			return Redirect::to('/'.$org->slug)->with('flash_message', 'Successfully removed from organization');
		}
		elseif(count($org->roles) == 1){
			DB::statement('SET FOREIGN_KEY_CHECKS = 0');
			if($org->flatplans){
				foreach($org->flatplans as $flatplan){
					foreach($flatplan->pages as $page){
						if($page->assignments){
							foreach($page->assignments as $assignment){
								$assignment->delete();
							}
						}
						$page->delete();
					}
					$flatplan->delete();
				}
			}
			$role->delete();
			$org->delete();
			DB::statement('SET FOREIGN_KEY_CHECKS = 1');
			return Redirect::to('/')->with('flash_message', 'Organization deleted');
		}
	}
}