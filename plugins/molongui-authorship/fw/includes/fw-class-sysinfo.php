<?php

namespace Molongui\Fw\Includes;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\Includes\Sysinfo' ) )
{
	class Sysinfo
	{
		private $plugin;
		public function __construct( $plugin )
		{
			$this->plugin = $plugin;
		}
		public function render_output()
		{
			ob_start();
			include( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'admin/views/html-admin-part-support-status.php' );

			return ob_get_clean();
		}
		public function get_plugins()
		{
			$plugins = array
			(
				'installed'      => array(),
				'active'         => array(),
				'network_active' => array(),
				'molongui'       => array(),
			);
			$plugins['installed'] = get_plugins();
			$plugins['active'] = (array) get_option( 'active_plugins', array() );
			if ( is_multisite() )
			{
				$plugins['network_active'] = array_keys( get_site_option( 'active_sitewide_plugins', array() ) );
				$plugins['active']         = array_merge( $plugins['active'], $plugins['network_active'] );
			}
			$plugins['molongui'] = molongui_get_our_plugins( $plugins['installed'] );

			return $plugins;
		}
		public function get_active_theme()
		{
			$active_theme = wp_get_theme();
			if ( is_child_theme() )
			{
				$parent_theme      = wp_get_theme( $active_theme->template );
				$parent_theme_info = array
				(
					'parent_name'       => $parent_theme->name,
					'parent_version'    => $parent_theme->version,
					'parent_author_url' => $parent_theme->{'Author URI'},
				);
			}
			else
			{
				$parent_theme_info = array
				(
					'parent_name'           => '',
					'parent_version'        => '',
					'parent_version_latest' => '',
					'parent_author_url'     => '',
				);
			}

			$active_theme_info = array
			(
				'name'           => $active_theme->name,
				'version'        => $active_theme->version,
				'author'         => esc_url_raw( $active_theme->{'Author'} ),
				'author_url'     => esc_url_raw( $active_theme->{'Author URI'} ),
				'is_child_theme' => is_child_theme(),
			);

			return array_merge( $active_theme_info, $parent_theme_info );
		}
		public function get_installed_themes()
		{
			return wp_get_themes();
		}
		public function get_environment_info()
		{
			$curl_version = '';
			if ( function_exists( 'curl_version' ) )
			{
				$curl_version = curl_version();
				$curl_version = $curl_version['version'] . ', ' . $curl_version['ssl_version'];
			}
			$wp_memory_limit = molongui_let_to_num( WP_MEMORY_LIMIT );
			if ( function_exists( 'memory_get_usage' ) )
			{
				$wp_memory_limit = max( $wp_memory_limit, molongui_let_to_num( @ini_get( 'memory_limit' ) ) );
			}
			$post_response = wp_safe_remote_post( 'https://www.paypal.com/cgi-bin/webscr', array
			(
				'timeout'     => 60,
				'user-agent'  => 'Molongui/' . $this->plugin->version,
				'httpversion' => '1.1',
				'body'        => array
				(
					'cmd' => '_notify-validate'
				)
			));
			$post_response_successful = false;
			if ( !is_wp_error( $post_response ) and $post_response['response']['code'] >= 200 and $post_response['response']['code'] < 300 ) $post_response_successful = true;
			$get_response = wp_safe_remote_get( 'https://woocommerce.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) );
			$get_response_successful = false;
			if ( !is_wp_error( $post_response ) and $post_response['response']['code'] >= 200 and $post_response['response']['code'] < 300 ) $get_response_successful = true;
			$database_version = $this->get_database_info();
			return array
			(
				'home_url'                  => get_option( 'home' ),
				'site_url'                  => get_option( 'siteurl' ),
				'wp_version'                => get_bloginfo( 'version' ),
				'wp_multisite'              => is_multisite(),
				'wp_memory_limit'           => $wp_memory_limit,
				'wp_debug_mode'             => ( defined( 'WP_DEBUG' ) and WP_DEBUG ),
				'wp_cron'                   => ! ( defined( 'DISABLE_WP_CRON' ) and DISABLE_WP_CRON ),
				'language'                  => get_locale(),
				'external_object_cache'     => wp_using_ext_object_cache(),
				'server_info'               => isset( $_SERVER['SERVER_SOFTWARE'] ) ? molongui_clean( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '',
				'php_version'               => phpversion(),
				'php_post_max_size'         => molongui_let_to_num( ini_get( 'post_max_size' ) ),
				'php_max_execution_time'    => ini_get( 'max_execution_time' ),
				'php_max_input_vars'        => ini_get( 'max_input_vars' ),
				'curl_version'              => $curl_version,
				'suhosin_installed'         => extension_loaded( 'suhosin' ),
				'max_upload_size'           => wp_max_upload_size(),
				'mysql_version'             => $database_version['number'],
				'mysql_version_string'      => $database_version['string'],
				'default_timezone'          => date_default_timezone_get(),
				'fsockopen_or_curl_enabled' => ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ),
				'soapclient_enabled'        => class_exists( 'SoapClient' ),
				'domdocument_enabled'       => class_exists( 'DOMDocument' ),
				'gzip_enabled'              => is_callable( 'gzopen' ),
				'mbstring_enabled'          => extension_loaded( 'mbstring' ),
				'remote_post_successful'    => $post_response_successful,
				'remote_post_response'      => ( is_wp_error( $post_response ) ? $post_response->get_error_message() : $post_response['response']['code'] ),
				'remote_get_successful'     => $get_response_successful,
				'remote_get_response'       => ( is_wp_error( $get_response ) ? $get_response->get_error_message() : $get_response['response']['code'] ),

				'wp_permalink'              => get_option( 'permalink_structure' ),
				'wp_posts_status'           => implode( ', ', get_post_stati() ),
				'wp_database_prefix'        => $database_version['prefix'],
				'php_arg_separator'         => ini_get( 'arg_separator.output' ),
				'php_only_cookies'          => ini_get( 'session.use_only_cookies' ),
				'php_display_errors'        => ini_get( 'display_errors' ),
				'php_allow_url_fopen'       => ini_get( 'allow_url_fopen' ),
				'php_session'               => isset( $_SESSION ),
				'php_session_name'          => ini_get( 'session.name' ),
				'php_cookie_path'           => ini_get( 'session.cookie_path' ),
				'php_save_path'             => ini_get( 'session.save_path' ),
				'php_use_cookies'           => ini_get( 'session.use_cookies' ),
			);
		}
		function get_database_info()
		{
			global $wpdb;

			if ( empty( $wpdb->is_mysql ) )
			{
				return array
				(
					'string' => '',
					'number' => '',
				);
			}
			if ( $wpdb->use_mysqli ) $server_info = mysqli_get_server_info( $wpdb->dbh ); // @codingStandardsIgnoreLine.
			else $server_info = mysql_get_server_info( $wpdb->dbh );                      // @codingStandardsIgnoreLine.

			return array
			(
				'string' => $server_info,
				'number' => preg_replace( '/([^\d.]+).*/', '', $server_info ),
				'prefix' => $wpdb->prefix,
			);
		}
		function get_client_info()
		{
			$browser = new \Molongui\Fw\Includes\Browser();

			return array
			(
				'platform'   => $browser->getPlatform() . ' ' . ( $browser->isMobile() ? '(mobile)' : ( $browser->isTablet() ? '(tablet)' : '(desktop)' ) ),
				'browser'    => $browser->getBrowser() . ' ' . $browser->getVersion(),
				'user_agent' => $browser->getUserAgent(),
				'ip'         => molongui_get_ip(),
			);
		}
		public function send_support_report()
		{
			check_ajax_referer( 'molongui-ajax-nonce', 'security', true );
			if ( !is_admin() and !isset( $_POST['report'] ) ) return;
			$current_user = wp_get_current_user();
			$subject = sprintf( __( 'MOLONGUI - Support report for %s', 'molongui-common-framework' ), sanitize_text_field( $_POST['domain'] ) );
			$headers = array
			(
				'From: ' . $current_user->display_name . ' <' . 'noreply@' . sanitize_text_field( $_POST['domain'] ) . '>',
				'Reply-To: ' . $current_user->display_name . ' <' . $current_user->user_email . '>',
				'Content-Type: ' . 'text/plain; charset=UTF-8',
			);
			$sent = wp_mail( molongui_get_constant( $this->plugin->id, 'SUPPORT_MAIL', true ), $subject, esc_html( $_POST['report'] ), $headers );
			echo( $sent ? 'sent' : 'error' );
			wp_die();
		}

	}
}