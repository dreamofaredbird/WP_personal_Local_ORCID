<?php
/**
 * Meta box field functionality.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Field
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Field'))
{
	/**
	 * Class used to implement the field object.
	 *
	 * @since 2.0.0
	 * 
	 * @uses Noakes_Menu_Manager_Wrapper
	 */
	class Noakes_Menu_Manager_Field extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Constructor function.
		 * 
		 * @since 2.0.2 Removed max_length and rows defaults.
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  array   $options Optional options for the field.
		 * @param  boolean $output  True if the field should output immediately.
		 * @return void
		 */
		public function __construct($options = array(), $output = false)
		{
			parent::__construct();
			
			$defaults = array
			(
				/* @var string Add item button text for repeatable fields. */
				'add_item' => '',
				
				/* @var boolean True if a field layout should be included. Only works with Repeatable fields. */
				'add_layout' => '',
				
				/* @var array CSS classes added to the field wrapper. */
				'classes' => array(),
				
				/* @var array Conditions for a field to be visible. */
				'conditional' => array(),
				
				/* @var string Content added to the field. */
				'content' => '',
				
				/* @var string Short description display with the field. */
				'description' => '',
				
				/* @var array Field associated with this field. Only works with Repeatable and Group fields. */
				'fields' => array(),
				
				/* @var string Long description displayed in the help tab. */
				'help_description' => '',
				
				/* @var boolean True if the labels should be hidden from the field output. */
				'hide_labels' => false,
				
				/* @var array CSS classes added to the field input element. */
				'input_classes' => array(),
				
				/* @var boolean True if the current field should be formatted for a layout. */
				'is_layout' => false,
				
				/* @var boolean True if the field is tall and the description should be displayed below the label. */
				'is_tall' => false,
				
				/* @var boolean True if the current field is a template. */
				'is_template' => false,
				
				/* @var string Output label displayed with the field. */
				'label' => '',
				
				/* @var string Base name for the field. */
				'name' => '',
				
				/* @var string Meta box option name. */
				'option_name' => '',
				
				/* @var array Field options. Only works with Select fields. */
				'options' => array(),
				
				/* @var string Placeholder text. Only works with Texst fields. */
				'placeholder' => '',
				
				/* @var string Type of field to output. */
				'type' => 'text',
				
				/* @var string Current value for the field. */
				'value' => ''
			);

			$this->_set_properties($defaults, $options);
			
			if (!empty($this->help_description))
			{
				Noakes_Menu_Manager_Help::add_block($this->label, $this->help_description);
			}
			
			if ($output)
			{
				$this->output(true);
			}
		}

		/**
		 * Get a default option based on the provided name.
		 * 
		 * @since 2.0.0
		 * 
		 * @access protected
		 * @param  string $name Name of the option to return.
		 * @return string       Default option if it exists, otherwise an empty string.
		 */
		protected function _default($name)
		{
			switch ($name)
			{
				/* @var string Generated DOM ID. */
				case 'id':
				
					return esc_attr($this->generate_id());
					
				/* @var string Generated field identifier attributes. */
				case 'identifiers':

					if (empty($this->id)) return '';

					return (strpos($this->id, '[__i__]') === false) ? ' id="' . $this->id . '" name="' . $this->id . '"' : ' data-nmm-identifier="' . $this->id . '"';
					
				/* @var string Generated label attributes. */
				case 'label_attr':

					if (empty($this->id)) return '';

					$label_attr = (strpos($this->id, '[__i__]') === false) ? ' for="' . $this->id . '"' : ' data-nmm-identifier="' . $this->id . '"';
					$label_attr .= ($this->is_template) ? ' class="nmm-input-template"' : '';
					
					return $label_attr;
			}

			return parent::_default($name);
		}
		
		/**
		 * Generate the output for the field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  boolean     $echo True if the field should be echoed.
		 * @return string/void       Generated field if $echo is false.
		 */
		public function output($echo = false)
		{
			$this->_push('classes', 'nmm-field');
			$this->_push('classes', 'nmm-field-' . str_replace('_', '-', $this->type));

			$output = '';
			
			if ($this->type == NMM_FIELD_GROUP)
			{
				$output = $this->group_output();
			}
			else if ($this->type == NMM_FIELD_REPEATABLE)
			{
				$output = $this->repeatable_output();
			}
			else
			{
				$output = $this->simple_output();
			}
			
			if (!empty($output) && in_array('nmm-hidden', $this->classes))
			{
				$output .= '<div class="nmm-hidden nmm-field-spacer"></div>';
			}
			
			if (!$echo)
			{
				return $output;
			}

			echo $output;
		}
		
		/**
		 * Group field output.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated group field.
		 */
		private function group_output()
		{
			if (!is_array($this->fields) || empty($this->fields)) return '';
			
			$output = '<div class="nmm-group">';
			
			foreach ($this->fields as $options)
			{
				if ($this->is_layout)
				{
					$options['name'] = '';
					$options['type'] = 'layout';
				}
				else
				{
					$options['option_name'] = $this->option_name;

					if (is_array($this->value) && isset($this->value[$options['name']]))
					{
						$options['value'] = $this->value[$options['name']];
					}

					$options['is_template'] = $this->is_template;
				}
				
				$group_field = new Noakes_Menu_Manager_Field($options);
				$output .= $group_field->output();
			}
			
			$output .= '</div>';
			
			return $this->wrap_field($output);
		}
		
		/**
		 * Repeatable field output.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated repeatable field.
		 */
		private function repeatable_output()
		{
			if (!is_array($this->fields) || empty($this->fields)) return '';
			
			$output = '';
			$first_field = true;
			$output_fields = array();
			$layout_class = '';
			
			foreach ($this->fields as $options)
			{
				if ($this->add_layout)
				{
					if ($first_field)
					{
						$output_fields['field-layout'] = '';
						$layout_class = ' nmm-has-layout';
					}
					
					$layout_options = array();
					
					if ($options['type'] == NMM_FIELD_GROUP)
					{
						$layout_options['is_layout'] = true;
					}
					else
					{
						$layout_options['name'] = '';
						$layout_options['type'] = 'layout';
					}
					
					$layout_field = new Noakes_Menu_Manager_Field(array_merge($options, $layout_options));
					$output_fields['field-layout'] .= $layout_field->output();
				}
				
				$options['option_name'] = $this->option_name . '[' . $this->name . '][__i__]';
				
				if (is_array($this->value))
				{
					foreach ($this->value as $i => $value)
					{
						if ($first_field)
						{
							$output_fields['field-' . $i] = '';
						}
						
						$field = new Noakes_Menu_Manager_Field(array_merge($options, array('value' => $value)));
						$output_fields['field-' . $i] .= $field->output();
					}
				}
				
				if ($first_field)
				{
					$output_fields['field-template'] = '';
					$first_field = false;
				}
				
				$options['is_template'] = true;
				$template_field = new Noakes_Menu_Manager_Field($options);
				$output_fields['field-template'] .= $template_field->output();
			}
			
			foreach ($output_fields as $key => $fields)
			{
				$class = ($key == 'field-layout') ? 'nmm-repeatable-layout' : 'nmm-repeatable-item';
				$class .= ($key == 'field-template') ? ' nmm-repeatable-template' : '';
				$output .= '<div class="' . $class . '">' . $fields . '</div>';
			}
			
			if (!empty($output))
			{
				$button_text = (empty($this->add_item)) ? __('Add Item', 'noakes-menu-manager') : $this->add_item;
				
				$label = (empty($this->label) && empty($this->description)) ? '' : '<div class="nmm-field-label">' .
					$this->generate_label() .
					$this->generate_description() .
					'</div>';
				
				$output = $label .
					'<div class="nmm-field-input">' .
					'<div class="nmm-repeatable' . $layout_class . '">' .
					$output .
					'<div class="nmm-repeatable-add">' .
					'<button type="button" class="button nmm-button">' . $button_text . '</button>' .
					'</div>' .
					'</div>' .
					'</div>';
			}
			
			return $this->wrap_field($output);
		}
		
		/**
		 * Simple field output.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated simple field.
		 */
		private function simple_output()
		{
			$output = '';
			$field = (method_exists($this, 'field_' . $this->type)) ? call_user_func(array($this, 'field_' . $this->type)) : $this->field_text();
			
			if (!empty($field))
			{
				$field .= $this->generate_condition_fields();
				$label_description = '';
				$description = ($this->hide_labels) ? '' : $this->generate_description();
				
				if ($this->is_tall)
				{
					$label_description = $description;
					$description = '';
				}
				
				$label = ($this->hide_labels || empty($this->label)) ? '' : '<div class="nmm-field-label">' .
					$this->generate_label() .
					$label_description .
					'</div>';

				$output = $this->wrap_field($label .
					'<div class="nmm-field-input">' .
					$field .
					$description .
					'</div>');
			}
			
			return $output;
		}
		
		/**
		 * Generate a checkbox field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated checkbox field.
		 */
		private function field_checkbox()
		{
			return (empty($this->id)) ? '' : '<input' . $this->identifiers . ' type="checkbox" value="1" ' . $this->get_input_classes() . ' ' . checked('1', $this->value, false) . ' />';
		}
		
		/**
		 * Generate code output field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated fcode output.
		 */
		private function field_code()
		{
			if (empty($this->value)) return '';
			
			$this->is_tall = true;
			
			$field_open = '<div class="nmm-code-wrapper">';
			
			$field_close = '<span class="nmm-copied">' . __('Copied', 'noakes-menu-manager') . '</span>' .
				'</div>';
			
			if (is_array($this->value))
			{
				$value = $this->value;
				$wp_core = '';
				$one_line = '';
				$author_preference = '';
				$tabs = '';

				if (isset($value['comment']))
				{
					$comment = $value['comment'] . PHP_EOL;
					$wp_core = $comment;
					$one_line = $comment;
					$author_preference = $comment;

					unset($value['comment']);
				}

				foreach ($value as $line)
				{
					if ($line == PHP_EOL)
					{
						$author_preference .= $line;
					}
					else
					{
						$add_tab = (Noakes_Menu_Manager_Utilities::ends_with('{', $line) || Noakes_Menu_Manager_Utilities::ends_with('(', $line));
						$remove_tab = (!$add_tab && (Noakes_Menu_Manager_Utilities::starts_with(')', $line) || Noakes_Menu_Manager_Utilities::starts_with('}', $line)));

						if ($remove_tab)
						{
							$tabs = substr($tabs, 1);
						}

						$wp_core .= $tabs . $line . PHP_EOL;
						$line = str_replace(array('( ', '! ', ' )', ' {'), array('(', '!', ')', '{'), $line);
						$line .= (Noakes_Menu_Manager_Utilities::ends_with(',', $line)) ? ' ' : '';
						$one_line .= $line;
						$new_line = PHP_EOL . $tabs;
						$line = str_replace(array('{', 'array('), array($new_line . '{', 'array' . $new_line . '('), $line);
						$author_preference .= $tabs . trim($line) . PHP_EOL;

						if ($add_tab)
						{
							$tabs .= "\t";
						}
					}
				}

				return $field_open .
					'<span>' . __('Style:', 'noakes-menu-manager') . '</span>' .
					'<button type="button" class="button button-primary nmm-button">' . __('WP Core', 'noakes-menu-manager') . '</button>' .
					'<button type="button" class="button nmm-button">' . __('One Line', 'noakes-menu-manager') . '</button>' .
					'<button type="button" class="button nmm-button">' . __('Author Preference', 'noakes-menu-manager') . '</button>' .
					'<pre>' . $wp_core . '</pre>' .
					'<pre>' . $one_line . '</pre>' .
					'<pre>' . $author_preference . '</pre>' .
					$field_close;
			}
			else
			{
				return $field_open .
					'<pre>' . $this->value . '</pre>' .
					$field_close;
			}
		}

		/**
		 * Generate an existing menus field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated existing menus field.
		 */
		private function field_existing_menus()
		{
			if (count($this->_base->_cache->registered_menus) > 0)
			{
				$this->is_tall = true;
				
				$assigned = get_nav_menu_locations();
				$select_label = __('Select %s', 'noakes-menu-manager');
				$select_all = ' checked="checked"';
				$rows = '';

				foreach ($this->_base->_cache->registered_menus as $location => $description)
				{
					$location_attr = esc_attr($location);
					$checked = (isset($this->value[$location_attr])) ? ' checked="checked"' : '';
					$select_all = ($checked) ? $select_all : '';
					$menu = (isset($assigned[$location])) ? wp_get_nav_menu_object($assigned[$location]) : '';
					$assigned_to = (empty($menu)) ? __('None', 'noakes-menu-manager') : '<a href="' . esc_url(admin_url('nav-menus.php?action=edit&menu=' . $menu->term_id)) . '" target="_blank">' . $menu->name . '</a>';

					$rows .= '<tr>' .
						'<th class="check-column" scope="row">' .
						'<label class="screen-reader-text" for="' . $this->id . '[' . $location_attr . ']">' .
						sprintf
						(
							$select_label,
							$location
						) .
						'</label>' .
						'<input' . str_replace('[' . $this->name . ']', '[' . $this->name . '][' . $location_attr . ']', $this->identifiers) . ' type="checkbox" value="1"' . $checked . ' />' .
						'</th>' .
						'<td class="nmm-location">' . $location . '</td>' .
						'<td>' . $description . '</td>' .
						'<td>' . $assigned_to . '</td>' .
						'</tr>';
				}

				$header_row = '<tr>' .
					'<td class="check-column">' .
					'<label class="screen-reader-text" for="cb-select-all-1">' .
					sprintf
					(
						$select_label,
						__('All', 'noakes-menu-manager')
					) .
					'</label>' .
					'<input id="cb-select-all-1" type="checkbox"' . $select_all . ' />' .
					'</td>' .
					'<th>' . __('Location', 'noakes-menu-manager') . '</th>' .
					'<th>' . __('Description', 'noakes-menu-manager') . '</th>' .
					'<th>' . __('Assigned To', 'noakes-menu-manager') . '</th>' .
					'</tr>';

				return '<table cellspacing="0" class="nmm-existing-menus nmm-table widefat striped' . $this->get_input_classes(false) . '">' .
					'<thead>' .
					$header_row .
					'</thead>' .
					'<tbody>' .
					$rows .
					'</tbody>' .
					'<tfoot>' .
					str_replace('cb-select-all-1', 'cb-select-all-2', $header_row) .
					'</tfoot>' .
					'</table>';
			}

			return '';
		}

		/**
		 * Generate an HTML field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated HMTL field.
		 */
		private function field_html()
		{
			return '<div class="nmm-html' . $this->get_input_classes(false) . '">' .
				wpautop(do_shortcode($this->content)) .
				'</div>';
		}
		
		/**
		 * Generate an layout field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated layout field.
		 */
		private function field_layout()
		{
			return $this->generate_label() .
				$this->generate_description();
		}

		/**
		 * Generate a radio buttons field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated radio buttons field.
		 */
		private function field_radio()
		{
			if (empty($this->options)) return '';
			
			$output = '';
			
			foreach ($this->options as $value => $label)
			{
				$output .= '<label><input' . $this->identifiers . ' type="radio" value="' . esc_attr($value) . '" ' . $this->get_input_classes() . ' ' . checked($value, $this->value, false) . ' /> <span>' . $label . '</span></label>';
			}
			
			return $output;
		}

		/**
		 * Generate a select field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated select field.
		 */
		private function field_select()
		{
			if (empty($this->id) || empty($this->options)) return '';
			
			$field = '<select' . $this->identifiers . $this->get_input_classes() . '>';
			
			foreach ($this->options as $value => $label)
			{
				$field .= '<option value="' . esc_attr($value) . '" ' . selected($this->value, $value, false) . '>' . $label . '</option>';
			}
			
			$field .= '</select>';
			
			return $field;
		}

		/**
		 * Generate a submit button.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated submit button.
		 */
		private function field_submit()
		{
			$this->content = (empty($this->content)) ? __('Submit', 'noakes-menu-manager') : $this->content;

			return '<button' . $this->identifiers . ' type="submit" disabled="disabled" class="button button-large button-primary nmm-button' . $this->get_input_classes(false) . '"><span>' . $this->content . '</span></button>';
		}

		/**
		 * Generate a text field.
		 * 
		 * @since 2.0.2 Removed max length.
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated text field.
		 */
		private function field_text()
		{
			if (empty($this->id)) return '';
			
			$this->type = 'text';
			
			$placeholder = (empty($this->placeholder)) ? '' : ' placeholder="' . esc_attr($this->placeholder) . '"';

			return '<input' . $this->identifiers . ' type="text"' . $placeholder . ' value="' . esc_attr($this->value) . '"' . $this->get_input_classes() . ' />';
		}

		/**
		 * Generate contition fields.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Generated condition fields.
		 */
		private function generate_condition_fields()
		{
			$output = '';
			
			if (is_array($this->conditional) && !empty($this->conditional))
			{
				foreach ($this->conditional as $condition)
				{
					if (is_array($condition) && isset($condition['field']) && isset($condition['value']))
					{
						if (!isset($condition['compare']))
						{
							$condition['compare'] = '=';
						}
						
						$output .= '<div class="nmm-hidden nmm-condition" ' .
							'data-nmm-conditional="' . $this->id . '" ' .
							'data-nmm-field="' . esc_attr($this->generate_id($condition['field'])) . '" ' .
							'data-nmm-value="' . esc_attr($condition['value']) . '" ' .
							'data-nmm-compare="' . esc_attr($condition['compare']) . '">' .
							'</div>';
					}
				}
			}
			
			return $output;
		}
		
		/**
		 * Generate the field description.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Wrapped field description.
		 */
		private function generate_description()
		{
			if (empty($this->description)) return '';
			
			return '<div class="nmm-description">' .
				'<label' . $this->label_attr . '>' . $this->description . '</label>' .
				'</div>';
		}

		/**
		 * Generate a field ID.
		 *  
		 * @since 2.0.0
		 * 
		 * @access private
		 * @param  array  $name The base name for the field. If excluded the default field name will be used.
		 * @return string       Generated field ID.
		 */
		private function generate_id($name = '')
		{
			$name = (empty($name)) ? $this->name : $name;
			
			return (empty($name) || empty($this->option_name)) ? $name : $this->option_name . '[' . $name . ']';
		}
		
		/**
		 * Generate the field label.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @return string Wrapped field label.
		 */
		private function generate_label()
		{
			if (empty($this->label)) return '';
			
			return '<label' . $this->label_attr . '><strong>' . $this->label . '</strong></label>';
		}
		
		/**
		 * Get the input class(es).
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @param  boolean $add_attr True if the class attribute should be added.
		 * @return string            Generated field class(es).
		 */
		private function get_input_classes($add_attr = true)
		{
			if ($this->is_template)
			{
				$this->_push('input_classes', 'nmm-input-template');
			}
			
			if (!empty($this->input_classes))
			{
				$classes = Noakes_Menu_Manager_Utilities::check_array($this->input_classes);
				$classes = esc_attr(implode(' ', $classes));

				return ($add_attr) ? ' class="' . $classes . '"' : ' ' . $classes;
			}

			return '';
		}
		
		/**
		 * Add a general wrap around the field.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @param  string $field Field HTML to wrap.
		 * @return string        Wrapped field.
		 */
		private function wrap_field($field)
		{
			if (empty($field)) return '';
			
			return '<div class="' . esc_attr(implode(' ', $this->classes)) . '">' .
				$field .
				'</div>';
		}
	}
}
