<?php
/**
 * Widgets functionality.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Widgets
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Widgets'))
{
	/**
	 * Class used to implement widgets functionality.
	 *
	 * @since 2.0.0
	 * 
	 * @uses Noakes_Menu_Manager_Wrapper
	 */
	final class Noakes_Menu_Manager_Widgets extends Noakes_Menu_Manager_Wrapper
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

			add_action('widgets_init', array($this, 'widgets_init'));

			if (!NMM_AJAX && is_admin())
			{
				add_action('load-widgets.php', array($this, 'load_widgets'));
			}
		}

		/**
		 * Register the nav menu sidebar widget.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function widgets_init()
		{
			register_widget('Noakes_Menu_Widget');
		}

		/**
		 * Load widgets page functionality.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function load_widgets()
		{
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 11);

			$this->add_help_tab();
		}

		/**
		 * Enqueues scripts for the nav menus page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_enqueue_scripts()
		{
			wp_enqueue_style('nmm-style', $this->_base->_cache->asset_path('styles', 'style.css'), array(), NMM_VERSION);
			wp_enqueue_script('nmm-script', $this->_base->_cache->asset_path('scripts', 'script.js'), array(), NMM_VERSION, true);

			wp_localize_script
			(
				'nmm-script',
				'nmm_script_options',
				
				array
				(
					'is_widgets' => true,
					'menu_id' => NMM_ID
				)
			);
		}

		/**
		 * Add the help tab to the page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return void
		 */
		private function add_help_tab()
		{
			if (!$this->_base->_settings->disable_help_tabs)
			{
				$widget_name = __('NMM Menu', 'noakes-menu-manager');
				$plugin_label = $this->_base->_cache->plugin_data['Name'];
				
				Noakes_Menu_Manager_Help::add_tab
				(
					'nmm-collapse-expand',
					$widget_name,

					sprintf
					(
						__('%1$s - %2$s', 'noakes-menu-manager'),
						$plugin_label,
						$widget_name
					)
				);
				
				Noakes_Menu_Manager_Help::add_block(__('Theme Location/Nav Menu', 'noakes-menu-manager'), __('The menu can be selected using either a registered nav menu location or a nav menu object. Selecting one will disable the other. If a theme location is used but not associated with a nav menu, the widget won\'t be displayed.', 'noakes-menu-manager'));
				
				Noakes_Menu_Manager_Help::add_block
				(
					__('Additional Fields', 'noakes-menu-manager'),
					
					sprintf
					(
						__('The additional fields are based on the %1$s arguments. Any fields not entered will use filtered values set in %2$s or the default values.', 'noakes-menu-manager'),
						NMM_LINK_WP_NAV_MENU,
						'<a href="https://developer.wordpress.org/reference/hooks/widget_nav_menu_args/" target="_blank">widget_nav_menu_args</a>'
					)
				);
					
				Noakes_Menu_Manager_Help::output(false);
			}
		}
	}
}
