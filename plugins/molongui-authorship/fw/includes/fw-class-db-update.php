<?php

namespace Molongui\Fw\Includes;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\Includes\DB_Update' ) )
{
	class DB_Update
	{
		private $plugin;
		protected $target_version;
		public function __construct( $plugin, $target_version )
		{
			if ( is_object( $plugin ) ) $this->plugin = $plugin;
			else molongui_get_plugin( $plugin, $this->plugin );
			$this->target_version = $target_version;
		}
		public function db_update_needed()
		{
			$current_version = get_option( $this->plugin->db_settings );
			if ( empty( $current_version ) )
			{
				update_option( $this->plugin->db_settings, $this->target_version );
				return false;
			}
			if ( $current_version >= $this->target_version ) return false;
			return true;
		}
		public function run_update()
		{
			$current_db_ver = get_option( $this->plugin->db_settings, 1 );
			$target_db_ver = $this->target_version;
			while ( $current_db_ver < $target_db_ver )
			{
				$current_db_ver ++;
				$func = "db_update_{$current_db_ver}";
				if ( !class_exists( '\Molongui\\'.ucfirst($this->plugin->namespace).'\Includes\DB_Update' ) ) require_once $this->plugin->dir . 'includes/plugin-class-db-update.php';
				if ( method_exists( '\Molongui\\'.ucfirst($this->plugin->namespace).'\Includes\DB_Update', $func ) )
				{
					$class_name   = '\Molongui\\'.ucfirst($this->plugin->namespace).'\Includes\DB_Update';
					$plugin_class = new $class_name();
					$plugin_class->{$func}();
				}
				update_option( $this->plugin->db_settings, $current_db_ver );
			}
		}
	}
}