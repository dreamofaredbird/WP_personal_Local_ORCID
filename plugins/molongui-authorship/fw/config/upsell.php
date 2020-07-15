<?php
if ( !defined( 'ABSPATH' ) ) exit;

return array(
	'server' => array
	(
		'url'   => '',
		'agent' => 'Molongui Upsell Ads',
	),
	'local' => array
	(
		'url' => molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'upsells/molongui-local-upsells.json',
	),
);