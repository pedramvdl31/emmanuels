<?php

class MenusController extends \BaseController {
	protected $layout = 'layouts.admin';
/**
* Display a listing of the resource.
*
* @return Response
*/
public function __construct() {
// switch(Auth::user()->roles){
// 	case 2:
// 		$this->layout = "layouts.admin";
// 	break;
// 	case 3:
// 		$this->layout = "layouts.admin_owners";
// 	break;
// 	case 4:
// 		$this->layout = "layouts.admin_employees";
// 	break;
// 	case 5:
// 		$this->layout = "layouts.admin_members";
// 	break;
// 	case 6:
// 		$this->layout = "layouts.admin";
// 	break;
// }
	$this->beforeFilter('csrf', array('on'=>'post'));
	$this->role_id = (isset(Auth::user()->roles)) ? Auth::user()->roles : null;

}

public function getIndex()
{
	if ($this->role_id < 3) {
		$companies = Company::find(1);
		$menus = Menu::prepare(Menu::where('status',1)->get());
		$this->layout->content = View::make('menus.index')
		->with('menus',$menus);
	}
}

public function getAdd()
{	
//previously was where status 2 but i dont think we need it
//		$pages = Page::where('status',2)->get();
	$pages = Page::all();
	$pages_prepared = Page::prepareForSelect($pages);
	$prepared_select = Menu::prepareSelect();
	$this->layout->content = View::make('menus.add')
	->with('pages_prepared',$pages_prepared)
	->with('prepared_select',$prepared_select);
}
public function postAdd()
{	
	$validator = Validator::make(Input::all(), Menu::$rules_add);
	if ($validator->passes()) {
		$kind = Input::get('kind');
		$url = Input::get('url');
		$url = substr($url, 1);
		if ($kind == 1) { //its a link
			$validator = Validator::make(Input::all(), Menu::$rules_add_link);
			if ($validator->passes()) {
				$name = Input::get('name');
				$page_id = Input::get('page_id');

				//add param_one to pages
				$page = Page::find($page_id);
				$page_url = substr($page->url, 1);
				$page->param_one = $page_url;

				$menu = new Menu;
				$menu->name = $name;
				$menu->page_id = $page_id;
				$menu->url = $url;
				$menu->status = 1;
				if($menu->save() && $page->save()) { // Save
					return Redirect::action('MenusController@getIndex')
					->with('message', 'Successfully added a page')
					->with('alert_type','alert-success');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again.')
					->with('alert_type','alert-danger');	
				}
			} else {
				// validation has failed, display error messages    
				return Redirect::back()
				->with('message', 'The following errors occurred')
				->with('alert_type','alert-danger')
				->withErrors($validator)
				->withInput();	    	
			}
		} else { //its a menu group
			$name = Input::get('name');
			$menu = new Menu;
			$menu->name = $name;
			$menu->url = $url;
			$menu->status = 1;
				if($menu->save()) { // Save
					return Redirect::action('MenusController@getIndex')
					->with('message', 'Successfully added a page')
					->with('alert_type','alert-success');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again.')
					->with('alert_type','alert-danger');	
				}
			}

		} 	else {
		// validation has failed, display error messages    
			return Redirect::back()
			->with('message', 'The following errors occurred')
			->with('alert_type','alert-danger')
			->withErrors($validator)
			->withInput();	    	
		}	
	}
	public function getEdit($id = null)
	{
		$menus = Menu::find($id);
		$is_link = (isset($menus->page_id)?1:2);
		$pages = Page::all();
		$pages_prepared = Page::prepareForSelect($pages);
		$prepared_select = Menu::prepareSelect();
		$this->layout->content = View::make('menus.edit')
		->with('pages_prepared',$pages_prepared )
		->with('prepared_select',$prepared_select)
		->with('menus',$menus)
		->with('menu_id',$menus->id)
		->with('is_link',$is_link);
	}
	public function postEdit()
	{
		$validator = Validator::make(Input::all(), Menu::$rules_add);
		if ($validator->passes()) {
			$menu_id = Input::get('menu_id');
			$kind = Input::get('kind');
			$url = Input::get('url');
			$url = substr($url, 1);
		if ($kind == 1) { //its a link
			$validator = Validator::make(Input::all(), Menu::$rules_add_link);
			if ($validator->passes()) {
				$name = Input::get('name');
				$page_id = Input::get('page_id');

				//add param_one to pages
				$page = Page::find($page_id);
				$page_url = substr($page->url, 1);
				$page->param_one = $page_url;

				$menu = Menu::find($menu_id);
				$menu->name = $name;
				$menu->page_id = $page_id;
				$menu->url = $url;
				$menu->status = 1;
				if($menu->save() && $page->save()) { // Save
					return Redirect::action('MenusController@getIndex')
					->with('message', 'Successfully added a page')
					->with('alert_type','alert-success');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again.')
					->with('alert_type','alert-danger');	
				}
			} else {
				// validation has failed, display error messages    
				return Redirect::back()
				->with('message', 'The following errors occurred')
				->with('alert_type','alert-danger')
				->withErrors($validator)
				->withInput();	    	
			}
		} else { //its a menu group
			$name = Input::get('name');
			$menu = Menu::find($menu_id);
			$menu->name = $name;
			$menu->page_id = null;
			$menu->url = $url;
			$menu->status = 1;
				if($menu->save()) { // Save
					return Redirect::action('MenusController@getIndex')
					->with('message', 'Successfully added a page')
					->with('alert_type','alert-success');
				} else {
					return Redirect::back()
					->with('message', 'Oops, somthing went wrong. Please try again.')
					->with('alert_type','alert-danger');	
				}
			}
		} 	else {
		// validation has failed, display error messages    
			return Redirect::back()
			->with('message', 'The following errors occurred')
			->with('alert_type','alert-danger')
			->withErrors($validator)
			->withInput();	    	

		}	
	}

