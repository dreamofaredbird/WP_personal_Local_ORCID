<?php
$headline_text_style = '';
if ( isset( $settings['headline_text_style'] ) and !empty( $settings['headline_text_style'] ) )
{
    foreach ( explode(',', $settings['headline_text_style'] ) as $style ) $headline_text_style .= ' molongui-text-style-'.$style;
}
$headline_tag = ( isset( $settings['box_headline_tag'] ) ? $settings['box_headline_tag'] : 'h3' );
?>

<?php if ( isset( $settings['show_headline'] ) and !empty( $settings['show_headline'] ) and $settings['show_headline'] == 1  ) : ?>
    <!-- Author headline -->
    <div class="molongui-author-box-item molongui-author-box-headline">
        <<?php echo $headline_tag; ?> class="molongui-font-size-<?php echo $settings['headline_text_size']; ?>-px
                   molongui-text-align-<?php echo $settings['headline_text_align']; ?>
                   <?php echo $headline_text_style; ?>
                   molongui-text-case-<?php echo $settings['headline_text_case']; ?>"
            style="color: <?php echo $settings['headline_text_color']; ?>">
            <span class="molongui-author-box-string-headline"><?php echo ( $settings['headline'] ? $settings['headline'] : __( 'About the author', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ); ?></span>
        </<?php echo $headline_tag; ?>>
    </div>
<?php endif; ?>