<?php
if ( !defined( 'ABSPATH' ) ) exit;

return array
(
	'advanced' => array
	(
		'key'      => $this->plugin->db_prefix . '_' . 'advanced',
		'slug'     => $this->plugin->underscored_id . '_' . 'advanced',
		'label'    => __( 'Advanced', 'molongui-common-framework' ),
		'callback' => array( $this, 'validate_advanced_tab' ),
		'sections' => array
		(
            array
            (
                'id'       => 'post_types',
                'display'  => $this->plugin->config['fw']['settings']['post_types'],
                'label'    => __( 'Post types', 'molongui-common-framework' ),
                'desc'     => __( '', 'molongui-common-framework' ),
                'callback' => 'render_description',
                'fields'   => array
                (
                    array
                    (
                        'id'      => 'extend_to',
                        'display' => $this->plugin->config['fw']['settings']['extend_to'],
                        'label'   => __( 'Enable plugin on...', 'molongui-common-framework' ),
                        'desc'    => __( '', 'molongui-common-framework' ),
                        'tip'     => __( 'Choose which post types extend plugin functionality to.', 'molongui-common-framework' ),
                        'premium' => $this->premium_setting_tip(),
                        'class'   => '',
                        'type'    => 'checkboxes',
                        'options' => molongui_get_post_types( 'all', 'objects', true ),
                    ),
                ),
            ),
            array
            (
	            'id'       => 'spam_protection',
	            'display'  => $this->plugin->config['fw']['settings']['spam_protection'],
	            'label'    => __( 'Spam protection', 'molongui-common-framework' ),
	            'desc'     => __( '', 'molongui-common-framework' ),
	            'callback' => 'render_description',
	            'fields'   => array
	            (
		            array
		            (
			            'id'      => 'encode_email',
			            'display' => $this->plugin->config['fw']['settings']['encode_email'],
			            'label'   => __( 'Encode mail addresses', 'molongui-common-framework' ),
			            'desc'    => __( '', 'molongui-common-framework' ),
			            'tip'     => __( 'Whether to encode e-mail addresses on the source code so SPAM bots can not retrieve them.', 'molongui-common-framework' ),
			            'premium' => $this->premium_setting_tip(),
			            'class'   => '',
			            'type'    => 'select',
			            'options' => array
			            (
				            array
				            (
					            'id'    => 'yes',
					            'label' => __( 'Yes', 'molongui-common-framework' ),
					            'value' => '1',
				            ),
				            array
				            (
					            'id'    => 'no',
					            'label' => __( 'No', 'molongui-common-framework' ),
					            'value' => '0',
				            ),
			            ),
		            ),
		            array
		            (
			            'id'      => 'encode_phone',
			            'display' => $this->plugin->config['fw']['settings']['encode_phone'],
			            'label'   => __( 'Encode phone numbers', 'molongui-common-framework' ),
			            'desc'    => __( '', 'molongui-common-framework' ),
			            'tip'     => __( 'Whether to encode phone numbers on the source code so SPAM bots can not retrieve them.', 'molongui-common-framework' ),
			            'premium' => $this->premium_setting_tip(),
			            'class'   => '',
			            'type'    => 'select',
			            'options' => array
			            (
				            array
				            (
					            'id'    => 'yes',
					            'label' => __( 'Yes', 'molongui-common-framework' ),
					            'value' => '1',
				            ),
				            array
				            (
					            'id'    => 'no',
					            'label' => __( 'No', 'molongui-common-framework' ),
					            'value' => '0',
				            ),
			            ),
		            ),
	            ),
            ),
			array
			(
				'id'       => 'shortcodes',
                'display'  => ( ( $this->plugin->config['fw']['settings']['extend_to'] and version_compare( get_bloginfo('version'),'4.9', '<' ) ) ? true : false ),
				'label'    => __( 'Shortcodes', 'molongui-common-framework' ),
				'desc'     => __( '', 'molongui-common-framework' ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'enable_sc_text_widgets',
                        'display' => version_compare( get_bloginfo('version'),'4.9', '<' ),
						'label'   => __( 'Enable in text widgets', 'molongui-common-framework' ),
						'desc'    => __( '', 'molongui-common-framework' ),
						'tip'     => __( 'Whether to enable the use of shortcodes in text widgets.', 'molongui-common-framework' ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', 'molongui-common-framework' ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', 'molongui-common-framework' ),
								'value' => '0',
							),
						),
					),
				),
			),
			array
			(
				'id'       => 'uninstalling',
                'display'  => $this->plugin->config['fw']['settings']['uninstalling'],
				'label'    => __( 'Uninstalling', 'molongui-common-framework' ),
				'desc'     => __( '', 'molongui-common-framework' ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'keep_config',
                        'display' => $this->plugin->config['fw']['settings']['keep_config'],
						'label'   => __( 'Keep configuration?', 'molongui-common-framework' ),
						'desc'    => __( '', 'molongui-common-framework' ),
						'tip'     => __( 'Whether to keep plugin configuration settings upon plugin uninstalling.', 'molongui-common-framework' ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', 'molongui-common-framework' ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', 'molongui-common-framework' ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'keep_data',
                        'display' => $this->plugin->config['fw']['settings']['keep_data'],
						'label'   => __( 'Keep data?', 'molongui-common-framework' ),
						'desc'    => __( '', 'molongui-common-framework' ),
						'tip'     => __( 'Whether to keep plugin related data upon plugin uninstalling.', 'molongui-common-framework' ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', 'molongui-common-framework' ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', 'molongui-common-framework' ),
								'value' => '0',
							),
						),
					),
				),
			),
		),
	),
	'license' => array
	(
		'key'      => $this->plugin->db_prefix . '_' . 'license',
		'slug'     => $this->plugin->underscored_id . '_' . 'license',
		'label'    => __( 'License', 'molongui-common-framework' ),
		'callback' => array( $this, 'validate_license_tab' ),
		'sections' => array
		(
			array
			(
				'id'       => 'license_credentials',
                'display'  => true,
				'label'    => __( 'Credentials', 'molongui-common-framework' ),
				'desc'     => sprintf( __( 'Insert your license credentials to make the plugin work, you will find them by logging in %sto your account%s.', 'molongui-common-framework' ), '<a href="'.molongui_get_constant( $this->plugin->id, 'MOLONGUI_WEB', true ).'my-account/" target="_blank">', '</a>' ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'          => ( isset( $this->plugin->update['db']['activation_key'] ) ? $this->plugin->update['db']['activation_key'] : '' ),
                        'display'     => true,
						'label'       => __( 'License Key', 'molongui-common-framework' ),
						'desc'        => __( '', 'molongui-common-framework' ),
						'tip'         => __( 'The key we provided upon premium plugin purchase.', 'molongui-common-framework' ),
						'placeholder' => '',
						'type'        => 'text',
						'icon'        => array
						(
							'position' => 'right',
							'type'     => 'status',
						),
					),
					array
					(
						'id'          => ( isset( $this->plugin->update['db']['activation_email'] ) ? $this->plugin->update['db']['activation_email'] : '' ),
                        'display'     => true,
						'label'       => __( 'License email', 'molongui-common-framework' ),
						'desc'        => __( '', 'molongui-common-framework' ),
						'tip'         => __( 'The email you used to purchase the premium license.', 'molongui-common-framework' ),
						'placeholder' => '',
						'type'        => 'text',
						'icon'        => array
						(
							'position' => 'right',
							'type'     => 'status',
						),
					),
				),
			),
			array
			(
				'id'       => 'license_deactivation',
                'display'  => true,
				'label'    => __( 'Deactivation', 'molongui-common-framework' ),
				'desc'     => sprintf( __( 'Choose whether to deactivate the licence key upon plugin deactivation. Deactivating the license releases it so it can be used on another website but also removes it from this one, so should you reactivate the plugin, you will need to set again your credentials. %sRegardless of the value of this setting, the license will be released when uninstalling the plugin.', 'molongui-common-framework' ), '' ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'keep_license',
                        'display' => true,
						'label'   => __( 'Keep on deactivation', 'molongui-common-framework' ),
						'desc'    => __( '', 'molongui-common-framework' ),
						'tip'     => __( 'Whether to keep license credentials upon plugin deactivation.', 'molongui-common-framework' ),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', 'molongui-common-framework' ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', 'molongui-common-framework' ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'deactivate_license',
                        'display' => true,
						'label'   => __( 'Deactivate license', 'molongui-common-framework' ),
						'desc'    => __( '', 'molongui-common-framework' ),
						'tip'     => __( 'Deactivates your premium license so you can use it on another installation.', 'molongui-common-framework' ),
						'type'    => 'button',
						'args'    => array
						(
							'id'    => 'deactivate_license_button',
							'label' => __( 'Deactivate now', 'molongui-common-framework' ),
							'class' => 'button',
						),
					),
				),
			),
		),
	),
	'support' => array
	(
		'key'      => $this->plugin->db_prefix . '_' . 'support',
		'slug'     => $this->plugin->underscored_id . '_' . 'support',
		'label'    => __( 'Support', 'molongui-common-framework' ),
		'callback' => '',
		'sections' => array
		(
			array
			(
				'id'       => 'section_support',
                'display'  => true,
				'label'    => __( '', 'molongui-common-framework' ),
				'callback' => 'render_class',
				'cb_class' => 'Sysinfo',
				'cb_args'  => '',
			),
		),
	),
	'more' => array
	(
		'key'      => $this->plugin->db_prefix . '_' . 'more',
		'slug'     => $this->plugin->underscored_id . '_' . 'more',
		'label'    => __( 'More', 'molongui-common-framework' ),
		'callback' => '',
		'sections' => array
		(
			array
			(
				'id'       => 'section_more',
                'display'  => true,
				'label'    => __( '', 'molongui-common-framework' ),
				'callback' => 'render_page',
				'cb_page'  => molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'admin/views/html-admin-tab-more.php',
				'cb_args'  => array( 'plugin_id' => $this->plugin->id, 'is_premium' => $this->plugin->is_premium ),
			),
		),
	),
);