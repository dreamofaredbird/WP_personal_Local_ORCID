<?php
	require_once('lib/GP_Plugin_Updater/GP_Plugin_Updater.php');
	require_once('lib/GP_Galahad/GP_Galahad.php');
	require_once('lib/BikeShed/bikeshed.php');	
	require_once('lib/easy_faqs_search_faqs.class.php');
	require_once('lib/str_highlight.php');
	require_once('lib/database_setup.php');
	require_once('widgets/submit_faqs_widget.php');

	/* Gutenburg blocks */
	if ( function_exists('register_block_type') ) {
		require_once('blocks/list-faqs-accordion.php');
		require_once('blocks/faqs-by-category-accordion.php');
		require_once('blocks/search-faqs.php');
		require_once('blocks/submit-faqs.php');
	}

	define('EASY_FAQS_PRO_PLUGIN_ID', 7002);
	define('EASY_FAQS_PRO_STORE_URL', 'https://goldplugins.com');

	class Easy_FAQs_Pro_Factory
	{		
		/*
		 * Constructor.
		 *
		 * @param string $_base_file The path to the base file of the plugin. 
		 *							 In most cases, pass the __FILE__ constant.
		 */
		function __construct($_base_file)
		{
			$this->_base_file = $_base_file;
		}
		
		function get($class_name)
		{
			
			switch ($class_name)
			{
				case 'GP_Plugin_Updater':
					return $this->get_gp_plugin_updater();
				break;
				
				case 'GP_Galahad':
					return $this->get_gp_galahad();
				break;
				
				case 'GP_BikeShed':
					return $this->get_gp_bikeshed();
				break;
				
				default:
					return false;
				break;				
			}
		}
		
		function get_gp_plugin_updater()
		{
			if ( empty($this->GP_Plugin_Updater) ) {
				$api_args = array(
					'version' 	=> $this->get_current_version(),
					'license' 	=> $this->get_license_key(),
					'item_id'   => EASY_FAQS_PRO_PLUGIN_ID,
					'author' 	=> 'Gold Plugins',
					'url'       => home_url(),
					'beta'      => false
				);
				$options = array(
					'plugin_name' => 'Easy FAQs Pro',
					'activate_url' => admin_url('admin.php?page=easy-faqs-license-information'),
					'info_url' => 'https://goldplugins.com/downloads/easy-faqs-pro/?utm_source=easy_faqs_pro&utm_campaign=activate_for_updates&utm_banner=plugin_links',
				);
				$this->GP_Plugin_Updater = new GP_Plugin_Updater(
					EASY_FAQS_PRO_STORE_URL, 
					$this->_base_file, 
					$api_args,
					$options
				);
			}
			return $this->GP_Plugin_Updater;
		}
		
		function get_gp_bikeshed()
		{
			if ( empty($this->GP_BikeShed) ) {
				$this->GP_BikeShed = new Easy_FAQs_GoldPlugins_BikeShed();
			}
			return $this->GP_BikeShed;
		}
		
		function get_gp_galahad()
		{
			if ( empty($this->GP_Galahad) ) {
				$gp_updater = $this->get('GP_Plugin_Updater');
				$options = array(
					'active_license' => $gp_updater->has_active_license(),
					'plugin_name' => 'Easy FAQs Pro',
					'license_key' => $this->get_license_key(),
					'patterns' => array(
						'easy-faqs(.*)',
						'easy-faqs(.*)',
						'easy_faqs(.*)',
						'easy_faqs(.*)',
					)
				);
				$this->GP_Galahad = new GP_Galahad( $options );
			}
			return $this->GP_Galahad;
		}
		
		function get_license_key()
		{
			return get_option( 'easy_faqs_pro_registered_key' );
		}
		
		function get_current_version()
		{
			if ( !function_exists('get_plugin_data') ) {
				include_once(ABSPATH . "wp-admin/includes/plugin.php");
			}
			$plugin_data = get_plugin_data( $this->_base_file );	
			$plugin_version = ( !empty($plugin_data['Version']) && $plugin_data['Version'] !== 'Version' )
							  ? $plugin_data['Version']
							  : '1.0';							
			return $plugin_version;
		}		
	}