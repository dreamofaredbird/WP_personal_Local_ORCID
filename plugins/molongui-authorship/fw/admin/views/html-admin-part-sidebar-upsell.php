<?php

use Molongui\Fw\Includes\Upsell;
if ( !defined( 'ABSPATH' ) ) exit;

?>

<div class="sidebar">
	<div class="upsells">

		<p class="text">
			<?php _e( 'As part of our ongoing effort to provide high quality, eye-catching Wordpress plugins, here you have some you might find useful for your site:', 'molongui-common-framework' ); ?>
		</p>

		<?php
			$upsell = new Upsell( $this->plugin->id );
			$upsell->output( 'featured', 2, 36, null );
		?>

	</div><!-- /.upsells -->
</div><!-- /.sidebar -->