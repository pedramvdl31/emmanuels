<?php

class ScheduleLimitsController extends \BaseController {

	//set layout
	protected $layout = "layouts.admin";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct() {
		// Set protection
		$this->beforeFilter('csrf', array('on'=>'post'));


		// Check if user is authorized to view the page
		$routes = explode("@", Route::currentRouteAction(), 2);     
        $this->controller = strtolower(str_replace('Controller', '', $routes[0]));
        $this->method = $routes[1];
        $this->parameters = Route::current()->parameters();

		// Set the layout
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
			case 6:
				$this->layout = "layouts.admin";
			break;
		}
     
     	// Page content setup

        $this->company_id = 1;
        
        $role_id = (isset($member_id)) ? Auth::user()->roles : null;
        $role_name = Admin::getRoleName($role_id);
	
        View::share('role',$role_name);
       	View::share('controller',$this->controller);
		View::share('action',$this->method);
	    
	}

	public function getIndex()
	{
		$this->layout->content = View::make('schedule_limits.index');
	}
	public function postIndex()
	{
		Job::dump(Input::all());
	}

	public function getAdd()
	{
		$this->layout->content = View::make('schedule_rules.add');
	}
	public function postAdd()
	{
		
	}

	public function getEdit($id = null)
	{
		$this->layout->content = View::make('schedule_rules.edit');
	}
	public function postEdit()
	{
		
	}

	public function postDelete()
	{
		
	}

	public function postAddOverwrite() {
		if(Request::ajax()) {
			$current_count = Input::get('count');
			$html = ScheduleLimit::prepareNewOverwrite($current_count);

			return Response::json(array(
				'html' => $html,
				));
		}
	}
	

	public function postValidateHours() {
		if(Request::ajax()) {
			$data = Input::get('data');

			$validation_result = ScheduleLimit::prepareValidationResults($data);

			return Response::json(array(
				'validation_result' => $validation_result,
				));
		}
	}

	public function postValidateOverWriteHours() {
		if(Request::ajax()) {
			$data = Input::get('data');
			$validation_result = ScheduleLimit::prepareValidationOverWriteResults($data);
			return Response::json(array(
				'validation_result' => $validation_result,
				));
		}
	}

}