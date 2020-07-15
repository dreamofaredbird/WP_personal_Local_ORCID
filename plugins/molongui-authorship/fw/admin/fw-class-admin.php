<?php

namespace Molongui\Fw\Admin;

use Molongui\Fw\Includes\License;
use Molongui\Fw\Includes\Key;
use Molongui\Fw\Includes\Update;
use Molongui\Fw\Includes\Password;
use Molongui\Fw\Includes\Settings;
use Molongui\Fw\OptionsPage;
use Molongui\Fw\Includes\Sysinfo;
use Molongui\Fw\Includes\Notice;
use Molongui\Fw\Includes\Upsell;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\Admin\Admin' ) )
{
	class Admin
	{
		protected $plugin;
		protected $loader;
		private $classes;
		public function __construct( $plugin, $loader )
		{
			$this->plugin = $plugin;
			$this->loader = $loader;
			$this->load_dependencies();
			$this->define_hooks();
		}
		private function load_dependencies()
		{
			if ( !class_exists( 'Molongui\Fw\Includes\Sysinfo' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'includes/fw-class-sysinfo.php' );
			if ( !class_exists( 'Molongui\Fw\Includes\Browser' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'includes/vendor-class-browser.php' );
			$this->classes['sysinfo'] = new Sysinfo( $this->plugin );
			if ( !class_exists( 'Molongui\Fw\Includes\Notice' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'includes/fw-class-notice.php' );
			$this->classes['notice'] = new Notice();
			if ( !class_exists( 'Molongui\Fw\Includes\Upsell' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'includes/fw-class-upsell.php' );
			if ( $this->plugin->is_premium ) $this->load_premium_dependencies();
		}
		private function load_premium_dependencies()
		{
			if ( !class_exists( 'Molongui\Fw\Includes\Key' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'premium/update/includes/fw-class-key.php' );
			if ( !class_exists( 'Molongui\Fw\Includes\Update' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'premium/update/includes/fw-class-update.php' );
			if ( !class_exists( 'Molongui\Fw\Includes\Password' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'premium/update/includes/fw-class-password.php' );
			if ( !class_exists( 'Molongui\Fw\Includes\License' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'premium/update/includes/fw-class-license.php' );
		}
		private function define_hooks()
		{
			$this->loader->add_action( 'init', $this, 'load_plugin_settings', 99 );
			$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_styles'  );
			$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
			$this->loader->add_action( 'admin_menu', $this, 'add_menu_item' );
			$this->loader->add_action( 'admin_init', $this, 'add_page_tabs' );
			$this->loader->add_filter( 'plugin_action_links_'.$this->plugin->basename, $this, 'add_action_links' );
			$this->loader->add_filter( 'admin_footer_text', $this, 'admin_footer_text', 999 );
			if ( get_transient( $this->plugin->dashed_name.'-activated' ) ) $this->loader->add_action( 'admin_notices', $this, 'display_install_notice', 999 );
			if ( get_transient( $this->plugin->dashed_name.'-updated' ) ) $this->loader->add_action( 'admin_notices', $this, 'display_whatsnew_notice', 999 );
			$this->loader->add_filter( 'upgrader_post_install', $this, 'reset_whatsnew_notice', 10, 3 );
			$this->loader->add_action( 'admin_notices', $this, 'display_rate_notice', 999 );
			$this->loader->add_action( 'wp_ajax_send_support_report', $this->classes['sysinfo'], 'send_support_report' );
			$this->loader->add_action( 'wp_ajax_send_support_ticket', $this, 'send_support_ticket' );
			$this->loader->add_action( 'wp_ajax_dismiss_notice', $this->classes['notice'], 'dismiss_notice' );
			if ( $this->plugin->is_premium ) $this->define_premium_hooks();
			else
			{
				if( $this->plugin->is_upgradable ) $this->loader->add_action( 'admin_notices', $this, 'display_upgrade_notice', 999 );
			}
		}
		private function define_premium_hooks()
		{
			$this->manage_license();
			$this->classes['license'] = new License( $this->plugin );
			$this->classes['key']     = new Key( $this->plugin );
			$this->loader->add_action( 'wp_ajax_deactivate_license_key', $this->classes['license'], 'deactivate_license_key' );
		}
		public function manage_license()
		{
			new Update( $this->plugin );
		}
		public function load_plugin_settings()
		{
			if ( file_exists( $file = molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'config/settings.php' ) ) $common_settings = include $file;
			if ( file_exists( $file = $this->plugin->dir . '/config/settings.php' ) ) $plugin_settings = include $file;
			$this->plugin->settings_map = array_merge_recursive( ( isset( $plugin_settings ) ? $plugin_settings : array() ), ( isset( $common_settings ) ? $common_settings : array() ) );
        }
		public function enqueue_styles()
		{
			$screen = get_current_screen();
			$fw_dir     = molongui_get_constant( $this->plugin->id, 'DIR', true );
			$fw_url     = molongui_get_constant( $this->plugin->id, 'URL', true );
			$fw_version = molongui_get_constant( $this->plugin->id, 'VERSION', true );
			$post_types = molongui_supported_post_types( $this->plugin->id, 'all' );
			$post_types = array_merge( $post_types, $this->plugin->config['cpt'] );
			foreach ( $post_types as $post_type ) $post_types[] = 'edit-'.$post_type;
			if ( in_array( $screen->id, array_merge( $post_types,
													 array( 'dashboard', 'update-core', 'plugins',
			                                                'toplevel_page_molongui', 'molongui_page_molongui-support', 'molongui_page_molongui-about',
			                                                'molongui_page_'.$this->plugin->dashed_name ) )
				) )
			{
				$file = 'admin/css/mcf-notices.bb7b.min.css';
				if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-notices', $fw_url.$file, array(), $fw_version, 'all' );
				$file = 'admin/css/mcf-font.339b.min.css';
				if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-font', $fw_url.$file, array(), $fw_version, 'all' );
			}
			if ( $screen->id == 'plugins' )
			{
				$file = 'admin/css/mcf-plugins.b4ba.min.css';
				if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-plugins', $fw_url.$file, array(), $fw_version, 'all' );
			}
            elseif ( $screen->id == 'toplevel_page_molongui' )
			{
				$file = 'admin/css/mcf-molongui-plugins.80e1.min.css';
				if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-molongui-plugins', $fw_url.$file, array(), $fw_version, 'all' );
			}
            elseif ( $screen->id == 'molongui_page_molongui-support' )
			{
				$file = 'admin/css/mcf-support.8934.min.css';
				if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-support', $fw_url.$file, array(), $fw_version, 'all' );
				elseif ( isset( $_GET['tab'] ) and $_GET['tab'] == 'status' )
				{
					$file = 'admin/css/mcf-support.8934.min.css';
					if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-support', $fw_url.$file, array(), $fw_version, 'all' );
				}
			}
            elseif ( $screen->id == 'molongui_page_molongui-about' )
			{
				$file = 'admin/css/mcf-molongui-plugins.80e1.min.css';
				if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-molongui-plugins', $fw_url.$file, array(), $fw_version, 'all' );

				$file = 'admin/css/mcf-about.xxxx.min.css';
				if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-about', $fw_url.$file, array(), $fw_version, 'all' );
			}
            elseif ( $screen->id == 'molongui_page_'.$this->plugin->dashed_name )
			{
				$file = 'admin/css/mcf-settings.9812.min.css';
				if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-settings', $fw_url.$file, array(), $fw_version, 'all' );
				if ( isset( $_GET['tab'] ) and $_GET['tab'] == $this->plugin->underscored_id.'_license' )
				{
					$file = 'admin/css/mcf-license.0a0a.min.css';
					if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-license', $fw_url.$file, array(), $fw_version, 'all' );
				}
				elseif ( isset( $_GET['tab'] ) and $_GET['tab'] == $this->plugin->underscored_id.'_support' )
				{
					$file = 'admin/css/mcf-support.8934.min.css';
					if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-support', $fw_url.$file, array(), $fw_version, 'all' );
				}
                elseif ( isset( $_GET['tab'] ) and $_GET['tab'] == $this->plugin->underscored_id.'_more' )
				{
					$file = 'admin/css/mcf-molongui-plugins.80e1.min.css';
					if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-more', $fw_url.$file, array(), $fw_version, 'all' );
				}
			}
			$file = 'admin/css/mcf-common.a8cb.min.css';
			if ( file_exists( molongui_get_constant( $this->plugin->id, 'DIR', true ).$file ) )
				wp_enqueue_style( 'mcf-admin', molongui_get_constant( $this->plugin->id, 'URL', true ).$file, array(), molongui_get_constant( $this->plugin->id, 'VERSION', true ), 'all' );
		}
		public function enqueue_scripts( $hook )
		{
			$screen = get_current_screen();
			$post_types = molongui_supported_post_types( $this->plugin->id, 'all' );
			$post_types = array_merge( $post_types, $this->plugin->config['cpt'] );
			foreach ( $post_types as $post_type ) $post_types[] = 'edit-'.$post_type;
			if ( in_array( $screen->id, array_merge( $post_types,                                                                                       // Post types where plugin functionality is extended to.
													 array( 'dashboard', 'update-core', 'plugins',                                                      // WP admin screens.
													        'toplevel_page_molongui', 'molongui_page_molongui-support', 'molongui_page_molongui-about', // Molongui common screens.
													        'molongui_page_'.$this->plugin->dashed_name ) )                                             // Plugin settings page.
			) )
			{
				molongui_enqueue_sweetalert();
			}
			if ( $screen->id == 'molongui_page_'.$this->plugin->dashed_name )
			{
				molongui_enqueue_tiptip();
				if ( isset( $_GET['tab'] ) and $_GET['tab'] == $this->plugin->underscored_id.'_license' )
				{
					$file = 'admin/js/mcf-license.1678.min.js';
					if ( file_exists( molongui_get_constant( $this->plugin->id, 'DIR', true ).$file ) ) wp_enqueue_script( 'molongui-support', molongui_get_constant( $this->plugin->id, 'URL', true ).$file, array( 'jquery' ), molongui_get_constant( $this->plugin->id, 'VERSION', true ), true );
				}
			}
			elseif ( $screen->id == 'molongui_page_molongui-support' )
			{
				molongui_enqueue_tiptip();
				$file = 'admin/js/mcf-support.0e93.min.js';
				if ( file_exists( molongui_get_constant( $this->plugin->id, 'DIR', true ).$file ) ) wp_enqueue_script( 'molongui-license', molongui_get_constant( $this->plugin->id, 'URL', true ).$file, array( 'jquery' ), molongui_get_constant( $this->plugin->id, 'VERSION', true ), true );
			}
			$file = 'admin/js/mcf-common.2efa.min.js';
			if ( file_exists( molongui_get_constant( $this->plugin->id, 'DIR', true ).$file ) )
			{
				wp_enqueue_script( 'molongui-common-framework', molongui_get_constant( $this->plugin->id, 'URL', true ).$file, array( 'jquery' ), molongui_get_constant( $this->plugin->id, 'VERSION', true ), true );
				wp_localize_script( 'molongui-common-framework', 'molongui_fw_params', array
				(
					'ajax_url'	 => admin_url( 'admin-ajax.php' ),
					'ajax_nonce' => wp_create_nonce( 'molongui-ajax-nonce' ),
				));
			}
		}
		public function add_action_links( $links )
		{
			$fw_config = include molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'config/config.php';

			$more_links = array
			(
				'settings' => '<a href="' . admin_url( $fw_config['menu']['slug'] . $this->plugin->dashed_name ) . '">' . __( 'Settings', 'molongui-common-framework' ) . '</a>',
				'docs'     => '<a href="' . molongui_get_constant( $this->plugin->id, 'MOLONGUI_WEB', true ) . 'docs" target="blank" >' . __( 'Docs', 'molongui-common-framework' ) . '</a>'
			);

			if( !$this->plugin->is_premium )
			{
				$more_links['gopro'] = '<a href="' . $this->plugin->web . '/" target="blank" style="font-weight:bold;color:orange">' . __( 'Go Premium', 'molongui-common-framework' ) . '</a>';
			}

			return array_merge( $more_links, $links );
		}
		public function admin_footer_text( $footer_text )
		{
			global $current_screen;
			$common_fw_pages = array( 'toplevel_page_molongui', 'molongui_page_molongui-support', 'molongui_page_molongui-about' );
			if ( in_array( $current_screen->id, $common_fw_pages ) )
			{
				return ( sprintf( __( 'Molongui is a trademark of %1$s Amitzy%2$s.', 'molongui-common-framework' ),
					'<a href="https://www.amitzy.com" target="_blank" class="molongui-admin-footer-link">',
					'</a>' )
				);
			}
			if ( $current_screen->id == 'molongui_page_'.$this->plugin->dashed_name )
			{
				return ( sprintf( __( 'If you like <strong>%s</strong> please leave us a %s&#9733;&#9733;&#9733;&#9733;&#9733;%s rating. A huge thank you from Molongui in advance!', 'molongui-common-framework' ),
								  $this->plugin->name,
								  '<a href="https://wordpress.org/support/view/plugin-reviews/'.strtolower( str_replace( ' ', '-', $this->plugin->name ) ).'?filter=5#postform" target="_blank" class="molongui-admin-footer-link" data-rated="' . esc_attr__( 'Thanks :)', 'molongui-common-framework' ) . '">',
								  '</a>' )
				);
			}
			return $footer_text;
		}
		public function add_menu_item()
		{
			if ( !current_user_can( 'manage_options' ) ) return;
			if ( !isset( $this->classes['settings'] ) )
			{
				if ( !class_exists( 'Molongui\Fw\Includes\Settings' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . '/includes/fw-class-settings.php' );
				$this->classes['settings'] = new Settings( $this->plugin, $this->plugin->settings_map );
			}
			$this->classes['settings']->add_menu_item();
		}
		public function add_page_tabs()
		{
			if ( !current_user_can( 'manage_options' ) ) return;
			if ( !isset( $this->classes['settings'] ) )
			{
				if ( !class_exists( 'Molongui\Fw\Includes\Settings' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . '/includes/fw-class-settings.php' );
				$this->classes['settings'] = new Settings( $this->plugin, $this->plugin->settings_map );
			}
			$this->classes['settings']->add_page_tabs();
		}
		public function display_install_notice()
		{
			$n_content = array();
			$plugin_function = "highlights_plugin";
			$class_name = '\Molongui\\'.$this->plugin->namespace.'\Includes\Highlights';
			if ( !class_exists( $class_name ) ) require_once $this->plugin->dir.'includes/plugin-class-highlights.php';
			if ( method_exists( $class_name, $plugin_function ) )
			{
				$plugin_class = new $class_name();
				$n_content    = $plugin_class->{$plugin_function}();
			}
			if ( empty( $n_content ) ) return;
			$n_slug = 'install';
			$notice = array
			(
				'id'          => $n_slug.'-notice-dismissal',
				'type'        => 'success',
				'content'     => $n_content,
				'dismissible' => $this->plugin->config['notices'][$n_slug]['dismissible'],
				'dismissal'   => $this->plugin->config['notices'][$n_slug]['dismissal'],
				'class'       => 'molongui-notice-activated',
				'pages'       => array
				(
					'dashboard' => 'dashboard',
					'updates'   => 'update-core',
					'plugins'   => 'plugins',
					'plugin'    => 'molongui_page_'.$this->plugin->dashed_name,
				),
			);
			Notice::display( $notice['id'], $notice['type'], $notice['content'], $notice['dismissible'], $notice['dismissal'], $notice['class'], $notice['pages'], $this->plugin->id );
		}
		public function display_whatsnew_notice()
		{
			$n_content = array();
			$current_release = str_replace('.', '', $this->plugin->version );
			$plugin_function = "highlights_release_{$current_release}";
			$class_name = '\Molongui\\'.$this->plugin->namespace.'\Includes\Highlights';
			if ( !class_exists( $class_name ) ) require_once $this->plugin->dir.'includes/plugin-class-highlights.php';
			if ( method_exists( $class_name, $plugin_function ) )
			{
				$plugin_class = new $class_name();
				$n_content    = $plugin_class->{$plugin_function}();
			}
			if ( empty( $n_content ) ) return;
			$n_slug = 'whatsnew';
			$notice = array
			(
				'id'          => $n_slug.'-notice-dismissal',
				'type'        => 'success',
				'content'     => $n_content,
				'dismissible' => $this->plugin->config['notices'][$n_slug]['dismissible'],
				'dismissal'   => $this->plugin->config['notices'][$n_slug]['dismissal'],
				'class'       => 'molongui-notice-whatsnew',
				'pages'       => array
				(
					'dashboard' => 'dashboard',
					'updates'   => 'update-core',
					'plugins'   => 'plugins',
					'plugin'    => 'molongui_page_'.$this->plugin->dashed_name,
				),
			);
			Notice::display( $notice['id'], $notice['type'], $notice['content'], $notice['dismissible'], $notice['dismissal'], $notice['class'], $notice['pages'], $this->plugin->id );
		}
		public function reset_whatsnew_notice( $response, $hook_extra, $result )
		{
			if ( isset( $hook_extra['plugin'] ) and $hook_extra['plugin'] != $this->plugin->basename ) return $result;
			delete_transient( $this->plugin->dashed_name.'-activated' );
			set_transient( $this->plugin->dashed_name.'-updated', 1 );
			$key = molongui_get_constant( $this->plugin->id, 'NOTICES', false );
			$notices = get_option( $key );
			unset( $notices['whatsnew-notice-dismissal'] );
			update_option( $key, $notices );
			return $result;
		}
		public function display_upgrade_notice()
		{
			$n_slug = 'upgrade';
			$notice = array
			(
				'id'          => $n_slug.'-notice-dismissal',
				'type'        => 'info',
				'content'     => array
				(
					'image'   => '',
					'icon'    => '',
					'title'   => sprintf( __( "%sMore features? It's time to upgrade your %s plugin to Premium vesion!%s", 'molongui-common-framework' ),
									'<a href="'.$this->plugin->web.'" target="_blank" >',
									$this->plugin->name,
									'</a>' ),
					'message' => __( 'Extend standard plugin functionality with new great options.', 'molongui-common-framework' ),
					'buttons' => array(),
					'button'  => array
					(
						'id'     => '',
						'href'   => $this->plugin->web,
						'target' => '_blank',
						'class'  => '',
						'icon'   => '',
						'label'  => __( 'Learn more', 'molongui-common-framework' ),
					),
				),
				'dismissible' => $this->plugin->config['notices'][$n_slug]['dismissible'],
				'dismissal'   => $this->plugin->config['notices'][$n_slug]['dismissal'],
				'class'       => 'molongui-notice-orange molongui-notice-icon-star',
				'pages'       => array
				(
					'dashboard' => 'dashboard',
					'updates'   => 'update-core',
					'plugins'   => 'plugins',
					'plugin'    => 'molongui_page_'.$this->plugin->dashed_name,
				),
			);
			if ( isset( $this->plugin->config['cpt'] ) and !empty( $this->plugin->config['cpt'] ) )
			{
				foreach ( $this->plugin->config['cpt'] as $cpt_name => $cpt_id )
				{
					$notice['pages'][$cpt_name]         = $cpt_id;
					$notice['pages']['edit-'.$cpt_name] = 'edit-'.$cpt_id;
				}
			}
			Notice::display( $notice['id'], $notice['type'], $notice['content'], $notice['dismissible'], $notice['dismissal'], $notice['class'], $notice['pages'], $this->plugin->id );
		}
		public function display_rate_notice()
		{
			if ( !isset( $this->plugin->settings['installation_date'] ) )
			{
				$installation = array
				(
					'installation_date'    => time(),
					'installation_version' => $this->plugin->version,
				);

				update_option( molongui_get_constant( $this->plugin->id, 'INSTALLATION', false ), $installation );
				return;
			}
			else
			{
				$installation_date = $this->plugin->settings['installation_date'];
			}
			$threshold_date = strtotime( '+'.$this->plugin->config['notices']['rate']['trigger'].' days', $installation_date );
			if ( !empty( $installation_date ) and ( time() <= $threshold_date ) ) return;
			global $current_user;
			$n_slug = 'rate';
			$notice = array
			(
				'id'          => $n_slug.'-notice-dismissal',
				'type'        => 'info',
				'content'     => array
				(
					'image'   => '',
					'icon'    => '',
					'title'   => sprintf( __( "Like %s?", 'molongui-common-framework' ), $this->plugin->name ),
					'message' => sprintf( __( "Hey %s, hope you're happy with %s plugin. We would really appreciate it if you dropped us a quick rating!", 'molongui-common-framework' ),
										  $current_user->display_name,
						                  $this->plugin->name,
						                  $this->plugin->name ),
					'buttons' => array(),
					'button'  => array
					(
						'id'     => $this->plugin->dashed_name.'-rate-button',
						'href'   => 'https://wordpress.org/support/plugin/'.$this->plugin->dashed_name.'/reviews/?filter=5#new-post',
						'target' => '_blank',
						'class'  => 'molongui-notice-rate-button',
						'icon'   => '',
						'label'  => __( 'Rate plugin', 'molongui-common-framework' ),
					),
				),
				'dismissible' => $this->plugin->config['notices'][$n_slug]['dismissible'],
				'dismissal'   => $this->plugin->config['notices'][$n_slug]['dismissal'],
				'class'       => 'molongui-notice-blue molongui-notice-icon-heart',
				'pages'       => array
				(
					'dashboard' => 'dashboard',
					'updates'   => 'update-core',
					'plugins'   => 'plugins',
					'plugin'    => 'molongui_page_'.$this->plugin->dashed_name,
				),
			);
			if ( isset( $this->plugin->config['cpt'] ) and !empty( $this->plugin->config['cpt'] ) )
			{
				foreach ( $this->plugin->config['cpt'] as $cpt_name => $cpt_id )
				{
					$notice['pages'][$cpt_name]         = $cpt_id;
					$notice['pages']['edit-'.$cpt_name] = 'edit-'.$cpt_id;
				}
			}
			Notice::display( $notice['id'], $notice['type'], $notice['content'], $notice['dismissible'], $notice['dismissal'], $notice['class'], $notice['pages'], $this->plugin->id );
		}
		public function premium_setting_tip( $type = 'full', $default = '' )
		{
			switch ( $type )
			{
				case 'full':
					$tip = sprintf( __( '%sPremium setting%s. You are using the free version of this plugin, so changing this setting will have no effect and default value will be used. Consider purchasing the %sPremium Version%s.', 'molongui-common-framework' ),
						'<strong>',
						'</strong>',
						'<a href="'.$this->plugin->web.'" target="_blank">',
						'</a>' );
					break;

				case 'part':
					$tip = sprintf( __( '%sPremium setting%s. You are using the free version of this plugin, so selecting any option marked as "PREMIUM" will have no effect and default value will be used. Consider purchasing the %sPremium Version%s.', 'molongui-common-framework' ),
						'<strong>',
						'</strong>',
						'<a href="'.$this->plugin->web.'" target="_blank">',
						'</a>' );
					break;

				default:
					$tip = '';
					break;
			}

			return $tip;
		}
		public function validate_license_tab( $input )
		{

			$this->classes['license']->validate_settings( $input );
			$input['plugin_version'] = $this->plugin->version;
			return $input;
		}
		public function validate_advanced_tab( $input )
		{
			$input[ 'plugin_version' ] = $this->plugin->version;
			$pts = molongui_get_post_types( 'all', 'names', false );
			foreach( $pts as $pt )
			{
				if ( !isset( $input['extend_to_'.$pt] ) ) $input['extend_to_'.$pt] = '0';
			}
			if( !$this->plugin->is_premium )
			{
				foreach( $pts as $pt )
				{
					$input['extend_to_'.$pt] = '0';
				}
				$input['extend_to_post'] = '1';
				$input['extend_to_page'] = '1';
				$input['encode_email'] = '0';
				$input['encode_phone'] = '0';
				$input['enable_sc_text_widgets'] = '0';
			}
			return $input;
		}
		public function send_support_ticket()
		{
			check_ajax_referer( 'molongui-ajax-nonce', 'security', true );
			if ( !is_admin() and !isset( $_POST['form'] ) )
			{
				echo 'error';
				wp_die();
			}
			$params = array();
			parse_str( $_POST['form'], $params );
			global $current_user;
			$subject = sprintf( __( '[MOLONGUI] %s: %s', 'molongui-common-framework' ), sanitize_text_field( $params['ticket-id'] ), sanitize_text_field( $params['your-subject'] ) );
			$message = esc_html( $params['your-message'] );
			$headers = array
			(
				'From: '         . $params['your-name'] . ' <' . $params['your-email'] . '>',
				'Reply-To: '     . $params['your-name'] . ' <' . $params['your-email'] . '>',
				'Content-Type: ' . 'text/html; charset=UTF-8',
			);
			$ssr_plugins = $this->classes['sysinfo']->get_plugins();
			$ssr_theme   = $this->classes['sysinfo']->get_active_theme();
			$ssr_client  = $this->classes['sysinfo']->get_client_info();
			$message .= '<br><br><br><p style="font-weight: bold; font-size: 1.25em;">'.__( 'System status report', 'molongui-common-framework' ).'</p>';
			$message .= '<p style="font-weight: bold;">'.__( 'Molongui plugins', 'molongui-common-framework' ).'</p>';
			foreach( $ssr_plugins['molongui'] as $plugin )
			{
				$message .= '<p style="padding-left: 15px;">'.esc_html( $plugin['Name'] ).' '.esc_html( $plugin['Version'] ).' [MFW '.esc_html( $plugin['fw_version'] ).', DBV: '.esc_html( $plugin['db_version'] ).']</p>';
			}
			$message .= '<p style="font-weight: bold;">'.__( 'Active plugins', 'molongui-common-framework' ).'</p>';
			foreach( $ssr_plugins['active'] as $basename => $plugin )
			{
				$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
				$message .= '<p style="padding-left: 15px;"><a href="'.esc_url( $plugin_data['PluginURI'] ).'">'.esc_html( $plugin_data['Name'] ).'</a> ('.esc_html( $plugin_data['Version'] ).')</p>';
			}
			$message .= '<p style="font-weight: bold;">'.__( 'Active theme', 'molongui-common-framework' ).'</p>';
			$message .= '<p style="padding-left: 15px;"><a href="'.esc_html( $ssr_theme['author_url'] ).'">'.esc_html( $ssr_theme['name'] ).'</a> '.esc_html( $ssr_theme['version'] ).( $ssr_theme['is_child_theme'] ? ' (child theme of <a href="'.esc_html( $ssr_theme['parent_author_url'] ).'">'.esc_html( $ssr_theme['parent_name'] ).'</a> '.esc_html( $ssr_theme['parent_version'] ).')' : '' ).'</p>';
			$message .= '<p style="font-weight: bold;">'.__( 'Client browser', 'molongui-common-framework' ).'</p>';
			$message .= '<p style="padding-left: 15px;">'.$ssr_client['browser'].' on '.$ssr_client['platform'].'</p>';
			$message .= '<p style="font-weight: bold;">'.__( 'Current user', 'molongui-common-framework' ).'</p>';
			$message .= '<p style="padding-left: 15px;">'.$current_user->display_name.' with registered e-mail '.$current_user->user_email.'</p>';
			$message .= '<br>--<br>';
			$message .= '<small>'.sprintf( __( "This support ticket was sent from the help request form on User's Dashboard (%s)", 'molongui-common-framework' ), $_POST['domain'] ).'</small>';
			$sent = wp_mail( molongui_get_constant( $this->plugin->id, 'SUPPORT_MAIL', true ), $subject, $message, $headers );
			echo( $sent ? 'sent' : 'error' );
			wp_die();
		}

	}
}