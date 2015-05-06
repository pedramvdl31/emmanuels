<?php

class TaxesController extends \BaseController {
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
		$taxes = Tax::prepareForView(Tax::orderBy('zipcode')->get());
		$this->layout->content = View::make('taxes.index')
			->with('taxes',$taxes);
	}

	public function getAdd()
	{
		$this->layout->content = View::make('taxes.add');
	}
	public function postAdd()
	{
		
	}

	public function getEdit($id = null)
	{
		$this->layout->content = View::make('taxes.edit');
	}
	public function postEdit()
	{
		
	}

	public function postDelete()
	{
		$tax_id = Input::get('tax_id');
		$tax = Tax::find($tax_id);
		if($tax->delete()) {
			return Redirect::action('TaxesController@getIndex')
			->with('message', 'Successfully deleted!')
			->with('alert_type','alert-success');
		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}
}