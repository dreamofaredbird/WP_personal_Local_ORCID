<?php

if ( isset( $settings['show_icons'] ) and !empty( $settings['show_icons'] ) and $settings['show_icons'] )
{
	$social_networks = include( MOLONGUI_AUTHORSHIP_DIR . 'config/social.php' );
	if ( $author['show_social_mail'] )
    {
        $social_networks['mail'] = array ( 'name' => 'E-mail', 'url' => 'your_name@example.com', 'color' => '#333', 'premium' => false );
        $settings['show_mail']   = true;
    }
	if ( $author['show_social_web'] )
    {
        $social_networks['web'] = array ( 'name' => 'Website', 'url' => 'https://www.example.com/', 'color' => '#333', 'premium' => false, );
	    $settings['show_web']   = true;
    }
	if ( $author['show_social_phone'] )
    {
        $social_networks['phone'] = array ( 'name' => 'Phone', 'url' => '123456789', 'color' => '#333', 'premium' => false, );
	    $settings['show_phone']   = true;
    }
	$continue = false;
	foreach ( $social_networks as $id => $social_network )
	{
		if ( isset( $author[$id] ) and !empty( $author[$id] ) )
		{
			$continue = true;
			break; // There is at least one social network to show, no need to keep looking.
		}
	}
	if ( !$continue ) return;
	if ( isset( $settings['icons_style'] ) )
	{
		$ico_style = $settings['icons_style'];
		if ( $ico_style and $ico_style != 'default' ) $ico_style = '-' . $ico_style;
		elseif ( $ico_style == 'default' ) $ico_style = '';
	}
	if ( isset( $settings['icons_size'] ) ) $ico_size = $settings['icons_size'];
	else $ico_size = 'normal';
	$ico_color = '';
	if ( isset( $settings['icons_color'] ) and $settings['icons_color'] != 'inherit' )
	{
		switch ( $settings['icons_style'] )
		{
			case 'squared':
			case 'circled':

				$ico_color = 'border-color: ' . $settings['icons_color'] . '; background-color: ' . $settings['icons_color'] . ';';

			break;

			case 'boxed':

				$ico_color = 'border-color: ' . $settings['icons_color'] . '; color: ' . $settings['icons_color'] . ';';

			break;

			case 'branded':
			case 'branded-squared-reverse':
			case 'branded-circled-reverse':
			case 'branded-boxed':

				$ico_color = ''; // do nothing

			break;

			case 'branded-squared':
			case 'branded-circled':

				$ico_color = 'background-color: ' . $settings['icons_color'];

			break;

			case 'default':
			default:

				$ico_color = 'color: ' . $settings['icons_color'] . ';';

			break;
		}
	}
	$nofollow = ( $settings['add_nofollow'] ? 'rel="nofollow"' : '' );
	echo '<div class="molongui-author-box-item molongui-author-box-social '.( ( isset( $settings['profile_layout'] ) and !in_array( $settings['profile_layout'], array( 'layout-7', 'layout-8' ) ) and isset( $settings['profile_valign'] ) and !empty( $settings['profile_valign'] ) and $settings['profile_valign'] != 'center' ) ? 'molongui-align-self-'.$settings['profile_valign'] : '' ).'">';
        foreach ( $social_networks as $id => $social_network )
        {
            $url = $author[$id];

            if ( isset( $url ) and !empty( $url ) and $settings['show_'.$id] )
            {
	            if ( $id == 'mail' )
	            {
                    $mail = sanitize_email( $url );
		            if ( isset( $settings['encode_email'] ) and $settings['encode_email'] ) $url = molongui_ascii_encode( 'mailto:'.$mail );
		            else $url = 'mailto:'.$mail;
	            }
	            elseif ( $id == 'phone' )
	            {
		            $phone = $url;
		            if ( isset( $settings['encode_phone'] ) and $settings['encode_phone'] ) $url = molongui_ascii_encode( 'tel:'.$phone );
		            else $url = 'tel:'.$phone;
	            }
				?>
					<div class="molongui-author-box-social-icon">
						<a itemprop="sameAs" href="<?php echo $url; ?>" class="icon-container icon-container<?php echo $ico_style; ?> icon-container-<?php echo $id; ?> molongui-font-size-<?php echo $ico_size; ?>-px" style="<?php echo $ico_color; ?>" <?php echo $nofollow; ?> target="_blank">
							<i class="m-a-icon-<?php echo $id; ?>"></i>
						</a>
					</div>
				<?php
            }
        }
    echo '</div>';
}