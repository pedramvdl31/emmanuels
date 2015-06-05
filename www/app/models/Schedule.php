<?php

class Schedule extends \Eloquent {
	protected $fillable = [];



	public static function prepareOrderForm($count) {
		$services = Service::all();
		$inventories = Inventory::all();

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

		$html .= '<div class="form-group">';
		$html .= '<label class="control-label" for="quantity">QUANTITY</label>';
		$html .= '<div class="input-group">
					<span class="input-group-addon minus-q"><i class="glyphicon glyphicon-minus"> </i></span>
					<input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" value="0">
					<span class="input-group-addon add-q"><i class="glyphicon glyphicon-plus"> </i></span>
					</div>';
		$html .= '</div>';

		$html .= '<div class="form-group">';
		$html .= '<label class="control-label" for="make">MAKE</label>';
		$html .= '<select id="select-make" class="form-control" status="" name="search">';
		$html .= '<option value="">Select Service</option>';

		foreach ($services as $key => $value) {
			$html .=	'<option value="'.$value->id.'">'.$value->name.'</option>';
		}
		$html .= '</select>';
		$html .= '</div>';


		$html .= '<div class="form-group">';
		$html .= '<label class="control-label" for="make">ITEM</label>';
		$html .= '<select id="select-item" class="form-control" status="" name="search">';
		$html .= '<option value="">Select Item</option>';

		foreach ($inventories as $key => $value) {

		$html .=	'<option value="'.$key.'">'.$value->name.'</option>';

		}
		$html .= '</select>';
		$html .= '</div>';


		$html .= '<div class="form-group">';
		$html .= '<label class="control-label" for="size">SIZE</label>';
		$html .= '<input type="text" name="content['.$count.'][content_size]" class="form-control content-size" placeholder="Size">';
		$html .= '</div>';

		$html .= '<div class="form-group">';
		$html .= '<label class="control-label" for="price">PRICE</label>';
		$html .= '<input type="text" name="content['.$count.'][content_price]" class="form-control content-price" placeholder="PricE">';
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

