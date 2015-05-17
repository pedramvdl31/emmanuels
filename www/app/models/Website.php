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
			// $html .= '<li class="dropdown current">';              
			// 		$html .=  '<a class="home_a li_a" style="margin-right:10px;" href="/">Home</a>';
			// $html .= '</li>';
			foreach ($menus as $key => $value) {
					if (isset($value->page_id)) { //MENU LINKS
						$this_page = Page::find($value->page_id);
						$page_class = ($value->page_id == 1) ?"current":"";
						$homepage_class = ($value->page_id == 1) ?"home_a":"li_a";
						$home_style = ($value->page_id == 1) ?"margin-right:1px;":"";
						$page_color = ($value->page_id == 1) ?"#FFFFFF":"#333";
						$html .= '<li class="dropdown '.$page_class.' " style="'.$home_style.'">';              
						$html .=  '<a class="'.$homepage_class.'" href="'.URL::to('/').'/'.$this_page->param_one.'" style="color:'.$page_color.';">'. $value->name.'</a>';
						$html .= '</li>';
					} else { //MENU GROUPS
						$html .= '<li>';
						$html .= '<li class="dropdown">';
						$html .= '<a class="dropdown-toggle li_a" data-toggle="dropdown">';               
						$html .=  $value->name.' ';
						$html .=  '<span class="caret"></span></a>';
						$html .= '<ul class="dropdown-menu item_ui" role="menu" aria-labelledby="dropdownMenu1">';
								foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
									if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP
										$this_page = Page::find($mivalue->page_id);
										$html .= '<li role="presentation" class="item_li"><a class="item_a" role="menuitem" tabindex="-1" href="'.URL::to('/').'/'.$this_page->param_one.'/'.$this_page->param_two.'">'.$mivalue->name.'</a></li>';
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

		public static  function prepareMenuBarHomeEdit()
		{
			$url = Request::url();
		$html = '';
		$menus = Menu::where('status',1)->orderBy('order', 'ASC')->get();
		$menu_items = MenuItem::where('status',1)->orderBy('order', 'ASC')->get();
		if (isset($menus,$menu_items)) {
			$html .= '<ul id="mainMenuList" class="dropdown mainMenuListFull">';
			// $html .= '<li class="dropdown current">';              
			// 		$html .=  '<a class="home_a li_a" style="margin-right:10px;" href="/">Home</a>';
			// $html .= '</li>';
			foreach ($menus as $key => $value) {
					if (isset($value->page_id)) { //MENU LINKS
						$this_page = Page::find($value->page_id);
						$page_class = ($value->page_id == 1) ?"current":"";
						$homepage_class = ($value->page_id == 1) ?"home_a":"li_a";
						$home_style = ($value->page_id == 1) ?"margin-right:1px;":"";
						$page_color = ($value->page_id == 1) ?"#FFFFFF":"#333";
						$html .= '<li class="dropdown '.$page_class.' " style="'.$home_style.'">';              
						$html .=  '<a class="'.$homepage_class.'" href="'.URL::to('/').'/'.$this_page->param_one.'" style="color:'.$page_color.';">'. $value->name.'</a>';
						$html .= '</li>';
					} else { //MENU GROUPS
						$html .= '<li>';
						$html .= '<li class="dropdown">';
						$html .= '<a class="dropdown-toggle li_a" data-toggle="dropdown">';               
						$html .=  $value->name.' ';
						$html .=  '<span class="caret"></span></a>';
						$html .= '<ul class="dropdown-menu item_ui" role="menu" aria-labelledby="dropdownMenu1">';
								foreach ($menu_items as $mikey => $mivalue) { //FOR EACH MENU ITEMS
									if ($mivalue->menu_id == $value->id) { //THIS MENU ITEM BELONGS TO THIS GROUP
										$this_page = Page::find($mivalue->page_id);
										$html .= '<li role="presentation" class="item_li"><a class="item_a" role="menuitem" tabindex="-1" href="'.URL::to('/').'/'.$this_page->param_one.'/'.$this_page->param_two.'">'.$mivalue->name.'</a></li>';
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
				// $html .= '<li class="dropdown">';              
				// 	$html .=  '<a  href="/"> Home</a>';
				// $html .= '</li>';
				foreach ($menus as $key => $value) {
					if (isset($value->page_id)) { //MENU LINKS
						$this_page = Page::find($value->page_id);
						$html .= '<li class="dropdown">';              
						$html .=  '<a  href="#" ">'. $value->name.'</a>';
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
											$html .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="#">'.$mivalue->name.'</a></li>';
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