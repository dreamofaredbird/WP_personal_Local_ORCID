<?php
/**
 * Functionality for AJAX calls.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Ajax
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Ajax'))
{
	/**
	 * Class used to implement AJAX functionality.
	 *
	 * @since 2.0.0
	 * 
	 * @uses Noakes_Menu_Manager_Wrapper
	 */
	final class Noakes_Menu_Manager_Ajax extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Constructor function.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base Base plugin object.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base)
		{
			parent::__construct($base);
			
			add_action('wp_ajax_nmm_collapsed', array($this, 'nmm_collapsed'));
		}
		
		/**
		 * Save the menu collapsed state for the logged in user.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function nmm_collapsed()
		{
			if (isset($_POST['menu_id']) && is_numeric($_POST['menu_id']))
			{
				$valid = true;
				$collapsed_raw = (isset($_POST['collapsed']) && is_array($_POST['collapsed'])) ? $_POST['collapsed'] : array();
				
				foreach ($collapsed_raw as $id)
				{
					if (!is_numeric($id))
					{
						$valid = false;
						
						break;
					}
				}
				
				if ($valid)
				{
					$user_id = get_current_user_id();
					$collapsed = get_user_meta($user_id, 'nmm_collapsed', true);
					$collapsed = (is_array($collapsed)) ? $collapsed : array();
					$collapsed[$_POST['menu_id']] = $_POST['collapsed'];

					update_user_meta($user_id, 'nmm_collapsed', $collapsed);
				}
			}
		}
	}
}
