<?php

use Molongui\Fw\Includes\Sysinfo;
if ( !defined( 'ABSPATH' ) ) exit;

?>

<div class="molongui-support-wrap">

	<h3><?php _e( 'Need help?', 'molongui-common-framework' ); ?></h3>

	<!-- Quick buttons -->
	<div class="quick-support-buttons">

		<!-- Documentation -->
		<a class="quick-support-button" href="<?php echo molongui_get_constant( $this->plugin->id, 'MOLONGUI_WEB', true ); ?>docs/">
			<div class="quick-support-button-icon"><i class="molongui-icon-book-open"></i></div>
			<div class="quick-support-button-title"><?php _e( 'Read the docs', 'molongui-common-framework' ); ?></div>
			<div class="quick-support-button-text"><?php _e( 'Learn the basics to help you make the most of Molongui plugins.', 'molongui-common-framework' ); ?></div>
		</a>

		<!-- Get report -->
		<a class="quick-support-button" id="get-molongui-support-report" download="molongui_support_report.txt" href="#">
			<div class="quick-support-button-icon"><i class="molongui-icon-doc-text"></i></div>
			<div class="quick-support-button-title"><?php _e( 'Get report', 'molongui-common-framework' ) ?></div>
			<div class="quick-support-button-text"><?php _e( 'Download and attach this information in your ticket when contacting support.', 'molongui-common-framework' ); ?></div>
		</a>

		<!-- Send report -->
		<a class="quick-support-button" id="send-molongui-support-report" href="#">
			<div class="quick-support-button-icon"><i class="molongui-icon-paper-plane-empty"></i></div>
			<div class="quick-support-button-title"><?php _e( 'Send report', 'molongui-common-framework' ) ?></div>
			<div class="quick-support-button-text"><?php _e( 'Submit report only if instructed so by the Molongui Support Team.', 'molongui-common-framework' ); ?></div>
		</a>

		<!-- Help request -->
		<a class="quick-support-button" href="<?php echo molongui_get_constant( $this->plugin->id, 'MOLONGUI_WEB', true ); ?>support/">
			<div class="quick-support-button-icon"><i class="molongui-icon-tip-circled"></i></div>
			<div class="quick-support-button-title"><?php _e( 'Help request', 'molongui-common-framework' ); ?></div>
			<div class="quick-support-button-text"><?php _e( 'Unable to find what you are looking for? Open a support ticket to get help.', 'molongui-common-framework' ); ?></div>
		</a>

		<!-- Upgrade -->
		<a class="quick-support-button" href="<?php echo $this->plugin->web; ?>">
			<div class="quick-support-button-icon"><i class="molongui-icon-star"></i></div>
			<div class="quick-support-button-title"><?php _e( 'Upgrade!', 'molongui-common-framework' ); ?></div>
			<div class="quick-support-button-text"><?php _e( 'Upgrade to unlock all premium features.', 'molongui-common-framework' ); ?></div>
		</a>

	</div>

	<!-- System information buttons -->
	<!--	<div class="notice notice-info molongui-message inline">
		<p><?php _e( 'Please download and attach this information in your ticket when contacting support:', 'molongui-common-framework' ); ?> </p>
		<p class="submit">
			<a id="get-support-report" download="molongui_support_report.txt" href="#" class="button"><?php _e( 'Download report as text file', 'molongui-common-framework' ) ?></a>
			<a id="send-support-report" href="#" class="button"><?php _e( 'Send report to Molongui', 'molongui-common-framework' ) ?></a>
		</p>
	</div>
-->
	<!--
	<p class="text"><?php _e( 'This page displays information about your WordPress configuration and Server information that may be useful for debugging.', 'molongui-common-framework' ); ?></p>
