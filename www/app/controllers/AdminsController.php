<?php

class AdminsController extends \BaseController {
	protected $layout = 'layouts.admin';

	public function __construct() {
		if(Auth::check() == true){
			switch(Auth::user()->roles){
				case 2:
					$this->layout = "layouts.admin";
				break;
				case 3:
					$this->layout = "layouts.admin_owner";
				break;
				case 4:
					$this->layout = "layouts.admin_employees";
				break;
				case 5:
					$this->layout = "layouts.admin_members";
				break;
				default:
					$this->layout = "layouts.admin";
				break;

			}

			// Check if user is authorized to view the page
			$routes = explode("@", Route::currentRouteAction(), 2);     
	        $this->controller = strtolower(str_replace('Controller', '', $routes[0]));
	        $this->method = $routes[1];
	        $this->parameters = Route::current()->parameters();

	     
	     	// Page content setup
	        
	        $role_id = (isset($member_id)) ? Auth::user()->roles : null;
	        $role_name = Admin::getRoleName($role_id);
		
	        View::share('role',$role_name);
	       	View::share('controller',$this->controller);
			View::share('action',$this->method);
		}

		// Set protection
		$this->beforeFilter('csrf', array('on'=>'post'));



	}

	/**
	 * Display a listing of the resource.
	 * GET /admins
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$role_name = Admin::getRoleName(Auth::user()->roles);
		$this->layout->content = View::make('admins.index');		
	}

	/**
	 * Login page.
	 * GET /admins/login
	 *
	 * @return Response
	 */
	public function getLogin()
	{
		Auth::logout();

		$this->layout = View::make('layouts.admins_login'); //set the layout 
		
		$this->layout->content = View::make('admins.login'); //set the content
	}

	/**
	 * Signin
	 * POST /admins/login
	 *
	 * @return Response
	 */
	public function postLogin()
	{
		if (Auth::attempt(array('username'=>Input::get('username'), 'password'=>Input::get('password')))) {
		    return Redirect::action('AdminsController@getIndex')
		    	->with('message', 'You are now logged in!')
		    	->with('alert_type', 'alert-success');
		} else {
		    return Redirect::action('AdminsController@getLogin')
		        ->with('message', 'Your username/password combination was incorrect')
		        ->with('alert_type','alert-danger')
		        ->withInput();
		}	
	}

	/**
	 * Logout page.
	 * POST /admins/logout
	 *
	 * @return Response
	 */
	public function getLogout()
	{
		Auth::logout();
		return Redirect::action('AdminsController@getLogin')
			->with('message','You have safely logged out!')
			->with('alert_type','alert-warning');
	}

}