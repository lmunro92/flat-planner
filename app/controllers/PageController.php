<?php

class PageController extends \BaseController {


	public function __contruct()
	{
		//		
	}


/**
 * Creates a new page
 * 
 *	@param $slug slug of the organization
 * @param $plan slug of the plan
 * @return response
 */

	public function getCreatePage($slug, $plan) {
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		try{
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->with('pages')->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		return View::make('createPage')->with('org', $org)->with('flatplan', $flatplan);
	}

/**
 * Handles the creation of a page
 *
 *	@param $slug slug of the organization
 * @param $plan slug of the plan
 * @return response
 */

	public function postCreatePage($slug, $plan) {
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		try{
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->with('pages')->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		$page = new Page();
		$page->page_number = Input::get('number');
		$page->slug = Input::get('slug');
		$page->notes = Input::get('notes');
		$page->color = Input::get('color');
		$page->image_url = Input::get('image');
		$page->flatplan_id = $flatplan->id;
		$page->save();
		if(Input::get('spread')){
			$pageOpp = new Page();
			$pageOpp->page_number = (Input::get('number') + 1);
			$pageOpp->slug = Input::get('slug');
			$pageOpp->notes = Input::get('notes');
			$pageOpp->color = Input::get('color');
			$pageOpp->image_url = Input::get('image');
			$pageOpp->flatplan_id = $flatplan->id;
			$pageOpp->save();
			$page->spread_page_id = $pageOpp->id;
			$page->save();
			$pageOpp->spread_page_id = $page->id;
			$pageOpp->save();
		}
		return Redirect::to('/'.$org->slug.'/'.$flatplan->slug)->with('flash_message', 'Page added');
	}

/**
 * View a single page
 *
 *	@param $slug slug of the organization
 * @param $plan slug of the flatplan
 * @param $page number of the page
 *	@return response
 */
	public function getViewPage ($slug, $plan, $number){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->with('pages')->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			if($page->spread_page_id){
				$pageOpp = Page::where('flatplan_id', '=', $flatplan->id)->where('id', '=', $page->spread_page_id)->firstOrFail();
			}
			$assignments = Assignment::where('page_id', '=', $page->id)->orWhere('page_id', '=', $pageOpp->id)->get();
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		$members = parent::member_list($slug);
		if($page->spread_page_id){
			return View::make('viewPage')->with('org', $org)->with('flatplan', $flatplan)->with('page', $page)->with('pageOpp', $pageOpp)->with('assignments', $assignments)->with('members', $members);
		}
		else {
			return View::make('viewPage')->with('org', $org)->with('flatplan', $flatplan)->with('page', $page)->with('assignments', $assignments)->with('members', $members);
		}
	}

/**
 * Edit a single page's information
 *
 * @param $slug slug of the organization
 * @param $plan slug of the flatplan
 * @param $page number of the page
 * @return response
 */
	public function getEditPage ($slug, $plan, $number){
	try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->with('pages')->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			if($page->spread_page_id){
				$pageOpp = Page::where('flatplan_id', '=', $flatplan->id)->where('id', '=', $page->spread_page_id)->firstOrFail();
			}
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		if($page->spread_page_id){
			return View::make('editPage')->with('org', $org)->with('flatplan', $flatplan)->with('page', $page)->with('pageOpp', $pageOpp);
		}
		else{
			return View::make('editPage')->with('org', $org)->with('flatplan', $flatplan)->with('page', $page);
		}
	}

/**
 * Handle edits to a single page's information
 *
 * @param $slug slug of the organization
 * @param $plan slug of the flatplan
 * @param $page number of the page
 * @return response
 */
	public function putEditPage ($slug, $plan, $number){
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
			$flatplan = Flatplan::where('organization_id', '=', $org->id)->where('slug', '=', $plan)->with('pages')->firstOrFail();
			$page = Page::where('flatplan_id', '=', $flatplan->id)->where('page_number', '=', $number)->firstOrFail();
			if($page->spread_page_id){
				$pageOpp = Page::where('flatplan_id', '=', $flatplan->id)->where('id', '=', $page->spread_page_id)->firstOrFail();
			}
		}
		catch(Exception $e) {
			return View::make('fourOhFour');
		}
		$page->page_number = Input::get('number');
		$page->slug = Input::get('slug');
		$page->notes = Input::get('notes');
		$page->color = Input::get('color');
		$page->image_url = Input::get('image');
		$page->save();
		return Redirect::to('/'.$org->slug.'/'.$flatplan->slug.'/'.$page->page_number)->with('flash_message', 'Page updated successfully');
	}	
}
