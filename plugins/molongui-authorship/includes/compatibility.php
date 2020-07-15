<?php
if ( !defined( 'ABSPATH' ) ) exit;
if ( false ) return;
add_filter( 'molongui_authorship_do_filter_link', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( ( is_author() or is_guest_author() ) and isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'get_author_feed_link' ) )
    {
        $args['link'] = $args['class']->filter_archive_link( $args['link'] );
        return true;
    }
    return false;
}, 10, 2 );
if ( is_plugin_active( 'schema/schema.php' ) or is_plugin_active( 'schema-premium/schema-premium.php' ) )
{
    add_filter( 'schema_wp_author', function( $author )
    {
        global $post;
        if ( !is_multiauthor_post( $post->ID ) ) return $author;

        if ( !class_exists('Molongui\Authorship\Includes\Author') ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
        $author_class = new \Molongui\Authorship\Includes\Author();

        $post_authors = $author_class->get_authors( $post->ID );
        $authors = array();
        foreach ( $post_authors as $post_author )
        {
            $url_enable = schema_wp_get_option( 'author_url_enable' );
            $url 		= ( $url_enable == true ) ? esc_url( $author_class->get_url( $post_author->id, $post_author->type, false, false ) ) : '';

            $author = array
            (
                '@type'	=> 'Person',
                'name'	=> $author_class->get_name( $post_author->id, $post_author->type, false, false ),
                'url'	=> $url
            );

            if ( $description = $author_class->get_bio( $post_author->id, $post_author->type, false, false ) )
            {
                $author['description'] = strip_tags( $description );
            }

            $gravatar_enable = schema_wp_get_option( 'gravatar_image_enable' );

            if ( $gravatar_enable == true )
            {
                $image_size	= apply_filters( 'schema_wp_get_author_array_img_size', 96 );
                $image_url	= $author_class->get_avatar( $post_author->id, $post_author->type, $image_size, 'url', 'gravatar', false, false );

                if ( $image_url )
                {
                    $author['image'] = array
                    (
                        '@type'		=> 'ImageObject',
                        'url' 		=> $image_url,
                        'height' 	=> $image_size,
                        'width' 	=> $image_size
                    );
                }
            }

            $website 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'web', false, false ) ) );
            $facebook 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'facebook', false, false ) ) );
            $twitter 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'twitter', false, false ) ) );
            $instagram 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'instagram', false, false ) ) );
            $youtube 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'youtube', false, false ) ) );
            $linkedin 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'linkedin', false, false ) ) );
            $myspace 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'myspace', false, false ) ) );
            $pinterest 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'pinterest', false, false ) ) );
            $soundcloud = esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'soundcloud', false, false ) ) );
            $tumblr 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'tumblr', false, false ) ) );
            $github 	= esc_attr( stripslashes( $author_class->get_meta( $post_author->id, $post_author->type, 'github', false, false ) ) );

            if ( isset( $twitter ) && $twitter != '' ) $twitter = 'https://twitter.com/' . $twitter;

            $sameAs_links = array( $website, $facebook, $twitter, $instagram, $youtube, $linkedin, $myspace, $pinterest, $soundcloud, $tumblr, $github );

            $social = array();

            foreach ( $sameAs_links as $sameAs_link )
            {
                if ( $sameAs_link != '' ) $social[] = $sameAs_link;
            }

            if ( !empty( $social ) )
            {
                $author["sameAs"] = $social;
            }

            $authors[] = $author;
        }
        return $authors;
    });
}
if ( is_plugin_active( 'td-cloud-library/td-cloud-library.php' ) )
{
    add_filter( 'molongui_authorship_filter_the_author_display_name_post_id', function( $post_id, $post, $display_name )
    {
        $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 8 );
        $i = 6;
        if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_the_author_meta' and isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_single' )
        {
            global $tdb_state_single;
            $tdcl_query = $tdb_state_single->get_wp_query();
            return $tdcl_query->queried_object_id;
        }
        elseif ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_the_author_meta' and isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_category' )
        {
        }
        return $post_id;
    }, 10, 3 );
    add_filter( 'molongui_authorship_dont_filter_the_author_display_name', function( $leave, $display_name, $user_id, $original_user_id, $post, $dbt )
    {
        if ( $leave ) return $leave;
        $i = 3;
        if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_the_author_meta' and isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_category' ) return true;
        return false;
    }, 10, 6 );
}
if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) or is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) )
{
	add_filter( 'wpseo_replacements',     'molongui_authorship_wpseo_replacements', 99, 2 );
	add_filter( 'wpseo_title',            'molongui_authorship_wpseo_title', 99, 1 );
	add_filter( 'wpseo_metadesc',         'molongui_authorship_wpseo_metadesc', 99, 1 );
	add_filter( 'wpseo_opengraph_url',    'molongui_authorship_wpseo_opengraph_url', 99, 1 );
    add_filter( 'wpseo_robots',           'molongui_authorship_wpseo_robots', 99, 1 );
	add_filter( 'wpseo_canonical',        'molongui_authorship_wpseo_canonical', 99, 1 );
	add_filter( 'wpseo_adjacent_rel_url', 'molongui_authorship_wpseo_adjacent_rel_url', 99, 2 );
    add_filter( 'molongui_authorship_do_filter_link', function( $leave, &$args )
    {
        if ( $leave ) return $leave;
        if ( ( is_author() or is_guest_author() ) and isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'generate_canonical' ) )
        {
            $args['link'] = $args['class']->filter_archive_link( $args['link'] );
            return true;
        }
        return false;
    }, 10, 2 );
	function molongui_authorship_wpseo_replacements( $replacements, $args )
	{
		if ( !is_author() and !is_guest_author() ) return $replacements;
		if ( is_guest_author() and !in_the_loop() and isset( $replacements['%%name%%'] ) )
		{
			if ( $author = get_query_var( 'ma-guest-author', 0 ) )
			{
				$my_query = new WP_Query
				(
					array
					(
						'name'      => $author,
						'post_type' => 'molongui_guestauthor',
					)
				);
				if ( $my_query->have_posts() ) $replacements['%%name%%'] = $my_query->posts[0]->post_title;
				wp_reset_postdata();
			}
		}
		else
		{
			if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
			$author = new Molongui\Authorship\Includes\Author();
			$replacements['%%name%%'] = $author->get_name( get_query_var( 'author', 0 ), 'user', false, false );
		}
		return $replacements;
	}
	function molongui_authorship_wpseo_title( $title )
	{
		if ( !is_author() and !is_guest_author() ) return $title;
		if ( is_guest_author() and !in_the_loop() and $title )
		{
			if ( $author = get_query_var( 'ma-guest-author', 0 ) )
			{
				$my_query = new WP_Query
				(
					array
					(
						'name'      => $author,
						'post_type' => 'molongui_guestauthor',
					)
				);
				if ( $my_query->have_posts() ) $title = $my_query->posts[0]->post_title;
				wp_reset_postdata();
			}
		}
		return $title;
	}
	function molongui_authorship_wpseo_metadesc( $metadesc )
	{
		if ( !is_author() and !is_guest_author() ) return $metadesc;
		if ( is_guest_author() and !in_the_loop() and $metadesc )
		{
			if ( $author = get_query_var( 'ma-guest-author', 0 ) )
			{
				$my_query = new WP_Query
				(
					array
					(
						'name'      => $author,
						'post_type' => 'molongui_guestauthor',
					)
				);
				if ( $my_query->have_posts() ) $metadesc = $my_query->posts[0]->post_content;
				wp_reset_postdata();
			}
		}
		return $metadesc;
	}
	function molongui_authorship_wpseo_opengraph_url( $url )
	{
		if ( !is_author() and !is_guest_author() ) return $url;
		$url = molongui_authorship_get_actual_author_data( 'url', $url );
		return $url;
	}
	function molongui_authorship_wpseo_opengraph_img( $url )
	{
		if ( !is_author() and !is_guest_author() ) return $url;
		$url = molongui_authorship_get_actual_author_data( 'img', $url );
		return $url;
	}
    function molongui_authorship_wpseo_robots( $robotsstr )
    {
        if ( is_guest_author() )
        {
            global $wp_query;
            $robots           = array();
            $robots['index']  = 'index';
            $robots['follow'] = 'follow';
            $robots['other']  = array();
            if ( WPSEO_Options::get( 'noindex-author-wpseo', false ) )
            {
                $robots['index'] = 'noindex';
            }
            if ( isset( $wp_query->guest_author_id ) )
            {
                global $wpdb;
                $guest_posts = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = '_molongui_author' AND meta_value = 'guest-{$wp_query->guest_author_id}'", ARRAY_A );
                if ( WPSEO_Options::get( 'noindex-author-noposts-wpseo', false ) and empty( $guest_posts ) )
                {
                    $robots['index'] = 'noindex';
                }
            }
            if ( '0' === (string) get_option( 'blog_public' ) || isset( $_GET['replytocom'] ) )
            {
                $robots['index'] = 'noindex';
            }
            $robotsstr = $robots['index'] . ',' . $robots['follow'];
            $robotsstr = preg_replace( '`^index,follow,?`', '', $robotsstr );
            $robotsstr = str_replace( array( 'noodp,', 'noodp' ), '', $robotsstr );
            if ( strpos( $robotsstr, 'noindex' ) === false && strpos( $robotsstr, 'nosnippet' ) === false )
            {
                if ( $robotsstr !== '' )
                {
                    $robotsstr .= ', ';
                }
                $robotsstr .= 'max-snippet:-1, max-image-preview:large, max-video-preview:-1';
            }
        }
        return $robotsstr;
    }
	function molongui_authorship_wpseo_canonical( $canonical )
	{
		if ( !is_author() and !is_guest_author() ) return $canonical;
		$canonical = molongui_authorship_get_actual_author_data( 'url', $canonical );
		return $canonical;
	}
	function molongui_authorship_wpseo_adjacent_rel_url( $url, $rel )
	{
		if ( !is_author() and !is_guest_author() ) return $url;
		if ( !molongui_is_multiauthor_link( $url ) ) return $url;
		if ( substr( $url, -1 ) == '/' )
		{
			$parts = explode( "/", substr( $url, 0, -1 ) );
			$trailing = '/';
		}
		else
		{
			$parts = explode( "/", $url );
			$trailing = '';
		}
		$page = array_pop( $parts );
		$query_arg = array_pop( $parts );
		$url = molongui_authorship_get_actual_author_data( 'url', $url );
		$url = $url.( substr( $url, -1 ) == '/' ? '' : '/' ).$query_arg.'/'.$page.$trailing;
		return $url;
	}
	function molongui_authorship_get_actual_author_data( $key, $default )
	{
		if ( is_guest_author() )
		{
			if ( $author = get_query_var( 'ma-guest-author', 0 ) )
			{
				$my_query = new WP_Query
				(
					array
					(
						'name'      => $author,
						'post_type' => 'molongui_guestauthor',
					)
				);
				if ( $my_query->have_posts() )
				{
					if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
					$author = new Molongui\Authorship\Includes\Author();

					switch ( $key )
					{
						case 'url':
							$url = $author->get_url( $my_query->posts[0]->ID, 'guest', false, false );
							wp_reset_postdata();
							return $url;

						break;

						case 'img':
							$img = $author->get_avatar( $my_query->posts[0]->ID, 'guest', false, false );
							wp_reset_postdata();
							return $img;

						break;
					}
				}
			}
		}
		elseif ( $key == 'url' )
		{
			if ( molongui_is_multiauthor_link( ( $default ) ) )
			{
				if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
				$author = new Molongui\Authorship\Includes\Author();
				return $author->get_url( get_query_var( 'author', 0 ), 'user', false, false );
			}
		}
		return $default;
	}
}
if ( is_plugin_active( 'js_composer/js_composer.php' ) )
{

	add_action( 'init', function()
	{
		remove_filter('vc_gitem_template_attribute_post_author', 'vc_gitem_template_attribute_post_author', 10);
		remove_filter('vc_gitem_template_attribute_post_author_href', 'vc_gitem_template_attribute_post_author_href', 10);
	}, 999 );
	add_filter( 'vc_gitem_template_attribute_post_author', function( $value, $data )
	{
		extract( array_merge( array
		(
			'post' => null,
			'data' => '',
		), $data ) );

		if ( isset( $post->ID ) and $post->ID )
		{
			if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
			$author = new Molongui\Authorship\Includes\Author();
			return $author->get_byline( $post->ID, '', '', false );
		}
		return $value;

	}, 999, 2 );
	add_filter( 'vc_gitem_template_attribute_post_author_href', function( $value, $data )
	{
		extract( array_merge( array
		(
			'post' => null,
			'data' => '',
		), $data ) );

		if ( isset( $post->ID ) and $post->ID )
		{
			if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
			$author = new Molongui\Authorship\Includes\Author();
			$main = $author->get_main_author( $post->ID );
			return $author->get_url( $main->id, $main->type, false, false );
		}
		return $value;

	}, 999, 2 );
}
if ( is_plugin_active( 'jetpack/jetpack.php' ) )
{
		add_action( 'init', function()
		{
			remove_filter( 'get_post_metadata', 'jetpack_featured_images_remove_post_thumbnail', true );
		}, 999 );
}
if ( class_exists( 'BuddyPress' ) )
{
	add_filter( 'molongui_authorship_dont_override_get_user_by', function( $leave, $user, $dbt )
	{
		if ( $leave ) return $leave;
		if ( isset( $dbt[5]['function'] ) and $dbt[5]['function'] == 'xprofile_filter_comments' and isset( $dbt[4]['function'] ) and $dbt[4]['function'] == 'bp_core_get_user_displaynames' ) return true;
		return false;
	}, 10, 3 );
}
if ( is_plugin_active( 'wpdiscuz/class.WpdiscuzCore.php' ) )
{
	add_filter( 'molongui_authorship_dont_filter_avatar', function( $leave, $avatar, $dbt )
	{
		if ( $leave ) return $leave;
		if ( !is_admin() and isset( $dbt[4]['function'] ) and $dbt[4]['function'] == 'renderFrontForm' and isset( $dbt[4]['class'] ) and $dbt[4]['class'] == 'wpdFormAttr\Form' ) return true;
		return false;
	}, 10, 3 );
    add_filter( 'wpdiscuz_comment_author', function( $authorName, $comment )
    {
        return ( $comment->comment_author ? $comment->comment_author : __( 'Anonymous', 'wpdiscuz' ) );
    }, 99, 2 );
    add_filter( 'get_comment_author_url', function( $commentAuthorUrl, $comment_id, $comment )
    {
        $email = $comment->comment_author_email;
        if ( !$email ) return $commentAuthorUrl;
        if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
        $author = new Molongui\Authorship\Includes\Author();
        if ( $user = $author->get_by( 'user_email', $email, 'user' ) )
        {
        }
        elseif ( $guest = $author->get_by( '_molongui_guest_author_mail', $email, 'guest' ) )
        {
            $settings = get_option( MOLONGUI_AUTHORSHIP_ARCHIVES_SETTINGS );

            if ( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) and $settings['guest_archive_enabled'] )
            {
                $permalink = ( ( isset( $settings['guest_archive_permalink'] ) and !empty( $settings['guest_archive_permalink'] ) ) ? $settings['guest_archive_permalink'] : '' );
                $slug      = ( ( isset( $settings['guest_archive_base'] ) and !empty( $settings['guest_archive_base'] ) ) ? $settings['guest_archive_base'] : 'author' );
                $commentAuthorUrl = home_url( ( !empty( $permalink ) ? $permalink.'/' : '' ) . $slug . '/' . $guest->post_name );
            }
            else
            {
                $commentAuthorUrl = '#molongui-disabled-link';
            }
        }
        return $commentAuthorUrl;

    }, 10, 3 );
    add_filter( 'wpdiscuz_profile_url', function( $profileUrl, $user )
    {
        return '';
    }, 10, 2 );
    add_filter( 'wpdiscuz_author_avatar_field', function( $authorAvatarField, $comment, $user, $profileUrl )
    {
        return $comment->comment_author_email;
    }, 10, 4 );
	add_filter( 'molongui_authorship_dont_override_get_user_by', function( $leave, $user, $dbt )
	{
		if ( $leave ) return $leave;
		if ( ( isset( $dbt[1]['function'] ) and $dbt[1]['function'] == "start_el" and isset( $dbt[1]['class'] ) and $dbt[1]['class'] == 'WpdiscuzWalker' ) ) return true;
		return false;
	}, 10, 3 );
}
if ( is_plugin_active( 'memberpress/memberpress.php' ) )
{
	add_filter( 'molongui_authorship_dont_override_get_user_by', function( $leave, $user, $dbt )
	{
		if ( $leave ) return $leave;
		if ( ( isset( $dbt[1]['function'] ) and $dbt[1]['function'] == 'get_user_by' and isset( $dbt[1]['class'] ) and $dbt[1]['class'] == 'MeprUtils' ) ) return true;
		return false;
	}, 10, 3 );
}
if ( is_plugin_active( 'memberpress-corporate/main.php' ) )
{
	add_filter( 'molongui_authorship_dont_override_get_user_by', function( $leave, $user, $dbt )
	{
		if ( $leave ) return $leave;
		if ( ( isset( $dbt[5]['function'] ) and $dbt[5]['function'] == "current_user_has_access" and isset( $dbt[5]['class'] ) and $dbt[5]['class'] == 'MPCA_Corporate_Account' ) ) return true;
		return false;
	}, 10, 3 );
}
if ( is_plugin_active( 'shortcodes-indep/init.php' ) )
{
	add_filter( 'molongui_authorship_dont_render_author_box', function( $leave )
	{
		if ( $leave ) return $leave;
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
		if ( in_the_loop() and isset( $dbt[6]['function'] ) and $dbt[6]['function'] == "shortcode_tab" ) return true;
		return false;
	});
}
if ( is_plugin_active( 'google-sitemap-generator/sitemap.php' ) )
{
	add_filter( 'molongui_authorship_dont_filter_link', function( $leave, $link, $dbt )
	{
		if ( $leave ) return $leave;
		if ( isset( $dbt[4]['function'] ) and $dbt[4]['function'] == 'BuildAuthors' and isset( $dbt[4]['class'] ) and $dbt[4]['class'] == 'GoogleSitemapGeneratorStandardBuilder' ) return $link;
		return false;
	}, 10, 3 );
}
if ( is_plugin_active( 'userswp/userswp.php' ) )
{
	add_filter( 'uwp_check_redirect_author_page', function()
	{
		if ( is_guest_author() ) return false;
		return true;
	});
}
if ( is_plugin_active( 'buddyboss-platform/bp-loader.php' ) )
{
    add_filter( 'molongui_filter_avatar_author_type', function( $author_type, $id_or_email, $dbt )
    {
        if ( isset( $dbt[4]['function'] ) and $dbt[4]['function'] == 'bp_wp_admin_bar_my_account_menu' ) return 'user';
        else return $author_type;
    }, 10, 3);
}

