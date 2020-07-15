<?php
/**
 * Functionality for plugin uninstallation.
 * 
 * @since 2.0.0
 * 
 * @package Nav Menu Manager
 */

if (!defined('WP_UNINSTALL_PLUGIN') && !defined('NP_FAUX_UNINSTALL_PLUGIN')) exit;

require_once(dirname(__FILE__) . '/includes/definitions.php');

$settings = get_option(NMM_OPTION_SETTINGS);

if (!empty($settings[NMM_SETTING_DELETE_SETTINGS]))
{
	delete_option(NMM_OPTION_VERSION);
	delete_option(NMM_OPTION_SETTINGS);
	delete_option(NMM_OPTION_GENERATOR);
}

if (!empty($settings[NMM_SETTING_DELETE_POST_META]))
{
	delete_metadata('post', '', '_menu_item_noakes_id', '', true);
	delete_metadata('post', '', '_menu_item_noakes_query_string', '', true);
	delete_metadata('post', '', '_menu_item_noakes_anchor', '', true);
}

if (!empty($settings[NMM_SETTING_DELETE_USER_META]))
{
	delete_metadata('user', '', 'nmm_collapsed', '', true);
}
