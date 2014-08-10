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
				$page->slug = ' ';
				$page->cover = true;
				$page->save();
			}
			for($i = 1; $i <= Input::get('pages'); $i++){
				$page = new Page();
				$page->page_number = $i;
				$page->slug = ' ';
				$page->flatplan_id = $flatplan->id;
				$page->save();
				}
			parent::match_pages($flatplan);
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
 * Displays the page to confirm deleting an assignment
 *
 *	@param $slug slug of the organization
 * @param $plan slug of the flatplan
 * @param $number page number to be assigned
 * @param $id the id of the assignment
 * @return response
 */
	public function getConfirmDelete ($slug, $plan){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		try{
			$role = Role::where('organization_id', '=', $org->id)->where('user_id', '=', Auth::user()->id)->firstOrFail();
		}
		catch (Exception $e){
			return Redirect::to('/'.$org->slug)->with('flash_message', 'You do not have permission to edit this organization');
		}
		if($role->permissions == 'edit'){
			$action = 'delete flatplan '.$flatplan->name;
			$additional = 'This will also delete all associated pages and assignments';
			$back = '/'.$org->slug;
			$url = '/'.$org->slug.'/'.$flatplan->slug.'/delete';
			return View::make('confirmDelete')->with('action', $action)
															->with('additional', $additional)
															->with('back', $back)
															->with('url', $url);
		}
		else{
			return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'You do not have permission to delete this flatplan');
		}
	}

/**
 * handle deleting an assignment
 *
 *	@param $slug slug of the organization
 * @param $plan slug of the flatplan
 * @param $number page number to be assigned
 * @param $id the id of the assignment
 * @return response
 */

	public function deleteFlatplan ($slug, $plan){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		try{
			$role = Role::where('organization_id', '=', $org->id)->where('user_id', '=', Auth::user()->id)->firstOrFail();
		}
		catch (Exception $e){
			return Redirect::to('/'.$org->slug)->with('flash_message', 'You do not have permission to edit this organization');
		}
		if($role->permissions == 'edit'){
			$pages = Page::where('flatplan_id', '=', $flatplan->id)->get();
			if($pages){
				DB::statement('SET FOREIGN_KEY_CHECKS = 0');
				foreach ($pages as $page) {
					$assignments = Assignment::where('page_id', '=', $page->id)->get();
					if($assignments){
						foreach($assignments as $assignment){
							$assignment->delete();
						}
					}
					$page->delete();
				}
				DB::statement('SET FOREIGN_KEY_CHECKS = 1');
			}
			$flatplan->delete();
			return Redirect::to('/'.$org->slug)->with('flash_message', 'Flatplan deleted successfully');
		}
		else{
			return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'You do not have permission to delete this flatplan');
		}	
	}
}
