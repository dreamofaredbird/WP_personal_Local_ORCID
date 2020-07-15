<?php
/**
 * Functionality for third-party plugins.
 *
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Third-Party
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Third_Party'))
{
	/**
	 * Class used to implement third party functions.
	 *
	 * @since 2.0.0
	 */
	final class Noakes_Menu_Manager_Third_Party
	{
		/**
		 * Remove third-party plugin meta boxes from the settings page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @return void
		 */
		public static function remove_meta_boxes()
		{
			add_action('add_meta_boxes', array('Noakes_Menu_Manager_Third_Party', 'remove_third_party_meta_boxes'), 1000);
		}

		/**
		 * Remove third-party plugin meta boxes.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @return void
		 */
		public static function remove_third_party_meta_boxes()
		{
			$screen = get_current_screen();

			remove_meta_box('eg-meta-box', $screen->id, 'normal');
			remove_meta_box('mymetabox_revslider_0', $screen->id, 'normal');
		}
	}
}
