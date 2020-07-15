<?php
if ( !defined( 'ABSPATH' ) ) exit;

?>

<div class="sidebar">
	<div class="rate">

		<p>
			<?php _e( 'We are constantly looking for ways to improve the quality of our products and services. How you rate our product and service is the most important information we can obtain to support our goal.', 'molongui-common-framework' ); ?>
		</p>
		<?php if ( !$this->plugin->is_premium ) : ?>
			<p>
				<?php _e( 'We would really appreciate it if you would take a second to rate this plugin at the official directory of Wordpress plugins. A huge thank you from Molongui in advance!', 'molongui-common-framework' ); ?>
			</p>
			<br>
			<a href="https://wordpress.org/support/view/plugin-reviews/<?php echo $this->plugin->slug; ?>" class="button button-primary" target="_blank">
				<?php _e('Rate this plugin', 'molongui-common-framework' ); ?>
			</a>
		<?php else : ?>
			<p>
				<?php _e( 'We would really appreciate any feedback you would like to send us. A huge thank you from Molongui in advance!', 'molongui-common-framework' ); ?>
			</p>
			<br>
			<a href="<?php echo $this->plugin->web; ?>" class="button button-primary" target="_blank">
				<?php _e('Send feedback', 'molongui-common-framework' ); ?>
			</a>
		<?php endif; ?>

	</div><!-- /.rate -->
</div><!-- /.sidebar -->