<?php
/**
 * Meta box functionality.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Meta Box
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Meta_Box'))
{
	/**
	 * Class used to implement the meta box object.
	 *
	 * @since 2.0.0
	 * 
	 * @uses Noakes_Menu_Manager_Wrapper
	 */
	class Noakes_Menu_Manager_Meta_Box extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Constructor function.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array $options Optional options for the meta box.
		 * @return void
		 */
		public function __construct($options = array())
		{
			parent::__construct();

			$defaults = array
			(
				/* @var callable Function used to populate the meta box. */
				'callback' => array($this, 'callback'),

				/* @var array Data that should be set as the $args property of the box array. */
				'callback_args' => null,

				/* @var array CSS classes added to the meta box. */
				'classes' => array('nmm-meta-box'),

				/* @var string Context within the screen where the boxes should display. */
				'context' => 'advanced',

				/* @var array Field displayed in the meta box. */
				'fields' => array(),

				/* @var string Description displayed below the heading in the help tab. */
				'help_description' => '',

				/* @var string ID for the help tab associated with the meta box. */
				'help_tab_id' => '',

				/* @var string Base ID for the meta box. */
				'id' => '',

				/* @var string Option name for the fields in the meta box. */
				'option_name' => '',

				/* @var string Priority within the context where the boxes should show. */
				'priority' => 'default',

				/* @var string Title displayed in the meta box. */
				'title' => ''
			);

			$this->_set_properties($defaults, $options);

			if (is_callable($this->callback) && !empty($this->id) && $this->title != '')
			{
				$this->id = NMM_TOKEN . '_meta_box_' . $this->id;

				if (!$this->_base->_settings->disable_help_tabs && !empty($this->help_tab_id))
				{
					Noakes_Menu_Manager_Help::add_tab($this->help_tab_id, $this->title);
					
					if (!empty($this->help_description))
					{
						Noakes_Menu_Manager_Help::add_block('', $this->help_description);
					}
				}

				add_action('add_meta_boxes', array($this, 'add_meta_box'));
			}
		}

		/**
		 * Add the meta box to the page.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function add_meta_box()
		{
			$title = esc_html($this->title);
			$title .= ($this->help_tab_id == '') ? '' : Noakes_Menu_Manager_Output::help_button($this->help_tab_id);

			add_meta_box($this->id, $title, $this->callback, $this->_base->_cache->screen, $this->context, $this->priority, $this->callback_args);
			
			add_filter('postbox_classes_' . esc_attr($this->_base->_cache->screen->id) . '_' . esc_attr($this->id), array($this, 'postbox_classes'));
		}

		/**
		 * The default callback that is fired for the meta box when one isn't provided.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function callback()
		{
			$has_option_name = ($this->option_name != '');

			$this->fields = Noakes_Menu_Manager_Utilities::check_array($this->fields);

			foreach ($this->fields as $field)
			{
				if (is_a($field, 'Noakes_Menu_Manager_Field'))
				{
					if ($has_option_name)
					{
						$field->option_name = $this->option_name;
					}

					$field->output(true);
				}
			}

			wp_nonce_field($this->id, $this->id . '_nonce', false);
		}

		/**
		 * Add additional classes to meta boxes.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array $classes Current meta box classes.
		 * @return array          Modified meta box classes.
		 */
		public function postbox_classes($classes)
		{
			$this->classes = Noakes_Menu_Manager_Utilities::check_array($this->classes);

			return array_merge($classes, $this->classes);
		}

		/**
		 * Add a field to the meta box.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array $options Options for the field to add.
		 * @return void
		 */
		public function add_field($options)
		{
			$this->_push('fields', new Noakes_Menu_Manager_Field($options));
		}
		
		/**
		 * Finalize the settings meta boxes.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @return void
		 */
		public static function finalize_meta_boxes()
		{
			self::side_meta_boxes();
			
			Noakes_Menu_Manager_Third_Party::remove_meta_boxes();

			do_action('add_meta_boxes', Noakes_Menu_Manager()->_cache->screen->id, null);
		}

		/**
		 * Generate the side meta boxes.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @return void
		 */
		public static function side_meta_boxes()
		{
			$version = '-' . str_replace('.', '-', NMM_VERSION);
			
			$support_box = new Noakes_Menu_Manager_Meta_Box(array
			(
				'context' => 'side',
				'id' => 'support' . $version,
				'title' => __('Support', 'noakes-menu-manager')
			));

			$support_box->add_field(array
			(
				'type' => 'html',

				'content' => __('Plugin developed by', 'noakes-menu-manager') . '<br />' .
					'<a href="https://robertnoakes.com/" target="_blank"><img src="' . Noakes_Menu_Manager()->_cache->asset_path('images', 'robert-noakes.png') . '" height="67" width="514" alt="Robert Noakes" class="robert-noakes" /></a>'
			));
			
			$support_box->add_field(array
			(
				'type' => 'html',
				
				'content' => __('Running into issues with the plugin?', 'noakes-menu-manager') . '<br />' .
					'<a href="' . NMM_URL_SUPPORT . '" target="_blank">' . __('Please submit a ticket.', 'noakes-menu-manager') . '</a>'
			));
			
			$support_box->add_field(array
			(
				'type' => 'html',
				
				'content' => __('Have some feedback you\'d like to share?', 'noakes-menu-manager') . '<br />' .
					'<a href="' . NMM_URL_REVIEW . '" target="_blank">' . __('Please submit a review.', 'noakes-menu-manager') . '</a>'
			));
			
			$support_box->add_field(array
			(
				'type' => 'html',
				
				'content' => __('Would you like to support development?', 'noakes-menu-manager') . '<br />' .
					'<a href="' . NMM_URL_DONATE . '" target="_blank">' . __('Make a small donation.', 'noakes-menu-manager') . '</a>'
			));
			
			$support_box->add_field(array
			(
				'type' => 'html',
				
				'content' => __('Want to see the plugin in your language?', 'noakes-menu-manager') . '<br />' .
					'<a href="' . NMM_URL_TRANSLATE . '" target="_blank">' . __('Assist with plugin translation.', 'noakes-menu-manager') . '</a>'
			));
			
			$advertising_box = new Noakes_Menu_Manager_Meta_Box(array
			(
				'context' => 'side',
				'id' => 'advertising' . $version,
				'title' => __('Better Hosting with WPEngine', 'noakes-menu-manager')
			));
			
			$advertising_box->add_field(array
			(
				'content' => '<a target="_blank" href="https://shareasale.com/r.cfm?b=1144535&amp;u=1815763&amp;m=41388&amp;urllink=&amp;afftrack="><img src="https://static.shareasale.com/image/41388/YourWordPressDXP300x600.png" border="0" /></a>',
				'type' => 'html'
			));
		}
	}
}
