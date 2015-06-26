<?php

class Schedule extends \Eloquent {
	protected $fillable = [];
	use SoftDeletingTrait;

	public static $rules_add = array(
			//DISABLED FOR NOW, UNTIL ADDING CONDITION FROM NEW ADDRESS

		// 'name'=>'required|min:1',
		// 'telephone'=>'required|min:1',
		// 'street'=>'required|min:1',
		// 'unit'=>'required|min:1',
		// 'city'=>'required|min:1',
		// 'state'=>'required|min:1',
		// 'zipcode'=>'required|min:1',

		);

	public static function prepareSchedules($data) {
		if(isset($data)) {
			foreach ($data as $key => $value) {
				
				if(isset($data[$key]['status'])) {
					switch($data[$key]['status']) {
						case 1:
						$data[$key]['status_html'] = '<span class="label label-success">active</span>';
						break;

						case 2:
						$data[$key]['status_html'] = '<span class="label label-warning">not active</span>';
						break;

						case 3:
						$data[$key]['status_html'] = '<span class="label label-danger">errors</span>';
						break;
					}
				}
			}
		}
		return $data;
	}

	public static function prepareOrderForm($count,$count_form) {
		$services = Service::all();
		$inventories = Inventory::all();
		$inventory_items = InventoryItem::all();

		$html = '';
		$html .= '<div class="panel panel-success content-set" this_set="'.$count_form.'" style="margin-top:10px;">';

		$html .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
		$html .= 'data-parent="#accordion" href="#accordion-'.$count_form.'" aria-expanded="true" aria-controls="collapseOne"';
		$html .= 'style="cursor: pointer;">';
		$html .= '<h4 class="panel-title">';
		$html .= '<a class="this-title">';
		$html .= 'Order '.($count+1);
		$html .= '</a>';
		$html .= '<a>';
		$html .= '<i class="glyphicon glyphicon-chevron-down pull-right"></i>';
		$html .= '</a>';
		$html .= '</h4>';
		$html .= '</div>';
		//here is the bug
		$html .= '<div id="accordion-'.$count_form.'" this_set="'.$count_form.'" class="panel-collapse collapse in collapse-'.$count_form.'" role="tabpanel" aria-labelledby="headingOne">';
		$html .= '<div class="panel-body panel-input">';

		$html .= '	<div class="form-group">
		<div class="radio">
		<label>
		<input type="radio" class="radio-option " name="content_radio_'.$count_form.'" id="service-radio" value="1">
		Services
		</label>
		</div>
		<div class="radio " >
		<label>
		<input type="radio" class="radio-option" name="content_radio_'.$count_form.'" id="item-radio" value="2">
		Items
		</label>
		</div>
		</div>';

		//RADIO ERROR
		$html .= '<span class="radio-error help-block hide" style="color:#a94442;">Please complete the order</span>';

		$html .= '<div class="form-group form-group-make hide make-form-'.$count_form.' ">';
		$html .= '<label class="control-label" for="make">MAKE</label>';
		$html .= '<select class="form-control select-make" status="" name="select-make-'.$count_form.'" id="select-make-'.$count_form.'">';
		$html .= '<option value="">Select Service</option>';
		foreach ($services as $key => $value) {
			$html .=	'<option value="'.$value->id.'" rate="'.$value->rate.'">'.$value->name.'</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		//MAKE ERROR
		$html .= '<span class="make-error help-block hide" style="color:#a94442;">Service must be selected!</span>';


		$html .= '<div class="form-group form-group-item hide item-form-'.$count_form.'">';
		$html .= '<label class="control-label" for="item">ITEM</label>';
		$html .= '<select class="form-control select-item" status="" name="select-item-'.$count_form.'" id="select-item-'.$count_form.'">';
		$html .= '<option value="">Select Item</option>';
		foreach ($inventories as $key => $value) {
			$html .= '<optgroup label='.$value->name.'>';
			foreach ($inventory_items as $ikey => $ivalue) {
				if ($ivalue->inventory_id == $value->id) {
					$html .=	'<option value="'.$ivalue->id.'" rate="'.$ivalue->price.'">'.$ivalue->name.'</option>';
				}
			}
			$html .= '</optgroup>';
		}
		$html .= '</select>';
		$html .= '</div>';
		//ITEM ERROR
		$html .= '<span class="item-error help-block hide" style="color:#a94442;">at least 1 Item must be selected!</span>';

		$html .= '<div class="form-group form-group-qty hide qty-form-'.$count_form.'">';
		$html .= '<label class="control-label" for="quantity">QUANTITY</label>';
		$html .= '<div class="input-group">
		<span class="input-group-addon minus-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-minus" > </i></span>
		<input type="text" class="form-control qty" disabled="disabled" id="qty-'.$count_form.'" aria-label="Amount (to the nearest dollar)"  name="qty-'.$count_form.'" placeholder="0">
		<span class="input-group-addon add-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-plus" > </i></span>
		</div>';
		$html .= '</div>';
		//QTY ERROR
		$html .= '<span class="qty-error help-block hide" style="color:#a94442;">Please add an item</span>';
		


		$html .= '												
		<div class="form-group form-group-di form-inline hide di-form-'.$count_form.'" >
		<div class="col-sm-2" style="padding-left:0;">
		<label class="control-label" >Height</label>
		</div>
		<div class="input-group form-group-height col-sm-4 col-xs-12 pull-left">
		<input type="text" class="form-control height" disabled="disabled" id="height-'.$count_form.'" name="height-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
		<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-vertical"></i></span>
		</div>
		<div class=" col-sm-2">
		<label class="control-label">Length</label>
		</div>
		<div class="input-group form-group-length col-sm-4 col-xs-12 pull-left"">
		<input type="text" disabled="disabled" class="form-control length" id="length-'.$count_form.'" name="length-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
		<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-horizontal"></i></span>
		</div>

		</div>';

		$html .= '<span class="di-error help-block hide" style="color:#a94442;">height and lenght are required</span>';

		$html .= '<div class="form-group form-group-rate hide rate-form-'.$count_form.'">';
		$html .= '<label class="control-label" for="rate">RATE</label>';
		$html .= '<input id="rate-'.$count_form.'" type="text" name="rate-'.$count_form.'" class="form-control content-rate" disabled="disabled" placeholder="00.0 $">';
		$html .= '</div>';

		$html .= '<div class="form-group form-group-price hide price-form-'.$count_form.'">';
		$html .= '<label class="control-label" for="price">PRICE</label>';
		$html .= '<input type="text" name="total-'.$count_form.'" class="form-control content-price" id="total-'.$count_form.'" disabled="disabled" placeholder="00.0 $">';
		$html .= '</div>';

		$html .= '</div>';
		$html .= '</div>';
		$html .= '';
		$html .= '<div class="panel-footer clearfix">';
		$html .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
		$html .= '</div>';

		$html .= '</div>';
		return $html;
	}
	//PREPARE ORDERS FROM SESSION
	public static function prepareOrderFromSession($preview_data){
		$services = Service::all();
		$inventories = Inventory::all();
		$inventory_items = InventoryItem::all();
		$html = '';
		$count_form = 0;
		if (isset($preview_data)) {
			if (isset($preview_data['service_order'])) {
				foreach ($preview_data['service_order'] as $pd_key => $pd_value) {

					$count_form = $count_form + 1;
					$html .= '<div class="panel panel-success content-set" this_set="'.$count_form.'" style="margin-top:10px;">';

					$html .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
					$html .= 'data-parent="#accordion" href="#accordion-'.$count_form.'" aria-expanded="true" aria-controls="collapseOne"';
					$html .= 'style="cursor: pointer;">';
					$html .= '<h4 class="panel-title">';
					$html .= '<a class="this-title">';
					$html .= 'Order '.($count_form);
					$html .= '</a>';
					$html .= '<a>';
					$html .= '<i class="glyphicon glyphicon-chevron-down pull-right"></i>';
					$html .= '</a>';
					$html .= '</h4>';
					$html .= '</div>';
					
					$html .= '<div id="accordion-'.$count_form.'" this_set="'.$count_form.'" class="panel-collapse collapse in collapse-'.$count_form.'" role="tabpanel" aria-labelledby="headingOne">';
					$html .= '<div class="panel-body panel-input">';

					$html .= '	<div class="form-group">
					<div class="radio">
					<label>
					<input type="radio" class="radio-option " checked name="content_radio_'.$count_form.'" id="service-radio" value="1">
					Services
					</label>
					</div>
					<div class="radio " >
					<label>
					<input type="radio" class="radio-option" name="content_radio_'.$count_form.'" id="item-radio" value="2">
					Items
					</label>
					</div>
					</div>';

					//RADIO ERROR
					$html .= '<span class="radio-error help-block hide" style="color:#a94442;">Please complete the order</span>';
//xxx
					$html .= '<div class="form-group form-group-make  make-form-'.$count_form.' ">';
					$html .= '<label class="control-label" for="make">MAKE</label>';
					$html .= '<select class="form-control select-make" status=""  name="select-make-'.$count_form.'" id="select-make-'.$count_form.'">';
					$html .= '<option rate="'.$pd_value['rate'].'" value="'.$pd_value['id'].'">'.$pd_value['name'].'</option>';
					foreach ($services as $key => $value) {
						//ADD THE ITEMS EXCEPT FOR THE ONE THAT IS CHOSEN
						if ($pd_value['id'] != $value->id) {
							$html .=	'<option value="'.$value->id.'" rate="'.$value->rate.'">'.$value->name.'</option>';
						}
					$html .= '</select>';
					$html .= '</div>';
					//MAKE ERROR
					$html .= '<span class="make-error help-block hide" style="color:#a94442;">Service must be selected!</span>';


					$html .= '<div class="form-group form-group-item  item-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="item">ITEM</label>';
					$html .= '<select class="form-control select-item" status="" name="select-item-'.$count_form.'" id="select-item-'.$count_form.'">';
					$html .= '<option  value="'.$pd_value['item_id'].'">'.$pd_value['item_name'].' </option>';
					foreach ($inventories as $key => $value) {
						$html .= '<optgroup label='.$value->name.'>';
						foreach ($inventory_items as $ikey => $ivalue) {
							if ($ivalue->inventory_id == $value->id) {
								if ($pd_value['item_id'] != $ivalue->id) {
								$html .=	'<option value="'.$ivalue->id.'" rate="'.$ivalue->price.'">'.$ivalue->name.'</option>';
								}
							}
						}
						$html .= '</optgroup>';
					}
					$html .= '</select>';
					$html .= '</div>';
					//ITEM ERROR
					$html .= '<span class="item-error help-block hide" style="color:#a94442;">at least 1 Item must be selected!</span>';

					$html .= '<div class="form-group form-group-qty hide qty-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="quantity">QUANTITY</label>';
					$html .= '<div class="input-group">
					<span class="input-group-addon minus-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-minus" > </i></span>
					<input type="text" class="form-control qty" disabled="disabled" id="qty-'.$count_form.'" aria-label="Amount (to the nearest dollar)"  name="qty-'.$count_form.'" placeholder="0">
					<span class="input-group-addon add-q" parents="'.$count_form.'"><i class="glyphicon glyphicon-plus" > </i></span>
					</div>';
					$html .= '</div>';
					//QTY ERROR
					$html .= '<span class="qty-error help-block hide" style="color:#a94442;">Please add an item</span>';



					$html .= '												
					<div class="form-group form-group-di form-inline di-form-'.$count_form.'" >
					<div class="col-sm-2" style="padding-left:0;">
					<label class="control-label" >Height</label>
					</div>
					<div class="input-group form-group-height col-sm-4 col-xs-12 pull-left">
					<input type="text" class="form-control height" value="'.$pd_value['height'].'" id="height-'.$count_form.'" name="height-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-vertical"></i></span>
					</div>
					<div class=" col-sm-2">
					<label class="control-label">Length</label>
					</div>
					<div class="input-group form-group-length col-sm-4 col-xs-12 pull-left"">
					<input type="text" value="'.$pd_value['length'].'" class="form-control length" id="length-'.$count_form.'" name="length-'.$count_form.'" placeholder="0" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-horizontal"></i></span>
					</div>

					</div>';
//xxxx
					$html .= '<span class="di-error help-block hide" style="color:#a94442;">height and lenght are required</span>';

					$html .= '<div class="form-group form-group-rate rate-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="rate">RATE</label>';
					$html .= '<input id="rate-'.$count_form.'" value="'.$pd_value['rate'].'$" rate="'.$pd_value['rate'].'" type="text" name="rate-'.$count_form.'" class="form-control content-rate" disabled="disabled" placeholder="00.0 $">';
					$html .= '</div>';

					$html .= '<div class="form-group form-group-price price-form-'.$count_form.'">';
					$html .= '<label class="control-label" for="price">PRICE</label>';
					$html .= '<input type="text" value="'.$pd_value['total'].'$" name="total-'.$count_form.'" class="form-control content-price" id="total-'.$count_form.'" disabled="disabled" placeholder="00.0 $">';
					$html .= '</div>';

					$html .= '</div>';
					$html .= '</div>';
					$html .= '';
					$html .= '<div class="panel-footer clearfix">';
					$html .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
					$html .= '</div>';

					$html .= '</div>';
				}
				
			}
		}
		return $html;
	}

	public static function prepareAllForPreview($Input_all) {
		$data = [];

		if(isset($Input_all)) {

			// CHECK IF THE ADDRESS WAS NEW
			if ( 	$Input_all['new_street'] &&
				$Input_all['new_unit'] &&
				$Input_all['new_city'] &&
				$Input_all['new_state'] &&
				$Input_all['new_zipcode']
				) { //NEW ADDRESS WAS SET
				$data['is_new'] = true;
			$data['new_street'] = Input::get('new_street') ;
			$data['new_unit'] = Input::get('new_unit') ;
			$data['new_city'] = Input::get('new_city') ;
			$data['new_state'] = Input::get('new_state') ;
			$data['new_zipcode'] = Input::get('new_zipcode') ;

			$data['street'] = "";
			$data['unit'] = "";
			$data['city'] = "";
			$data['state'] = "";
			$data['zipcode'] = "";

			} else { //OLD ADDRESS
				$data['is_new'] = false;
				$data['street'] = Input::get('street') ;
				$data['unit'] = Input::get('unit') ;
				$data['city'] = Input::get('city') ;
				$data['state'] = Input::get('state') ;
				$data['zipcode'] = Input::get('zipcode') ;

				$data['new_street'] = "";
				$data['new_unit'] = "";
				$data['new_city'] = "";
				$data['new_state'] = "";
				$data['new_zipcode'] = "";
			} 

			//IS IT ORDER OR ESTIMATE, ESTIMATE=1, ORDER=2
			if (Input::get('estimate_or_order')) {

				if (Input::get('estimate_or_order') == 1) {
					$data['estimate'] = "checked";
					$data['order'] = "";
				} else {
					$data['order'] = "checked";
					$data['estimate'] = "";
				}
			}

			//WHERE WILL PHONE CHECKED OR NOT 
			if (Input::get('will_phone')) {
				$data['will_phone'] = "checked";
			} else {
				$data['will_phone'] = "";
			}

			//GET AND SET USER INFORMATION

			$data['name']= Input::get('name');
			$data['email']= Input::get('email');
			$data['phone']= Input::get('telephone');
			
			//PREPARES ORDERS
			if (Input::get('service_order') || Input::get('item_order')) {
				$data['subtotal'] = 0;
				//PREPARE SERVICE ORDERS
				if (Input::get('service_order')) {
					$service_orders = Input::get('service_order');
					foreach ($service_orders as $key => $s_o) {
						$services = Service::find($s_o['id']);
						$data['service_order'][$key]['type']= "Services";
						$data['service_order'][$key]['id']= $services->id;
						$data['service_order'][$key]['name']= $services->name;
						$data['service_order'][$key]['description']= $services->description;
						//FIND THE ITEM
						$items = InventoryItem::find($s_o['item_id']);
						$data['service_order'][$key]['item_name']= $items->name;
						$data['service_order'][$key]['item_id']= $items->id;

						//SET TWO DECIMAL PLACES
						$data['service_order'][$key]['rate']= number_format($services->rate, 2);
						$data['service_order'][$key]['height']= $s_o['height'];
						$data['service_order'][$key]['length']= $s_o['length'];

						// ONLY FOR SESSION
						$data['service_order'][$key]['total']= $s_o['length'] * $s_o['height'] * $services->rate;

						//CALCULATE SUBTOTAL
						$data['subtotal'] = $data['subtotal'] + $services->rate;
					}
				}
				//PREPARE ITEM ORDERS
				if (Input::get('item_order')) {
					$item_orders = Input::get('item_order');
					foreach ($item_orders as $ikey => $i_o) {
						//GET ITEM ID
						$items = InventoryItem::find($i_o[0]);
						$data['item_order'][$ikey]['id']= $items->id;
						$data['item_order'][$ikey]['name']= $items->name;
						$data['item_order'][$ikey]['price']= $items->price;
						$data['item_order'][$ikey]['description']= $items->description;
						$data['item_order'][$ikey]['qty']= count($i_o);
						//CALCULATE THE TOTAL 
						$total = count($i_o) * $items->price;
						//SET TWO DECIMAL PLACES
						$data['item_order'][$ikey]['total'] = number_format($total, 2) ;
						$data['subtotal'] = $data['subtotal'] + $total;
					}
				}
				//SET TAX PRICE, SEATTLE 9.5%
				$taxes = Tax::find(1);
				$tax_rate = $taxes->rate;
				$data['tax_rate'] = $tax_rate * 100;
				//TAX FOR SALE
				$taxed = $tax_rate * $data['subtotal'];
				$data['tax'] = number_format($taxed, 2);
				//GET TOTAL AFTER TAX
				$total_after_tax = $data['tax'] + $data['subtotal'];
				$data['total_after_tax'] = $total_after_tax;
			}//END OF ORDERS

			
		}
		return $data;
	}

}

