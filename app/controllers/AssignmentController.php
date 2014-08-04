<?php

class AssignmentController extends \BaseController {

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
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->with('pages')->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			$user = User::where('id', '=', Input::get('user'))->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		$assignment = new Assignment();
		$assignment->description = Input::get('description');
		$assignment->deadline = Input::get('deadline');
		$assignment->user_id = $user->id;
		$assignment->page_id = $page->id;
		$assignment->save();
		return Redirect::back()->with('flash_message', 'Assignment created successfully');
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
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->with('pages')->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			$assignment = Assignment::where('id', '=', $id)->with('users')->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		return View::make('editAssignment')->with('org', $org)->with('flatplan', $flatplan)->with('page', $page)->with('assignment', $assignment);
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
		return Redirect::back()->with('flash_message', 'Assignment updated successfully');
	}


}
