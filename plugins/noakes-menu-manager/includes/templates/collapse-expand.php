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

<script type="text/html" id="tmpl-nmm-collapse-expand">

	<a href="javascript:;" class="nmm-collapse-expand"><span title="<?php esc_attr_e('Collapse', 'noakes-menu-manager'); ?>" class="nmm-collapse">–</span><span title="<?php esc_attr_e('Expand', 'noakes-menu-manager'); ?>" class="nmm-expand">+</span></a>
	
</script>
