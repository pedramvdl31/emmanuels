<?php

class MenuItemsController extends \BaseController {
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
			$menu_items = MenuItem::prepare(MenuItem::where('status',1)->get());
			$this->layout->content = View::make('menu_items.index')
			->with('menu_items',$menu_items)
			->with('companies',$companies);
		}
	}
	public function getAdd($id = null)
	{

		$pages = Page::where('status',2)->whereNotIn('id', array(1))->get();
		//only the menu groups
		$menus = Menu::where('page_id',null)->get();

		$pages_prepared = Page::prepareForSelect($pages);
		$menus_prepared = Menu::prepareForSelect($menus);

		$this->layout->content = View::make('menu_items.add')
		->with('pages_prepared',$pages_prepared)
		->with('id',$id)
		->with('menus',$menus)
		->with('pages',$pages)
		->with('menus_prepared',$menus_prepared);

	}
	public function postAdd()
	{
		$validator = Validator::make(Input::all(), MenuItem::$rules_add);
		if ($validator->passes()) {
			$name = Input::get('name');
			$menus = Input::get('menus');
			$page_id = Input::get('page_id');
			$menu_item = new MenuItem;
			$menu_item->name = $name;
			$menu_item->menu_id = $menus;
			$menu_item->page_id = $page_id;

			//FIND PAGE
			$page = Page::find($page_id);
			$page_url = substr($page->url, 1);
			$page->param_two = $page_url;

			//FIND MENU
			$menu = Menu::find($menus);
			$page->param_one = $menu->url;

			$menu_item->status = 1;
			 if($menu_item->save() && $page->save()) { // Save
			 	return Redirect::action('MenuItemsController@getIndex')
			 	->with('message', 'Successfully added a menu item')
			 	->with('alert_type','alert-success');
			 } else {
			 	return Redirect::back()
			 	->with('message', 'Oops, somthing went wrong. Please try again.')
			 	->with('alert_type','alert-danger');	
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
		$pages = Page::where('status',2)->whereNotIn('id', array(1))->get();
		//only the menu groups
		$menus = Menu::where('page_id',null)->get();
		$pages_prepared = Page::prepareForSelect($pages);
		$menus_prepared = Menu::prepareForSelect($menus);
		$menu_item = MenuItem::find($id);
		$this->layout->content = View::make('menu_items.edit')
			->with('pages_prepared',$pages_prepared)
			->with('menu_item',$menu_item)
			->with('menus_prepared',$menus_prepared);
	}
	public function postEdit()
	{
		$validator = Validator::make(Input::all(), MenuItem::$rules_add);
		if ($validator->passes()) {
			$menu_item_id = Input::get('menu_items_id');
			$name = Input::get('name');
			$page_id = Input::get('page_id');
			$menu_id = Input::get('menus');
			$menu_items = MenuItem::find($menu_item_id);
			$menu_items->name = $name;
			$menu_items->menu_id = $menu_id;
			$menu_items->page_id = $page_id;
			$menus = Input::get('menus');

			//FIND PAGE
			$page = Page::find($page_id);
			$page_url = substr($page->url, 1);
			$page->param_two = $page_url;

			//FIND MENU
			$menu = Menu::find($menus);
			$page->param_one = $menu->url;

			$menu_items->status = 1;
			 if($menu_items->save() && $page->save()) { // Save
			 	return Redirect::action('MenuItemsController@getIndex')
			 	->with('message', 'Successfully added a page')
			 	->with('alert_type','alert-success');
			 } else {
			 	return Redirect::back()
			 	->with('message', 'Oops, somthing went wrong. Please try again.')
			 	->with('alert_type','alert-danger');	
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
		$menu_items_id = Input::get('menu_item_id');
		$menu_items = MenuItem::find($menu_items_id);
		if($menu_items->delete()) {
			return Redirect::action('MenuItemsController@getIndex')
			->with('message', 'Successfully deleted!')
			->with('alert_type','alert-success');
		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}

}