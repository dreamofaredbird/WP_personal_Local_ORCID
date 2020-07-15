<?php
if ( !defined( 'ABSPATH' ) ) exit;
$lang = '_' . get_locale();

?>

<ul class="molongui-products">
	<?php foreach( $upsells->{$category} as $upsell_id => $upsell ) : ?>
		<li class="molongui-product">
			<a href="<?php echo $upsell->link; ?>">
				<h3>
					<?php echo ( isset( $upsell->{'name'.$lang} ) ? $upsell->{'name'.$lang} : $upsell->name ); ?>
					<span class="molongui-product-price">
						<?php
							$molongui_plugins = $this->get_installed_molongui_plugins( 'Name' );
							if ( in_array( $upsell->name, $molongui_plugins ) ) echo __( 'Installed', 'molongui-common-framework' );
							else echo ( empty( $upsell->price ) ? __( 'Free', 'molongui-common-framework' ) : $upsell->price.'&euro;' );
						?>
					</span>
				</h3>
				<?php if( ( $lang == '_en_US' && !empty( $upsell->image ) ) || ( $lang != '_en_US' && !empty( $upsell->{'image'.$lang} ) ) ) : ?>
					<div class="molongui-product-image">
						<img src="<?php echo ( isset( $upsell->{'image'.$lang} ) ? $upsell->{'image'.$lang} : $upsell->image ); ?>"/>
					</div>
				<?php else : ?>
					<p class="molongui-product-excerpt">
						<?php echo wp_trim_words( ( isset( $upsell->{'excerpt'.$lang} ) ? $upsell->{'excerpt'.$lang} : $upsell->excerpt ), $num_words, $more ); ?>
					</p>
				<?php endif; ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>