-->
	<!-- Plugin information -->
	<table id="plugin" class="status-table widefat" cellspacing="0">
		<thead>
		<tr>
			<th colspan="3" data-export-label="Plugin information"><h2><?php _e( 'Plugin information', 'molongui-common-framework' ); ?></h2></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td data-export-label="Plugin name"><?php _e( 'Name', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The name of this plugin.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $this->plugin->name; ?></td>
		</tr>
		<tr>
			<td data-export-label="Plugin License"><?php _e( 'License', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The license of this plugin.', 'molongui-common-framework' ) ); ?></td>
			<td>
				<?php echo ( $this->plugin->is_premium ? __( 'Premium', 'molongui-common-framework' ) : __( 'Free', 'molongui-common-framework' ) ); ?>
				<?php if ( !$this->plugin->is_premium && $this->plugin->is_upgradable ) : ?>
					<a href="<?php echo $this->plugin->web; ?>" class="button-upgrade" target="_blank">
						<?php _e( 'Upgrade now!', 'molongui-common-framework' ); ?>
					</a>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td data-export-label="Plugin Version"><?php _e( 'Version', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The version of the plugin installed on your site.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $this->plugin->version; ?></td>
		</tr>
		<tr>
			<td data-export-label="Plugin framework"><?php _e( 'Framework', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The Molongui Framework this plugin is using.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo molongui_get_constant( $this->plugin->id, 'NAME', true ); ?> - <?php echo molongui_get_constant( $this->plugin->id, 'VERSION', true ); ?></td>
		</tr>
		<tr>
			<td data-export-label="Database Version"><?php _e( 'Database Version', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The version of the plugin that the database is formatted for.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $this->plugin->db_version; ?></td>
		</tr>
		</tbody>
	</table><!-- /#plugin -->

	<!-- Plugin settings -->
	<table id="plugin-settings" class="status-table widefat hidden" cellspacing="0">
		<thead>
		<tr>
			<th colspan="3" data-export-label="Plugin settings"><h2><?php _e( 'Plugin settings', 'molongui-common-framework' ); ?></h2></th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $this->plugin->settings as $id => $value )
		{
			echo '<tr>';
			echo '<td data-export-label="'.$id.'">'.$id.':</td>';
			echo '<td class="help">'.''.'</td>';
			echo '<td>';
			if ( molongui_is_bool( $value ) ) echo ( '1' === $value ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' );
			else echo $value;
			echo '</td>';
			echo '</tr>';
		}
		?>
		</tbody>
	</table><!-- /#plugin-settings -->

	<!-- WordPress Environment -->
	<table id="wp" class="status-table widefat" cellspacing="0">
		<thead>
		<tr>
			<th colspan="3" data-export-label="WordPress Environment"><h2><?php _e( 'WordPress Environment', 'molongui-common-framework' ); ?></h2></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td data-export-label="Home URL"><?php _e( 'Home URL', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The URL of your site\'s homepage.', 'molongui-common-framework' ) ); ?></td>
			<td><?php form_option( 'home' ); ?></td>
		</tr>
		<tr>
			<td data-export-label="Site URL"><?php _e( 'Site URL', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The root URL of your site.', 'molongui-common-framework' ) ); ?></td>
			<td><?php form_option( 'siteurl' ); ?></td>
		</tr>
		<tr>
			<td data-export-label="WP Version"><?php _e( 'Version', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The version of WordPress installed on your site.', 'molongui-common-framework' ) ); ?></td>
			<td><?php bloginfo('version'); ?></td>
		</tr>
		<tr>
			<td data-export-label="WP Multisite"><?php _e( 'Multisite', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Whether or not you have WordPress Multisite enabled.', 'molongui-common-framework' ) ); ?></td>
			<td><?php if ( is_multisite() ) echo '<span class="dashicons dashicons-yes"></span>'; else echo '&ndash;'; ?></td>
		</tr>
		<tr>
			<td data-export-label="WP Table Prefix"><?php _e( 'DB table prefix', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'WordPress database table prefix.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $wpdb->prefix; ?></td>
		</tr>
		<tr>
			<td data-export-label="WP Memory Limit"><?php _e( 'Memory Limit', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The maximum amount of memory (RAM) that your site can use at one time.', 'molongui-common-framework' ) ); ?></td>
			<td>
				<?php
				$memory = molongui_let_to_num( WP_MEMORY_LIMIT );

				if ( $memory < 67108864 )
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( __( '%s - We recommend setting memory to at least 64MB. See: %s', 'molongui-common-framework' ), size_format( $memory ), '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . __( 'Increasing memory allocated to PHP', 'molongui-common-framework' ) . '</a>' ) . '</mark>';
				else
					echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="WP Permalink Strucutre"><?php _e( 'Permalink strucutre', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'WordPress permalink structure.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo get_option( 'permalink_structure' ); ?></td>
		</tr>
		<tr>
			<td data-export-label="WP Registered Post Status"><?php _e( 'Registered post status', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'WordPress registered post status types.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo implode( ', ', get_post_stati() ); ?></td>
		</tr>
		<tr>
			<td data-export-label="WP Cron"><?php _e( 'Cron', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Displays whether or not WP Cron Jobs are enabled.', 'molongui-common-framework' ) ); ?></td>
			<td>
				<?php if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) : ?>
					<mark class="no">&ndash;</mark>
				<?php else : ?>
					<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td data-export-label="WP Debug Mode"><?php _e( 'Debug Mode', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Displays whether or not WordPress is in Debug Mode.', 'molongui-common-framework' ) ); ?></td>
			<td>
				<?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
					<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
				<?php else : ?>
					<mark class="no">&ndash;</mark>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td data-export-label="WP Timezone"><?php _e( 'Timezone', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'WordPress timezone.', 'molongui-common-framework' ) ); ?></td>
			<td><?php $tz = get_option('timezone_string'); echo $tz; if( !empty( $tz ) ) echo ' ('; echo 'GMT '.get_option('gmt_offset'); if( !empty( $tz ) ) echo ')'; ?></td>
		</tr>
		<tr>
			<td data-export-label="Language"><?php _e( 'Language', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The current language used by WordPress. Default = English', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo get_locale(); ?></td>
		</tr>
		</tbody>
	</table><!-- /#wp -->

	<!-- Active Theme -->
	<table id="theme" class="status-table widefat" cellspacing="0">
		<thead>
		<tr>
			<th colspan="3" data-export-label="Theme"><h2><?php _e( 'Active theme', 'molongui-common-framework' ); ?></h2></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td data-export-label="Name"><?php _e( 'Name', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The name of the current active theme.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo esc_html( $active_theme->Name ); ?></td>
		</tr>
		<tr>
			<td data-export-label="Version"><?php _e( 'Version', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The installed version of the current active theme.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo esc_html( $active_theme->Version ); ?></td>
		</tr>
		<tr>
			<td data-export-label="Author"><?php _e( 'Author', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The theme developers.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $active_theme->{'Author'}; ?></td>
		</tr>
		<tr>
			<td data-export-label="Author URL"><?php _e( 'Author URL', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The theme developers URL.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $active_theme->{'Author URI'}; ?></td>
		</tr>
		<tr>
			<td data-export-label="Child Theme"><?php _e( 'Child Theme', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Displays whether or not the current theme is a child theme.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo is_child_theme() ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>'; ?></td>
		</tr>
		<?php if( is_child_theme() ) : $parent_theme = wp_get_theme( $active_theme->Template ); ?>
			<tr>
				<td data-export-label="Parent Theme Name"><?php _e( 'Parent Theme Name', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'The name of the parent theme.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo esc_html( $parent_theme->Name ); ?></td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Version"><?php _e( 'Parent Theme Version', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'The installed version of the parent theme.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo esc_html( $parent_theme->Version ); ?></td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Author URL"><?php _e( 'Parent Theme Author URL', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'The parent theme developers URL.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo $parent_theme->{'Author URI'}; ?></td>
			</tr>
		<?php endif ?>
		</tbody>
	</table><!-- /#theme -->

	<!-- Installed Themes -->
	<table id="themes" class="status-table widefat" cellspacing="0">
		<thead>
		<tr>
			<th colspan="3" data-export-label="Installed themes"><h2><?php _e( 'Installed themes', 'molongui-common-framework' ); ?></h2></th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $themes as $theme )
		{
			?>
			<tr>
				<td><?php echo $theme['Name']; ?></td>
				<td class="help"><i class="molongui-icon-toggle-off molongui-help-tip" data-tip="<?php _e( 'Disabled', 'molongui-common-framework' ); ?>"></i></td>
				<td><?php echo sprintf( _x( 'by %s', 'by author', 'molongui-common-framework' ), $theme['Author'] ) . ' &ndash; ' . esc_html( $theme['Version'] ); ?></td>
			</tr>
		    <?php
		}
		?>
		</tbody>
	</table><!-- /#themes -->

	<!-- Installed Plugins -->
	<table id="plugins" class="status-table widefat" cellspacing="0">
		<thead>
		<tr>
			<th colspan="3" data-export-label="Installed plugins (<?php echo count( $active_plugins ); ?>/<?php echo count( $plugins ); ?>)"><h2><?php _e( 'Installed plugins', 'molongui-common-framework' ); echo ' ('.count( $active_plugins ).'/'.count( $plugins ).')'; ?></h2></th>
		</tr>
		</thead>
		<tbody>
		<?php

		foreach ( $active_plugins as $plugin )
		{
			$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$network_string = '';

			if ( !empty( $plugin_data['Name'] ) )
			{
				$plugin_name = esc_html( $plugin_data['Name'] );
				if ( !empty( $plugin_data['PluginURI'] ) )
				{
					$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . esc_attr__( 'Visit plugin homepage' , 'molongui-common-framework' ) . '" target="_blank">' . $plugin_name . '</a>';
				}
				if ( $plugin_data['Network'] != false )
				{
					$network_string = ' &ndash; <strong style="color:black;">' . __( 'Network enabled', 'molongui-common-framework' ) . '</strong>';
				}
				?>
				<tr>
					<td><?php echo $plugin_name; ?></td>
					<td class="help"><i class="molongui-icon-toggle-on molongui-help-tip" data-tip="<?php _e( 'Active', 'molongui-common-framework' ); ?>"></i></td>
					<td><?php echo sprintf( _x( 'by %s', 'by author', 'molongui-common-framework' ), $plugin_data['Author'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $network_string; ?></td>
				</tr>
			<?php
			}
		}

		foreach( $plugins as $plugin_path => $plugin )
		{
			if( in_array( $plugin_path, $active_plugins ) ) continue;
			$plugin_name = esc_html( $plugin['Name'] );
			if ( !empty( $plugin['PluginURI'] ) )
			{
				$plugin_name = '<a href="' . esc_url( $plugin['PluginURI'] ) . '" title="' . esc_attr__( 'Visit plugin homepage' , 'molongui-common-framework' ) . '" target="_blank">' . $plugin_name . '</a>';
			}
			$plugin_author = esc_html( $plugin['Author'] );
			if ( !empty( $plugin['AuthorURI'] ) )
			{
				$plugin_author = '<a href="' . esc_url( $plugin['AuthorURI'] ) . '" title="' . esc_attr__( 'Visit author homepage' , 'molongui-common-framework' ) . '" target="_blank">' . $plugin_author . '</a>';
			}
			if ( $plugin['Network'] != false )
			{
				$network_string = ' &ndash; <strong style="color:black;">' . __( 'Network enabled', 'molongui-common-framework' ) . '</strong>';
			}

			?>
			<tr>
				<td><?php echo $plugin_name; ?></td>
				<td class="help"><i class="molongui-icon-toggle-off molongui-help-tip" data-tip="<?php _e( 'Disabled', 'molongui-common-framework' ); ?>"></i></td>
				<td><?php echo sprintf( _x( 'by %s', 'by author', 'molongui-common-framework' ), $plugin_author ) . ' &ndash; ' . esc_html( $plugin['Version'] ) . $network_string; ?></td>
			</tr>
		<?php
		}

		?>
		</tbody>
	</table><!-- /#plugins -->

	<!-- Server Environment -->
	<table id="server" class="status-table widefat" cellspacing="0">
		<thead>
		<tr>
			<th colspan="3" data-export-label="Server Environment"><h2><?php _e( 'Server Environment', 'molongui-common-framework' ); ?></h2></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td data-export-label="Server Info"><?php _e( 'Server Info', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Information about the web server that is currently hosting your site.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
		</tr>
		<tr>
			<td data-export-label="Database Info"><?php _e( 'Database Info', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Information about the database installed on your hosting server.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo ( $wpdb->use_mysqli ? @mysqli_get_server_info( $wpdb->dbh ) : @mysql_get_server_info() ); ?></td>
		</tr>
		<tr>
			<td data-export-label="PHP Version"><?php _e( 'PHP Version', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The version of PHP installed on your hosting server.', 'molongui-common-framework' ) ); ?></td>
			<td>
				<?php
				if ( function_exists( 'phpversion' ) )
				{
					$php_version = phpversion();

					if ( version_compare( $php_version, '5.6', '<' ) )
					{
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( __( '%s - We recommend a minimum PHP version of 5.6. See: %s', 'molongui-common-framework' ), esc_html( $php_version ), '<a href="https://molongui.amitzy.com/kb/how-to-update-your-php-version/" target="_blank">' . __( 'How to update your PHP version', 'molongui-common-framework' ) . '</a>' ) . '</mark>';
					}
					else
					{
						echo '<mark class="yes">' . esc_html( $php_version ) . '</mark>';
					}
				}
				else
				{
					_e( "Couldn't determine PHP version because phpversion() doesn't exist.", 'molongui-common-framework' );
				}
				?>
			</td>
		</tr>
		<?php if ( function_exists( 'ini_get' ) ) : ?>
			<tr>
				<td data-export-label="PHP Safe Mode"><?php _e( 'PHP Safe Mode', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Whether PHP\'s safe mode is enabled.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ( ini_get( 'safe_mode' ) == "Yes" ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Memory Limit"><?php _e( 'PHP Memory Limit', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'The maximum amount of memory (RAM) that PHP can use at one time.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo size_format( molongui_let_to_num( ini_get( 'memory_limit' ) ) ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Post Max Size"><?php _e( 'PHP Post Max Size', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'The largest filesize that can be contained in one post.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo size_format( molongui_let_to_num( ini_get( 'post_max_size' ) ) ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Upload Max Size"><?php _e( 'PHP Upload Max Size', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'The largest filesize that can be uploaded to your WordPress installation.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo size_format( molongui_let_to_num( ini_get( 'upload_max_filesize' ) ) ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Time Limit"><?php _e( 'PHP Time Limit', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ini_get( 'max_execution_time' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Max Input Vars"><?php _e( 'PHP Max Input Vars', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ini_get( 'max_input_vars' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Arg Separator"><?php _e( 'PHP Arg Separator', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Character used as argument separator.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ini_get( 'arg_separator.output' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Display Errors"><?php _e( 'PHP Display Errors', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Does your site prints errors to the screen as part of the output?', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ( ini_get( 'display_errors' ) ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Allow URL File Open"><?php _e( 'PHP Allow URL File Open', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ( ini_get( 'allow_url_fopen' ) ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Session"><?php _e( 'PHP Session', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ( isset( $_SESSION ) ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Session Name"><?php _e( 'PHP Session Name', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ini_get( 'session.name' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Cookie Path"><?php _e( 'PHP Cookie Path', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ini_get( 'session.cookie_path' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Save Path"><?php _e( 'PHP Save Path', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ini_get( 'session.save_path' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Use Cookies"><?php _e( 'PHP Use Cookies', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ( ini_get( 'session.use_cookies' ) ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Use Only Cookies"><?php _e( 'PHP Use Only Cookies', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo ( ini_get( 'session.use_only_cookies' ) ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
			</tr>

			<tr>
				<td data-export-label="SUHOSIN Installed"><?php _e( 'SUHOSIN Installed', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'molongui-common-framework' ) ); ?></td>
				<td><?php echo extension_loaded( 'suhosin' ) ? '<span class="dashicons dashicons-yes"></span>' : '&ndash;'; ?></td>
			</tr>
			<tr>
				<td data-export-label="cURL Version"><?php _e( 'cURL Version', 'molongui-common-framework' ); ?>:</td>
				<td class="help"><?php echo molongui_help_tip( __( 'The version of cURL installed on your server.', 'molongui-common-framework' ) ); ?></td>
				<td>
					<?php
					if ( function_exists( 'curl_version' ) )
					{
						$curl_version = curl_version();
						echo $curl_version['version'] . ', ' . $curl_version['ssl_version'];
					} else {
						_e( 'N/A', 'molongui-common-framework' );
					}
					?>
				</td>
			</tr>
		<?php endif; ?>
		<?php
		$posting = array();
		$posting['fsockopen_curl']['name'] = 'fsockopen/cURL';
		$posting['fsockopen_curl']['help'] = molongui_help_tip( __( 'Some plugins can use cURL to communicate with remote servers.', 'molongui-common-framework' ) );

		if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
			$posting['fsockopen_curl']['success'] = true;
		} else {
			$posting['fsockopen_curl']['success'] = false;
			$posting['fsockopen_curl']['note']    = __( 'Your server does not have fsockopen or cURL enabled - some plugins which communicate with other servers will not work. Contact your hosting provider.', 'molongui-common-framework' );
		}
		$posting['soap_client']['name'] = 'SoapClient';
		$posting['soap_client']['help'] = molongui_help_tip( __( 'Some webservices use SOAP to get information from remote servers.', 'molongui-common-framework' ) );

		if ( class_exists( 'SoapClient' ) ) {
			$posting['soap_client']['success'] = true;
		} else {
			$posting['soap_client']['success'] = false;
			$posting['soap_client']['note']    = sprintf( __( 'Your server does not have the %s class enabled - some plugins which use SOAP may not work as expected.', 'molongui-common-framework' ), '<a href="https://php.net/manual/en/class.soapclient.php">SoapClient</a>' );
		}
		$posting['dom_document']['name'] = 'DOMDocument';
		$posting['dom_document']['help'] = molongui_help_tip( __( 'HTML/Multipart emails use DOMDocument to generate inline CSS in templates.', 'molongui-common-framework' ) );

		if ( class_exists( 'DOMDocument' ) ) {
			$posting['dom_document']['success'] = true;
		} else {
			$posting['dom_document']['success'] = false;
			$posting['dom_document']['note']    = sprintf( __( 'Your server does not have the %s class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', 'molongui-common-framework' ), '<a href="https://php.net/manual/en/class.domdocument.php">DOMDocument</a>' );
		}
		$posting['gzip']['name'] = 'GZip';
		$posting['gzip']['help'] = molongui_help_tip( __( 'GZip (gzopen) is used to open the GEOIP database from MaxMind.', 'molongui-common-framework' ) );

		if ( is_callable( 'gzopen' ) ) {
			$posting['gzip']['success'] = true;
		} else {
			$posting['gzip']['success'] = false;
			$posting['gzip']['note']    = sprintf( __( 'Your server does not support the %s function - this is required to use the GeoIP database from MaxMind.', 'molongui-common-framework' ), '<a href="https://php.net/manual/en/zlib.installation.php">gzopen</a>' );
		}
		$posting['mbstring']['name'] = 'Multibyte String';
		$posting['mbstring']['help'] = molongui_help_tip( __( 'Multibyte String (mbstring) is used to convert character encoding, like for emails or converting characters to lowercase.', 'molongui-common-framework' ) );

		if ( extension_loaded( 'mbstring' ) ) {
			$posting['mbstring']['success'] = true;
		} else {
			$posting['mbstring']['success'] = false;
			$posting['mbstring']['note']    = sprintf( __( 'Your server does not support the %s functions - this is required for better character encoding. Some fallbacks will be used instead for it.', 'molongui-common-framework' ), '<a href="https://php.net/manual/en/mbstring.installation.php">mbstring</a>' );
		}
		$posting['wp_remote_post']['name'] = __( 'Remote Post', 'molongui-common-framework');
		$posting['wp_remote_post']['help'] = molongui_help_tip( __( 'PayPal uses this method of communicating when sending back transaction information.', 'molongui-common-framework' ) );

		$response = wp_safe_remote_post( 'https://www.paypal.com/cgi-bin/webscr', array(
			'timeout'     => 60,
			'user-agent'  => 'Molongui/' . $this->plugin->version,
			'httpversion' => '1.1',
			'body'        => array(
				'cmd'    => '_notify-validate'
			)
		) );

		if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
			$posting['wp_remote_post']['success'] = true;
		} else {
			$posting['wp_remote_post']['note']    = __( 'wp_remote_post() failed. PayPal IPN won\'t work with your server. Contact your hosting provider.', 'molongui-common-framework' );
			if ( is_wp_error( $response ) ) {
				$posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Error: %s', 'molongui-common-framework' ), molongui_clean( $response->get_error_message() ) );
			} else {
				$posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Status code: %s', 'molongui-common-framework' ), molongui_clean( $response['response']['code'] ) );
			}
			$posting['wp_remote_post']['success'] = false;
		}
		$posting['wp_remote_get']['name'] = __( 'Remote Get', 'molongui-common-framework');
		$posting['wp_remote_get']['help'] = molongui_help_tip( __( 'Molongui plugins may use this method of communication when checking for plugin updates.', 'molongui-common-framework' ) );

		$response = wp_safe_remote_get( 'https://woocommerce.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) );

		if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
			$posting['wp_remote_get']['success'] = true;
		} else {
			$posting['wp_remote_get']['note']    = __( 'wp_remote_get() failed. The Molongui plugin updater won\'t work with your server. Contact your hosting provider.', 'molongui-common-framework' );
			if ( is_wp_error( $response ) ) {
				$posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Error: %s', 'molongui-common-framework' ), molongui_clean( $response->get_error_message() ) );
			} else {
				$posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Status code: %s', 'molongui-common-framework' ), molongui_clean( $response['response']['code'] ) );
			}
			$posting['wp_remote_get']['success'] = false;
		}

		foreach ( $posting as $post )
		{
			$mark = !empty( $post['success'] ) ? 'yes' : 'error';
			?>
			<tr>
				<td data-export-label="<?php echo esc_html( $post['name'] ); ?>"><?php echo esc_html( $post['name'] ); ?>:</td>
				<td class="help"><?php echo isset( $post['help'] ) ? $post['help'] : ''; ?></td>
				<td>
					<mark class="<?php echo $mark; ?>">
						<?php echo ! empty( $post['success'] ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no-alt"></span>'; ?> <?php echo ! empty( $post['note'] ) ? wp_kses_data( $post['note'] ) : ''; ?>
					</mark>
				</td>
			</tr>
		<?php
		}
		?>
		<tr>
			<td data-export-label="Default Timezone is UTC"><?php _e( 'Default Timezone is UTC', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'The default timezone for your server.', 'molongui-common-framework' ) ); ?></td>
			<td><?php
				$default_timezone = date_default_timezone_get();
				if ( 'UTC' !== $default_timezone ) {
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( __( 'Default timezone is %s - it should be UTC', 'molongui-common-framework' ), $default_timezone ) . '</mark>';
				} else {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} ?>
			</td>
		</tr>
		</tbody>
	</table><!-- /#server -->

	<!-- Client Environment -->
	<table id="client" class="status-table widefat" cellspacing="0">
		<thead>
		<tr>
			<th colspan="3" data-export-label="Client Environment"><h2><?php _e( 'Client Environment', 'molongui-common-framework' ); ?></h2></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td data-export-label="Platform"><?php _e( 'Platform', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Information of the platform being used.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $browser->getPlatform() . ' ' . ( $browser->isMobile() ? '(mobile)' : ( $browser->isTablet() ? '(tablet)' : '(desktop)' ) );?></td>
		</tr>
		<tr>
			<td data-export-label="Browser"><?php _e( 'Browser', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Information of the browser being used.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $browser->getBrowser() . ' ' . $browser->getVersion(); ?></td>
		</tr>
		<tr>
			<td data-export-label="User Agent"><?php _e( 'User Agent', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Information of the user agent being used.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $browser->getUserAgent(); ?></td>
		</tr>
		<tr>
			<td data-export-label="IP address"><?php _e( 'IP address', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( __( 'Your IP address.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo molongui_get_ip(); ?></td>
		</tr>
		</tbody>
	</table><!-- /#client -->

</div><!-- /.molongui-support-wrap -->