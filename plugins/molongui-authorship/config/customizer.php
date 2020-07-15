<?php

return array
(
	'add_panel'       => true,
	'id'              => $this->plugin->dashed_name,
	'title'           => __( 'Molongui Author Box', $this->plugin->textdomain ),
	'description'     => sprintf( '%s%s%s', '<p>', __( 'Customize visual settings to your like.', $this->plugin->textdomain ), '</p>' ),
	'priority'        => 121,
	'capability'      => 'manage_options',
	'active_callback' => '',
	'sections'        => array
	(
		array
		(
			'id'                 => 'molongui_authorship_scheme',
			'title'              => __( 'Pre-defined appearance schemes', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => false,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[scheme]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'scheme-1',
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Pre-defined schemes', $this->plugin->textdomain ),
						'description'     => __( 'Choose the pre-defined appearance scheme you would like to use. Once loaded, you can customize any setting you need.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Select_Control',
						'type'            => 'molongui-select',
						'choices'         => array
						(
							'scheme-1' => array
							(
								'label'    => __( 'Scheme 1', $this->plugin->textdomain ),
								'disabled' => false,
								'premium'  => false,
							),
							'scheme-2' => array
							(
								'label'    => __( 'Scheme 2', $this->plugin->textdomain ),
								'disabled' => false,
								'premium'  => false,
							),
							'scheme-3' => array
							(
								'label'    => __( 'Scheme 3', $this->plugin->textdomain ),
								'disabled' => false,
								'premium'  => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_box',
			'title'              => __( 'Box', $this->plugin->textdomain ),
			'description'        => __( 'Customize to your likings the author box that will be displayed on your posts by selecting which layout to use, the position where to display it, and many more color, size and styling options. Make it fit the best with your site. You can preview Premium settings. Upgrade to Premium to unlock them all :)', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[layout]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'slim',
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => '',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Layout', $this->plugin->textdomain ),
						'description'     => __( 'The template used to render the author box. The first two displays the author profile or the related posts in the same space while the third one shows related entries below author profile.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'slim' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-layout/box-layout-slim.png',
								'label'   => __( 'Slim', $this->plugin->textdomain ),
								'premium' => false,
							),
							'tabbed' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-layout/box-layout-tabbed.png',
								'label'   => __( 'Tabbed', $this->plugin->textdomain ),
								'premium' => false,
							),
							'stacked' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-layout/box-layout-stacked.png',
								'label'   => __( 'Stacked', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[position]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'below',
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Position', $this->plugin->textdomain ),
						'description'     => __( 'Whether to show the author box above the post content, below or on both places.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'above' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-position/author-box-position-above.png',
								'label'   => __( 'Above content', $this->plugin->textdomain ),
								'premium' => false,
							),
							'below' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-position/author-box-position-below.png',
								'label'   => __( 'Below content', $this->plugin->textdomain ),
								'premium' => false,
							),
							'both' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-position/author-box-position-both.png',
								'label'   => __( 'Above and below content', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[order]',
					'display' => false,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 11,
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => '',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Order', $this->plugin->textdomain ),
						'description'     => __( 'Author box is added to post content in the configured position. Nonetheless, other plugins may also add their stuff, making the author box appear above/below it. Reduce the number below until the box goes up there where you like or increase it to make it go down.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Number_Control',
						'type'            => 'molongui-number',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'min'     => '1',
							'max'     => '',
							'step'    => '1',
							'premium' => false,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[box_margin]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 0,
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Margin', $this->plugin->textdomain ),
						'description'     => __( 'Space in pixels to add above and below the author box.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 0,
							'max'     => 200,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[box_width]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 100,
						'transport'            => 'postMessage',
						'validate_callback'    => 'molongui_authorship_validate_box_width',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Width', $this->plugin->textdomain ),
						'description'     => __( 'Amount of space in percentage the author box can take.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 0,
							'max'     => 100,
							'step'    => 1,
							'suffix'  => '%',
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
								),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[box_border]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'solid',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Border', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-border/box-border-none.png',
								'label'   => __( 'None', $this->plugin->textdomain ),
								'premium' => false,
							),
							'all' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-border/box-border-all.png',
								'label'   => __( 'All', $this->plugin->textdomain ),
								'premium' => false,
							),
							'horizontals' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-border/box-border-horizontal.png',
								'label'   => __( 'Horizontals', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'verticals' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-border/box-border-vertical.png',
								'label'   => __( 'Verticals', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'left' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-border/box-border-left.png',
								'label'   => __( 'Left', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'top' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-border/box-border-top.png',
								'label'   => __( 'Top', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'right' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-border/box-border-right.png',
								'label'   => __( 'Right', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'bottom' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-border/box-border-bottom.png',
								'label'   => __( 'Bottom', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[box_border_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'solid',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',//array( 'Molongui\Fw\Customizer\Customizer', 'molongui_sanitize_to_default' ),//'molongui_sanitize_to_default',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Border style', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'solid' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-solid.png',
								'label'   => __( 'Solid', $this->plugin->textdomain ),
								'premium' => false,
							),
							'double' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-double.png',
								'label'   => __( 'Double', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'dotted' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-dotted.png',
								'label'   => __( 'Dotted', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'dashed' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-dashed.png',
								'label'   => __( 'Dashed', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_box_border_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[box_border_width]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 1,
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Border width', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 1,
							'max'     => 10,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_box_border_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[box_border_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Border color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_box_border_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[box_background]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Background color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[box_shadow]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'none',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Shadow', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'left' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-shadow/box-shadow-left.png',
								'label'   => __( 'Left', $this->plugin->textdomain ),
								'premium' => false,
							),
							'none' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-shadow/box-shadow-none.png',
								'label'   => __( 'None', $this->plugin->textdomain ),
								'premium' => false,
							),
							'right' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-shadow/box-shadow-right.png',
								'label'   => __( 'Right', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_headline',
			'title'              => __( 'Headline', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[show_headline]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => '0',
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Display', $this->plugin->textdomain ),
						'description'     => __( 'Whether to show a headline above the author box.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'1' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-headline/author-box-headline-on.png',
								'label'   => __( 'Show headline', $this->plugin->textdomain ),
								'premium' => false,
							),
							'0' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-headline/author-box-headline-off.png',
								'label'   => __( 'Hide headline', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[headline]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( 'About the author', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Text', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( 'About the author', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_headline_setting',
					),
				),
				array
				(
					'id'      => 'molongui_headline_typography_settings',
					'display' => true,
					'setting' => array
					(
						'sanitize_callback' => 'esc_html',
					),
					'control' => array
					(
						'label'           => __( 'Typography', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Group_Label_Control',
						'type'            => 'molongui-compact-group-label',
						'active_callback' => 'molongui_active_headline_setting',
						'input_attrs'     => array(),
						'choices'         => array(),
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[headline_text_size]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'normal',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Size', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'molongui-compact-range-flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 8,
							'max'     => 100,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_headline_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[headline_text_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => '',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Style', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Checkbox_Button_Control',
						'type'            => 'molongui-compact-image-checkbox',
						'choices'         => array
						(
							'normal' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-normal.png',
								'label'   => __( 'Normal', $this->plugin->textdomain ),
								'premium' => false,
							),
							'bold' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-bold.png',
								'label'   => __( 'Bold', $this->plugin->textdomain ),
								'premium' => false,
							),
							'italic' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-italic.png',
								'label'   => __( 'Italic', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'underline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-underline.png',
								'label'   => __( 'Underline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'overline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-overline.png',
								'label'   => __( 'Overline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'overunderline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-overunderline.png',
								'label'   => __( 'Overline and underline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array( 'compact' => true ),
						'allow_addition'  => true,
						'active_callback' => 'molongui_active_headline_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[headline_text_case]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'none',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Case', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-compact-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-none.png',
								'label'   => __( 'Leave as is', $this->plugin->textdomain ),
								'premium' => false,
							),
							'capitalize' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-capitalize.png',
								'label'   => __( 'Capitalize', $this->plugin->textdomain ),
								'premium' => false,
							),
							'uppercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-uppercase.png',
								'label'   => __( 'Uppercase', $this->plugin->textdomain ),
								'premium' => false,
							),
							'lowercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-lowercase.png',
								'label'   => __( 'Lowercase', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_headline_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[headline_text_align]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'left',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Align', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-compact-image-radio',
						'choices'         => array
						(
							'left' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-left.png',
								'label'   => __( 'Left', $this->plugin->textdomain ),
								'premium' => false,
							),
							'center' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-center.png',
								'label'   => __( 'Center', $this->plugin->textdomain ),
								'premium' => false,
							),
							'right' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-right.png',
								'label'   => __( 'Right', $this->plugin->textdomain ),
								'premium' => false,
							),
							'justify' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-justify.png',
								'label'   => __( 'Justify', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_headline_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[headline_text_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-compact-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_headline_setting',
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_tabs',
			'title'              => __( 'Tabs', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => 'molongui_active_box_tabbed_layout_setting',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[tabs_position]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'top-full',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Position', $this->plugin->textdomain ),
						'description'     => __( 'Where to display the tabs.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'top-full' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-tabs/box-tabs-position-top-full.png',
								'label'   => __( 'Top full width', $this->plugin->textdomain ),
								'premium' => false,
							),
							'top-left' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-tabs/box-tabs-position-top-left.png',
								'label'   => __( 'Top left', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'top-center' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-tabs/box-tabs-position-top-center.png',
								'label'   => __( 'Top center', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'top-right' => array
							(
								'image'   => $this->plugin->url.'customizer/img/box-tabs/box-tabs-position-top-right.png',
								'label'   => __( 'Top right', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[tabs_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Tabs color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[tabs_active_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Active tab color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[tabs_background]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Background color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_tabs_background_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[tabs_text_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Text color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[about_the_author]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( 'About the author', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( '"About the author" label', $this->plugin->textdomain ),
						'description'     => __( 'Text to show as author bio tab label.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( 'About the author', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[related_posts]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( 'Related posts', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( '"Related posts" label', $this->plugin->textdomain ),
						'description'     => __( 'Text to show as author related posts tab label', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( 'Related posts', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_profile',
			'title'              => __( 'Template', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[profile_layout]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'layout-1',
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => '',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Profile template', $this->plugin->textdomain ),
						'description'     => __( 'The template to be used to render the author profile section.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'layout-1' => array
							(
								'image'   => $this->plugin->url.'customizer/img/profile-template/profile-template-1.png',
								'label'   => __( 'Template 1', $this->plugin->textdomain ),
								'premium' => false,
							),
							'layout-2' => array
							(
								'image'   => $this->plugin->url.'customizer/img/profile-template/profile-template-2.png',
								'label'   => __( 'Template 2', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'layout-3' => array
							(
								'image'   => $this->plugin->url.'customizer/img/profile-template/profile-template-3.png',
								'label'   => __( 'Template 3', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'layout-4' => array
							(
								'image'   => $this->plugin->url.'customizer/img/profile-template/profile-template-4.png',
								'label'   => __( 'Template 4', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'layout-5' => array
							(
								'image'   => $this->plugin->url.'customizer/img/profile-template/profile-template-5.png',
								'label'   => __( 'Template 5', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'layout-6' => array
							(
								'image'   => $this->plugin->url.'customizer/img/profile-template/profile-template-6.png',
								'label'   => __( 'Template 6', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'layout-7' => array
							(
								'image'   => $this->plugin->url.'customizer/img/profile-template/profile-template-7.png',
								'label'   => __( 'Template 7', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'layout-8' => array
							(
								'image'   => $this->plugin->url.'customizer/img/profile-template/profile-template-8.png',
								'label'   => __( 'Template 8', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[profile_valign]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'default',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Alignment', $this->plugin->textdomain ),
						'description'     => __( 'Content vertical alignment', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Text_Radio_Button_Control',
						'type'            => 'molongui-text-radio',
						'choices'         => array
						(
							'top' => array
							(
								'label'   => __( 'Top', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'center' => array
							(
								'label'   => __( 'Center', $this->plugin->textdomain ),
								'premium' => false,
							),
							'bottom' => array
							(
								'label'   => __( 'Bottom', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[profile_title]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( 'Author profile', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Section label', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( 'Author profile', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_box_stacked_layout_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bottom_background_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Bottom background color', $this->plugin->textdomain ),
						'description'     => __( 'The color used to fill the background of the bottom section on a "ribbon" layout.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_ribbon_layout_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bottom_border_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'solid',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Bottom border style', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-none.png',
								'label'   => __( 'None', $this->plugin->textdomain ),
								'premium' => false,
							),
							'solid' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-solid.png',
								'label'   => __( 'Solid', $this->plugin->textdomain ),
								'premium' => false,
							),
							'double' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-double.png',
								'label'   => __( 'Double', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'dotted' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-dotted.png',
								'label'   => __( 'Dotted', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'dashed' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-dashed.png',
								'label'   => __( 'Dashed', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_ribbon_layout_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bottom_border_width]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 1,
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Bottom border width', $this->plugin->textdomain ),
						'description'     => __( 'Width of the border to add at the top of bottom section on a "ribbon" layout.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
							'min'     => 1,
							'max'     => 10,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => function( $control ) { return ( molongui_active_ribbon_layout_setting( $control ) and molongui_active_ribbon_border_setting( $control ) ? true : false ); },
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bottom_border_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'transparent',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Bottom border color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => function( $control ) { return ( molongui_active_ribbon_layout_setting( $control ) and molongui_active_ribbon_border_setting( $control ) ? true : false ); },
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_avatar',
			'title'              => __( 'Avatar', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[show_avatar]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'default',
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Display', $this->plugin->textdomain ),
						'description'     => __( 'Whether to show the author avatar.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Text_Radio_Button_Control',
						'type'            => 'molongui-text-radio',
						'choices'         => array
						(
							'1' => array
							(
								'label'   => __( 'Show', $this->plugin->textdomain ),
								'premium' => false,
							),
							'0' => array
							(
								'label'   => __( 'Hide', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array
						(
							'premium' => false,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[avatar_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'none',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Shape', $this->plugin->textdomain ),
						'description'     => __( 'Whether and how to shape the author avatar.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'customizer/img/avatar-style/avatar-style-none.png',
								'label'   => __( 'None', $this->plugin->textdomain ),
								'premium' => false,
							),
							'rounded' => array
							(
								'image'   => $this->plugin->url.'customizer/img/avatar-style/avatar-style-rounded.png',
								'label'   => __( 'Rounded', $this->plugin->textdomain ),
								'premium' => false,
							),
							'circled' => array
							(
								'image'   => $this->plugin->url.'customizer/img/avatar-style/avatar-style-circled.png',
								'label'   => __( 'Circled', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_avatar_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[avatar_border_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'solid',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Border style', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-none.png',
								'label'   => __( 'None', $this->plugin->textdomain ),
								'premium' => false,
							),
							'solid' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-solid.png',
								'label'   => __( 'Solid', $this->plugin->textdomain ),
								'premium' => false,
							),
							'double' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-double.png',
								'label'   => __( 'Double', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'dotted' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-dotted.png',
								'label'   => __( 'Dotted', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'dashed' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/border-style/border-style-dashed.png',
								'label'   => __( 'Dashed', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_avatar_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[avatar_border_width]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 1,
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Border width', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 1,
							'max'     => 10,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => function( $control ) { return ( molongui_active_avatar_setting( $control ) and molongui_active_avatar_border_width_setting( $control ) ? true : false ); },
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[avatar_border_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Border color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
						),
						'allow_addition'  => false,
						'active_callback' => function( $control ) { return ( molongui_active_avatar_setting( $control ) and molongui_active_avatar_border_color_setting( $control ) ? true : false ); },
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[avatar_link_to_archive]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'link',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Link to archive', $this->plugin->textdomain ),
						'description'     => ( !$this->plugin->is_premium ? __( "Whether to make the author avatar link to the author's archive page.", $this->plugin->textdomain ) : __( "Whether to make the author avatar link to the author's archive page. Regardless of this setting being enabled, the author avatar might not become a link. i.e. When author archive pages are disabled.", $this->plugin->textdomain ) ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Text_Radio_Button_Control',
						'type'            => 'molongui-text-radio',
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_avatar_setting',
						'input_attrs'     => array(),
						'choices'         => array
						(
							'1' => array
							(
								'label'   => __( 'Link', $this->plugin->textdomain ),
								'premium' => false,
							),
							'0' => array
							(
								'label'   => __( 'No link',  $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[avatar_default_img]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'blank',
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => '',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Default image', $this->plugin->textdomain ),
						'description'     => __( 'Avatar to show if none uploaded and no gravatar configured.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'customizer/img/avatar-default/avatar-default-image-none.png',
								'label'   => __( 'None', $this->plugin->textdomain ),
								'premium' => false,
							),
							'blank' => array
							(
								'image'   => $this->plugin->url.'customizer/img/avatar-default/avatar-default-image-blank.png',
								'label'   => __( 'Blank', $this->plugin->textdomain ),
								'premium' => false,
							),
							'mm' => array
							(
								'image'   => $this->plugin->url.'customizer/img/avatar-default/avatar-default-image-mm.png',
								'label'   => __( 'Mistery man', $this->plugin->textdomain ),
								'premium' => false,
							),
							'acronym' => array
							(
								'image'   => $this->plugin->url.'customizer/img/avatar-default/avatar-default-image-acronym.png',
								'label'   => __( 'Author acronym', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_avatar_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[acronym_text_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( ' Acronym font color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => function( $control ) { return ( molongui_active_avatar_setting( $control ) and molongui_active_acronym_setting( $control ) ? true : false ); },
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[acronym_bg_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Acronym background color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => function( $control ) { return ( molongui_active_avatar_setting( $control ) and molongui_active_acronym_setting( $control ) ? true : false ); },
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_name',
			'title'              => __( 'Name', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => 'molongui_name_typography_settings',
					'display' => true,
					'setting' => array
					(
						'sanitize_callback' => 'esc_html',
					),
					'control' => array
					(
						'label'           => __( 'Typography', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Group_Label_Control',
						'type'            => 'molongui-compact-group-label',
						'active_callback' => '',
						'input_attrs'     => array(),
						'choices'         => array(),
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[name_text_size]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'normal',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Size', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'molongui-compact-range-flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 8,
							'max'     => 100,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[name_text_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => '',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Style', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Checkbox_Button_Control',
						'type'            => 'molongui-compact-image-checkbox',
						'choices'         => array
						(
							'normal' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-normal.png',
								'label'   => __( 'Normal', $this->plugin->textdomain ),
								'premium' => false,
							),
							'bold' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-bold.png',
								'label'   => __( 'Bold', $this->plugin->textdomain ),
								'premium' => false,
							),
							'italic' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-italic.png',
								'label'   => __( 'Italic', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'underline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-underline.png',
								'label'   => __( 'Underline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'overline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-overline.png',
								'label'   => __( 'Overline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'overunderline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-overunderline.png',
								'label'   => __( 'Overline and underline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => true,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[name_text_case]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'none',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Case', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-compact-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-none.png',
								'label'   => __( 'Leave as is', $this->plugin->textdomain ),
								'premium' => false,
							),
							'capitalize' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-capitalize.png',
								'label'   => __( 'Capitalize', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'uppercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-uppercase.png',
								'label'   => __( 'Uppercase', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'lowercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-lowercase.png',
								'label'   => __( 'Lowercase', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[name_text_align]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'left',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Align', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-compact-image-radio',
						'choices'         => array
						(
							'left' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-left.png',
								'label'   => __( 'Left', $this->plugin->textdomain ),
								'premium' => false,
							),
							'center' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-center.png',
								'label'   => __( 'Center', $this->plugin->textdomain ),
								'premium' => false,
							),
							'right' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-right.png',
								'label'   => __( 'Right', $this->plugin->textdomain ),
								'premium' => false,
							),
							'justify' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-justify.png',
								'label'   => __( 'Justify', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[name_text_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-compact-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[name_link_to_archive]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'link',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Link to archive', $this->plugin->textdomain ),
						'description'     => ( !$this->plugin->is_premium ? __( "Whether to make the author name link to the author's archive page.", $this->plugin->textdomain ) : __( "Whether to make the author name link to the author's archive page. Regardless of this setting being enabled, the author name might not become a link. i.e. When author archive pages are disabled.", $this->plugin->textdomain ) ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Text_Radio_Button_Control',
						'type'            => 'molongui-text-radio',
						'allow_addition'  => false,
						'active_callback' => '',
						'input_attrs'     => array(),
						'choices'         => array
						(
							'1' => array
							(
								'label'   => __( 'Link', $this->plugin->textdomain ),
								'premium' => false,
							),
							'0' => array
							(
								'label'   => __( 'No link',  $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[name_inherited_underline]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'keep',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Remove inherited underline', $this->plugin->textdomain ),
						'description'     => __( 'Whether to (try to) remove the underline added by your theme or any other third plugin.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Text_Radio_Button_Control',
						'type'            => 'molongui-text-radio',
						'allow_addition'  => false,
						'active_callback' => '',
						'input_attrs'     => array(),
						'choices'         => array
						(
							'keep' => array
							(
								'label'   => __( 'Keep as is', $this->plugin->textdomain ),
								'premium' => false,
							),
							'remove' => array
							(
								'label'   => __( 'Remove it',  $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_meta',
			'title'              => __( 'Metadata', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					 'id'      => 'molongui_meta_typography_settings',
					 'display' => true,
					 'setting' => array
					 (
						 'sanitize_callback' => 'esc_html',
					 ),
					 'control' => array
					 (
						 'label'           => __( 'Typography', $this->plugin->textdomain ),
						 'description'     => __( '', $this->plugin->textdomain ),
						 'priority'        => 10,
						 'class'           => 'Molongui_Customize_Group_Label_Control',
						 'type'            => 'molongui-compact-group-label',
						 'active_callback' => '',
						 'input_attrs'     => array(),
						 'choices'         => array(),
					 ),
				 ),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[meta_text_size]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'normal',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Size', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'molongui-compact-range-flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 8,
							'max'     => 100,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[meta_text_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => '',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Style', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Checkbox_Button_Control',
						'type'            => 'molongui-compact-image-checkbox',
						'choices'         => array
						(
							'normal' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-normal.png',
								'label'   => __( 'Normal', $this->plugin->textdomain ),
								'premium' => false,
							),
							'bold' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-bold.png',
								'label'   => __( 'Bold', $this->plugin->textdomain ),
								'premium' => false,
							),
							'italic' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-italic.png',
								'label'   => __( 'Italic', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'underline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-underline.png',
								'label'   => __( 'Underline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'overline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-overline.png',
								'label'   => __( 'Overline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'overunderline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-overunderline.png',
								'label'   => __( 'Overline and underline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => true,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[meta_text_case]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'none',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Case', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-compact-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-none.png',
								'label'   => __( 'Leave as is', $this->plugin->textdomain ),
								'premium' => false,
							),
							'capitalize' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-capitalize.png',
								'label'   => __( 'Capitalize', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'uppercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-uppercase.png',
								'label'   => __( 'Uppercase', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'lowercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-lowercase.png',
								'label'   => __( 'Lowercase', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[meta_text_align]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'left',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Align', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-compact-image-radio',
						'choices'         => array
						(
							'left' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-left.png',
								'label'   => __( 'Left', $this->plugin->textdomain ),
								'premium' => false,
							),
							'center' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-center.png',
								'label'   => __( 'Center', $this->plugin->textdomain ),
								'premium' => false,
							),
							'right' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-right.png',
								'label'   => __( 'Right', $this->plugin->textdomain ),
								'premium' => false,
							),
							'justify' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-justify.png',
								'label'   => __( 'Justify', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[meta_text_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-compact-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[at]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( 'at', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( '"at" label', $this->plugin->textdomain ),
						'description'     => __( 'Text to show between author\'s job position and company.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( 'at', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[web]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( 'Website', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( '"Website" label', $this->plugin->textdomain ),
						'description'     => __( 'Text to show as link name to author\'s personal website.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( 'Website', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[more_posts]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( '+ posts', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( '"+ posts" label', $this->plugin->textdomain ),
						'description'     => __( 'Text to show as toggle button to display author\'s related posts when displaying author bio.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( '+ posts', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_box_slim_layout_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[bio]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( 'Bio', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( '"Bio" label', $this->plugin->textdomain ),
						'description'     => __( 'Text to show as toggle button to display author\'s bio when displaying related posts.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( 'Bio', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_box_slim_layout_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[meta_separator]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => '|',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Separator', $this->plugin->textdomain ),
						'description'     => __( 'Character used to separate author meta data information', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Select_Control',
						'type'            => 'select',
						'choices'         => array
						(
							'|' => array
							(
								'label'    => __( '|' ),
								'disabled' => false,
								'premium'  => false,
							),
							'||' => array
							(
								'label'    => __( '||' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'/' => array
							(
								'label'    => __( '/' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'//' => array
							(
								'label'    => __( '//' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'-' => array
							(
								'label'    => __( '–' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'--' => array
							(
								'label'    => __( '--' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'–' => array
							(
								'label'    => __( '–' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'·' => array
							(
								'label'    => __( '·' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'•' => array
							(
								'label'    => __( '•' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'>' => array
							(
								'label'    => __( '>' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'>>' => array
							(
								'label'    => __( '>>' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'~' => array
							(
								'label'    => __( '~' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'*' => array
							(
								'label'    => __( '*' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'⇄' => array
							(
								'label'    => __( '⇄' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'⊥' => array
							(
								'label'    => __( '⊥' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'⋄' => array
							(
								'label'    => __( '⋄' ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
							'<br>' => array
							(
								'label'    => __( 'Line break', $this->plugin->textdomain ),
								'disabled' => !$this->plugin->is_premium,
								'premium'  => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_bio',
			'title'              => __( 'Biography', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => 'molongui_bio_typography_settings',
					'display' => true,
					'setting' => array
					(
						'sanitize_callback' => 'esc_html',
					),
					'control' => array
					(
						'label'           => __( 'Typography', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Group_Label_Control',
						'type'            => 'molongui-compact-group-label',
						'active_callback' => '',
						'input_attrs'     => array(),
						'choices'         => array(),
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bio_text_size]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 12,
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Size', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'molongui-compact-range-flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 8,
							'max'     => 100,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bio_line_height]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 1,
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Line height', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'molongui-compact-range-flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 1,
							'max'     => 2,
							'step'    => 0.1,
							'suffix'  => '',
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bio_text_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => '',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Style', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Checkbox_Button_Control',
						'type'            => 'molongui-compact-image-checkbox',
						'choices'         => array
						(
							'normal' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-normal.png',
								'label'   => __( 'Normal', $this->plugin->textdomain ),
								'premium' => false,
							),
							'bold' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-bold.png',
								'label'   => __( 'Bold', $this->plugin->textdomain ),
								'premium' => false,
							),
							'italic' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-italic.png',
								'label'   => __( 'Italic', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'underline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-underline.png',
								'label'   => __( 'Underline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => true,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bio_text_case]',
					'display' => false,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'none',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Case', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-compact-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-none.png',
								'label'   => __( 'Leave as is', $this->plugin->textdomain ),
								'premium' => false,
							),
							'capitalize' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-capitalize.png',
								'label'   => __( 'Capitalize', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'uppercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-uppercase.png',
								'label'   => __( 'Uppercase', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'lowercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-lowercase.png',
								'label'   => __( 'Lowercase', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bio_text_align]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'justify',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Align', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-compact-image-radio',
						'choices'         => array
						(
							'left' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-left.png',
								'label'   => __( 'Left', $this->plugin->textdomain ),
								'premium' => false,
							),
							'center' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-center.png',
								'label'   => __( 'Center', $this->plugin->textdomain ),
								'premium' => false,
							),
							'right' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-right.png',
								'label'   => __( 'Right', $this->plugin->textdomain ),
								'premium' => false,
							),
							'justify' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/text-align/text-align-justify.png',
								'label'   => __( 'Justify', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => true,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[bio_text_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-compact-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_icons',
			'title'              => __( 'Social icons', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[show_icons]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'default',
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Social icons', $this->plugin->textdomain ),
						'description'     => __( 'Whether to show social media icons.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Text_Radio_Button_Control',
						'type'            => 'molongui-text-radio',
						'choices'         => array
						(
							'1' => array
							(
								'label'   => __( 'Show', $this->plugin->textdomain ),
								'premium' => false,
							),
							'0' => array
							(
								'label'   => __( 'Hide', $this->plugin->textdomain ),
								'premium' => false,
							),
						),
						'input_attrs'     => array
						(
							'premium' => false,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[icons_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'default',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Style', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'default' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-default.png',
								'label'   => __( 'Default', $this->plugin->textdomain ),
								'premium' => false,
							),
							'squared' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-squared.png',
								'label'   => __( 'Squared', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'circled' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-circled.png',
								'label'   => __( 'Circled', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'boxed' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-boxed.png',
								'label'   => __( 'Boxed', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'branded' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-branded.png',
								'label'   => __( 'Branded', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'branded-squared' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-branded-squared.png',
								'label'   => __( 'Branded squared', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'branded-squared-reverse' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-branded-squared-reverse.png',
								'label'   => __( 'Branded squared reverse', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'branded-circled' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-branded-circled.png',
								'label'   => __( 'Branded circled', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'branded-circled-reverse' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-branded-circled-reverse.png',
								'label'   => __( 'Branded circled reverse', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'branded-boxed' => array
							(
								'image'   => $this->plugin->url.'customizer/img/icons-style/icons-style-branded-boxed.png',
								'label'   => __( 'Branded boxed', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_icons_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[icons_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_icons_color_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[icons_size]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'normal',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Font size', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 8,
							'max'     => 100,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_icons_setting',
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_related',
			'title'              => __( 'Template', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[related_layout]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'layout-1',
						'transport'            => 'refresh',
						'validate_callback'    => '',
						'sanitize_callback'    => '',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Related entries template', $this->plugin->textdomain ),
						'description'     => __( 'The template to be used to render related entries section.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-image-radio',
						'choices'         => array
						(
							'layout-1' => array
							(
								'image'   => $this->plugin->url.'customizer/img/related-template/related-template-1.png',
								'label'   => __( 'Template 1', $this->plugin->textdomain ),
								'premium' => false,
							),
							'layout-2' => array
							(
								'image'   => $this->plugin->url.'customizer/img/related-template/related-template-2.png',
								'label'   => __( 'Template 2', $this->plugin->textdomain ),
								'premium' => false,
							),
							'layout-3' => array
							(
								'image'   => $this->plugin->url.'customizer/img/related-template/related-template-3.png',
								'label'   => __( 'Template 3', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[related_title]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( 'Related posts', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Section label', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( 'Related posts', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => 'molongui_active_box_stacked_layout_setting',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_strings[no_related_posts]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => __( 'This author does not have any more posts.', $this->plugin->textdomain ),
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_string',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( '"No related posts found" label', $this->plugin->textdomain ),
						'description'     => __( 'Text to display when no related entries are found.', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'WP_Customize_Control',
						'type'            => 'text',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium'     => false,
							'placeholder' => __( 'This author does not have any more posts.', $this->plugin->textdomain ),
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
			),
		),
		array
		(
			'id'                 => 'molongui_authorship_related_config',
			'title'              => __( 'Entries', $this->plugin->textdomain ),
			'description'        => __( '', $this->plugin->textdomain ),
			'display'            => true,
			'priority'           => '',
			'type'               => '',
			'capability'         => 'manage_options',
			'active_callback'    => '',
			'description_hidden' => true,
			'fields'             => array
			(
				array
				(
					'id'      => 'molongui_related_typography_settings',
					'display' => true,
					'setting' => array
					(
						'sanitize_callback' => 'esc_html',
					),
					'control' => array
					(
						'label'           => __( 'Typography', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Group_Label_Control',
						'type'            => 'molongui-compact-group-label',
						'active_callback' => '',
						'input_attrs'     => array(),
						'choices'         => array(),
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[related_text_size]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'normal',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Size', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Range_Control',
						'type'            => 'molongui-compact-range-flat',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => false,
							'min'     => 8,
							'max'     => 100,
							'step'    => 1,
							'suffix'  => 'px',
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[related_text_style]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => '',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Style', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Checkbox_Button_Control',
						'type'            => 'molongui-compact-image-checkbox',
						'choices'         => array
						(
							'normal' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-normal.png',
								'label'   => __( 'Normal', $this->plugin->textdomain ),
								'premium' => false,
							),
							'bold' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-bold.png',
								'label'   => __( 'Bold', $this->plugin->textdomain ),
								'premium' => false,
							),
							'italic' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-italic.png',
								'label'   => __( 'Italic', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'underline' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-style/font-style-underline.png',
								'label'   => __( 'Underline', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => true,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[related_text_case]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'none',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Case', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Image_Radio_Button_Control',
						'type'            => 'molongui-compact-image-radio',
						'choices'         => array
						(
							'none' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-none.png',
								'label'   => __( 'Leave as is', $this->plugin->textdomain ),
								'premium' => false,
							),
							'capitalize' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-capitalize.png',
								'label'   => __( 'Capitalize', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'uppercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-uppercase.png',
								'label'   => __( 'Uppercase', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
							'lowercase' => array
							(
								'image'   => $this->plugin->url.'fw/customizer/img/font-case/font-case-lowercase.png',
								'label'   => __( 'Lowercase', $this->plugin->textdomain ),
								'premium' => !$this->plugin->is_premium,
							),
						),
						'input_attrs'     => array(),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
				array
				(
					'id'      => $this->plugin->db_prefix.'_box[related_text_color]',
					'display' => true,
					'setting' => array
					(
						'type'                 => 'option',
						'capability'           => 'manage_options',
						'default'              => 'inherit',
						'transport'            => 'postMessage',
						'validate_callback'    => '',
						'sanitize_callback'    => 'molongui_authorship_sanitize_setting',
						'sanitize_js_callback' => '',
						'dirty'                => false,
					),
					'control' => array
					(
						'label'           => __( 'Color', $this->plugin->textdomain ),
						'description'     => __( '', $this->plugin->textdomain ),
						'priority'        => 10,
						'class'           => 'Molongui_Customize_Color_Control',
						'type'            => 'molongui-compact-color',
						'choices'         => array(),
						'input_attrs'     => array
						(
							'premium' => !$this->plugin->is_premium,
						),
						'allow_addition'  => false,
						'active_callback' => '',
					),
				),
			),
		),
	),
);