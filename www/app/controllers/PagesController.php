<?php

class PagesController extends \BaseController {
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


				$routes = explode("@", Route::currentRouteAction(), 2);     
        $this->controller = strtolower(str_replace('Controller', '', $routes[0]));
        $this->method = $routes[1];
        $this->parameters = Route::current()->parameters();

		$home_active = ($this->method == 'home') ? 'current' : '';
			$home_nav_active = ($this->method == 'home') ? 'selected="selected"' : '';
		$services_active = ($this->method == 'services') ? 'current' : '';
			$services_nav_active = ($this->method == 'services') ? 'selected="selected"' : '';
		$market_active = ($this->method == 'marketplace') ? 'current' : '';
			$market_nav_active = ($this->method == 'marketplace') ? 'selected="selected"' : '';
		$aboutus_active = ($this->method == 'aboutus') ? 'current' : '';
			$aboutus_nav_active = ($this->method == 'aboutus') ? 'selected="selected"' : '';
		$advice_active = ($this->method == 'advice') ? 'current' : '';
			$advice_nav_active = ($this->method == 'advice') ? 'selected="selected"' : '';
		$contactus_active = ($this->method == 'contactus') ? 'current' : '';
			$contactus_nav_active = ($this->method == 'contactus') ? 'selected="selected"' : '';
        View::share('home_active',$home_active);
        View::share('services_active',$services_active);
        View::share('market_active',$market_active);
        View::share('aboutus_active',$aboutus_active);
        View::share('advice_active',$advice_active);
        View::share('contactus_active',$contactus_active);
        View::share('home_nav_active',$home_nav_active);
        View::share('services_nav_active',$services_nav_active);
        View::share('market_nav_active',$market_nav_active);
        View::share('aboutus_nav_active',$aboutus_nav_active);
        View::share('advice_nav_active',$advice_nav_active);
        View::share('contactus_nav_active',$contactus_nav_active);


	}

	public function getIndex()
	{
		if(Session::get('pages_add_form_data')) Session::forget('pages_add_form_data');
		$user_role = Auth::user()->roles;
		$pages = (isset($id)) ? Page::preparePages(Page::where('company_id',$id)->get()) : Page::preparePages(Page::all());
		$companies = Company::find(1);
		$count = count($pages);

		$this->layout->content = View::make('pages.index')
		->with('pages',$pages)
		->with('companies',$companies)
		->with('user_role',$user_role)
		->with('count',$count)
		->with('company_id',$companies->id);
	}

	public function getAdd()
	{
		$form_data  = null;
		if (Session::get('pages_add_form_data')) {

			$form_data = Page::prepareAddFormSession(Session::get('pages_add_form_data'));
			// Session::forget('pages_add_form_data');
		} 
		$this->layout->content = View::make('pages.add')
		->with('form_data',$form_data);
	}
	public function postAdd()
	{
		$this->layout = View::make('layouts.pages');
		$validator = Validator::make(Input::all(), Page::$pages_add);
		if ($validator->passes()) {
			Session::put('pages_add_form_data',Input::all());
			$title = Input::get('title');
			$description = Input::get('description');
			$url = Input::get('url');
			$keywords = Input::get('keywords');
			$content = Page::prepareForPreview(Input::get('content'));
			$this->layout->content = View::make('pages.preview')
			->with('content',$content);
		} 	else {
	        // validation has failed, display error messages    
			return Redirect::back()
			->with('message', 'The following errors occurred')
			->with('alert_type','alert-danger')
			->withErrors($validator)
			->withInput();	    	
		}			

	}

	public function getPreview()
	{

		if (Session::get('pages_add_form_data')) {
			$form_data = Session::get('pages_add_form_data');
			//add to page
			$page = new Page;
			$page->title = $form_data['title'];
			$page->description = $form_data['description'];
			$page->url = $form_data['url'];
			$page->keywords = $form_data['keywords'];
			$page->content_data = json_encode($form_data['content']);
			$page->status = 1;

		    if($page->save()) { // Save the user and redirect to freelancers home
		    	if(Session::get('pages_add_form_data')) Session::forget('pages_add_form_data');
		    	return Redirect::action('PagesController@getIndex')
		    	->with('message', 'Successfully added a page')
		    	->with('alert_type','alert-success');
		    } else {
		    	return Redirect::back()
		    	->with('message', 'Oops, somthing went wrong. Please try again.')
		    	->with('alert_type','alert-danger');	
		    }
		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}

	}

	public function getEdit($id = null)
	{
		$page = Page::find($id);
		$title = $page->title;
		$description = $page->description;
		$url = $page->url;
		$keywords = $page->keywords;
		$content =  Page::prepareForEdit(json_decode($page->content_data)); 
		$this->layout->content = View::make('pages.edit')
		->with('title',$title)
		->with('description',$description)
		->with('url',$url)
		->with('keywords',$keywords )
		->with('content',$content);
	}
	public function postEdit()
	{

	}

	public function postDelete()
	{
		$page_id = Input::get('page_id');
		$page = Page::find($page_id);
		if($page->delete()) {
			return Redirect::action('PagesController@getIndex')
			->with('message', 'Successfully deleted!')
			->with('alert_type','alert-success');
		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}

	public function postContentAdd() {
		if(Request::ajax()) {
			$status = 400;
			$count = Input::get('content_set_count');
			$html = Page::prepareContentArea($count);
			return Response::json(array(
				'status' => 200,
				'html' => $html
				));
		}
	}

}