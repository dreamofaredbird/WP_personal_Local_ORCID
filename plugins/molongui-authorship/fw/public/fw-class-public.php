<?php

namespace Molongui\Fw\FrontEnd;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\FrontEnd\FrontEnd' ) )
{
    class FrontEnd
    {
	    protected $plugin;
	    protected $loader;
        public function __construct( $plugin, $loader )
        {
	        $this->plugin = $plugin;
	        $this->loader = $loader;
	        $this->load_dependencies();
	        $this->define_hooks();
        }
        private function load_dependencies()
        {
	        if ( $this->plugin->is_premium ) $this->load_premium_dependencies();
        }
        private function load_premium_dependencies()
        {
        }
	    private function define_hooks()
	    {
		    $this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
		    $this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );
	    }
        public function enqueue_styles()
        {
	        $fw_dir = molongui_get_constant( $this->plugin->id, 'DIR', true );
            $file = 'public/css/mcf-common.58c1.min.css';
            if ( file_exists( $fw_dir.$file ) )
            {
	            $fw_url     = molongui_get_constant( $this->plugin->id, 'URL', true );
	            $fw_version = molongui_get_constant( $this->plugin->id, 'VERSION', true );
            	wp_enqueue_style( 'molongui-common-framework', $fw_url.$file, array(), $fw_version, 'all' );
            }
        }
        public function enqueue_scripts( $hook )
        {
	        $fw_dir = molongui_get_constant( $this->plugin->id, 'DIR', true );
	        $file = 'public/js/mcf-common.xxxx.min.js';
	        if ( file_exists( $fw_dir.$file ) )
	        {
		        $fw_url     = molongui_get_constant( $this->plugin->id, 'URL', true );
		        $fw_version = molongui_get_constant( $this->plugin->id, 'VERSION', true );
	        	wp_enqueue_script( 'molongui-common-framework', $fw_url.$file, array( 'jquery' ), $fw_version, true );
	        }
        }

    }
}