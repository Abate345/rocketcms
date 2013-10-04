<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2012, Bonfire Dev Team
 * @license   http://guides.rocketphp.com/license.html
 * @link      http://rocketphp.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Roles Settings Context
 *
 * Allows the management of the Bonfire roles.
 *
 * @package    Bonfire
 * @subpackage Modules_Roles
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.rocketphp.com/helpers/file_helpers.html
 *
 */
class Roles extends Admin_Controller
{
	protected static $available_permissions = array();
	//--------------------------------------------------------------------

	/**
	 * Sets up the require permissions and loads required classes
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->auth->is_admin($this->load->_ci_cached_vars['current_user']->role_id);

		$this->load->model('role_model');
		$this->load->model('role_permission_model');

		$this->lang->load('roles');

		Assets::add_module_css('roles', 'css/settings.css');
		Assets::add_module_js('roles', 'jquery.tablehover.pack.js');
		Assets::add_module_js('roles', 'js/settings.js');

		// for the render_search_box()
		$this->load->helper('ui/ui');

		Template::set_block('sub_nav', '_sub_nav');
	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Displays a list of all roles
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function index()
	{
		// Get User Counts
		Template::set('role_counts', $this->user_model->count_by_roles());
		Template::set('total_users', $this->user_model->count_all());

		Template::set('deleted_users', $this->user_model->count_all(TRUE));

		Template::set('roles', $this->role_model->where('deleted', 0)->find_all());

		Template::set('toolbar_title', lang("role_manage"));
		Template::render();

	}//end index()

	//--------------------------------------------------------------------
	
	
	public function permission_options()
	{
		$id = (int)$this->uri->segment(4);

		if (!empty($id))
		{
			$role = $this->role_model->find($id);
			$role_permissions = $role->new_role_permissions;
		}
		
		$module_list = module_list();
		foreach ($module_list as $module)
		{
			$mod_permissions = module_permissions($module);
			self::$available_permissions = @array_merge(self::$available_permissions, $mod_permissions);
		}
				
		unset($module_list);

		// Do we have any actions?
		if (!count(self::$available_permissions))
		{
			return '';
		}
		
		// Grab our module permissions so we know who can see what on the sidebar
		//$permissions = self::$ci->config->item('module_permissions');
		
		// Build up permission's options
		$menu = "<div style='padding: 0 20px 20px; width: 600px; margin: 0px auto;'>";
		foreach (self::$available_permissions as $permission){
			$menu .= '
					<label class="radio permission_title">'.$permission.':</label>	
					
					<label class="radio permission_option">
						<input'; 
						if(!isset($role_permissions[$permission]) ) 
							$menu .= ' checked="checked" ';	
						$menu .= ' type="radio" value="0" name="role_permissions['.preg_replace("/\s/", "_", $permission).']" checked="checked"> No access
					</label>
					
					<label class="radio permission_option">
						<input';
						if(isset($role_permissions[$permission]) AND $role_permissions[$permission] == 1 ) 
							$menu .= ' checked="checked" ';	
						 $menu .= ' type="radio" value="1" name="role_permissions['.preg_replace("/\s/", "_", $permission).']"> Read Only
					</label>
					<label class="radio permission_option">
						<input';
						if(isset($role_permissions[$permission]) AND $role_permissions[$permission] == 2 ) 
							$menu .= ' checked="checked" ';	
						$menu .= ' type="radio" value="2" name="role_permissions['.preg_replace("/\s/", "_", $permission).']"> Create Only
					</label>
					<label class="radio permission_option">
						<input';
						if(isset($role_permissions[$permission]) AND $role_permissions[$permission] == 3 ) 
							$menu .= ' checked="checked" ';	
						$menu .= ' type="radio" value="3" name="role_permissions['.preg_replace("/\s/", "_", $permission).']"> Full Access
					</label>
					
					<div class="clear"></div>
			';	
		}
		$menu .= "</div>";
		
		return $menu;
		
	} //end permission_options()



	/**
	 * Create a new role in the database
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function create()
	{
		
		if ($this->input->post('save'))
		{
			if ($this->save_role())
			{
				Template::set_message('Role successfully created.', 'success');
				Template::redirect(SITE_AREA .'/roles');
			}
			else
			{
				Template::set_message('There was a problem creating the role: '. $this->role_model->error, 'error');
			}
		}

        Template::set('contexts', list_contexts(true));
        Template::set('toolbar_title', 'Create New Role');
		Template::set_view('role_form');
		Template::render();

	}//end create()

	//--------------------------------------------------------------------

	/**
	 * Edit a role record
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = (int)$this->uri->segment(4);

		if (empty($id))
		{
			Template::set_message('Invalid Role ID.', 'error');
			redirect(SITE_AREA .'/roles');
		}

		if (isset($_POST['save']))
		{
			if ($this->save_role('update', $id))
			{
				Template::set_message('Role successfully saved.', 'success');
				// redirect to update the sidebar which will show old name otherwise.
				Template::redirect(SITE_AREA .'/roles');
			}
			else
			{
				Template::set_message('There was a problem saving the role: '. $this->role_model->error);
			}
		}
		elseif (isset($_POST['delete']))
		{
			if ($this->role_model->delete($id))
			{
				Template::set_message('The Role was successfully deleted.', 'success');
				redirect(SITE_AREA .'/roles');
			}
			else
			{
				Template::set_message('We could not delete the role: '. $this->role_model->error, 'error');
			}
		}

		Template::set('role', $this->role_model->find($id));
        Template::set('contexts', list_contexts(true));

        Template::set('toolbar_title', 'Edit Role');
		Template::set_view('role_form');
		Template::render();

	}//end edit()

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Saves the role record to the database
	 *
	 * @access private
	 *
	 * @param string $type The type of save operation (insert or edit)
	 * @param int    $id   The record ID in the case of edit
	 *
	 * @return bool
	 */
	private function save_role($type='insert', $id=0)
	{
		if ($type == 'insert')
		{
			$this->form_validation->set_rules('role_name', 'lang:role_name', 'required|trim|strip_tags|unique[roles.role_name]|max_length[60]|xss_clean');
		}
		else
		{
			$this->form_validation->set_rules('role_name', 'lang:role_name', 'required|trim|strip_tags|unique[roles.role_name,roles.role_id]|max_length[60]|xss_clean');
		}

		$this->form_validation->set_rules('description', 'lang:bf_description', 'trim|strip_tags|max_length[255]|xss_clean');
		$this->form_validation->set_rules('login_destination', 'lang:role_login_destination', 'trim|strip_tags|max_length[255]|xss_clean');
        $this->form_validation->set_rules('default_context', 'lang:role_default_context', 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('default', 'lang:role_default_role', 'trim|strip_tags|is_numeric|max_length[1]|xss_clean');
		$this->form_validation->set_rules('can_delete', 'lang:role_can_delete_role', 'trim|strip_tags|is_numeric|max_length[1]|xss_clean');

		$_POST['role_id'] = $id;

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		unset($_POST['save']);

		// Grab our permissions out of the POST vars, if it's there.
		// We'll need it later.
		$permissions = $this->input->post('role_permissions');
		unset($_POST['role_permissions']);

		
		if ($type == 'insert')
		{
			$id = $this->role_model->insert($_POST);

			if (is_numeric($id))
			{
				$return = TRUE;
			}
			else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->role_model->update($id, $_POST);
		}

		// Add a new management permission for the role.
		if ($type ==  'insert')	{
			foreach($permissions as $permission_title => $permission_value){
				if($permission_value > 0){
					$add_perm = array(
						'name'=>preg_replace("/\_/", " ", $permission_title),
						'description'=>'To manage the access control permissions for the '.ucwords($this->input->post('role_name')).' role.',
						'status'=>$permission_value
					);

					if ( $this->permission_model->insert($add_perm) ) {
						$prefix = $this->db->dbprefix;
						// give current_role, or admin fallback, access to manage new role ACL
						if(!is_numeric($id))
							$id = 1;
						//$assign_role = $this->session->userdata('role_id') ? $this->session->userdata('role_id') : $id;
						$assign_role = $id;
						$permissions_ids[] = $this->db->insert_id();
						$this->db->query("INSERT INTO {$prefix}role_permissions VALUES(".$assign_role.",".$this->db->insert_id().")");
					}
					else
					{
						$this->error = 'There was an error creating the ACL permission.';
					}
				}
			}
		}
		else
		{
			$current_permissions = $this->role_permission_model->find_for_role($id);
			for($i = 0; $i < count($current_permissions);$i++){
				$this->permission_model->delete($current_permissions[$i]->permission_id);	
			}
			
			if ($permissions){
				foreach($permissions as $permission_title => $permission_value){
					if($permission_value > 0){
						$add_perm = array(
							'name'=>preg_replace("/\_/", " ", $permission_title),
							'description'=>'To manage the access control permissions for the '.ucwords($this->input->post('role_name')).' role.',
							'status'=>$permission_value
						);

						if ( $this->permission_model->insert($add_perm) ) {
							$prefix = $this->db->dbprefix;
							// give current_role, or admin fallback, access to manage new role ACL
							if(!is_numeric($id))
								$id = 1;
							//$assign_role = $this->session->userdata('role_id') ? $this->session->userdata('role_id') : $id;
							$assign_role = $id;
							$permissions_ids[] = $this->db->insert_id();
							$this->db->query("INSERT INTO {$prefix}role_permissions VALUES(".$assign_role.",".$this->db->insert_id().")");
						}
						else
						{
							$this->error = 'There was an error creating the ACL permission.';
						}
					}
				}
			}
			/*
			// grab the current role model name
			$current_name = $this->role_model->find($id)->role_name;
			// update the permission name (did it this way for brevity on the update_where line)
			$new_perm_name = 'Permissions.'.ucwords($this->input->post('role_name')).'.Manage';
			$old_perm_name = 'Permissions.'.ucwords($current_name).'.Manage';
			$this->permission_model->update_where('name',$old_perm_name,array('name'=>$new_perm_name));
			*/
		}

		// Save the permissions.
		if ($permissions && !$this->role_permission_model->set_for_role($id, $permissions_ids))
		{
			$this->error = 'There was an error saving the permissions.';
		}

		unset($permissions);
		return $return;

	}//end save_role()

	//--------------------------------------------------------------------

}//end Settings
