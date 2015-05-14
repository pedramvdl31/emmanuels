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
			$this->role_id = (isset(Auth::user()->roles)) ? Auth::user()->roles : null;
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
	public function getAdd(){

	}
	public function postAdd(){
		$validator = Validator::make(Input::all(), User::$rules_add);

		if ($validator->passes()) {
			$user = new User;
			$user->roles = Input::get('roles');
			$user->username = Input::get('username');
			$user->firstname = Input::get('firstname');
			$user->lastname = Input::get('lastname');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));

		     if($user->save()) { // Save the user and redirect to owners home
		     	return Redirect::action('AdminsController@getIndex')
		     	->with('message', 'New Admin'.$user->username.'Successfully Registered!')
		     	->with('alert_type','alert-success');
		     }

		 } else {
	        // validation has failed, display error messages    
		 	return Redirect::back()
		 	->with('message', 'The following errors occurred')
		 	->with('alert_type','alert-danger')
		 	->withErrors($validator)
		 	->withInput();	    	
		 }				
		}
		public function getEdit($id = null) {

		}
		public function postEdit(){
			$validator = Validator::make(Input::all(), User::$rules_edit);
			if ($validator->passes()) {
				$id = Input::get('id');
	        // validation has passed, save user in DB
				$user = User::find($id);
				$user->roles = Input::get('roles');
				$user->username = Input::get('username');
				$user->firstname = Input::get('firstname');
				$user->lastname = Input::get('lastname');
				$user->email = Input::get('email');
				if(Input::get('password') != ''){    
					$user->password = Hash::make(Input::get('password'));
				}
				if($user->save()) {
					return Redirect::action('AdminsController@getIndex',$id)
					->with('message', 'Admin Successfully Updated')
					->with('alert_type','alert-success');
				} else {
		        // Could not save changes  
					return Redirect::to('admins/index')
					->with('message', 'ops, somthing went wrong. Please try again.')
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
		}
		public function getForgot() {
			$this->layout->content = View::make('admins.forgot');
		}

		public function postDelete()
		{

			// $user_id = Input::get('user_id');
			// $current_user_id = Auth::user()->id;
			// if ($current_user_id != $user_id) {
			// 	$user = User::find($user_id);
			// 	if($user->delete()) {
			// 		return Redirect::action('AdminsController@getIndex')
			// 		->with('message', 'Successfully deleted!')
			// 		->with('alert_type','alert-success');
			// 	} else {
			// 		return Redirect::back()
			// 		->with('message', 'Oops, somthing went wrong. Please try again.')
			// 		->with('alert_type','alert-danger');	
			// 	}
			// } else {
			// 	return Redirect::back()
			// 	->with('message', 'Permission denied.')
			// 	->with('alert_type','alert-danger');
			// }

		}

	}