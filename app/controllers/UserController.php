<?php

class UserController extends \BaseController {

	private $rules = array(
		'username'=>'required|unique:users,username|unique:organizations,slug',
		'email'=>'required|email|unique:users,email',
		'password'=>'required|confirmed|min:8',
		'image_url'=>'active_url',
		'website_url'=>'active_url');
	private $updateRules = array(
		'image_url'=>'active_url',
		'website_url'=>'active_url'
		);

	public function __contruct()
	{
		$this->beforeFilter('guest', array('only' => array('create', 'store', 'getLogin', 'postLogin')));
		$this->beforeFilter('auth', array('only' => array('edit', 'update', 'getLogout')));
	}

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
		$validator = Validator::make(Input::all(), $this->rules);
		if($validator->fails()){
			return Redirect::back()->with('flash_message', 'Sign up failed. Please try again.')->withInput()->withErrors($validator);
		}
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
		try{
			$user->save();
		}
		catch(Exception $e){
			return Redirect::back()->with('flash_message', 'Sign up failed. Please try again.')->withInput();
		}
		//Create a personal organization for each user
		$org = new Organization();
		$org->name = Input::get('first-name').' '.Input::get('last-name');
		$org->slug = Parent::create_slug(Input::get('username'));
		$org->image_url = Input::get('image_url');
		$org->website_url = Input::get('website_url');
		$org->description = Input::get('profile');
		$org->city = Input::get('city');
		$org->state = Input::get('state');
		$org->country = Input::get('country');
		try{
			$org->save();
		}
		catch(Exception $e){
			return Redirect::back()->with('flash_message', 'Sign up failed. Please try again.')->withInput();
			}
		//make user the editor of that organization
		$role = new Role();
		$role->title = 'Personal Projects';
		$role->permissions = 'edit';
		$role->organization_id = $org->id;
		$role->user_id = $user->id;
		$role->save();
		Auth::login($user);
		return Redirect::to('/user/'.$user->username)->with('flash_message', 'Update Successful');
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
			$user = User::whereUsername($username)->firstOrFail();
		}
		catch (exception $e) {
			return View::make('fourOhFour');
		}
		$roles = Role::where('user_id', '=', $user->id)->get();
		return View::make('viewUser')->with('user', $user)->with('roles', $roles);
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
			$user = User::whereUsername($username)->firstOrFail();
		}
		catch (exception $e) {
			return View::make('fourOhFour');
		}
		if($user->id == Auth::user()->id){
			return View::make('editUser')->with('user', $user);
		}
		else {
			return Redirect::to('/user/'.$username)->with('flash_message', 'You cannot edit that user');
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
			$user = User::whereUsername($username)->firstorFail();
		}
		catch (exception $e) {
			return View::make('fourOhFour');
		}
		if($user->id != Auth::user()->id){
			return Redirect::to('/user/'/$username)->with('flash_message', 'You cannot edit that user');
		}
		$validator = Validator::make(Input::all(), $this->updateRules);
		if($validator->fails()){
			return Redirect::back()->with('flash_message', 'Edit failed. Please try again.')->withInput()->withErrors($validator);
		}
		$user->first_name = Input::get('first-name');
		$user->last_name = Input::get('last-name');
		$user->image_url = Input::get('image_url');
		$user->website_url = Input::get('website_url');
		$user->city = Input::get('city');
		$user->state = Input::get('state');
		$user->country = Input::get('country');
		$user->bio = Input::get('profile');
		$user->save();
		return Redirect::to('/user/'.$username)->with('flash_message', 'Update successful');
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
	 *	Displays the login form.
	 *
	 *	@return Response
	 */
	public function getLogin(){
		return View::make('login');
	}

	/**
	 * Handles the login form.
	 *
	 * @return Response
	 */
	public function postLogin(){
		try{
			$user = User::where('username', '=', Input::get('username'))->orWhere('email', '=', Input::get('username'))->firstOrFail();
		}
		catch (Exception $e) {
			return Redirect::to('/login')->withInput()->with('flash_message', 'Invalid username or e-mail. Please try again.');
		}
		if(Hash::check(Input::get('password'), $user->password)){
			Auth::login($user);
			return Redirect::intended('/')->with('flash_message', 'Login successful. Welcome back, '.$user->username);
		}
		else{
			return Redirect::to('/login')->withInput()->with('flash_message', 'Invalid password');
		}
	}

	/**
	 * Logs out the user
	 *
	 * @return response
	 */
	public function getLogout() {
		Auth::logout();
		return Redirect::to('/')->with('flash_message', 'Logout successful.');
	}
}
