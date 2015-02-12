<?php

class RemindersController extends BaseController {
	//set layout
	protected $layout = 'layouts.admin';
	
	public function __construct() {
		if(Auth::check() == true){
			// Set the layout
			switch(Auth::user()->roles){
				case 3:
					$this->layout = "layouts.admin_owner";
				break;
				case 4:
					$this->layout = "layouts.admin_employees";
				break;
				case 5:
					$this->layout = "layouts.admin_members";
				break;
				case 6:
					$this->layout = "layouts.admin";
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

	        $owner_id = User::getOwnerId(Auth::user()->id,'2');
	        $company_id = (Auth::user()->roles == 3) ? Company::where('owner_id',$owner_id)->pluck('id') : null;
	        
	        $role_id = (isset($member_id)) ? Auth::user()->roles : null;
	        $role_name = Admin::getRoleName($role_id);
		
	        View::share('role',$role_name);
	        View::share('company_id',$company_id);
	       	View::share('controller',$this->controller);
			View::share('action',$this->method);
		} 
		else{
			$this->layout="layouts.admin_guest";
		}

		// Set protection
		$this->beforeFilter('csrf', array('on'=>'post'));
	}
	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getForgot()
	{
		$this->layout->content = View::make('reminders.password');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postForgot()
	{
		$response = Password::remind(Input::only('email'), function($message){
		$message->subject('Reset your password'); 
		});
		switch ($response)
		{
			case Password::INVALID_USER:
				return Redirect::back()
					->with('message', Lang::get($response))
					->with('alert_type','alert-warning');
			break;

			case Password::REMINDER_SENT:
				//update users table with token
				return Redirect::back()
					->with('message', Lang::get($response))
					->with('alert_type','alert-success');
			break;
		}
	
	}
	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);
		
		$this->layout->content = View::make('reminders.reset')
				->with('token', $token);
		
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
			$validator = Validator::make(Input::all(), User::$rules_reset);
		    if ($validator->passes()) {
				$credentials = Input::only(
					'email', 'password', 'password_confirmation', 'token'
				);
				$response = Password::reset($credentials, function($user, $password)
				{
					$user->password = Hash::make($password);
					$user->_token = Input::get('token');
					$user->save();
				});

				switch ($response)
				{

					case Password::INVALID_TOKEN:
						return Redirect::back()
							->with('message', Lang::get($response))
							->with('alert_type','alert-warning');
						break;
					case Password::INVALID_USER:
						return Redirect::back()
							->with('message', Lang::get($response))
							->with('alert_type','alert-warning');
						break;
					case Password::PASSWORD_RESET:
						return Redirect::to('/'); // redirect back()
						break;
				}
		}
		else {
	        // validation has failed, display error messages    
	        return Redirect::back()
	        	->with('message', 'The following errors occurred')
	        	->with('alert_type','alert-danger')
	        	->withErrors($validator)
	        	->withInput();	
	    }	

	}
}
