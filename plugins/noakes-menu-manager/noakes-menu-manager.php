<?php
/**
 * Plugin Name: Nav Menu Manager
 * Plugin URI:  https://wordpress.org/plugins/noakes-menu-manager/
 * Description: Simplifies nav menu maintenance and functionality providing more control over nav menus with less coding.
 * Version:     2.0.3
 * Author:      Robert Noakes
 * Author URI:  https://robertnoakes.com/
 * Text Domain: noakes-menu-manager
 * Domain Path: /languages/
 * Copyright:   (c) 2016-2019 Robert Noakes (mr@robertnoakes.com)
 * License:     GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */
 
/**
 * Main plugin file.
 * 
 * @since 2.0.2 Changed 'dirname' call to 'plugin_dir_path'.
 * @since 2.0.0
 * 
 * @package Nav Menu Manager
 */

if (!defined('ABSPATH')) exit;

$includes_path = plugin_dir_path(__FILE__) . '/includes/';

require_once($includes_path . 'definitions.php');

$core_path = $includes_path . 'core/';

require_once($core_path . 'class-wrapper.php');
require_once($core_path . 'class-base.php');
require_once($core_path . 'class-cache.php');
require_once($core_path . 'class-settings.php');
require_once($core_path . 'class-nav-menus.php');
require_once($core_path . 'class-ajax.php');
require_once($core_path . 'class-generator.php');
require_once($core_path . 'class-widgets.php');

$standalone_path = $includes_path . 'standalone/';

require_once($standalone_path . 'class-field.php');
require_once($standalone_path . 'class-meta-box.php');
require_once($standalone_path . 'class-widget-menu.php');

$static_path = $includes_path . 'static/';

require_once($static_path . 'class-help.php');
require_once($static_path . 'class-output.php');
require_once($static_path . 'class-setup.php');
require_once($static_path . 'class-third-party.php');
require_once($static_path . 'class-utilities.php');

register_activation_hook(__FILE__, array('Noakes_Menu_Manager_Setup', 'activate'));

/**
 * Returns the main instance of Noakes_Menu_Manager.
 * 
 * @since 2.0.0
 * 
 * @return Noakes_Menu_Manager Main Noakes_Menu_Manager instance.
 */
function Noakes_Menu_Manager()
{
	return Noakes_Menu_Manager::_get_instance(__FILE__);
}

Noakes_Menu_Manager();
