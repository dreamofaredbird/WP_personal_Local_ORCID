<?php
/*
Plugin Name: Easy FAQs Pro
Plugin Script: easy-faqs-pro.php
Plugin URI: http://goldplugins.com/our-plugins/easy-faqs-pro/
Description: Pro Addon for Easy FAQs. Requires the Easy FAQs plugin.
Version: 3.1.1
Author: Gold Plugins
Author URI: http://goldplugins.com/
*/

add_action( 'easy_faqs_bootstrap', 'easy_faqs_pro_init' );

function easy_faqs_pro_init()
{
	require_once('include/Easy_FAQs_Pro_Plugin.php');
	//require_once('include/lib/BikeShed/bikeshed.php');
		
	$easy_faqs_pro = new Easy_FAQs_Pro_Plugin( __FILE__ );

	// create an instance of BikeShed that we can use later
	global $Easy_FAQs_BikeShed;
	if ( is_admin() && empty($Easy_FAQs_BikeShed) ) {
		//$Easy_FAQs_BikeShed = new Easy_FAQs_GoldPlugins_BikeShed();
	}
}

function easy_faqs_pro_activation_hook()
{
	set_transient('easy_faqs_pro_just_activated', 1);
}
add_action( 'activate_easy-faqs-pro/easy-faqs-pro.php', 'easy_faqs_pro_activation_hook' );
