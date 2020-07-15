<?php

namespace Molongui\Fw\Includes;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\Includes\Dependencies' ) )
{
	class Dependencies
	{
		protected $plugin;
		private $error;
		public function __construct( $plugin )
		{
			$this->plugin = $plugin;
		}
		public function check()
		{
			$config = require_once( $this->plugin->dir . 'config/config.php' );
			if ( !isset( $this->plugin->config['dependencies'] ) or empty( $this->plugin->config['dependencies'] ) ) return true;
			foreach ( $this->plugin->config['dependencies'] as $type => $dependencies )
			{
				if ( empty( $dependencies ) ) continue;

				foreach ( $dependencies as $key => $dependency )
				{
					if ( !in_array( $dependency['basename'], apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
					{
						$this->error['type'] = $type;
						$this->error['name'] = $key;
						add_action( 'admin_notices', array( $this, 'disabled_notice' ), 100 );
						return false;
					}
					else
					{
						$dependency_data = get_file_data( WP_PLUGIN_DIR.'/'.$dependency['basename'], array
						(
							'Version' => 'Version'
						));

						if ( version_compare( $dependency_data['Version'], $dependency['version'], '<' ) )
						{
							$this->error['type']    = $type;
							$this->error['name']    = $key;
							$this->error['version'] = $dependency['version'];
							add_action( 'admin_notices', array( $this, 'version_notice' ), 100 );
							return false;
						}
					}
				}
			}
			return true;
		}
		public function disabled_notice()
		{
			if ( !current_user_can( 'manage_options' ) ) return;
			$fw_config = include molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'config/config.php';
			$n_slug = 'missing-dependency';
			$notice = array
			(
				'id'          => $n_slug.'-notice-dismissal',
				'type'        => 'error',
				'content'     => array
				(
					'image'   => '',
					'title'   => __( 'Plugin disabled', 'molongui-common-framework' ),
					'message' => sprintf( __( '%s%s%s has been disabled because %s %s is not active. Please, install/activate %s to enable %s.', 'molongui-common-framework' ),
								'<strong>', $this->plugin->name, '</strong>',
									ucwords( $this->error['name'] ), $this->error['type'],
									ucwords( $this->error['name'] ), $this->plugin->name ),
					'buttons' => array(),
					'button'  => array
					(
						'id'     => '',
						'href'   => admin_url( 'plugins.php' ),
						'target' => '_self',
						'class'  => '',
						'icon'   => '',
						'label'  => __( 'Manage plugins', 'molongui-common-framework' ),
					),
				),
				'dismissible' => $this->plugin->config['notices'][$n_slug]['dismissible'],
				'dismissal'   => $this->plugin->config['notices'][$n_slug]['dismissal'],
				'class'       => 'molongui-notice-red molongui-notice-icon-alert',
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
			molongui_display_notice( $this->plugin->id, $notice );
		}
		public function version_notice()
		{
			$fw_config = include molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'config/config.php';
			$n_slug = 'missing-version';
			$notice = array
			(
				'id'          => $n_slug.'-notice-dismissal',
				'type'        => 'error',
				'content'     => array
				(
					'image'   => '',
					'title'   => __( 'Plugin disabled', 'molongui-common-framework' ),
					'message' => sprintf( __( '%s%s%s has been disabled because the minimum required version of the %s %s is %s. Please, update %s to enable %s.', 'molongui-common-framework' ),
									'<strong>', $this->plugin->name, '</strong>',
									ucwords( $this->error['name'] ), $this->error['type'], $this->error['version'],
									ucwords( $this->error['name'] ), $this->plugin->name ),
					'buttons' => array(),
					'button'  => array
					(
						'id'     => '',
						'href'   => admin_url( 'plugins.php' ),
						'target' => '_self',
						'class'  => '',
						'icon'   => '',
						'label'  => __( 'Manage plugins', 'molongui-common-framework' ),
					),
				),
				'dismissible' => $this->plugin->config['notices'][$n_slug]['dismissible'],
				'dismissal'   => $this->plugin->config['notices'][$n_slug]['dismissal'],
				'class'       => 'molongui-notice-red molongui-notice-icon-alert',
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
			molongui_display_notice( $this->plugin->id, $notice );
		}
	} // class
} // class_exists