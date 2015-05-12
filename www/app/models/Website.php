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
			$html .= '<li class="dropdown current">';              
					$html .=  '<a class="home_a li_a" style="margin-right:10px;" href="/">Home</a>';
			$html .= '</li>';
			foreach ($menus as $key => $value) {
					if (isset($value->page_id)) { //MENU LINKS
						$this_page = Page::find($value->page_id);
				
						$html .= '<li class="dropdown">';              
						$html .=  '<a class="li_a" href="'.$url.'/'.$this_page->param_one.'" style="color:#333;">'. $value->name.'</a>';
						$html .= '</li>';
					} else { //MENU GROUPS
						$html .= '<li>';
						$html .= '<li class="dropdown">';
						$html .= '<a class="dropdown-toggle li_a" data-toggle="dropdown">';               
						$html .=  $value->name.' ';
						$html .=  '<span class="caret"></span></a>';
						$html .= '<ul class="dropdown-menu ul_a" role="menu" aria-labelledby="dropdownMenu1">';
								foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
									if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP
										$this_page = Page::find($mivalue->page_id);
										$html .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="'.$url.'/'.$this_page->param_one.'/'.$this_page->param_two.'">'.$mivalue->name.'</a></li>';
									}
								}
								$html .= '</ul>';
								$html .= '</li>';
							}
				}//End of menus for loop

				$html .= '</ul>';
			}
			return $html;
		}

		public static  function prepareNavBar()
		{
			$url = Request::url();
			$html = '';
			$menus = Menu::where('status',1)->orderBy('order', 'ASC')->get();
			$menu_items = MenuItem::where('status',1)->orderBy('order', 'ASC')->get();
			if (isset($menus,$menu_items)) {
				$html .= '<ul class="nav navbar-nav navbar-right">';
				$html .= '<li class="dropdown">';              
					$html .=  '<a  href="/"> Home</a>';
				$html .= '</li>';
				foreach ($menus as $key => $value) {
					if (isset($value->page_id)) { //MENU LINKS
						$this_page = Page::find($value->page_id);
						$html .= '<li class="dropdown">';              
						$html .=  '<a  href="'.$url.'/'.$this_page->param_one.'" ">'. $value->name.'</a>';
						$html .= '</li>';

					} else { //MENU GROUPS
						$html .= '<li class="dropdown">';               
							$html .= '<a class="dropdown-toggle" data-toggle="dropdown">';
							$html .=  $value->name.' ';
							$html .=  '<span class="caret"></span>';
							$html .= '</a>'; 
							$html .= '<ul class="dropdown-menu" role="menu">';
									foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
										if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP
											$this_page = Page::find($mivalue->page_id);
											$html .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="'.$url.'/'.$this_page->param_one.'/'.$this_page->param_two.'">'.$mivalue->name.'</a></li>';
										}
									}
							$html .= '</ul>';
						$html .= '</li>';
							}
				}//End of menus for loop

				$html .= '</ul>';
			}
			return $html;
		}

	}