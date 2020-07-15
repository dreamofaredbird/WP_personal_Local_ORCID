<?php
?>

<div class="molongui-author-box-content-top">

	<?php if ( $settings['layout'] == 'stacked' ) include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/parts/html-author-box-profile-title.php' ); ?>

</div><!-- End of .molongui-author-box-content-top -->

<div class="molongui-author-box-content-middle">

    <!-- Author picture -->
    <?php include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/parts/html-author-box-avatar.php' ); ?>

    <!-- Author social -->
    <?php include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/parts/html-author-box-socialmedia.php' ); ?>

    <!-- Author data -->
    <div class="molongui-author-box-item molongui-author-box-data <?php echo ( ( isset( $settings['profile_valign'] ) and !empty( $settings['profile_valign'] ) and $settings['profile_valign'] != 'center' ) ? 'molongui-align-self-'.$settings['profile_valign'] : '' ); ?>">

        <!-- Author name -->
        <?php include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/parts/html-author-box-name.php' ); ?>

        <!-- Author metadata -->
        <?php include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/parts/html-author-box-meta.php' ); ?>

        <!-- Author bio -->
        <?php include( MOLONGUI_AUTHORSHIP_DIR . '/public/views/parts/html-author-box-bio.php' ); ?>

        <?php if ( $settings['layout'] == 'slim' and isset( $settings['show_related'] ) and !empty( $settings['show_related'] ) ) : ?>

            <!-- Author related posts -->
            <div class="molongui-author-box-related" data-related-layout="<?php echo $settings['related_layout']; ?>">
                <div class="molongui-author-box-item molongui-author-box-related-entries" <?php echo ( $settings['layout'] == 'slim' ? 'style="display: none;"' : '' ); ?>>

                    <?php
                    $related_text_style = '';
                    if ( isset( $settings['related_text_style'] ) and !empty( $settings['related_text_style'] ) )
                    {
                        foreach ( explode(',', $settings['related_text_style'] ) as $style ) $related_text_style .= ' molongui-text-style-'.$style;
                    }
                    ?>
                    <ul class="molongui-font-size-<?php echo $settings['related_text_size']; ?>-px <?php echo $related_text_style; ?>" style="color: <?php echo $settings['related_text_color']; ?>">
                        <?php
                        if ( isset( $author['posts'] ) and !empty( $author['posts'] ) ) //or is_array( $author_posts ) or is_object( $author_posts ) )
                        {
                            $premium_layouts = array( 'layout-3' );
                            if ( !isset( $settings['related_layout'] ) or empty( $settings['related_layout'] ) or $settings['related_layout'] == 'layout-1' )
                            {
                                include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/html-author-box-related-layout-1.php' );
                            }
                            elseif ( isset( $settings['related_layout'] ) and !empty( $settings['related_layout'] ) and !in_array( $settings['related_layout'], $premium_layouts ) )
                            {
                                include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/html-author-box-related-'.$settings['related_layout'].'.php' );
                            }
                            elseif ( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) and in_array( $settings['related_layout'], $premium_layouts ) )
                            {
                                include( MOLONGUI_AUTHORSHIP_DIR . 'premium/public/views/html-author-box-related-'.$settings['related_layout'].'.php' );
                            }
                            elseif ( is_customize_preview() )
                            {
                                require_once( MOLONGUI_AUTHORSHIP_DIR . 'customizer/plugin-customizer-preview.php' );
                                molongui_authorship_related_customizer_preview( $author, $settings, $random_id );
                            }
                        }
                        else
                        {
                            echo ' <span class="molongui-author-box-string-no-related-posts">'. ( $settings[ 'no_related_posts' ] ? $settings[ 'no_related_posts' ] : __( 'This author does not have any more posts.', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ).'</span>';
                        }
                        ?>
                    </ul>

                </div><!-- End of .molongui-author-box-related-entries -->
            </div><!-- End of .molongui-author-box-related -->

        <?php endif; ?>

    </div><!-- End of .molongui-author-box-data -->

</div><!-- End of .molongui-author-box-content-middle -->

<div class="molongui-author-box-content-bottom"></div><!-- End of .molongui-author-box-content-bottom -->