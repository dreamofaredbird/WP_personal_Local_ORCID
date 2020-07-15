<?php
if ( !defined( 'ABSPATH' ) ) exit;
if ( !function_exists( 'molongui_get_constant' ) )
{
    function molongui_get_constant( $plugin_id, $constant, $fw = false )
    {
	    $value = ( constant( "MOLONGUI_" . strtoupper( str_replace( ' ', '_', $plugin_id ) ) . "_" . ( $fw ? "FW_" : "" ) . strtoupper( $constant ) ) );
	    if ( !isset( $value ) ) return false;
	    return $value;
    }
}
if ( !function_exists( 'molongui_get_plugin' ) )
{
    function molongui_get_plugin( $id, &$plugin )
    {
        if ( !isset( $plugin ) ) $plugin = new stdClass();
	    $plugin->dashed_id        = strtolower( str_replace( ' ', '-', $id ) ); // plugin-name
	    $plugin->underscored_id   = strtolower( str_replace( ' ', '_', $id ) ); // plugin_name
	    $plugin->dashed_name      = 'molongui-' . $plugin->dashed_id;                          // molongui-plugin-name
	    $plugin->underscored_name = 'molongui_' . $plugin->underscored_id;                     // molongui_plugin_name
        $prefix = 'MOLONGUI_' . strtoupper( $plugin->underscored_id ) . '_';                   // MOLONGUI_PLUGIN_NAME_

        $plugin->name          = constant( $prefix . "NAME" );
        $plugin->id            = constant( $prefix . "ID" );
        $plugin->version       = constant( $prefix . "VERSION" );
        $plugin->dir           = constant( $prefix . "DIR" );
        $plugin->url           = constant( $prefix . "URL" );
        $plugin->basename      = constant( $prefix . "BASENAME" );
	    $plugin->namespace     = constant( $prefix . "NAMESPACE" );
        $plugin->textdomain    = constant( $prefix . "TEXTDOMAIN" );
        $plugin->is_premium    = molongui_is_premium( $plugin->dir );
        $plugin->is_upgradable = molongui_is_premium( $plugin->dir ) ? false : constant( $prefix . "UPGRADABLE" );
        $plugin->web           = constant( $prefix . "WEB" );
        $plugin->db_version    = constant( $prefix . "DB_VERSION" );
        $plugin->db_prefix     = constant( $prefix . "DB_PREFIX" );
        $plugin->db_settings   = constant( $prefix . "DB_SETTINGS" );
	    $plugin->config = include( $plugin->dir . 'config/config.php' );
	    if ( $plugin->is_premium ) $plugin->update = include( $plugin->dir . 'premium/config/update.php' );
	    $plugin->settings = array();
	    global $wpdb;
	    $settings_keys = $wpdb->get_col( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '{$plugin->db_prefix}%'" );
	    foreach ( $settings_keys as $key )
	    {
		    if ( !in_array( substr( $key, strlen( $plugin->db_prefix )+1 ), array( 'db_version', 'activated', 'instance', 'license', 'product_id', 'version' ) ) )
		    {
		        $settings_values = get_option( $key );
			    if ( is_array( $settings_values ) )
                {
                    $plugin->settings = array_merge( $plugin->settings, $settings_values );
                }
                else
                {
	                $plugin->settings[substr( $key, strlen( $plugin->db_prefix )+1 )] = $settings_values;
                }
		    }
	    }
    }
}
if ( !function_exists( 'molongui_is_premium' ) )
{
    function molongui_is_premium( $plugin_dir )
    {
        $path = $plugin_dir.'premium';

        if ( file_exists( $path ) ) return true;

        return false;
    }
}
if ( !function_exists( 'molongui_is_active' ) )
{
    function molongui_is_active( $plugin_dir )
    {
        if ( file_exists( $file = $plugin_dir.'premium/config/update.php' ) ) $config = include $file;

        return ( get_option( $config['db']['activated_key'] ) == 'Activated' ? true : false );
    }
}
if ( !function_exists( 'molongui_display_notice' ) )
{
	function molongui_display_notice( $plugin_id, $notice )
	{
		if ( empty( $notice ) ) return;
		$fw_dir     = molongui_get_constant( $plugin_id, 'DIR', true );
		$fw_url     = molongui_get_constant( $plugin_id, 'URL', true );
		$fw_version = molongui_get_constant( $plugin_id, 'VERSION', true );
		$file = 'admin/css/mcf-notices.bb7b.min.css';
		if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-notices', $fw_url.$file, array(), $fw_version, 'all' );
		$file = 'admin/css/mcf-font.6346.min.css';
		if ( file_exists( $fw_dir.$file ) ) wp_enqueue_style( 'mcf-font', $fw_url.$file, array(), $fw_version, 'all' );
		if ( !class_exists( 'Molongui\Fw\Includes\Notice' ) ) require_once $fw_dir . '/includes/fw-class-notice.php';
		Molongui\Fw\Includes\Notice::display( $notice['id'], $notice['type'], $notice['content'], $notice['dismissible'], $notice['dismissal'], $notice['class'], $notice['pages'], $plugin_id );
	}
}
if ( !function_exists( 'molongui_help_tip' ) )
{
    function molongui_help_tip( $tip, $allow_html = false )
    {
        if ( $allow_html )
        {
            $tip = molongui_sanitize_tooltip( $tip );
        }
        else
        {
            $tip = esc_attr( $tip );
        }
        return '<i class="molongui-icon-tip molongui-help-tip" data-tip="' . $tip . '"></i>';
    }
}
if ( !function_exists( 'molongui_sanitize_tooltip' ) )
{
    function molongui_sanitize_tooltip( $var )
    {
        return htmlspecialchars( wp_kses( html_entity_decode( $var ), array(
            'br'     => array(),
            'em'     => array(),
            'strong' => array(),
            'small'  => array(),
            'span'   => array(),
            'ul'     => array(),
            'li'     => array(),
            'ol'     => array(),
            'p'      => array(),
        ) ) );
    }
}
if ( !function_exists( 'molongui_request_data' ) )
{
    function molongui_request_data( $url )
    {
        $response = null;
	    $args = array
        (
		    'method'      => 'GET',
		    'timeout'     => 20,
		    'redirection' => 10,
		    'httpversion' => '1.1',
		    'sslverify'   => false,
        );
	    $response = wp_remote_get( $url, $args );
	    if( is_wp_error( $response ) or !isset( $response ) or empty( $response ) )
	    {

		    $response = 0;
	    }
	    else
	    {
		    $response = unserialize( wp_remote_retrieve_body( $response ) );
	    }
        return $response;
    }
}
if ( !function_exists( 'molongui_curl' ) )
{
    function molongui_curl( $url )
    {
        $curl = curl_init( $url );

        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HEADER, 0 );
        curl_setopt( $curl, CURLOPT_USERAGENT, '' );
        curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );

        $response = curl_exec( $curl );
        if( 0 !== curl_errno( $curl ) || 200 !== curl_getinfo( $curl, CURLINFO_HTTP_CODE ) )
        {
            $response = null;
        }
        curl_close( $curl );

        return $response;
    }
}
if ( !function_exists( 'molongui_is_bool' ) )
{
    function molongui_is_bool( $var )
    {
        if ( '0' === $var or '1' === $var ) return true;

        return false;
    }
}
if ( !function_exists( 'molongui_get_post_types' ) )
{
    function molongui_get_post_types( $type = 'all', $output = 'names', $setting = false )
    {
        $wp_post_types     = ( ( $type == 'wp'  or $type == 'all' ) ? get_post_types( array( 'public' => true, '_builtin' => true ), $output )  : array() );
        $custom_post_types = ( ( $type == 'cpt' or $type == 'all' ) ? get_post_types( array( 'public' => true, '_builtin' => false ), $output ) : array() );
        $post_types = array_merge( $wp_post_types, $custom_post_types );
        if ( $setting )
        {
            $options = array();

            foreach ( $post_types as $post_type )
            {
                $options[] = array( 'id' => $post_type->name, 'label' => $post_type->labels->name );
            }

            return $options;
        }
        return $post_types;
    }
}
if ( !function_exists('molongui_supported_post_types') )
{
    function molongui_supported_post_types( $plugin_id, $type = 'all', $setting = false )
    {
        $post_types = $options = array();
        $advanced_settings = (array) get_option( molongui_get_constant( $plugin_id, 'ADVANCED_SETTINGS', false ) );
        foreach( molongui_get_post_types( $type, 'objects', false ) as $post_type_name => $post_type_object )
        {
            if ( isset( $advanced_settings['extend_to_'.$post_type_name] ) and $advanced_settings['extend_to_'.$post_type_name] )
            {
                $post_types[] = $post_type_name;
                $options[]    = array( 'id' => $post_type_name, 'label' => $post_type_object->labels->name );
            }
        }
        return ( $setting ? $options : $post_types );
    }
}
if ( !function_exists('molongui_post_categories') )
{
    function molongui_post_categories( $setting = false )
    {
        $categories = $options = array();
	    $post_categories = get_categories( array
        (
		    'orderby' => 'name',
            'order'   => 'ASC',
	    ));
        foreach( $post_categories as $category )
        {
	        $categories[] = $category->name;
            $options[]    = array( 'id' => $category->cat_ID, 'label' => $category->name );
        }
        return ( $setting ? $options : $categories );
    }
}
if ( !function_exists('molongui_is_post_type_enabled') )
{
    function molongui_is_post_type_enabled( $plugin, $post_type = null )
    {
        if ( !$post_type ) $post_type = get_post_type();

        return (bool) in_array( $post_type, molongui_supported_post_types( $plugin, 'all' ) );
    }
}
if ( !function_exists( 'molongui_debug' ) )
{
    function molongui_debug( $vars, $backtrace = false, $in_admin = true, $die = false, $check = true )
    {
        if ( $check )
        {
	        if ( !function_exists( 'is_user_logged_in' ) or !function_exists( 'current_user_can' ) )
	        {
		        echo "<pre>";
		        _e( 'Too early to run molongui_debug() function. Sorry...', 'molongui-common-framework' );
		        echo "</pre>";

		        return;
	        }
	        if ( !is_user_logged_in() and !current_user_can( 'administrator' ) ) return;
        }
	    if ( !$in_admin and is_admin() ) return;
	    echo '<pre style="' . ( is_admin() ? 'padding-left: 180px;' : '' ) . '">';
	    if ( $backtrace )
        {
	        $dbt  = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2 );
	        $info = array
            (
                'file'        => ( isset( $dbt[0]['file'] ) ? $dbt[0]['file'] : '' ),
                'class'       => ( isset( $dbt[1]['class'] ) ? $dbt[1]['class'] : '' ),
                'function'    => ( isset( $dbt[1]['function'] ) ? $dbt[1]['function'] : '' ),
                'filter'      => current_filter(),
                'in_the_loop' => in_the_loop(),
                'backtrace'   => array_reverse( wp_debug_backtrace_summary( null, 0, false ) ),
            );
	        $vars = array_merge( $info, ( is_array( $vars ) ? $vars : (array)$vars ) );
        }
        print_r( $vars );
        echo "</pre>";
        if ( $die ) die;
    }
}
if ( !function_exists( 'molongui_get_sites' ) )
{
    function molongui_get_sites()
    {
	    if ( function_exists( 'get_sites' ) && function_exists( 'get_current_network_id' ) )
	    {
		    $site_ids = get_sites( array( 'fields' => 'ids', 'network_id' => get_current_network_id() ) );
	    }
	    else
	    {
		    global $wpdb;
		    $site_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE site_id = $wpdb->siteid;" );
	    }

	    return $site_ids;
    }
}
if ( !function_exists( 'molongui_get_acronym' ) )
{
    function molongui_get_acronym ( $words, $length = 3 )
    {
        $acronym = '';
        foreach ( explode( ' ', $words ) as $word ) $acronym .= mb_substr( $word, 0, 1, 'utf-8' );

        return strtoupper( mb_substr( $acronym, 0, $length ) );
    }
}
if ( !function_exists( 'molongui_let_to_num' ) )
{
    function molongui_let_to_num( $size )
    {
        $l   = substr( $size, - 1 );
        $ret = substr( $size, 0, - 1 );
        switch ( strtoupper( $l ) )
        {
            case 'P':
                $ret *= 1024;
            case 'T':
                $ret *= 1024;
            case 'G':
                $ret *= 1024;
            case 'M':
                $ret *= 1024;
            case 'K':
                $ret *= 1024;
        }

        return $ret;
    }
}
if ( !function_exists( 'molongui_get_ip' ) )
{
    function molongui_get_ip()
    {
        $ip = '127.0.0.1';

        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) )
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif( !empty( $_SERVER['REMOTE_ADDR'] ) )
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return apply_filters( 'molongui_get_ip', $ip );
    }
}
if ( !function_exists( 'molongui_get_base64_svg' ) )
{
    function molongui_get_base64_svg( $svg, $base64 = true )
    {
        if ( $base64 )
        {
            return 'data:image/svg+xml;base64,' . base64_encode( $svg );
        }

        return $svg;
    }
}
if ( !function_exists( 'molongui_clean' ) )
{
    function molongui_clean( $var )
    {
        if ( is_array( $var ) ) return array_map( 'molongui_clean', $var );
        else return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
    }
}
if ( !function_exists( 'molongui_sort_array' ) )
{
    function molongui_sort_array( $array = array(), $order = 'ASC', $orderby = 'key' )
    {
        if ( empty( $array ) ) return $array;
        switch ( $orderby )
        {
            case 'key':
                ksort( $array );
            break;

            default:
                usort( $array , function ( $item1, $item2 ) use ( $orderby )
                {
                    if ( $item1[$orderby] == $item2[$orderby] ) return 0;
                    return $item1[$orderby] < $item2[$orderby] ? -1 : 1;
                });
            break;
        }
        if ( 'desc' === strtolower( $order ) ) $array = array_reverse( $array );
        return $array;
    }
}
if ( !function_exists( 'molongui_parse_array_attribute' ) )
{
    function molongui_parse_array_attribute( $string )
    {
        $no_whitespaces = preg_replace( '/\s*,\s*/', ',', filter_var( $string, FILTER_SANITIZE_STRING ) );
        $array = explode( ',', $no_whitespaces );
        return $array;
    }
}
if ( !function_exists( 'molongui_display_badge' ) )
{
	function molongui_display_badge( $label, $is_premium, $href = '', $echo = true )
    {
	    $badge  = '';
	    $badge .= '<span class="molongui-badge ' . ( $is_premium ? '' : 'molongui-badge-premium' ) . '">';
	    $badge .= ( !empty( $href ) ? '<a href="'.$href.'" target="_blank">' : '' );
	    $badge .= $label;
	    $badge .= ( !empty( $href ) ? '</a>' : '' );
	    $badge .= '</span>';

        if ( $echo ) echo $badge;
        else return $badge;
    }
}
if ( !function_exists( 'molongui_ascii_encode' ) )
{
	function molongui_ascii_encode( $input )
	{
		$output = '';
		for ( $i = 0; $i < strlen( $input ); $i++ ) $output .= '&#'.ord( $input[$i] ).';';
		return $output;
	}
}
if ( !function_exists( 'molongui_get_plugin_settings' ) )
{
	function molongui_get_plugin_settings( $id = '', $names = '' )
    {
        if ( empty( $id ) or empty( $names ) ) return;
        $settings = array();
        if ( is_array( $names ) ) foreach ( $names as $name ) $settings = array_merge( $settings, get_option( molongui_get_constant( $id, $name.'_SETTINGS', false ) ) );
        else $settings = get_option( molongui_get_constant( $id, $names.'_SETTINGS', false ) );
        return $settings;
    }
}
if ( !function_exists( 'molongui_get_our_plugins' ) )
{
	function molongui_get_our_plugins( $plugins = array() )
    {
        $molonguis = array();
        $plugin    = new StdClass();
        if ( empty( $plugins ) ) $plugins = get_plugins();
        foreach ( $plugins as $filepath => $data )
        {
            if ( $data['Author'] == 'Amitzy' )
            {
                $plugin_id = explode( '/', $filepath );
	            $plugin_id = substr( $plugin_id[1], 0 , -4 );
	            $plugin_id = str_replace( 'molongui-', '' , $plugin_id );
	            $plugin_id = str_replace( '-', '_' , $plugin_id );
	            if ( !is_plugin_active( $filepath ) ) continue;
	            if ( $plugin_id == "bump_offer" ) $plugin_id = "order_bump";
	            molongui_get_plugin( $plugin_id, $plugin );
	            $data['id']            = $plugin_id;
	            $data['is_premium']    = $plugin->is_premium;
	            $data['is_upgradable'] = $plugin->is_upgradable;
	            $data['fw_name']       = molongui_get_constant( $plugin_id, "NAME", true );
	            $data['fw_version']    = molongui_get_constant( $plugin_id, "VERSION", true );
	            $data['db_version']    = $plugin->db_version;
	            $data['settings']      = $plugin->settings;
	            $molonguis[$filepath] = $data;
            }
        }
        return $molonguis;
    }
}
if ( !function_exists( 'molongui_enqueue_tiptip' ) )
{
	function molongui_enqueue_tiptip()
    {
	    if ( !wp_script_is( 'molongui-tiptip', 'enqueued' ) )
	    {
		    $version = '1.3';
            $tiptip_js_url  = plugins_url( '/', plugin_dir_path( __FILE__ ) ).'admin/js/tipTip.min.js';
            $tiptip_css_url = plugins_url( '/', plugin_dir_path( __FILE__ ) ).'admin/css/tipTip.min.css';
            wp_enqueue_script( 'molongui-tiptip', $tiptip_js_url, array( 'jquery' ), $version, true );
            wp_enqueue_style( 'molongui-tiptip', $tiptip_css_url, array(), $version, 'all' );
		    wp_add_inline_script( 'molongui-tiptip',
                "
                    jQuery(document).ready(function($)
                    {
                        var tiptip_args =
                        {
                            attribute:       'data-tip',
                            defaultPosition: 'top',
                            fadeIn:           50,
                            fadeOut:          50,
                            delay:            200,
                        };
                        $( '.tips, .help_tip, .molongui-tip, .molongui-help-tip' ).tipTip( tiptip_args );
                    });
                "
            );
        }
    }
}
if ( !function_exists( 'molongui_enqueue_sweetalert' ) )
{
	function molongui_enqueue_sweetalert()
    {
	    if ( !wp_script_is( 'molongui-sweetalert', 'enqueued' ) )
	    {
		    $version = '2.1.2';
		    $sweetalert_js_url = 'https://cdn.jsdelivr.net/npm/sweetalert@'.$version.'/dist/sweetalert.min.js';
		    wp_enqueue_script( 'molongui-sweetalert', $sweetalert_js_url, array( 'jquery' ), $version, true );
		    wp_add_inline_script( 'molongui-sweetalert', 'var molongui_swal = swal;' );
	    }
    }
}
if ( !function_exists( 'molongui_enqueue_selectr' ) )
{
	function molongui_enqueue_selectr()
    {
	    if ( !wp_script_is( 'molongui-selectr', 'enqueued' ) )
	    {
		    $version = '2.4.8';
		    $selectr_js_url  = 'https://cdn.jsdelivr.net/npm/mobius1-selectr@'.$version.'/dist/selectr.min.js';
		    $selectr_css_url = 'https://cdn.jsdelivr.net/npm/mobius1-selectr@'.$version.'/dist/selectr.min.css';
		    wp_enqueue_script( 'molongui-selectr', $selectr_js_url, array(), $version, true );
		    wp_enqueue_style( 'molongui-selectr', $selectr_css_url, array(), $version, 'all' );
		    wp_add_inline_script( 'molongui-selectr', 'var MolonguiSelectr = Selectr; Selectr = undefined;' );
	    }
    }
}
if ( !function_exists( 'molongui_enqueue_select2' ) )
{
	function molongui_enqueue_select2()
    {
	    if ( !wp_script_is( 'molongui-select2', 'enqueued' ) )
	    {
		    $version = '4.0.5';
		    $select2_js_url  = 'https://cdnjs.cloudflare.com/ajax/libs/select2/'.$version.'/js/select2.min.js';
		    $select2_css_url = 'https://cdnjs.cloudflare.com/ajax/libs/select2/'.$version.'/css/select2.min.css';
		    wp_enqueue_script( 'molongui-select2', $select2_js_url, array(), $version, true );
		    wp_enqueue_style( 'molongui-select2', $select2_css_url, array(), $version, 'all' );
		    wp_add_inline_script( 'molongui-select2',
                'var molongui_select2 = jQuery.fn.select2; delete jQuery.fn.select2;' .
                "
                    jQuery(document).ready(function($)
                    {
                        if ( typeof molongui_select2 !== 'undefined' )
                        {
                            molongui_select2.call( $('#molongui-settings select'), { dropdownAutoWidth: true, minimumResultsForSearch: Infinity } );
                            molongui_select2.call( $('.molongui-metabox select'),  { dropdownAutoWidth: true, minimumResultsForSearch: Infinity } );
                            molongui_select2.call( $('#molongui-settings select.searchable'), { dropdownAutoWidth: true } );
                            molongui_select2.call( $('.molongui-metabox select.searchable'),  { dropdownAutoWidth: true } );
                            molongui_select2.call( $('#molongui-settings select.multiple'), { dropdownAutoWidth: true, multiple: true, allowClear: true } );
                            molongui_select2.call( $('.molongui-metabox select.multiple'),  { dropdownAutoWidth: true, multiple: true, allowClear: true } );
                        }
                    });
                "
            );
	    }
    }
}
if ( !function_exists( 'molongui_enqueue_sortable' ) )
{
	function molongui_enqueue_sortable()
    {
        $version = '1.9.0';
	    $sortable_js_url = 'https://cdn.jsdelivr.net/npm/sortablejs@'.$version.'/Sortable.min.js';
	    wp_enqueue_script( 'molongui-sortable', $sortable_js_url, array( 'jquery' ), $version, true );
    }
}
if ( !function_exists( 'molongui_enqueue_element_queries' ) )
{
	function molongui_enqueue_element_queries()
    {
	    $version = '1.2.0';
	    $resizesensor_js_url   = 'https://cdn.jsdelivr.net/npm/css-element-queries@'.$version.'/src/ResizeSensor.min.js';
	    $elementqueries_js_url = 'https://cdn.jsdelivr.net/npm/css-element-queries@'.$version.'/src/ElementQueries.min.js';
        wp_enqueue_script( 'molongui-resizesensor',   $resizesensor_js_url,   array( 'jquery' ), $version, true );
	    wp_enqueue_script( 'molongui-elementqueries', $elementqueries_js_url, array( 'jquery' ), $version, true );
    }
}