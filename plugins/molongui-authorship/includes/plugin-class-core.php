<?php

namespace Molongui\Authorship\Includes;

use Molongui\Fw\Includes\Loader;
use Molongui\Fw\Includes\DB_Update;
use Molongui\Fw\Includes\i18n;
use Molongui\Fw\Customizer\Customizer;
use Molongui\Fw\Admin\Admin as CommonAdmin;
use Molongui\Fw\FrontEnd\FrontEnd as CommonFrontEnd;
use Molongui\Authorship\Admin\Admin;
use Molongui\Authorship\FrontEnd\FrontEnd;
if ( !defined( 'ABSPATH' ) ) exit;
class Core
{
	protected $plugin;
	protected $loader;
	private $classes;
    public function __construct( $plugin = '' )
    {
	    if ( empty( $plugin ) ) molongui_get_plugin( MOLONGUI_AUTHORSHIP_ID, $this->plugin );
	    else $this->plugin = $plugin;
	    $this->init();
	    $this->update_db();
	    $this->set_locale();
	    $this->load_dependencies();
    }
	private function init()
	{
		if ( !class_exists( 'Molongui\Fw\Includes\Loader' ) ) require_once $this->plugin->dir . 'fw/includes/fw-class-loader.php';
		$this->loader = new Loader();
	}
    private function update_db()
    {
	    if ( !class_exists( 'Molongui\Fw\Includes\DB_Update' ) ) require_once $this->plugin->dir . 'fw/includes/fw-class-db-update.php';
	    $this->classes['update_db'] = new DB_Update( $this->plugin, $this->plugin->db_version );
        if ( $this->classes['update_db']->db_update_needed() ) $this->classes['update_db']->run_update();
    }
    private function set_locale()
    {
		if ( !class_exists( 'Molongui\Fw\Includes\i18n' ) ) require_once $this->plugin->dir . 'fw/includes/fw-class-i18n.php';
        $this->classes['i18n'] = new i18n();
        $this->classes['i18n']->set_domain( $this->plugin->textdomain );

        $this->loader->add_action( 'plugins_loaded', $this->classes['i18n'], 'load_plugin_textdomain' );
    }
    private function check_license()
    {
        if ( $this->plugin->is_premium ) return ( molongui_is_active( $this->plugin->dir ) );
        return true;
    }
    private function load_dependencies()
    {
	    if ( is_admin() ) $this->load_backend_dependencies();
	    if ( $this->check_license() ) $this->load_frontend_dependencies();
	    $this->load_customizer_dependencies();
    }
	private function load_backend_dependencies()
	{
		$this->load_fw_backend_dependencies();
		$this->load_plugin_backend_dependencies();
	}
	private function load_frontend_dependencies()
	{
		$this->load_fw_frontend_dependencies();
		$this->load_plugin_frontend_dependencies();
	}
	private function load_customizer_dependencies()
	{
		$config = include $this->plugin->dir . "config/config.php";
		if ( $config['customizer']['enable'] )
		{
			if ( !class_exists( 'Molongui\Fw\Customizer\Customizer' ) ) require_once( $this->plugin->dir . 'fw/customizer/fw-class-customizer.php' );
			new Customizer( $this->plugin );
		}
	}
	private function load_fw_backend_dependencies()
	{
		if ( !class_exists( 'Molongui\Fw\Admin\Admin' ) ) require_once $this->plugin->dir . 'fw/admin/fw-class-admin.php';
		new CommonAdmin( $this->plugin, $this->loader );
	}
	private function load_plugin_backend_dependencies()
	{
		require_once $this->plugin->dir . 'admin/plugin-class-admin.php';
		new Admin( $this->plugin, $this->loader );
	}
	private function load_fw_frontend_dependencies()
	{
		if ( !class_exists( 'Molongui\Fw\FrontEnd\FrontEnd' ) ) require_once $this->plugin->dir . 'fw/public/fw-class-public.php';
		new CommonFrontEnd( $this->plugin, $this->loader );
	}
	private function load_plugin_frontend_dependencies()
	{
		require_once $this->plugin->dir . 'public/plugin-class-public.php';
		new FrontEnd( $this->plugin, $this->loader );
	}
    public function run()
    {
        $this->loader->run();
    }
	public function get_plugin()
	{
		return $this->plugin;
	}
    public function get_plugin_name()
    {
        return $this->plugin->id;
    }
    public function get_version()
    {
        return $this->plugin->version;
    }
    public function get_loader()
    {
        return $this->loader;
    }
}