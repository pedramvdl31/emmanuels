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
					$this->layout = "layouts.admin_owners";
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
		}

	    $this->beforeFilter('csrf', array('on'=>'post'));


	}

	/**
	 * Display a listing of the resource.
	 * GET /admins
	 *
	 * @return Response
	 */
	public function index()
	{
		/**
		* ACL Required page
		**/
		
		if(Acl::isAllowed(Admin::getRoleName(Auth::user()->roles), 'admins', 'index') == false) {
			return Redirect::back()->with('message','You are not authorized to view this page!')->with('alert_type','alert-danger')->withInput();
		}
		/**
		* Begin Page Processing
		**/
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
		    return Redirect::action('AdminsController@index')
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