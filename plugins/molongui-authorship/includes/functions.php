<?php

use Molongui\Authorship\Includes\Author;
if ( !defined( 'ABSPATH' ) ) exit;
if ( !function_exists( 'is_guest_post' ) )
{
	function is_guest_post( $post_id = null )
	{
		if ( !isset( $post_id ) )
		{
			global $post;
			if ( empty( $post ) ) return false;
			$post_id = $post->ID;
		}
		$authors = get_post_meta( $post_id, '_molongui_author', false );
		if ( empty( $authors ) ) return false;
		foreach ( $authors as $author )
		{
			$prefix = 'guest';
			if ( strncmp( $author, $prefix, strlen( $prefix ) ) === 0 ) return true;
		}
		return false;
	}
}
if ( !function_exists( 'is_multiauthor_post' ) )
{
	function is_multiauthor_post( $post_id = null )
	{
		if ( !isset( $post_id ) )
		{
			global $post;
			if ( empty( $post ) ) return false;
			$post_id = $post->ID;
		}

		return ( count( get_post_meta( $post_id, '_molongui_author', false ) ) > 1 ? true : false );
	}
}
if ( !function_exists( 'is_guest_author' ) )
{
	function is_guest_author()
	{
		global $wp_query;

		return ( ( isset( $wp_query->is_guest_author ) ? $wp_query->is_guest_author : false ) );
	}
}
if ( !function_exists( 'molongui_is_multiauthor_link' ) )
{
	function molongui_is_multiauthor_link( $link )
	{
		$hack = '#molongui-multiauthor-link%7C%7C%7C';

		return ( strpos( $link, $hack ) !== false ? true : false );
	}
}
if ( !function_exists( 'has_local_avatar' ) )
{
	function has_local_avatar( $author_id = null, $author_type = 'user' )
	{
		switch( $author_type )
		{
			case 'user':

				$img = get_user_meta( $author_id, 'molongui_author_image_url', true );
				return ( !empty( $img ) ? true : false );

				break;

			case 'guest':

				return ( has_post_thumbnail( $author_id ) ? true : false );

				break;
		}

		return false;
	}
}
if ( !function_exists( 'molongui_get_user_by' ) )
{
	function molongui_get_user_by( $field, $value, $type = 'user' )
	{
		if ( $type == 'user' )
		{
			$user_query = new WP_User_Query(
				array(
					'search'        => $value,
					'search_fields' => array( $field ),
				)
			);
			$user = $user_query->get_results();

			return ( !empty( $user['0'] ) ? $user['0'] : false );
		}

		return false;
	}
}
$settings = get_option( MOLONGUI_AUTHORSHIP_BYLINE_SETTINGS );
if ( true )
{
	if ( !function_exists( 'get_user_by' ) )
	{
		function get_user_by( $field, $value )
		{
			$userdata = WP_User::get_data_by( $field, $value );

			if ( !$userdata )
			{
				if ( is_guest_author() )
				{
					global $wp_query;
					$user = new WP_User();
					$user->ID = $wp_query->guest_author_id;
					goto goto_label_guest_author_archive_page;
				}
				else return false;
			}

			$user = new WP_User;
			$user->init( $userdata );
			global $pagenow;
			if ( is_admin() or $pagenow == 'wp-login.php' or defined( 'DOING_AJAX' ) /*or wp_doing_ajax()*/ ) return $user;
			global $in_comment_loop;
			if ( $in_comment_loop ) return $user;
			$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 6 );
			if ( empty( $dbt ) ) return $user;
			if ( apply_filters( 'molongui_authorship_dont_override_get_user_by', false, $user, $dbt ) ) return $user;
			global $wp_query;
			if ( is_guest_author() ) //if ( is_object( $wp_query ) and $wp_query->is_guest_author )
			{
				goto_label_guest_author_archive_page:
				global $wp_query;
				if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
				$author = new Author();
				$guest_id = $wp_query->guest_author_id;
				$guest = $author->get_author( $guest_id, 'guest', false, false );
				$byline_name = false;   //  global $post;molongui_debug(array("ants", $post->ID), false, false, false, false );
				if ( in_the_loop() )
				{
					global $post;
					if ( empty( $post ) or !$post->ID )
					{
						$byline_name = false;
					}
					else
					{
						$byline_name = true;
						$post_id = $post->ID;
						$main_author = $author->get_main_author( $post_id );
					}
				}
				$user->guest_id      = $wp_query->guest_author_id;
				$user->display_name  = ( $byline_name ? $author->filter_name( $post_id ) : $author->get_name( $guest_id, 'guest', false, false, $guest ) );
				$user->user_url      = $author->get_meta( $guest_id, 'guest', 'web', false, false );
				$user->description   = $author->get_bio( $guest_id, 'guest', false, false, $guest );
                $user->user_description = $user->description;
				$user->user_nicename = ( $byline_name ? $author->get_slug( $main_author->id, $main_author->type, false, false ) : $author->get_slug( $guest_id, 'guest', false, false ) );
				$user->nickname      = $user->display_name;
				$user->user_email    = $author->get_mail( $guest_id, 'guest', false, false, $guest );
				return $user;
			}
            if ( is_object( $wp_query ) and $wp_query->is_author /*and in_the_loop()*/ )
			{
				if ( !in_the_loop() )
				{
					return $user;
				}
				global $post;
				if ( empty( $post ) or !$post->ID ) return $user;
				if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
				$author = new Author();
				$main_author = $author->get_main_author( $post->ID );
				$user->display_name  = $author->filter_name( $post->ID );
				$user->user_nicename = $author->get_slug( $main_author->id, $main_author->type, false, false );
				$user->nickname      = $user->display_name;
				return $user;
			}
			if ( ( is_object( $wp_query ) and $wp_query->is_home )
			or ( is_object( $wp_query ) and $wp_query->is_singular and molongui_is_post_type_enabled( MOLONGUI_AUTHORSHIP_ID ) ) )
			{
				global $post;
				if ( empty( $post ) or !$post->ID ) return $user;
				$post_id = apply_filters( 'molongui_authorship_override_get_user_by_post_id', $post->ID, $post, $user );
				if ( !class_exists( 'Molongui\Authorship\Includes\Author' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . '/includes/molongui-class-author.php' );
				$author = new Author();
				$main_author = $author->get_main_author( $post_id );
				if ( is_multiauthor_post( $post_id ) )
				{
					$user->display_name  = $author->filter_name( $post_id );
					$user->user_url      = $author->filter_link( $user->user_url, $post_id );
					$user->description   = '';
                    $user->user_description = $user->description;
					$user->user_nicename = $author->get_slug( $main_author->id, $main_author->type, false, false );
					$user->nickname      = $user->display_name;
					return $user;
				}
				elseif ( is_guest_post( $post_id ) )
				{
					$guest = $author->get_author( $main_author->id, 'guest', false, false );
					$user->guest_id      = $main_author->id;
					$user->display_name  = $author->filter_name( $post_id );
					$user->user_url      = $author->get_meta( $main_author->id, 'guest', 'web', false, false );
					$user->description   = $author->get_bio( $main_author->id, 'guest', false, false );
                    $user->user_description = $user->description;
					$user->user_nicename = $author->get_slug( $main_author->id, 'guest', false, false );
					$user->nickname      = $user->display_name;
					if ( isset( $dbt[1]['function'] ) and $dbt[1]['function'] != 'get_avatar_data' )
					{
						$user->user_email = $author->get_mail( $main_author->id, 'guest', false, false, $guest );
					}
					return $user;
				}
			}
			return $user;
		}
	}
}
add_action( 'pre_get_posts', 'molongui_filter_user_posts', 999 );
function molongui_filter_user_posts( $wp_query )
{
	if ( is_guest_author()
         or ( is_admin() and ( !defined( 'DOING_AJAX' ) or !DOING_AJAX /*or !wp_doing_ajax()*/ ) )
         or ( !$wp_query->is_main_query() and apply_filters_ref_array( 'molongui_edit_main_query_only', array( true, &$wp_query ) ) )
    ) return;
	if ( $wp_query->is_author() )
	{
		$meta_query = $wp_query->get( 'meta_query' );
        if ( !is_array( $meta_query ) and empty( $meta_query ) ) $meta_query = array();
        $author = get_users( array( 'nicename' => $wp_query->query_vars['author_name'] ) );
		$meta_query[] = array
		(
			'relation' => 'OR',
            array
            (
                'key'     => '_molongui_author',
                'compare' => 'NOT EXISTS',
            ),
            array
			(
                'relation' => 'AND',
                array
                (
                    'key'     => '_molongui_author',
                    'compare' => 'EXISTS',
                ),
                array
                (
                    'key'     => '_molongui_author',
                    'value'   => 'user-'.$author[0]->ID,
                    'compare' => '==',
                ),
            ),
		);
        $wp_query->set( 'meta_query', $meta_query );
	}
}
add_filter( 'posts_where', 'molongui_remove_author_from_where_clause', 10, 2 );
function molongui_remove_author_from_where_clause( $where, $wp_query )
{
    if ( is_guest_author()
         or ( is_admin() and ( !defined( 'DOING_AJAX' ) or !DOING_AJAX /*or !wp_doing_ajax()*/ ) )
         or ( !$wp_query->is_main_query() and apply_filters_ref_array( 'molongui_edit_main_query_only', array( true, &$wp_query ) ) )
    ) return $where;
    if ( $wp_query->is_author() )
    {
        if ( isset( $wp_query->query_vars['author'] ) and !empty( $wp_query->query_vars['author'] ) )
        {
            global $wpdb;
	        $where = str_replace( ' AND '.$wpdb->posts.'.post_author IN ('.$wp_query->query_vars['author'].')', '', $where );
            $where = str_replace( ' AND ('.$wpdb->posts.'.post_author = '.$wp_query->query_vars['author'].')', '', $where );
            $where = str_replace( $wpdb->postmeta.'.post_id IS NULL ', '( '.$wpdb->postmeta.'.post_id IS NULL AND '.$wpdb->posts.'.post_author = '.$wp_query->query_vars['author'].' )', $where );
        }
    }
    return $where;
}