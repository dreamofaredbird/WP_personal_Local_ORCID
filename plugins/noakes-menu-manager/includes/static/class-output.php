<?php
/**
 * Functionality for outputting content.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Output
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Output'))
{
	/**
	 * Class used to implement output functions.
	 *
	 * @since 2.0.0
	 */
	final class Noakes_Menu_Manager_Output
	{
		/**
		 * Admin page tabs.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private static
		 * @var    array
		 */
		private static $_tabs = array();
		
		/**
		 * Add an admin page tab.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string $menu_parent Parent page for the admin page.
		 * @param  string $menu_slug   Menu slug for the admin page.
		 * @param  string $page_title  Title for the admin page tab.
		 * @return void
		 */
		public static function add_tab($menu_parent, $menu_slug, $title)
		{
			self::$_tabs[] = array
			(
				'parent' => $menu_parent,
				'slug' => $menu_slug,
				'title' => $title
			);
		}
		
		/**
		 * Generate and admin notice.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string  $message        Message to display in the admin notice.
		 * @param  string  $class          CSS class(es) to add to the admin notice.
		 * @param  boolean $is_dismissible True if the admin notice should be dismissible.
		 * @return string                  Generated admin notice.
		 */
		public static function admin_notice($message, $class = 'updated', $is_dismissible = true)
		{
			$classes = (empty($class)) ? '' : ' ' . esc_attr($class);
			$classes .= ($is_dismissible) ? ' is-dismissible' : '';
			
			return '<div class="notice' . $classes . '">' .
				wpautop($message) .
				'</div>';
		}
		
		/**
		 * Output an admin page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string $heading     Heading displayed at the top of the admin page.
		 * @param  string $option_name Option name to generate the admin page for.
		 * @return void
		 */
		public static function admin_page($heading, $option_name = '')
		{
			$option_name = (empty($option_name)) ? '' : sanitize_key($option_name);
			$has_option_name = (!empty($option_name));
			$action = ($has_option_name) ? 'options.php' : basename($_SERVER['REQUEST_URI']);
			$screen = Noakes_Menu_Manager()->_cache->screen;
			$columns = $screen->get_columns();
			$columns = (empty($columns)) ? 2 : $columns;
			
			if ($option_name != NMM_OPTION_SETTINGS && isset($_GET['settings-updated']))
			{
				$notice = ($option_name == NMM_OPTION_GENERATOR) ? __('Code generated.', 'noakes-menu-manager') : __('Settings saved.', 'noakes-menu-manager');
				
				echo '<div class="nmm-hidden">' .
					self::admin_notice('<strong>' . $notice . '</strong>') .
					'</div>';
			}
			else if (isset($_GET['reset']))
			{
				echo '<div class="nmm-hidden">' .
					self::admin_notice('<strong>' . __('Reset successful.', 'noakes-menu-manager') . '</strong>') .
					'</div>';
			}
			
			echo '<div class="wrap">' .
				'<h1>' . $heading . '</h1>' .
				'<form action="' . esc_url(admin_url($action)) . '" method="post">';
				
			if (!empty(self::$_tabs) && count(self::$_tabs) > 1)
			{
				echo '<h2 class="nav-tab-wrapper">';
				
				foreach (self::$_tabs as $tab)
				{
					$active_class = (isset($_GET['page']) && $_GET['page'] == $tab['slug']) ? ' nav-tab-active' : '';
					
					echo '<a href="' . esc_url(admin_url($tab['parent'] . '?page=' . $tab['slug'])) . '" class="nav-tab nmm-nav-tab' . $active_class . '">' . $tab['title'] . '</a>';
				}
				
				echo '</h2>';
			}
				
			ob_start();
			
			if ($has_option_name)
			{
				settings_fields($option_name);
			}
			
			wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
			wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
			
			echo str_replace(array('&reset=true', '&amp;reset=true', 'reset=true&', 'reset=true&amp;'), '', ob_get_clean()) .
				'<div id="poststuff">' .
				'<div id="post-body" class="metabox-holder columns-' . $columns . '">' .
				'<div id="postbox-container-1" class="postbox-container">';

			do_meta_boxes($screen->id, 'side', '');

			echo '</div>' .
				'<div id="postbox-container-2" class="postbox-container">';

			do_meta_boxes($screen->id, 'advanced', '');
			do_meta_boxes($screen->id, 'normal', '');

			echo '</div>' .
				'</div>' .
				'</div>' .
				'</form>' .
				'</div>';
		}
		
		/**
		 * Generates a button that opens a specified help tab.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string  $help_tab_id Optional ID for the help tab to open.
		 * @param  boolean $disabled    Optional flag to disable the help button by default.
		 * @return string               Generated help button.
		 */
		public static function help_button($help_tab_id = '', $disabled = false)
		{
			if (function_exists('is_customize_preview') && is_customize_preview()) return '';
			
			$leading_space = (empty($help_tab_id)) ? '' : ' ';
			$help_label = __('Help', 'noakes-menu-manager');
			$class = ($disabled) ? ' nmm-disabled' : '';

			return (empty(Noakes_Menu_Manager()->_settings->disable_help_buttons) || empty($leading_space)) ? $leading_space . '<a href="javascript:;" title="' . esc_attr($help_label) . '" class="nmm-help-button dashicons dashicons-editor-help' . $class . '" tabindex="-1" data-nmm-help-tab-id="' . esc_attr($help_tab_id) . '">' . $help_label . '</a>' : '';
		}
		
		/**
		 * Outputs a nav menu item field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string  $name        Input name for the field.
		 * @param  string  $label       Label for the field.
		 * @param  string  $help_tab_id ID for the help tab associated with this field.
		 * @return void
		 */
		public static function menu_item_field($name, $label, $help_tab_id)
		{
			$name = esc_attr($name);
			$label .= (empty($help_tab_id)) ? '' : self::help_button($help_tab_id);

			echo '<p class="field-' . $name . ' description description-wide">' .
				'<label for="edit-menu-item-' . $name . '-__i__">' .
				$label . '<br />' .
				'<input type="text" id="edit-menu-item-' . $name . '-__i__" class="widefat edit-menu-item-' . $name . '" name="menu-item-' . $name . '[__i__]" value="" />' .
				'</label>' .
				'</p>';
		}
	}
}
