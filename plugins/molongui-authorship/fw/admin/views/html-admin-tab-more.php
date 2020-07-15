<?php

use Molongui\Fw\Includes\Upsell;
if ( !defined( 'ABSPATH' ) ) exit;

?>

<div class="molongui-more-wrap">

	<h3><?php _e( 'Molongui plugins', 'molongui-common-framework' ); ?></h3>
	<p class="text">
		<?php _e( 'As part of our ongoing effort to provide high quality, eye-catching Wordpress plugins, here you have some you might find useful for your site:', 'molongui-common-framework' ); ?>
	</p>

	<!-- Upsells -->
	<?php
	$upsell = new Upsell( $this->plugin );
	$upsell->output( 'all', 'all', 36, null );
	?>

</div><!-- !.upsells -->