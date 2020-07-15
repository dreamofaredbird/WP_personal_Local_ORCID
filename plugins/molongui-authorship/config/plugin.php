<?php
if ( !defined( 'ABSPATH' ) ) exit;
$config = array
(
    'NAME'              => 'Molongui Authorship',
    'ID'                => 'Authorship',
    'VERSION'           => '3.2.25',
    'DB_VERSION'        => '13',
    'UPGRADABLE'        => true,
    'WEB'               => 'https://www.molongui.com/product/authorship',
    'DB_SETTINGS'       => 'molongui_authorship_db_version',
    'INSTALLATION'      => 'molongui_authorship_installation',
    'NOTICES'           => 'molongui_authorship_notices',
    'BYLINE_SETTINGS'   => 'molongui_authorship_byline',
    'BOX_SETTINGS'      => 'molongui_authorship_box',
    'AUTHORS_SETTINGS'  => 'molongui_authorship_authors',
    'ARCHIVES_SETTINGS' => 'molongui_authorship_archives',
    'STRING_SETTINGS'   => 'molongui_authorship_strings',
    'ADVANCED_SETTINGS' => 'molongui_authorship_advanced',
    'CONTRIBUTORS_PAGE' => 'molongui_authorship_contributors_page',
);
if ( isset( $dont_load_constants ) and $dont_load_constants )
{
    unset( $dont_load_constants );
    return;
}
$constant_prefix = 'MOLONGUI_' . strtoupper( str_replace( ' ', '_', $config['ID'] ) ) . '_';
foreach( $config as $param => $value )
{
    $param = $constant_prefix . $param;
    if( !defined( $param ) ) define( $param, $value );
}
if( !defined( $constant_prefix . 'DIR' ) )         define( $constant_prefix . 'DIR'        , plugin_dir_path( plugin_dir_path( __FILE__ ) ) );
if( !defined( $constant_prefix . 'URL' ) )         define( $constant_prefix . 'URL'        , plugins_url( '/', plugin_dir_path( __FILE__ ) ) );
if( !defined( $constant_prefix . 'DASHED_ID' ) )   define( $constant_prefix . 'DASHED_ID'  , strtolower( str_replace( ' ', '-', $config['ID'] ) ) );
if( !defined( $constant_prefix . 'DASHED_NAME' ) ) define( $constant_prefix . 'DASHED_NAME', strtolower( str_replace( ' ', '-', $config['NAME'] ) ) );
if( !defined( $constant_prefix . 'BASENAME' ) )    define( $constant_prefix . 'BASENAME'   , plugin_basename( dirname( plugin_dir_path( __FILE__ ) ) ) . '/molongui-' . strtolower( str_replace( ' ', '-', $config['ID'] ) ) . '.php' );
if( !defined( $constant_prefix . 'NAMESPACE' ) )   define( $constant_prefix . 'NAMESPACE'  , str_replace( ' ', '', ucwords( $config['ID'] ) ) );
if( !defined( $constant_prefix . 'TEXTDOMAIN' ) )  define( $constant_prefix . 'TEXTDOMAIN', constant( $constant_prefix . 'DASHED_NAME' ) );
if( !defined( $constant_prefix . 'DB_PREFIX' ) )   define( $constant_prefix . 'DB_PREFIX'  , 'molongui_' . strtolower( str_replace( ' ', '_', $config['ID'] ) ) );