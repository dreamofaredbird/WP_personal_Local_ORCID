<?php

namespace Molongui\Authorship\Includes;
if ( !defined( 'ABSPATH' ) ) exit;
class User
{
	public function __construct() {}
	public function manage_users_columns( $column_headers )
	{
		unset( $column_headers['posts'] );
		$column_headers['molongui_entries'] = __( 'Entries', MOLONGUI_AUTHORSHIP_TEXTDOMAIN );
		$column_headers['molongui_box'] = __( 'Author box', MOLONGUI_AUTHORSHIP_TEXTDOMAIN );
		$column_headers['user_id'] = __( 'ID' );

		return $column_headers;
	}
	public function fill_id_column( $value, $column, $ID )
	{
		if ( $column == 'user_id' ) return $ID;

		elseif ( $column == 'molongui_box' )
		{
			switch ( get_user_meta( $ID, 'molongui_author_box_display', true ) )
			{
				case 'show':
					return '<i data-tip="'.__( 'Show', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ).'" class="m-a-icon-show molongui-tip"></i>';
				break;

				case 'hide':
					return '<i data-tip="'.__( 'Hide', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ).'" class="m-a-icon-hide molongui-tip"></i>';
				break;

				case 'default':
				default:
				    $settings = get_option( MOLONGUI_AUTHORSHIP_BOX_SETTINGS );
					if ( $settings['display'] == 'hide' ) return '<i data-tip="'.__( 'Hide',MOLONGUI_AUTHORSHIP_TEXTDOMAIN ).'" class="m-a-icon-hide molongui-tip"></i>';
					else return '<i data-tip="'.__( 'Show', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ).'" class="m-a-icon-show molongui-tip"></i>';
				break;
			}
		}

		elseif ( $column == 'molongui_entries' )
        {
	        $html = '';
	        if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
	        $author = new Author();

	        foreach ( molongui_supported_post_types( MOLONGUI_AUTHORSHIP_ID, 'all', true ) as $post_type )
	        {
		        $html .= '<div>'.count( $author->get_posts( $ID, 'user', true, array(), array(), $post_type['id'] ) ).' '.$post_type['label'].'</div>';
	        }
	        return $html;
        }

		return $value;
	}
	public function add_authorship_fields( $user )
	{
		if ( is_object( $user ) )
        {
	        if ( !current_user_can( 'edit_user', $user->ID ) ) return false;
        }
        else
        {
            $user = new \stdClass();
	        $user->ID = 0;
        }

		?>

        <div id="molongui-author-box-container" class="molongui-flex-container molongui-settings-container">

            <div class="molongui-flex-row">
                <h2><?php _e( 'Molongui Authorship', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></h2>
            </div>

            <!-- Local avatar -->
            <div class="molongui-flex-column" id="molongui-authorship-local-avatar">
                <h3><?php _e( 'Local Avatar', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></h3>
                <p class="molongui-settings-description">
			        <?php _e( "Want to use a custom local avatar instead of Gravatar's? User's avatar is displayed in the author box, comments and other relevant sections. WordPress uses Gravatar service to display user's profile picture which is based on the email address. If you do not have a Gravatar account then your profile picture will be replaced with a default image placeholder which is called 'Mystery Man'. Molongui Authorship enables you to use any photo you upload here as your avatar. If none is uploaded, your Gravatar avatar or Default Avatar will be displayed.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                </p>
            </div>

            <div class="molongui-flex-row">
                <div class="molongui-flex-content">

                    <label for="molongui_author_image"><?php _e( 'Profile image', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>

                    <div class="molongui-flex-column">
                        <?php
                            $img_id       = get_the_author_meta( 'molongui_author_image_id',   $user->ID );
                            $img_url      = get_the_author_meta( 'molongui_author_image_url',  $user->ID );
                            $img_edit_url = get_the_author_meta( 'molongui_author_image_edit', $user->ID );

                            if ( current_user_can( 'upload_files' ) ) :

                                if ( !$img_id ) $btn_text = __( 'Upload New Image', MOLONGUI_AUTHORSHIP_TEXTDOMAIN );
                                else $btn_text = __( 'Change Current Image', MOLONGUI_AUTHORSHIP_TEXTDOMAIN );
                                wp_enqueue_media();
                                ?>

                                <!-- Outputs the image after save -->
                                <div id="current_img">
                                    <?php if ( $img_url ): ?>
                                        <img src="<?php echo esc_url( $img_url ); ?>" class="molongui_current_img">
                                        <div class="edit_options uploaded">
                                            <a class="remove_img"><span><?php _e( 'Remove', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span></a>
                                            <a href="<?php echo $img_edit_url; ?>" class="edit_img" target="_blank"><span><?php _e( 'Edit', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span></a>
                                        </div>
                                    <?php else : ?>
                                        <img src="<?php echo plugins_url( 'admin/img/placeholder.gif' ); ?>" class="molongui_current_img placeholder">
                                    <?php endif; ?>
                                </div>

                                <!-- Hold the value here of WPMU image -->
                                <div id="molongui_image_upload">
                                    <input type="hidden" name="molongui_placeholder_meta" id="molongui_placeholder_meta" value="<?php echo plugins_url( 'dmin/img/placeholder.gif' ); ?>" class="hidden" />
                                    <input type="hidden" name="molongui_author_image_id" id="molongui_author_image_id" value="<?php echo $img_id; ?>" class="hidden" />
                                    <input type="hidden" name="molongui_author_image_url" id="molongui_author_image_url" value="<?php echo esc_url_raw( $img_url ); ?>" class="hidden" />
                                    <input type="hidden" name="molongui_author_image_edit" id="molongui_author_image_edit" value="<?php echo $img_edit_url; ?>" class="hidden" />
                                    <input type='button' class="molongui_wpmu_button button-primary" value="<?php _e( $btn_text, MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>" id="uploadimage"/><br />
                                </div>

                            <?php else : ?>

                                <?php if ( $img_url ): ?>
                                    <img src="<?php echo esc_url( $img_url ); ?>" class="molongui_current_img">
                                <?php else : ?>
                                    <img src="<?php echo plugins_url( 'admin/img/placeholder.gif' ); ?>" class="molongui_current_img placeholder">
                                <?php endif; ?>
                                <div>
                                    <p class="description"><?php _e( 'You do not have permission to upload a profile picture. Please, contact the administrator of this site.', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></p>
                                </div>

                            <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Professional info -->
            <div class="molongui-flex-column" id="molongui-authorship-professional-info">
                <h3><?php _e( 'Professional Info', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></h3>
                <p class="molongui-settings-description">
		            <?php printf( __( "Information below will be displayed on the author box and other relevant sections (i.e. authors list) below the user's name. %sPhone number won't be displayed unless configured%s using the %sdisplay settings%s. Any blank field will not be displayed either.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>', '<a href="#molongui-authorship-author-box-settings">', '</a>' ); ?>
                </p>
            </div>

            <div class="molongui-flex-row">

                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_phone"><?php _e( 'Phone', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <input type="text" name="molongui_author_phone" id="molongui_author_phone" value="<?php echo esc_attr( get_the_author_meta( 'molongui_author_phone', $user->ID ) ); ?>" class="regular-text" />
                        </div>
                    </div>
                </div>

            </div>

            <div class="molongui-flex-row">

                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_job"><?php _e( 'Job title', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <input type="text" name="molongui_author_job" id="molongui_author_job" value="<?php echo esc_attr( get_the_author_meta( 'molongui_author_job', $user->ID ) ); ?>" class="regular-text" />
                        </div>
                    </div>
                </div>

            </div>

            <div class="molongui-flex-row">

                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_company"><?php _e( 'Company', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <input type="text" name="molongui_author_company" id="molongui_author_company" value="<?php echo esc_attr( get_the_author_meta( 'molongui_author_company', $user->ID ) ); ?>" class="regular-text" />
                        </div>
                    </div>
                </div>

            </div>

            <div class="molongui-flex-row">

                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_company_link"><?php _e( 'Company website', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <input type="text" name="molongui_author_company_link" id="molongui_author_company_link" value="<?php echo esc_attr( get_the_author_meta( 'molongui_author_company_link', $user->ID ) ); ?>" class="regular-text" placeholder="<?php _e( 'https://www.example.com/', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>" />
                        </div>
                    </div>
                </div>

            </div>

            <!-- Social Profiles -->
            <div class="molongui-flex-column" id="molongui-authorship-social-profiles">
                <h3><?php _e( 'Social Profiles', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></h3>
                <p class="molongui-settings-description">
	                <?php printf( __( "Social profiles will be displayed as icons on the author box and other relevant sections. Any blank profile will not be displayed. Molongui Authorship allows you to add %smore than 90 different social network profiles%s, so if you don't see here the ones you want to add, just go to the %splugin settings page%s and check those you need to edit.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<strong>', '</strong>', '<a href="'.get_admin_url().'admin.php?page=molongui-authorship" target="_blank">', '</a>' ); ?>
                </p>
            </div>

	        <?php
                $social_networks = include( MOLONGUI_AUTHORSHIP_DIR . 'config/social.php' );
                $settings = get_option( MOLONGUI_AUTHORSHIP_BOX_SETTINGS );

                foreach ( $social_networks as $id => $social_network )
                {
                    if ( isset( $settings['show_'.$id] ) and $settings['show_'.$id] == 1 )
                    {
                        echo '<div class="molongui-flex-row">';
                        echo '<div class="molongui-flex-column">';
                        echo '<div class="molongui-flex-content">';
                        echo '<div class="molongui-input-wrap">';
                        echo '<label for="molongui_author_'.$id.'">'.$social_networks[$id]['name'].'</label>';
                        if ( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) and $social_network['premium'] )
                        {
                            echo '<input disabled placeholder="'.__( 'Premium feature', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ).'" type="text" name="molongui_author_'.$id.'" id="molongui_author_'.$id.'" value="" class="regular-text" />';
                            echo '<span class="description"><span class="premium">'.__( 'Premium', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ).'</span>';
                            printf( __( "This option is available only in the %spremium version%s of the plugin.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<a href="' . MOLONGUI_AUTHORSHIP_WEB . '" target="_blank">', '</a>' );
                            echo '</span>';
                        }
                        else
                        {
                            echo '<input type="text" name="molongui_author_'.$id.'" id="molongui_author_'.$id.'" value="'.esc_attr( get_the_author_meta( 'molongui_author_'.$id, $user->ID ) ).'" class="regular-text" placeholder="'.$social_networks[$id]['url'].'" />';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
	        ?>

            <!-- Author Box Settings -->
            <div class="molongui-flex-column" id="molongui-authorship-author-box-settings">
                <h3><?php _e( 'Author Box Settings', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></h3>
                <p class="molongui-settings-description">
	                <?php printf( __( "On the %splugin settings page%s you can configure all the display settings that affects how the author box is displayed by default. Nonetheless, below you have some settings that override that global configuration for this user.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<a href="'.get_admin_url().'admin.php?page=molongui-authorship" target="_blank">', '</a>' ); ?>
                </p>
            </div>

            <div class="molongui-flex-row">

                <!-- Author box display -->
	            <?php $user_box_display = get_the_author_meta( 'molongui_author_box_display', $user->ID ); ?>
                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_box_display"><?php _e( 'Disable author box', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <select name="molongui_author_box_display" id="molongui_author_box_display">
                                <option value="default" <?php selected( $user_box_display, 'default' ); ?>><?php _e( 'Default', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></option>
                                <option value="show"    <?php selected( $user_box_display, 'show' ); disabled( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ), false ); ?>><?php _e( 'Show', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></option>
                                <option value="hide"    <?php selected( $user_box_display, 'hide' ); disabled( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ), false ); ?>><?php _e( 'Hide', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></option>
                            </select>
					        <?php if( !molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ) : ?>
                                <span class="description"><span class="premium"><?php _e( 'Premium', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></span>
	                                <?php printf( __( "Disabled options are available only in the %spremium version%s of the plugin.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<a href="' . MOLONGUI_AUTHORSHIP_WEB . '" target="_blank">', '</a>' ); ?>
                                </span>
					        <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="molongui-flex-row">

                <!-- Display email as author meta -->
                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_show_meta_mail"><?php _e( 'Display e-mail', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <input type="checkbox" name="molongui_author_show_meta_mail" id="molongui_author_show_meta_mail" value="1" <?php echo ( get_the_author_meta( 'molongui_author_show_meta_mail', $user->ID ) ? 'checked=checked' : '' );  echo ( $user_box_display == 'hide' ? 'disabled' : '' ); ?>>
                            <label for="molongui_author_show_meta_mail"><?php _e( "Check this box to display the user's e-mail publicly in the author meta line, which is displayed below the author name.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="molongui-flex-row">

                <!-- Display phone as author meta -->
                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_show_meta_phone"><?php _e( 'Display phone', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <input type="checkbox" name="molongui_author_show_meta_phone" id="molongui_author_show_meta_phone" value="1" <?php echo ( get_the_author_meta( 'molongui_author_show_meta_phone', $user->ID ) ? 'checked=checked' : '' );  echo ( $user_box_display == 'hide' ? 'disabled' : '' ); ?>>
                            <label for="molongui_author_show_meta_phone"><?php _e( "Check this box to display the user's phone publicly in the author meta line, which is displayed below the author name.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="molongui-flex-row">

                <!-- Display website as social icon -->
                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_show_icon_web"><?php _e( 'Show website icon', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <input type="checkbox" name="molongui_author_show_icon_web" id="molongui_author_show_icon_web" value="1" <?php echo ( get_the_author_meta( 'molongui_author_show_icon_web', $user->ID ) ? 'checked=checked' : '' );  echo ( $user_box_display == 'hide' ? 'disabled' : '' ); ?>>
                            <label for="molongui_author_show_icon_web"><?php _e( "Check this box to display a website icon with other social icons.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="molongui-flex-row">

                <!-- Display email as social icon -->
                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_show_icon_mail"><?php _e( 'Show e-mail icon', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <input type="checkbox" name="molongui_author_show_icon_mail" id="molongui_author_show_icon_mail" value="1" <?php echo ( get_the_author_meta( 'molongui_author_show_icon_mail', $user->ID ) ? 'checked=checked' : '' );  echo ( $user_box_display == 'hide' ? 'disabled' : '' ); ?>>
                            <label for="molongui_author_show_icon_mail"><?php _e( "Check this box to display an e-mail icon with other social icons.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="molongui-flex-row">

                <!-- Display phone as social icon -->
                <div class="molongui-flex-column">
                    <div class="molongui-flex-content">
                        <div class="molongui-input-wrap">
                            <label for="molongui_author_show_icon_phone"><?php _e( 'Show phone icon', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                            <input type="checkbox" name="molongui_author_show_icon_phone" id="molongui_author_show_icon_phone" value="1" <?php echo ( get_the_author_meta( 'molongui_author_show_icon_phone', $user->ID ) ? 'checked=checked' : '' );  echo ( $user_box_display == 'hide' ? 'disabled' : '' ); ?>>
                            <label for="molongui_author_show_icon_phone"><?php _e( "Check this box to display a phone icon with other social icons.", MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?></label>
                        </div>
                    </div>
                </div>

            </div>

            <script>
		        document.getElementById('molongui_author_box_display').onchange = function()
		        {
		        	var $disabled = false;
		        	if ( this.value === 'hide' ) $disabled = true;

			        document.getElementById('molongui_author_show_meta_phone').disabled = $disabled;
			        document.getElementById('molongui_author_show_meta_mail').disabled  = $disabled;
			        document.getElementById('molongui_author_show_icon_mail').disabled  = $disabled;
			        document.getElementById('molongui_author_show_icon_web').disabled   = $disabled;
			        document.getElementById('molongui_author_show_icon_phone').disabled = $disabled;
		        };
            </script>

        </div> <!-- #molongui-author-box-container -->

		<?php
	}
	public function filter_user_profile_picture_description( $description, $profileuser )
    {
        return $description . ' ' . sprintf( __( 'Or you can upload a custom local profile picture using %sMolongui Authorship field%s', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ), '<a href="#molongui-author-box-container">', '</a>' );
    }
	public function save_authorship_fields( $user_id )
	{
		if ( !current_user_can( 'edit_user', $user_id ) ) return false;
        $social_networks = include( MOLONGUI_AUTHORSHIP_DIR . '/config/social.php' );
		update_user_meta( $user_id, 'molongui_author_phone', $_POST['molongui_author_phone'] );
		update_user_meta( $user_id, 'molongui_author_job', $_POST['molongui_author_job'] );
		update_user_meta( $user_id, 'molongui_author_company', $_POST['molongui_author_company'] );
		update_user_meta( $user_id, 'molongui_author_company_link', $_POST['molongui_author_company_link'] );

		foreach ( $social_networks as $id => $social_network )
		{
			if ( isset( $_POST['molongui_author_'.$id] ) and !empty( $_POST['molongui_author_'.$id] ) ) update_user_meta( $user_id, 'molongui_author_'.$id, sanitize_text_field( $_POST['molongui_author_'.$id] ) );
			else delete_user_meta( $user_id, 'molongui_author_'.$id );
		}
		$checkboxes = array
		(
			'molongui_author_show_meta_mail',
			'molongui_author_show_meta_phone',
			'molongui_author_show_icon_mail',
			'molongui_author_show_icon_web',
			'molongui_author_show_icon_phone',
		);
		foreach ( $checkboxes as $checkbox )
		{
			if ( isset( $_POST[$checkbox] ) ) update_user_meta( $user_id, $checkbox, sanitize_text_field( $_POST[$checkbox] ) );
			else delete_user_meta( $user_id, $checkbox );
		}
		update_post_meta( $user_id, 'molongui_author_box_display', 'default' );
		if ( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) )
		{
			$selects = array
			(
				'molongui_author_box_display',
			);
			foreach ( $selects as $select )
			{
				if ( isset( $_POST[$select] ) and !empty( $_POST[$select] ) ) update_user_meta( $user_id, $select, sanitize_text_field( $_POST[$select] ) );
			}
		}

		if ( !current_user_can( 'upload_files', $user_id ) ) return false;
		update_user_meta( $user_id, 'molongui_author_image_id',   $_POST['molongui_author_image_id'] );
		update_user_meta( $user_id, 'molongui_author_image_url',  $_POST['molongui_author_image_url'] );
		update_user_meta( $user_id, 'molongui_author_image_edit', $_POST['molongui_author_image_edit'] );
	}

}