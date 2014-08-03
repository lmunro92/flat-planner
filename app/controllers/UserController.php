<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('createUser');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = new User();
		$user->first_name = Input::get('first-name');
		$user->last_name = Input::get('last-name');
		$user->username = Parent::create_slug(Input::get('username'));
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));
		$user->image_url = Input::get('image_url');
		$user->website_url = Input::get('website_url');
		$user->city = Input::get('city');
		$user->state = Input::get('state');
		$user->country = Input::get('country');
		$user->bio = Input::get('profile');
		$user->save();
		//Create a personal organization for each user
		$org = new Organization();
		$org->name = Input::get('first-name').' '.Input::get('last-name');
		$org->slug = Parent::create_slug(Input::get('username'));
		$org->image_url = Input::get('image_url');
		$org
		->website_url = Input::get('website_url');
		$org->description = Input::get('profile');
		$org->city = Input::get('city');
		$org->state = Input::get('state');
		$org->country = Input::get('country');
		$org->save();

		$role = new Role();
		$role->title = 'Personal Projects';
		$role->permissions = 'edit';
		$role->organization_id = $org->id;
		$role->user_id = $user->id;
		$role->save();
		return Redirect::to('/user/'.$user->username);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($username)
	{
		try{
			$user = User::whereUsername($username)->first();
		}
		catch (exception $e) {
			return View::make('fourOhFour');
		}
		if($user == null){
			return View::make('fourOhFour');
		}
		else{
			$roles = Role::where('user_id', '=', $user->id)->get();
			return View::make('viewUser')->with('user', $user)->with('roles', $roles);
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($username)
	{
		try{
			$user = User::whereUsername($username)->first();
		}
		catch (exception $e) {
			return View::make('fourOhFour');
		}
		if($user == null){
			return View::make('fourOhFour');
		}
		else{
			return View::make('editUser')->with('user', $user);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($username)
	{
		try{
			$user = User::whereUsername($username)->first();
		}
		catch (exception $e) {
			return View::make('fourOhFour');
		}
		if($user == null){
			return View::make('fourOhFour');
		}
		else{
			$user->first_name = Input::get('first-name');
			$user->last_name = Input::get('last-name');
			$user->email = Input::get('email');
			$user->image_url = Input::get('image_url');
			$user->website_url = Input::get('website_url');
			$user->city = Input::get('city');
			$user->state = Input::get('state');
			$user->country = Input::get('country');
			$user->bio = Input::get('profile');
			$user->save();
			return Redirect::to('/user/'.$username);
		} 
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


}
