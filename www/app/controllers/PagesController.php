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


	}

	public function getIndex()
	{
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
		$this->layout->content = View::make('pages.add');
	}
	public function postAdd()
	{


		$validator = Validator::make(Input::all(), Page::$pages_add);
		if ($validator->passes()) {
			$title = Input::get('title');
			$description = Input::get('description');
			$url = Input::get('url');
			$keywords = Input::get('keywords');

			$page = new Page;
			$page->title = $title;
			$page->description = $description;
			$page->url = $url;
			$page->keywords = $keywords;

		    if($page->save()) { // Save the user and redirect to freelancers home
		    	return Redirect::action('PagesController@getIndex')
		    	->with('message', 'Successfully added a page')
		    	->with('alert_type','alert-success');
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
		$this->layout->content = View::make('pages.edit');
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
			$html = Page::prepareContentArea();
			return Response::json(array(
				'status' => 200,
				'html' => $html
				));
		}
	}

}