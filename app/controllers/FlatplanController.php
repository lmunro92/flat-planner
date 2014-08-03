<?php

class FlatplanController extends \BaseController {

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
		return View::make('createFlatplan')->with('org', $org);
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
			$page->save();
		}
		if(Input::get('pages')){
			for($i = 1; $i <= Input::get('pages'); $i++){
				$page = new Page();
				$page->page_number = $i;
				$page->flatplan_id = $flatplan->id;
				$page->save();
			}
		}
		$this->match_pages($flatplan);
		return Redirect::to('/'.$org->slug.'/'.$flatplan->slug);
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
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		try{
			$flatplan = Flatplan::where('slug', '=', $plan)->firstOrFail();
		}
		catch(Exception $e) {
			return View::Make('fourOhFour');
		}
		$pages = Page::where('flatplan_id', '=', $flatplan->id)->get();
		return View::make('viewFlatplan')->with('flatplan', $flatplan)->with('org', $org)->with('pages', $pages);
	}

	/**
	 *	Helper function that matches pages with their spread mates
	 *
	 *	@param $flatplan The plan whose pages need mating
	 */
	private function match_pages($flatplan){
		$pages = Page::where('flatplan_id', '=', $flatplan->id)->get();
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
				$page->spread_page_id = $pages->filter(function($item){return $item->page_number == 1;})->first()->id;
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
			elseif($page->page_number == count($pages)){
				$page->spread_page_id = $pages->filter(function($item){return $item->page_number == 'IBC';})->first()->id;
				$page->save();
			}
			elseif($page->page_number == count($pages)-1){
				$page->spread_page_id = $pages->last()->id-1;
			}
			elseif((int)($page->page_number) % 2 == 0){
				$page->spread_page_id = ($page->id)+1;
			}
			else{
				$page->spread_page_id = ($page->id)-1;
			}
		}
	}
}
