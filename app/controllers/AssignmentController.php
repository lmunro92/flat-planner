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
			$user = User::where('id', '=', Input::get('user')->firstOrFail();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		$assignment = new Assignment();
		$assignment->description = Input::get('description');
		$assignment->deadline = Input::get('deadline');
		$assignment->user_id = $user->id;
		$assignemnt->page_id = $page->id;
		$assignment->save();
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


	}


}