$theme = wp_get_theme();
if ( 'Astra' == $theme->name or 'Astra' == $theme->parent_theme )
{
	add_filter( 'astra_get_content_layout', function( $content_layout )
	{
		if ( is_author() or is_guest_author() ) return astra_get_option( 'archive-' . 'post' . '-content-layout' );
		else return $content_layout;
	});
    add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
    {
        // Leave if another hooked function has set value to 'true'.
        if ( $leave ) return $leave;

        // If the 'get_the_author()' WP function is called from the archive template to display the page title.
        if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' ) and isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'astra_archive_page_info' ) )
        {
            // Filter name.
            $args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );

            // Return true to force escaping the calling function.
            return true;
        }

        // Return false otherwise.
        return false;
    }, 10, 2 );

    add_filter( 'get_the_author_description', function( $value, $user_id = null, $original_user_id = null )
    {
        $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 5 );
        $i = 3;
        if ( isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == 'get_the_author_meta' ) and isset( $dbt[$i+1]['function'] ) and ( $dbt[$i+1]['function'] == 'astra_archive_page_info' ) )
        {
            global $wp_query;
            $author_id = ( is_guest_author() and isset( $wp_query->guest_author_id ) ) ? $wp_query->guest_author_id : $wp_query->query_vars['author'];
            if ( !class_exists('Molongui\Authorship\Includes\Author') ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
            $author_class = new Molongui\Authorship\Includes\Author();
            return $author_class->get_bio( $author_id, ( isset( $wp_query->is_guest_author ) and $wp_query->is_guest_author ) ? 'guest' : 'user', false, false );
        }
        return $value;
    }, 10, 3 );

    add_filter( 'get_the_author_user_email', function( $value, $user_id = null, $original_user_id = null )
    {
        $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 5 );
        $i = 3;
        if ( isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == 'get_the_author_meta' ) and isset( $dbt[$i+1]['function'] ) and ( $dbt[$i+1]['function'] == 'astra_archive_page_info' ) )
        {
            global $wp_query;
            $author_id = ( is_guest_author() and isset( $wp_query->guest_author_id ) ) ? $wp_query->guest_author_id : $wp_query->query_vars['author'];
            if ( !class_exists('Molongui\Authorship\Includes\Author') ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
            $author_class = new Molongui\Authorship\Includes\Author();
            return $author_class->get_mail($author_id, ( isset( $wp_query->is_guest_author ) and $wp_query->is_guest_author ) ? 'guest' : 'user', false, false);
        }
        return $value;
    }, 10, 3 );
}
if ( 'GeneratePress' == $theme->name or 'GeneratePress' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'generate_filter_the_archive_title' ) )
		{
			$args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );
			return true;
		}
		return false;
	}, 10, 2 );
}
elseif ( 'The7' == $theme->name or 'The7' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'presscore_get_page_title' ) )
		{
			$args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );
			return true;
		}
		return false;
	}, 10, 2 );
	add_filter( 'molongui_authorship_do_filter_link', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'presscore_get_page_title' ) )
		{
			$args['link'] = $args['class']->filter_archive_link( $args['link'] );
			return true;
		}
		return false;
	}, 10, 2 );
}
elseif ( 'soledad' == $theme->name or 'soledad' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_do_filter_link', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][5]['function'] ) and ( $args['dbt'][5]['function'] == 'the_author_posts_link' )
			 and
			 isset( $args['dbt'][5]['file'] ) and substr_compare( $args['dbt'][5]['file'], '/themes/soledad/inc/templates/about_author.php', strlen( $args['dbt'][5]['file'] )-strlen( '/themes/soledad/inc/templates/about_author.php' ), strlen( '/themes/soledad/inc/templates/about_author.php' ) ) === 0
		)
		{
			$args['link'] = $args['class']->filter_archive_link( $args['link'] );
			return true;
		}
		return false;
	}, 10, 2 );
}
elseif ( 'Newspaper' == $theme->name or 'Newspaper' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_override_get_user_by_post_id', function( $post_id, $post, $user )
	{
		$dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 7 );
		$i = 6;
		if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_author' and isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == 'td_module' and isset( $dbt[$i]['object'] ) and isset( $dbt[$i]['object']->post ) and isset( $dbt[$i]['object']->post->ID ) ) return $dbt[$i]['object']->post->ID;
		return $post_id;
	}, 10, 3 );
	add_filter( 'molongui_authorship_filter_the_author_display_name_post_id', function( $post_id, $post, $display_name )
	{
		$dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 8 );
		$i = 7;
		if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_author' and isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == 'td_module' and isset( $dbt[$i]['object'] ) and isset( $dbt[$i]['object']->post ) and isset( $dbt[$i]['object']->post->ID ) ) return $dbt[$i]['object']->post->ID;
		return $post_id;
	}, 10, 3 );
	add_filter( 'molongui_authorship_bypass_original_user_id_if', function( $false )
	{
		return true;
	}, 10, 1 );
	add_filter( 'molongui_authorship_filter_link_post_id', function( $post_id, $post, $link )
	{
		$dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 9 );
		$i = 8;
		if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_author' and isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == 'td_module' and isset( $dbt[$i]['object'] ) and isset( $dbt[$i]['object']->post ) and isset( $dbt[$i]['object']->post->ID ) ) return $dbt[$i]['object']->post->ID;
		return $post_id;
	}, 10, 3 );
	add_filter( 'molongui_authorship_dont_render_author_box', function( $leave )
	{
		if ( $leave ) return $leave;
		if ( doing_action( 'tdc_footer' ) ) return true;
		return false;
	});
}
elseif ( 'Thrive Themes' == $theme->get( 'Author' ) or ( $theme->parent() and 'Thrive Themes' == $theme->parent()->get( 'Author' ) ) )
{
	add_filter( 'molongui_authorship_dont_override_get_user_by', function( $leave, $user, $dbt )
	{
		if ( $leave ) return $leave;
		if ( isset( $dbt[3]['function'] ) and $dbt[3]['function'] == 'thrive_comments' ) return true;
		return false;
	}, 10, 3 );
	add_filter( 'molongui_authorship_dont_filter_the_author_display_name', function( $leave, $display_name, $user_id, $original_user_id, $post, $dbt )
	{
		if ( $leave ) return $leave;
		if ( isset( $dbt[5]['function'] ) and $dbt[5]['function'] == 'thrive_comments' ) return true;
		return false;
	}, 10, 4 );
}
elseif ( 'Flatsome' == $theme->name or 'Flatsome' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
			and
			isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], '/themes/flatsome/template-parts/posts/partials/archive-title.php', strlen( $args['dbt'][3]['file'] )-strlen( '/themes/flatsome/template-parts/posts/partials/archive-title.php' ), strlen( '/themes/flatsome/template-parts/posts/partials/archive-title.php' ) ) === 0
		)
		{
			$args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );
			return true;
		}
		return false;
	}, 10, 2 );
}
elseif ( 'ColorMag' == $theme->name or 'ColorMag' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
			and
			isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], '/themes/colormag/archive.php', strlen( $args['dbt'][3]['file'] )-strlen( '/themes/colormag/archive.php' ), strlen( '/themes/colormag/archive.php' ) ) === 0
		)
		{
			$args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );
			return true;
		}
		return false;
	}, 10, 2 );
}
elseif ( 'Alea' == $theme->name or 'Alea' == $theme->parent_theme )
{
	global $wp_query;
	add_filter( 'get_the_author_nickname', array( $this->classes['author'], 'filter_name' ) );
}
elseif ( 'JNews' == $theme->name or 'JNews' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_dont_render_author_box', function( $leave )
	{
		if ( $leave ) return $leave;
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
		if ( in_the_loop() and isset( $dbt[7]['function'] ) and $dbt[7]['function'] == "render_footer" and isset( $dbt[7]['class'] ) and $dbt[7]['class'] == "JNews\Footer\FooterBuilder" ) return true;
		return false;
	});
	add_filter( 'jnews_default_query_args', function( $args )
	{
		global $wp_query;
		if ( is_admin() or !$wp_query->is_main_query() ) return $args;
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 15 );
		if ( ( $wp_query->is_author() or array_key_exists( 'ma-guest-author', $wp_query->query_vars ) )
			and
			isset( $dbt[9]['function'] ) and $dbt[9]['function'] == "render_content" and isset( $dbt[9]['class'] ) and $dbt[9]['class'] == "JNews\Archive\AuthorArchive"
		)
		{
			$args['meta_query'] = $wp_query->get( 'meta_query' );
		}
		return $args;
	}, 99, 1 );
}
elseif ( 'Agama' == $theme->name or 'Agama' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
			 and
			 isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], '/themes/agama/author.php', strlen( $args['dbt'][3]['file'] )-strlen( '/themes/agama/author.php' ), strlen( '/themes/agama/author.php' ) ) === 0
		)
		{
			$args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );
			return true;
		}
		return false;
	}, 10, 2 );
	add_filter( 'molongui_authorship_do_filter_link', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_author_posts_url' )
			 and
			 isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], '/themes/agama/author.php', strlen( $args['dbt'][3]['file'] )-strlen( '/themes/agama/author.php' ), strlen( '/themes/agama/author' ) ) === 0
		)
		{
			$args['link'] = $args['class']->filter_archive_link( $args['link'] );
			return true;
		}
		return false;
	}, 10, 2 );
	add_filter( 'get_the_author_user_url', function( $value )
	{
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 6 );
		if ( is_author() and in_the_loop() and isset( $dbt[5]['function'] ) and $dbt[5]['function'] == "agama_render_blog_post_meta" ) return '#molongui-disabled-link';
		return $value;
	}, 10, 1 );
}
elseif ( 'fruitful' == $theme->name or 'fruitful' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'get_content_part' ) )
		{
			$args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );
			return true;
		}
		return false;
	}, 10, 2 );
	add_filter( 'molongui_authorship_do_filter_link', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'get_content_part' ) )
		{
			$args['link'] = $args['class']->filter_archive_link( $args['link'] );
			return true;
		}
		return false;
	}, 10, 2 );
}
elseif ( 'Jupiter' == $theme->name or 'Jupiter' == $theme->parent_theme )
{
    add_filter( 'molongui_edit_main_query_only', function( $default, &$query )
    {
        global $wp_query;
        $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 20 );
        if ( empty( $dbt ) ) return $default;
        if ( ( $query->is_home() or $query->is_author() )
            and ( $query->query_vars['post_type'] == 'post' or $query->query_vars['post_type'] == 'any' )
            and ( ( isset( $dbt[9]['function'] ) and $dbt[9]['function'] == 'mk_wp_query' ) or ( isset( $dbt[10]['function'] ) and $dbt[10]['function'] == 'mk_wp_query' ) or ( isset( $dbt[13]['function'] ) and $dbt[13]['function'] == 'mk_wp_query' ) )
        )
        {
            $query->set( 'author', $wp_query->get( 'author' ) );             // Set author ID.
            $query->set( 'author_name', $wp_query->get( 'author_name' ) );   // Re-set 'author_name' query_var.
            $query->query['author_name'] = $wp_query->get( 'author_name' );  // Re-set 'author_name' query string.
            //$query->is_author = true;
            return false;
        }
        if ( isset( $wp_query->is_guest_author )
            and $query->is_home()
            and $query->query_vars['post_type'] == 'any'
        )
        {
            $query->set( 'ma-guest-author', $wp_query->get( 'ma-guest-author' ) );   // Set 'ma-guest-author' query string.
            $query->query['ma-guest-author'] = $wp_query->get( 'ma-guest-author' );  // Set 'ma-guest-author' query_var.
            $query->set( 'post_type', 'post' );
            $query->query['post_type'] = 'post';
            $query->set( 'ignore_sticky_posts', true );
            return false;
        }
        return $default;
    }, 10, 2 );
    add_filter( 'mk_theme_page_header_title', function( $title )
    {
        if ( is_author() )
        {
            if ( get_query_var( 'author_name' ) )
            {
                $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
                $title  = $author->display_name;
            }
            else
            {
                $author = get_userdata( get_query_var( 'author' ) );
                $title  = $author->display_name;
            }
        }

        return $title;
    });
    add_filter( 'mk_theme_page_header_subtitle', function( $subtitle )
    {
        if ( is_author() )
        {
            if ( get_query_var( 'author_name' ) )
            {
                $author   = get_user_by( 'slug', get_query_var( 'author_name' ) );
                $subtitle = sprintf( esc_html__( 'Author Archive for: "%s"', 'mk_framework' ), $author->display_name );
            }
            else
            {
                $author   = get_userdata( get_query_var( 'author' ) );
                $subtitle = sprintf( esc_html__( 'Author Archive for: "%s"', 'mk_framework' ), $author->display_name );
            }
        }

        return $subtitle;
    });
}
elseif ( 'university' == $theme->name or 'university' == $theme->parent_theme )
{
	add_filter( 'get_the_author_user_url', function( $value )
	{
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
		if ( is_author() and in_the_loop() and isset( $dbt[5]['function'] ) and $dbt[5]['function'] == "the_author_link" ) return '#molongui-disabled-link';
		return $value;
	}, 10, 1 );
}
elseif ( 'Vellum' == $theme->name or 'Vellum' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
			 and
			 isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], '/themes/parallelus-vellum/author.php', strlen( $args['dbt'][3]['file'] )-strlen( '/themes/parallelus-vellum/author.php' ), strlen( '/themes/parallelus-vellum/author.php' ) ) === 0
		)
		{
			$args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );
			return true;
		}
		return false;
	}, 10, 2 );
	add_filter( 'molongui_edit_main_query_only', function( $default, &$query )
	{
		return false;
	}, 10, 2 );
}
elseif ( 'Creativo Theme' == $theme->name or 'Creativo Theme' == $theme->parent_theme )
{
    add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
    {
        if ( $leave ) return $leave;
        if ( ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
                and
                isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'cr_page_title' ) )
            or
            ( isset( $args['dbt'][5]['function'] ) and ( $args['dbt'][5]['function'] == 'the_author_posts_link' )
                and
                isset( $args['dbt'][5]['file'] ) and substr_compare( $args['dbt'][5]['file'], '/themes/creativo/archive.php', strlen( $args['dbt'][5]['file'] )-strlen( '/themes/creativo/archive.php' ), strlen( '/themes/creativo/archive.php' ) ) === 0 )
            or
            ( isset( $args['dbt'][6]['function'] ) and ( $args['dbt'][6]['function'] == 'the_author_posts_link' )
                and
                isset( $args['dbt'][6]['file'] ) and substr_compare( $args['dbt'][6]['file'], '/themes/creativo/archive.php', strlen( $args['dbt'][6]['file'] )-strlen( '/themes/creativo/archive.php' ), strlen( '/themes/creativo/archive.php' ) ) === 0 )
        )
        {
            $args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );
            return true;
        }
        return false;
    }, 10, 2 );
    add_filter( 'molongui_authorship_do_filter_link', function( $leave, &$args )
    {
        if ( $leave ) return $leave;
        if ( isset( $args['dbt'][5]['function'] ) and ( $args['dbt'][5]['function'] == 'the_author_posts_link' )
            and
            isset( $args['dbt'][5]['file'] ) and substr_compare( $args['dbt'][5]['file'], '/themes/creativo/archive.php', strlen( $args['dbt'][5]['file'] )-strlen( '/themes/creativo/archive.php' ), strlen( '/themes/creativo/archive.php' ) ) === 0
        )
        {
            $args['link'] = $args['class']->filter_archive_link( $args['link'] );
            return true;
        }
        return false;
    }, 10, 2 );
}
elseif ( 'OneSocial' == $theme->name or 'OneSocial' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_dont_filter_avatar', function( $leave, $avatar, $dbt )
	{
		if ( $leave ) return $leave;
		if ( !is_admin() and isset( $dbt[3]['function'] ) and ( $dbt[3]['function'] == "get_avatar" ) and isset( $dbt[3]['file'] ) and substr_compare( $dbt[3]['file'], '/template-parts/header-user-links.php', strlen( $dbt[3]['file'] )-strlen( '/template-parts/header-user-links.php' ), strlen( '/template-parts/header-user-links.php' ) ) === 0 ) return true;
		return false;
	}, 10, 3 );
}
elseif ( 'BuddyBoss Theme' == $theme->name or 'BuddyBoss Theme' == $theme->parent_theme )
{
    add_filter( 'molongui_authorship_dont_filter_avatar', function( $leave, $avatar, $dbt )
    {
        if ( $leave ) return $leave;
        $file = '/template-parts/header-aside.php';
        $i = 3;
        if ( !is_admin() and
            isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == 'get_avatar' ) and
            isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0
        ) return true;
        return false;
    }, 10, 3 );
    add_filter( 'molongui_filter_avatar_author', function( $author, $id_or_email, $dbt )
    {
        $file = '/template-parts/entry-meta.php';
        $i = 3;
        if ( !is_admin() and
            isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == 'get_avatar' ) and
            isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0
        )
        {
            if ( !class_exists('Molongui\Authorship\Includes\Author') ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
            $author_class = new \Molongui\Authorship\Includes\Author();
            global $post;

            if ( $author_class->is_guest_post( $post->ID ) )
            {
                $guest         = $author_class->get_main_author( $post->ID );
                $guest_id      = $guest->id;
                $author->type  = 'guest';
                $author->guest = $author_class->get_author( $guest_id , 'guest');
                return $author;
            }
        }
        return $author;
    }, 10, 3 );
    add_filter( 'molongui_filter_avatar_author', function( $author, $id_or_email, $dbt )
    {
        $file = '/themes/buddyboss-theme/comments.php';
        $i = 3;
        if ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 ) $author->type = 'user';
        return $author;
    }, 10, 3);
}
elseif ( 'Bitz' == $theme->name or 'Bitz' == $theme->parent_theme )
{
	add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
	{
		if ( $leave ) return $leave;
		$file = '/themes/bitz/title.php';
		if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
			 and isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], $file, strlen( $args['dbt'][3]['file'] )-strlen( $file ), strlen( $file ) ) === 0
		)
		{
			$args['display_name'] = $args['class']->filter_archive_title( $args['display_name'] );
			return true;
		}
		return false;
	}, 10, 2 );
	add_filter( 'get_the_author_ID', function( $value, $user_id = null, $original_user_id = null )
	{
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
		$file = '/themes/bitz/title.php';
		$i = 3;
		if ( !in_the_loop()
			 and ( !isset( $original_user_id ) or empty( $original_user_id ) )
			 and ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 )
			 and ( isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == 'get_the_author_meta' ) )
		){
			global $wp_query;
			if ( is_guest_author() and isset( $wp_query->guest_author_id ) ) return $wp_query->guest_author_id;
			else return $wp_query->query_vars['author'];
		}
		return $value;
	}, 10, 3 );
	add_filter( 'get_the_author_description', function( $value, $user_id = null, $original_user_id = null )
	{
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
		$file = '/themes/bitz/title.php';
		$i = 4;
		if ( !in_the_loop()
			 and ( !isset( $original_user_id ) or empty( $original_user_id ) )
			 and ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 )
			 and ( isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == 'the_author_meta' ) )
		){
			global $wp_query;
			$author_id = ( is_guest_author() and isset( $wp_query->guest_author_id ) ) ? $wp_query->guest_author_id : $wp_query->query_vars['author'];
			if ( !class_exists('Molongui\Authorship\Includes\Author') ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
			$author_class = new Molongui\Authorship\Includes\Author();
			return $author_class->get_bio( $author_id, ( isset( $wp_query->is_guest_author ) and $wp_query->is_guest_author ) ? 'guest' : 'user', false, false );
		}
		return $value;
	}, 10, 3 );
}
elseif ( 'Mundana' == $theme->name or 'Mundana' == $theme->parent_theme )
{
    add_action( 'parse_request', function( $wp_query )
    {

        if ( isset( $wp_query->query_vars['ma-guest-author'] ) and !empty( $wp_query->query_vars['ma-guest-author'] ) )
        {
            remove_action( 'pre_get_posts', 'mundana_exclude_latest_post', 1 );
            remove_action( 'pre_get_posts', 'mundana_query_offset', 1 );
        }

        return $wp_query;

    }, 1, 1 );
}