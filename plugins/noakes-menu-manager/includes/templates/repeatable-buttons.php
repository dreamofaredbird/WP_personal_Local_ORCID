<?php
	/**
	 * Repeatable buttons template.
	 * 
	 * @since 2.0.0
	 * 
	 * @package Nav Menu Manager
	 */

	if (!defined('ABSPATH')) exit;
?>

<script type="text/html" id="tmpl-nmm-repeatable-buttons">

	<a title="<?php esc_attr_e('Move Menu', 'faucet-manager'); ?>" class="nmm-repeatable-move">
	
		<span class="nmm-repeatable-count"></span>
		<span class="nmm-repeatable-button"><?php echo NMM_ICON_MOVE; ?></span>
		
	</a>
	
	<a title="<?php esc_attr_e('Move Menu Up', 'faucet-manager'); ?>" class="nmm-repeatable-button nmm-repeatable-move-up"><?php echo NMM_ICON_ARROW_UP; ?></a>
	<a title="<?php esc_attr_e('Move Menu Down', 'faucet-manager'); ?>" class="nmm-repeatable-button nmm-repeatable-move-down"><?php echo NMM_ICON_ARROW_DOWN; ?></a>
	<a title="<?php esc_attr_e('Insert Menu Above', 'faucet-manager'); ?>" class="nmm-repeatable-button nmm-repeatable-insert"><?php echo NMM_ICON_PLUS; ?></a>
	<a title="<?php esc_attr_e('Remove Menu', 'faucet-manager'); ?>" class="nmm-repeatable-button nmm-repeatable-remove"><?php echo NMM_ICON_NO; ?></a>
	
</script>
