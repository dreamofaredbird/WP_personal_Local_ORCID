<?php
/**
 * Plugin utility functions.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Utilities
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Utilities'))
{
	/**
	 * Class used to implement utilities functions.
	 *
	 * @since 2.0.0
	 */
	final class Noakes_Menu_Manager_Utilities
	{
		/**
		 * Check a value to see if it is an array or convert to an array if necessary.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  mixed $value        Value to turn into an array.
		 * @param  mixed $return_false True if a false value should be returned as-is.
		 * @return array               Checked value as an array.
		 */
		public static function check_array($value, $return_false = false)
		{
			if ($value === false && $return_false)
			{
				return $value;
			}

			if (empty($value))
			{
				$value = array();
			}

			if (!is_array($value))
			{
				$value = array($value);
			}

			return $value;
		}
		
		/**
		 * Remove comments, line breaks and tabs from a code.
		 * 
		 * @since 2.0.0
		 * 
		 * @param  string $code Raw code to clean up.
		 * @return string       Code without comments, line breaks and tabs.
		 */
		public static function clean_code($code)
		{
			$code = preg_replace('/<!--(.*)-->/Uis', '', $code);
			$code = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/', '', $code);
			
			return str_replace(array(PHP_EOL, "\r", "\n", "\t"), '', $code);
		}
		
		/**
		 * Check to see if a full string ends with a specified ending string.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string  $needle   Ending string to check for.
		 * @param  string  $haystack Full string to check for the ending string.
		 * @return boolean True if the full string ends with the specified ending string.
		 */
		public static function ends_with($needle, $haystack)
		{
			$length = strlen($needle);
			
			return ($length == 0 || substr($haystack, -$length) === $needle);
		}
		
		/**
		 * Check to see if an AJAX action is being executed.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string  $action Action to check for.
		 * @return boolean         True if the action is being executed.
		 */
		public static function is_ajax_action($action)
		{
			if (!NMM_AJAX) return false;

			$current_action = (isset($_GET['action'])) ? $_GET['action'] : '';
			$current_action = (empty($current_action) && isset($_POST['action'])) ? $_POST['action'] : $current_action;

			return ($action == $current_action);
		}

		/**
		 * Check to see if a plugin is active.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string  $path Path for the plugin to check.
		 * @return boolean       True if the plugin is active.
		 */
		public static function is_plugin_active($path)
		{
			if (!function_exists('is_plugin_active'))
			{
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			return is_plugin_active($path);
		}
		
		/**
		 * Removes leading and trailing redundancies from a custom field value.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string $value Raw value to check for redundancies.
		 * @return string        Modified value without redundancies.
		 */
		public static function remove_redundancies($value)
		{
			return trim($value, "?&# \t\n\r\0\x0B");
		}

		/**
		 * Sanitize CSS classes.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string $raw_classes Raw classes to sanitize.
		 * @return string              Sanitized classes.
		 */
		public static function sanitize_classes($raw_classes)
		{
			$classes = explode(' ', preg_replace('/\s\s+/', ' ', trim($raw_classes)));
			$class_count = count($classes);

			for ($i = 0; $i < $class_count; $i++)
			{
				$classes[$i] = sanitize_html_class($classes[$i]);
			}

			return implode(' ', array_filter($classes));
		}
		
		/**
		 * Check to see if a full string starts with a specified starting string.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @param  string  $needle   Starting string to check for.
		 * @param  string  $haystack Full string to check for the starting string.
		 * @return boolean True if the full string starts with the specified starting string.
		 */
		public static function starts_with($needle, $haystack)
		{
			return (empty($needle) || strpos($haystack, $needle) === 0);
		}
	}
}
