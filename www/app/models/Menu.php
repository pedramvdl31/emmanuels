<?php

class Menu extends \Eloquent {
	protected $fillable = [];
	use SoftDeletingTrait;

		public static $rules_add = array(
		'name'=>'required|min:1',
		'kind'=>'required|min:1',
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
				}
				if(isset($data[$key]['start'])) {
					$data[$key]['start'] = date ( 'n/d/Y g:ia',  strtotime($data[$key]['start']) );
				}
				if(isset($data[$key]['end'])) {
					$data[$key]['end'] = date ( 'n/d/Y g:ia',  strtotime($data[$key]['end']) );
				}
				if(isset($data[$key]['page_id'])&&$data[$key]['page_id']!=0) {
					$page = Page::find($data[$key]['page_id']);
					$data[$key]['page_id'] = $page->title;
				}

			}
		}


		return $data;
	}
		public static function prepareSelect()
	{
		return array(
			'1'	=> 'link',
			'2' => 'not'
			);
	}

	public static function prepareForSelect($data) {
		$pages = array('0'=>'All Menus');
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$page_id = $value['id'];
				$page_name = $value['name'];
				$pages[$page_id] = $page_name; 
			}
		}

		return $pages;
	}

}