<?php

class InventoriesController extends \BaseController {
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

	public function getIndex()
	{
		$this->layout->content = View::make('inventories.index');
	}

	public function getAdd()
	{
		$this->layout->content = View::make('inventories.add');
	}
	public function postAdd()
	{
		
	}

	public function getEdit()
	{
		$this->layout->content = View::make('inventories.edit');
	}
	public function postEdit()
	{
		
	}

}