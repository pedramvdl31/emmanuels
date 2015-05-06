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
		$user_role = Auth::user()->roles;
		$inventories = (isset($id)) ? Inventory::prepareInventory(Inventory::where('company_id',$id)->get()) : Inventory::prepareInventory(Inventory::all());
		$companies = Company::find(1);

		//NEEDS TO BE CHANGE LATER
		$company_id = 1;
		$this->layout->content = View::make('inventories.index')
		->with('inventories',$inventories)
		->with('companies',$companies)
		->with('user_role',$user_role)
		->with('company_id',$company_id);
	}

	public function getAdd()
	{
		$this->layout->content = View::make('inventories.add');
	}
	public function postAdd()
	{
		
	}

	public function getEdit($id = null)
	{
		$this->layout->content = View::make('inventories.edit');
	}
	public function postEdit()
	{
		
	}

	public function postDelete()
	{
		$inventory_id = Input::get('inventory_id');
		$inventory = Inventory::find($inventory_id);
		$count = count(InventoryItem::where('inventory_id',$inventory_id)->where('company_id',$inventory->company_id)->get());
		$inventory_items = InventoryItem::where('inventory_id',$inventory_id)->where('company_id',$inventory->company_id)->get();
		if($count>0){
			if($inventory->delete() && $inventory_items->delete()) {
				return Redirect::back()
				->with('message', 'Successfully Deleted!')
				->with('alert_type','alert-success');

			} else {
				return Redirect::back()
				->with('message', 'Oops, somthing went wrong. Please try again. items and inventories')
				->with('alert_type','alert-danger');	
			}

		} elseif($inventory->delete()) {

			return Redirect::back()
			->with('message', 'Successfully Deleted!')
			->with('alert_type','alert-success');

		} else {
			return Redirect::back()
			->with('message', 'Oops, somthing went wrong. Please try again.')
			->with('alert_type','alert-danger');	
		}
	}

}