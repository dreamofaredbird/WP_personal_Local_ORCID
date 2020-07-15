<?php

use Molongui\Fw\Includes\Dependencies;
use Molongui\Fw\Includes\Compatibility;
use Molongui\Authorship\Includes\Activator;
use Molongui\Authorship\Includes\Deactivator;
use Molongui\Authorship\Includes\Core;

// Deny direct access to this file.
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin admin area. This file also includes
 * all of the dependencies used by the plugin, registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * Plugin Name:       Molongui Authorship
 * Plugin URI:        https://www.molongui.com/product/authorship
 * Description:       Complete suite on all about authors and authorship: Co-authors, guest authors, author box and local avatar. Four plugins in one... 4 in 1!
 * Text Domain:       molongui-authorship
 * Domain Path:       /i18n/
 * Version:           3.2.25
 * Requires at least: 4.5.0
 * Tested up to:      5.3.2
 * Author:            Amitzy
 * Author URI:        https://www.molongui.com/
 * Plugin Base:       _boilerplate 2.1.0
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * This plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or any later version.
 *
 * This plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this plugin. If not,
 * see http://www.gnu.org/licenses/.
 *
 * @author     Amitzy
 * @category   plugin
 * @package    Authorship
 * @license    GPL-3.0+
 * @since      1.0.0
 * @version    3.2.0
 */

if( !class_exists( 'molongui_authorship' ) )
{
    class molongui_authorship
    {
	    /**
	     * The object that holds all the information regarding the plugin.
	     *
	     * @access  protected
	     * @var     object     $plugin  Maintains all plugin information.
	     * @since   3.2.0
	     * @version 3.2.0
	     */
	    protected $plugin;

	    /**
	     * Dependencies class.
	     *
	     * @since   3.1.3
	     * @version 3.1.3
	     */
	    private $dependencies;

	    /**
         * Framework compatibility class.
         *
         * @since   1.0.0
         * @version 1.0.0
         */
        private $compatibility;

        /**
         * The constructor.
         *
         * Initializes the plugin by setting localization, filters, and administration functions.
         *
         * @since   1.0.0
         * @version 1.0.0
         */
        function __construct()
        {
	        /**
	         * Loads configuration.
	         *
	         * NOTE: Load order is important => First load plugin config, then fw config.
	         *
	         * @since   1.0.0
	         * @version 3.2.0
	         */
	        require_once( plugin_dir_path( __FILE__ ) . 'config/plugin.php' );
	        require_once( plugin_dir_path( __FILE__ ) . 'fw/config/fw.php'  );

	        /**
	         * Loads the file responsible for defining common helper functions.
	         *
	         * @since   1.0.0
	         * @version 3.2.0
	         */
	        require_once( plugin_dir_path( __FILE__ ) . 'fw/includes/fw-helper-functions.php' );

	       /**
	         * Initializes plugin information.
	         *
	         * @since   3.2.0
	         * @version 3.2.0
	         */
	        molongui_get_plugin( MOLONGUI_AUTHORSHIP_ID, $this->plugin );

			/**
			 * Dependencies check.
			 *
			 * Does not let the plugin be activated if dependencies are not installed and active.
			 *
			 * @since   3.1.3
			 * @version 3.2.0
			 */
			require_once( plugin_dir_path( __FILE__ ) . 'fw/includes/fw-class-dependencies.php' );
			$this->dependencies = new Dependencies( $this->plugin );
			if ( !$this->dependencies->check() ) return;

            /**
             * Sanity check.
             *
             * Do not let the plugin be activated when another instance is already installed.
             *
             * @since   1.0.0
             * @version 1.3.0
             */
            require_once( plugin_dir_path( __FILE__ ) . 'fw/includes/fw-class-compatibility.php' );
            $this->compatibility = new Compatibility( $this->plugin );
            if ( !$this->compatibility->compatible_version() ) return;

	        /**
	         * Loads plugin activation library.
	         *
	         * @since   2.0.7
	         * @version 3.2.0
	         */
	        require_once( $this->plugin->dir . 'includes/plugin-class-activator.php' );

	        /**
             * Registers hooks that are fired when the plugin is activated and deactivated,
             * respectively.
             *
             * @since   1.0.0
             * @version 1.0.0
             */
            register_activation_hook( __FILE__, array( $this, 'activate' ) );
            register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

	        /**
	         * Initializes the plugin on every new blog is created (if plugin is network-activated).
	         *
	         * @since   2.0.7
	         * @version 2.0.7
	         */
	        add_action( 'wpmu_new_blog', array( $this, 'activate_on_new_blog' ), 10, 6 );

            /**
			 * Loads the class that is used to define internationalization,
             * admin-specific hooks and public-facing site hooks.
             *
             * @since   1.0.0
             * @version 3.2.0
             */
	        require_once( $this->plugin->dir . 'includes/plugin-class-core.php' );

	        /**
             * Begins execution of the plugin.
             *
             * Since everything within the plugin is registered via hooks,
             * then kicking off the plugin from this point in the file does
             * not affect the page life cycle.
             *
             * @since   1.0.0
             * @version 1.0.0
             */
            $core = new Core( $this->plugin );
	        $core->run();
        }

        /**
         * Fires all required actions during plugin activation.
         *
         * This action is documented in includes/plugin-class-activator.php
         *
         * @access  public
         * @param   bool    $network_wide   Whether to enable the plugin for all sites in the network or just the current site. Multisite only. Default is false.
         * @since   1.0.0
         * @version 2.0.7
         */
        public function activate( $network_wide )
        {
            $this->compatibility->activation_check();
            Activator::activate( $network_wide );
        }

        /**
         * Fires all required actions during plugin deactivation.
         *
         * This action is documented in includes/plugin-class-deactivator.php
         *
         * @access  public
         * @param   bool    $network_wide   Whether to disable the plugin for all sites in the network or just the current site. Multisite only. Default is false.
         * @since   1.0.0
         * @version 2.0.7
         */
        public function deactivate( $network_wide )
        {
            require_once MOLONGUI_AUTHORSHIP_DIR . 'includes/plugin-class-deactivator.php';
            Deactivator::deactivate( $network_wide );
        }

	    /**
	     * Initializes the plugin on every new blog is created (if plugin is network-activated).
	     *
	     * @access  public
	     * @param   int    $blog_id Blog ID.
	     * @param   int    $user_id User ID.
	     * @param   string $domain  Site domain.
	     * @param   string $path    Site path.
	     * @param   int    $site_id Site ID. Only relevant on multi-network installs.
	     * @param   array  $meta    Meta data. Used to set initial site options.
	     * @since   2.0.7
	     * @version 2.0.7
	     */
	    public function activate_on_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta )
	    {
		    Activator::activate_on_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta );
	    }

    } // class
} // class_exists

/**
 * Runs the plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
if ( class_exists( 'molongui_authorship' ) )
{
    $plugin = new molongui_authorship();
}