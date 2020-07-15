<?php
if ( !defined( 'ABSPATH' ) ) exit;

?>

<div class="molongui-page-centered-wrapper">

    <div class="molongui-page-centered-inner">

        <img class="molongui-page-header" src="<?php echo molongui_get_constant( $this->plugin->id, 'URL', true ) . 'admin/img/logo_molongui.png' ?>" alt="Molongui logo" />
        <h1><?php _e( 'Need help? Need more?', 'molongui-common-framework' ); ?></h1>
        <p>Get instant answers for the most common questions and learn how to use Molongui plugins like a pro. Upgrade to Premium and unleash powerful features.</p>

        <!-- Quick buttons -->
        <div class="molongui-blurb-holder">

            <!-- Website -->
            <a class="molongui-blurb" target="_blank" href="<?php echo molongui_get_constant( $this->plugin->id, 'MOLONGUI_WEB', true ); ?>">
                <div class="molongui-blurb-icon"><i class="molongui-icon-cloud turquoise"></i></div>
                <div class="molongui-blurb-title"><?php _e( 'Website', 'molongui-common-framework' ); ?></div>
                <div class="molongui-blurb-text"><?php _e( 'Learn the basics to help you make the most of Molongui plugins.', 'molongui-common-framework' ); ?></div>
            </a>

            <!-- Plugins -->
            <a class="molongui-blurb" target="_blank" href="<?php echo molongui_get_constant( $this->plugin->id, 'MOLONGUI_WEB', true ); ?>support/">
                <div class="molongui-blurb-icon"><i class="molongui-icon-tip-circled blue"></i></div>
                <div class="molongui-blurb-title"><?php _e( 'Plugins', 'molongui-common-framework' ); ?></div>
                <div class="molongui-blurb-text"><?php _e( 'Unable to find what you are looking for? Open a support ticket to get help.', 'molongui-common-framework' ); ?></div>
            </a>

            <!-- Contact -->
            <a class="molongui-blurb" target="_blank" href="<?php echo molongui_get_constant( $this->plugin->id, 'MOLONGUI_WEB', true ); ?>contact/">
                <div class="molongui-blurb-icon"><i class="molongui-icon-mail orange"></i></div>
                <div class="molongui-blurb-title"><?php _e( 'Contact', 'molongui-common-framework' ); ?></div>
                <div class="molongui-blurb-text"><?php _e( 'Say Hello. Let us know how can we help.', 'molongui-common-framework' ); ?></div>
            </a>

        </div>

    </div>

</div>