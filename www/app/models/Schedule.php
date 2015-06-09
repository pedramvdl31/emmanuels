<?php

class Schedule extends \Eloquent {
	protected $fillable = [];
		use SoftDeletingTrait;

		public static $rules_add = array(
		'name'=>'required|min:1',
		'description'=>'required|min:1',
		'rate' => 'required|min:1|numeric',
		'type' => 'required'
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

	public static function prepareOrderForm($count) {
		$services = Service::all();
		$inventories = Inventory::all();
		$inventory_items = InventoryItem::all();

		$html = '';
		$html .= '<div class="panel panel-success content-set" this_set="'.$count.'" style="margin-top:10px;">';

		$html .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
		$html .= 'data-parent="#accordion" href="#accordion-'.$count.'" aria-expanded="true" aria-controls="collapseOne"';
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
		$html .= '<div id="accordion-'.$count.'" this_set="'.$count.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">';
		$html .= '<div class="panel-body panel-input">';

		$html .= '
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" class="radio-option" name="content_radio" id="service-radio" value="1">
								Services
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" class="radio-option" name="content_radio" id="item-radio" value="2">
								Items
							</label>
						</div>
					</div>';

		$html .= '<div class="form-group hide make-form-'.$count.' ">';
		$html .= '<label class="control-label" for="make">MAKE</label>';
		$html .= '<select class="form-control select-make" status="" name="select-make-'.$count.'" id="select-make-'.$count.'">';
		$html .= '<option value="">Select Service</option>';
		foreach ($services as $key => $value) {
			$html .=	'<option value="'.$value->id.'" rate="'.$value->rate.'">'.$value->name.'</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '<div class="form-group hide item-form-'.$count.'">';
		$html .= '<label class="control-label" for="item">ITEM</label>';
		$html .= '<select class="form-control select-item" status="" name="select-item-'.$count.'" id="select-item-'.$count.'">';
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
		$html .= '<div class="form-group hide qty-form-'.$count.'">';
		$html .= '<label class="control-label" for="quantity">QUANTITY</label>';
		$html .= '<div class="input-group">
					<span class="input-group-addon minus-q"><i class="glyphicon glyphicon-minus"> </i></span>
					<input type="text" class="form-control qty" id="qty-'.$count.'" aria-label="Amount (to the nearest dollar)" value="0" name="qty-'.$count.'">
					<span class="input-group-addon add-q"><i class="glyphicon glyphicon-plus"> </i></span>
					</div>';
		$html .= '</div>';
		$html .= '												
		<div class="form-group form-inline hide di-form-'.$count.'" >
			<div class="col-sm-1" style="padding-left:0;">
				<label class="control-label" >Height</label>
			</div>
			<div class="input-group  col-sm-5 col-xs-12 pull-left">
				<input type="text" class="form-control height" id="height-'.$count.'" name="height-'.$count.'" placeholder="0" aria-describedby="basic-addon2">
				<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-vertical"></i></span>
			</div>
			<div class=" col-sm-1">
				<label class="control-label">Length</label>
			</div>
			<div class="input-group  col-sm-5 col-xs-12 pull-left"">
				<input type="text" class="form-control length" id="length-'.$count.'" name="length-'.$count.'" placeholder="0" aria-describedby="basic-addon2">
				<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-resize-horizontal"></i></span>
			</div>
		</div>';

		$html .= '<div class="form-group hide rate-form-'.$count.'">';
		$html .= '<label class="control-label" for="rate">RATE</label>';
		$html .= '<input id="rate-'.$count.'" type="text" name="rate-'.$count.'" class="form-control content-rate" disabled="disabled" placeholder="-">';
		$html .= '</div>';

		$html .= '<div class="form-group hide price-form-'.$count.'">';
		$html .= '<label class="control-label" for="price">PRICE</label>';
		$html .= '<input type="text" name="total-'.$count.'" class="form-control content-price" id="total-'.$count.'" disabled="disabled" placeholder="00.0 $">';
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

}

