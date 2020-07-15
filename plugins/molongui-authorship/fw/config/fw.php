<?php
if ( !defined( 'ABSPATH' ) ) exit;
$fw_config = array
(
	'NAME'          => 'Molongui Common Framework',
	'ID'            => 'Common Framework',
	'VERSION'       => '1.3.1',
	'DIR'           => plugin_dir_path( plugin_dir_path( __FILE__ ) ),
	'URL'           => plugins_url( '/', plugin_dir_path( __FILE__ ) ),
	'MOLONGUI_WEB'  => 'https://www.molongui.com/',
	'SUPPORT_MAIL'  => 'support@molongui.com',
);
$constant_prefix = 'MOLONGUI_' . strtoupper( str_replace( ' ', '_', $config[ 'ID' ] ) ) . '_FW_';
foreach( $fw_config as $param => $value )
{
	$param = $constant_prefix . $param;
	if( !defined( $param ) ) define( $param, $value );
}