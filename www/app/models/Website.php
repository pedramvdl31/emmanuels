<?php

class Website extends \Eloquent {
	protected $fillable = [];


public static  function prepareMenuBar()
	{
		$url = Request::url();
		$html = '';
		$menus = Menu::where('status',1)->orderBy('order', 'ASC')->get();
		$menu_items = MenuItem::where('status',1)->orderBy('order', 'ASC')->get();

		if (isset($menus,$menu_items)) {
			$html .= '<ul id="mainMenuList" class="dropdown mainMenuListFull">';
			foreach ($menus as $key => $value) {
					if (isset($value->page_id)) { //MENU LINKS

						$this_page = Page::find($value->page_id);

						$html .= '<li >';
							$html .= '<div class="dropdown">';              
								$html .= '<button style="border:none;" class="btn btn-default" type="button">';
								$html .=  '<a  href="'.$url.'/'.$this_page->param_one.'" style="color:#333;">'. $value->name.'</a>';
								$html .= '</button>'; 
							$html .= '</div>';
						$html .= '</li>';
						
					} else { //MENU GROUPS

						$html .= '<li>';
							$html .= '<div class="dropdown">';               
							$html .= '<button  style="border:none"  class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">';
							$html .=  $value->name.' ';
							$html .=  '<span class="caret"></span>';
							$html .= '</button>'; 
							$html .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">';
								foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
									if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP
										$this_page = Page::find($mivalue->page_id);
										$html .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="'.$url.'/'.$this_page->param_one.'/'.$this_page->param_two.'">'.$mivalue->name.'</a></li>';
									}
								}
							$html .= '</ul>';
							$html .= '</div>';
						$html .= '</li>';
					}
				}//End of menus for loop

				$html .= '</ul>';
			}
			return $html;
		}

	}