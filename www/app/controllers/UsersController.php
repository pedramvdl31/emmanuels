<?php

class UsersController extends BaseController {
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
	public function getIndex() {
        /**
        * ACL Required page
        **/
        
        // if(Acl::isAllowed(Admin::getRoleName(Auth::user()->roles), 'users', 'index') == false) {
        //     return Redirect::back()->with('message','You are not authorized to view this page!')->with('alert_type','alert-danger')->withInput();
        // }
        /**
        * Begin Page Processing
        **/
		$this->layout->content = View::make('users.index');
	}

	public function getAdd() {
		$this->layout->content = View::make('users.add');
	}

	public function postAdd() {
		$validator = Validator::make(Input::all(), User::$rules);
	 
	    if ($validator->passes()) {
	        // validation has passed, save user in DB
	        $user = new User;
	        $user->username = Input::get('username');
		    $user->firstname = Input::get('firstname');
		    $user->lastname = Input::get('lastname');
		    $user->email = Input::get('email');
		    $user->password = Hash::make(Input::get('password'));
		    $user->roles = 1;
		    $user->save();

		    return Redirect::to('users')
		    	->with('message', 'Successfully Registered User!')
		    	->with('alert_type','alert-success');

	    } else {
	        // validation has failed, display error messages    
	        return Redirect::action('UsersController@getAdd')
	        	->with('message', 'The following errors occurred')
	        	->with('alert_type','alert-danger')
	        	->withErrors($validator)
	        	->withInput();
	    }
	}

	public function getEdit() {	
		$this->layout->content = View::make('users.edit');
	}

	public function postEdit() {

	}




}