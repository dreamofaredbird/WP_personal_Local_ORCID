<?php
if ( !defined( 'ABSPATH' ) ) exit;

return array
(
	'cpt' => array
	(
		'molongui_guestauthor',
	),
	'dependencies' => array
	(
		'theme'  => array(),
		'plugin' => array(),
	),
    'scripts' => array
    (
        'back'  => array(),
        'front' => array(),
    ),
    'styles' => array
    (
        'back'  => array(),
        'front' => array(),
    ),
    'fonts' => array
    (
        'back'  => array(),
        'front' => array(),
    ),
    'admin_tabs' => array
    (
        'hide' => array
        (
            'box'      => false,
            'byline'   => false,
            'authors'  => false,
            'archives' => false,
            'advanced' => false,
            'license'  => false,
            'support'  => true,
            'more'     => true,
        ),
        'no_save' => array
        (
	        'box'      => false,
	        'byline'   => false,
	        'authors'  => false,
	        'archives' => false,
		    'advanced' => false,
            'license'  => false,
            'support'  => true,
            'more'     => true,
        ),
        'no_sidebar' => array
        (
	        'box'      => true,
	        'byline'   => true,
	        'authors'  => true,
	        'archives' => true,
	        'advanced' => true,
            'license'  => true,
            'support'  => true,
	        'more'     => true,
        ),
    ),
    'notices' => array
    (
    	'install' => array
	    (
		    'dismissible' => true,
		    'dismissal'   => 'forever',
	    ),
    	'whatsnew' => array
	    (
		    'dismissible' => true,
		    'dismissal'   => 'forever',
	    ),
    	'upgrade' => array
	    (
		    'dismissible' => true,
		    'dismissal'   => 60,
	    ),
    	'rate' => array
	    (
	    	'trigger'     => 30,
		    'dismissible' => true,
		    'dismissal'   => 'forever',
	    ),
    	'update' => array
	    (
		    'dismissible' => false,
		    'dismissal'   => 0,
	    ),
    	'inactive-license' => array
	    (
		    'dismissible' => false,
		    'dismissal'   => 0,
	    ),
    	'renew-license' => array
	    (
		    'dismissible' => true,
		    'dismissal'   => 7,
	    ),
    	'expired-license' => array
	    (
		    'dismissible' => true,
		    'dismissal'   => 60,
	    ),
	    'missing-dependency' => array
	    (
		    'dismissible' => false,
		    'dismissal'   => 0,
	    ),
	    'missing-version' => array
	    (
		    'dismissible' => false,
		    'dismissal'   => 0,
	    ),
	    'many-installations' => array
	    (
		    'dismissible' => false,
		    'dismissal'   => 0,
	    ),
    ),
	'customizer' => array
	(
		'enable' => true,
	),
	'fw' => array
	(
		'enable'   => true,
		'settings' => array
		(
			'post_types'      => true,
			'extend_to'       => true,
			'spam_protection' => true,
			'encode_email'    => true,
			'encode_phone'    => true,
			'shortcodes'      => true,
			'uninstalling'    => true,
			'keep_config'     => true,
			'keep_data'       => true,
		),
	),
);