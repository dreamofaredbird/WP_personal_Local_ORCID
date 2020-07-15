<?php

namespace Molongui\Fw\Includes;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\Includes\Notice' ) )
{
	class Notice
	{
		public static function display( $id, $type = 'info', $content = array(), $dismissible = false, $dismissal = 0, $class = '', $pages = array(), $plugin = '' )
		{
            if ( self::is_dismissed( $id, $plugin ) ) return;
			if ( !empty( $pages ) )
			{
				global $current_screen;
				if ( !in_array( $current_screen->id, $pages ) ) return;
			}
			?>
            <div id="<?php echo $id; ?>" data-dismissible="<?php echo $dismissal; ?>" data-plugin="<?php echo $plugin; ?>" class="notice notice-<?php echo $type; ?> molongui-notice <?php echo $class ?> <?php echo ( $dismissible ? 'is-dismissible' : '' ); ?>">
			    <?php if ( isset( $content['image'] ) and !empty( $content['image'] ) ) : ?>
                    <div class="molongui-notice-image"><img src="<?php echo $content['image']; ?>" /></div>
			    <?php endif; ?>
	            <?php if ( isset( $content['icon'] ) and !empty( $content['icon'] ) ) : ?>
                    <div class="molongui-notice-icon"><i class="molongui-icon-<?php echo $content['icon']; ?>"></i></div>
	            <?php endif; ?>
                <div class="molongui-notice-content">
			        <?php if ( isset( $content['title'] ) and !empty( $content['title'] ) ) : ?>
                        <div class="molongui-notice-title"><h3><?php echo $content['title']; ?></h3></div>
			        <?php endif; ?>
			        <?php if ( isset( $content['message'] ) and !empty( $content['message'] ) ) : ?>
                        <div class="molongui-notice-message"><p><?php echo $content['message']; ?></p></div>
                    <?php endif; ?>
                    <?php if ( isset( $content['buttons'] ) and !empty( $content['buttons'] ) ) : ?>
                        <div class="molongui-notice-buttons">
                            <?php foreach ( $content['buttons'] as $button ) : ?>
                                <?php if ( isset( $button['hidden'] ) and $button['hidden'] ) continue; ?>
                                <a href="<?php echo $button['href']; ?>" target="<?php echo $button['target']; ?>" class="molongui-notice-button <?php echo $button['class']; ?>"><?php echo ( ( isset( $button['icon'] ) and !empty( $button['icon'] ) ) ? $button['icon'].' ' : '' ).$button['label']; ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
	            <?php if ( isset( $content['button'] ) and !empty( $content['button'] ) ) : ?>
                    <div class="molongui-notice-buttons">
                        <a id="<?php echo $content['button']['id']; ?>" href="<?php echo $content['button']['href']; ?>" target="<?php echo $content['button']['target']; ?>" class="molongui-notice-button <?php echo $content['button']['class']; ?>"><?php echo ( ( isset( $content['button']['icon'] ) and !empty( $content['button']['icon'] ) ) ? $content['button']['icon'].' ' : '' ).$content['button']['label']; ?></a>
                    </div>
	            <?php endif; ?>
            </div>
			<?php
		}
		public static function dismiss_notice()
		{
			check_ajax_referer( 'molongui-ajax-nonce', 'security', true );
			$plugin_id = sanitize_text_field( $_POST['plugin_id'] );
			$name      = sanitize_text_field( $_POST['dismissible_id'] );
			$value     = sanitize_text_field( $_POST['dismissible_length'] );
            if ( empty( $plugin_id ) ) wp_die();
			$key = molongui_get_constant( $plugin_id, 'NOTICES', false );
			$notices = get_option( $key );
            $notices[$name] = ( 'forever' == $value ? 'forever' : time() + absint( $value ) * DAY_IN_SECONDS );
			update_option( $key, $notices );
			wp_die();
		}
		public static function is_dismissed( $name, $plugin = '' )
		{
			if ( empty( $plugin ) ) return false;
			$key = molongui_get_constant( $plugin, 'NOTICES', false );
			$notices = get_option( $key );
            if ( !isset( $notices[$name] ) ) return false;
			if ( 'forever' == $notices[$name] ) return true;
            if ( time() >= $notices[$name] )
            {
                unset( $notices[$name] );
	            update_option( $key, $notices );
                return false;
            }
            else
            {
	            return true;
            }
		}
	}
}