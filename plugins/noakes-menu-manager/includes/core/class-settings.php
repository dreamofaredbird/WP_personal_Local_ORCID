<?php
/**
 * Settings page functionality.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Settings
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Settings'))
{
	/**
	 * Class used to implement settings functionality.
	 *
	 * @since 2.0.0
	 * 
	 * @uses Noakes_Menu_Manager_Wrapper
	 */
	final class Noakes_Menu_Manager_Settings extends Noakes_Menu_Manager_Wrapper
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

			$this->load_option();
			
			if (is_admin())
			{
				add_action('admin_init', array($this, 'admin_init'));
				add_action('admin_menu', array($this, 'admin_menu'));

				add_filter('plugin_action_links_' . plugin_basename($this->_base->_plugin), array($this, 'plugin_action_links'), 11);
			}
		}

		/**
		 * Load the plugin settings option.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array $settings Setting array to load, or null of the settings should be loaded from the database.
		 * @return void
		 */
		public function load_option($settings = null)
		{
			$defaults = array
			(
				/* @var string General page title for the admin page. */
				'page_title' => '',
				
				/* @var boolean True if collapse/expand states should be saved for each user. */
				'store_collapsed_states' => false,
				
				/* @var boolean True if the advanced nav menu widget should be enabled. */
				'enable_widget' => false,

				/* @var boolean True if the nav menu generator should be disabled. */
				'disable_generator' => false,
				
				/* @var boolean True if help buttons should be disabled. */
				'disable_help_buttons' => false,

				/* @var boolean True if help tabs should be disabled. */
				'disable_help_tabs' => false,
				
				/* @var array Unused nav menus that should be disabled. */
				'disable' => array(),
				
				/* @var array Nav menus that should be registered for the site. */
				'menus' => array(),
				
				/* @var string CSS class added to all active nav menu items. */
				'active_class' => '',
				
				/* @var boolean True if default DOM IDs should be removed from all nav menu items. */
				'exclude_default_ids' => false,
				
				/* @var boolean True if the DOM ID field should be included for nav menu items. */
				'enable_id' => false,
				
				/* @var boolean True if the query string field should be included for nav menu items. */
				'enable_query_string' => false,
				
				/* @var boolean True if the anchor field should be included for nav menu items. */
				'enable_anchor' => false,

				/* @var boolean True if plugin settings should be deleted when the plugin is uninstalled. */
				NMM_SETTING_DELETE_SETTINGS => false,

				/* @var boolean True if plugin settings should be deleted when the plugin is uninstalled. */
				NMM_SETTING_DELETE_SETTINGS . '_unconfirmed' => false,

				/* @var boolean True if plugin-specific post meta should be deleted when the plugin is uninstalled. */
				NMM_SETTING_DELETE_POST_META => false,

				/* @var boolean True if plugin-specific post meta should be deleted when the plugin is uninstalled. */
				NMM_SETTING_DELETE_POST_META . '_unconfirmed' => false,

				/* @var boolean True if plugin-specific user meta should be deleted when the plugin is uninstalled. */
				NMM_SETTING_DELETE_USER_META => false,

				/* @var boolean True if plugin-specific user meta should be deleted when the plugin is uninstalled. */
				NMM_SETTING_DELETE_USER_META . '_unconfirmed' => false
			);

			$settings = (empty($settings)) ? get_option(NMM_OPTION_SETTINGS) : $settings;

			$this->_set_properties($defaults, $settings);
		}

		/**
		 * Register the settings option.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_init()
		{
			register_setting(NMM_OPTION_SETTINGS, NMM_OPTION_SETTINGS, array($this, 'sanitize'));
		}
		
		/**
		 * Sanitize the settings.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array $input Raw settings array.
		 * @return array        Sanitized settings array.
		 */
		public function sanitize($input)
		{
			if (!is_array($input)) return array();
			
			foreach ($input as $name => $value)
			{
				if ($name == 'disable_help_tabs')
				{
					$input[$name] = (isset($input['disable_help_buttons']) && $input['disable_help_buttons']) ? $input[$name] : false;
				}
				else if ($name == 'disable')
				{
					if (!empty($input[$name]))
					{
						foreach ($input[$name] as $location => $value)
						{
							$input[$name][$location] = sanitize_text_field($value);
						}
					}
				}
				else if ($name == 'menus')
				{
					if (!empty($input[$name]))
					{
						foreach ($input[$name] as $i => $nav_menu)
						{
							$input[$name][$i]['location'] = sanitize_key($nav_menu['location']);
							$input[$name][$i]['description'] = sanitize_text_field($nav_menu['description']);
						}
					}
				}
				else if ($name == 'active_class')
				{
					$input[$name] = Noakes_Menu_Manager_Utilities::sanitize_classes($input[$name]);
				}
				else
				{
					$input[$name] = sanitize_text_field($input[$name]);
				}
			}
			
			return $input;
		}

		/**
		 * Add the settings page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_menu()
		{
			$plugin_label = $this->_base->_cache->plugin_data['Name'];
			$settings_label = __('Settings', 'noakes-menu-manager');
			
			Noakes_Menu_Manager_Output::add_tab('options-general.php', NMM_OPTION_SETTINGS, $settings_label);
			
			$this->page_title = sprintf
			(
				__('%1$s - %2$s', 'noakes-menu-manager'),
				$plugin_label,
				$settings_label
			);
			
			$settings_page = add_options_page($this->page_title, $plugin_label, 'manage_options', NMM_OPTION_SETTINGS, array($this, 'settings_page'));
			
			add_action('load-' . $settings_page, array($this, 'load_settings'));
		}

		/**
		 * Output the settings page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function settings_page()
		{
			Noakes_Menu_Manager_Output::admin_page($this->page_title, NMM_OPTION_SETTINGS);
		}

		/**
		 * Load settings page functionality.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function load_settings()
		{
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 11);
			add_action('admin_footer', array($this, 'admin_footer'));

			add_screen_option
			(
				'layout_columns',
				
				array
				(
					'default' => 2,
					'max' => 2
				)
			);
			
			$this->add_meta_boxes();
			
			Noakes_Menu_Manager_Help::output();
		}

		/**
		 * Enqueues scripts for the settings page.
		 * 
		 * @since 2.0.2 Added dashicons CSS dependency.
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_enqueue_scripts()
		{
			wp_enqueue_style('nmm-style', $this->_base->_cache->asset_path('styles', 'style.css'), array('dashicons'), NMM_VERSION);
			wp_enqueue_script('nmm-script', $this->_base->_cache->asset_path('scripts', 'script.js'), array('postbox', 'jquery-ui-draggable', 'jquery-ui-sortable', 'wp-util'), NMM_VERSION, true);

			wp_localize_script('nmm-script', 'nmm_script_options', array
			(
				'is_settings' => true,
				
				'validator' => array
				(
					'nmm-location' => __('Location names must be unique.', 'noakes-menu-manager'),
					'required' => __('This field is required.', 'noakes-menu-manager')
				)
			));
		}
		
		/**
		 * Include the HTML template in the admin footer.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_footer()
		{
			ob_start();
			
			include_once(dirname(__FILE__) . '/../templates/repeatable-buttons.php');
			
			echo Noakes_Menu_Manager_Utilities::clean_code(ob_get_clean());
		}

		/**
		 * Add meta boxes to the settings page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return void
		 */
		private function add_meta_boxes()
		{
			$plugin_label = $this->_base->_cache->plugin_data['Name'];
			
			$general_settings_box = new Noakes_Menu_Manager_Meta_Box(array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-general-settings',
				'id' => 'general_settings',
				'option_name' => NMM_OPTION_SETTINGS,
				'title' => __('General Settings', 'noakes-menu-manager'),
				
				'help_description' => sprintf
				(
					__('The settings in this box are general settings for the %s.', 'noakes-menu-manager'),
					$plugin_label
				)
			));
			
			if (!$this->_base->_cache->has_legacy_nmc)
			{
				$general_settings_box->add_field(array
				(
					'description' => __('Store collapsed states for each menu on a user-by-user basis.', 'noakes-menu-manager'),
					'help_description' => __('All collapsible nav menu items are collapsed by default. With this option enabled, the state of the collapased items is stored within the meta for each user.', 'noakes-menu-manager'),
					'label' => __('Store Collapsed States', 'noakes-menu-manager'),
					'name' => 'store_collapsed_states',
					'type' => 'checkbox',
					'value' => $this->store_collapsed_states
				));
			}
			
			$nmm_menu_label = __('NMM Menu', 'noakes-menu-manager');
			
			$general_settings_box->add_field(array
			(
				'label' => __('Enable Widget', 'noakes-menu-manager'),
				'name' => 'enable_widget',
				'type' => 'checkbox',
				'value' => $this->enable_widget,
				
				'description' => sprintf
				(
					__('Make the %s widget available to use in sidebars.', 'noakes-menu-manager'),
					$nmm_menu_label
				),
				
				'help_description' => sprintf
				(
					__('Adds the %1$s widget which can be added to sidebars. This nav menu widget provides more control over the settings used for the %2$s output.', 'noakes-menu-manager'),
					'<em>' . $nmm_menu_label . '</em>',
					NMM_LINK_WP_NAV_MENU
				)
			));
			
			$general_settings_box->add_field(array
			(
				'description' => __('Disable the nav menu generator page.', 'noakes-menu-manager'),
				'help_description' => __('Completely disables the nav menu generator in the admin.', 'noakes-menu-manager'),
				'label' => __('Disable Generator', 'noakes-menu-manager'),
				'name' => 'disable_generator',
				'type' => 'checkbox',
				'value' => $this->disable_generator
			));
			
			$general_settings_box->add_field(array
			(
				'label' => __('Disable Help Buttons', 'noakes-menu-manager'),
				'name' => 'disable_help_buttons',
				'type' => 'checkbox',
				'value' => $this->disable_help_buttons,
				
				'description' => sprintf
				(
					__('Remove help buttons specific to %s.', 'noakes-menu-manager'),
					$plugin_label
				),
				
				'help_description' => sprintf
				(
					__('Removes all help buttons (%1$s) associated with %2$s functionality. The help buttons are meant for users that aren\'t yet familiar with the plugin.', 'noakes-menu-manager'),
					Noakes_Menu_Manager_Output::help_button(),
					$plugin_label
				)
			));

			$general_settings_box->add_field(array
			(
				'classes' => ($this->disable_help_buttons) ? array() : array('nmm-hidden'),
				'label' => __('Disable Help Tabs', 'noakes-menu-manager'),
				'name' => 'disable_help_tabs',
				'type' => 'checkbox',
				'value' => $this->disable_help_tabs,
				
				'conditional' => array
				(
					array
					(
						'field' => 'disable_help_buttons',
						'value' => '1'
					)
				),
				
				'description' => sprintf
				(
					__('Remove help tabs specific to %s.', 'noakes-menu-manager'),
					$plugin_label
				),
				
				'help_description' => sprintf
				(
					__('Removes all help tabs associated with %s functionality. The help tabs are meant for users that aren\'t yet familiar with the plugin.', 'noakes-menu-manager'),
					$plugin_label
				)
			));
			
			$save_all_field = array
			(
				'content' => __('Save All Settings', 'noakes-menu-manager'),
				'type' => 'submit'
			);

			$general_settings_box->add_field($save_all_field);

			$site_menus_box = new Noakes_Menu_Manager_Meta_Box(array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-site-menus',
				'id' => 'site_menus',
				'option_name' => NMM_OPTION_SETTINGS,
				'title' => __('Site Menus', 'noakes-menu-manager'),
				
				'help_description' => sprintf
				(
					__('The settings in this box are used to maintain registered nav menus.', 'noakes-menu-manager'),
					$plugin_label
				)
			));

			$site_menus_box->add_field(array
			(
				'description' => __('Menus added by the theme or another plugin. Use the checkboxes to disable menus that aren\'t in use.', 'noakes-menu-manager'),
				'label' => __('Existing Menus', 'noakes-menu-manager'),
				'name' => 'disable',
				'type' => 'existing_menus',
				'value' => $this->disable,
				
				'help_description' => sprintf
				(
					__('Lists nav menus that are added outside of the %s as well as their current assignments. Checking a box next to one of these menus will hide it from the nav menus page. If there are no existing menus, this field will not be displayed.', 'noakes-menu-manager'),
					$plugin_label
				)
			));
			
			$add_menu = __('Add Menu', 'noakes-menu-manager');
			$field_output = __('%1$s: %2$s', 'noakes-menu-manager');
			$field_location = __('Location', 'noakes-menu-manager');
			$field_description = __('Description', 'noakes-menu-manager');

			$site_menus_box->add_field(array
			(
				'add_item' => $add_menu,
				'add_layout' => true,
				'description' => __('Menus to register for the site.', 'noakes-menu-manager'),
				'label' => __('Menus', 'noakes-menu-manager'),
				'name' => 'menus',
				'type' => NMM_FIELD_REPEATABLE,
				'value' => $this->menus,

				'fields' => array
				(
					array
					(
						'type' => NMM_FIELD_GROUP,
						
						'fields' => array
						(
							array
							(
								'description' => __('Menu location identifier, like a slug.', 'noakes-menu-manager'),
								'hide_labels' => true,
								'input_classes' => array('required', 'nmm-location'),
								'label' => $field_location,
								'name' => 'location',
								'placeholder' => $field_location,
								'type' => 'text'
							),

							array
							(
								'description' => __('Menu description that is displayed in the dashboard.', 'noakes-menu-manager'),
								'hide_labels' => true,
								'input_classes' => array('required'),
								'label' => $field_description,
								'name' => 'description',
								'placeholder' => $field_description,
								'type' => 'text'
							)
						)
					)
				),
				
				'help_description' => __('Repeatable field that allows for the quick registration of nav menus. They are maintained using the following functionality:', 'noakes-menu-manager') .
					'<ul>' .
					'<li>' .
					sprintf
					(
						__('%s Adds a new menu to the bottom of the list.', 'noakes-menu-manager'),
						'<span class="button nmm-button" style="vertical-align: baseline; cursor: default;">' . $add_menu . '</span>'
					) .
					'</li>' .
					'<li>' .
					sprintf
					(
						__('%s Inserts a new menu above the menu clicked on.', 'noakes-menu-manager'),
						NMM_ICON_PLUS
					) .
					'</li>' .
					'<li>' .
					sprintf
					(
						__('%s Removes the menu from the list.', 'noakes-menu-manager'),
						NMM_ICON_NO
					) .
					'</li>' .
					'<li>' .
					sprintf
					(
						__('%s Handle for dragging the menu to a new position.', 'noakes-menu-manager'),
						NMM_ICON_MOVE
					) .
					'</li>' .
					'<li>' .
					sprintf
					(
						__('%1$s%2$s Quickly swap positions with the menu above or below.', 'noakes-menu-manager'),
						NMM_ICON_ARROW_DOWN,
						NMM_ICON_ARROW_UP
					) .
					'</li>' .
					'</ul>' .
					__('The following fields are available for each nav menu:', 'noakes-menu-manager') .
					'<ul>' .
					'<li>' .
					sprintf
					(
						$field_output,
						'<strong>' . $field_location . '</strong>',
						__('Menu location identifier, like a slug. This field is required and must be unique.', 'noakes-menu-manager')
					) .
					'</li>' .
					'<li>' .
					sprintf
					(
						$field_output,
						'<strong>' . $field_description . '</strong>',
						__('Menu description that is displayed in the dashboard. This field is required.', 'noakes-menu-manager')
					) .
					'</ul>'
			));

			$site_menus_box->add_field($save_all_field);
			
			$menu_settings_box = new Noakes_Menu_Manager_Meta_Box(array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-menu-settings',
				'id' => 'menu_settings',
				'option_name' => NMM_OPTION_SETTINGS,
				'title' => __('Menu Settings', 'noakes-menu-manager')
			));

			$menu_settings_box->add_field(array
			(
				'description' => __('If entered, this class will be added to all active nav menu items.', 'noakes-menu-manager'),
				'label' => __('Active Class', 'noakes-menu-manager'),
				'name' => 'active_class',
				'type' => 'text',
				'value' => $this->active_class,
				
				'help_description' => sprintf
				(
					__('Any nav menu item containing a general WordPress active class will also get this class if it is entered. General WordPress active classes include %1$s. This functionality relies on the %2$s filter hook which is used in the default nav menu walker.', 'noakes-menu-manager'),
					'<em>' . implode(', ', $this->_base->_nav_menus->_active_classes) . '</em>',
					'<em>nav_menu_css_class</em>'
				)
			));

			$menu_settings_box->add_field(array
			(
				'label' => __('Exclude Default IDs', 'noakes-menu-manager'),
				'name' => 'exclude_default_ids',
				'type' => 'checkbox',
				'value' => $this->exclude_default_ids,
				
				'description' => sprintf
				(
					__('Remove default nav menu item %s IDs.', 'noakes-menu-manager'),
					$this->dom
				),
				
				'help_description' => sprintf
				(
					__('Enabling this option will exclude the ID attribute from all list items in nav menus. This functionality relies on the %s filter hook which is used in the default nav menu walker.', 'noakes-menu-manager'),
					'<em>nav_menu_item_id</em>'
				)
			));

			$menu_settings_box->add_field(array
			(
				'label' => __('Enable ID', 'noakes-menu-manager'),
				'name' => 'enable_id',
				'type' => 'checkbox',
				'value' => $this->enable_id,
				
				'description' => sprintf
				(
					__('Add a %s field to nav menu items.', 'noakes-menu-manager'),
					$this->_base->_cache->dom_id
				),
				
				'help_description' => sprintf
				(
					__('Adds a %1$s field to nav menus. This functionality also relies on the %2$s filter hook.', 'noakes-menu-manager'),
					$this->_base->_cache->dom_id,
					'<em>nav_menu_item_id</em>'
				)
			));
			
			$menu_settings_box->add_field(array
			(
				'description' => __('Add a query string field to nav menu items.', 'noakes-menu-manager'),
				'label' => __('Enable Query String', 'noakes-menu-manager'),
				'name' => 'enable_query_string',
				'type' => 'checkbox',
				'value' => $this->enable_query_string,
				
				'help_description' => sprintf
				(
					__('Adds a field that allows query string values to be added to the nav menu item URL. If the URL already contains a query string, these values are appended. This functionality relies on the %s filter hook which is used in the default nav menu walker.', 'noakes-menu-manager'),
					'<em>nav_menu_link_attributes</em>'
				)
			));

			$menu_settings_box->add_field(array
			(
				'description' => __('Add an anchor field to nav menu items.', 'noakes-menu-manager'),
				'label' => __('Enable Anchor', 'noakes-menu-manager'),
				'name' => 'enable_anchor',
				'type' => 'checkbox',
				'value' => $this->enable_anchor,
				
				'help_description' => sprintf
				(
					__('Allows and anchor to be added to the end of the nav menu item URL. If an anchor already exists in the URL, it is replaced by this value. This functionality also relies on the %s filter hook.', 'noakes-menu-manager'),
					'<em>nav_menu_link_attributes</em>'
				)
			));

			$menu_settings_box->add_field($save_all_field);
			
			$uninstall_settings_box = new Noakes_Menu_Manager_Meta_Box(array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-uninstall-settings',
				'id' => 'uninstall_settings',
				'option_name' => NMM_OPTION_SETTINGS,
				'title' => __('Uninstall Settings', 'noakes-menu-manager')
			));

			$uninstall_settings_box->add_field(array
			(
				'complex' => true,
				'label' => __('Fail-safe Code', 'noakes-menu-manager'),
				'type' => 'code',
				'value' => $this->fail_safe_code(),
				
				'description' => sprintf
				(
					__('Add this code to the theme functions.php to prevent site menus from disappearing if the %s is disabled or uninstalled.', 'noakes-menu-manager'),
					$plugin_label
				),
				
				'help_description' => sprintf
				(
					__('Outputs code based on the site menus registered by the %s. Adding this code to the theme functions.php will add a layer of protection to the site menus in the event of plugin deactivation or uninstallation.', 'noakes-menu-manager'),
					$plugin_label
				)
			));
			
			$delete_settings_description = sprintf
			(
				__('Delete settings for the %s when the plugin is uninstalled.', 'noakes-menu-manager'),
				$plugin_label
			);
			
			$delete_settings_label = __('Delete Plugin Settings', 'noakes-menu-manager');
			$delete_settings_unconfirmed = NMM_SETTING_DELETE_SETTINGS . '_unconfirmed';
			$delete_settings_value = $this->{NMM_SETTING_DELETE_SETTINGS};
			
			$uninstall_settings_box->add_field(array
			(
				'classes' => ($delete_settings_value) ? array('nmm-hidden') : array(),
				'description' => $delete_settings_description,
				'label' => $delete_settings_label,
				'name' => $delete_settings_unconfirmed,
				'type' => 'checkbox',
				'value' => $delete_settings_value,

				'help_description' => sprintf
				(
					__('When the %s is uninstalled, all plugin settings are deleted in the process. This option must be confirmed before it is saved.', 'noakes-menu-manager'),
					$plugin_label
				)
			));

			$uninstall_settings_box->add_field(array
			(
				'classes' => ($delete_settings_value) ? array() : array('nmm-confirmation nmm-hidden'),
				'description' => $delete_settings_description,
				'label' => ($delete_settings_value) ? $delete_settings_label : __('Confirm Delete Plugin Settings', 'noakes-menu-manager'),
				'name' => NMM_SETTING_DELETE_SETTINGS,
				'type' => 'checkbox',
				'value' => $delete_settings_value,

				'conditional' => array
				(
					array
					(
						'field' => $delete_settings_unconfirmed,
						'value' => '1'
					)
				)
			));
			
			$delete_post_meta_description = sprintf
			(
				__('Delete post meta specific to the %s when the plugin is uninstalled.', 'noakes-menu-manager'),
				$plugin_label
			);
			
			$delete_post_meta_label = __('Delete Plugin Post Meta', 'noakes-menu-manager');
			$delete_post_meta_unconfirmed = NMM_SETTING_DELETE_POST_META . '_unconfirmed';
			$delete_post_meta_value = $this->{NMM_SETTING_DELETE_POST_META};
			
			$uninstall_settings_box->add_field(array
			(
				'classes' => ($delete_post_meta_value) ? array('nmm-hidden') : array(),
				'description' => $delete_post_meta_description,
				'label' => $delete_post_meta_label,
				'name' => $delete_post_meta_unconfirmed,
				'type' => 'checkbox',
				'value' => $delete_post_meta_value,

				'help_description' => sprintf
				(
					__('When using the custom nav menu fields, post meta is added to the database for nav menu items. When the %s is uninstalled, this post meta is deleted in the process. This option must be confirmed before it is saved.', 'noakes-menu-manager'),
					$plugin_label
				)
			));

			$uninstall_settings_box->add_field(array
			(
				'classes' => ($delete_post_meta_value) ? array() : array('nmm-confirmation nmm-hidden'),
				'description' => $delete_post_meta_description,
				'label' => ($delete_post_meta_value) ? $delete_post_meta_label : __('Confirm Delete Plugin Post Meta', 'noakes-menu-manager'),
				'name' => NMM_SETTING_DELETE_POST_META,
				'type' => 'checkbox',
				'value' => $delete_post_meta_value,

				'conditional' => array
				(
					array
					(
						'field' => $delete_post_meta_unconfirmed,
						'value' => '1'
					)
				)
			));
			
			$delete_user_meta_description = sprintf
			(
				__('Delete user meta specific to the %s when the plugin is uninstalled.', 'noakes-menu-manager'),
				$plugin_label
			);
			
			$delete_user_meta_label = __('Delete Plugin User Meta', 'noakes-menu-manager');
			$delete_user_meta_unconfirmed = NMM_SETTING_DELETE_USER_META . '_unconfirmed';
			$delete_user_meta_value = $this->{NMM_SETTING_DELETE_USER_META};
			
			$uninstall_settings_box->add_field(array
			(
				'classes' => ($delete_user_meta_value) ? array('nmm-hidden') : array(),
				'description' => $delete_user_meta_description,
				'label' => $delete_user_meta_label,
				'name' => $delete_user_meta_unconfirmed,
				'type' => 'checkbox',
				'value' => $delete_user_meta_value,

				'help_description' => sprintf
				(
					__('When using stored collapsed states, that information is saved in the user meta table. When the %s is uninstalled, this user meta is deleted in the process. This option must be confirmed before it is saved.', 'noakes-menu-manager'),
					$plugin_label
				)
			));

			$uninstall_settings_box->add_field(array
			(
				'classes' => ($delete_user_meta_value) ? array() : array('nmm-confirmation nmm-hidden'),
				'description' => $delete_user_meta_description,
				'label' => ($delete_user_meta_value) ? $delete_user_meta_label : __('Confirm Delete Plugin User Meta', 'noakes-menu-manager'),
				'name' => NMM_SETTING_DELETE_USER_META,
				'type' => 'checkbox',
				'value' => $delete_user_meta_value,

				'conditional' => array
				(
					array
					(
						'field' => $delete_user_meta_unconfirmed,
						'value' => '1'
					)
				)
			));

			$uninstall_settings_box->add_field($save_all_field);
			
			Noakes_Menu_Manager_Meta_Box::finalize_meta_boxes();
		}
		
		/**
		 * Generate the fail-safe code output.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return array Lines of generated code.
		 */
		private function fail_safe_code()
		{
			if (empty($this->menus)) return '';
			
			$code = array
			(
				'comment' => '/* ' . esc_html($this->_base->_cache->plugin_data['Name']) . ' Fail-safe Code */',
				'if ( ! class_exists( \'Noakes_Menu_Manager\' ) && ! function_exists( \'nmm_fail_safe_code\' ) ) {',
				'add_action( \'after_setup_theme\', \'nmm_fail_safe_code\' );',
				PHP_EOL,
				'function nmm_fail_safe_code() {',
				'register_nav_menus( array(',
			);
			
			$theme = wp_get_theme();
			$text_domain = $theme->get('TextDomain');
			$text_domain = (empty($text_domain)) ? 'noakes-menu-manager' : esc_attr($text_domain);
			
			foreach ($this->menus as $i => $menu)
			{
				$code[] = '\'' . esc_attr($menu['location']) . '\' => __( \'' . esc_attr($menu['description']) . '\', \'' . $text_domain . '\' ),';
			}
			
			$last_line = array_pop($code);
			
			$code = array_merge
			(
				$code,
				
				array
				(
					substr($last_line, 0, strlen($last_line) - 1),
					') );',
					'}',
					'}'
				)
			);
			
			return $code;
		}

		/**
		 * Add action links to the plugin list.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array $links Existing action links.
		 * @return array        Modified action links.
		 */
		public function plugin_action_links($links)
		{
			array_unshift($links, '<a href="' . esc_url(admin_url('options-general.php?page=' . NMM_OPTION_SETTINGS)) . '">' . __('Settings', 'noakes-menu-manager') . '</a>');

			return $links;
		}
	}
}
