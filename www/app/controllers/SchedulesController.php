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
		//CLEAROUT ALL SESSIONS
		if (Session::get('preview_data'))
			Session::forget('preview_data');

		$schedules = Schedule::prepareSchedules(Schedule::where('status',1)->get());
		$this->layout->content = View::make('schedules.index')
		->with('schedules',$schedules);
	}

	public function getAdd()
	{
		//CHECK IF PREVIEW SESSION EXISTS, IF SO THE USER IS COMING BACK FROM PREVIEW PAGE
		if (Session::get('preview_data')){
			$searchBy = Delivery::search_by();

			//PREPARE HTML ORDERS FOR VIEW
			$preview_session = Session::get('preview_data');
			$orders_html   = Schedule::prepareOrderFromSession($preview_session);
			
			$this->layout->content = View::make('schedules.add')
			->with('search_by',$searchBy)
			->with('preview_data',Session::get('preview_data'))
			->with('orders_html',$orders_html);

		} else {
			$searchBy = Delivery::search_by();
			$this->layout->content = View::make('schedules.add')
			->with('search_by',$searchBy);
		}
	}

	public function postPreview()
	{
		$validator = Validator::make(Input::all(), Schedule::$rules_add);
		if ($validator->passes()) { //VALIDATION PASSED

			if (Session::get('preview_data'))
				Session::forget('preview_data');
			$prepared_data = Schedule::prepareAllForPreview(Input::all());
			//SAVE ALL THE DATA IN SESSION FOR EDITING PURPOSES
			Session::put('preview_data', $prepared_data);
			//EVERYTHING LOOKS GOOD FORWARD TO PREVIEW PAGE FOR APPROVAL
			$this->layout->content = View::make('schedules.preview')
			->with('input_all',$prepared_data);
		} 	else {
		// validation has failed, display error messages    
			return Redirect::back()
			->with('message', 'The following errors occurred')
			->with('alert_type','alert-danger')
			->withErrors($validator)
			->withInput();	    	
		}	
	}

		public function postAdd()
	{
		if (Session::get('preview_data')) {
			//GET ALL DATA
			$all_inputs = Session::get('preview_data');

			//GET ADDRESS START
			$street = $all_inputs['street'];
			$unit = $all_inputs['unit'];
			$city = $all_inputs['city'];
			$state = $all_inputs['state'];
			$zipcode = $all_inputs['zipcode'];
			//GET USER INFO
			if (isset($all_inputs['user_id'])) {
				$user_id = $all_inputs['user_id'];
			} else {
				$user_id = null;
			}
			$name = $all_inputs['name'];
			$email = $all_inputs['email'];
			$phone = $all_inputs['phone'];
			//GET OTHER INFORMATION
			$will_phone = ($all_inputs['will_phone'] == 1)?true:false;
			//WILL BE SAVE AS TYPE
			$estimate_or_order = $all_inputs['estimate_or_order'];

			//COUNT THE TOTAL NUMBER OF ORDERS, INCLUDING BOTH SERVICES AND ITEMS
			$orders_count = 0;
			if (isset($all_inputs['service_order'])) {//SERVICES
				$services_count = count($all_inputs['service_order']);
				$orders_count = $orders_count + $services_count;
			}
			if (isset($all_inputs['item_order'])) {//ITEM
				$items_count = count($all_inputs['item_order']);
				$orders_count = $orders_count + $items_count;
			}

			//SET PRICES
			$total_before_tax = $all_inputs['total_befor_tax'];
			$total_after_tax = $all_inputs['total_after_tax'];
			$tax = $all_inputs['tax'];


			//PROCESSING THE INVOICE AND INVOICE ITEMS
			if (isset($all_inputs['service_order']) || isset($all_inputs['item_order'])) {
				$invoice = new Invoice;
				//WORK ORDER OR ESTIMATE
				$invoice->type = $estimate_or_order;
				//EMPTY FOR NOW
				$invoice->description = null;
				//TOTAL ORDERS
				$invoice->quantity = $orders_count;
				$invoice->pretax = $total_before_tax;
				$invoice->tax = $tax;
				//TOTAL AFTER TAX
				$invoice->total = $total_after_tax;
				$invoice->status = 1;
				if($invoice->save()) { //IF SUCCESS, SAVE EACH ORDERS SEPARATELY
					if (isset($all_inputs['service_order'])) {//SERVICES

						foreach ($all_inputs['service_order'] as $so_key => $so_value) {
							$invoice_item = new InvoiceItem();
							$invoice_item->invoice_id = $invoice->id;
							//TYPE 1 IS SERVICE
							$invoice_item->type = 1;
							$invoice_item->inventory_item_id = $so_value['id'];
							$invoice_item->total = $so_value['total'];
							$invoice_item->height = $so_value['height'];
							$invoice_item->length = $so_value['length'];
							//THIS IS NOT THE SERVICE ID(NOT MAKE), ITS THE ITEM BELLOW MAKE IN THE FORM
							$invoice_item->item_id = $so_value['item_id'];
							$invoice_item->status = 1;
							$invoice_item->save();
						}

					}
					if (isset($all_inputs['item_order'])) {//ITEM
						foreach ($all_inputs['item_order'] as $io_key => $io_value) {
							$invoice_item = new InvoiceItem();
							$invoice_item->invoice_id = $invoice->id;
							//TYPE 2 IS ITEM
							$invoice_item->type = 2;
							$invoice_item->inventory_item_id = $io_value['id'];
							$invoice_item->total = $io_value['total'];
							$invoice_item->quantity = $io_value['qty'];
							$invoice_item->status = 1;
							$invoice_item->save();
						}
					}
					//SAVE THE SCHEDULE
					$schedules = new Schedule();
					//INVOICE ID
					$schedules->invoice_id = $invoice->id;
					//FOR NOW FIRSTNAME HOLDS BOTH FIRST NAME AND LAST NAME
					//INFO
					$schedules->user_id = $user_id;
					$schedules->firstname = $name;
					$schedules->email = $email;
					$schedules->phone = $phone;
					//ADDRESS
					$schedules->street = $street;
					$schedules->unit = $unit;
					$schedules->city = $city;
					$schedules->state = $state;
					$schedules->zipcode = $zipcode;
					//OTHER INFO
					//TYPE 1 = SERVICE, 2 = ITEM
					$schedules->type = $estimate_or_order;
					$schedules->will_phone = $will_phone;
					$schedules->status = 1;

					if ($schedules->save()) { // Save
						//FORGET THE SESSION
		            	if (Session::get('preview_data'))
		            		Session::forget('preview_data');
		            	return Redirect::action('SchedulesController@getIndex')
		            	->with('message', 'Successfully added a Schedule')
		            	->with('alert_type', 'alert-success');
		            } else {
		            	return Redirect::back()
		            	->with('message', 'Oops, somthing went wrong. Please try again.')
		            	->with('alert_type', 'alert-danger');
		            }
				}
			}
		} else {
			//SOMTHING WENT WRONG SESSION NOT SUPPOSED TO BE EMPTY
		}
	}

	public function getEdit($id = null)
	{
		if (isset($id)) {

			$searchBy = Delivery::search_by();
			$prepared_data = Schedule::prepareDataForEdit($id);
			$orders_html   = Schedule::prepareOrderFromSession($prepared_data);
			

			$this->layout->content = View::make('schedules.edit')
			->with('search_by',$searchBy)
			->with('preview_data',$prepared_data)
			->with('orders_html',$orders_html);
		}
		
	}
	public function postEdit()
	{
		if (Session::get('preview_data')) {
			//GET ALL DATA
			$all_inputs = Session::get('preview_data');

			//GET ADDRESS START
			$street = $all_inputs['street'];
			$unit = $all_inputs['unit'];
			$city = $all_inputs['city'];
			$state = $all_inputs['state'];
			$zipcode = $all_inputs['zipcode'];
			//GET USER INFO
			if (isset($all_inputs['user_id'])) {
				$user_id = $all_inputs['user_id'];
			} else {
				$user_id = null;
			}
			$name = $all_inputs['name'];
			$email = $all_inputs['email'];
			$phone = $all_inputs['phone'];
			//GET OTHER INFORMATION
			$will_phone = ($all_inputs['will_phone'] == 1)?true:false;
			//WILL BE SAVE AS TYPE
			$estimate_or_order = $all_inputs['estimate_or_order'];

			//COUNT THE TOTAL NUMBER OF ORDERS, INCLUDING BOTH SERVICES AND ITEMS
			$orders_count = 0;
			if (isset($all_inputs['service_order'])) {//SERVICES
				$services_count = count($all_inputs['service_order']);
				$orders_count = $orders_count + $services_count;
			}
			if (isset($all_inputs['item_order'])) {//ITEM
				$items_count = count($all_inputs['item_order']);
				$orders_count = $orders_count + $items_count;
			}

			//SET PRICES
			$total_before_tax = $all_inputs['total_befor_tax'];
			$total_after_tax = $all_inputs['total_after_tax'];
			$tax = $all_inputs['tax'];


			//PROCESSING THE INVOICE AND INVOICE ITEMS
			if (isset($all_inputs['service_order']) || isset($all_inputs['item_order'])) {
				$invoice_id = $all_inputs['invoice_id'];
				$invoice = Invoice::find($invoice_id);
				//WORK ORDER OR ESTIMATE
				$invoice->type = $estimate_or_order;
				//EMPTY FOR NOW
				$invoice->description = null;
				//TOTAL ORDERS
				$invoice->quantity = $orders_count;
				$invoice->pretax = $total_before_tax;
				$invoice->tax = $tax;
				//TOTAL AFTER TAX
				$invoice->total = $total_after_tax;
				$invoice->status = 1;

				//DELETE ALL ITEMS(ORDERS, INVOICE_ITEMS) THAT BELLONG TO THIS INVOICE
				$old_invoice_items = InvoiceItem::where('invoice_id', $invoice_id)->get();
				foreach ($old_invoice_items as $oii_key => $oii_value) {
					$oii_value->delete();
				}


				if($invoice->save()) { //IF SUCCESS, SAVE EACH ORDERS SEPARATELY
					if (isset($all_inputs['service_order'])) {//SERVICES

						foreach ($all_inputs['service_order'] as $so_key => $so_value) {
							$invoice_item = new InvoiceItem();
							$invoice_item->invoice_id = $invoice->id;
							//TYPE 1 IS SERVICE
							$invoice_item->type = 1;
							$invoice_item->inventory_item_id = $so_value['id'];
							$invoice_item->total = $so_value['total'];
							$invoice_item->height = $so_value['height'];
							$invoice_item->length = $so_value['length'];
							//THIS IS NOT THE SERVICE ID(NOT MAKE), ITS THE ITEM BELLOW MAKE IN THE FORM
							$invoice_item->item_id = $so_value['item_id'];
							$invoice_item->status = 1;
							$invoice_item->save();
						}

					}
					if (isset($all_inputs['item_order'])) {//ITEM
						foreach ($all_inputs['item_order'] as $io_key => $io_value) {
							$invoice_item = new InvoiceItem();
							$invoice_item->invoice_id = $invoice->id;
							//TYPE 2 IS ITEM
							$invoice_item->type = 2;
							$invoice_item->inventory_item_id = $io_value['id'];
							$invoice_item->total = $io_value['total'];
							$invoice_item->quantity = $io_value['qty'];
							$invoice_item->status = 1;
							$invoice_item->save();
						}
					}
					$schedule_id = $all_inputs['schedule_id'];
					//SAVE THE SCHEDULE
					$schedules = Schedule::find($schedule_id);
					//INVOICE ID
					$schedules->invoice_id = $invoice->id;
					//FOR NOW FIRSTNAME HOLDS BOTH FIRST NAME AND LAST NAME
					//INFO
					$schedules->user_id = $user_id;
					$schedules->firstname = $name;
					$schedules->email = $email;
					$schedules->phone = $phone;
					//ADDRESS
					$schedules->street = $street;
					$schedules->unit = $unit;
					$schedules->city = $city;
					$schedules->state = $state;
					$schedules->zipcode = $zipcode;
					//OTHER INFO
					//TYPE 1 = SERVICE, 2 = ITEM
					$schedules->type = $estimate_or_order;
					$schedules->will_phone = $will_phone;
					$schedules->status = 1;

					if ($schedules->save()) { // Save
						//FORGET THE SESSION
		            	if (Session::get('preview_data'))
		            		Session::forget('preview_data');
		            	return Redirect::action('SchedulesController@getIndex')
		            	->with('message', 'Successfully added a Schedule')
		            	->with('alert_type', 'alert-success');
		            } else {
		            	return Redirect::back()
		            	->with('message', 'Oops, somthing went wrong. Please try again.')
		            	->with('alert_type', 'alert-danger');
		            }
				}
			}
		} else {
			//SOMTHING WENT WRONG SESSION NOT SUPPOSED TO BE EMPTY
		}
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