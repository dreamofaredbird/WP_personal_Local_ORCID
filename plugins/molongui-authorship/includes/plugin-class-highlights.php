<?php

namespace Molongui\Authorship\Includes;

use Molongui\Authorship\Admin\Admin;
if ( !defined( 'ABSPATH' ) ) exit;
class Highlights
{
	public function highlights_plugin()
	{
		$config = include MOLONGUI_AUTHORSHIP_FW_DIR . "config/config.php";
		ob_start();
		?>
		<p><?php  _e( "Molongui Authorship is probably the most complete suite on all about authors and authorship. Check below some of its awesome features:", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></p>
        <ul>
			<li class="molongui-notice-icon-check"><?php printf( __( "%sCo-authors%s. Assign multiple authors to your posts. Just locate the 'Authors' module on the right of your post edit screen and start adding authors.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
			<li class="molongui-notice-icon-check"><?php printf( __( "%sGuest authors%s. Assign guest authors to your posts without creating WordPress user accounts. Open the 'Guest authors' menu and define your guest authors.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check"><?php printf( __( "%sAuthor box%s. Display the author profile in all your posts or just on those you define. Customize the box to your likings to best fit your site with %slive-preview%s!.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>', '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check <?php echo ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span><?php printf( __( "%sShortcodes%s. Display author boxes on your sidebar or anywhere you like, a list of authors and contributors of your blog and a list of posts by author.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
		    <?php if ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ) : ?>
                <li class="molongui-notice-icon-check molongui-notice-only-premium"><span><?php _e( 'Premium only', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span><?php printf( __( "%sPremium features%s. More layouts, more styles, more customization settings, guest author archive pages and Premium support.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
		    <?php endif; ?>
        </ul>
		<?php
		$message = ob_get_clean();
		$content = array
		(
			'image'   => '',
			'title'   => sprintf( __( "Thanks for choosing %s plugin!", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), MOLONGUI_AUTHORSHIP_NAME ),
			'message' => $message,
			'buttons' => array
			(
				'customizer' => array
				(
					'href'   => Admin::get_customizer_link(),
					'target' => '_self',
					'class'  => 'molongui-notice-button-green',
					'icon'   => '',
					'label'  => __( 'Customizer', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
                    'hidden' => false,
				),
				'settings' => array
				(
					'href'   => admin_url( $config['menu']['slug'] . MOLONGUI_AUTHORSHIP_DASHED_NAME ),
					'target' => '_self',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'Settings', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
					'hidden' => false,
				),
				'documentation' => array
				(
					'href'   => MOLONGUI_AUTHORSHIP_FW_MOLONGUI_WEB.'docs',
					'target' => '_blank',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'Documentation', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
					'hidden' => false,
				),
				'premium' => array
				(
					'href'   => MOLONGUI_AUTHORSHIP_WEB,
					'target' => '_blank',
					'class'  => 'molongui-notice-button-orange',
					'icon'   => '',
					'label'  => __( 'Go Premium', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
					'hidden' => molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ),
				),
			),
		);
		return $content;
	}
	public function highlights_release_210()
	{
	    require_once MOLONGUI_AUTHORSHIP_FW_DIR.'includes/fw-helper-functions.php';
		ob_start();
		?>
			<p><?php _e( "We have listened to you and we have focused this update on improving the customization of the author box.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></p>
			<ul>
				<li class="molongui-notice-icon-check"><?php printf( __( "The author box can be now customized with %slive preview%s from the WordPress Customizer.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
				<li class="molongui-notice-icon-check"><?php _e( "Settings page reorganization for clarity's sake.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
				<?php if ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ) : ?>
                    <li class="molongui-notice-icon-check"><?php printf( __( "Added the options to display the author box %sonly on posts%s or %sonly on pages%s.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>', '<strong>', '</strong>' ); ?></li>
				    <li class="molongui-notice-icon-check"><?php _e( "Author name color is now customizable.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
                <?php endif; ?>
                <li class="molongui-notice-icon-check <?php echo ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span><?php printf( __( "Added setting to %sdisable user archive pages%s and redirect pages to any given destination.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
                <li class="molongui-notice-icon-check <?php echo ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span><?php printf( __( "Added setting to %schange author archives template and the author base%s.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
                <li class="molongui-notice-icon-check <?php echo ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span><?php _e( "Added more customization settings: text style, border style...", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
            </ul>
            <p class="molongui-notice-message-important"><?php _e( "Some styling modifications have been introduced. Please, make sure the author box looks like you want and customize it required.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></p>
		<?php
		$message = ob_get_clean();
		$content = array
		(
			'image'   => '',
			'title'   => sprintf( __( "What's new on %s %s", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), MOLONGUI_AUTHORSHIP_NAME, MOLONGUI_AUTHORSHIP_VERSION ),
			'message' => $message,
			'buttons' => array
			(
				'customizer' => array
				(
					'href'   => Admin::get_customizer_link(),
					'target' => '_self',
					'class'  => 'molongui-notice-button-green',
					'icon'   => '',
					'label'  => __( 'Open new customizer', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
				),
				'settings' => array
				(
					'href'   => 'admin.php?page='.MOLONGUI_AUTHORSHIP_DASHED_NAME,
					'target' => '_self',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'Settings page', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
				),
				'changelog' => array
				(
					'href'   => MOLONGUI_AUTHORSHIP_FW_MOLONGUI_WEB . 'molongui-authorship-changelog/',
					'target' => '_blank',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'See changelog', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
				),
			),
		);
		return $content;
	}
	public function highlights_release_300()
	{
		require_once MOLONGUI_AUTHORSHIP_FW_DIR.'includes/fw-helper-functions.php';
		ob_start();
		?>
        <p><?php _e( "Huge update with endless author box layout combinations!", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></p>
        <ul>
            <li class="molongui-notice-icon-check"><?php printf( __( "Added a %snew box layout%s that displays author profile above related posts in the same author box.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Added settings to customize box tabs.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
            <li class="molongui-notice-icon-check"><?php printf( __( "Added a %snew template to display related entries%s into the author box.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>', '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Added 'Hide on these post categories' setting to control on which categories the author box won't be displayed by default.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
            <li class="molongui-notice-icon-check <?php echo ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span><?php printf( __( "Added 7 %snew profile templates%s.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check <?php echo ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span><?php printf( __( "Added a %sthird new template%s to display related entries into the author box.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check <?php echo ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span><?php printf( __( "New %s'Contributors' page%s featuring a list of all authors in your site.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
        </ul>
        <p class="molongui-notice-message-important"><?php _e( "Some styling modifications have been introduced. Please, make sure the author box looks like you want and customize it if required.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></p>
		<?php
		$message = ob_get_clean();
		$content = array
		(
			'image'   => '',
			'title'   => sprintf( __( "What's new on %s %s", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), MOLONGUI_AUTHORSHIP_NAME, MOLONGUI_AUTHORSHIP_VERSION ),
			'message' => $message,
			'buttons' => array
			(
				'customizer' => array
				(
					'href'   => Admin::get_customizer_link(),
					'target' => '_self',
					'class'  => 'molongui-notice-button-green',
					'icon'   => '',
					'label'  => __( 'Open customizer', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
				),
				'settings' => array
				(
					'href'   => 'admin.php?page='.MOLONGUI_AUTHORSHIP_DASHED_NAME,
					'target' => '_self',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'Settings page', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
				),
				'changelog' => array
				(
					'href'   => MOLONGUI_AUTHORSHIP_FW_MOLONGUI_WEB . 'molongui-authorship-changelog/',
					'target' => '_blank',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'See changelog', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
				),
			),
		);
		return $content;
	}
	public function highlights_release_320()
	{
		require_once MOLONGUI_AUTHORSHIP_FW_DIR.'includes/fw-helper-functions.php';
		ob_start();
		?>
        <p><?php _e( "Huge update with endless author box layout combinations!", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></p>
        <ul>
            <li class="molongui-notice-icon-check"><?php printf( __( "Now you can edit 'first name', 'last name' and 'display name' %sseparately%s for your guest authors. Just like you do for regular users.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Added setting to align name and author meta within the author box.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Added 'Entries' column to 'Users list' to display number of entries for each user.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Removed 'e-mail' and 'website' from social networks list. Both can be optionally displayed as an icon.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Now it is possible to show phone number as another icon within the social icons section.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Restyled 'Support' page. Now you can open support tickets and chat with Molongui without leaving the Dashboard :)", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></li>
        </ul>
		<?php
		$message = ob_get_clean();
		$content = array
		(
			'image'   => '',
			'title'   => sprintf( __( "What's new on %s %s", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), MOLONGUI_AUTHORSHIP_NAME, MOLONGUI_AUTHORSHIP_VERSION ),
			'message' => $message,
			'buttons' => array
			(
				'customizer' => array
				(
					'href'   => Admin::get_customizer_link(),
					'target' => '_self',
					'class'  => 'molongui-notice-button-green',
					'icon'   => '',
					'label'  => __( 'Open customizer', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
				),
				'settings' => array
				(
					'href'   => 'admin.php?page='.MOLONGUI_AUTHORSHIP_DASHED_NAME,
					'target' => '_self',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'Settings page', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
				),
				'changelog' => array
				(
					'href'   => MOLONGUI_AUTHORSHIP_FW_MOLONGUI_WEB . 'molongui-authorship-changelog/',
					'target' => '_blank',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'See changelog', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
				),
			),
		);
		return $content;
	}

} // End of the class.