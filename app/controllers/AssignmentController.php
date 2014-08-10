<?php

class AssignmentController extends \BaseController {

	public function __contruct()
	{	
		parent::__construct();
		$this->beforeFilter('auth');	
	}


/**
 * Creates an assignment from post data
 *
 *	@param $slug slug of the organization
 * @param $plan slug of the flatplan
 * @param $number page number to be assigned
 * @return response
 */
	public function postCreateAssignment($slug, $plan, $number){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			$user = User::where('id', '=', Input::get('user'))->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		try {
			$role = Role::where('user_id', '=', Auth::user()->id)->where('organization_id', '=', $org->id)->firstOrFail();
		}
		catch(Exception $e) {
			dd($org->id);
			return Redirect::to('/'.$org->slug)->with('flash_message', 'You do not have permission to edit this organization.');
		}
		if ($role->permissions == 'edit'){
			$assignment = new Assignment();
			$assignment->description = Input::get('description');
			$assignment->deadline = Input::get('deadline');
			$assignment->user_id = $user->id;
			$assignment->page_id = $page->id;
			$assignment->save();
			return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'Assignment created successfully');
		}
		else{
			return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'You do not have permission to create assignments in this Flatplan.');
		}
	}

/**
 * view the edit page for an assignment
 *
 *	@param $slug slug of the organization
 * @param $plan slug of the flatplan
 * @param $number page number to be assigned
 * @param $id the id of the assignment
 * @return response
 */

	public function getEditAssignment($slug, $plan, $number, $id){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			$assignment = Assignment::where('id', '=', $id)->firstOrFail();
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
			return View::make('editAssignment')->with('org', $org)
															->with('flatplan', $flatplan)
															->with('page', $page)
															->with('assignment', $assignment);
		}
		else{
			return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'You do not have permission to edit this assignment');
		}
	}


/**
 * handle the edits to an assignment
 *
 *	@param $slug slug of the organization
 * @param $plan slug of the flatplan
 * @param $number page number to be assigned
 * @param $id the id of the assignment
 * @return response
 */
	public function putEditAssignment($slug, $plan, $number, $id){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->with('pages')->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			$assignment = Assignment::where('id', '=', $id)->with('user')->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		$assignment->description = Input::get('description');
		$assignment->deadline = Input::get('deadline');
		$assignment->completed = Input::get('completed');
		$assignment->save();
		return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'Assignment updated successfully');
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
	public function getConfirmDelete ($slug, $plan, $number, $id){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			$assignment = Assignment::where('id', '=', $id)->firstOrFail();
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
			$action = 'delete this assignment';
			$additional = null;
			$back = '/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number.'/assignment/'.$assignment->id;
			$url = '/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number.'/assignment/'.$assignment->id.'/delete';
			return View::make('confirmDelete')->with('action', $action)
															->with('additional', $additional)
															->with('back', $back)
															->with('url', $url);
		}
		else{
			return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'You do not have permission to delete this assignment');
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

	public function deleteAssignment ($slug, $plan, $number, $id){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			$assignment = Assignment::where('id', '=', $id)->firstOrFail();
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
				if(Input::get('_method') == 'DELETE'){
					$assignment->delete();
				}
				return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'Assignment deleted successfully');
		}
		else{
			return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'You do not have permission to delete this assignment');
		}	
	}

}
