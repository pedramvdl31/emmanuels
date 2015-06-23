<?php

class SchedulesController extends \BaseController {
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

	public function getIndex()
	{


		$schedules = Schedule::prepareSchedules(Schedule::where('status',1)->get());
		$this->layout->content = View::make('schedules.index')
			->with('schedules',$schedules);

	}

	public function getAdd()
	{

		$searchBy = Delivery::search_by();
		//PUSH IT TO THE SCRIPT FILE
		$this->layout->content = View::make('schedules.add')
		->with('search_by',$searchBy);
	}
	public function postAdd()
	{
		
		$validator = Validator::make(Input::all(), Schedule::$rules_add);
		if ($validator->passes()) { //VALIDATION PASSED
			Job::dump(Input::all());
			//GET ADDRESS START
			if ( 	Input::get('new_street') &&
					Input::get('new_unit') &&
					Input::get('new_city') &&
					Input::get('new_state') &&
					Input::get('new_zipcode')
				) { //NEW ADDRESS WAS SET
				$street = Input::get('new_street') ;
				$unit = Input::get('new_unit') ;
				$city = Input::get('new_city') ;
				$state = Input::get('new_state') ;
				$zipcode = Input::get('new_zipcode') ;
				
			} else { //OLD ADDRESS
				$street = Input::get('street') ;
				$unit = Input::get('unit') ;
				$city = Input::get('city') ;
				$state = Input::get('state') ;
				$zipcode = Input::get('zipcode') ;
			} 
			//GET ADDRESS END

			//GET OTHER INFORMATION

			$will_phone = (Input::get('will_phone') == 1)?true:false;
			$estimate_or_order = Input::get('estimate_or_order');
		





			
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
		$this->layout->content = View::make('schedules.edit');
	}
	public function postEdit()
	{
		
	}

	public function postDelete()
	{
		
	}

	public function postOrderAdd()
	{
		if (Request::ajax()) {
			$status = 400;
			$count  = Input::get('content_set_count');
			$count_form  = Input::get('count_form');
			$html   = Schedule::prepareOrderForm($count,$count_form);
			return Response::json(array(
				'status' => 200,
				'html' => $html
				));
		}
	}
	public function postAjaxValidation() {
		if(Request::ajax()) {
			
			$value = Input::get('value');
			$type = Input::get('type');

			//CREATE ARRAY FOR VALIDATION
			$inputs =  array($type => $value);

			//VALIDATION
			$data = Job::AjaxValidation($inputs,$type);

			return Response::json(array(
				'data' => $data,
				));
		}
	}
}