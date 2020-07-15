<?php
/**
 * Plugin setup functionality.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Setup
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Setup'))
{
	/**
	 * Class used to implement setup functions.
	 *
	 * @since 2.0.0
	 */
	final class Noakes_Menu_Manager_Setup
	{
		/**
		 * Plugin activation hook.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @return void
		 */
		public static function activate()
		{
			//Nothing to see here.
		}
		
		/**
		 * Check and update the plugin version.
		 * 
		 * @since 2.0.0
		 * 
		 * @access public static
		 * @return void
		 */
		public static function check_version()
		{
			$current_version = get_option(NMM_OPTION_VERSION);
			
			if (empty($current_version))
			{
				add_option(NMM_OPTION_VERSION, NMM_VERSION);
			}
			else if ($current_version != NMM_VERSION)
			{
				update_option(NMM_OPTION_VERSION, NMM_VERSION);
				
				if (version_compare($current_version, '2.0.0', '<'))
				{
					self::pre_two_zero_zero($current_version);
				}
			}
		}
		
		/**
		 * Clean up plugin settings for Nav Menu Manager versions earlier than 2.0.0.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @param  string $current_version Current plugin version.
		 * @return void
		 */
		private static function pre_two_zero_zero($current_version)
		{
			if (version_compare($current_version, '1.7.0', '<'))
			{
				self::pre_one_seven_zero($current_version);
			}
			
			$settings_option = Noakes_Menu_Manager_Utilities::check_array(get_option(NMM_OPTION_SETTINGS));
			
			unset($settings_option['enable_collapse_expand']);
			unset($settings_option['preserve_options']);
			unset($settings_option['preserve_post_meta']);
			unset($settings_option['preserve_user_meta']);
			
			update_option(NMM_OPTION_SETTINGS, $settings_option);
			
			Noakes_Menu_Manager()->_settings->load_option($settings_option);
			
			$generator_option = Noakes_Menu_Manager_Utilities::check_array(get_option(NMM_OPTION_GENERATOR));
			
			if (isset($generator_option['item_spacing']) && $generator_option['item_spacing'] == 'preserve')
			{
				unset($generator_option['item_spacing']);
			}
			
			if (!isset($generator_option['echoed']))
			{
				$generator_option['echoed'] = '';
			}
			
			update_option(NMM_OPTION_GENERATOR, $generator_option);
			
			Noakes_Menu_Manager()->_generator->load_option($generator_option);
		}
		
		/**
		 * Clean up plugin settings for Nav Menu Manager versions earlier than 1.7.0.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private
		 * @param  string $current_version Current plugin version.
		 * @return void
		 */
		private static function pre_one_seven_zero($current_version)
		{
			if (version_compare($current_version, '1.4.2', '<'))
			{
				self::pre_one_four_two($current_version);
			}

			$settings_option = Noakes_Menu_Manager_Utilities::check_array(get_option(NMM_OPTION_SETTINGS));
			
			if (isset($settings_option['enable_collapse_expand']) && !empty($settings_option['enable_collapse_expand']))
			{
				$settings_option['store_collapsed_states'] = '1';
			}

			update_option(NMM_OPTION_SETTINGS, $settings_option);
			
			Noakes_Menu_Manager()->_settings->load_option($settings_option);
		}
		
		/**
		 * Clean up generator settings for Nav Menu Manager versions earlier than 1.4.2.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private static
		 * @param  string $current_version Current plugin version.
		 * @return void
		 */
		private static function pre_one_four_two($current_version)
		{
			if (version_compare($current_version, '1.4.0', '<'))
			{
				self::pre_one_four_zero($current_version);
			}
			
			$generator_option = Noakes_Menu_Manager_Utilities::check_array(get_option(NMM_OPTION_GENERATOR));
			$dropdown_fields = array('fallback_cb', 'walker', 'items_wrap');
			
			foreach ($generator_option as $name => $value)
			{
				if (in_array($name, $dropdown_fields) && $value == 'included')
				{
					$generator_option[$name] = 'true';
				}
			}

			update_option(NMM_OPTION_GENERATOR, $generator_option);
			
			Noakes_Menu_Manager()->_generator->load_option($generator_option);
		}
		
		/**
		 * Clean up plugin settings for Nav Menu Manager versions earlier than 1.4.0.
		 * 
		 * @since 2.0.0
		 * 
		 * @access private static
		 * @param  string $current_version Current plugin version.
		 * @return void
		 */
		private static function pre_one_four_zero($current_version)
		{
			$settings_option = Noakes_Menu_Manager_Utilities::check_array(get_option(NMM_OPTION_SETTINGS));
			$settings_option = Noakes_Menu_Manager()->_settings->sanitize($settings_option);

			update_option(NMM_OPTION_SETTINGS, $settings_option);
			
			Noakes_Menu_Manager()->_settings->load_option($settings_option);
		}
	}
}
