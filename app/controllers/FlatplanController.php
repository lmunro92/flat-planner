<?php

class FlatplanController extends \BaseController {



	private $rules = array(
		'publication_date'=>'date_format:n/j/Y',
		'pages'=>'required|numeric|min:2|even',
		);
	private $updateRules = array(
		'publication_date'=>'date_format:n/j/Y'
	);


	public function __contruct()
	{
		parent::__construct();
		$this->beforeFilter('auth');	

	}

/**
 * Create a new flatplan within a given organization
 *
 *	@param $slug the organization slug
 *	@return response
 */
	public function getCreateFlatplan($slug) {
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		if(Auth::check()){
			try{
				$role = Role::where('organization_id', '=', $org->id)->where('user_id', '=', Auth::user()->id)->firstOrFail();
				#$org->roles->filter(function($item){return $item->user_id == Auth::user()->id;})->first();
			}
			catch (Exception $e) {
				return Redirect::to('/'.$slug)->with('flash_message', 'You cannot edit this organization.');
			}
			if($role->permissions == 'edit'){
				return View::make('createFlatplan')->with('org', $org);
			}
			else {
				return Redirect::to('/'.$slug)->with('flash_message', 'You do not have permission to add flatplans to this organization');
			}
		}
		else{
			return Redirect::to('/login');
		}
	}

/**
 *	Handle creation of the new flatplan
 *
 *	@param $slug owning organization
 * @return response
 */
	public function postCreateFlatplan($slug) {
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		$validator = Validator::make(Input::all(), $this->rules);
		if($validator->fails()){
			return Redirect::back()->with('flash_message', 'There were errors with your flatplan. See below')->withInput()->withErrors($validator);
		}
		else{
			$flatplan = new Flatplan();
			$flatplan->name = Input::get('name');
			$flatplan->slug = Parent::create_slug(Input::get('name'));
			$flatplan->pub_date = Input::get('publication_date');
			$flatplan->organization_id = $org->id;
			$flatplan->user_id = 1;
			$flatplan->save();
			$covers = array('COVER', 'IFC', 'IBC', 'BACK');
			foreach($covers as $cover){
				$page = new Page();
				$page->page_number = $cover;
				$page->flatplan_id = $flatplan->id;
				$page->cover = true;
				$page->save();
			}
			for($i = 1; $i <= Input::get('pages'); $i++){
				$page = new Page();
				$page->page_number = $i;
				$page->flatplan_id = $flatplan->id;
				$page->save();
				}
			$this->match_pages($flatplan);
			return Redirect::to('/'.$org->slug.'/'.$flatplan->slug)->with('flash_message', 'Flatplan created successfully');
		}
	}

	/**
	 *	Show a single flatplan
	 *
	 * @param $slug slug of the organization
	 * @param $plan slug of the flatplan
	 * @return response
	 */
	public function getViewFlatplan($slug, $plan) {
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		if(Auth::check()){
			try{
				$role = Role::where('organization_id', '=', $org->id)->where('user_id', '=', Auth::user()->id )->firstOrFail();
			}
			catch (Exception $e){
				return redirect::to('/'.$org->slug)->with('flash_message', 'You do not have permission to view this flatplan.');
			}
			$pages = Page::where('flatplan_id', '=', $flatplan->id)->where('cover', '=', false)->get();
			$covers = Page::where('flatplan_id', '=', $flatplan->id)->where('cover', '=', true)->get();
			return View::make('viewFlatplan')->with('flatplan', $flatplan)
														->with('org', $org)
														->with('pages', $pages)
														->with('covers', $covers)
														->with('permission', $role->permissions);
		}
		else {
			return Redirect::to('/login');
		}
	}

	/**
	 * Edit a flatplan
	 *
	 * @param $slug slug of the organization
	 * @param $plan slug of the flatplan
	 * @return response
	 */
	public function getEditFlatplan($slug, $plan) {
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		if(Auth::check()){
			try{
				$role = Role::where('organization_id', '=', $org->id)
									->where('user_id', '=', Auth::user()->id)
									->where('permissions', '=', 'edit')
									->firstOrFail();
			}
			catch(Exception $e) {
				return Redirect::to('/'.$org->slug)->with('flash_message', 'You do not have permission to edit this flatplan.');
			}
			return View::make('editFlatplan')->with('org', $org)
														->with('flatplan', $flatplan);
		}
		else{
			return Redirect::to('/login');
		}
	}

	/**
	*	Handle edits to flatplan
	*
	* @param $slug slug of the organization
	* @param $plan slug of the flatplan
	* @return response
	*/
	public function putEditFlatplan($slug, $plan){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		$validator = Validator::make(Input::all(), $this->updateRules);
		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator)->with('flash_message', 'There were errors with your update. See below.');
		}
		else{
			$flatplan->name = Input::get('name');
			$flatplan->pub_date = Input::get('publication_date');
			$flatplan->save();
			return Redirect::to('/'.$org->slug.'/'.$flatplan->slug)->with('flash_message', 'Update Successful');
		}
	}

	/**
	 *	Helper function that matches pages with their spread mates
	 *
	 *	@param $flatplan The plan whose pages need mating
	 */
	private function match_pages($flatplan){
		$pages = Page::where('flatplan_id', '=', $flatplan->id)->get();
		//$pages = $pages->sortBy('page_number');
		foreach($pages as $page){
			if($page->page_number == 'COVER'){
				$page->spread_page_id = $pages->filter(function($item){return $item->page_number == 'BACK';})->first()->id;
				$page->save();
			}
			elseif($page->page_number == 'BACK'){
				$page->spread_page_id = $pages->filter(function($item){return $item->page_number == 'COVER';})->first()->id;
				$page->save();
			}
			elseif($page->page_number == 'IFC'){
				$page->spread_page_id = $pages->filter(function($item) use ($page) {return $item->page_number == 1;})->first()->id;
				$page->save();
			}
			elseif($page->page_number == 'IBC'){
				$page->spread_page_id = $pages->last()->id;
				$page->save();
			}
			elseif((int)($page->page_number) == 1){
				$page->spread_page_id = $pages->filter(function($item){return $item->page_number == 'IFC';})->first()->id;
				$page->save();
			}
			elseif($page->page_number == count($pages)-4){
				$page->spread_page_id = $pages->filter(function($item){return $item->page_number == 'IBC';})->first()->id;
				$page->save();
			}
			elseif(((int)($page->page_number)) % 2 == 0){
				try{
					$pageOpp = $pages->filter(function($item) use ($page){return $item->page_number == ($page->page_number + 1);})->first();
				}
				catch(Exception $e){
					break;
				}
				$page->spread_page_id = $pageOpp->id;
				$page->save();
			}
			else{
				try{
					$pageOpp = $pages->filter(function($item) use ($page){return $item->page_number == ($page->page_number - 1);})->first();
				}
				catch(Exception $e){
					break;
				}
				$page->spread_page_id = $pageOpp->id;
				$page->save();
			}
		}
	}
}
