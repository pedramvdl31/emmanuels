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

		
		$nav_html = Website::prepareNavBar();
		View::share('nav_html',$nav_html);

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

		$prepared_status = Page::prepareStatus();
		View::share('prepared_status',$prepared_status);


	}

	public function getIndex()
	{
		
		if(Session::get('data_session')) Session::forget('data_session');
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
		if (Session::get('data_session')) {

			$form_data = Page::prepareAddFormSession(Session::get('data_session'));
			Session::forget('data_session');
		} 
		$this->layout->content = View::make('pages.add')
		->with('form_data',$form_data);
	}
	public function postAdd()
	{
		$this->layout = View::make('layouts.pages');
		$validator = Validator::make(Input::all(), Page::$pages_add);
		Session::put('data_session',Input::all());
		if ($validator->passes()) {
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

	

	public function getEdit($id = null)
	{

		$form_data  = null;
		if (Session::get('data_session')) {
			$form_data = Page::prepareEditFormSession(Session::get('data_session'));
			Session::forget('data_session');
			$title = null;
			$description = null;
			$url = null;
			$keywords = null;
			$content = null;
			$page_id = null;
			$status = null;
		} else {
			$page = Page::find($id);
			$page_id = $page->id;
			$title = $page->title;
			$description = $page->description;
			$url = $page->url;
			$keywords = $page->keywords;
			$status = $page->status;
			$content =  Page::prepareForEdit(json_decode($page->content_data)); 
		}
		$this->layout->content = View::make('pages.edit')
		->with('page_id',$page_id)
		->with('title',$title)
		->with('description',$description)
		->with('url',$url)
		->with('keywords',$keywords )
		->with('content',$content)
		->with('form_data',$form_data)
		->with('status',$status);
	}
	public function postEdit()
	{
		
		$this->layout = View::make('layouts.pages');
		$validator = Validator::make(Input::all(), Page::$pages_add);
		Session::put('data_session',Input::all());
		if ($validator->passes()) {
			$content = Page::prepareForPreview(Input::get('content'));
			$this->layout->content = View::make('pages.preview_edit')
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

		if (Session::get('data_session')) {
			$form_data = Session::get('data_session');
			//add to page
			$page = new Page;
			$page->title = $form_data['title'];
			$page->description = $form_data['description'];
			$page->url = $form_data['url'];
			$page->keywords = $form_data['keywords'];
			$page->content_data = json_encode($form_data['content']);
			$page->status = 1;

		    if($page->save()) { // Save
		    	if(Session::get('data_session')) Session::forget('data_session');
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

	public function getPreviewEdit()
	{

		if (Session::get('data_session')) {
			$form_data = Session::get('data_session');
			//add to page
			$page = Page::find($form_data['page_id']);
			$page->title = $form_data['title'];
			$page->description = $form_data['description'];
			$page->url = $form_data['url'];
			$page->keywords = $form_data['keywords'];
			$page->content_data = isset($form_data['content'])?json_encode($form_data['content']):null;
			$page->status = $form_data['status'];

		    if($page->save()) { // Save the user and redirect to freelancers home
		    	if(Session::get('data_session')) Session::forget('data_session');
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
	public function postChangeStatus() {
		if(Request::ajax()) {
			$status = 400;
			$id = Input::get('id');
			$selected_status = Input::get('selected_status');
			$page = Page::find($id);
			$page->status = $selected_status;
			if ($page->save()) {
				$status = 200;
			} 
			return Response::json(array(
				'status' => $status
				));
		}
	}
	/**
	* getPage Method
	* retrieves content from url by parameter and displays page based on user input from pages/add || pages/edit
	* Home page being the only special route we need to keep in mind for routing
	* @param $param1 = menu group
	* @param $param2 = menu item
	**/
	public function getPage($param1 = null, $param2 = null) {
		// Set layout
		$this->layout = View::make('layouts.pages');

		if (!isset($param2)) {
			$page = Page::where('param_one',$param1)->first();
			if (isset($page)){
				//PAGE FOUND
				$page_content=  json_decode($page->content_data);

				$this->layout->content = View::make('pages.page')
				->with('page_content',$page_content);
			} else {
				$this->layout->content = View::make('errors.missing');
			}
		} elseif (isset($param1) && isset($param2)) {
			$page = Page::where('param_one',$param1)->where('param_two',$param2)->first();
			
			if (isset($page)){
				//PAGE FOUND
				$page_content=  json_decode($page->content_data);

				$this->layout->content = View::make('pages.page')
				->with('page_content',$page_content);
			} else {
				//PAGE NOT FOUND 404
				$this->layout->content = View::make('errors.missing');
			}
		}

	}
	public function postAddSlider() {
		if(Request::ajax()) {
			$order = Input::get('order');
			$slider = Page::createSlider($order);

			return Response::json(array(
				'status' => 200,
				'slider' => $slider
				));
		}
	}

	public function postImageTemp() {
		if(Request::ajax()) {
			Job::dump(Input::all());
			// // $jpeg_quality = 100;

			// $dir = "img/temp";

			// if (!file_exists($dir)) {
			// 	@mkdir($dir);
			// }

			// imagejpeg($image->name, $dir);
			
			// // uncomment line below to save the cropped image in the same location as the original image.
			// //$output_filename = dirname($imgUrl). "/croppedImg_".rand();

			// $what = getimagesize($imgUrl);

			// switch(strtolower($what['mime']))
			// {
			// 	case 'image/png':
			// 	$img_r = imagecreatefrompng($imgUrl);
			// 	$source_image = imagecreatefrompng($imgUrl);
			// 	$type = '.png';
			// 	break;
			// 	case 'image/jpeg':
			// 	$img_r = imagecreatefromjpeg($imgUrl);
			// 	$source_image = imagecreatefromjpeg($imgUrl);
			// 	error_log("jpg");
			// 	$type = '.jpeg';
			// 	break;
			// 	case 'image/gif':
			// 	$img_r = imagecreatefromgif($imgUrl);
			// 	$source_image = imagecreatefromgif($imgUrl);
			// 	$type = '.gif';
			// 	break;
			// 	default: die('image type not supported');
			// }

			// if(!is_writable(dirname($savePath))){
			// 	$response = Array(
			// 		"status" => 'error',
			// 		"message" => 'Can`t Write'
			// 		);	
			// }else{

			// 	imagejpeg($image,$output_filename, $jpeg_quality);
			// 	// $image_url = asset($cropPath . DIRECTORY_SEPARATOR. $output_filename . $type);
			
			return Response::json(array(
				'status' => 200
				));
}
}

}