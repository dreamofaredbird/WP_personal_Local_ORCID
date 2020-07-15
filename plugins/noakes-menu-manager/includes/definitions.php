<?php
/**
 * Global plugin definitions.
 * 
 * @since 2.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Definitions
 */

if (!defined('ABSPATH')) exit;

/**
 * Plugin version.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_VERSION', '2.0.3');

/**
 * Plugin token.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_TOKEN', 'noakes_menu_manager');

/**
 * ID used for widgets and shortcodes.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_ID', 'nmm_menu');

/**
 * Plugin AJAX check.
 * 
 * @since 2.0.0
 * 
 * @var boolean
 */
define('NMM_AJAX', (defined('DOING_AJAX') && DOING_AJAX));

/**
 * Plugin version option name.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_OPTION_VERSION', NMM_TOKEN . '_version');

/**
 * Plugin settings option name.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_OPTION_SETTINGS', NMM_TOKEN . '_settings');

/**
 * Plugin settings option name.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_OPTION_GENERATOR', NMM_TOKEN . '_generator');

/**
 * Setting name for preserving options.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_SETTING_DELETE_SETTINGS', 'delete_settings');

/**
 * Setting name for removing post meta.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_SETTING_DELETE_POST_META', 'delete_post_meta');

/**
 * Setting name for removing user meta.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_SETTING_DELETE_USER_META', 'delete_user_meta');

/**
 * Group field type.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_FIELD_GROUP', 'group');

/**
 * Repeatable field type.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_FIELD_REPEATABLE', 'repeatable');

/**
 * Plugin support URL.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_URL_SUPPORT', 'https://wordpress.org/support/plugin/noakes-menu-manager/');

/**
 * Plugin review URL.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_URL_REVIEW', NMM_URL_SUPPORT . 'reviews/?rate=5#new-post');

/**
 * Plugin translate URL.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_URL_TRANSLATE', 'https://translate.wordpress.org/projects/wp-plugins/noakes-menu-manager');

/**
 * Plugin donate URL.
 *
 * @since 2.0.0
 *
 * @var string
 */
define('NMM_URL_DONATE', 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XNE7BREHR7BZQ');

/**
 * WP_Nav_Menu link.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_LINK_WP_NAV_MENU', '<a href="https://developer.wordpress.org/reference/functions/wp_nav_menu/" target="_blank">wp_nav_menu</a>');

/**
 * Arrow down icon.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_ICON_ARROW_DOWN', '<span class="dashicons dashicons-arrow-down-alt"></span>');

/**
 * Arrow down icon.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_ICON_ARROW_UP', '<span class="dashicons dashicons-arrow-up-alt"></span>');

/**
 * Move icon.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_ICON_MOVE', '<span class="dashicons dashicons-move"></span>');

/**
 * No icon.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_ICON_NO', '<span class="dashicons dashicons-no"></span>');

/**
 * Plus icon.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
define('NMM_ICON_PLUS', '<span class="dashicons dashicons-plus"></span>');
