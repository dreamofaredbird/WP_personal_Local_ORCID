<?php
?>

<!-- MOLONGUI AUTHORSHIP PLUGIN <?php echo MOLONGUI_AUTHORSHIP_VERSION ?> -->
<!-- <?php echo MOLONGUI_AUTHORSHIP_WEB ?> -->
<div class="molongui-clearfix"></div>
<div id="mab-<?php echo $random_id; ?>"
     class="molongui-author-box"
     data-plugin-release="<?php echo MOLONGUI_AUTHORSHIP_VERSION ?>"
     data-plugin-version="<?php echo ( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ? 'premium' : 'free' ) ?>"
     data-box-layout="<?php echo $settings['layout']; ?>"
     data-multiauthor="<?php echo ( $is_multiauthor ? 'true' : 'false' ); ?>"
     data-authors-count="<?php echo count( $authors ); ?>"
     itemscope itemtype="https://schema.org/Person"
     style="<?php echo ( ( isset( $settings['box_width'] )  and !empty( $settings['box_width'] ) )  ? 'width: '  . $settings['box_width']  . '%;' : '' );?>
     <?php echo ( ( isset( $settings['box_margin'] ) and !empty( $settings['box_margin'] ) ) ? 'margin: ' . $settings['box_margin'] . 'px auto;' : '' );?>">

	<?php
	if ( $show_headline and isset( $settings['show_headline'] ) and !empty( $settings['show_headline'] ) and $settings['show_headline'] == 1  )
	{
		include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/parts/html-author-box-headline.php' );
	}
	if ( $show_tabs = ( isset( $settings['layout'] ) and !empty( $settings['layout'] ) and $settings['layout'] == 'tabbed' ) )
	{
		echo '<div class="molongui-author-box-tabs">';
		include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/parts/html-author-box-tabs.php' );
	}

	?>

    <div class="molongui-author-box-container
                <?php echo $this->get_box_border( $settings['box_border'] ); ?>
                molongui-border-style-<?php echo ( ( isset( $settings['box_border_style'] ) and !empty( $settings['box_border_style'] ) ) ? $settings['box_border_style'] : 'none' ); ?>
                molongui-border-width-<?php echo ( ( isset( $settings['box_border_width'] ) and !empty( $settings['box_border_width'] ) ) ? $settings['box_border_width'] : '0' ); ?>-px
                mabc-shadow-<?php echo ( ( isset( $settings['box_shadow'] ) and !empty( $settings['box_shadow'] ) ) ? $settings['box_shadow'] : 'left' ); ?>"
         style="<?php echo ( ( isset( $settings['box_border_color'] ) and !empty( $settings['box_border_color'] ) ) ? 'border-color: ' . $settings['box_border_color'] . ';' : '' );?>
	     <?php echo ( ( isset( $settings['box_background'] ) and !empty( $settings['box_background'] ) ) ? 'background-color: ' . $settings['box_background'] . ';' : '' );?>">

        <div class="molongui-author-box-tab molongui-author-box-content molongui-author-box-profile"
             data-profile-layout="<?php echo $settings['profile_layout']; ?>">

            <?php foreach ( $authors as $author ) : ?>

                <?php if ( isset( $author['hide'] ) and $author['hide'] ) continue; ?>

                <div class="molongui-author-box-profile-multiauthor" data-author-type="<?php echo $author['type']; ?>" data-author-ref="<?php echo $author['type'].'-'.$author['id']; ?>">
                    <?php
                    if ( !isset( $settings['profile_layout'] ) or empty( $settings['profile_layout'] ) or $settings['profile_layout'] == 'layout-1' )
                    {
                        include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/html-author-box-profile-layout-1.php' );
                    }
                    elseif ( molongui_is_premium(MOLONGUI_AUTHORSHIP_DIR) )
                    {
                        include( MOLONGUI_AUTHORSHIP_DIR . 'premium/public/views/html-author-box-profile-' . $settings['profile_layout'] . '.php' );
                    }
                    elseif ( is_customize_preview() )
                    {
                        require_once( MOLONGUI_AUTHORSHIP_DIR . 'customizer/plugin-customizer-preview.php' );
                        molongui_authorship_profile_customizer_preview( $author, $settings, $random_id );
                    }
                    ?>
                </div>

            <?php endforeach; ?>

        </div><!-- End of .molongui-author-box-profile -->

        <?php if ( $settings['layout'] != 'slim' and isset($settings['show_related']) and !empty($settings['show_related']) and $settings['show_related'] == 1 ) : ?>

            <?php $author['posts'] = $this->get_coauthored_posts( $post_authors, false, array(), 'selected' ); ?>

            <div class="molongui-author-box-tab molongui-author-box-content molongui-author-box-related" data-related-layout="<?php echo $settings['related_layout']; ?>">

                <div class="molongui-author-box-content-top">

			        <?php if ( $settings['layout'] == 'stacked' ) include( MOLONGUI_AUTHORSHIP_DIR . 'public/views/parts/html-author-box-related-title.php' ); ?>

                </div><!-- End of .molongui-author-box-content-top -->

                <div class="molongui-author-box-content-middle">

                    <!-- Related entries -->
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

                </div><!-- End of .molongui-author-box-content-middle -->

                <div class="molongui-author-box-content-bottom"></div><!-- End of .molongui-author-box-content-bottom -->

            </div><!-- End of .molongui-author-box-related -->

        <?php endif; ?>

    </div><!-- End of .molongui-author-box-container -->

	<?php if ( $show_tabs ) echo '</div><!-- End of .molongui-author-box-tabs -->'; ?>

</div><!-- End of .molongui-author-box -->