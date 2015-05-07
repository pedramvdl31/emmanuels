<?php

class Page extends \Eloquent {
	protected $fillable = [];

	use SoftDeletingTrait;

	public static $pages_add = array(
		'title'=>'required|min:1',
		'description'=>'required|min:1',
		'url'=>'required|min:1',
		'keywords'=>'required|min:1'
		);
	public static $pages_edit = array(
		'name'=>'required|min:1'
		);

	public static function preparePages($data) {
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$data[$key]['company_name'] = Company::where('id',1)->pluck('name');
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
	public static function prepareContentArea() {
		$html = '';
		$html .= '<input type="text" class="requested_area" readonly="readonly" name="requested_area" value=""/>';
		return $html;
	}
}