<?php

class BaseController extends Controller {


	public function __construct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 *	Helper function for creating slugs
	 *
	 *	@param the name to be slugged
	 *	@return string 
	 */
	function create_slug($name)
	{
		$slug = strtolower($name);
		$slug = preg_replace('#[^a-z0-9 ]#', '', $slug);
		$slug = preg_replace('#\s+#', ' ', $slug);
		$slug = preg_replace('#\s#', '-', $slug);
		echo $slug;
		return $slug;
	}

	/**
	 * Helper function to generate an array of members in an organization, keyed by their id
	 *
	 * @param $slug slug of the organization
	 * @return array of members
	 */

	function member_list($slug)
	{
		$members = array();
		try{
			$org = Organization::where('slug', '=', $slug)->firstOrFail();
		}
		catch (Exception $e){
			return $members;
		}
		$roles = Role::where('organization_id', '=', $org->id)->with('user')->get();
		foreach($roles as $role){
			$members[$role->user->id] = $role->user->username;
		}
		return $members;
	}

/**
 *	Helper function that matches pages with their spread mates
 *
 *	@param $flatplan The plan whose pages need mating
 */
	protected function match_pages($flatplan){
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

/**
 * Helper method to renumber flatplan pages after deleting pages
 * 
 *	@param $flatplan the flatplan whose pages need numbering
 */
	protected function renumber_pages ($flatplan) {
		$pages = Page::where('flatplan_id', '=', $flatplan->id)->where('cover', '=', false)->get();
		$i = 1;
		foreach($pages as $page){
			$page->page_number = $i;
			$page->save();
			$i++;
		}
		$this->match_pages($flatplan);
	}
}
