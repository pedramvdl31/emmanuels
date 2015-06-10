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
		Job::dump(Input::all());
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