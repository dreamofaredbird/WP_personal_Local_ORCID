<?php

namespace Molongui\Fw\Includes;

use Molongui\Fw\Includes\Upsell;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Molongui\Fw\Includes\Settings' ) )
{
	class Settings
	{
		private $plugin;
		private $classes;
		private $slug_tab_more = 'more';
		public function __construct( $plugin, $tabs, $default_tab = '' )
		{
			$this->plugin = $plugin;
            if ( $default_tab == '' )
            {
                reset( $tabs );
	            $default_tab = key( $tabs );
                while ( $this->plugin->config['admin_tabs']['hide'][$default_tab] )
                {
	                next( $tabs );
                    $default_tab = key( $tabs );
                }
            }
			$this->tabs        = $tabs;
			$this->default_tab = $this->plugin->underscored_id . '_' . $default_tab;
			if ( !class_exists( 'Molongui\Fw\Includes\Upsell' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'includes/fw-class-upsell.php' );
			$this->classes['upsell'] = new Upsell( $this->plugin );
			if ( $this->classes['upsell']->empty_upsells() ) array_pop( $this->tabs );
		}
		public function add_menu_item()
		{
			if ( empty ( $GLOBALS['admin_page_hooks']['molongui'] ) )
			{
				add_menu_page( __( 'Molongui', 'molongui-common-framework' ), __( 'Molongui', 'molongui-common-framework' ), 'manage_options', 'molongui', array( $this, 'render_page_plugins' ), molongui_get_base64_svg( $this->get_admin_menu_icon() ), '59.1' );
				add_submenu_page( 'molongui', __( 'Plugins', 'molongui-common-framework' ), __( 'Plugins', 'molongui-common-framework' ), 'manage_options', 'molongui', array( $this, 'render_page_plugins' ) );
				add_submenu_page( 'molongui', __( 'About', 'molongui-common-framework' ), __( 'About', 'molongui-common-framework' ), 'manage_options', 'molongui-about', array( $this, 'render_page_about' ) );
				add_submenu_page( 'molongui', __( 'Support', 'molongui-common-framework' ), __( 'Support', 'molongui-common-framework' ), 'manage_options', 'molongui-support', array( $this, 'render_page_support' ) );
				$this->add_admin_menu_separator('59.2');
			}
			add_submenu_page( 'molongui', ucfirst( $this->plugin->name ).' Settings', ucfirst( $this->plugin->id ).' Settings', 'manage_options', $this->plugin->dashed_name, array( $this, 'render_page_plugin_settings' ) );
			$this->reorder_submenu_items();
		}
		private function get_admin_menu_icon()
		{
			return '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
						<g>
							<path d="M50,0C22.4,0,0,22.4,0,50c0,27.6,22.4,50,50,50s50-22.4,50-50C100,22.4,77.6,0,50,0z M27.8,66.3v0.4
								c-0.1,1.4-0.6,2.5-1.5,3.4c-1,0.9-2.1,1.4-3.5,1.4c-1.3,0-2.5-0.5-3.4-1.4c-1-0.9-1.5-2.1-1.5-3.4v-35c0.1-1.4,0.6-2.5,1.6-3.4
								c0.9-0.9,2.1-1.4,3.5-1.4c1.3,0,2.5,0.5,3.4,1.4c0.9,0.9,1.5,2.1,1.6,3.4V66.3z M81.9,66.5c0,1.4-0.5,2.6-1.5,3.5
								c-1,1-2.2,1.4-3.6,1.4c-1.4,0-2.6-0.5-3.6-1.5c-1-1-1.4-2.2-1.4-3.4v-19c0-1.2-0.1-2.5-0.3-3.8c-0.2-1.3-0.6-2.5-1.1-3.6
								c-0.6-1.1-1.4-2-2.5-2.7c-1.1-0.7-2.5-1.1-4.4-1.1c-1.8,0-3.3,0.3-4.4,1c-1.1,0.7-2,1.5-2.6,2.6c-0.6,1-1.1,2.2-1.3,3.5
								c-0.2,1.3-0.4,2.6-0.4,3.8v19c0,1.4-0.5,2.7-1.4,3.7c-0.9,1-2.1,1.6-3.7,1.6c-1.4,0-2.6-0.5-3.5-1.4c-1-1-1.4-2.1-1.4-3.5V47.2
								c0-1.2-0.1-2.4-0.3-3.7c-0.2-1.3-0.6-2.5-1.2-3.5c-0.6-1-1.4-1.9-2.5-2.6c-1.1-0.7-2.5-1-4.2-1c-1.5,0-2.8,0.3-3.8,0.8
								c-1,0.5-1.9,1.2-2.6,1.9v-9c1.1-0.8,2.4-1.5,3.9-2.2c1.5-0.6,3.3-1,5.4-1c1.1,0,2.2,0.1,3.4,0.4c1.2,0.3,2.4,0.7,3.6,1.3
								c1.1,0.6,2.2,1.4,3.2,2.5s1.9,2.4,2.6,4c0.6-1.1,1.4-2.1,2.3-3.1c0.9-1,1.9-1.9,3-2.6c1.1-0.7,2.4-1.3,3.8-1.8
								c1.4-0.5,3-0.7,4.7-0.7c1.8,0,3.7,0.3,5.7,0.9c2,0.6,3.8,1.7,5.4,3.4c1,1,1.7,2,2.4,3c0.6,1,1.1,2.1,1.4,3.3
								c0.3,1.2,0.5,2.6,0.7,4.2c0.1,1.6,0.2,3.4,0.2,5.6V66.5z"/>
						</g>
					</svg>';
		}
		private function add_admin_menu_separator( $position )
		{
			global $menu;

			$menu[ $position ] = array
            (
				0	=>	'',
				1	=>	'read',
				2	=>	'separator' . $position,
				3	=>	'',
				4	=>	'wp-menu-separator'
			);
		}
		private function reorder_submenu_items()
		{
			global $submenu;
			if ( !isset( $submenu['molongui'] ) or empty( $submenu['molongui'] ) ) return;
			$titles = array();
			foreach ( $submenu['molongui'] as $items )
			{
				$titles[] = $items[0];
			}
			array_multisort( $titles, SORT_ASC, $submenu['molongui'] );
			foreach ( $submenu['molongui'] as $key => $value )
			{
				if ( $value[2] == 'molongui' )         { $plugins_key = $key; $plugins = $value; }
				if ( $value[2] == 'molongui-support' ) { $support_key = $key; $support = $value; }
				if ( $value[2] == 'molongui-about' )   { $about_key   = $key; $about   = $value; }
			}
			unset( $submenu['molongui'][$plugins_key] );
			unset( $submenu['molongui'][$support_key] );
			unset( $submenu['molongui'][$about_key] );
			array_unshift( $submenu['molongui'], $plugins );        // Set "plugins" submenu at the top of the list.
			array_push( $submenu['molongui'], $support, $about );   // Set "support" and "about" submenus at the bottom.
		}
		public function render_page_plugins()
		{
			include molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'admin/views/html-admin-page-plugins.php';
		}
		public function render_page_support()
		{
			include molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'admin/views/html-admin-page-support.php';
		}
		public function render_page_about()
		{
			include molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'admin/views/html-admin-page-about.php';
		}
		public function render_page_plugin_settings()
		{
			$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->default_tab;
			$current_tab_id  = str_replace( $this->plugin->underscored_id.'_', '', $current_tab );
			$display_sidebar = ( !$this->plugin->is_premium and isset( $this->plugin->config['admin_tabs']['no_sidebar'][$current_tab_id] ) and !$this->plugin->config['admin_tabs']['no_sidebar'][$current_tab_id] ? true : false );
			$main_class = 'main' . ' ' . ( !$display_sidebar ? 'no-sidebar' : '' );

			?>

			<div id="molongui-settings" data-tab="<?php echo $current_tab_id; ?>" data-license="license-<?php echo ( $this->plugin->is_premium ? 'premium' : 'free' ); ?>" class="wrap molongui">

				<!-- Title -->
				<h2>
					<?php _e( $this->plugin->name, '' ); ?>
					<span class="version"><?php echo $this->plugin->version; ?></span>
					<span class="version"><?php echo ( $this->plugin->is_premium ? __( 'Premium', 'molongui-common-framework' ) : __( 'Free', 'molongui-common-framework' ) ); ?></span>
				</h2>

				<!-- Navigation -->
				<h2 class="nav-tab-wrapper">
					<?php
						foreach ( $this->tabs as $tab )
						{
							if ( $tab['slug'] == $this->plugin->underscored_id.'_'.'license' and !$this->plugin->is_premium ) continue;
							$tab_id = str_replace( $this->plugin->underscored_id.'_', '', $tab['slug'] );
							if ( isset( $this->plugin->config['admin_tabs']['hide'][$tab_id] ) and $this->plugin->config['admin_tabs']['hide'][$tab_id] ) continue;

							$active = $current_tab == $tab['slug'] ? 'nav-tab-active' : '';
							echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin->dashed_name . '&tab=' . $tab['slug'] . '">' . $tab['label'] . '</a>';
						}
					?>
				</h2>

				<?php settings_errors(); ?>

				<?php do_action( $this->plugin->underscored_name.'_settings_before_submit_button', $current_tab ); ?>

				<!-- Settings -->
				<div class="<?php echo $main_class; ?>">
					<form id="molongui-settings-form" method="post" action="options.php">
						<?php wp_nonce_field( 'update-options' ); ?>
						<?php settings_fields( $current_tab ); ?>
						<?php $this->molongui_do_settings_sections( $current_tab ); ?>
						<?php
							if ( !isset( $this->plugin->config['admin_tabs']['no_save'][$current_tab_id] ) or
                               (  isset( $this->plugin->config['admin_tabs']['no_save'][$current_tab_id] ) and !$this->plugin->config['admin_tabs']['no_save'][$current_tab_id] ) )
							{
								submit_button();
							}
						?>
					</form>
				</div>

				<?php do_action( $this->plugin->underscored_name.'_settings_after_submit_button', $current_tab ); ?>

				<!-- Sidebar -->
				<?php
				if ( $display_sidebar )
				{
					switch ( $current_tab )
					{
						case $this->plugin->underscored_id.'_'.$this->slug_tab_more:

							include molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'admin/views/html-admin-part-sidebar-rate.php';

						break;

						default:

							include molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'admin/views/html-admin-part-sidebar-upsell.php';

						break;
					}
				}
				?>

			</div>
			<?php
		}
		private function molongui_do_settings_sections( $page )
		{
			global $wp_settings_sections, $wp_settings_fields;

			if ( ! isset( $wp_settings_sections[$page] ) ) return;

			foreach ( (array) $wp_settings_sections[$page] as $section )
			{
				if ( $section['title'] ) echo "<h2>{$section['title']}</h2>\n";

				if ( $section['callback'] ) call_user_func( $section['callback'], $section );

				if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) ) continue;

				echo '<table class="form-table">';
				$this->molongui_do_settings_fields( $page, $section['id'] );
				echo '</table>';
			}
		}
		private function molongui_do_settings_fields( $page, $section )
		{
			global $wp_settings_fields;

			if ( !isset( $wp_settings_fields[$page][$section] ) ) return;

			foreach ( (array) $wp_settings_fields[$page][$section] as $field )
			{
				$class = '';

				if ( !empty( $field['args']['class'] ) )
				{
					$class = ' class="' . esc_attr( $field['args']['class'] ) . '"';
				}

				echo "<tr{$class}>";

				if ( !empty( $field['args']['label_for'] ) )
				{
					echo '<th scope="row"><label for="' . esc_attr( $field['args']['label_for'] ) . '">' . $field['title'] . '</label></th>';
				}
				else
				{
					echo '<th scope="row">'
					     . $field['title']
					     . ( isset( $field['args']['field']['tip'] ) ? molongui_help_tip( $field['args']['field']['tip'] ) : "" )
					     . ( ( isset( $field['args']['field']['premium'] ) and !empty( $field['args']['field']['premium'] ) ) ? $this->molongui_premium_setting( $field['args']['field']['premium'] ) : "" )
					     . '</th>';
				}

				echo '<td>';
				call_user_func($field['callback'], $field['args']);
				echo '</td>';
				echo '</tr>';
			}
		}
		private function molongui_premium_setting( $tip, $link = true, $allow_html = false )
		{
			if ( !$this->plugin->is_premium )
			{
				if ( $allow_html )
				{
					$tip = molongui_sanitize_tooltip( $tip );
				}
				else
				{
					$tip = esc_attr( $tip );
				}
				$html  = '';
				$html .= ( $link ? '<a href="' . $this->plugin->web . '" target="_blank">' : '' );
				$html .= '<i class="molongui-icon-star molongui-help-tip molongui-premium-setting" data-tip="' . $tip . '"></i>';
				$html .= ( $link ? '</a>' : '' );

				return $html;
			}
		}
		public function add_page_tabs()
		{
			foreach ( $this->tabs as $tab )
			{
				$this->register_tab( $tab );
			}
		}
        private function register_tab( $tab )
        {
            register_setting( $tab['slug'], $tab['key'], $tab['callback'] );
	        if ( !isset( $tab['sections'] ) or empty( $tab['sections'] ) ) return;
            foreach ( $tab['sections'] as $section )
            {
                if ( isset( $section['display'] ) and !$section['display'] ) continue;

                add_settings_section( $section['id'], $section['label'], array( $this, $section['callback'] ), $tab['slug'] );
                if ( !empty( $section['fields'] ) )
                {
                    foreach ( $section['fields'] as $field )
                    {
                        if ( isset( $field['display'] ) and !$field['display'] ) continue;

                        add_settings_field( $field['id'], $field['label'], array( $this, 'render_field' ), $tab['slug'], $section['id'], array( 'field' => $field, 'option_group' => $tab['key'] ) );
                    }
                }
            }
        }
		public function render_description( $args )
		{
			foreach ( $this->tabs as $tab )
			{
				foreach ( $tab['sections'] as $section )
				{
					if ( $section['id'] == $args['id'] ) echo '<p id="'.$section['id'].'-description" class="'.( isset( $section['d_class'] ) ? $section['d_class'] : '' ).'">' . $section['desc'] . '</p>';
				}
			}
		}
		public function render_class( $args )
		{
			foreach ( $this->tabs as $tab )
			{
				foreach ( $tab['sections'] as $section )
				{
					if ( $section['id'] == $args['id'] )
					{
						if ( !empty( $section['cb_args'] ))
						{
							foreach ( $section['cb_args'] as $key => $value )
							{
								${$key} = $value;
							}
						}
						$cname = 'Molongui\\Fw\\Includes\\'.$section['cb_class'];
						$class = new $cname( $this->plugin );
						echo $class->render_output();
					}
				}
			}
		}
		public function render_page( $args )
		{
			foreach ( $this->tabs as $tab )
			{
				foreach ( $tab['sections'] as $section )
				{
					if ( $section['id'] == $args['id'] )
					{
						if ( !empty( $section['cb_args'] ))
						{
							foreach ( $section['cb_args'] as $key => $value )
							{
								${$key} = $value;
							}
						}
						include( $section['cb_page'] );
					}
				}
			}
		}
		public function render_field( $args )
		{
			$field        = $args['field'];
			$option_group = $args['option_group'];
			if ( ! isset( $field['type'] ) )        return;
			if ( ! isset( $field['icon'] ) )        $field['icon']  = '';
			if ( ! isset( $field['id'] ) )          $field['id']    = '';
			if ( ! isset( $field['label'] ) )       $field['label'] = '';
			if ( ! isset( $field['desc'] ) )        $field['desc']  = '';
			if ( ! isset( $field['tip'] ) )         $field['tip']   = '';
			if ( ! isset( $field['name'] ) )        $field['name']  = '';
			if ( ! isset( $field['placeholder'] ) ) $field['placeholder'] = '';
			$options = get_option( $option_group );
			$default = isset( $field['default'] ) ? $field['default'] : '';
			$value   = isset( $options[ $field['id'] ] ) ? $options[ $field['id'] ] : $default;
			switch ( $field['type'] )
			{
				case 'text':
					if ( $field['icon'] and $field['icon']['position'] == 'left' ) $this->render_icon( $options, $field );
					echo '<input type="text" id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" placeholder="' . $field['placeholder'] . '" value="' . $value . '" class="regular-text ltr ' . ( ( isset( $field['class'] ) and $field['class'] ) ? $field['class'] : '' ) . ' ' . ( ( stripos( $field['id'], "activation_" ) !== false and $options[ $field['id'] ] ) ? 'molongui-field-validated' : '' ) . '" />' . ' ' . $field['desc'];
					if ( $field['icon'] and $field['icon']['position'] == 'right' ) $this->render_icon( $options, $field );
				break;

				case 'textarea':
					echo '<textarea id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" rows="5" cols="50">' . $value . '</textarea>';
				break;

				case 'select':
					if ( $field['icon'] and $field['icon']['position'] == 'left' ) $this->render_icon( $options, $field );
					echo '<select id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" class="' . $field['class'] . '">';
						foreach ( $field['options'] as $option )
						{
							echo '<option value="' . $option['value'] . '"' . selected( $options[$field['id']], $option['value'], false ) . ( ( isset( $option['disabled'] ) and $option['disabled'] ) ? 'disabled' : '' ) . '>' . $option['label'] . '</option>';
						}
					echo '</select>';
					if ( $field['icon'] and $field['icon']['position'] == 'right' ) $this->render_icon( $options, $field );
				break;

				case 'radio':
					foreach ( $field['options'] as $option )
					{
						echo '<input type="radio" id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" value="' . $option['value'] . '"' . checked( $option['value'], $options[$field['id']], false ) . '/>';
						echo '&nbsp;';
						echo '<label for="' . $option_group . '[' . $field['id'] . ']">' . $option['label'] . '</label>';
						echo '<br>';
					}
				break;

				case 'checkbox':
					echo '<input type="checkbox" id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" value="1"';
					echo checked( $options[$field['id']], "1" );
					echo '/>';
					echo '<label for="' . $field['id'] . '">' . $field['desc'] . '</label>';
				break;

				case 'checkboxes':

                    if ( isset( $field['options'][0]['id'] ) )
                    {
	                    usort($field['options'] , function ( $item1, $item2 )
	                    {
		                    if ( $item1['id'] == $item2['id'] ) return 0;
		                    return $item1['id'] < $item2['id'] ? -1 : 1;
	                    });
                    }

					echo '<ul id="' . $field['id'] . '">';
					foreach ( $field['options'] as $option )
					{
						echo '<li style="float:left; width:150px;">';
						echo '<input type="checkbox" id="' . $field['id'].'_'.$option['id'] . '" name="' . $option_group . '[' . $field['id'] . '_' . $option['id'] . ']" value="1"' . ( ( isset( $options[$field['id'].'_'.$option['id']] ) && $options[$field['id'].'_'.$option['id']] == 1 ) ? 'checked="checked"' : '')  . '/>';
						echo '<label for="' . $field['id'].'_'.$option['id'] . '">' . $option['label'] . '</label>';
						echo '</li>';
					}
					echo '</ul>';

				break;

				case 'colorpicker':
						echo '<input type="text" class="colorpicker" name="' . $option_group . '[' . $field['id'] . ']" value="' . $value . '">';
				break;

				case 'range':
					?>
					<input  type="range" id="<?php echo $field['id']; ?>" name="<?php echo $option_group.'['.$field['id'].']'; ?>" value="<?php echo $value; ?>" min="<?php echo $field['min']; ?>" max="<?php echo $field['max']; ?>" step="<?php echo ( $field['step'] ? $field['step'] : '1' ); ?>" oninput="<?php echo $field['id'].'_output'; ?>.value = <?php echo $field['id']; ?>.value">
					<output type="range" id="<?php echo $field['id'].'_output'; ?>" name="<?php echo $field['id'].'_output'; ?>"><?php echo $value; ?></output>
					<?php
				break;

				case 'toggle':
					?>
					<div class="switch">
						<input type="checkbox" id="<?php echo $field['id']; ?>" name="<?php echo $option_group.'['.$field['id'].']'; ?>" class="molongui-toggle molongui-toggle-<?php echo $field['style']; ?>" <?php checked( $value, 'on' ); ?>>
						<label for="<?php echo $field['id']; ?>" data-on="Yes" data-off="No"></label>
					</div>
					<?php
				break;

				case 'button':
						echo '<button id="' . $field['args']['id'] . '" class="' . $field['args']['class'] . '">' . $field['args']['label'] . '</button>';
				break;

				case 'link':
                    ?>
                        <a href="<?php echo $field['args']['url']; ?>" target="<?php echo ( ( isset( $field['args']['target'] ) and !empty( $field['args']['target'] ) ) ? $field['args']['target'] : '_self' ); ?>" id="<?php echo $field['args']['id']; ?>" class="<?php echo $field['args']['class']; ?>"><?php echo $field['args']['text']; ?></a>
                        <p class="molongui-settings-link-desc"><?php echo $field['desc']; ?></p>
                    <?php
				break;

				case 'number':
					if ( $field['icon'] and $field['icon']['position'] == 'left' ) $this->render_icon( $options, $field );
					echo '<input type="number" id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . ( $field['step'] ? $field['step'] : '1' ) . '" value="' . $value . '" class="' . ( ( stripos( $field['id'], "activation_" ) !== false and $options[ $field['id'] ] ) ? 'molongui-field-validated' : '' ) . '" />' . ' ' . $field['desc'];
					if ( $field['icon'] and $field['icon']['position'] == 'right' ) $this->render_icon( $options, $field );
				break;

				case 'password':
					if ( $field['icon'] and $field['icon']['position'] == 'left' ) $this->render_icon( $options, $field );
					echo '<input type="password" id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" value="' . $value . '" class="regular-text ltr ' . ( ( stripos( $field['id'], "activation_" ) !== false and $options[ $field['id'] ] ) ? 'molongui-field-validated' : '' ) . '" />' . ' ' . $field['desc'];
					if ( $field['icon'] and $field['icon']['position'] == 'right' ) $this->render_icon( $options, $field );
				break;

				case 'email':
					if ( $field['icon'] and $field['icon']['position'] == 'left' ) $this->render_icon( $options, $field );
					echo '<input type="email" id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" placeholder="' . $field['placeholder'] . '" value="' . $value . '" class="regular-text ltr ' . ( ( stripos( $field['id'], "activation_" ) !== false and $options[ $field['id'] ] ) ? 'molongui-field-validated' : '' ) . '" />' . ' ' . $field['desc'];
					if ( $field['icon'] and $field['icon']['position'] == 'right' ) $this->render_icon( $options, $field );
				break;

				case 'date':
					if ( $field['icon'] and $field['icon']['position'] == 'left' ) $this->render_icon( $options, $field );
					echo '<input type="date" id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" min="' . $field['min'] . '" max="' . $field['max'] . '" value="' . $value . '" class="regular-text ltr ' . ( ( stripos( $field['id'], "activation_" ) !== false and $options[ $field['id'] ] ) ? 'molongui-field-validated' : '' ) . '" />' . ' ' . $field['desc'];
					if ( $field['icon'] and $field['icon']['position'] == 'right' ) $this->render_icon( $options, $field );
				break;

				case 'dropdown_pages':
					$args = array
					(
						'depth'                 => 0,
						'child_of'              => 0,
						'selected'              => $options[$field['id']],
						'echo'                  => 1,
						'name'                  => $option_group.'['.$field['id'].']',
						'id'                    => $field['id'],
						'class'                 => $field['class'],
						'show_option_none'      => null, // string
						'show_option_no_change' => null, // string
						'option_none_value'     => null, // string
					);
					wp_dropdown_pages( $args );
				break;

				case 'dropdown_users':
					$args = array
                    (
						'show_option_all'         => null, // string
						'show_option_none'        => null, // string
						'hide_if_only_one_author' => null, // string
						'orderby'                 => 'display_name',
						'order'                   => 'ASC',
						'include'                 => null, // string
						'exclude'                 => null, // string
						'multi'                   => false,
						'show'                    => 'display_name',
						'echo'                    => true,
						'selected'                => $options[$field['id']],
						'include_selected'        => false,
						'name'                    => $option_group.'['.$field['id'].']',
						'id'                      => $field['id'],
						'class'                   => $field['class'],
						'blog_id'                 => $GLOBALS['blog_id'],
						'who'                     => null, // string,
						'role'                    => null, // string|array,
						'role__in'                => null, // array
						'role__not_in'            => null, // array
					);
					wp_dropdown_users( $args );
				break;

				case 'dropdown_roles':
					echo '<select id="' . $field['id'] . '" name="' . $option_group . '[' . $field['id'] . ']" class="' . $field['class'] . '">';
                        wp_dropdown_roles( $options[$field['id']] );
                    echo '</select>';
				break;

				case 'html':
					ob_start();
					include( $field['template'] );
					echo ob_get_clean();
				break;
			}
		}
		public function render_icon( $options, $field )
		{
			switch ( $field['icon']['type'] )
			{
				case 'status':

					if ( $options[ $field['id'] ] )
					{
						echo '<i class="molongui-icon-check-circled molongui-license-data-ok"></i>';
					}
					else
					{
						echo '<i class="molongui-icon-notice molongui-license-data-ko"></i>';
					}

				break;

				case 'tip':

					echo '<span class="molongui-help-tip" data-tip="' . $field['icon']['tip'] . '">?</span>';

				break;
			}
		}

	} // End of 'Settings_Page' class
}