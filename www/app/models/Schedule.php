<?php

class Schedule extends \Eloquent {
	protected $fillable = [];
		use SoftDeletingTrait;

		public static $rules_add = array(
		'name'=>'required|min:1',
		'telephone'=>'required|min:1',
		'street'=>'required|min:1',
		'unit'=>'required|min:1',
		'city'=>'required|min:1',
		'state'=>'required|min:1',
		'zipcode'=>'required|min:1',

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
				$data['street'] = Input::get('new_street') ;
				$data['unit'] = Input::get('new_unit') ;
				$data['city'] = Input::get('new_city') ;
				$data['state'] = Input::get('new_state') ;
				$data['zipcode'] = Input::get('new_zipcode') ;
				
			} else { //OLD ADDRESS
				$data['is_new'] = false;
				$data['street'] = Input::get('street') ;
				$data['unit'] = Input::get('unit') ;
				$data['city'] = Input::get('city') ;
				$data['state'] = Input::get('state') ;
				$data['zipcode'] = Input::get('zipcode') ;
			} 
			//GET AND SET USER INFORMATION
		
			$data['name']= Input::get('name');
			$data['email']= Input::get('email');
			$data['phone']= Input::get('telephone');
			
			//PREPARES ORDERS
			if (Input::get('service_order') || Input::get('item_order')) {

				//PREPARE SERVICE ORDERS
				
				
			}

			
		}
		return $data;
	}

}

