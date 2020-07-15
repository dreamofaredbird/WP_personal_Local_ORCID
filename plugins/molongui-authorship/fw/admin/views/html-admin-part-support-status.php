<?php
if ( !defined( 'ABSPATH' ) ) exit;
$theme       = $this->get_active_theme();
$themes      = $this->get_installed_themes();
$plugins     = $this->get_plugins();
$environment = $this->get_environment_info();
$client      = $this->get_client_info();
?>

<div class="molongui-support-wrap">

	<!-- Report buttons -->
	<div class="notice notice-info molongui-message inline">
		<p><?php esc_html_e( 'Please download and attach this report in your ticket when contacting support:', 'molongui-common-framework' ); ?> </p>
		<p class="submit">
			<a id="get-molongui-support-report"  href="#" class="button button-primary" download="molongui_support_report.txt"><?php esc_html_e( 'Download report as text file', 'molongui-common-framework' ) ?></a>
			<a id="send-molongui-support-report" href="#" class="button"><?php esc_html_e( 'Send report to Molongui', 'molongui-common-framework' ) ?></a>
		</p>
	</div>

	<!-- Molongui plugins information -->
    <?php foreach ( $plugins['molongui'] as $plugin ) : ?>

        <!-- Plugin information -->
	    <table id="<?php echo $plugin['id']; ?>-plugin" class="status-table widefat" cellspacing="0">
		<thead>
            <tr>
                <th colspan="3" data-export-label="<?php echo $plugin['Name']; ?> plugin information"><h2><?php echo $plugin['Name']; ?></h2></th>
            </tr>
		</thead>
		<tbody>
            <tr>
                <td data-export-label="Plugin name"><?php esc_html_e( 'Name', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The name of the plugin.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo $plugin['Name']; ?></td>
            </tr>
            <tr>
                <td data-export-label="Plugin License"><?php esc_html_e( 'License', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The license of the plugin.', 'molongui-common-framework' ) ); ?></td>
                <td>
                    <?php echo ( $plugin['is_premium'] ? esc_html__( 'Premium', 'molongui-common-framework' ) : esc_html__( 'Free', 'molongui-common-framework' ) ); ?>
                    <?php if ( !$plugin['is_premium'] and $plugin['is_upgradable'] ) : ?>
                        <a href="<?php echo $plugin['PluginURI']; ?>" class="button-upgrade" target="_blank">
                            <?php esc_html_e( 'Upgrade now!', 'molongui-common-framework' ); ?>
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="Plugin Version"><?php esc_html_e( 'Version', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The version of the plugin installed on your site.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo $plugin['Version']; ?></td>
            </tr>
            <tr>
                <td data-export-label="Plugin framework"><?php esc_html_e( 'Framework', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The Molongui Framework the plugin is using.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo $plugin['fw_name']; ?> - <?php echo $plugin['fw_version']; ?></td>
            </tr>
            <tr>
                <td data-export-label="Database Version"><?php esc_html_e( 'Database Version', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The version of the plugin that the database is formatted for.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo $plugin['db_version']; ?></td>
            </tr>
		</tbody>
	</table><!-- /#plugin -->

        <!-- Plugin settings -->
        <table id="<?php echo $plugin['id']; ?>-plugin-settings" class="status-table widefat hidden" cellspacing="0">
            <thead>
            <tr>
                <th colspan="3" data-export-label="Plugin settings"><h2><?php esc_html_e( 'Plugin settings', 'molongui-common-framework' ); ?></h2></th>
            </tr>
            </thead>
            <tbody>
		    <?php
                foreach ( $plugin['settings'] as $id => $value )
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

	<?php endforeach; ?>

    <!-- Installed Plugins -->
    <table id="plugins" class="status-table widefat" cellspacing="0">
        <thead>
        <tr>
            <th colspan="3" data-export-label="Installed plugins (<?php echo count( $plugins['active'] ); ?>/<?php echo count( $plugins['installed'] ); ?>)"><h2><?php esc_html_e( 'Installed plugins', 'molongui-common-framework' ); echo ' ('.count( $plugins['active'] ).'/'.count( $plugins['installed'] ).')'; ?></h2></th>
        </tr>
        </thead>
        <tbody>
		<?php
		foreach ( $plugins['active'] as $plugin )
		{
			$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$network_string = '';

			if ( !empty( $plugin_data['Name'] ) )
			{
				$plugin_name = esc_html( $plugin_data['Name'] );
				if ( !empty( $plugin_data['PluginURI'] ) ) $plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . esc_attr( 'Visit plugin homepage' , 'molongui-common-framework' ) . '" target="_blank">' . $plugin_name . '</a>';
				if ( $plugin_data['Network'] != false ) $network_string = ' &ndash; <strong style="color:black;">' . esc_html__( 'Network enabled', 'molongui-common-framework' ) . '</strong>';

				?>
                <tr>
                    <td><?php echo $plugin_name; ?></td>
                    <td class="help"><i class="molongui-icon-toggle-on molongui-help-tip" data-tip="<?php esc_html_e( 'Active', 'molongui-common-framework' ); ?>"></i></td>
                    <td><?php echo sprintf( _x( 'by %s', 'by author', 'molongui-common-framework' ), $plugin_data['Author'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $network_string; ?></td>
                </tr>
				<?php
			}
		}
		foreach( $plugins['installed'] as $plugin_path => $plugin )
		{
			if( in_array( $plugin_path, $plugins['active'] ) ) continue;
			$plugin_name = esc_html( $plugin['Name'] );
			if ( !empty( $plugin['PluginURI'] ) ) $plugin_name = '<a href="' . esc_url( $plugin['PluginURI'] ) . '" title="' . esc_attr( 'Visit plugin homepage' , 'molongui-common-framework' ) . '" target="_blank">' . $plugin_name . '</a>';
			$plugin_author = esc_html( $plugin['Author'] );
			if ( !empty( $plugin['AuthorURI'] ) ) $plugin_author = '<a href="' . esc_url( $plugin['AuthorURI'] ) . '" title="' . esc_attr( 'Visit author homepage' , 'molongui-common-framework' ) . '" target="_blank">' . $plugin_author . '</a>';
			if ( is_array( $plugins['network_active'] ) and in_array( $plugin_path, $plugins['network_active'] ) ) $network_string = ' &ndash; <strong style="color:black;">' . esc_html__( 'Network enabled', 'molongui-common-framework' ) . '</strong>';

			?>
            <tr>
                <td><?php echo $plugin_name; ?></td>
                <td class="help"><i class="molongui-icon-toggle-off molongui-help-tip" data-tip="<?php esc_html_e( 'Disabled', 'molongui-common-framework' ); ?>"></i></td>
                <td><?php echo sprintf( _x( 'by %s', 'by author', 'molongui-common-framework' ), $plugin_author ) . ' &ndash; ' . esc_html( $plugin['Version'] ) . $network_string; ?></td>
            </tr>
			<?php
		}
		?>
        </tbody>
    </table><!-- /#plugins -->

    <!-- Active Theme -->
    <table id="theme" class="status-table widefat" cellspacing="0">
        <thead>
        <tr>
            <th colspan="3" data-export-label="Theme"><h2><?php esc_html_e( 'Active theme', 'molongui-common-framework' ); ?></h2></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td data-export-label="Name"><?php esc_html_e( 'Name', 'molongui-common-framework' ); ?>:</td>
            <td class="help"><?php echo molongui_help_tip( esc_html__( 'The name of the current active theme.', 'molongui-common-framework' ) ); ?></td>
            <td><?php echo esc_html( $theme['name'] ); ?></td>
        </tr>
        <tr>
            <td data-export-label="Version"><?php esc_html_e( 'Version', 'molongui-common-framework' ); ?>:</td>
            <td class="help"><?php echo molongui_help_tip( esc_html__( 'The installed version of the current active theme.', 'molongui-common-framework' ) ); ?></td>
            <td><?php echo esc_html( $theme['version'] ); ?></td>
        </tr>
        <tr>
            <td data-export-label="Author"><?php esc_html_e( 'Author', 'molongui-common-framework' ); ?>:</td>
            <td class="help"><?php echo molongui_help_tip( esc_html__( 'The theme developers.', 'molongui-common-framework' ) ); ?></td>
            <td><?php echo esc_html( $theme['author'] ); ?></td>
        </tr>
        <tr>
            <td data-export-label="Author URL"><?php esc_html_e( 'Author URL', 'molongui-common-framework' ); ?>:</td>
            <td class="help"><?php echo molongui_help_tip( esc_html__( 'The theme developers URL.', 'molongui-common-framework' ) ); ?></td>
            <td><?php echo esc_html( $theme['author_url'] ); ?></td>
        </tr>
        <tr>
            <td data-export-label="Child Theme"><?php esc_html_e( 'Child Theme', 'molongui-common-framework' ); ?>:</td>
            <td class="help"><?php echo molongui_help_tip( esc_html__( 'Displays whether or not the current theme is a child theme.', 'molongui-common-framework' ) ); ?></td>
            <td><?php echo ( $theme['is_child_theme'] ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<span class="dashicons dashicons-no-alt"></span>&ndash;' ); ?></td>
        </tr>
		<?php if( $theme['is_child_theme'] ) : ?>
            <tr>
                <td data-export-label="Parent Theme Name"><?php esc_html_e( 'Parent Theme Name', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The name of the parent theme.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo esc_html( $theme['parent_name'] ); ?></td>
            </tr>
            <tr>
                <td data-export-label="Parent Theme Version"><?php esc_html_e( 'Parent Theme Version', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The installed version of the parent theme.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo esc_html( $theme['parent_version'] ); ?></td>
            </tr>
            <tr>
                <td data-export-label="Parent Theme Author URL"><?php esc_html_e( 'Parent Theme Author URL', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The parent theme developers URL.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo esc_html( $theme['parent_author_url'] ); ?></td>
            </tr>
		<?php endif ?>
        </tbody>
    </table><!-- /#theme -->

    <!-- Installed Themes -->
    <table id="themes" class="status-table widefat" cellspacing="0">
        <thead>
        <tr>
            <th colspan="3" data-export-label="Installed themes"><h2><?php esc_html_e( 'Installed themes', 'molongui-common-framework' ); ?></h2></th>
        </tr>
        </thead>
        <tbody>
		<?php
		foreach ( $themes as $theme )
		{
			?>
            <tr>
                <td><?php echo $theme['Name']; ?></td>
                <td class="help"><i class="molongui-icon-toggle-off molongui-help-tip" data-tip="<?php esc_html_e( 'Disabled', 'molongui-common-framework' ); ?>"></i></td>
                <td><?php echo sprintf( _x( 'by %s', 'by author', 'molongui-common-framework' ), $theme['Author'] ) . ' &ndash; ' . esc_html( $theme['Version'] ); ?></td>
            </tr>
			<?php
		}
		?>
        </tbody>
    </table><!-- /#themes -->

	<!-- WordPress environment -->
	<table id="wp" class="status-table widefat" cellspacing="0">
		<thead>
            <tr>
                <th colspan="3" data-export-label="WordPress environment"><h2><?php esc_html_e( 'WordPress environment', 'molongui-common-framework' ); ?></h2></th>
            </tr>
		</thead>
		<tbody>
            <tr>
                <td data-export-label="Home URL"><?php esc_html_e( 'Home URL', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The URL of your site.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo $environment['home_url']; ?></td>
            </tr>
            <tr>
                <td data-export-label="Site URL"><?php esc_html_e( 'Site URL', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The root URL of your site.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo $environment['site_url']; ?></td>
            </tr>
            <tr>
                <td data-export-label="WP Version"><?php esc_html_e( 'Version', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The version of WordPress installed on your site.', 'molongui-common-framework' ) ); ?></td>
                <td>
                    <?php
                        $latest_version = get_transient( 'molongui_system_status_wp_version_check' );

                        if ( false === $latest_version )
                        {
                            $version_check = wp_remote_get( 'https://api.wordpress.org/core/version-check/1.7/' );
                            $api_response  = json_decode( wp_remote_retrieve_body( $version_check ), true );

                            if ( $api_response and isset( $api_response['offers'], $api_response['offers'][0], $api_response['offers'][0]['version'] ) ) $latest_version = $api_response['offers'][0]['version'];
                            else $latest_version = $environment['wp_version'];

                            set_transient( 'molongui_system_status_wp_version_check', $latest_version, DAY_IN_SECONDS );
                        }

                        if ( version_compare( $environment['wp_version'], $latest_version, '<' ) ) echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - There is a newer version of WordPress available (%2$s)', 'molongui-common-framework' ), esc_html( $environment['wp_version'] ), esc_html( $latest_version ) ) . '</mark>';
                        else echo '<mark class="yes">' . esc_html( $environment['wp_version'] ) . '</mark>';
                    ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="WP Multisite"><?php esc_html_e( 'Multisite', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Whether or not you have WordPress Multisite enabled.', 'molongui-common-framework' ) ); ?></td>
                <td><?php if ( $environment['wp_multisite'] ) echo '<span class="dashicons dashicons-yes"></span>'; else echo '&ndash;'; ?></td>
            </tr>
            <tr>
                <td data-export-label="WP Memory Limit"><?php esc_html_e( 'Memory Limit', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'molongui-common-framework' ) ); ?></td>
                <td>
                    <?php
                    $memory = molongui_let_to_num( WP_MEMORY_LIMIT );

                    if ( $environment['wp_memory_limit'] < 67108864 )
                        echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend setting memory to at least 64MB. See: %2$s', 'molongui-common-framework' ), esc_html( size_format( $environment['wp_memory_limit'] ) ), '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'molongui-common-framework' ) . '</a>' ) . '</mark>';
                    else
                        echo '<mark class="yes">' . esc_html( size_format( $environment['wp_memory_limit'] ) ) . '</mark>';
                    ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="WP Debug Mode"><?php esc_html_e( 'Debug Mode', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Displays whether or not WordPress is in Debug Mode.', 'molongui-common-framework' ) ); ?></td>
                <td>
                    <?php if ( $environment['wp_debug_mode'] ) : ?>
                        <mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
                    <?php else : ?>
                        <mark class="no">&ndash;</mark>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="WP Cron"><?php esc_html_e( 'Cron', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Displays whether or not WP Cron Jobs are enabled.', 'molongui-common-framework' ) ); ?></td>
                <td>
                    <?php if ( $environment['wp_cron'] ) : ?>
                        <mark class="no">&ndash;</mark>
                    <?php else : ?>
                        <mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="WP Timezone"><?php esc_html_e( 'Timezone', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'WordPress timezone.', 'molongui-common-framework' ) ); ?></td>
                <td><?php $tz = get_option('timezone_string'); echo $tz; if( !empty( $tz ) ) echo ' ('; echo 'GMT '.get_option('gmt_offset'); if( !empty( $tz ) ) echo ')'; ?></td>
            </tr>
            <tr>
                <td data-export-label="Language"><?php esc_html_e( 'Language', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The current language used by WordPress. Default = English', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo $environment['language']; ?></td>
            </tr>
            <tr>
                <td data-export-label="WP Permalink Strucutre"><?php esc_html_e( 'Permalink strucutre', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'WordPress permalink structure.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo $environment['wp_permalink']; ?></td>
            </tr>
            <tr>
                <td data-export-label="WP Registered Post Status"><?php esc_html_e( 'Registered post status', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'WordPress registered post status types.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo $environment['wp_posts_status']; ?></td>
            </tr>
            <tr>
                <td data-export-label="External object cache"><?php esc_html_e( 'External object cache', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Displays whether or not WordPress is using an external object cache.', 'molongui-common-framework' ) ); ?></td>
                <td>
                    <?php if ( $environment['external_object_cache'] ) : ?>
                        <mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
                    <?php else : ?>
                        <mark class="no">&ndash;</mark>
                    <?php endif; ?>
                </td>
            </tr>
		</tbody>
	</table><!-- /#wp -->

	<!-- Database environment -->
	<table id="database" class="status-table widefat" cellspacing="0">
		<thead>
            <tr>
                <th colspan="3" data-export-label="Database"><h2><?php esc_html_e( 'Database', 'molongui-common-framework' ); ?></h2></th>
            </tr>
		</thead>
		<tbody>
		    <?php if ( $environment['mysql_version'] ) : ?>
            <tr>
                <td data-export-label="MySQL Version"><?php esc_html_e( 'MySQL version', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The version of MySQL installed on your hosting server.', 'molongui-common-framework' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
                <td>
					<?php
					if ( version_compare( $environment['mysql_version'], '5.6', '<' ) and ! strstr( $environment['mysql_version_string'], 'MariaDB' ) ) {
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend a minimum MySQL version of 5.6. See: %2$s', 'molongui-common-framework' ), esc_html( $environment['mysql_version_string'] ), '<a href="https://wordpress.org/about/requirements/" target="_blank">' . esc_html__( 'WordPress requirements', 'molongui-common-framework' ) . '</a>' ) . '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( $environment['mysql_version_string'] ) . '</mark>';
					}
					?>
                </td>
            </tr>
		    <?php endif; ?>
            <tr>
                <td data-export-label="WP Table Prefix"><?php esc_html_e( 'DB table prefix', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'WordPress database table prefix.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo esc_html( $environment['wp_database_prefix'] ); ?></td>
            </tr>
		</tbody>
	</table><!-- /#database -->

    <!-- Server Environment -->
    <table id="server" class="status-table widefat" cellspacing="0">
        <thead>
            <tr>
                <th colspan="3" data-export-label="Server environment"><h2><?php esc_html_e( 'Server environment', 'molongui-common-framework' ); ?></h2></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-export-label="Server Info"><?php esc_html_e( 'Server Info', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Information about the web server that is currently hosting your site.', 'molongui-common-framework' ) ); ?></td>
                <td><?php echo esc_html( $environment['server_info'] ); ?></td>
            </tr>
            <tr>
                <td data-export-label="PHP Version"><?php esc_html_e( 'PHP Version', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The version of PHP installed on your hosting server.', 'molongui-common-framework' ) ); ?></td>
                <td>
		            <?php
                        if ( version_compare( $environment['php_version'], '7.2', '>=' ) )
                        {
                            echo '<mark class="yes">' . esc_html( $environment['php_version'] ) . '</mark>';
                        }
                        else
                        {
                            $update_link = ' <a href="https://molongui.amitzy.com/docs/troubleshooting/how-to-update-my-php-version/" target="_blank">' . esc_html__( 'How to update your PHP version', 'molongui-common-framework' ) . '</a>';
                            $class       = 'error';

                            if ( version_compare( $environment['php_version'], '5.3', '<' ) ) {
                                $notice = '<span class="dashicons dashicons-warning"></span> ' . __( 'Molongui plugins will not run properly under this version of PHP. Support for this version has been dropped. We recommend using PHP version 7.2 or above for greater performance and security.', 'molongui-common-framework' ) . $update_link;
                            } elseif ( version_compare( $environment['php_version'], '5.6', '<' ) ) {
                                $notice = '<span class="dashicons dashicons-warning"></span> ' . __( 'Molongui plugins will run under this version of PHP, however, it has reached end of life. We recommend using PHP version 7.2 or above for greater performance and security.', 'molongui-common-framework' ) . $update_link;
                            } elseif ( version_compare( $environment['php_version'], '7.2', '<' ) ) {
                                $notice = __( 'We recommend using PHP version 7.2 or above for greater performance and security.', 'molongui-common-framework' ) . $update_link;
                                $class  = 'recommendation';
                            }

                            echo '<mark class="' . esc_attr( $class ) . '">' . esc_html( $environment['php_version'] ) . ' - ' . wp_kses_post( $notice ) . '</mark>';
                        }
		            ?>
                </td>
            </tr>
            <?php if ( function_exists( 'ini_get' ) ) : ?>
                <tr>
                    <td data-export-label="PHP Memory Limit"><?php esc_html_e( 'PHP memory limit', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'The maximum amount of memory (RAM) that PHP can use at one time.', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( $environment['wp_memory_limit'] ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Post Max Size"><?php esc_html_e( 'PHP post max size', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'The largest filesize that can be contained in one post.', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( size_format( $environment['php_post_max_size'] ) ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="Max Upload Size"><?php esc_html_e( 'PHP Max upload size', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'The largest filesize that can be uploaded to your WordPress installation.', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( size_format( $environment['max_upload_size'] ) ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Time Limit"><?php esc_html_e( 'PHP time limit', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( $environment['php_max_execution_time'] ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Max Input Vars"><?php esc_html_e( 'PHP max input vars', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( $environment['php_max_input_vars'] ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Arg Separator"><?php esc_html_e( 'PHP arg separator', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Character used as argument separator.', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( $environment['php_arg_separator'] ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Display Errors"><?php esc_html_e( 'PHP display errors', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Does your site prints errors to the screen as part of the output?', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo ( $environment['php_display_errors'] ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Allow URL File Open"><?php esc_html_e( 'PHP allow URL file open', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo ( $environment['php_allow_url_fopen'] ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Session"><?php esc_html_e( 'PHP session', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo ( $environment['php_session'] ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Session Name"><?php esc_html_e( 'PHP session name', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( $environment['php_session_name'] ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Cookie Path"><?php esc_html_e( 'PHP cookie path', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( $environment['php_cookie_path'] ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Save Path"><?php esc_html_e( 'PHP save path', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( $environment['php_save_path'] ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Use Cookies"><?php esc_html_e( 'PHP use cookies', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo ( $environment['php_use_cookies'] ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
                </tr>
                <tr>
                    <td data-export-label="PHP Use Only Cookies"><?php esc_html_e( 'PHP use only cookies', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Does your site enable accessing URL object like files?', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo ( $environment['php_only_cookies'] ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '<mark class="no">&ndash;</mark>' ); ?></td>
                </tr>

                <tr>
                    <td data-export-label="SUHOSIN Installed"><?php esc_html_e( 'SUHOSIN installed', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo $environment['suhosin_installed'] ? '<span class="dashicons dashicons-yes"></span>' : '&ndash;'; ?></td>
                </tr>
                <tr>
                    <td data-export-label="cURL Version"><?php esc_html_e( 'cURL version', 'molongui-common-framework' ); ?>:</td>
                    <td class="help"><?php echo molongui_help_tip( esc_html__( 'The version of cURL installed on your server.', 'molongui-common-framework' ) ); ?></td>
                    <td><?php echo esc_html( $environment['curl_version'] ); ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td data-export-label="fsockopen/cURL"><?php esc_html_e( 'fsockopen/cURL', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Some plugins can use cURL to communicate with remote servers.', 'molongui-common-framework' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
                <td>
		            <?php
		            if ( $environment['fsockopen_or_curl_enabled'] ) {
			            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
		            } else {
			            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'Your server does not have fsockopen or cURL enabled - Plugins which communicate with other servers will not work. Contact your hosting provider.', 'molongui-common-framework' ) . '</mark>';
		            }
		            ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="SoapClient"><?php esc_html_e( 'SoapClient', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Some webservices use SOAP to get information from remote servers.', 'molongui-common-framework' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
                <td>
		            <?php
		            if ( $environment['soapclient_enabled'] ) {
			            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
		            } else {
			            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not have the %s class enabled - some plugins which use SOAP may not work as expected.', 'molongui-common-framework' ), '<a href="https://php.net/manual/en/class.soapclient.php">SoapClient</a>' ) . '</mark>';
		            }
		            ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="DOMDocument"><?php esc_html_e( 'DOMDocument', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'HTML/Multipart emails use DOMDocument to generate inline CSS in templates.', 'molongui-common-framework' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
                <td>
		            <?php
		            if ( $environment['domdocument_enabled'] ) {
			            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
		            } else {
			            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not have the %s class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', 'molongui-common-framework' ), '<a href="https://php.net/manual/en/class.domdocument.php">DOMDocument</a>' ) . '</mark>';
		            }
		            ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="GZip"><?php esc_html_e( 'GZip', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'GZip (gzopen) is used to open the GEOIP database from MaxMind.', 'molongui-common-framework' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
                <td>
		            <?php
		            if ( $environment['gzip_enabled'] ) {
			            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
		            } else {
			            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not support the %s function - this is required to use the GeoIP database from MaxMind.', 'molongui-common-framework' ), '<a href="https://php.net/manual/en/zlib.installation.php">gzopen</a>' ) . '</mark>';
		            }
		            ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="Multibyte String"><?php esc_html_e( 'Multibyte string', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Multibyte String (mbstring) is used to convert character encoding, like for emails or converting characters to lowercase.', 'molongui-common-framework' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
                <td>
		            <?php
		            if ( $environment['mbstring_enabled'] ) {
			            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
		            } else {
			            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Your server does not support the %s functions - this is required for better character encoding. Some fallbacks will be used instead for it.', 'molongui-common-framework' ), '<a href="https://php.net/manual/en/mbstring.installation.php">mbstring</a>' ) . '</mark>';
		            }
		            ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="Remote Post"><?php esc_html_e( 'Remote post', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Some services may use this method of communicating when sending back information.', 'molongui-common-framework' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
                <td>
		            <?php
		            if ( $environment['remote_post_successful'] ) {
			            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
		            } else {
			            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%s failed. Contact your hosting provider.', 'molongui-common-framework' ), 'wp_remote_post()' ) . ' ' . esc_html( $environment['remote_post_response'] ) . '</mark>';
		            }
		            ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="Remote Get"><?php esc_html_e( 'Remote get', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'Molongui plugins may use this method of communication when checking for plugin updates.', 'molongui-common-framework' ) ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></td>
                <td>
		            <?php
		            if ( $environment['remote_get_successful'] ) {
			            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
		            } else {
			            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%s failed. Contact your hosting provider.', 'molongui-common-framework' ), 'wp_remote_get()' ) . ' ' . esc_html( $environment['remote_get_response'] ) . '</mark>';
		            }
		            ?>
                </td>
            </tr>
            <tr>
                <td data-export-label="Default Timezone is UTC"><?php esc_html_e( 'Default Timezone is UTC', 'molongui-common-framework' ); ?>:</td>
                <td class="help"><?php echo molongui_help_tip( esc_html__( 'The default timezone for your server.', 'molongui-common-framework' ) ); ?></td>
                <td>
                    <?php
                    if ( 'UTC' !== $environment['default_timezone'] )
                    {
                        echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Default timezone is %s - it should be UTC', 'molongui-common-framework' ), esc_html( $environment['default_timezone'] ) ) . '</mark>';
                    }
                    else
                    {
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
			<th colspan="3" data-export-label="Client Environment"><h2><?php esc_html_e( 'Client environment', 'molongui-common-framework' ); ?></h2></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td data-export-label="Platform"><?php esc_html_e( 'Platform', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( esc_html__( 'Information of the platform being used.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $client['platform'];?></td>
		</tr>
		<tr>
			<td data-export-label="Browser"><?php esc_html_e( 'Browser', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( esc_html__( 'Information of the browser being used.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $client['browser']; ?></td>
		</tr>
		<tr>
			<td data-export-label="User Agent"><?php esc_html_e( 'User Agent', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( esc_html__( 'Information of the user agent being used.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $client['user_agent']; ?></td>
		</tr>
		<tr>
			<td data-export-label="IP address"><?php esc_html_e( 'IP address', 'molongui-common-framework' ); ?>:</td>
			<td class="help"><?php echo molongui_help_tip( esc_html__( 'Your IP address.', 'molongui-common-framework' ) ); ?></td>
			<td><?php echo $client['ip']; ?></td>
		</tr>
		</tbody>
	</table><!-- /#client -->

</div><!-- /.molongui-support-wrap -->