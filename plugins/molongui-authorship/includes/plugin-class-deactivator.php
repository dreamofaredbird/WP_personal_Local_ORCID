<?php

namespace Molongui\Authorship\Includes;
if ( !defined( 'ABSPATH' ) ) exit;
class Deactivator
{
    public static function deactivate( $network_wide )
    {
	    if ( function_exists('is_multisite') and is_multisite() and $network_wide )
	    {
		    if ( false == is_super_admin() ) return;
		    foreach ( molongui_get_sites() as $site_id )
		    {
			    switch_to_blog( $site_id );
				self::deactivate_single_blog();
			    restore_current_blog();
		    }
	    }
	    else
	    {
		    if ( false == current_user_can( 'activate_plugins' ) ) return;

			self::deactivate_single_blog();
	    }
    }
	private static function deactivate_single_blog()
	{
		flush_rewrite_rules();
		if( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) )
		{
			if ( !class_exists( 'Molongui\Fw\Includes\License' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . 'fw/premium/update/includes/fw-class-license.php' );
			$license = new \Molongui\Fw\Includes\License( MOLONGUI_AUTHORSHIP_ID );
			$license->remove( false );
		}
		delete_transient( strtolower( str_replace( ' ', '-', MOLONGUI_AUTHORSHIP_ID ) ).'-activated' );
		delete_transient( strtolower( str_replace( ' ', '-', MOLONGUI_AUTHORSHIP_ID ) ).'-updated' );
	}

}