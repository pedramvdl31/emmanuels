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
		$today = date('Y-d-m');
		//GET DATA AND SAVE SCHEDULE LIMITS
		$hours_array = Input::get('hours');
		foreach ($hours_array as $hkey => $hvalue) {
			$schedule_limits = new ScheduleLimit;

			if ($hvalue['open'] == "open") {
				$open_hours = strtotime($today.' '.$hvalue['open_hour'].':'.$hvalue['open_minute'].' '.$hvalue['open_ampm']);
				$close_hours = strtotime($today.' '.$hvalue['close_hour'].':'.$hvalue['close_minute'].' '.$hvalue['close_ampm']);
				// FINAL PRODUCT
				$open_date_formated = date('Y-d-m H:i:s',$open_hours);
				$close_date_formated = date('Y-d-m H:i:s',$close_hours);
				$schedule_limits->schedule_hours_open = $open_date_formated;
				$schedule_limits->schedule_hours_close = $close_date_formated;
				$schedule_limits->state = 1;//OPEN
				$schedule_limits->status = 1;

			} else {
				$schedule_limits->state = 2;//CLOSE
				$schedule_limits->status = 1;
			}

			//SAVE 
			$schedule_limits->save();
		}
		//SCHEDULE LIMITS END----------------
		$overwrite = Input::get('overwrite');
		foreach ($overwrite as $okey => $ovalue) {
			$schedule_overwrite = new ScheduleOverwrite;
			//SINGLE
			if ($ovalue['type'] == "single") {
				//SET TYPE
				$schedule_overwrite->type = 1;

				$overwrite_data_strtotime = strtotime($ovalue['date']);
				//FINAL PRODUCT
				$overwrite_data_formated = date('Y-d-m',$overwrite_data_strtotime);
				$schedule_overwrite->overwrite_date = $overwrite_data_formated;

			} else if ($ovalue['type'] == "range"){//RANGE
				//SET TYPE
				$schedule_overwrite->type = 2;

				//OVERWRITE END AND START
				$overwrite_start_strtotime = strtotime($ovalue['start']);
				$overwrite_end_strtotime = strtotime($ovalue['end']); 
				//FINAL PRODUCT
				$overwrite_start_formated = date('Y-d-m',$overwrite_start_strtotime);
				$overwrite_end_formated = date('Y-d-m',$overwrite_end_strtotime);
				
				$schedule_overwrite->overwrite_date_start = $overwrite_start_formated;
				$schedule_overwrite->overwrite_date_end = $overwrite_end_formated;

			}

			//OVERWRITE HOURS
			$ow_open_hours = strtotime($today.' '.$ovalue['open_hour'].':'.$ovalue['open_minute'].' '.$ovalue['open_ampm']);
			$ow_close_hours = strtotime($today.' '.$ovalue['close_hour'].':'.$ovalue['close_minute'].' '.$ovalue['close_ampm']);
			//FINAL PRODUCT
			$ow_open_date_formated = date('Y-d-m H:i:s',$ow_open_hours);
			$ow_close_date_formated = date('Y-d-m H:i:s',$ow_close_hours);
			$schedule_overwrite->overwrite_hours_open = $ow_open_date_formated;
			$schedule_overwrite->overwrite_hours_close = $ow_close_date_formated;

			//NUMBER OF EMPLOYEE
			$number_of_employee = $ovalue['number_of_employee'];
			$schedule_overwrite->number_of_employee = $number_of_employee;
			// SAVE 
			$schedule_overwrite->save();
		}

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