<?php
$nofollow = ( $settings['add_nofollow'] ? 'rel="nofollow"' : '' );
$meta_text_style = '';
if ( isset( $settings['meta_text_style'] ) and !empty( $settings['meta_text_style'] ) )
{
	foreach ( explode(',', $settings['meta_text_style'] ) as $style ) $meta_text_style .= ' molongui-text-style-'.$style;
}

?>

<?php if ( !isset( $settings['show_meta'] ) or ( isset( $settings['show_meta'] ) and $settings['show_meta'] ) ) : ?>
<div class="molongui-author-box-item molongui-author-box-meta
            molongui-font-size-<?php echo $settings['meta_text_size']; ?>-px
            molongui-text-align-<?php echo $settings['meta_text_align']; ?>
            <?php echo $meta_text_style; ?>
            molongui-text-case-<?php echo $settings['meta_text_case']; ?>"
     style="color: <?php echo $settings['meta_text_color']; ?>">

	<span itemprop="jobTitle"><?php echo $author['job']; ?></span>
	<?php if ( $author['job'] && $author['company'] ) echo ' <span class="molongui-author-box-string-at">'.( $settings[ 'at' ] ? $settings[ 'at' ] : __('at', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ).'</span> '; ?>
	<span itemprop="worksFor" itemscope itemtype="https://schema.org/Organization">
		<?php if ( $author['company_link'] ) echo '<a href="' . esc_url( $author['company_link'] ) . '" target="_blank" itemprop="url" style="color: '.$settings['meta_text_color'].';" ' . $nofollow . '>'; ?>
		<span itemprop="name"><?php echo $author['company']; ?></span>
		<?php if ( $author['company_link'] ) echo '</a>'; ?>
	</span>

	<?php if( $author['phone'] and $author['show_meta_phone'] ) : ?>
		<?php
            if( isset( $settings['encode_phone'] ) and $settings['encode_phone'] )
            {
                $phone  = molongui_ascii_encode( $author['phone'] );
	            $p_href = '&#116;&#101;&#108;&#58;'.$phone;
            }
            else
            {
                $phone  = $author['phone'];
	            $p_href = 'tel:'.$author['phone'];
            }
        ?>
		<?php if ( $author['job'] or $author['company'] ) echo ' <span class="molongui-author-box-meta-separator">'.$settings['meta_separator'].'</span> '; ?>
        <a href="<?php echo $p_href; ?>" itemprop="telephone" content="<?php echo $phone; ?>" style="color: <?php echo $settings['meta_text_color']; ?>" <?php echo $nofollow; ?>><?php echo $phone; ?></a>
	<?php endif; ?>

	<?php if ( $author['mail'] and $author['show_meta_mail'] ) : ?>
		<?php
            if( isset( $settings['encode_email'] ) and $settings['encode_email'] )
            {
                $email  = molongui_ascii_encode( $author['mail'] );
                $e_href = '&#109;&#97;&#105;&#108;&#116;&#111;&#58;'.$email;
            }
            else
            {
                $email  = $author['mail'];
                $e_href = 'mailto:'.$author['mail'];
            }
		?>
		<?php if ( $author['job'] or $author['company'] ) echo ' <span class="molongui-author-box-meta-separator">'.$settings['meta_separator'].'</span> '; ?>
		<a href="<?php echo $e_href; ?>" target="_top" itemprop="email" content="<?php echo $email; ?>" style="color: <?php echo $settings['meta_text_color']; ?>" <?php echo $nofollow; ?>><?php echo $email; ?></a>
	<?php endif; ?>

	<?php if ( $author['web'] ) : ?>
		<?php if ( $author['job'] or $author['company'] or ( $author['phone'] and $author['show_meta_phone'] ) or ( $author['mail'] and $author['show_meta_mail'] ) ) echo ' <span class="molongui-author-box-meta-separator">'.$settings['meta_separator'].'</span> '; ?>
		<a href="<?php echo esc_url( $author['web'] ); ?>" target="_blank" style="color: <?php echo $settings['meta_text_color']; ?>" <?php echo $nofollow; ?>><?php echo ' <span class="molongui-author-box-string-web">'.( $settings[ 'web' ] ? $settings[ 'web' ] : __( 'Website', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ).'</span>'; ?></a>
	<?php endif; ?>

	<?php if ( $settings['show_related'] and $settings['layout'] == 'slim' and isset( $author['posts'] ) and !empty( $author['posts'] ) ) : ?>
		<?php if ( $author['job'] or $author['company'] or $author['web'] ) echo ' <span class="molongui-author-box-meta-separator">'.$settings['meta_separator'].'</span> '; ?>
		<script type="text/javascript" language="JavaScript">
			if (typeof window.ToggleAuthorshipData === 'undefined')
			{
				function ToggleAuthorshipData(id, author)
				{
					var box_selector = '#mab-' + id;
                    var box = document.querySelector(box_selector);
                    if ( box.getAttribute('data-multiauthor') ) box_selector = '#mab-' + id + ' [data-author-ref="' + author + '"]';
					var label = document.querySelector(box_selector + ' ' + '.molongui-author-box-data-toggle');
					label.innerHTML = ( label.text.trim() === "<?php echo ( $settings['more_posts'] ? $settings['more_posts'] : __( '+ posts', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ); ?>" ? " <span class=\"molongui-author-box-string-bio\"><?php echo ( $settings['bio'] ? $settings['bio'] : __( 'Bio', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ); ?></span>" : " <span class=\"molongui-author-box-string-more-posts\"><?php echo ( $settings['more_posts'] ? $settings['more_posts'] : __( '+ posts', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ); ?></span>" );
					var bio     = document.querySelector(box_selector + ' ' + '.molongui-author-box-bio');
					var related = document.querySelector(box_selector + ' ' + '.molongui-author-box-related-entries');

					if( related.style.display === "none" )
					{
						related.style.display = "block";
						bio.style.display     = "none";
					}
					else
					{
						related.style.display = "none";
						bio.style.display     = "block";
					}
				}
			}
		</script>
		<a href="javascript:ToggleAuthorshipData(<?php echo $random_id; ?>, '<?php echo $author['type'].'-'.$author['id']; ?>')" class="molongui-author-box-data-toggle" style="color: <?php echo $settings['meta_text_color']; ?>" <?php echo $nofollow; ?>><?php echo ' <span class="molongui-author-box-string-more-posts">'.( $settings[ 'more_posts' ] ? $settings[ 'more_posts' ] : __( '+ posts', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ).'</span> '; ?></a>
	<?php endif; ?>

</div><!-- End of .molongui-author-box-meta -->
<?php endif; ?>