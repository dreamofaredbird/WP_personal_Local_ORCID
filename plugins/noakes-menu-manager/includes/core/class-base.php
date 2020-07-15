<?php
/**
 * Base plugin functionality.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Base
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager'))
{
	/**
	 * Class used to implement base plugin functionality.
	 *
	 * @since 2.0.0
	 * 
	 * @uses Nav_Menu_Collapse_Wrapper
	 */
	final class Noakes_Menu_Manager extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Main instance of Noakes_Menu_Manager.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private static
		 * @var    Noakes_Menu_Manager
		 */
		private static $_instance = null;

		/**
		 * Returns the main instance of Noakes_Menu_Manager.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string              $file Main plugin file.
		 * @return Noakes_Menu_Manager       Main Noakes_Menu_Manager instance. 
		 */
		public static function _get_instance($file)
		{
			if (is_null(self::$_instance))
			{
				self::$_instance = new self($file);
			}

			return self::$_instance;
		}
		
		/**
		 * File path for the plugin.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    string
		 */
		public $_plugin;

		/**
		 * Global cache object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    Noakes_Menu_Manager_Cache
		 */
		public $_cache;

		/**
		 * Global settings object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    Noakes_Menu_Manager_Settings
		 */
		public $_settings;

		/**
		 * Global nav menus object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    Noakes_Menu_Manager_Nav_Menus
		 */
		public $_nav_menus;

		/**
		 * Global AJAX object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    Noakes_Menu_Manager_Ajax
		 */
		public $_ajax;

		/**
		 * Global generator object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    Noakes_Menu_Manager_Generator
		 */
		public $_generator;

		/**
		 * Global widgets object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    Noakes_Menu_Manager_Widgets
		 */
		public $_widgets;

		/**
		 * Constructor function.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  string $file Main plugin file.
		 * @return void
		 */
		public function __construct($file)
		{
			if (!empty($file) && file_exists($file))
			{
				$this->_plugin = $file;
				$this->_cache = new Noakes_Menu_Manager_Cache($this);
				$this->_settings = new Noakes_Menu_Manager_Settings($this);
				$this->_nav_menus = new Noakes_Menu_Manager_Nav_Menus($this);

				add_action('init', array($this, 'init'), 1000);
				
				if (NMM_AJAX)
				{
					$this->_ajax = new Noakes_Menu_Manager_Ajax($this);
				}
				else if (is_admin())
				{
					if (!$this->_settings->disable_generator)
					{
						$this->_generator = new Noakes_Menu_Manager_Generator($this);
					}
					
					add_action('admin_init', array('Noakes_Menu_Manager_Setup', 'check_version'), 0);
					
					add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
				}
				
				if ($this->_settings->enable_widget)
				{
					$this->_widgets = new Noakes_Menu_Manager_Widgets($this);
				}
				
				add_shortcode(NMM_ID, array($this, 'shortcode'));
			}
		}

		/**
		 * Initialize the plugin.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function init()
		{
			load_plugin_textdomain('noakes-menu-manager', false, dirname(plugin_basename($this->_plugin)) . '/languages/');
			
			$this->_cache->registered_menus = get_registered_nav_menus();

			if (count($this->_settings->disable) > 0 && (!isset($_GET['page']) || $_GET['page'] != NMM_OPTION_SETTINGS))
			{
				foreach ($this->_settings->disable as $location => $value)
				{
					if ($value == '1')
					{
						unregister_nav_menu($location);
					}
				}
			}

			if (count($this->_settings->menus) > 0)
			{
				foreach ($this->_settings->menus as $menu)
				{
					register_nav_menu($menu['location'], $menu['description']);
				}
			}
		}

		/**
		 * Add links to the plugin page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array  $links Default links for the plugin.
		 * @param  string $file  Main plugin file name.
		 * @return array         Modified links for the plugin.
		 */
		public function plugin_row_meta($links, $file)
		{
			if ($file == plugin_basename($this->_plugin))
			{
				$links[] = '<a href="' . NMM_URL_SUPPORT . '" target="_blank">' . __('Support', 'noakes-menu-manager') . '</a>';
				$links[] = '<a href="' . NMM_URL_REVIEW . '" target="_blank">' . __('Review', 'noakes-menu-manager') . '</a>';
				$links[] = '<a href="' . NMM_URL_TRANSLATE . '" target="_blank">' . __('Translate', 'noakes-menu-manager') . '</a>';
				$links[] = '<a href="' . NMM_URL_DONATE . '" target="_blank">' . __('Donate', 'noakes-menu-manager') . '</a>';
			}

			return $links;
		}
		
		/**
		 * Nav menu shortcode.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array  $atts Settings for the nav menu output.
		 * @return string       Generated wp_nav_menu output.
		 */
		public function shortcode($atts)
		{
			$atts['echo'] = false;
			
			if (isset($atts['walker']))
			{
				unset($atts['walker']);
			}
			
			return wp_nav_menu
			(
				shortcode_atts
				(
					$this->_nav_menus->_wp_nav_menu_defaults,
					
					array_map
					(
						'htmlspecialchars_decode',
						str_replace('__Q__', '"', $atts)
					)
				)
			);
		}
	}
}
