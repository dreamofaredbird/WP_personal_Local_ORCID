<?php
/**
 * Abstract wrapper for core class functionality.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Wrapper'))
{
	/**
	 * Abstract class used to implement core class functionality.
	 *
	 * @since 2.0.0
	 */
	abstract class Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Base plugin object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @var    Noakes_Menu_Manager
		 */
		public $_base = null;

		/**
		 * The stored properties.
		 * 
		 * @since 2.0.0
		 * 
		 * @access protected
		 * @var    array
		 */
		protected $_properties = array();

		/**
		 * Constructor function.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base Optional base plugin object. If empty, the global object is used.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base = null)
		{
			$this->_base = (empty($base)) ? Noakes_Menu_Manager() : $base;
		}

		/**
		 * Get a property based on the provided name.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  string $name Name of the property to return.
		 * @return string       Property if it is found, otherwise an empty string.
		 */
		public function __get($name)
		{
			if (!isset($this->_properties[$name]) || is_null($this->_properties[$name]))
			{
				return $this->_properties[$name] = $this->_default($name);
			}

			return $this->_properties[$name];
		}

		/**
		 * Check to see if a property exists with the provided name.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  string  $name Name of the property to check.
		 * @return boolean       True if the property is set, otherwise false.
		 */
		public function __isset($name)
		{
			if (!isset($this->_properties[$name]) || is_null($this->_properties[$name]))
			{
				$default = $this->_default($name);

				if (!is_null($default))
				{
					$this->_properties[$name] = $default;
				}
			}

			return isset($this->_properties[$name]);
		}

		/**
		 * Set the property with the provided name to the provided value.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  string $name  Name of the property to set.
		 * @param  string $value Value of the property to set.
		 * @return void
		 */
		public function __set($name, $value)
		{
			$this->_properties[$name] = $value;
		}

		/**
		 * Unset the property with the provided name.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  string $name Name of the property to unset.
		 * @return void
		 */
		public function __unset($name)
		{
			unset($this->_properties[$name]);
		}

		/**
		 * Set the initial properties for the object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access protected
		 * @param  array $defaults Default properties for the object.
		 * @param  array $options  Optional specific options for the object.
		 * @return void
		 */
		protected function _set_properties($defaults, $options = array())
		{
			$defaults = Noakes_Menu_Manager_Utilities::check_array($defaults);

			$this->_properties = (empty($options)) ? $defaults : array_merge($defaults, Noakes_Menu_Manager_Utilities::check_array($options));
		}

		/**
		 * Get a default property based on the provided name.
		 * 
		 * @since 2.0.0
		 * 
		 * @access protected
		 * @param  string $name Name of the property to return.
		 * @return string       Empty string.
		 */
		protected function _default($name)
		{
			return null;
		}

		/**
		 * Push a value into a property array.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public
		 * @param  string $name  Name of the property array to push the value into.
		 * @param  string $value Value to push into the property array.
		 * @param  mixed  $index Optional array index for the value to push.
		 * @return void
		 */
		public function _push($name, $value, $index = null)
		{
			$property = $this->$name;

			if (is_array($property))
			{
				if (is_null($index))
				{
					$property[] = $value;
				}
				else
				{
					$property[$index] = $value;
				}
			}

			$this->$name = $property;
		}
	}
}
