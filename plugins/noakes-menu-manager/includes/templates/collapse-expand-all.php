<?php
	/**
	 * Collapse/Expand All button template.
	 * 
	 * @since 2.0.0
	 * 
	 * @package Nav Menu Manager
	 */

	if (!defined('ABSPATH')) exit;
?>

<script type="text/html" id="tmpl-nmm-collapse-expand-all">

	<div id="nmm-collapse-expand-all" class="nmm-collapse-expand-all">
	
		<button class="nmm-collapse-all button" type="button"><?php
		
			printf
			(
				__('%s Collapse All', 'noakes-menu-manager'),
				'<span title="' . esc_attr__('Collapse', 'noakes-menu-manager') . '" class="nmm-collapse">–</span>'
			);
			
		?></button>
		
		<button class="nmm-expand-all button" type="button"><?php
		
			printf
			(
				__('%s Expand All', 'noakes-menu-manager'),
				'<span title="' . esc_attr__('Expand', 'noakes-menu-manager') . '" class="nmm-expand">+</span>'
			);
			
		?></button>
		
		<?php echo Noakes_Menu_Manager_Output::help_button('nmm-collapse-expand'); ?>
		
	</div>
	
</script>
