<?php

class ForgetsController extends \BaseController {

	protected $layout = 'layouts.frontend';
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

	    $nav_html = Website::prepareNavBar();
    	View::share('nav_html', $nav_html);
	}

	public function getIndex()
	{
		
		$this->layout->content = View::make('forgets.index');
	}

	public function getAdd()
	{
		
	}
	public function postAdd()
	{
		
	}

	public function getEdit($id = null)
	{
	
	}
	public function postEdit()
	{
		
	}

	public function postDelete()
	{
		
	}


}