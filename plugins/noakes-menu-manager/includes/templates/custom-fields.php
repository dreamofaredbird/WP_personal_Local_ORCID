<?php
	/**
	 * Collapse/Expand button template.
	 * 
	 * @since 2.0.0
	 * 
	 * @package Nav Menu Manager
	 */

	if (!defined('ABSPATH')) exit;
?>

<script type="text/html" id="tmpl-nmm-custom-fields">

	<?php
		if (Noakes_Menu_Manager()->_settings->enable_id)
		{
			Noakes_Menu_Manager_Output::menu_item_field('noakes-id', Noakes_Menu_Manager()->_cache->dom_id, 'nmm-custom-fields');
		}
		
		if (Noakes_Menu_Manager()->_settings->enable_query_string)
		{
			Noakes_Menu_Manager_Output::menu_item_field('noakes-query-string', __('Query String', 'noakes-menu-manager'), 'nmm-custom-fields');
		}

		if (Noakes_Menu_Manager()->_settings->enable_anchor)
		{
			Noakes_Menu_Manager_Output::menu_item_field('noakes-anchor', __('Anchor', 'noakes-menu-manager'), 'nmm-custom-fields');
		} 
	?>
	
</script>
