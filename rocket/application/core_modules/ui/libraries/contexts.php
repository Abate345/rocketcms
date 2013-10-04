<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contexts {

	protected static $actions = array();
	protected static $menu	= array();
	protected static $outer_id	= null;
	protected static $parent_class	= 'dropdown';
	protected static $child_class	= 'dropdown-menu';
	protected static $ci;
	protected static $site_area = SITE_AREA;
	protected static $contexts = array();
	protected static $errors = array();
	
	public static $public_menu = array();
	public static $public_parent = array();
	public static $admin_menu = array();
	public static $outer_class	= 'nav';

	//--------------------------------------------------------------------

	public function __construct(){
		self::$ci =& get_instance();
		self::init();

	}

	//--------------------------------------------------------------------

	protected static function init( $is_admin = false ){
		if( !function_exists( 'module_list' ) ){
			self::$ci->load->helper( 'application' );
		}
		log_message( 'debug', 'UI/Contexts entities has been initialized' );

	}
	
	//--------------------------------------------------------------------

	public static function loadEntities(){
		$module_list = module_list();
		
		foreach ( $module_list as $module ){
			$mod_urls = module_urls( $module );
			self::$contexts = @array_merge_recursive( self::$contexts, $mod_urls );
		}
		
		// Do we have any data?
		if(!count( self::$contexts ) ) return '';
		
		self::$public_parent = @ self::$contexts['parent'];
		
		// Build up public menu
		foreach( self::$contexts['public'] as $module_name => $module_menu ){
			foreach( $module_menu as $module_page => $url_item ){
				if( @is_array( $url_item ) ){
					if( @is_array( $url_item['title'] ) )
						$url_item['title'] = $url_item['title'][0];
					if( @is_array( $url_item['href'] ) )
						$url_item['href'] = $url_item['href'][0];
					if( @is_array( $url_item['perm'] ) )
						$url_item['perm'] = $url_item['perm'][0];
					if( @count( self::$contexts['sub']['public'][$module_name][$module_page] ) == 1 )
						$url_item['href'] = self::$contexts['sub']['public'][$module_name][$module_page][0]['href'];
					else
						$url_item['subnav'] = @self::$contexts['sub']['public'][$module_name][$module_page];
					
					self::$public_menu[$module_name][$module_page] = $url_item;
				}
			}
		}
		
		// Build up admin menu
		foreach( self::$contexts['admin'] as $module_name => $module_menu ){
			if($module_name == 'Developer')
				continue;
			foreach( $module_menu as $module_page => $url_item ){
				if( @is_array( $url_item ) ){
					if( @is_array( $url_item['title'] ) )
						$url_item['title'] = $url_item['title'][0];
					if( @is_array( $url_item['href'] ) )
						$url_item['href'] = $url_item['href'][0];
					if( @is_array( $url_item['perm'] ) )
						$url_item['perm'] = $url_item['perm'][0];
					if( @count( self::$contexts['sub']['admin'][$module_name][$module_page] ) == 1 )
						$url_item['href'] = self::$contexts['sub']['admin'][$module_name][$module_page][0]['href'];
					else
						$url_item['subnav'] = @self::$contexts['sub']['admin'][$module_name][$module_page];
					self::$admin_menu[$module_name][$module_page] = $url_item;
				}
			}
		}
	}

	//--------------------------------------------------------------------

	private function sort_actions(){
		$weights 		= array();
		$display_names	= array();

		foreach (self::$actions as $key => $action)
		{
			$weights[$key] 			= $action['weight'];
			$display_names[$key]	= $action['display_name'];
		}

		array_multisort($weights, SORT_DESC, $display_names, SORT_ASC, self::$actions);
		//echo '<pre>'. print_r(self::$actions, true) .'</pre>';

	}

	//--------------------------------------------------------------------

}
