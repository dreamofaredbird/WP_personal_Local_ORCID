<?php

namespace Molongui\Fw\Includes;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\Includes\Upsell' ) )
{
	class Upsell
	{
		private $plugin;
		private static $debug = false;
		public function __construct( $plugin )
		{
			$this->plugin = $plugin;
		}
		public function output( $category = 'all', $num_items = 'all', $num_words = 36, $more = null )
		{
			$config = include $this->plugin->dir . 'fw/config/upsell.php';
			if ( $this->plugin->is_premium )
			{
				if ( false === ( $upsells = get_site_transient( 'molongui_sw_data' ) ) )
				{
					$upsell_json = wp_safe_remote_get( $config['server']['url'], array( 'user-agent' => $config['server']['agent'] ) );

					if ( !is_wp_error( $upsell_json ) )
					{
						$upsells = json_decode( wp_remote_retrieve_body( $upsell_json ) );
						if ( $upsells ) set_site_transient( 'molongui_sw_data', $upsells, WEEK_IN_SECONDS );
					}
					else
					{
						$upsell_json = file_get_contents( $config['local']['url'] );
						$upsell_json = str_replace( '%%MOLONGUI_PLUGIN_URL%%', $this->plugin->url, $upsell_json );
						$upsells = json_decode( $upsell_json, false );
					}
				}
			}
			else
			{
				if ( file_exists( $config['local']['url'] ) )
				{
					$upsell_json = file_get_contents( $config['local']['url'] );
					$upsell_json = str_replace( '%%MOLONGUI_PLUGIN_URL%%', $this->plugin->url, $upsell_json );
					$upsells = json_decode( $upsell_json, false );
				}
			}
			if ( ! isset( $upsells ) or empty( $upsells ) ) return;
			$tmp = (array) $upsells->{$category};
			if ( ! empty( $tmp ) )
			{
				if ( isset( $upsells->{$category}->{$this->plugin->id} ) ) unset( $upsells->{$category}->{$this->plugin->id} );
				if ( isset( $num_items ) and ( $num_items != 'all' ) and ( $num_items > 0 ) ) $upsells->{$category} = array_slice( (array) $upsells->{$category}, 0, $num_items );
				if ( self::$debug ) { echo '<pre>'; print_r( $upsells ); echo '</pre>'; }
				require_once $this->plugin->dir . 'fw/admin/views/html-admin-part-upsells.php';
			}
		}
		public function empty_upsells()
		{
			$empty_upsells = true;
			$config = include $this->plugin->dir . 'fw/config/upsell.php';
			if ( file_exists( $config['local']['url'] ) )
			{
				$upsell_json = file_get_contents( $config['local']['url'] );
				$upsell_json = str_replace( '%%MOLONGUI_PLUGIN_URL%%', $this->plugin->url, $upsell_json );
				$upsells = json_decode( $upsell_json, true );
				$empty_upsells = empty( $upsells['all'] ) ? true : false;
			}
			return $empty_upsells;
		}
		public function get_installed_molongui_plugins( $field = 'all' )
		{
			if ( ! function_exists( 'get_plugins' ) ) require_once ABSPATH . 'wp-admin/includes/plugin.php';
			$all_plugins = get_plugins();
			$molongui_plugins = array_filter( $all_plugins, function( $value, $key )
			{
				return ( $value['Author'] == 'Amitzy' );
			}, ARRAY_FILTER_USE_BOTH);
			if ( $field != 'all' )
			{
				$data = array();
				foreach ( $molongui_plugins as $plugin )
				{
					$data[] = $plugin[$field];
				}
				$molongui_plugins = $data;
			}
			return $molongui_plugins;
		}
	}
}