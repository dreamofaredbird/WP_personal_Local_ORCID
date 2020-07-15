<?php
/**
 * Nav menus functionality.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Nav Menus
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Nav_Menus'))
{
	/**
	 * Class used to implement nav menus functionality.
	 *
	 * @since 2.0.0
	 * 
	 * @uses Noakes_Menu_Manager_Wrapper
	 */
	final class Noakes_Menu_Manager_Nav_Menus extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Active nav menu item classes used by WordPress.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    array
		 */
		public $_active_classes = array
		(
			'current-menu-item',
			'current-menu-parent',
			'current-menu-ancestor',
			'current_page_item',
			'current_page_parent',
			'current_page_ancestor'
		);
		
		/**
		 * Default values for the wp_nav_menu code.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    array
		 */
		public $_wp_nav_menu_defaults = array
		(
			'menu' => '',
			'menu_class' => '',
			'menu_id' => '',
			'container' => 'div',
			'container_class' => '',
			'container_id' => '',
			'fallback_cb' => '',
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'echo' => 'true',
			'depth' => 0,
			'walker' => '',
			'theme_location' => '',
			'items_wrap' => '',
			'item_spacing' => ''
		);
		
		/**
		 * Flag for custom fields.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @var    boolean
		 */
		private $_has_custom_fields;
		
		/**
		 * Custom field values.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @var    boolean or array
		 */
		private $_custom_field_values = array();
		
		/**
		 * Constructor function.
		 * 
		 * @since 2.0.1 Fixed logic to allow nav menus functionality to load correctly.
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base Base plugin object.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base)
		{
			parent::__construct($base);

			if ($this->_base->_settings->active_class != '')
			{
				add_filter('nav_menu_css_class', array($this, 'nav_menu_css_class'), 10, 2);
			}
			
			if ($this->_base->_settings->enable_id || $this->_base->_settings->exclude_default_ids)
			{
				add_filter('nav_menu_item_id', array($this, 'nav_menu_item_id'), 10, 2);
			}
			
			$this->_has_custom_fields = ($this->_base->_settings->enable_id || $this->_base->_settings->enable_query_string || $this->_base->_settings->enable_anchor);
			
			if (!$this->_base->_cache->has_legacy_nmc || $this->_has_custom_fields)
			{
				if ($this->_has_custom_fields)
				{
					add_filter('wp_get_nav_menu_items', array($this, 'wp_get_nav_menu_items'));
					add_filter('wp_setup_nav_menu_item', array($this, 'wp_setup_nav_menu_item'));

					if ($this->_base->_settings->enable_query_string || $this->_base->_settings->enable_anchor)
					{
						add_filter('nav_menu_link_attributes', array($this, 'nav_menu_link_attributes'), 10, 2);
					}
				}
				else
				{
					$this->_custom_field_values = false;
				}
				
				if (is_admin())
				{
					if ($this->_has_custom_fields && Noakes_Menu_Manager_Utilities::is_ajax_action('add-menu-item'))
					{
						add_action('admin_init', array($this, 'admin_init'));
					}
					else if (!NMM_AJAX)
					{
						add_action('load-nav-menus.php', array($this, 'load_nav_menus'));
					}
				}
			}
		}

		/**
		 * Add the active class to appropriate menu items.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array  $classes Array of menu item classes.
		 * @param  object $item    Nav menu item data object.
		 * @return array           Modified array of menu item classes.
		 */
		public function nav_menu_css_class($classes, $item)
		{
			$intersecting = array_intersect($this->_active_classes, $classes);

			if (!empty($intersecting))
			{
				$classes[] = $this->_base->_settings->active_class;
			}

			return $classes;
		}

		/**
		 * Modify menu item DOM IDs.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  string $menu_id DOM ID of the current menu item.
		 * @param  object $item    Nav menu item object.
		 * @return string          Filtered menu item DOM ID.
		 */
		public function nav_menu_item_id($menu_id, $item)
		{
			if ($this->_base->_settings->enable_id && $item->noakes_id != '')
			{
				return $item->noakes_id;
			}

			return ($this->_base->_settings->exclude_default_ids) ? '' : $menu_id;
		}
		
		/**
		 * Gather the custom field values.
		 *
		 * @since 2.0.0
		 *
		 * @param  array $items Array of nav menu item objects.
		 * @return array        Original array of nav menu item objects.
		 */
		public function wp_get_nav_menu_items($items)
		{
			foreach ($items as $menu_item)
			{
				if (!empty($menu_item->noakes_id) || !empty($menu_item->noakes_query_string) || !empty($menu_item->noakes_anchor))
				{
					$this->_custom_field_values[$menu_item->ID] = array
					(
						'id' => $menu_item->noakes_id,
						'query_string' => $menu_item->noakes_query_string,
						'anchor' => $menu_item->noakes_anchor
					);
				}
			}
			
			return $items;
		}

		/**
		 * Setup a nav menu item.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  object $menu_item Nav menu item object.
		 * @return string            Filtered nav menu item object.
		 */
		public function wp_setup_nav_menu_item($menu_item)
		{
			$menu_item->noakes_id = ($this->_base->_settings->enable_id) ? get_post_meta($menu_item->ID, '_menu_item_noakes_id', true) : '';
			$menu_item->noakes_query_string = ($this->_base->_settings->enable_query_string) ? get_post_meta($menu_item->ID, '_menu_item_noakes_query_string', true) : '';
			$menu_item->noakes_anchor = ($this->_base->_settings->enable_anchor) ? get_post_meta($menu_item->ID, '_menu_item_noakes_anchor', true) : '';

			return $menu_item;
		}

		/**
		 * Modify menu item link attributes.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  string $atts Initial link attributes.
		 * @param  object $item Nav menu item object.
		 * @return string       Filtered link attributes.
		 */
		public function nav_menu_link_attributes($atts, $item)
		{
			$href_pieces = explode('#', $atts['href']);

			if ($this->_base->_settings->enable_query_string && $item->noakes_query_string != '')
			{
				$href_pieces[0] .= (strpos($href_pieces[0], '?') === false) ? '?' : '&';
				$href_pieces[0] .= $item->noakes_query_string;
			}

			if ($this->_base->_settings->enable_anchor && $item->noakes_anchor != '')
			{
				$href_pieces[1] = $item->noakes_anchor;
			}

			$atts['href'] = $href_pieces[0];

			if (isset($href_pieces[1]) && $href_pieces[1] != '')
			{
				$atts['href'] .= '#' . $href_pieces[1];
			}

			return $atts;
		}

		/**
		 * Load nav menus AJAX functionality.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_init()
		{
			add_action('wp_update_nav_menu_item', array($this, 'wp_update_nav_menu_item'), 11, 2);
		}

		/**
		 * Load nav menus page functionality.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function load_nav_menus()
		{
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 11);
			add_action('admin_footer', array($this, 'admin_footer'));

			if ($this->_has_custom_fields)
			{
				$this->admin_init();
				
				add_filter('manage_nav-menus_columns', array($this, 'manage_columns'), 11);
			}
			
			$this->add_help_tabs();
		}
		
		/**
		 * Fires after a navigation menu item has been updated.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  integer $menu_id         ID of the updated menu.
		 * @param  integer $menu_item_db_id ID of the updated menu item.
		 * @return void
		 */
		public function wp_update_nav_menu_item($menu_id, $menu_item_db_id)
		{
			if (!isset($_POST['update-nav-menu-nonce']) || !wp_verify_nonce($_POST['update-nav-menu-nonce'], 'update-nav_menu')) return;

			if ($this->_base->_settings->enable_id && isset($_POST['menu-item-noakes-id']) && !empty($_POST['menu-item-noakes-id'][$menu_item_db_id]))
			{
				update_post_meta($menu_item_db_id, '_menu_item_noakes_id', Noakes_Menu_Manager_Utilities::remove_redundancies($_POST['menu-item-noakes-id'][$menu_item_db_id]));
			}
			else
			{
				delete_post_meta($menu_item_db_id, '_menu_item_noakes_id');
			}

			if ($this->_base->_settings->enable_query_string && isset($_POST['menu-item-noakes-query-string']) && !empty($_POST['menu-item-noakes-query-string'][$menu_item_db_id]))
			{
				update_post_meta($menu_item_db_id, '_menu_item_noakes_query_string', Noakes_Menu_Manager_Utilities::remove_redundancies($_POST['menu-item-noakes-query-string'][$menu_item_db_id]));
			}
			else
			{
				delete_post_meta($menu_item_db_id, '_menu_item_noakes_query_string');
			}

			if ($this->_base->_settings->enable_anchor && isset($_POST['menu-item-noakes-anchor']) && !empty($_POST['menu-item-noakes-anchor'][$menu_item_db_id]))
			{
				update_post_meta($menu_item_db_id, '_menu_item_noakes_anchor', Noakes_Menu_Manager_Utilities::remove_redundancies($_POST['menu-item-noakes-anchor'][$menu_item_db_id]));
			}
			else
			{
				delete_post_meta($menu_item_db_id, '_menu_item_noakes_anchor');
			}
		}

		/**
		 * Enqueues scripts for the nav menus page.
		 * 
		 * @since 2.0.2 Added dashicons CSS dependency.
		 * @since 2.0.1 Fixed logic to allow nav menus functionality to load correctly.
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_enqueue_scripts()
		{
			wp_enqueue_style('nmm-style', $this->_base->_cache->asset_path('styles', 'style.css'), array('dashicons'), NMM_VERSION);
			wp_enqueue_script('nmm-script', $this->_base->_cache->asset_path('scripts', 'script.js'), array('wp-util'), NMM_VERSION, true);

			$collapsed = ($this->_base->_cache->has_legacy_nmc) ? '0' : '1';
			$collapsed = ($this->_base->_settings->store_collapsed_states === '1') ? get_user_meta(get_current_user_id(), 'nmm_collapsed', true) : $collapsed;
			
			wp_localize_script('nmm-script', 'nmm_script_options', array
			(
				'is_nav_menus' => true,
				'collapsed' => (is_array($collapsed) || $collapsed === '0' || $collapsed === '1') ? $collapsed : array(),
				'custom_fields' => ($this->_custom_field_values === false) ? '0' : $this->_custom_field_values,
				'nested' => __('%d Nested Menu Items', 'noakes-menu-manager')
			));
		}
		
		/**
		 * Include the HTML templates in the admin footer.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_footer()
		{
			$templates_path = dirname(__FILE__) . '/../templates/';
			
			ob_start();
			
			if ($this->_has_custom_fields)
			{
				include_once($templates_path . 'custom-fields.php');
			}
			
			if (!$this->_base->_cache->has_legacy_nmc)
			{
				include_once($templates_path . 'collapse-expand-all.php');
				include_once($templates_path . 'collapse-expand.php');
			}
			
			echo Noakes_Menu_Manager_Utilities::clean_code(ob_get_clean());
		}
		
		/**
		 * Returns the columns for the nav menus page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array $columns Existing nav menu columns.
		 * @return array          Updated nav menu columns.
		 */
		public function manage_columns($columns)
		{
			if ($this->_base->_settings->enable_id)
			{
				$columns['noakes-id'] = $this->_base->_cache->dom_id;
			}

			if ($this->_base->_settings->enable_query_string)
			{
				$columns['noakes-query-string'] = __('Query String', 'noakes-menu-manager');
			}

			if ($this->_base->_settings->enable_anchor)
			{
				$columns['noakes-anchor'] = __('Anchor', 'noakes-menu-manager');
			}
			
			return $columns;
		}
		
		/**
		 * Add the help tabs to the page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return void
		 */
		private function add_help_tabs()
		{
			if (!$this->_base->_settings->disable_help_tabs)
			{
				$plugin_label = $this->_base->_cache->plugin_data['Name'];
				
				if (!$this->_base->_cache->has_legacy_nmc)
				{
					$collapse_expand_label = __('Collapse/Expand', 'noakes-menu-manager');
					
					Noakes_Menu_Manager_Help::add_tab
					(
						'nmm-collapse-expand',
						$collapse_expand_label,
						
						sprintf
						(
							__('%1$s - %2$s', 'noakes-menu-manager'),
							$plugin_label,
							$collapse_expand_label
						)
					);

					Noakes_Menu_Manager_Help::add_block
					(
						__('Overview', 'noakes-menu-manager'),
						
						sprintf
						(
							__('Nav menu items with children now have collapse (%1$s) and expand (%2$s) buttons on the right side of the nav menu item bar. Clicking on these buttons will hide/show child nav menu items accordingly. There are also collapse and expand all buttons above the menu to quickly hide or show all child nav menu items.', 'noakes-menu-manager'),
							'<span title="' . esc_attr__('Collapse', 'noakes-menu-manager') . '" class="nmm-collapse">&ndash;</span>',
							'<span title="' . esc_attr__('Expand', 'noakes-menu-manager') . '" class="nmm-expand">+</span>'
						)
					);
					
					Noakes_Menu_Manager_Help::add_block(__('Counts', 'noakes-menu-manager'), '<p>' . __('The number in parenthesis next to the nav menu item title indicates the total number of nested nav menu items.', 'noakes-menu-manager') . '</p>');

					Noakes_Menu_Manager_Help::add_block
					(
						__('Ordering', 'noakes-menu-manager'),
						
						'<ul>' .
						'<li>' . __('While dragging a nav menu item, hover over a collapsed nav menu item for one second to expand it.', 'noakes-menu-manager') . '</li>' .
						'<li>' . __('When a nav menu item is dropped into a collapsed nav menu item, that item will expand automatically.', 'noakes-menu-manager') . '</li>' .
						'</ul>'
					);
				}
				
				if ($this->_has_custom_fields)
				{
					$blocks = array();
					
					if ($this->_base->_settings->enable_id)
					{
						$blocks[$this->_base->_cache->dom_id] = sprintf
							(
								__('The %s for the list item. If default IDs are enabled, this will replace the default.', 'noakes-menu-manager'),
								$this->_base->_cache->dom_id
							);
					}
					
					if ($this->_base->_settings->enable_query_string)
					{
						$blocks[__('Query String', 'noakes-menu-manager')] = __('Query string values for the URL. If the URL already contains a query string, this will be appended.', 'noakes-menu-manager');
					}
					
					if ($this->_base->_settings->enable_anchor)
					{
						$blocks[__('Anchor', 'noakes-menu-manager')] = __('Appended to the end of the URL. If an anchor already exists in the URL, it will be replaced.', 'noakes-menu-manager');
					}
					
					$block_count = count($blocks);
					
					Noakes_Menu_Manager_Help::add_tab
					(
						'nmm-custom-fields',
						_n('Custom Field', 'Custom Fields', $block_count, 'noakes-menu-manager'),
						
						sprintf
						(
							_n('%s - Custom Field', '%s - Custom Fields', $block_count, 'noakes-menu-manager'),
							$plugin_label
						)
					);
					
					foreach ($blocks as $subheading => $content)
					{
						Noakes_Menu_Manager_Help::add_block($subheading, $content);
					}
				}

				Noakes_Menu_Manager_Help::output(false);
			}
		}
	}
}
