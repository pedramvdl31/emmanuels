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

		// if ($this->role_id < 3) {
		// 	$companies = Company::find(1);
		// 	$schedules = Schedule::prepare(Schedule::where('status',1)->get());
		$this->layout->content = View::make('schedules.index');
			// ->with('schedules',$schedules)
			// ->with('companies',$companies);
		// }
	}

	public function getAdd()
	{

		$searchBy = Delivery::search_by();
		$this->layout->content = View::make('schedules.add')
		->with('search_by',$searchBy);
	}
	public function postAdd()
	{
		
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
			$html   = Schedule::prepareOrderForm($count);
			return Response::json(array(
				'status' => 200,
				'html' => $html
				));
		}
	}
}