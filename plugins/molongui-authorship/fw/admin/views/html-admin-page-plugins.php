<?php

use Molongui\Fw\Includes\Upsell;
if ( !defined( 'ABSPATH' ) ) exit;

?>

<div class="molongui molongui-page-plugins molongui-page-centered-wrapper">

    <div class="molongui-page-centered-inner">

        <img class="molongui-page-header" src="<?php echo molongui_get_constant( $this->plugin->id, 'URL', true ) . 'admin/img/logo_molongui.png' ?>" alt="Molongui logo" />
        <h1><?php _e( 'Plugins that make your site better!', 'molongui-common-framework' ); ?></h1>

        <!-- Upsells -->
		<?php
		$upsell = new Upsell( $this->plugin );
		if ( $upsell->empty_upsells() )
		{
			?>
            <p><?php _e( 'Visit our site to find more plugins and themes we have created to improve your site.', 'molongui-common-framework' ); ?></p>
            <a href="<?php echo molongui_get_constant( $this->plugin->id, 'MOLONGUI_WEB', true ); ?>" class="button button-primary" title="Visit Molongui website" target="_blank"><?php _e( 'Visit our site', 'molongui-common-framework' ); ?></a>
			<?php
		}
		else
		{
			echo '<p>' . __( 'As part of our ongoing effort to provide high quality, eye-catching Wordpress plugins, here you have some you might find useful for your site.', 'molongui-common-framework' ) . '</p>';
			$upsell->output( 'all', 'all', 36, null );
		}
		?>

    </div>

</div>