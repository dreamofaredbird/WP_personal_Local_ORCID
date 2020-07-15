<?php
if ( !defined( 'ABSPATH' ) ) exit;

$current_tab = !empty( $_REQUEST['tab'] ) ? sanitize_title( $_REQUEST['tab'] ) : 'help'/*'docs'*/;
$tabs        = array
(
    'help'   => __( 'Get help', 'molongui-common-framework' ),
	'status' => __( 'System status', 'molongui-common-framework' ),
);

?>

<div class="wrap molongui">

    <!-- Page title -->
    <h2><?php _e( 'Molongui Support', 'molongui-common-framework' ); ?></h2>

    <!-- Nav tabs -->
    <nav class="nav-tab-wrapper">
		<?php
            foreach ( $tabs as $name => $label )
            {
                echo '<a href="' . admin_url( 'admin.php?page=molongui-support&tab=' . $name ) . '" class="nav-tab ';
                if ( $current_tab == $name ) echo 'nav-tab-active';
                echo '">' . $label . '</a>';
            }
		?>
    </nav>

    <h1 class="screen-reader-text"><?php echo esc_html( $tabs[ $current_tab ] ); ?></h1>

	<?php
        switch ( $current_tab )
        {
            case 'status':

	            if ( !isset( $this->classes['sysinfo'] ) )
	            {
		            if ( !class_exists( 'Molongui\Fw\Includes\Sysinfo' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'includes/fw-class-sysinfo.php' );
		            if ( !class_exists( 'Molongui\Fw\Includes\Browser' ) ) require_once( molongui_get_constant( $this->plugin->id, 'DIR', true ) . 'includes/vendor-class-browser.php' );
		            $this->classes['sysinfo'] = new Molongui\Fw\Includes\Sysinfo( $this->plugin );
	            }
	            echo $this->classes['sysinfo']->render_output();

            break;

            case 'help':

                require_once( 'html-admin-page-support-help.php' );

            break;

            default:

            break;
        }
	?>
</div>