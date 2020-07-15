<?php
$bio_text_style = '';
if ( isset( $settings['bio_text_style'] ) and !empty( $settings['bio_text_style'] ) )
{
	foreach ( explode(',', $settings['bio_text_style'] ) as $style ) $bio_text_style .= ' molongui-text-style-'.$style;
}
$bio_line_height = '';
if ( isset( $settings['bio_line_height'] ) and !empty( $settings['bio_line_height'] ) )
{
	$bio_line_height = 'molongui-line-height-'.$settings['bio_line_height']*10;
}

?>

<div class="molongui-author-box-bio" itemprop="description">
	<div class="molongui-font-size-<?php echo $settings['bio_text_size']; ?>-px molongui-text-align-<?php echo $settings['bio_text_align']; ?> <?php echo $bio_text_style; ?> <?php echo $bio_line_height; ?>"
         style="color: <?php echo $settings['bio_text_color']; ?>">
	    <?php
        if ( !isset( $settings['show_bio'] ) or ( isset( $settings['show_bio'] ) and $settings['show_bio'] ) )
        {
            if ( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) )
            {
                echo do_shortcode( str_replace( array("\n\r", "\r\n", "\n\n", "\r\r"), "<br>", wpautop(  $author['bio'] ) ) );
            }
            else
            {
                echo str_replace( array("\n\r", "\r\n", "\n\n", "\r\r"), "<br>", wpautop(  $author['bio'] ) );
            }
        }
	    if ( isset( $settings['extra_content'] ) and $settings['extra_content'] )
	    {
	        echo $settings['extra_content'];
	    }
        ?>
	</div>
</div>
