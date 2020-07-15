<?php

namespace Molongui\Fw\Customizer;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\Customizer\Customizer' ) )
{
	class Customizer
	{
		private $plugin;
		public function __construct( $plugin )
		{
			$this->plugin = $plugin;
			foreach ( glob( plugin_dir_path( __FILE__ ).'controls/classes/*.php' ) as $file )
			{
				require_once $file;
			}
			require_once( 'customizer-helper-callbacks.php' );
			require_once( $this->plugin->dir . 'customizer/plugin-customizer-callbacks.php' );
			add_action( 'customize_register', array( $this, 'molongui_customizer_settings' ) );
			add_action( 'customize_preview_init', array( $this, 'molongui_customizer_preview' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'molongui_customizer_hide_settings' ) );
		}
		public function molongui_customizer_settings( $wp_customize )
		{
			$styles = include( $this->plugin->dir . 'config/customizer.php' );
			if ( !isset( $styles ) and empty( $styles ) ) return;
			if ( $styles['add_panel'] )
			{
				$wp_customize->add_panel( $styles['id'], array
				(
					'title'           => $styles['title'],
					'description'     => $styles['description'],
					'priority'        => ( ( isset( $styles['priority'] ) and !empty( $styles['priority'] ) ) ? $styles['priority'] : '10' ),
					'capability'      => ( ( isset( $styles['capability'] ) and !empty( $styles['capability'] ) ) ? $styles['capability'] : 'manage_options' ),
					'active_callback' => ( ( isset( $styles['active_callback'] ) and !empty( $styles['active_callback'] ) ) ? $styles['active_callback'] : '' ),
				));
			}
			$wp_customize->add_panel( $styles['id'], array
			(
				'title'           => $styles['title'],
				'description'     => $styles['description'],
				'priority'        => ( ( isset( $styles['priority'] ) and !empty( $styles['priority'] ) ) ? $styles['priority'] : '10' ),
				'capability'      => ( ( isset( $styles['capability'] ) and !empty( $styles['capability'] ) ) ? $styles['capability'] : 'manage_options' ),
				'active_callback' => ( ( isset( $styles['active_callback'] ) and !empty( $styles['active_callback'] ) ) ? $styles['active_callback'] : '' ),
			));
			if ( isset( $styles['sections'] ) and !empty( $styles['sections'] ) )
			{
				foreach( $styles['sections'] as $section )
				{
					if ( !$section['display'] ) continue;
					$args = array
					(
						'title'              => $section['title'],
						'description'        => $section['description'],
						'priority'           => ( ( isset( $section['priority'] ) and !empty( $section['priority'] ) ) ? $section['priority'] : 10 ),
						'type'               => ( ( isset( $section['type'] ) and !empty( $section['type'] ) ) ? $section['type'] : '' ),
						'capability'         => ( ( isset( $section['capability'] ) and !empty( $section['capability'] ) ) ? $section['capability'] : 'manage_options' ),
						'active_callback'    => ( ( isset( $section['active_callback'] ) and !empty( $section['active_callback'] ) ) ? $section['active_callback'] : '' ),
						'description_hidden' => ( ( isset( $section['description_hidden'] ) and !empty( $section['description_hidden'] ) ) ? $section['description_hidden'] : false ),
					);
					if ( $styles['add_panel'] ) $args['panel'] = $styles['id'];
					$wp_customize->add_section( $section['id'] , $args );
					if ( isset( $section['fields'] ) and !empty( $section['fields'] ) )
					{
						foreach ( $section['fields'] as $field )
						{
							if ( !$field['display'] ) continue;
							if ( isset( $field['setting'] ) and !empty( $field['setting'] ) )
							{
								$wp_customize->add_setting( $field['id'], array
								(
									'type'                 => ( ( isset( $field['setting']['type'] ) and !empty( $field['setting']['type'] ) ) ? $field['setting']['type'] : 'option' ),
									'capability'           => ( ( isset( $field['setting']['capability'] ) and !empty( $field['setting']['capability'] ) ) ? $field['setting']['capability'] : 'manage_options' ),
									'default'              => ( ( isset( $field['setting']['default'] ) and !empty( $field['setting']['default'] ) ) ? $field['setting']['default'] : '' ),
									'transport'            => ( ( isset( $field['setting']['transport'] ) and !empty( $field['setting']['transport'] ) ) ? $field['setting']['transport'] : 'refresh' ),
									'validate_callback'    => ( ( isset( $field['setting']['validate_callback'] ) and !empty( $field['setting']['validate_callback'] ) ) ? $field['setting']['validate_callback'] : '' ),
									'sanitize_callback'    => ( ( isset( $field['setting']['sanitize_callback'] ) and !empty( $field['setting']['sanitize_callback'] ) ) ? $field['setting']['sanitize_callback'] : '' ),
									'sanitize_js_callback' => ( ( isset( $field['setting']['sanitize_js_callback'] ) and !empty( $field['setting']['sanitize_js_callback'] ) ) ? $field['setting']['sanitize_js_callback'] : '' ),
									'dirty'                => ( ( isset( $field['setting']['dirty'] ) and !empty( $field['setting']['dirty'] ) ) ? $field['setting']['dirty'] : false ),
								));
								if ( isset( $field['control'] ) and !empty( $field['control'] ) )
								{
									$class = ( ( isset( $field['control']['class'] ) and !empty( $field['control']['class'] ) ) ? $field['control']['class'] : 'WP_Customize_Control' );
									$wp_customize->add_control( new $class( $wp_customize, $field['id'], array
									(
										'settings'        => $field['id'], // or also: array( 'default' => $field['id'] ),
										'capability'      => ( ( isset( $field['setting']['capability'] ) and !empty( $field['setting']['capability'] ) ) ? $field['setting']['capability'] : 'manage_options' ),
										'priority'        => ( ( isset( $field['control']['priority'] ) and !empty( $field['control']['priority'] ) ) ? $field['control']['priority'] : 10 ),
										'section'         => ( ( isset( $field['control']['section'] ) and !empty( $field['control']['section'] ) ) ? $field['control']['section'] : $section['id'] ),
										'label'           => ( ( isset( $field['control']['label'] ) and !empty( $field['control']['label'] ) ) ? $field['control']['label'] : '' ),
										'description'     => ( ( isset( $field['control']['description'] ) and !empty( $field['control']['description'] ) ) ? $field['control']['description'] : '' ),
										'choices'         => ( ( isset( $field['control']['choices'] ) and !empty( $field['control']['choices'] ) ) ? $field['control']['choices'] : array() ),
										'input_attrs'     => ( ( isset( $field['control']['input_attrs'] ) and !empty( $field['control']['input_attrs'] ) ) ? $field['control']['input_attrs'] : array() ),
										'allow_addition'  => ( ( isset( $field['control']['allow_addition'] ) and !empty( $field['control']['allow_addition'] ) ) ? $field['control']['allow_addition'] : false ),
										'type'            => ( ( isset( $field['control']['type'] ) and !empty( $field['control']['type'] ) ) ? $field['control']['type'] : 'text' ),
										'active_callback' => ( ( isset( $field['control']['active_callback'] ) and !empty( $field['control']['active_callback'] ) ) ? $field['control']['active_callback'] : '' ),
									)));
								}
							}
						}
					}
				}
			}
		}
		public function molongui_customizer_preview()
		{
			if ( !$this->plugin->is_premium )
			{
				$fpath = 'customizer/css/live-preview.min.css';
				if ( file_exists( $this->plugin->dir . $fpath ) )
				{
					wp_enqueue_style( $this->plugin->dashed_name.'-preview', $this->plugin->url . $fpath, array(), $this->plugin->version );
				}
			}
			$fpath = 'customizer/js/live-preview.min.js';
			if ( file_exists( $this->plugin->dir . $fpath ) )
			{
				wp_enqueue_script( $this->plugin->dashed_name.'-preview', $this->plugin->url . $fpath, array( 'jquery', 'customize-preview' ), $this->plugin->version );
			}
		}
		public function molongui_customizer_hide_settings()
		{
			$fw_version  = molongui_get_constant( $this->plugin->id, 'VERSION', true );
			$fpath = 'fw/customizer/css/styles.cb33.min.css';
			if ( file_exists( $this->plugin->dir . $fpath ) )
			{
				wp_enqueue_style( 'molongui-framework-preview', $this->plugin->url . $fpath, array(), $fw_version );
			}
			$fpath = 'fw/customizer/js/scripts.da39.min.js';
			if ( file_exists( $this->plugin->dir . $fpath ) )
			{
				wp_enqueue_script( 'molongui-framework-preview', $this->plugin->url . $fpath, array( 'jquery', 'customize-preview' ), $fw_version );

				if ( $this->plugin->is_upgradable and !$this->plugin->is_premium )
				{
					$script = sprintf( '
								( function($) {
									$( window ).load( function()
									{
										$( "#sub-accordion-panel-%s" ).append(
											"<li class=\"molongui-accordion-section-divider\">" +
												"<span>%s</span>" +
												"<p>%s</p>" +
											"</li>" +
											"<li class=\"accordion-section control-section control-section- control-subsection molongui-upgrade-link\">" +
												"<a href=\"%s\" target=\"_blank\"><h3 class=\"accordion-section-title\" tabindex=\"0\">%s</h3></a>" +
											"</li>"
										);
									});
								})(jQuery);
								', $this->plugin->dashed_name, __( 'Premium features', 'molongui-framework-preview' ), __( 'Take a look at all the available premium features.', 'molongui-framework-preview' ), $this->plugin->web, __( 'Go Premium', 'molongui-framework-preview' ) );
					wp_add_inline_script( 'molongui-framework-preview', $script );
				}
			}
			$fpath = 'customizer/js/customizer-scripts.min.js';
			if ( file_exists( $this->plugin->dir . $fpath ) )
			{
				wp_enqueue_script( $this->plugin->dashed_name.'-scripts', $this->plugin->url . $fpath, array( 'jquery', 'customize-preview' ), $this->plugin->version );
			}
		}

	}
}