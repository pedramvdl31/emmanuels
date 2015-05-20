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

		$this->role_id = (isset(Auth::user()->roles)) ? Auth::user()->roles : null;
	}
	public function getIndex() {
		if ($this->role_id == 1) {
			$user_id = Auth::user()->id;
			$users = User::prepare(User::all());
			$this->layout->content = View::make('users.index')
			->with('user_id',$user_id)
			->with('users',$users);
		} else if($this->role_id == 2) {
			$user_id = Auth::user()->id;
			$users = User::prepare(User::whereNotIn('roles', array(1))->get());
			$this->layout->content = View::make('users.index')
			->with('user_id',$user_id)
			->with('users',$users);
		}
	}

	public function getAdd() {
		$roles = Admin::roles();
		$this->layout->content = View::make('users.add')
		->with('roles',$roles);
	}

	public function postAdd() {
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
		     	return Redirect::action('UsersController@getIndex')
		     	->with('message', 'New User '.$user->username.' Successfully Registered!')
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
		$roles = Admin::roles();
		$admins = User::find($id);
		$this->layout->content = View::make('users.edit')
		->with('roles',$roles)
		->with('admins',$admins);
	}

	public function postEdit() {
		
		$current_user_id = Auth::user()->id;
		$id = Input::get('id');
		$username = Input::get('username');
		$save_user = User::find($id);
		if ($save_user->username == $username) {
			$validator = Validator::make(Input::all(), User::$rules_edit_name);
		} else {
			$validator = Validator::make(Input::all(), User::$rules_edit);
		}
		if ($validator->passes()) {

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
				return Redirect::action('UsersController@getIndex',$id)
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

	public function postDelete()
	{

		$user_id = Input::get('user_id');
		$current_user_id = Auth::user()->id;
		if (($current_user_id != $user_id) && ($this->role_id < 3)) {
			$user = User::find($user_id);
			if($user->delete()) {
				return Redirect::action('UsersController@getIndex')
				->with('message', 'Successfully deleted!')
				->with('alert_type','alert-success');
			} else {
				return Redirect::back()
				->with('message', 'Oops, somthing went wrong. Please try again.')
				->with('alert_type','alert-danger');	
			}
		} else {
			return Redirect::back()
			->with('message', 'Permission denied.')
			->with('alert_type','alert-danger');
		}

	}
}