	public function postDelete()
	{
		$menu_id = Input::get('menu_id');
		$menu = Menu::find($menu_id);
		$count = count(MenuItem::where('menu_id',$menu_id)->first());
		if($count>0){
			$menu_items = MenuItem::where('menu_id',$menu_id)->get();
			if($menu->delete() && $menu_items->delete()) {
				return Redirect::back()
				->with('message', 'Successfully Deleted!')
				->with('alert_type','alert-success');

			} else {
				return Redirect::back()
				->with('message', 'Oops, somthing went wrong. Please try again. items and menus')
				->with('alert_type','alert-danger');	
			}

		} elseif($menu->delete()) {

			return Redirect::back()
			->with('message', 'Successfully Deleted!')
			->with('alert_type','alert-success');

		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}

		public function getOrder()
	{
		$menus = Menu::where('status',1)->orderBy('order', 'ASC')->get();
		$menu_items = MenuItem::where('status',1)->orderBy('order', 'ASC')->get();
		$list_html = Menu::prepareNestable($menus,$menu_items);
		$this->layout->content = View::make('menus.order')
			->with('list_html',$list_html);

	}

		public function postOrder()
	{
		$menus_arranged = Input::get('menu');
		foreach ($menus_arranged as $key => $value) {
			$menus = Menu::find($key);
			$menus->order = $value['order'];
			if (isset($value['item'])) {
				foreach ($value['item'] as $ikey => $ivalue) {
					$menu_items = MenuItem::find($ikey);
					$menu_items->order = $ivalue['order'];
					$menu_items->save();
				}
			}
			$menus->save();
		}
		return Redirect::action('MenusController@getIndex')
			->with('message', 'Successfully Saved')
			->with('alert_type','alert-success');
	}

	public function postCountItems() {
		if(Request::ajax()) {
			$status = 200;
			$id = Input::get('id');
			$items_count = count(MenuItem::where('menu_id',$id)->first());

			return Response::json(array(
				'status' => 200,
				'count' => $items_count
				));
		}
	}

}