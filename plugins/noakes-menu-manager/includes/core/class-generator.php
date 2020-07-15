<?php
/**
 * Generator page functionality.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Generator
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Generator'))
{
	/**
	 * Class used to implement settings functionality.
	 *
	 * @since 2.0.0
	 * 
	 * @uses Noakes_Menu_Manager_Wrapper
	 */
	final class Noakes_Menu_Manager_Generator extends Noakes_Menu_Manager_Wrapper
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
			
			add_action('admin_init', array($this, 'admin_init'));
			add_action('admin_menu', array($this, 'admin_menu'));

			add_filter('plugin_action_links_' . plugin_basename($this->_base->_plugin), array($this, 'plugin_action_links'));
		}

		/**
		 * Load the plugin generator option.
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
				
				/* @var string Method for selecting the nav menu to generate code for. */
				'choose_menu_by' => '',
				
				/* @var string Theme location to be used. */
				'theme_location' => '',
				
				/* @var string Nav menu to be used. */
				'menu' => '',
				
				/* @var string CSS class to use for the nav menu. */
				'menu_class' => '',
				
				/* @var string DOM ID that is applied to the nav menu. */
				'menu_id' => '',
				
				/* @var string Whether to wrap the nav menu, and what to wrap it with. */
				'container' => 'div',
				
				/* @var string Class that is applied to the nav menu container. */
				'container_class' => '',
				
				/* @var string DOM ID that is applied to the nav menu container. */
				'container_id' => '',
				
				/* @var string If the menu doesn\'t exist, a callback function will fire. */
				'fallback_cb' => '',
				
				/* @var string Tag wrapped around each nav menu item link. */
				'before_after_link' => '',
				
				/* @var string Tag wrapped around the content in each nav menu item link. */
				'before_after_text' => '',
				
				/* @var string Whether to echo the menu or return it. */
				'echoed' => '1',
				
				/* @var integer How many levels of the hierarchy are to be included. */
				'depth' => 0,
				
				/* @var string Instance of a custom walker class. */
				'walker' => '',
				
				/* @var string How the list items should be wrapped. */
				'items_wrap' => '',
				
				/* @var string Whether to preserve whitespace within the nav menu HTML. */
				'item_spacing' => ''
			);
			
			if (isset($_GET['reset']) && $_GET['reset'] === 'true')
			{
				update_option(NMM_OPTION_GENERATOR, $defaults);
			}
			
			$settings = (empty($settings)) ? get_option(NMM_OPTION_GENERATOR) : $settings;

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
			register_setting(NMM_OPTION_GENERATOR, NMM_OPTION_GENERATOR, array($this, 'sanitize'));
		}
		
		/**
		 * Sanitize the generator settings.
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
			
			$choose_by_menu = ($input['choose_menu_by'] == 'menu');
			$has_container = (!empty($input['container']));
			
			foreach ($input as $name => $value)
			{
				if ($name == 'theme_location')
				{
					$input[$name] = ($choose_by_menu) ? '' : $input[$name];
				}
				else if ($name == 'menu')
				{
					$input[$name] = ($choose_by_menu) ? $input[$name] : '';
				}
				else if ($name == 'menu_class')
				{
					$input[$name] = Noakes_Menu_Manager_Utilities::sanitize_classes($input[$name]);
				}
				else if ($name == 'container_class')
				{
					$input[$name] = ($has_container) ? Noakes_Menu_Manager_Utilities::sanitize_classes($input[$name]) : '';
				}
				else if ($name == 'container_id')
				{
					$input[$name] = ($has_container) ? sanitize_text_field($input[$name]) : '';
				}
				else if ($name == 'depth')
				{
					$input[$name] = (int)$input[$name];
				}
				else
				{
					$input[$name] = sanitize_text_field($input[$name]);
				}
			}
			
			if (!isset($input['echoed']))
			{
				$input['echoed'] = '';
			}
			
			return $input;
		}

		/**
		 * Add the generator page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_menu()
		{
			$generator_label = __('Generator', 'noakes-menu-manager');
			
			Noakes_Menu_Manager_Output::add_tab('tools.php', NMM_OPTION_GENERATOR, $generator_label);
			
			$this->page_title = sprintf
			(
				__('%1$s - %2$s', 'noakes-menu-manager'),
				$this->_base->_cache->plugin_data['Name'],
				$generator_label
			);
			
			$generator_page = add_management_page($this->page_title, __('Nav Menu Generator', 'noakes-menu-manager'), 'manage_options', NMM_OPTION_GENERATOR, array($this, 'generator_page'));
			
			add_action('load-' . $generator_page, array($this, 'load_generator'));
		}

		/**
		 * Output the generator page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function generator_page()
		{
			Noakes_Menu_Manager_Output::admin_page($this->page_title, NMM_OPTION_GENERATOR);
		}

		/**
		 * Load generator page functionality.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function load_generator()
		{
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 11);

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
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_enqueue_scripts()
		{
			wp_enqueue_style('nmm-style', $this->_base->_cache->asset_path('styles', 'style.css'), array(), NMM_VERSION);
			wp_enqueue_script('nmm-script', $this->_base->_cache->asset_path('scripts', 'script.js'), array('postbox'), NMM_VERSION, true);

			wp_localize_script
			(
				'nmm-script',
				'nmm_script_options',
				
				array
				(
					'is_settings' => true,

					'validator' => array
					(
						'required' => __('This field is required.', 'noakes-menu-manager')
					)
				)
			);
		}

		/**
		 * Add meta boxes to the generator page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return void
		 */
		private function add_meta_boxes()
		{
			$args = $this->generate_args();
			
			if (!empty($args))
			{
				$code_output_box = new Noakes_Menu_Manager_Meta_Box(array
				(
					'context' => 'normal',
					'help_tab_id' => 'nmm-generator',
					'id' => 'code_output',
					'option_name' => NMM_OPTION_GENERATOR,
					'title' => __('Code Output', 'noakes-menu-manager')
				));
				
				$code_output_box->add_field(array
				(
					'label' => __('Theme Code', 'noakes-menu-manager'),
					'type' => 'code',
					'value' => $this->generate_code($args),
					
					'description' => sprintf
					(
						__('Generated %s code based on the selected options.', 'noakes-menu-manager'),
						strip_tags(NMM_LINK_WP_NAV_MENU)
					)
				));
				
				$code_output_box->add_field(array
				(
					'description' => __('Generated shortcode based on the selected options.', 'noakes-menu-manager'),
					'label' => __('Shortcode', 'noakes-menu-manager'),
					'type' => 'code',
					'value' => $this->generate_shortcode($args)
				));

				$code_output_box->add_field(array
				(
					'content' => '<p><a href="' . esc_url(admin_url('tools.php?page=' . NMM_OPTION_GENERATOR . '&reset=true')) . '" class="button button-large nmm-button">' . __('Reset', 'noakes-menu-manager') . '</a></p>',
					'type' => 'html'
				));
			}
			
			$generator_box = new Noakes_Menu_Manager_Meta_Box(array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-generator',
				'id' => 'generator',
				'option_name' => NMM_OPTION_GENERATOR,
				'title' => __('Generator', 'noakes-menu-manager'),
				
				'help_description' => '<p>' .
					sprintf
					(
						__('This tool allows for %s code and a shortcode to be generated for a specified theme location or nav menu.', 'noakes-menu-manager'),
						NMM_LINK_WP_NAV_MENU
					) .
					'</p>' .
					'<ul>' .
					'<li>' . __('Select or enter the values to use in the code output.', 'noakes-menu-manager') . '</li>' .
					'<li>' .
					sprintf
					(
						__('Click on the %s button to generate the code output and save the settings.', 'noakes-menu-manager'),
						'<em>' . __('Generate', 'noakes-menu-manager') . '</em>'
					) .
					'</li>' .
					'<li>' . __('Default values will not be included in the code output.', 'noakes-menu-manager') . '</li>' .
					'<li>' . __('Once generated, click on a code block to select and copy the code.', 'noakes-menu-manager') . '</li>' .
					'<li><em>' . __('Note: The shortcode output will not contain the echo or walker arguments.', 'noakes-menu-manager') . '</em></li>' .
					'</ul>'
			));
			
			$theme_location_label = __('Theme Location', 'noakes-menu-manager');
			$nav_menu_label = __('Nav Menu', 'noakes-menu-manager');
			
			$generator_box->add_field(array
			(
				'description' => __('Method for selecting the nav menu to generate code for.', 'noakes-menu-manager'),
				'label' => __('Choose Menu By', 'noakes-menu-manager'),
				'name' => 'choose_menu_by',
				'type' => 'radio',
				'value' => $this->choose_menu_by,
				
				'options' => array
				(
					'' => $theme_location_label,
					'menu' => $nav_menu_label
				)
			));
			
			$generator_box->add_field(array
			(
				'classes' => ($this->choose_menu_by == 'menu') ? array('nmm-hidden') : array(),
				'description' => __('Theme location to be used.', 'noakes-menu-manager'),
				'input_classes' => array('required'),
				'label' => $theme_location_label,
				'name' => 'theme_location',
				'options' => array_merge(array('' => __('Select a theme location...', 'noakes-menu-manager')), get_registered_nav_menus()),
				'type' => 'select',
				'value' => $this->theme_location,
				
				'conditional' => array
				(
					array
					(
						'compare' => '!=',
						'field' => 'choose_menu_by',
						'value' => 'menu'
					)
				)
			));
			
			$menus = wp_get_nav_menus();
			$nav_menus = array('' => __('Select a menu...', 'noakes-menu-manager'));
			
			foreach ($menus as $menu)
			{
				$nav_menus[$menu->slug] = $menu->name;
			}
			
			$generator_box->add_field(array
			(
				'classes' => ($this->choose_menu_by == 'menu') ? array() : array('nmm-hidden'),
				'description' => __('Nav menu to be used.', 'noakes-menu-manager'),
				'input_classes' => array('required'),
				'label' => $nav_menu_label,
				'name' => 'menu',
				'options' => $nav_menus,
				'type' => 'select',
				'value' => $this->menu,
				
				'conditional' => array
				(
					array
					(
						'field' => 'choose_menu_by',
						'value' => 'menu'
					)
				)
			));

			$generator_box->add_field(array
			(
				'description' => __('CSS class to use for the nav menu. Default is \'menu\'.', 'noakes-menu-manager'),
				'label' => __('Menu Class(es)', 'noakes-menu-manager'),
				'name' => 'menu_class',
				'type' => 'text',
				'value' => $this->menu_class
			));

			$generator_box->add_field(array
			(
				'label' => __('Menu ID', 'noakes-menu-manager'),
				'name' => 'menu_id',
				'type' => 'text',
				'value' => $this->menu_id,
				
				'description' => sprintf
				(
					__('%s that is applied to the nav menu. Default is the menu slug, incremented.', 'noakes-menu-manager'),
					$this->_base->_cache->dom_id
				)
			));
			
			$generator_box->add_field(array
			(
				'description' => __('Whether to wrap the nav menu, and what to wrap it with.', 'noakes-menu-manager'),
				'label' => __('Container', 'noakes-menu-manager'),
				'name' => 'container',
				'options' => $this->_base->_cache->container_options,
				'type' => 'select',
				'value' => $this->container
			));
			
			$has_container = (!empty($this->container));

			$generator_box->add_field(array
			(
				'classes' => ($has_container) ? array() : array('nmm-hidden'),
				'description' => __('Class that is applied to the nav menu container. Default is \'menu-{menu slug}-container\'.', 'noakes-menu-manager'),
				'label' => __('Container Class(es)', 'noakes-menu-manager'),
				'name' => 'container_class',
				'type' => 'text',
				'value' => $this->container_class,
				
				'conditional' => array
				(
					array
					(
						'compare' => '!=',
						'field' => 'container',
						'value' => ''
					)
				)
			));

			$generator_box->add_field(array
			(
				'classes' => ($has_container) ? array() : array('nmm-hidden'),
				'label' => __('Container ID', 'noakes-menu-manager'),
				'name' => 'container_id',
				'type' => 'text',
				'value' => $this->container_id,
				
				'conditional' => array
				(
					array
					(
						'compare' => '!=',
						'field' => 'container',
						'value' => ''
					)
				),
				
				'description' => sprintf
				(
					__('%s that is applied to the nav menu container.', 'noakes-menu-manager'),
					$this->_base->_cache->dom_id
				)
			));

			$fallback_cb_label = __('Fallback Callback', 'noakes-menu-manager');
			$exclude_arg_label = __('Exclude argument from output', 'noakes-menu-manager');
			$include_arg_label = __('Include argument in output with default value', 'noakes-menu-manager');
			
			$generator_box->add_field(array
			(
				'description' => __('If the menu doesn\'t exist, a callback function will fire. Default is \'wp_page_menu\'.', 'noakes-menu-manager'),
				'label' => $fallback_cb_label,
				'name' => 'fallback_cb',
				'type' => 'select',
				'value' => $this->fallback_cb,
				
				'options' => array
				(
					'' => $exclude_arg_label,
					'true' => $include_arg_label,
					
					'false' => sprintf
					(
						__('Explicitly disable %s', 'noakes-menu-manager'),
						$fallback_cb_label
					)
				)
			));
			
			$generator_box->add_field(array
			(
				'description' => __('Tag wrapped around each nav menu item link.', 'noakes-menu-manager'),
				'label' => __('Before/After Link', 'noakes-menu-manager'),
				'name' => 'before_after_link',
				'options' => $this->_base->_cache->before_after_options,
				'type' => 'select',
				'value' => $this->before_after_link
			));

			$generator_box->add_field(array
			(
				'description' => __('Tag wrapped around the content in each nav menu item link.', 'noakes-menu-manager'),
				'label' => __('Before/After Text', 'noakes-menu-manager'),
				'name' => 'before_after_text',
				'options' => $this->_base->_cache->before_after_options,
				'type' => 'select',
				'value' => $this->before_after_text
			));

			$generator_box->add_field(array
			(
				'description' => __('Whether to echo the menu or return it.', 'noakes-menu-manager'),
				'label' => __('Echo', 'noakes-menu-manager'),
				'name' => 'echoed',
				'type' => 'checkbox',
				'value' => $this->echoed
			));
			
			$generator_box->add_field(array
			(
				'description' => __('How many levels of the hierarchy are to be included.', 'noakes-menu-manager'),
				'label' => __('Depth', 'noakes-menu-manager'),
				'name' => 'depth',
				'options' => $this->_base->_cache->depth_options,
				'type' => 'select',
				'value' => $this->depth
			));

			$generator_box->add_field(array
			(
				'description' => __('Instance of a custom walker class.', 'noakes-menu-manager'),
				'label' => __('Walker', 'noakes-menu-manager'),
				'name' => 'walker',
				'type' => 'select',
				'value' => $this->walker,
				
				'options' => array
				(
					'' => $exclude_arg_label,
					'true' => $include_arg_label
				)
			));

			$generator_box->add_field(array
			(
				'label' => __('Items Wrap', 'noakes-menu-manager'),
				'name' => 'items_wrap',
				'type' => 'select',
				'value' => $this->items_wrap,
				
				'description' => sprintf
				(
					__('How the list items should be wrapped. Default is a UL with an %s and CSS class. Uses printf() format with numbered placeholders.', 'noakes-menu-manager'),
					$this->_base->_cache->dom_id
				),
				
				'options' => array
				(
					'' => $exclude_arg_label,
					'true' => $include_arg_label
				)
			));

			$generator_box->add_field(array
			(
				'description' => __('Whether to preserve whitespace within the nav menu HTML.', 'noakes-menu-manager'),
				'label' => __('Item Spacing', 'noakes-menu-manager'),
				'name' => 'item_spacing',
				'options' => $this->_base->_cache->item_spacing_options,
				'type' => 'select',
				'value' => $this->item_spacing
			));
			
			$generator_box->add_field(array
			(
				'content' => __('Generate', 'noakes-menu-manager'),
				'type' => 'submit'
			));
			
			Noakes_Menu_Manager_Meta_Box::finalize_meta_boxes();
		}
		
		/**
		 * Generate the code output arguments based on the saved options.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return array Arguments used for code generation.
		 */
		private function generate_args()
		{
			$args = array();
			
			foreach ($this->_properties as $name => $value)
			{
				if ($name == 'before_after_link')
				{
					if (!empty($value))
					{
						$tag = esc_attr($value);
						$args['before'] = '<' . $tag . '>';
						$args['after'] = '</' . $tag . '>';
					}
				}
				else if ($name == 'before_after_text')
				{
					if (!empty($value))
					{
						$tag = esc_attr($value);
						$args['link_before'] = '<' . $tag . '>';
						$args['link_after'] = '</' . $tag . '>';
					}
				}
				else if ($name == 'echoed')
				{
					$args['echo'] = ($value == '1') ? 'true' : 'false';
				}
				else if ($name != 'page_title' && $name != 'choose_menu_by')
				{
					$args[$name] = $value;
				}
			}
			
			$args = array_diff_assoc($args, $this->_base->_nav_menus->_wp_nav_menu_defaults);
			
			if (isset($args['fallback_cb']) && $args['fallback_cb'] === 'true')
			{
				$args['fallback_cb'] = 'wp_page_menu';
			}
			
			if (isset($args['walker']) && $args['walker'] === 'true')
			{
				$args['walker'] = 'new Walker_Nav_Menu()';
			}
			
			if (isset($args['items_wrap']) && $args['items_wrap'] === 'true')
			{
				$args['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s</ul>';
			}
			
			return $args;
		}
		
		/**
		 * Generate the wp_nav_menu code based on the provided arguments.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @param  array  $args Arguments used for code generation.
		 * @return string       Generated wp_nav_menu code.
		 */
		private function generate_code($args)
		{
			$code = array
			(
				'wp_nav_menu( array('
			);
			
			foreach ($args as $name => $value)
			{
				$value = ($name == 'walker' || is_numeric($value) || $value === 'true' || $value === 'false') ? $value : '\'' . esc_attr($value) . '\'';
				$code[] = '\'' . esc_attr($name) . '\' => ' . esc_attr($value) . ',';
			}
			
			$last_line = array_pop($code);
			
			$code = array_merge
			(
				$code,
				
				array
				(
					substr($last_line, 0, strlen($last_line) - 1),
					') );'
				)
			);
			
			return $code;
		}
		
		/**
		 * Generate the shortcode based on the provided arguments.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @param  array  $args Arguments used for code generation.
		 * @return string Generated shortcode.
		 */
		private function generate_shortcode($args)
		{
			$code = '[' . NMM_ID;
			
			foreach ($args as $name => $value)
			{
				if ($name != 'echo' && $name != 'walker')
				{
					$code .= ' ' . esc_attr($name) . '="' . esc_html(str_replace('"', '__Q__', $value)) . '"';
				}
			}
			
			$code .= ']';
			
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
			array_unshift($links, '<a href="' . esc_url(admin_url('tools.php?page=' . NMM_OPTION_GENERATOR)) . '">' . __('Generator', 'noakes-menu-manager') . '</a>');

			return $links;
		}
	}
}
