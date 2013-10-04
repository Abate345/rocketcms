<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if( !function_exists( 'render_menu' ) ){
	function render_menu( $outer_class = false ){
		if( !$outer_class ) $outer_class = Contexts::$outer_class;
		$nav = '<ul class="'. $outer_class .'">';
		$public_menu = Contexts::$public_menu;
		$public_parent = Contexts::$public_parent;
		reorder_navigation( $public_menu );
		$ci = & get_instance();
		foreach ( $public_menu as $module_name => $module_menu ){
			if ( has_permission( $module_name , 1 ) or is_admin() ){
				foreach ( $module_menu as $module_page => $url_item ){
					if ( has_permission( $module_name.' '.$module_page , 1 ) or is_admin() ){
						$nav .= "<li class='". @ $url_item['class'];
						if( $ci->router->fetch_class() == strtolower($module_name) and !$public_parent[$ci->router->fetch_class()] or $public_parent[$ci->router->fetch_class()] == strtolower($module_name) ) $nav .= " current";
						$nav .= "'>";
						if( !empty( $url_item['subnav'] ) ){
							$nav .= "<a href='". site_url( $url_item['href'] ) ."' title='{$url_item['title']}'>{$url_item['title']} <b class='caret'></b></a>";
							$nav .= "<ul>";
							foreach ( $url_item['subnav'] as $subnav_item ){
								if ( has_permission( $module_name , $subnav_item['perm'] ) or is_admin() ){
									$nav .= "<li><a href='". site_url( $subnav_item['href'] ) ."' title='{$subnav_item['title']}' >{$subnav_item['title']}</a></li>";
								}	
							}
							$nav .= "</ul>";
						}else{
							$nav .= "<a href='". site_url( $url_item['href'] ) ."' title='{$url_item['title']}'>{$url_item['title']}</a>";
						}
						$nav .= "</li>\n";
					}
				}
			}
		}

		$nav .= '</ul>';
		
		return $nav;
	}
}

if( !function_exists( 'render_admin_menu' ) ){
	function render_admin_menu( $outer_class = false ){
		if( !$outer_class ) $outer_class = Contexts::$outer_class;
		$nav = '<ul class="'. $outer_class .'">';
		$admin_menu = Contexts::$admin_menu;
		$public_parent = Contexts::$public_parent;
		$ci = & get_instance();
		reorder_navigation( $admin_menu );
		foreach ( $admin_menu as $module_name => $module_menu ){
			foreach ( $module_menu as $module_page => $url_item ){
				$nav .= "<li class='dropdown";
				if( $ci->router->fetch_class() == strtolower($module_name) and !$public_parent['admin'][$ci->router->fetch_class()] or $public_parent['admin'][$ci->router->fetch_class()] == strtolower($module_name) ) $nav .= " active";
				$nav .= "'>";
				if( !empty( $url_item['subnav'] ) ){
					$nav .= "<a href='". site_url( 'admin/'.$url_item['href'] ) ."' class='dropdown-toggle' title='{$url_item['title']}' data-toggle='dropdown' data-id='{$module_page}_menu'>{$url_item['title']} <b class='caret'></b></a>";
					$nav .= "<ul class='dropdown-menu'>";
					foreach ( $url_item['subnav'] as $subnav_item ){
						$nav .= "<li><a href='". site_url( 'admin/'.$subnav_item['href'] ) ."' title='{$subnav_item['title']}' >{$subnav_item['title']}</a></li>";
					}
					$nav .= "</ul>";
				}else{
					$nav .= "<a href='". site_url( 'admin/'.$url_item['href'] ) ."' title='{$url_item['title']}'>{$url_item['title']}</a>";
				}
				$nav .= "</li>\n";
			}
		}
		
		
		//~ foreach ( $public_menu as $module_name => $module_menu ){
			//~ if ( has_permission( $module_name , 1 ) or is_admin() ){
				//~ foreach ( $module_menu as $module_page => $url_item ){
					//~ //echo $module_name.' '.$module_page."<br />";
					//~ if ( has_permission( $module_name.' '.$module_page , 1 ) or is_admin() ){
						//~ $nav .= "<li class='{$url_item['class']}";
						//~ if( $ci->router->fetch_class() == strtolower($module_name) and !$public_parent[$ci->router->fetch_class()] or $public_parent[$ci->router->fetch_class()] == strtolower($module_name) ) $nav .= " current";
						//~ $nav .= "'>";
						//~ if( !empty( $url_item['subnav'] ) ){
							//~ $nav .= "<a href='". site_url( $url_item['href'] ) ."' title='{$url_item['title']}'>{$url_item['title']} <b class='caret'></b></a>";
							//~ $nav .= "<ul>";
							//~ foreach ( $url_item['subnav'] as $subnav_item ){
								//~ if ( has_permission( $module_name , $subnav_item['perm'] ) or is_admin() ){
									//~ $nav .= "<li><a href='". site_url( $subnav_item['href'] ) ."' title='{$subnav_item['title']}' >{$subnav_item['title']}</a></li>";
								//~ }	
							//~ }
							//~ $nav .= "</ul>";
						//~ }else{
							//~ $nav .= "<a href='". site_url( $url_item['href'] ) ."' title='{$url_item['title']}'>{$url_item['title']}</a>";
						//~ }
						//~ $nav .= "</li>\n";
					//~ }
				//~ }
			//~ }
		//~ }
		

		$nav .= '</ul>';
		
		return $nav;
	}
}

if ( !function_exists('is_admin') ){
	function is_admin(){
		$ci = & get_instance();
		if( $ci->session->userdata('role_id') == 1 )
			return true;

		return false;
	}
}

if ( !function_exists('reorder_navigation') ){
	function reorder_navigation( &$public_menu ){
		$sort_array = array();
		foreach( $public_menu as &$menu_item ){
			$sort_array[] = @ $menu_item['Index']['order'];
			$subnav_sort_array = array();
			if( @$menu_item['Index']['subnav'] ){
				foreach( $menu_item['Index']['subnav'] as $subnav ){
					if( @$subnav['order'] )
						$subnav_sort_array[] = $subnav['order'];
				}
				if( count($subnav_sort_array) == count( $menu_item['Index']['subnav'] ) )
					array_multisort( $subnav_sort_array, $menu_item['Index']['subnav'] );
			}
		}
		array_multisort( $sort_array, $public_menu );
	}
}

?>