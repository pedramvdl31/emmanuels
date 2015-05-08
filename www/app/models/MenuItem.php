<?php

class MenuItem extends \Eloquent {
	protected $fillable = [];
	use SoftDeletingTrait;

	public static $rules_add = array(
		'name'=>'required|min:1',
		'menus'=>'required|min:1',
		'page_id'=>'required|min:1'
		);

	public static function prepare($data){
		if(isset($data)){
			foreach ($data as $key => $value) {
				if(isset($data[$key]['status'])) {
					switch ($data[$key]['status']) {
						case 1:// Created by user
						$data[$key]['status_html'] = '<span class="label label-primary">Created</span>';
						break;
						case 2:// Accepted by owner
						$data[$key]['status_html'] = '<span class="label label-info">Accepted</span>';
						break;
						default://errors
						$data[$key]['status_html'] = '<span class="label label-danger">Error</span>';
						break;
					}
					if(isset($data[$key]['menu_id'])&&$data[$key]['menu_id']!=0) {
						$menu = Menu::find($data[$key]['menu_id']);
						$data[$key]['menu_name'] = $menu->name;
					}
					if(isset($data[$key]['page_id'])&&$data[$key]['page_id']!=0) {
						$page = Page::find($data[$key]['page_id']);
						$data[$key]['page_id'] = $page->title;
					}
				}
			}
		}

		return $data;
	}
}