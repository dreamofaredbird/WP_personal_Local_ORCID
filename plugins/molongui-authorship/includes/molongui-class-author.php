<?php

namespace Molongui\Authorship\Includes;
use Molongui\Authorship\FrontEnd\FrontEnd;
use WP_Query;
use WP_User_Query;
if ( !defined( 'ABSPATH' ) ) exit;
class Author
{
	protected $plugin;
	public $cpt_name = 'molongui_guestauthor';
	public function __construct( $plugin = '' )
	{
		if ( empty( $plugin ) ) molongui_get_plugin( MOLONGUI_AUTHORSHIP_ID, $this->plugin );
		else $this->plugin = $plugin;
    }
	public function find()
	{
		$authors = array();
		global $wp_query;
		global $post;
		$post_type  = get_post_type( $post );
		$post_types = molongui_supported_post_types( $this->plugin->id, 'all' );
		if ( isset( $wp_query->query_vars['ma-guest-author'] ) and !empty( $wp_query->query_vars['ma-guest-author'] ) )
		{
			$my_query = new WP_Query
            (
				array
				(
					'name'      => $wp_query->query_vars['ma-guest-author'],
					'post_type' => 'molongui_guestauthor',
				)
			);
			if ( $my_query->have_posts() )
			{
				$authors[0]       = new \stdClass();
				$authors[0]->id   = (int)$my_query->posts[0]->ID;
				$authors[0]->type = 'guest';
				$authors[0]->ref  = 'guest-'.$my_query->posts[0]->ID;
			}
			else
			{
				if ( $user = molongui_get_user_by( 'user_nicename', $wp_query->query_vars['ma-guest-author'] ) )
				{
					$authors[0]       = new \stdClass();
					$authors[0]->id   = (int)$user->ID;
					$authors[0]->type = 'user';
					$authors[0]->ref  = 'user-'.$user->ID;
				}
			}
			wp_reset_postdata();
		}
        elseif ( is_author() and isset( $wp_query->query_vars['author_name'] ) and !empty( $wp_query->query_vars['author_name'] ) )
		{
			$authors[0]       = new \stdClass();
			$authors[0]->id   = 0;
			$authors[0]->type = 'user';
			$authors[0]->ref  = 'user-0';
			if ( $user = molongui_get_user_by( 'user_nicename', $wp_query->query_vars['author_name'] ) )
			{
				$authors[0]->id  = (int)$user->ID;
				$authors[0]->ref = 'user-'.$user->ID;
			}
		}
        elseif ( in_array( $post_type, $post_types ) )
		{
			$authors = $this->get_authors( $post->ID );
		}
		if ( empty( $authors ) or $authors[0]->id == 0 ) return false;
		return $authors;
	}
	public function validate( &$id = '', &$type = '', $detail = true, $find = true )
	{
		if ( empty( $id ) and empty( $type ) )
		{
			if ( $find )
			{
				if ( !$authors = $this->find() ) return ( $detail ? __( 'No author ID nor author type provided. Please, indicate both values.', $this->plugin->textdomain ) : false );
				$id   = $authors[0]->id;
				$type = $authors[0]->type;
			}
			else
			{
				return ( $detail ? __( 'No author ID nor author type provided. Please, indicate both values.', $this->plugin->textdomain ) : false );
			}
		}
		if ( ( empty( $id ) or empty( $type ) ) and $id != 0 ) return ( $detail ? __( 'No author ID or author type provided. Please, indicate both values.', $this->plugin->textdomain ) : false );
		if ( !is_numeric( $id ) or $id == 0 ) return ( $detail ? __( "Wrong ID provided. It must be an integer higher than 0.", $this->plugin->textdomain ) : false );
        $type = strtolower( $type );
		if ( !in_array( $type, array( 'user', 'guest' ) ) ) return ( $detail ? __( "No accepted author type provided. Please, indicate 'user' or 'guest'.", $this->plugin->textdomain ) : false );
		switch ( $type )
		{
			case 'user':
				if ( !in_array( $id, get_users( array( 'fields' => 'ID') ) ) ) return ( $detail ? sprintf( __( 'No user exists with the given ID (%s).', $this->plugin->textdomain ), $id ) : false );
			break;

			case 'guest':
				if ( !in_array( $id, $this->get_guests( array(), array(), false, 'ids' ) ) ) return ( $detail ? sprintf( __( 'No guest author exists with the given ID (%s).', $this->plugin->textdomain ), $id ) : false );
			break;
		}
		return true;
	}
    public function get( $field = null )
    {
        if ( is_null( $field ) ) return false;
        $author = '';
        if ( is_string( $field ) )
        {
            $guest = new WP_Query
            (
                array
                (
                    'name'      => $field,
                    'post_type' => $this->cpt_name,
                )
            );
            if ( $guest->have_posts() and !empty( $guest->posts['0'] ) )
            {
                $author = $guest->posts['0'];
            }
            else
            {
                $author = molongui_get_user_by( 'user_nicename', $field );
            }
        }
        wp_reset_postdata();
        if ( is_int( $field ) )
        {
        }
        return $author;
    }
    public function get_type( $author = null )
    {
        if ( is_null( $author ) ) return false;
        if ( $author instanceof \WP_User ) return 'user';
        if ( $author instanceof \WP_Post ) return 'user';
        return false;
    }
	public function get_by( $field, $value, $type = 'user' )
	{
		if ( $type == 'user' )
		{
			$user_query = new WP_User_Query
            (
				array
                (
					'search'        => $value,
					'search_fields' => array( $field ),
				)
			);
			$user = $user_query->get_results();

			return ( !empty( $user['0'] ) ? $user['0'] : false );
		}
        elseif ( $type == 'guest' )
		{
			$guest = new WP_Query
            (
				array
                (
					'post_type'  => 'molongui_guestauthor',
					'meta_query' => array
                    (
						array
                        (
							'key'     => $field,
							'value'   => $value,
							'compare' => '=',
						),
					),
				)
			);

			if ( $guest->have_posts() ) return ( !empty( $guest->posts['0'] ) ? $guest->posts['0'] : false );
		}

		return false;
	}
	public function get_type_by_nicename( $nicename )
	{
		$my_query = new WP_Query
		(
			array
			(
				'name'      => $nicename,
				'post_type' => $this->cpt_name,
			)
		);
		if ( $my_query->have_posts() )
		{
			return 'guest';
		}
		else
		{
			if ( $author = molongui_get_user_by( 'user_nicename', $nicename ) )
			{
				return 'user';
			}
		}
		wp_reset_postdata();
		return 'not_found';
	}
	public function get_author( $id, $type, $validate = true, $detail = false )
	{
		if ( $validate )
		{
			$validation = $this->validate( $id, $type, $detail );
			if ( !is_bool( $validation ) or ( is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
		}
		$author = null;
        switch ( $type )
		{
			case 'user':
				add_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );
				$author = get_user_by( 'id', $id );
				remove_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );

			break;

			case 'guest':
				$author = get_post( $id );

			break;
		}
		if ( ( !$author or !is_object( $author ) ) and $detail ) $author = sprintf( __( 'No %s exists with the given ID (%s).', $this->plugin->textdomain ), ( $type == 'guest' ? __( 'guest author', $this->plugin->textdomain ) : __( 'user', $this->plugin->textdomain ) ), $id );
		return apply_filters( 'molongui_authorship_get_author', $author, $id, $type );
	}
	public function get_name( $id, $type, $validate = true, $detail = true, $author = null )
	{
		if ( $validate )
		{
			$validation = $this->validate( $id, $type, $detail );
			if ( !is_bool( $validation ) or ( is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
		}
		if ( is_null( $author ) or !$author or !is_object( $author ) ) $author = $this->get_author( $id, $type, false, false );
		if ( !$author or !is_object( $author ) ) return false;
		$name = '';
        switch ( $type )
		{
			case 'user':
				$name = $author->display_name;
			break;

			case 'guest':
				$name = $author->post_title;
			break;
		}
		if ( empty( $name ) and $detail ) $name = sprintf( __( 'No %s exists with the given ID (%s).', $this->plugin->textdomain ), ( $type == 'guest' ? __( 'guest author', $this->plugin->textdomain ) : __( 'user', $this->plugin->textdomain ) ), $id );
		return apply_filters( 'molongui_authorship_get_author_name', $name, $id, $type, $author );
	}
	public function get_slug( $id, $type, $validate = true, $detail = true, $author = null )
	{
		if ( $validate )
		{
			$validation = $this->validate( $id, $type, $detail );
			if ( !is_bool( $validation ) or ( is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
		}
		if ( is_null( $author ) or !$author or !is_object( $author ) ) $author = $this->get_author( $id, $type, false, false );
		if ( !$author or !is_object( $author ) ) return false;
		$slug = '';
		switch ( $type )
		{
			case 'user':
                $slug = $author->user_nicename;
			break;

			case 'guest':
				$slug = $author->post_name;
			break;
		}
		if ( empty( $slug ) and $detail ) $slug = sprintf( __( 'No %s exists with the given ID (%s).', $this->plugin->textdomain ), ( $type == 'guest' ? __( 'guest author', $this->plugin->textdomain ) : __( 'user', $this->plugin->textdomain ) ), $id );
		return apply_filters( 'molongui_authorship_get_author_slug', $slug, $id, $type, $author );
	}
	public function get_url( $id, $type, $validate = true, $detail = true, $author = null )
	{
		if ( $validate )
		{
			$validation = $this->validate( $id, $type, $detail );
			if ( !is_bool( $validation ) or ( is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
		}
		if ( is_null( $author ) or !$author or !is_object( $author ) ) $author = $this->get_author( $id, $type, false, false );
		if ( !$author or !is_object( $author ) ) return false;
		$url = '';
		switch ( $type )
		{
			case 'user':
				add_filter( 'molongui_authorship_dont_filter_link', '__return_true' );
				add_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );
				$url = get_author_posts_url( $id, $author->user_nicename );
				remove_filter( 'molongui_authorship_dont_filter_link', '__return_true' );
				remove_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );

			break;

			case 'guest':
				$permastruct = ( ( isset( $this->plugin->settings['guest_archive_permalink']) and !empty( $this->plugin->settings['guest_archive_permalink'] ) ) ? '/' . $this->plugin->settings['guest_archive_permalink'] : '' ) .
					           ( ( isset( $this->plugin->settings['guest_archive_base'])      and !empty( $this->plugin->settings['guest_archive_base'] ) )      ? '/' . $this->plugin->settings['guest_archive_base'] : '/author' );
				$url = $this->plugin->settings['guest_archive_enabled'] ? user_trailingslashit( home_url( $permastruct.'/'.$author->post_name ) ) : '#molongui-disabled-link';

			break;
		}
		if ( empty( $url ) and $detail ) $url = sprintf( __( 'No %s exists with the given ID (%s).', $this->plugin->textdomain ), ( $type == 'guest' ? __( 'guest author', $this->plugin->textdomain ) : __( 'user', $this->plugin->textdomain ) ), $id );
		return apply_filters( 'molongui_authorship_get_author_url', $url, $id, $type, $author, $this->plugin->settings );
	}
	public function get_link( $id, $type, $validate = true, $detail = true, $author = null )
	{
		if ( $validate )
		{
			$validation = $this->validate( $id, $type, $detail );
			if ( !is_bool( $validation ) or ( is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
		}
		$name = $url = $link = '';
        $name = $this->get_name( $id, $type, false, false, $author );
        $url = $this->get_url( $id, $type, false, false, $author );
		if ( !empty( $name ) and !empty( $url ) ) $link = '<a href="'.$url.'">'.$name.'</a>';
		return apply_filters( 'molongui_authorship_get_author_link', $link, $name, $url, $id, $type, $this->plugin->settings );
	}
	public function get_bio( $id, $type, $validate = true, $detail = true, $author = null )
	{
		if ( $validate )
		{
			$validation = $this->validate( $id, $type, $detail );
			if ( !is_bool( $validation ) or ( is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
		}
		if ( is_null( $author ) or !$author or !is_object( $author ) ) $author = $this->get_author( $id, $type, false, false );
		if ( !$author or !is_object( $author ) ) return false;
		$bio = '';
		switch ( $type )
		{
			case 'user':
				$bio = $author->description;
			break;

			case 'guest':
				$bio = $author->post_content;
			break;
		}
		if ( empty( $bio ) and $detail ) $bio = sprintf( __( 'No %s exists with the given ID (%s).', $this->plugin->textdomain ), ( $type == 'guest' ? __( 'guest author', $this->plugin->textdomain ) : __( 'user', $this->plugin->textdomain ) ), $id );
		return apply_filters( 'molongui_authorship_get_author_bio', $bio, $id, $type, $author );
	}
	public function get_mail( $id, $type, $validate = true, $detail = true, $author = null )
	{
		if ( $validate )
		{
			$validation = $this->validate( $id, $type, $detail );
			if ( !is_bool( $validation ) or ( is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
		}
		if ( is_null( $author ) or !$author or !is_object( $author ) ) $author = $this->get_author( $id, $type, false, false );
		if ( !$author or !is_object( $author ) ) return false;
		$mail = '';
		switch ( $type )
		{
			case 'user':
				$mail = $author->user_email;
			break;

			case 'guest':
				$mail = get_post_meta( $id, '_molongui_guest_author_mail', true );
			break;
		}
		if ( empty( $mail ) and $detail ) $mail = sprintf( __( 'No %s exists with the given ID (%s).', $this->plugin->textdomain ), ( $type == 'guest' ? __( 'guest author', $this->plugin->textdomain ) : __( 'user', $this->plugin->textdomain ) ), $id );
		return apply_filters( 'molongui_authorship_get_author_mail', $mail, $id, $type, $author );
	}
	public function get_meta( $id, $type, $key, $validate = true, $detail = true )
	{
        if ( empty( $key ) ) $meta = __( "Which meta do you want to retrieve? You need to provide a 'key' attribute.", $this->plugin->textdomain );
		if ( $validate )
		{
			$validation = $this->validate( $id, $type, $detail );
			if ( !is_bool( $validation ) or ( is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
		}
		$meta = '';
		switch ( $type )
		{
			case 'user':
				$meta = get_user_meta( $id, 'molongui_author_'.$key, true );
			break;

			case 'guest':
				$meta = get_post_meta( $id, '_molongui_guest_author_'.$key, true );
			break;
		}
		if ( empty( $meta ) and $detail ) $meta = sprintf( __( 'No %s exists for this author (%s).', $this->plugin->textdomain ), $key, $id );
		return apply_filters( 'molongui_authorship_get_author_meta', $meta, $id, $type, $key );
	}
	public function get_avatar( $id, $type, $size = 'full', $context = 'screen', $default = 'gravatar', $validate = true, $detail = true )
	{
		if ( $validate )
		{
			$validation = $this->validate( $id, $type, $detail );
			if ( !is_bool( $validation ) or ( is_bool( $validation ) and !$validation ) ) return ( $detail ? $validation : false );
		}
		$avatar = '';
		$attr   = array();
		if ( $context == 'box' )
		{
			$attr = array( 'class' => 'mabt-radius-'.$this->plugin->settings['avatar_style'].' molongui-border-style-'.$this->plugin->settings['avatar_border_style'].' molongui-border-width-'.$this->plugin->settings['avatar_border_width'].'-px', 'style' => 'border-color:'.$this->plugin->settings['avatar_border_color'].';', 'itemprop' => 'image' );
		}
		switch ( $type )
		{
			case 'user':
				if ( $img_id = get_user_meta( $id, 'molongui_author_image_id', true ) )
				{
					if ( $context == 'url' ) $avatar = wp_get_attachment_url( $img_id );
					else $avatar = wp_get_attachment_image( $img_id, $size, false, $attr );
				}

			break;

			case 'guest':
				if ( has_post_thumbnail( $id ) )
				{
					if ( $context == 'url' ) $avatar = get_the_post_thumbnail_url( $id, $size );
					else $avatar = get_the_post_thumbnail( $id, $size, $attr );
				}

			break;
		}
		if ( empty( $avatar ) )
		{
			switch ( $default )
			{
				case 'acronym':
					$avatar = $this->get_acronym( $this->get_name( $id, $type, false, false ) );

				break;

				case 'mm':
				case 'blank':
				case 'gravatar':
					$attr['force_display'] = true;
				    add_filter( 'molongui_authorship_dont_filter_avatar', '__return_true' );
					$avatar = get_avatar( $this->get_mail( $id, $type, false, false ), get_option( 'thumbnail_size_w' ), $this->plugin->settings['avatar_default_img'], false, $attr );
                    remove_filter( 'molongui_authorship_dont_filter_avatar', '__return_true' );
					if ( !$avatar ) $avatar = '';

				break;

				case 'none':
				default:

				break;
			}
		}
		return $avatar;
	}
	public function get_acronym ( $name, $settings = array() )
	{
		if ( empty( $name ) ) return '';
		if ( empty( $settings ) ) $settings = $this->plugin->settings;
		$html  = '';
		$html .= '<div data-avatar-type="acronym" class="mabt-radius-'.$settings['avatar_style'] . ' molongui-border-style-'.$settings['avatar_border_style'] . ' molongui-border-width-'.$settings['avatar_border_width'].'-px' . ' acronym-container" style="background:'.$settings['acronym_bg_color'].'; color:'.$settings['acronym_text_color'].';">';
		$html .= '<div class="molongui-vertical-aligned">';
		$html .= molongui_get_acronym( $name );
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
	public function get_posts( $author_id, $author_type, $get_all = false, $include = array(), $exclude = array(), $entry = 'post', $meta_query = array() )
	{
		switch ( $entry )
		{
			case 'all':
				$entries = molongui_get_post_types( 'all', 'names', false );
			break;

			case 'selected':
				$entries = molongui_supported_post_types( $this->plugin->id, 'all', false );
			break;

			case 'related':
				foreach( molongui_get_post_types( 'all', 'names', false ) as $post_type_name )
				{
					if ( isset( $this->plugin->settings['related_post_type_'.$post_type_name] ) and $this->plugin->settings['related_post_type_'.$post_type_name] ) $entries[] = $post_type_name;
				}
			break;

			default:
				$entries = $entry;
			break;
		}
		if ( $author_type == 'guest' )
		{
			if ( isset( $meta_query ) and !empty( $meta_query ) )
			{
				$mq = array
				(
					'relation'  => 'AND',
					array
					(
						'key'   => $meta_query['key'],
						'value' => $meta_query['value'],
					),
					array
					(
						'key'   => '_molongui_author',
						'value' => 'guest-'.$author_id,
					),
				);
			}
			else
			{
				$mq = array
				(
					array
					(
						'key'   => '_molongui_author',
						'value' => 'guest-'.$author_id,
					),
				);
			}
			$args = array
			(
				'post_type'           => $entries,
				'post__in'            => $include,
				'post__not_in'        => $exclude,
				'post_status'         => 'publish',
				'meta_query'          => $mq,
				'orderby'             => ( ( isset( $this->plugin->settings['related_order_by'] ) and $this->plugin->settings['related_order_by'] ) ? $this->plugin->settings['related_order_by'] : 'DESC' ),
				'order'               => ( ( isset( $this->plugin->settings['related_order'] ) and $this->plugin->settings['related_order'] ) ? $this->plugin->settings['related_order'] : 'date' ),
				'posts_per_page'      => ( $get_all ? '-1' : $this->plugin->settings['related_items'] ),
				'no_found_rows'       => true,
                'ignore_sticky_posts' => true,
			);
			$data = new WP_Query( $args );
			foreach ( $data->posts as $post ) $posts[] = $post;
			wp_reset_postdata();
		}
		else
		{
			if ( isset( $meta_query ) and !empty( $meta_query ) )
			{
				$mq = array
				(
					'relation'  => 'AND',
					array
					(
						'key'     => $meta_query['key'],
						'value'   => $meta_query['value'],
					),
					array
					(
						'key'     => '_molongui_author',
						'compare' => 'NOT EXISTS',
					),
				);
			}
			else
			{
				$mq = array
				(
					array
					(
						'key'     => '_molongui_author',
						'compare' => 'NOT EXISTS',
					),
				);
			}
			$args1 = array
			(
				'post_type'           => $entries,
				'post__in'            => $include,
				'post__not_in'        => $exclude,
				'post_status'         => 'publish',
				'meta_query'          => $mq,
				'author'              => $author_id,
				'orderby'             => ( ( isset( $this->plugin->settings['related_order_by'] ) and $this->plugin->settings['related_order_by'] ) ? $this->plugin->settings['related_order_by'] : 'DESC' ),
				'order'               => ( ( isset( $this->plugin->settings['related_order'] ) and $this->plugin->settings['related_order'] ) ? $this->plugin->settings['related_order'] : 'date' ),
				'posts_per_page'      => ( $get_all ? '-1' : $this->plugin->settings['related_items'] ),
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			);
			$data1 = get_posts( $args1 );
			if ( isset( $meta_query ) and !empty( $meta_query ) )
			{
				$mq = array
				(
					'relation'  => 'AND',
					array
					(
						'key'    => $meta_query['key'],
						'value'  => $meta_query['value'],
					),
					array
					(
						'key'     => '_molongui_author',
						'compare' => 'EXISTS',
					),
					array
					(
						'key'     => '_molongui_author',
						'value'   => 'user-'.$author_id,
						'compare' => '==',
					),
				);
			}
			else
			{
				$mq = array
				(
					array
					(
						'key'     => '_molongui_author',
						'compare' => 'EXISTS',
					),
					array
					(
						'key'     => '_molongui_author',
						'value'   => 'user-'.$author_id,
						'compare' => '==',
					),
				);
			}
			$args2 = array
			(
				'post_type'           => $entries,
				'post__in'            => $include,
				'post__not_in'        => $exclude,
				'post_status'         => 'publish',
				'meta_query'          => $mq,
				'orderby'             => ( ( isset( $this->plugin->settings['related_order_by'] ) and $this->plugin->settings['related_order_by'] ) ? $this->plugin->settings['related_order_by'] : 'DESC' ),
				'order'               => ( ( isset( $this->plugin->settings['related_order'] ) and $this->plugin->settings['related_order'] ) ? $this->plugin->settings['related_order'] : 'date' ),
				'posts_per_page'      => ( $get_all ? '-1' : $this->plugin->settings['related_items'] ),
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			);
			$data2 = get_posts( $args2 );
			$data = array_merge( $data1, $data2 );
			$postIDs = array_unique( wp_list_pluck( $data, 'ID' ) );
			if ( empty( $postIDs ) ) return array();
			$args3 = array
			(
				'post_type'           => $entries,
				'post__in'            => $postIDs,
				'post_status'         => 'publish',
				'orderby'             => ( ( isset( $this->plugin->settings['related_order_by'] ) and $this->plugin->settings['related_order_by'] ) ? $this->plugin->settings['related_order_by'] : 'DESC' ),
				'order'               => ( ( isset( $this->plugin->settings['related_order'] ) and $this->plugin->settings['related_order'] ) ? $this->plugin->settings['related_order'] : 'date' ),
				'posts_per_page'      => ( $get_all ? '-1' : $this->plugin->settings['related_items'] ),
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			);
			$posts = get_posts( $args3 );
		}
		return ( !empty( $posts ) ? $posts : array() );
	}
	public function get_coauthored_posts( $authors, $get_all = false, $exclude = array(), $entry = 'post', $meta_query = array() )
	{
		switch ( $entry )
		{
			case 'all':
				$entries = molongui_get_post_types( 'all', 'names', false );
				break;

			case 'selected':
				$entries = molongui_supported_post_types( $this->plugin->id, 'all', false );
				break;

			case 'related':
				foreach( molongui_get_post_types( 'all', 'names', false ) as $post_type_name )
				{
					if ( isset( $this->plugin->settings['related_post_type_'.$post_type_name] ) and $this->plugin->settings['related_post_type_'.$post_type_name] ) $entries[] = $post_type_name;
				}
				break;

			default:
				$entries = $entry;
				break;
		}
		if ( count( $authors ) > 1 )
		{
			$mq['authors']['relation'] = 'AND';
			foreach( $authors as $author )
			{
				$mq['authors'][] = array( 'key' => '_molongui_author', 'value' => $author->ref, 'compare' => '=' );
			}
		}
		else
		{
			$mq['authors'] = array( 'key' => '_molongui_author', 'value' => $authors, 'compare' => '=' );
		}
		if ( isset( $meta_query ) and !empty( $meta_query ) )
		{
			$mq['authors']['relation'] = 'AND';
			$mq['authors'] = array
			(
				'key'   => $meta_query['key'],
				'value' => $meta_query['value'],
			);
		}
		$args = array(
			'post_type'      => $entries,
			'orderby'        => ( isset( $this->plugin->settings['related_order_by'] ) and $this->plugin->settings['related_order_by'] ? $this->plugin->settings['related_order_by'] : 'ASC' ),
			'order'          => ( isset( $this->plugin->settings['related_order'] ) and $this->plugin->settings['related_order'] ? $this->plugin->settings['related_order'] : 'date' ),
			'posts_per_page' => ( $get_all ? '-1' : $this->plugin->settings['related_items'] ),
			'post__not_in'   => $exclude,
			'meta_query'     => $mq,
		);
		$data = new WP_Query( $args );
		foreach ( $data->posts as $post ) $posts[] = $post;
		wp_reset_postdata();
		return ( !empty( $posts ) ? $posts : array() );
	}
	public function get_data( $author_id, $author_type, $settings = array() )
	{
		$social_networks = include( $this->plugin->dir . '/config/social.php' );
		if ( empty( $settings ) ) $settings = $this->plugin->settings;
		if ( $author_type == 'guest' ) do_action( 'molongui_authorship_before_get_guest_author_data', $author_id, $settings );
		$author_post                 = $this->get_author( $author_id, $author_type, false, false );
		$author['id']                = $author_id;
		$author['type']              = $author_type;
		$author['name']              = $this->get_name( $author_id, $author_type, false, false, $author_post );
		$author['first_name']        = $this->get_meta( $author_id, $author_type, 'first_name', false, false );
		$author['last_name']         = $this->get_meta( $author_id, $author_type, 'last_name', false, false );
		$author['slug']              = $this->get_slug( $author_id, $author_type, false, false, $author_post );
		$author['mail']              = $this->get_mail( $author_id, $author_type, false, false, $author_post );
		$author['phone']             = $this->get_meta( $author_id, $author_type, 'phone', false, false );
		$author['web']               = ($author_type == 'user' ? $author_post->user_url : $this->get_meta( $author_id, $author_type, 'web', false, false ) );
		$author['archive']           = $this->get_url( $author_id, $author_type, false, false, $author_post );
		$author['img']               = $this->get_avatar( $author_id, $author_type, 'thumbnail', 'box', $settings['avatar_default_img'], false, false );
		$author['job']               = $this->get_meta( $author_id, $author_type, 'job', false, false );
		$author['company']           = $this->get_meta( $author_id, $author_type, 'company', false, false );
		$author['company_link']      = $this->get_meta( $author_id, $author_type, 'company_link', false, false );
		$author['bio']               = $this->get_bio( $author_id, $author_type, false, false, $author_post );
		$author['box']               = $this->get_meta( $author_id, $author_type, 'box_display', false, false );
		$author['show_meta_mail']    = $this->get_meta( $author_id, $author_type, 'show_meta_mail', false, false );
		$author['show_meta_phone']   = $this->get_meta( $author_id, $author_type, 'show_meta_phone', false, false );
		$author['show_social_mail']  = $this->get_meta( $author_id, $author_type, 'show_icon_mail', false, false );
		$author['show_social_web']   = $this->get_meta( $author_id, $author_type, 'show_icon_web', false, false );
		$author['show_social_phone'] = $this->get_meta( $author_id, $author_type, 'show_icon_phone', false, false );

		foreach ( $social_networks as $id => $social_network ) $author[$id] = $this->get_meta( $author_id, $author_type, $id, false, false );
		if ( $author_type == 'guest' ) do_action( 'molongui_authorship_after_get_guest_author_data', $author_id, $settings );
		return $author;
	}
	public function get_main_author( $post_id )
	{
		$data = new \stdClass();
		$main_author = get_post_meta( $post_id, '_molongui_main_author', true );
		if ( !empty( $main_author ) )
		{
			$split      = explode( '-', $main_author );
			$data->id   = $split[1];
			$data->type = $split[0];
			$data->ref  = $main_author;
		}
		else
		{
		    if ( $post_author = get_post_field( 'post_author', $post_id ) )
            {
	            $data->id    = $post_author;
	            $data->type  = 'user';
	            $data->ref   = $data->type.'-'.$data->id;
            }
            else return false;
		}
		return $data;
	}
	public function get_authors( $post_id = null, $key = '' )
	{
		if ( is_null( $post_id ) or !is_integer( $post_id ) or !$post_id )
		{
			global $post;
			if ( empty( $post ) ) return '';
			$post_id = $post->ID;
		}
		$data = array();
		$main_author = $this->get_main_author( $post_id );
		if ( empty( $main_author ) ) return false;
		$authors = get_post_meta( $post_id, '_molongui_author', false );
		if ( !empty( $authors) )
		{
			foreach ( $authors as $author )
			{
				$split  = explode( '-', $author );
				if ( $split[1] == $main_author->id ) continue;
				$data[] = (object) array( 'id' => (int)$split[1], 'type' => $split[0], 'ref' => $author );
			}
		}
		array_unshift( $data, $main_author );
		if ( !$key ) return $data;
		$values = array();
		foreach( $data as $author ) $values[] = $author->$key;
		return $values;
	}
	public function get_active_social_networks( $networks = array() )
	{
		$active = array();
		if ( empty( $networks ) ) $networks = include( $this->plugin->dir . '/config/social.php' );
		foreach ( $networks as $name => $network ) if ( $this->plugin->settings['show_'.$name] ) $active[] = $name;
		return $active;
	}
	public function is_guest( $author )
	{
		if ( is_object( $author ) and !empty( $author ) ) return ( $author->type == 'guest' ? true : false );

		if ( is_string( $author ) )
        {
	        $split = explode( '-', $author );
	        return ( $split[0] == 'guest' ? true : false );
        }
	}
	public function is_guest_post( $post_id )
	{
		$authors = get_post_meta( $post_id, '_molongui_author', false );
		foreach ( $authors as $author )
		{
			$split = explode( '-', $author );
			if ( $split[0] == 'guest' ) return true;
		}
		return false;
	}
	public function is_multiauthor( $data )
	{
		if ( is_array( $data ) ) return ( count( $data ) > 1 ? true : false );
		return ( count( $this->get_authors( $data ) ) > 1 ? true : false );
	}
	public function render_author_box( $content )
	{
		if ( ( !is_single() and !is_page() ) or is_guest_author() or !is_main_query() or !in_the_loop() ) return $content;
		global $post;
		if ( apply_filters( 'molongui_authorship_dont_render_author_box', false, $post ) ) return $content;
        $post_authors = $this->get_authors( $post->ID );
        if ( empty( $post_authors ) or $post_authors[0]->id == 0 ) return $content;
		$settings = molongui_get_plugin_settings( $this->plugin->id, array( 'box', 'byline', 'authors', 'archives', 'advanced', 'string' ) );
		$html = $this->get_box_markup( $post, $post_authors, $settings );
		if ( empty( $html ) ) return $content;
		global $multipage, $page, $numpages;
        $box_position = get_post_meta( $post->ID, '_molongui_author_box_position', true );
        if ( $box_position == 'default' ) $box_position = $this->plugin->settings['position'];
		switch ( $box_position )
		{
			case "both":

				if ( !$multipage )
				{
					$html_2  = $this->get_box_markup( $post, $post_authors, $settings );
					$content = $html.$content.$html_2;
				}
                elseif ( $page == 1 )
				{
					$content = $html.$content;
				}
                elseif ( $page == $numpages )
				{
					$content .= $html;
				}

			break;

			case "above":

				if ( !$multipage or ( $multipage and $page == 1 ) ) $content = $html.$content;

			break;

			case "below":
			case "default":
            default:

			    if ( !$multipage or ( $multipage and $page == $numpages ) ) $content .= $html;

			break;
		}
		return $content;
	}
	public function dont_render_author_box( $post, $author, $settings )
	{
		if ( !in_array( get_post_type( $post ), molongui_supported_post_types( $this->plugin->id, 'all' ) ) )
        {
	        if ( get_option( MOLONGUI_AUTHORSHIP_CONTRIBUTORS_PAGE ) != $post->ID ) return true;
        }
        switch ( $this->get_meta( $author->id, $author->type, 'box_display', false, false ) )
        {
            case 'show':    return false; break; // Show author box.
            case 'hide':    return true;  break; // Hide author box.
            case 'default':               break; // Keep checking other settings.
        }
		switch ( get_post_meta( $post->ID, '_molongui_author_box_display', true ) )
		{
			case 'show':    return false; break; // Show author box.
			case 'hide':    return true;  break; // Hide author box.
			case 'default':               break; // Keep checking other settings.
        }
        if ( is_single() and ( $settings['display'] == 'posts' or $settings['display'] == 'show' ) )
		{
			foreach ( wp_get_post_categories( $post->ID ) as $post_category )
			{
				if ( isset( $settings['hide_on_category_'.$post_category] ) and $settings['hide_on_category_'.$post_category] ) return true; // Hide author box.
			}
		}
		if ( $settings['hide_if_no_bio'] and !$this->get_bio( $author->id, $author->type, false, false ) ) return true; // Hide author box.
		if ( ( ( $settings['display'] == 'hide' ) or                      // Global setting set to not display the author box.
			   ( $settings['display'] == 'posts' and !is_single() ) or    // Global setting set to display the author box only on posts but current page is not a post.
			   ( $settings['display'] == 'pages' and !is_page() ) ) and   // Global setting set to display the author box only on pages but current page is not a page.
             ( get_option( MOLONGUI_AUTHORSHIP_CONTRIBUTORS_PAGE ) != $post->ID ) )
		{
			return true; // Hide author box.
		}
		global $multipage;
        if ( $multipage )
        {
	        global $page, $numpages;
	        $box_position = get_post_meta( $post->ID, '_molongui_author_box_position', true );
	        if ( $box_position == 'default' ) $box_position = $this->plugin->settings['position'];

	        switch ( $box_position )
            {
                case 'above':
	                if ( $page != 1 ) return true;
                break;

                case 'below':
	                if ( $page != $numpages ) return true;
                break;

                case 'both':
	                if ( $page != 1 and $page != $numpages ) return true;
                break;
            }
        }
		return false;
	}
	public function get_box_markup( $post, $post_authors, $settings = array(), $check = true )
	{
		$html = '';
		$is_multiauthor = $this->is_multiauthor( $post_authors );
		$show_headline  = true;
		if ( empty( $settings ) ) $settings = $this->plugin->settings;
		foreach ( $post_authors as $post_author )
		{
			if ( $check and $this->dont_render_author_box( $post, $post_author, $settings ) )
			{
				$authors[$post_author->ref]['hide'] = true;
				continue;
			}
			$authors[$post_author->ref] = $this->get_data( $post_author->id, $post_author->type, $settings );
			if ( $settings['show_related'] or $settings['layout'] == 'tabbed' )
			{
				$authors[$post_author->ref]['posts'] = $this->get_posts( $post_author->id, $post_author->type, false, array(), ( ( is_object( $post ) and !empty( $post->ID ) ) ? array( $post->ID ) : array() ), 'related' );
			}
			if ( !$is_multiauthor or ( $is_multiauthor and $settings['multiauthor_box_layout'] == 'individual' ) )
			{
				$author = $authors[$post_author->ref];
				$random_id = substr( number_format( time() * mt_rand(), 0, '', '' ), 0, 10 );
				ob_start();
				include( $this->plugin->dir . 'public/views/html-author-box-layout.php' );
				$html .= ob_get_clean();
				$show_headline = false;
			}
		}
		if ( $is_multiauthor                                                                                                 // It is a multi-authored post
            and                                                                                                              // and
            $settings['multiauthor_box_layout'] != 'individual'                                                              // author boxes are not displayed individually
            and                                                                                                              // and
            0 < count( array_filter( $authors, function( $a ){ return ( !isset( $a['hide'] ) or $a['hide'] == false ); } ) ) // there is at least one author to show.
        )
		{
			$random_id = substr( number_format( time() * mt_rand(), 0, '', '' ), 0, 10 );
			ob_start();
			include( $this->plugin->dir . 'public/views/html-multiauthor-box-layout.php' );
			$html .= ob_get_clean();
		}
		return $html;
	}
	public function get_box_border( $box_border )
	{
		switch ( $box_border )
		{
			case 'none':
				return 'molongui-border-none';
			break;

			case 'horizontals':
				return 'molongui-border-right-none molongui-border-left-none';
			break;

			case 'verticals':
				return 'molongui-border-top-none molongui-border-bottom-none';
			break;

			case 'top':
				return 'molongui-border-right-none molongui-border-bottom-none molongui-border-left-none';
			break;

			case 'right':
				return 'molongui-border-top-none molongui-border-bottom-none molongui-border-left-none';
			break;

			case 'bottom':
				return 'molongui-border-top-none molongui-border-right-none molongui-border-left-none';
			break;

			case 'left':
				return 'molongui-border-top-none molongui-border-right-none molongui-border-bottom-none';
			break;

			case 'all':
			default:
				return '';
			break;
		}
	}
	public function add_author_meta()
	{
		global $post;
		if ( empty( $post ) or empty( $post->ID ) ) return;
		if ( !$this->plugin->settings['add_opengraph_meta'] and !$this->plugin->settings['add_google_meta'] and !$this->plugin->settings['add_facebook_meta'] ) return;
		if ( !$main_author = $this->get_main_author( $post->ID ) ) return;
		if ( $this->is_guest( $main_author ) )
		{
			$author['name'] = get_post_field( 'post_title', $main_author->id );
			$author['web']  = get_post_meta( $main_author->id, '_molongui_guest_author_web', true );
			$author['fb']   = get_post_meta( $main_author->id, '_molongui_guest_author_facebook', true );
			$author['gp']   = get_post_meta( $main_author->id, '_molongui_guest_author_googleplus', true );
		}
		else
		{
			$user = get_userdata( $main_author->id );
			$author['name'] = $user->display_name;
			$author['web']  = $user->user_url;
			$author['fb']   = get_the_author_meta( 'molongui_author_facebook' );
			$author['gp']   = get_the_author_meta( 'molongui_author_googleplus' );
		}
		if ( molongui_is_premium( $this->plugin->dir ) ) $meta = "\n<!-- Molongui Authorship " . $this->plugin->version . ", visit: https://wordpress.org/plugins/molongui-authorship/ -->\n";
		else $meta = "\n<!-- Molongui Authorship Premium " . $this->plugin->version . ", visit: " . $this->plugin->web . " -->\n";
		$authors = $this->get_authors( $post->ID );
		$meta .= '<meta name="author" content="'.$this->prepare_name( $authors, count( $authors ) ).'">';
		if ( $this->plugin->settings['add_google_meta'] == 1 && isset( $author['gp'] ) && $author['gp'] <> '' ) $meta .= $this->add_google_author_meta( $author['gp'] );
		if ( $this->plugin->settings['add_facebook_meta'] == 1 && isset( $author['fb'] ) && $author['fb'] <> '' ) $meta .= $this->add_facebook_author_meta( $author['fb'] );
		if ( $this->plugin->settings['add_opengraph_meta'] == 1 && is_author() )
		{
			$meta .= $this->add_opengraph_meta( $author['name'], $author['web'] );
		}

		$meta .= "<!-- /Molongui Authorship -->\n\n";

		echo $meta;
	}
	public function add_opengraph_meta( $author_name, $author_link )
	{
		$og  = '';
		$og .= sprintf( '<meta property="og:type" content="%s" />', 'profile' ) . "\n";
		$og .= ( $author_link ? sprintf( '<meta property="og:url" content="%s" />', $author_link )."\n" : '' );
		$og .= ( $author_name ? sprintf( '<meta property="profile:username" content="%s" />', $author_name )."\n" : '' );

		return $og;
	}
	public function add_google_author_meta( $author_gp )
	{
		return '<link rel="author" href="' . ( ( strpos( $author_gp, 'http' ) === false ) ? 'https://plus.google.com/' : '' ) . $author_gp . '" />' . "\n";
	}
	public function add_facebook_author_meta( $author_fb )
	{
		return '<meta property="article:author" content="' . ( ( strpos( $author_fb, 'http' ) === false ) ? 'https://www.facebook.com/' : '' ) . $author_fb . '" />' . "\n";
	}
	public function maybe_filter_name( $display_name )
	{
        if ( is_admin() and ( !defined( 'DOING_AJAX' ) or !DOING_AJAX /*or !wp_doing_ajax()*/ ) ) return $display_name;
		global $post;
		if ( empty( $post ) or !$post->ID ) return $display_name;
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
		if ( empty( $dbt ) ) return $display_name;
		if ( apply_filters( 'molongui_authorship_dont_filter_name', false, $display_name, $post, $dbt ) ) return $display_name;
		$args = array( 'class' => $this, 'display_name' => &$display_name, 'post' => $post, 'dbt' => $dbt );
		if ( apply_filters_ref_array( 'molongui_authorship_do_filter_name', array( false, &$args ) ) ) return $display_name;
        if ( is_author() or is_guest_author() ) return $display_name;
		return $this->filter_name();
	}
	public function maybe_filter_the_author_display_name( $display_name, $user_id = null, $original_user_id = null )
	{
        if ( !empty( $original_user_id ) and !apply_filters( 'molongui_authorship_bypass_original_user_id_if', false ) ) return $display_name;
        if ( is_admin() and ( !defined( 'DOING_AJAX' ) or !DOING_AJAX /*or !wp_doing_ajax()*/ ) ) return $display_name;
		global $post;
		if ( empty( $post ) or !$post->ID ) return $display_name;
		$post_id = apply_filters( 'molongui_authorship_filter_the_author_display_name_post_id', $post->ID, $post, $display_name );
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 5 );
		if ( empty( $dbt ) ) return $display_name;
		if ( apply_filters( 'molongui_authorship_dont_filter_the_author_display_name', false, $display_name, $user_id, $original_user_id, $post, $dbt ) ) return $display_name;
		if ( is_author() and !is_guest_author() ) return $display_name;
		return $this->filter_name( $post_id );
	}
	public function filter_archive_title( $title )
    {
	    global $wp_query;
	    if ( !is_author() ) return $title;
	    if ( is_guest_author() and isset( $wp_query->guest_author_id ) ) return get_post_field( 'post_title', $wp_query->guest_author_id );
        if ( $wp_query->query_vars['author'] )
        {
	        add_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );
	        $user = get_user_by( 'id', $wp_query->query_vars['author'] );
	        remove_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );

            return $user->display_name;
        }
        return $title;
	}
    public function filter_archive_description( $description )
    {
        global $wp_query;
        if ( !is_author() ) return $description;
        if ( is_guest_author() and isset( $wp_query->guest_author_id ) ) return get_post_field( 'post_content', $wp_query->guest_author_id );
        if ( $wp_query->query_vars['author'] )
        {
            add_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );
            $user = get_user_by( 'id', $wp_query->query_vars['author'] );
            remove_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );
            return $user->description;
        }
        return $description;
    }
	public function filter_name( $pid = null )
    {
	    return $this->get_byline( $pid );
    }
	public function get_byline( $pid = null, $separator = '', $last_separator = '', $linked = false )
	{
		if ( is_null( $pid ) or !is_integer( $pid ) or !$pid )
		{
			global $post;
			if ( empty( $post ) ) return '';
			$pid = $post->ID;
		}
		if ( $authors = $this->get_authors( $pid ) )
		{
			switch ( $this->plugin->settings['byline_multiauthor_display'] )
			{
				case 'main':

					$byline = $this->prepare_name( $authors, '1', false, '', '', $linked );

				break;
				case '1':

					$byline = $this->prepare_name( $authors, '1', true, '', $last_separator, $linked );

				break;
				case '2':

					$byline = $this->prepare_name( $authors, '2', true, $separator, $last_separator, $linked );

				break;
				case '3':

					$byline = $this->prepare_name( $authors, '3', true, $separator, $last_separator, $linked );

				break;
				case 'all':
				default:

					$byline = $this->prepare_name( $authors, count( $authors ), false, $separator, $last_separator, $linked );

				break;
			}
		}

		return ( isset( $byline ) ? $byline : '' );
	}
	private function prepare_name( $authors, $qty, $count = true, $separator = '', $last_separator = '', $linked = false )
	{
        if ( !$authors ) return;
		$string = '';
		$total  = count( $authors );
		$i = 0;
		$separator      = ( !empty( $separator ) ? $separator : ( ( isset( $this->plugin->settings['byline_multiauthor_separator'] ) and !empty( $this->plugin->settings['byline_multiauthor_separator'] ) ) ? $this->plugin->settings['byline_multiauthor_separator'] : ', ' ) );
		$last_separator = ( !empty( $last_separator ) ? $last_separator : ( ( isset( $this->plugin->settings['byline_multiauthor_last_separator'] ) and !empty( $this->plugin->settings['byline_multiauthor_last_separator'] ) ) ? $this->plugin->settings['byline_multiauthor_last_separator'] : __( 'and', $this->plugin->textdomain ) ) );
		if ( $qty < $total )
        {
	        for ( $j = 0; $j < $qty; $j++ )
	        {
		        $divider = ( $i == 0 ? '' : ( $i == ( $total - 1 ) ? ' '.$last_separator.' ' : $separator.' ' ) );
		        if ( $linked ) $item = $this->get_link( $authors[$j]->id, $authors[$j]->type, false, false );
		        else $item = $this->get_name( $authors[$j]->id, $authors[$j]->type, false, false );
		        $string .= $divider . $item;
		        if ( ++$i == $qty ) break;
	        }
	        if ( $count ) $string .= ' '.sprintf( __( '%s %d more', $this->plugin->textdomain ), $last_separator, $total - $qty );
        }
        else
        {
	        foreach ( $authors as $author )
	        {
		        $divider = ( $i == 0 ? '' : ( $i == ( $total - 1 ) ? ' '.$last_separator.' ' : $separator.' ' ) );
		        if ( $linked ) $item = $this->get_link( $author->id, $author->type, false, false );
		        else $item = $this->get_name( $author->id, $author->type, false, false );
		        $string .= $divider . $item;
		        if ( ++$i == $qty ) break;
	        }
        }

		return $string;
	}
	public function maybe_filter_link( $link )
	{
        if ( is_admin() and ( !defined( 'DOING_AJAX' ) or !DOING_AJAX /*or !wp_doing_ajax()*/ ) )  return $link;
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 8 );
		if ( empty( $dbt ) ) return $link;
		if ( apply_filters( 'molongui_authorship_dont_filter_link', false, $link, $dbt ) ) return $link;
		$args = array( 'class' => $this, 'link' => &$link, 'dbt' => $dbt );
        if ( apply_filters_ref_array( 'molongui_authorship_do_filter_link', array( false, &$args ) ) ) return $link;
		return $this->filter_link( $link );
	}
	public function filter_link( $link, $post_id = null )
	{
		if ( !isset( $post_id ) or !$post_id )
        {
	        global $post;
	        if ( empty( $post ) ) return $link;
	        if ( !$post->ID or $post->ID == 0 ) return $link;
	        $post_id = apply_filters( 'molongui_authorship_filter_link_post_id', $post->ID, $post, $link );
        }
		$authors = $this->get_authors( $post_id );
		if ( !$authors ) return $link;
        if ( $this->is_multiauthor( $authors ) )
        {
            switch ( $this->plugin->settings['byline_multiauthor_link'] )
            {
                case 'disabled':
	                return '#molongui-disabled-link';
	            break;

                case 'main':
	            break;

	            case 'magic':
                default:
                    $js_link = '#molongui-multiauthor-link';
                    $js_sep  = '%7C%7C%7C';

                    switch ( $this->plugin->settings['byline_multiauthor_display'] )
                    {
                        case 'main':
                            return $this->get_url( $authors[0]->id, $authors[0]->type, false, false );
                        break;

                        case '1':
                        case '2':
                        case '3':
                            for ( $i = 0; $i < (int) $this->plugin->settings['byline_multiauthor_display']; $i++ ) $js_link .= $js_sep . $this->get_url( $authors[$i]->id, $authors[$i]->type, false, false );
                        break;

                        case 'all':
                        default:
                            foreach ( $authors as $author ) $js_link .= $js_sep . $this->get_url( $author->id, $author->type, false, false );
                        break;
                    }
                    return str_replace( ':', '%7C%7C', $js_link );

		        break;
            }
        }
        if ( $authors[0]->type == 'guest' )
        {
            if ( $this->plugin->is_premium and $this->plugin->settings['guest_archive_enabled'] )
            {
                $guest = get_post( $authors[0]->id );
                $permalink = ( ( isset( $this->plugin->settings['guest_archive_permalink'] ) and !empty( $this->plugin->settings['guest_archive_permalink'] ) ) ? $this->plugin->settings['guest_archive_permalink'] : '' );
                $slug      = ( ( isset( $this->plugin->settings['guest_archive_base'] ) and !empty( $this->plugin->settings['guest_archive_base'] ) ) ? $this->plugin->settings['guest_archive_base'] : 'author' );
                return user_trailingslashit( home_url( ( !empty( $permalink ) ? $permalink.'/' : '' ) . $slug . '/' . $guest->post_name ) );
            }
            else
            {
                return '#molongui-disabled-link';
            }
        }
        else return $link;
	}
	public function filter_archive_link( $link )
	{
		global $wp_query;
		if ( !is_author() ) return $link;
		if ( is_guest_author() and isset( $wp_query->guest_author_id ) ) return $this->get_url( $wp_query->guest_author_id, 'guest', false, false );
		if ( $wp_query->query_vars['author'] ) return $this->get_url( $wp_query->query_vars['author'], 'user', false, false );
		return $link;
	}
	public function filter_avatar( $avatar = '', $id_or_email, $size = 96, $default = '', $alt = '', $args )
	{
        $email            = false;
		$user             = false;
        $author_type      = false;
        $author           = new \stdClass();
		$local_avatar_url = false;
		$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
		if ( empty( $dbt ) ) return $avatar;
		if ( isset( $dbt[4]['function'] ) and $dbt[4]['function'] == 'post_comment_form_avatar' ) return $avatar;
		if ( apply_filters( 'molongui_authorship_dont_filter_avatar', false, $avatar, $dbt ) ) return $avatar;
		if ( is_numeric( $id_or_email ) )
		{
			$user = get_user_by( 'id', absint( $id_or_email ) );
			if ( !isset( $user->user_email ) ) return $avatar;

			$email = $user->user_email;
		}
		elseif ( is_string( $id_or_email ) )
        {
            if ( !$id_or_email )
            {
	            $authors = $this->get_authors( null, 'id' );
	            if ( $authors )
	            {
		            $user = new \stdClass();
		            $user->guest_id = $authors[0];
	            }
            }
            elseif ( strpos( $id_or_email, '@md5.gravatar.com' ) )
			{
				return $avatar;
			}
			else
			{
				$email = $id_or_email;
			}
		}
		elseif ( $id_or_email instanceof \WP_User )
        {
			$user  = $id_or_email;
	        $email = $user->user_email;
		}
		elseif ( $id_or_email instanceof \WP_Post )
        {
			$user  = get_user_by( 'id', (int) $id_or_email->post_author );
	        $email = $user->user_email;
		}
		elseif ( $id_or_email instanceof \WP_Comment )
        {
	        if ( !empty( $id_or_email->comment_author_email ) )
            {
                $email = $id_or_email->comment_author_email;
            }
	        elseif ( !empty( $id_or_email->user_id ) )
	        {
		        add_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );
		        $user  = get_user_by( 'id', (int) $id_or_email->user_id );
		        $email = $user->user_email;
		        remove_filter( 'molongui_authorship_dont_override_get_user_by', '__return_true' );
	        }
		}
        if ( ( isset( $dbt[4]['function'] ) and ( $dbt[4]['function'] == 'wp_admin_bar_my_account_menu' or $dbt[4]['function'] == 'wp_admin_bar_my_account_item' ) ) )
		{
			$author_type = 'user';
		}
        elseif ( !$email and isset( $user->guest_id ) and $user->guest_id )
        {
	        $author_type = 'guest';
            $guest = get_post( $user->guest_id );
        }
        elseif ( !$email )
		{
			return $avatar;
		}
        elseif ( $user = $this->get_by( 'user_email', $email, 'user' ) )
		{
			$author_type = 'user';
		}
        elseif ( $guest = $this->get_by( '_molongui_guest_author_mail', $email, 'guest' ) )
		{
			$author_type = 'guest';
		}
        $author_type = apply_filters( 'molongui_filter_avatar_author_type', $author_type, $id_or_email, $dbt );
        $author->type  = $author_type;
        $author->user  = ( !empty( $user )  ? $user : '' );
        $author->guest = ( !empty( $guest ) ? $guest : '' );
        $author = apply_filters( 'molongui_filter_avatar_author', $author, $id_or_email, $dbt );
        switch ( $author->type )
        {
            case 'user':

                $user_local_avatar = get_user_meta( $author->user->ID, 'molongui_author_image_url', true );
                $local_avatar_url  = ( $user_local_avatar ? $user_local_avatar : '' );

                break;

            case 'guest':

                $local_avatar_url = ( has_post_thumbnail( $author->guest->ID ) ? get_the_post_thumbnail_url( $author->guest->ID, $size ) : '' );
                if ( !$local_avatar_url ) $local_avatar_url = get_avatar_url( $email );

                break;

            default:
                $local_avatar_url = get_avatar_url( $email );
        }
		if ( $local_avatar_url )
		{
			return $author_avatar = sprintf
			(
				"<img alt='%s' src='%s' srcset='%s' class='%s' height='%d' width='%d' %s/>",
				esc_attr( $args['alt'] ),
				esc_url( $local_avatar_url ),
				esc_attr( "$local_avatar_url 2x" ),
				esc_attr( join( ' ', array( 'avatar', 'avatar-'.(int)$args['size'], 'photo' ) ) ),
				(int) $args['height'],
				(int) $args['width'],
				$args['extra_attr']
			);
		}
		return $avatar;
	}
    public function get_all( $type = 'authors', $with_posts = false, $include_users = array(), $exclude_users = array(), $include_guests = array(), $exclude_guests = array(), $order = 'asc', $orderby = 'name', $output = 'array' )
    {
        $authors = array();
	    if ( isset( $orderby ) and $orderby == 'post_count' ) $with_posts = true;
        if ( $type == 'authors' or $type == 'users' )
        {
            $args = array
            (
                'role__in' => array( 'administrator', 'editor', 'author', 'contributor' ),
                'include'  => $include_users,
                'exclude'  => $exclude_users,
                'order'    => $order,
                'orderby'  => $orderby,
            );
            $wp_users = get_users( $args ); // Array of WP_User objects.
            if ( $output != 'dropdown' )
            {
                foreach ( $wp_users as $wp_user )
                {
                    if ( $with_posts )
                    {
                        $user_posts = $this->get_posts( $wp_user->ID, 'user', true, array(), array(), 'selected' );
                        if ( empty( $user_posts ) ) continue;  // skip right ahead and go to the next user.
                    }
                    $authors[] = $this->get_data( $wp_user->ID, 'user', $this->plugin->settings );

                    if ( isset( $user_posts ) )
                    {
                        end( $authors );
                        $authors[key( $authors )]['post_count'] = empty( $user_posts ) ? 0 : count( $user_posts );
                    }
                }
            }
            else
            {
                foreach ( $wp_users as $wp_user ) $authors[] = array( 'id' => $wp_user->ID, 'type' => 'user', 'name' => $wp_user->display_name );
            }
        }
        if ( ( $type == 'authors' or $type == 'guests' ) and ( isset( $this->plugin->settings['enable_guest_authors_feature'] ) and $this->plugin->settings['enable_guest_authors_feature'] ) )
        {
            $guests = $this->get_guests( $include_guests, $exclude_guests, false ); // Array of stdClass objects.
            if ( $output != 'dropdown' )
            {
                foreach ( $guests->posts as $guest )
                {
                    if ( $with_posts )
                    {
                        $guest_posts = $this->get_posts( $guest->ID, 'guest', true, array(), array(), 'selected' );
                        if ( empty( $guest_posts ) ) continue;  // skip right ahead and go to the next guest author.
                    }
                    $authors[] = $this->get_data( $guest->ID, 'guest', $this->plugin->settings );

                    if ( isset( $guest_posts ) )
                    {
                        end( $authors );
                        $authors[key( $authors )]['post_count'] = empty( $guest_posts ) ? 0 : count( $guest_posts );
                    }
                }
            }
            else
            {
                foreach ( $guests->posts as $guest ) $authors[] = array( 'id' => $guest->ID, 'type' => 'guest', 'name' => $guest->post_title );
            }
        }
	    if ( $orderby == 'post_count' )
        {
	        usort( $authors, function ( $a, $b ) use ( $orderby )
	        {
		        return $a[$orderby] - $b[$orderby];
	        });
        }
        else
        {
	        usort( $authors, function ( $a, $b ) use ( $orderby )
	        {
		        return strcasecmp( $a[$orderby], $b[$orderby] );
	        });
        }
        if ( $order == 'desc' ) $authors = array_reverse( $authors );
        if ( $output != 'dropdown' ) return $authors;
        $output = '';
        if( !empty( $authors ) )
        {
            $output .= '<select id="_molongui_author" name="_molongui_author" class="searchable" data-placeholder="'.__( 'Add an(other) author...', $this->plugin->textdomain ).'">';

            foreach( $authors as $author )
            {
                $output .= '<option value="'.$author['type'].'-'.$author['id'].'" data-type="['.$author['type'].']">' . $author['name'] . '</option>';
            }
            $output .= '</select>';
        }
        else
        {
            $output .= '<div><p>'.__( 'No authors found.', $this->plugin->textdomain ).'</p></div>';
        }

        $output .= '<div class="block__list block__list_words"><ul id="molongui_authors">';
        global $post;
        $post_authors = $this->get_authors( $post->ID );

        if( $post_authors )
        {
            foreach ( $post_authors as $author )
            {
                if ( $author->type == 'guest' )
                {
                    $author_name = get_post_field( 'post_title', $author->id );
                }
                else
                {
                    $user = get_userdata( $author->id );
                    $author_name = $user->display_name;
                }
                $output .= '<li data-value="'.$author->ref.'">'.$author_name.'<input type="hidden" name="molongui_authors[]" value="'.$author->ref.'" /><span class="dashicons dashicons-trash molongui-tip js-remove" data-tip="'.__( 'Remove author from selection', $this->plugin->textdomain ).'"></span></li>';
            }
        }

        $output .= '</ul></div>';
        return $output;
    }
    public function get_users( $exclude = array(), $dropdown = true )
    {

    }
    public function get_guests( $include = array(), $exclude = array(), $dropdown = true, $fields = 'all' )
    {
        global $post;
        $args   = array( 'post_type' => 'molongui_guestauthor', 'posts_per_page' => -1, 'post__in' => $include, 'post__not_in' => $exclude, 'order' => 'ASC', 'orderby' => 'title', 'post_status' => 'publish', 'fields' => $fields );
        $guests = new WP_Query( $args );
	    wp_reset_postdata();
        if ( in_array( $fields, array( 'ids', 'id=>parent' ) ) ) return $guests->posts;
        if ( !$dropdown ) return $guests;
        $post_authors = $this->get_authors( $post->ID, 'id' );
        $output = '';
        if ( $guests->have_posts() )
        {
            $output .= '<select name="_molongui_author" class="multiple">';
            foreach( $guests->posts as $guest )
            {
                $output .= '<option value="' . $guest->ID . '" ' . ( in_array( $guest->ID, $post_authors ) ? 'selected' : '' ) . '>' . $guest->post_title . '</option>';
            }
            $output .= '</select>';
            $output .= '<div><ul id="molongui-authors" class="sortable"></ul></div>';
        }
        return $output;
    }
	public function register_custom_post_type()
	{
		$labels = array
        (
			'name'					=> _x( 'Guest Authors', 'post type general name', $this->plugin->textdomain ),
			'singular_name'			=> _x( 'Guest Author', 'post type singular name', $this->plugin->textdomain ),
			'menu_name'				=> __( 'Guest Authors', $this->plugin->textdomain ),
			'name_admin_bar'		=> __( 'Guest Author', $this->plugin->textdomain ),
			'all_items'				=> ( ( isset( $this->plugin->settings['guest_menu_item_level'] ) and $this->plugin->settings['guest_menu_item_level'] != 'top' ) ? __( 'Guest authors', $this->plugin->textdomain ) : __( 'All Guest authors', $this->plugin->textdomain ) ),
			'add_new'				=> _x( 'Add New', 'molongui_guestauthor', $this->plugin->textdomain ),
			'add_new_item'			=> __( 'Add New Guest Author', $this->plugin->textdomain ),
			'edit_item'				=> __( 'Edit Guest Author', $this->plugin->textdomain ),
			'new_item'				=> __( 'New Guest Author', $this->plugin->textdomain ),
			'view_item'				=> __( 'View Guest Author', $this->plugin->textdomain ),
			'search_items'			=> __( 'Search Guest Authors', $this->plugin->textdomain ),
			'not_found'				=> __( 'No Guest Authors Found', $this->plugin->textdomain ),
			'not_found_in_trash'	=> __( 'No Guest Authors Found in the Trash', $this->plugin->textdomain ),
			'parent_item_colon'		=> '',
			'featured_image'        => __( 'Profile Image', $this->plugin->textdomain ),
			'set_featured_image'    => __( 'Set Profile Image', $this->plugin->textdomain ),
			'remove_featured_image' => __( 'Remove Profile Pmage', $this->plugin->textdomain ),
			'use_featured_image'    => __( 'Use as Profile Pmage', $this->plugin->textdomain ),
		);

		$args = array
        (
			'labels'				=> $labels,
			'description'			=> 'Holds our guest author and guest authors specific data',
			'public'				=> false,
			'exclude_from_search'	=> false,
			'publicly_queryable'	=> true, // false => not being able to edit slug from the Quick Editor.
			'show_ui'				=> true,
			'show_in_menu'          => ( ( isset( $this->plugin->settings['guest_menu_item_level'] ) and $this->plugin->settings['guest_menu_item_level'] != 'top' ) ? $this->plugin->settings['guest_menu_item_level'] : true ),
			'show_in_nav_menus'		=> true,
			'show_in_admin_bar '	=> true,
			'menu_position'			=> 5, // 5 = Below posts
			'menu_icon'				=> 'dashicons-id',
			'supports'		 		=> array( 'editor', 'thumbnail' ),
			'register_meta_box_cb'	=> '',
			'has_archive'			=> true,
			'rewrite'				=> array( 'slug' => 'guest-author' ),
		);
		register_post_type( $this->cpt_name, $args );
	}
	public function post_updated_messages( $msg )
    {
	    $msg[ $this->cpt_name ] = array
        (
            0  => '',                                       // Unused. Messages start at index 1.
		    1  => "Guest author updated.",
            2  => "Custom field updated.",                  // Probably better do not touch
            3  => "Custom field deleted.",                  // Probably better do not touch
            4  => "Guest author updated.",
            5  => "Guest author restored to revision",
            6  => "Guest author published.",
            7  => "Guest author saved.",
            8  => "Guest author submitted.",
            9  => "Guest author scheduled.",
            10 => "Guest author draft updated.",
        );

        return $msg;
    }
	public function custom_remove_menu_pages()
    {
        $slug = 'edit.php?post_type=molongui_guestauthor';

		if ( !current_user_can( 'edit_others_pages' ) and !current_user_can( 'edit_others_posts' ) )
        {
	        if ( isset( $this->plugin->settings['guest_menu_item_level'] ) and $this->plugin->settings['guest_menu_item_level'] != 'top' )
            {
                if ( $this->plugin->settings['guest_menu_item_level'] == 'users.php' ) $this->plugin->settings['guest_menu_item_level'] = 'profile.php';

                remove_submenu_page( $this->plugin->settings['guest_menu_item_level'], $slug );
            }
            else
            {
	            remove_menu_page( $slug );
            }
		}
	}
    public function change_default_title( $title )
    {
        global $current_screen;

        if ( $this->cpt_name == $current_screen->post_type ) $title = __( 'Enter guest author name here', $this->plugin->textdomain );

        return $title;
    }
    public function remove_media_buttons()
    {
        global $current_screen;

        if( $this->cpt_name == $current_screen->post_type ) remove_action( 'media_buttons', 'media_buttons' );
    }
    public function add_list_columns( $columns )
    {
        unset( $columns['title'] );
        unset( $columns['date'] );
        unset( $columns['thumbnail'] );
        return array_merge( $columns,
                            array
                            (
                                'guestAuthorPic'     => __( 'Photo', $this->plugin->textdomain ),
                                'title'		         => __( 'Name', $this->plugin->textdomain ),
                                'guestDisplayBox'    => __( 'Box', $this->plugin->textdomain ),
                                'guestAuthorBio'     => __( 'Bio', $this->plugin->textdomain ),
                                'guestAuthorMail'    => __( 'Email', $this->plugin->textdomain ),
                                'guestAuthorPhone'   => __( 'Phone', $this->plugin->textdomain ),
                                'guestAuthorUrl'     => __( 'URL', $this->plugin->textdomain ),
                                'guestAuthorJob'     => __( 'Job', $this->plugin->textdomain ),
                                'guestAuthorCia'     => __( 'Co.', $this->plugin->textdomain ),
                                'guestAuthorCiaUrl'  => __( 'Co. URL', $this->plugin->textdomain ),
                                'guestAuthorSocial'  => __( 'Social', $this->plugin->textdomain ),
                                'guestAuthorEntries' => __( 'Entries', $this->plugin->textdomain ),
                                'guestAuthorId'      => __( 'ID', $this->plugin->textdomain ),
                            )
        );
    }
    public function fill_list_columns( $column, $ID )
    {
	    $value = '';
        if ( $column == 'guestAuthorPic' )
        {
            echo get_the_post_thumbnail( $ID, array( 60, 60) );
	        return;
        }
        elseif ( $column == 'guestDisplayBox' )
	    {
            $value = $this->get_meta( $ID, 'guest', 'box_display', false, false );
            $icon  = ( empty( $value ) or $value == 'default' ) ? $this->plugin->settings['display'] : $value;
            echo '<div id="box_display_'.$ID.'" data-display-box="'.$value.'">'.'<i data-tip="'.( $icon == 'show' ? __( 'Show', $this->plugin->textdomain ) : __( 'Hide', $this->plugin->textdomain ) ).'" class="molongui-authorship-icon-'.$icon.' molongui-tip"></i>'.'</div>';
		    return;
	    }
        elseif ( $column == 'guestAuthorEntries' )
	    {
		    foreach ( molongui_supported_post_types( $this->plugin->id, 'all', true ) as $post_type )
		    {
			    echo '<div>'.count( $this->get_posts( $ID, 'guest', true, array(), array(), $post_type['id'] ) ).' '.$post_type['label'].'</div>';
		    }
		    return;
	    }
        elseif ( $column == 'guestAuthorSocial' )
        {
            $networks = $this->get_active_social_networks();
	        foreach ( $networks as $network )
	        {
		        if ( $sn = $this->get_meta( $ID, 'guest', $network, false, false ) )
                {
	                echo '<a href="'.esc_url( $sn ).'" target="_blank">';
	                    echo '<i data-tip="'.esc_url( $sn ).'" class="molongui-authorship-icon-'.$network.' molongui-tip"></i>';
	                echo '</a>';
                }
	        }
	        return;
        }
        elseif ( $column == 'guestAuthorId' )
        {
	        echo $ID;
	        return;
        }
        elseif ( $column == 'guestAuthorBio'   ) $value = $this->get_bio ( $ID, 'guest', false, false );
        elseif ( $column == 'guestAuthorMail'  ) $value = $this->get_meta( $ID, 'guest', 'mail', false, false );
        elseif ( $column == 'guestAuthorPhone' ) $value = $this->get_meta( $ID, 'guest', 'phone', false, false );
        elseif ( $column == 'guestAuthorJob'   ) $value = $this->get_meta( $ID, 'guest', 'job', false, false );
        elseif ( $column == 'guestAuthorCia'   ) $value = $this->get_meta( $ID, 'guest', 'company', false, false );

	    if ( !empty( $value ) )
	    {
		    echo '<i data-tip="'.esc_html( $value ).'" class="molongui-authorship-icon-ok molongui-tip"></i>';
		    return;
	    }
        elseif ( $column == 'guestAuthorUrl'    ) $value = $this->get_meta( $ID, 'guest', 'web', false, false );
        elseif ( $column == 'guestAuthorCiaUrl' ) $value = $this->get_meta( $ID, 'guest', 'company_link', false, false );

	    if ( !empty( $value ) )
	    {
		    echo '<a href="'.esc_url( $value ).'" target="_blank">';
		        echo '<i data-tip="'.esc_url( $value ).'" class="molongui-authorship-icon-ok molongui-tip"></i>';
		    echo '</a>';
		    return;
	    }
	    else
        {
	        echo '-';//'<i data-tip="'.esc_url( $value ).'" class="molongui-authorship-icon-minus molongui-tip"></i>';
	        return;
        }
    }
	public function edit_view_link( $url, $post )
	{
		if ( $this->cpt_name == get_post_type( $post ) )
		{
			return $this->get_url( $post->ID, 'guest', false, false );
		}
		return $url;
	}
	public function remove_view_link( $actions )
	{
		if ( $this->cpt_name == get_post_type() ) unset( $actions['view'] );

		return $actions;
	}
	public function quick_edit_add_guest_title_field()
	{
		global $pagenow, $post_type;

		if ( 'edit.php' == $pagenow and $post_type == $this->cpt_name ) add_post_type_support( $post_type, 'title' );
	}
	public function	quick_edit_add_custom_fields( $column_name, $post_type )
    {
	    if ( $column_name != 'guestDisplayBox' ) return;

	    ?>
        <fieldset class="inline-edit-col-left">
            <div class="inline-edit-col">
                <div class="inline-edit-group wp-clearfix">
                    <label class="inline-edit-status alignleft">
                        <span class="title"><?php esc_html_e( 'Author box', $this->plugin->textdomain ); ?></span>
                        <select name="_molongui_guest_author_box_display">
                            <option value="default" ><?php _e( 'Default', $this->plugin->textdomain ); ?></option>
                            <option value="show"    ><?php _e( 'Show', $this->plugin->textdomain ); ?></option>
                            <option value="hide"    ><?php _e( 'Hide', $this->plugin->textdomain ); ?></option>
                        </select>
                    </label>
                </div>
            </div>
        </fieldset>
	    <?php
    }
	public function quick_edit_populate_custom_fields()
    {
	    $current_screen = get_current_screen();
	    if ( $current_screen->id != 'edit-'.$this->cpt_name or $current_screen->post_type != $this->cpt_name ) return;
	    wp_enqueue_script( 'jquery' );
	    ?>
        <script type="text/javascript">
	        jQuery( function( $ )
            {
                var $inline_editor = inlineEditPost.edit;
                inlineEditPost.edit = function(id)
                {
                    $inline_editor.apply( this, arguments);
                    var post_id = 0;
                    if ( typeof(id) == 'object' )
                    {
                        post_id = parseInt(this.getId(id));
                    }
                    if ( post_id != 0 )
                    {
                        $row = $('#edit-' + post_id);
	                    $box_display = $('#box_display_' + post_id).data( 'display-box' );
	                    if ( $box_display === '' )
                        {
                        	$box_display = 'default';
                        }
	                    $row.find('[name="_molongui_guest_author_box_display"]').val($box_display);
	                    $row.find('[name="_molongui_guest_author_box_display"]').children('[value="' + $box_display + '"]').attr('selected', true);
                    }
                }
            });
        </script>
	    <?php
    }
	public function quick_edit_save_custom_fields( $post_id, $post )
	{
		if ( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) return;
		if ( $post->post_type != $this->cpt_name ) return;
		if ( !current_user_can( 'edit_post', $post_id ) ) return;
		if ( isset( $_POST['post_title'] ) ) update_post_meta( $post_id, '_molongui_guest_author_display_name', $_POST['post_title'] );
		if ( isset( $_POST['_molongui_guest_author_box_display'] ) ) update_post_meta( $post_id, '_molongui_guest_author_box_display', $_POST['_molongui_guest_author_box_display'] );
	}
	public function remove_bulk_edit_action( $actions )
    {
	    unset( $actions['edit'] );
	    return $actions;
    }
    public function remove_author_metabox()
    {
        $post_types = molongui_supported_post_types($this->plugin->id, 'all' );
        foreach ( $post_types as $post_type ) remove_meta_box( 'authordiv', $post_type, 'normal' );
    }
	public function add_meta_boxes( $post_type )
	{
		if ( !current_user_can( 'edit_others_pages' ) and !current_user_can( 'edit_others_posts' ) ) return;
        $post_types = molongui_supported_post_types( $this->plugin->id, 'all' );
		if ( in_array( $post_type, $post_types ) )
		{
			add_meta_box(
				'authorboxdiv'
				,__( 'Authors', $this->plugin->textdomain )
				,array( $this, 'render_author_metabox' )
				,$post_type
				,'side'
				,'high'
			);
			add_meta_box(
				'showboxdiv'
				,__( 'Authorship box', $this->plugin->textdomain )
				,array( $this, 'render_display_metabox' )
				,$post_type
				,'side'
				,'high'
			);
		}
		if ( in_array( $post_type, array( $this->cpt_name ) ) )
		{
			add_meta_box(
				'authorboxdiv'
				,__( 'Author box settings', $this->plugin->textdomain )
				,array( $this, 'render_box_metabox' )
				,$post_type
				,'side'
				,'high'
			);
			add_meta_box(
				'authorprofilediv'
				,__( 'Profile', $this->plugin->textdomain )
				,array( $this, 'render_profile_metabox' )
				,$post_type
				,'top'
				,'high'
			);
			add_meta_box(
				'authorsocialdiv'
				,__( 'Social Media', $this->plugin->textdomain )
				,array( $this, 'render_social_metabox' )
				,$post_type
				,'normal'
				,'high'
			);
		}
	}
	public function add_top_section_after_title()
    {
	    global $post, $wp_meta_boxes;
	    do_meta_boxes( get_current_screen(), 'top', $post );
	    unset( $wp_meta_boxes[ get_post_type( $post )]['top'] );
    }
	public function	add_bio_title_to_editor()
    {
	    $screen = get_current_screen();

	    if ( $screen->post_type == $this->cpt_name ) echo '<h2>'.__( 'Biography', $this->plugin->textdomain ).'</h2>';
    }
	public function render_author_metabox( $post )
	{
		wp_nonce_field( 'molongui_authorship', 'molongui_authorship_nonce' );
		?>
		<div class="molongui-metabox">
            <p class="molongui-description"><?php _e( 'Add as many authors as needed by selecting them from the dropdown below. Drag to change their order and click on trash icon to remove them. First listed author will be the main author.', $this->plugin->textdomain ); ?></p>
            <div class="molongui-field">
                <label for="_molongui_author">
                    <?php echo $this->get_all( 'authors', false, array(), array(), array(), array(), 'asc', 'name', 'dropdown' ); ?>
                </label>
            </div>
		</div>
		<?php
	}
	public function render_display_metabox( $post )
	{
		wp_nonce_field( 'molongui_authorship', 'molongui_authorship_nonce' );
		$screen = get_current_screen();
		$author_box_display  = get_post_meta( $post->ID, '_molongui_author_box_display', true );
		$author_box_position = get_post_meta( $post->ID, '_molongui_author_box_position', true );
		if ( empty( $author_box_display ) )  $author_box_display  = 'default';
		if ( empty( $author_box_position ) ) $author_box_position = 'default';
		?>
		<div class="molongui-metabox">

            <!-- Author box display -->
			<p class="molongui-description"><?php _e( 'Show the author box in this post?', $this->plugin->textdomain ); ?></p>
			<div class="molongui-field">
				<select name="_molongui_author_box_display">
					<option value="default" <?php selected( $author_box_display, 'default' ); ?>><?php _e( 'Default', $this->plugin->textdomain ); ?></option>
					<option value="show"    <?php selected( $author_box_display, 'show' );    ?>><?php _e( 'Show', $this->plugin->textdomain ); ?></option>
					<option value="hide"    <?php selected( $author_box_display, 'hide' );    ?>><?php _e( 'Hide', $this->plugin->textdomain ); ?></option>
				</select>
			</div>

            <!-- Author box position -->
            <p class="molongui-description <?php echo ( $author_box_display == 'hide' ? 'molongui-description-disabled' : '' ); ?>"><?php _e( 'Where to display the author box?', $this->plugin->textdomain ); ?></p>
            <div class="molongui-field">
                <select name="_molongui_author_box_position" <?php echo ( $author_box_display == 'hide' ? 'disabled' : '' ); ?>>
                    <option value="default" <?php selected( $author_box_position, 'default' ); ?>><?php _e( 'Default', $this->plugin->textdomain ); ?></option>
                    <option value="above"   <?php selected( $author_box_position, 'above' );   ?>><?php _e( 'Above', $this->plugin->textdomain ); ?></option>
                    <option value="below"   <?php selected( $author_box_position, 'below' );   ?>><?php _e( 'Below', $this->plugin->textdomain ); ?></option>
                    <option value="both"    <?php selected( $author_box_position, 'both'  );   ?>><?php _e( 'Both', $this->plugin->textdomain );  ?></option>
                </select>
            </div>

		</div>
		<?php
	}
	public function render_box_metabox( $post )
	{
		wp_nonce_field( 'molongui_authorship', 'molongui_authorship_nonce' );
		$guest_author_hide_box   = get_post_meta( $post->ID, '_molongui_guest_author_box_display', true );
		$guest_author_mail_icon  = get_post_meta( $post->ID, '_molongui_guest_author_show_icon_mail', true );
		$guest_author_phone_icon = get_post_meta( $post->ID, '_molongui_guest_author_show_icon_phone', true );
		$guest_author_web_icon   = get_post_meta( $post->ID, '_molongui_guest_author_show_icon_web', true );
		$guest_author_mail_meta  = get_post_meta( $post->ID, '_molongui_guest_author_show_meta_mail', true );
		$guest_author_phone_meta = get_post_meta( $post->ID, '_molongui_guest_author_show_meta_phone', true );
        ?>
		<div class="molongui-metabox">

<!--		<div class="molongui-description" style="margin-bottom:10px;"><?php _e( 'Check the box below to disable the author box for this guest author regardless of other post or plugin settings.', $this->plugin->textdomain ); ?></div>
-->
            <!-- Author box display -->
            <p class="molongui-description">
	            <?php
                    _e( 'Display the author box for this author regardless of other post or plugin settings?', $this->plugin->textdomain );
	                if ( !$this->plugin->is_premium ) echo ' <i>'.sprintf( __( 'Disabled options are only available in the %sPremium version%s of the plugin.', $this->plugin->textdomain ), '<a href="'.$this->plugin->web.'">', '</a>' ).'</i>';
                ?>
            </p>
            <div class="molongui-field">
                <select name="_molongui_guest_author_box_display" id="_molongui_guest_author_box_display">
                    <option value="default" <?php selected( $guest_author_hide_box, 'default' ); ?>><?php _e( 'Default', $this->plugin->textdomain ); ?></option>
                    <option value="show"    <?php selected( $guest_author_hide_box, 'show' ); disabled( $this->plugin->is_premium, false ); ?>><?php _e( 'Show', $this->plugin->textdomain ); ?></option>
                    <option value="hide"    <?php selected( $guest_author_hide_box, 'hide' ); disabled( $this->plugin->is_premium, false ); ?>><?php _e( 'Hide', $this->plugin->textdomain ); ?></option>
                </select>
            </div>

            <!-- Display email as author meta -->
            <div class="molongui-field">
                <div class="input-wrap">
                    <input type="checkbox" id="_molongui_guest_author_show_meta_mail" name="_molongui_guest_author_show_meta_mail" value="1" <?php echo ( $guest_author_mail_meta ? 'checked=checked' : '' ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
                    <label class="checkbox-label" for="_molongui_guest_author_show_meta_mail"><?php _e( 'Display e-mail in the author meta line, which is displayed below author name.', $this->plugin->textdomain ); ?></label>
                </div>
            </div>

            <!-- Display phone as author meta -->
            <div class="molongui-field">
                <div class="input-wrap">
                    <input type="checkbox" id="_molongui_guest_author_show_meta_phone" name="_molongui_guest_author_show_meta_phone" value="1" <?php echo ( $guest_author_phone_meta ? 'checked=checked' : '' ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
                    <label class="checkbox-label" for="_molongui_guest_author_show_meta_phone"><?php _e( 'Display phone in the author meta line, which is displayed below author name.', $this->plugin->textdomain ); ?></label>
                </div>
            </div>

            <!-- Display website as social icon -->
            <div class="molongui-field">
                <div class="input-wrap">
                    <input type="checkbox" id="_molongui_guest_author_show_icon_web" name="_molongui_guest_author_show_icon_web" value="1" <?php echo ( $guest_author_web_icon ? 'checked=checked' : '' ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
                    <label class="checkbox-label" for="_molongui_guest_author_show_icon_web"><?php _e( 'Display website as an icon with social icons.', $this->plugin->textdomain ); ?></label>
                </div>
            </div>

            <!-- Display email as social icon -->
            <div class="molongui-field">
                <div class="input-wrap">
                    <input type="checkbox" id="_molongui_guest_author_show_icon_mail" name="_molongui_guest_author_show_icon_mail" value="1" <?php echo ( $guest_author_mail_icon ? 'checked=checked' : '' ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
                    <label class="checkbox-label" for="_molongui_guest_author_show_icon_mail"><?php _e( 'Display e-mail as an icon with social icons.', $this->plugin->textdomain ); ?></label>
                </div>
            </div>

            <!-- Display phone as social icon -->
            <div class="molongui-field">
                <div class="input-wrap">
                    <input type="checkbox" id="_molongui_guest_author_show_icon_phone" name="_molongui_guest_author_show_icon_phone" value="1" <?php echo ( $guest_author_phone_icon ? 'checked=checked' : '' ); echo ( $guest_author_hide_box == 'hide' ? 'disabled' : '' ); ?>>
                    <label class="checkbox-label" for="_molongui_guest_author_show_icon_phone"><?php _e( 'Display phone as an icon with social icons.', $this->plugin->textdomain ); ?></label>
                </div>
            </div>

            <script>
				document.getElementById('_molongui_guest_author_box_display').onchange = function()
				{
					var $disabled = false;
					if ( this.value === 'hide' ) $disabled = true;

					document.getElementById('_molongui_guest_author_show_meta_phone').disabled = $disabled;
					document.getElementById('_molongui_guest_author_show_meta_mail').disabled  = $disabled;
					document.getElementById('_molongui_guest_author_show_icon_mail').disabled  = $disabled;
					document.getElementById('_molongui_guest_author_show_icon_web').disabled   = $disabled;
					document.getElementById('_molongui_guest_author_show_icon_phone').disabled = $disabled;
				};
            </script>
		</div>
        <?php
	}
	public function render_profile_metabox( $post )
	{
		wp_nonce_field( 'molongui_authorship', 'molongui_authorship_nonce' );
		$guest_author_first_name   = get_post_meta( $post->ID, '_molongui_guest_author_first_name', true );
		$guest_author_last_name    = get_post_meta( $post->ID, '_molongui_guest_author_last_name', true );
		$guest_author_display_name = get_post_meta( $post->ID, '_molongui_guest_author_display_name', true ); //get_the_title( $post->ID );
		$guest_author_mail         = get_post_meta( $post->ID, '_molongui_guest_author_mail', true );
		$guest_author_phone        = get_post_meta( $post->ID, '_molongui_guest_author_phone', true );
		$guest_author_web          = get_post_meta( $post->ID, '_molongui_guest_author_web', true );
		$guest_author_job          = get_post_meta( $post->ID, '_molongui_guest_author_job', true );
		$guest_author_company      = get_post_meta( $post->ID, '_molongui_guest_author_company', true );
		$guest_author_company_link = get_post_meta( $post->ID, '_molongui_guest_author_company_link', true );
        ?>
		<div class="molongui molongui-metabox">

		    <div class="molongui-flex-container molongui-settings-container">

                <div class="molongui-flex-row">

                    <div class="molongui-flex-column">
                        <div class="molongui-flex-content">

                            <div class="molongui-field">
                                <label class="title" for="_molongui_guest_author_first_name">
                                    <?php _e( 'First name', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                                    <i class="tip molongui-authorship-icon-tip molongui-help-tip" data-tip="<?php _e( "Author's name", $this->plugin->textdomain ); ?>"></i>
                                </label>
                                <input type="text" name="_molongui_guest_author_first_name" id="_molongui_guest_author_first_name" value="<?php echo esc_attr( $guest_author_first_name ); ?>" class="regular-text" />
                            </div>

                            <div class="molongui-field">
                                <label class="title" for="_molongui_guest_author_last_name">
                                    <?php _e( 'Last name', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                                    <i class="tip molongui-authorship-icon-tip molongui-help-tip" data-tip="<?php _e( "Author's last name", $this->plugin->textdomain ); ?>"></i>
                                </label>
                                <input type="text" name="_molongui_guest_author_last_name" id="_molongui_guest_author_last_name" value="<?php echo esc_attr( $guest_author_last_name ); ?>" class="regular-text" />
                            </div>

                            <div class="molongui-field">
                                <label class="title" for="_molongui_guest_author_display_name">
                                    <?php _e( 'Display name', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                                    <i class="tip molongui-authorship-icon-tip molongui-help-tip" data-tip="<?php _e( "This is a phrase that refers to the author's name. Most of the time, it is the name of the author, but you can write in whatever you wish. This will be shown as author name.", $this->plugin->textdomain ); ?>"></i>
                                </label>
                                <input type="text" name="_molongui_guest_author_display_name" id="_molongui_guest_author_display_name" value="<?php echo esc_attr( $guest_author_display_name ); ?>" class="regular-text" />
                            </div>

                            <div class="molongui-field">
                                <label class="title" for="_molongui_guest_author_mail">
                                    <?php _e( 'E-mail', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                                    <i class="tip molongui-authorship-icon-tip molongui-help-tip" data-tip="<?php _e( "Author's e-mail address. Used to retrieve author's Gravatar if it exists and no local avatar is uploaded. This field is not displayed in the front-end unless configured so. See 'Author box settings' on this same page.", $this->plugin->textdomain ); ?>"></i>
                                </label>
                                <input type="text" name="_molongui_guest_author_mail" id="_molongui_guest_author_mail" value="<?php echo esc_attr( $guest_author_mail ); ?>" class="regular-text" />
                            </div>

                            <div class="molongui-field">
                                <label class="title" for="_molongui_guest_author_web">
                                    <?php _e( 'Website', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                                    <i class="tip molongui-authorship-icon-tip molongui-help-tip" data-tip="<?php _e( "URL to the author's website, blog or profile page. Leave blank to prevent this field to be displayed in the front-end.", $this->plugin->textdomain ); ?>"></i>
                                </label>
                                <input type="text" name="_molongui_guest_author_web" id="_molongui_guest_author_web" value="<?php echo esc_attr( $guest_author_web ); ?>" class="regular-text" />
                            </div>

                            <div class="molongui-field">
                                <label class="title" for="_molongui_guest_author_phone"><?php _e( 'Phone', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                                    <i class="tip molongui-authorship-icon-tip molongui-help-tip" data-tip="<?php _e( "Author's telephone number. This field is not displayed in the front-end unless configured so. See 'Author box settings' on this same page.", $this->plugin->textdomain ); ?>"></i>
                                </label>
                                <input type="text" name="_molongui_guest_author_phone" id="_molongui_guest_author_author_phone" value="<?php echo esc_attr( $guest_author_phone ); ?>" class="regular-text" />
                            </div>

                        </div>
                    </div>

                    <div class="molongui-flex-column">
                        <div class="molongui-flex-content">

                            <div class="molongui-field">
                                <label class="title" for="_molongui_guest_author_job">
                                    <?php _e( 'Job title', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                                    <i class="tip molongui-authorship-icon-tip molongui-help-tip" data-tip="<?php _e( 'Name used to describe what the author does for a business or another enterprise. It will be displayed in the author box, just below the author name. Leave blank to prevent this field to be displayed in the front-end.', $this->plugin->textdomain ); ?>"></i>
                                </label>
                                <input type="text" name="_molongui_guest_author_job" id="_molongui_guest_author_job" value="<?php echo esc_attr( $guest_author_job ); ?>" class="regular-text" />
                            </div>

                            <div class="molongui-field">
                                <label class="title" for="_molongui_guest_author_company">
                                    <?php _e( 'Company', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                                    <i class="tip molongui-authorship-icon-tip molongui-help-tip" data-tip="<?php _e( 'The name of the company the author works for. It will be displayed in the author box, just below the author name. Leave blank to prevent this field to be displayed in the front-end.', $this->plugin->textdomain ); ?>"></i>
                                </label>
                                <input type="text" name="_molongui_guest_author_company" id="_molongui_guest_author_company" value="<?php echo esc_attr( $guest_author_company ); ?>" class="regular-text" />
                            </div>

                            <div class="molongui-field">
                                <label class="title" for="_molongui_guest_author_company_link">
                                    <?php _e( 'Company URL', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ); ?>
                                    <i class="tip molongui-authorship-icon-tip molongui-help-tip" data-tip="<?php _e( 'URL the company name will link to. Leave blank to disable link feature.', $this->plugin->textdomain ); ?>"></i>
                                </label>
                                <input type="text" name="_molongui_guest_author_company_link" id="_molongui_guest_author_company_link" value="<?php echo esc_attr( $guest_author_company_link ); ?>" class="regular-text" />
                            </div>

                        </div>
                    </div>

                </div>

            </div>

		</div>
        <?php
	}
	public function render_social_metabox( $post )
	{
		wp_nonce_field( 'molongui_authorship', 'molongui_authorship_nonce' );
        $social_networks = include( $this->plugin->dir . '/config/social.php' );
        echo '<div class="molongui molongui-metabox">';

            foreach ( $social_networks as $id => $social_network )
            {
                if ( in_array( $id, array( 'mail', 'web' ) ) ) continue;

                $social_networks[$id]['value'] = get_post_meta( $post->ID, '_molongui_guest_author_'.$id, true );

                if ( isset( $this->plugin->settings['show_'.$id] ) and ( $this->plugin->settings['show_'.$id] == 1 ) or $this->plugin->settings['show_'.$id] )
                {
                    echo '<div class="molongui-field">';
                        echo '<label class="title" for="_molongui_guest_author_'.$id.'">' . $social_networks[$id]['name'];
                            if ( !molongui_is_premium( $this->plugin->dir ) and $social_network['premium'] ) echo '<a href="' . $this->plugin->web . '" target="_blank">' . '<i class="molongui-authorship-icon-star molongui-help-tip molongui-premium-setting" data-tip="' . $this->premium_option_tip() . '"></i>' . '</a>';
                        echo '</label>';
                        if ( !molongui_is_premium( $this->plugin->dir ) and $social_network['premium'] )
                        {
                            echo '<div class="input-wrap"><input type="text" disabled placeholder="' . __( 'Premium feature', $this->plugin->textdomain ) . '" id="_molongui_guest_author_'.$id.'" name="_molongui_guest_author_'.$id.'" value="" class="text"></div>';
                        }
                        else
                        {
                            echo '<div class="input-wrap"><input type="text" placeholder="' . $social_networks[$id]['url'] . '" id="_molongui_guest_author_'.$id.'" name="_molongui_guest_author_'.$id.'" value="' . ( $social_networks[$id]['value'] ? $social_networks[$id]['value'] : '' ) . '" class="text"></div>';
                        }
                    echo '</div>';
                }
            }

        echo '</div>';
	}
    public function premium_option_tip()
    {
        return sprintf( __( '%sPremium feature%s. You are using the free version of this plugin. Consider purchasing the Premium Version to enable this feature.', $this->plugin->textdomain ), '<strong>', '</strong>' );
    }
	public function filter_cpt_title( $data , $postarr )
    {
	    if ( $postarr['ID'] == null or empty( $_POST ) ) return $data;
	    if ( !isset( $_POST['molongui_authorship_nonce'] ) or !wp_verify_nonce( $_POST['molongui_authorship_nonce'], 'molongui_authorship' ) ) return $data;
	    if ( $data['post_type'] != $this->cpt_name ) return $data;
        $first_name   = ( isset( $_POST['_molongui_guest_author_first_name'] )   and !empty( $_POST['_molongui_guest_author_first_name'] ) )   ? $_POST['_molongui_guest_author_first_name']    : '';
        $last_name    = ( isset( $_POST['_molongui_guest_author_last_name'] )    and !empty( $_POST['_molongui_guest_author_last_name'] ) )    ? $_POST['_molongui_guest_author_last_name']     : '';
        $display_name = ( isset( $_POST['_molongui_guest_author_display_name'] ) and !empty( $_POST['_molongui_guest_author_display_name'] ) ) ? $_POST['_molongui_guest_author_display_name']  : '';
        if ( $display_name ) $post_title = sanitize_text_field( $_POST['_molongui_guest_author_display_name'] );
	    elseif (  $first_name and  $last_name ) $post_title = sanitize_text_field( $_POST['_molongui_guest_author_first_name'] ) . ' ' . sanitize_text_field( $_POST['_molongui_guest_author_last_name'] );
	    elseif (  $first_name and !$last_name ) $post_title = sanitize_text_field( $_POST['_molongui_guest_author_first_name'] );
	    elseif ( !$first_name and  $last_name ) $post_title = sanitize_text_field( $_POST['_molongui_guest_author_last_name'] );

	    if ( isset( $post_title ) and !empty( $post_title ) ) $data['post_title'] = $post_title;
        if ( empty( $postarr['post_name'] ) or substr( $data['post_name'], 0, strlen( 'auto-draft' ) ) === 'auto-draft' )
        {
	        $data['post_name'] = apply_filters( 'molongui_authorship_guest_author_slug', sanitize_title( sanitize_title_with_dashes ( $post_title, '', 'save' ) ), $first_name, $last_name, $display_name, $data );
        }
		return $data;
	}
	public function save_authors( $data, $post_id, $class = '', $fn = '' )
	{
		if ( empty( $data['molongui_authors'] ) )
		{
			$current_user = wp_get_current_user();
			$data['molongui_authors'][0] = 'user-'.$current_user->ID;
		}
		delete_post_meta( $post_id, '_molongui_author' );
		foreach( $data['molongui_authors'] as $author ) add_post_meta( $post_id, '_molongui_author', $author, false );
		update_post_meta( $post_id, '_molongui_main_author', $data['molongui_authors'][0] );
		if ( !$this->is_guest( $data['molongui_authors'][0] ) )
		{
			$split = explode( '-', $data['molongui_authors'][0] );
			global $wpdb;
			$author = array( 'post_author' => $split[1] );
			$where  = array( 'ID' => $post_id );
			if ( false === $wpdb->update( $wpdb->posts, $author, $where ) )
			{
			}
		};
	}
	public function save( $post_id )
	{
		if ( !isset( $_POST['molongui_authorship_nonce'] ) or !wp_verify_nonce( $_POST['molongui_authorship_nonce'], 'molongui_authorship' ) ) return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) return $post_id;
		if ( wp_is_post_revision( $post_id ) ) return $post_id;
		if ( 'page' == $_POST['post_type'] ) if ( !current_user_can( 'edit_page', $post_id ) ) return $post_id;
		elseif ( !current_user_can( 'edit_post', $post_id ) ) return $post_id;

		global $current_screen;
		if ( $this->cpt_name == $current_screen->post_type )
		{
			$social_networks = include( $this->plugin->dir . '/config/social.php' );
			$inputs = array
			(
				'_molongui_guest_author_first_name',
				'_molongui_guest_author_last_name',
				'_molongui_guest_author_display_name',
				'_molongui_guest_author_mail',
				'_molongui_guest_author_phone',
				'_molongui_guest_author_web',
				'_molongui_guest_author_job',
				'_molongui_guest_author_company',
				'_molongui_guest_author_company_link',
			);
			foreach ( $inputs as $input )
			{
				if ( isset( $_POST[$input] ) and !empty( $_POST[$input] ) ) update_post_meta( $post_id, $input, sanitize_text_field( $_POST[$input] ) );
				else delete_post_meta( $post_id, $input );
			}
			foreach ( $social_networks as $id => $social_network )
			{
				if ( isset( $_POST['_molongui_guest_author_'.$id] ) and !empty( $_POST['_molongui_guest_author_'.$id] ) ) update_post_meta( $post_id, '_molongui_guest_author_'.$id, sanitize_text_field( $_POST['_molongui_guest_author_'.$id] ) );
				else delete_post_meta( $post_id, '_molongui_guest_author_'.$id );
			}
            $checkboxes = array
            (
	            '_molongui_guest_author_show_meta_mail',
	            '_molongui_guest_author_show_meta_phone',
	            '_molongui_guest_author_show_icon_mail',
	            '_molongui_guest_author_show_icon_web',
	            '_molongui_guest_author_show_icon_phone',
            );
            foreach ( $checkboxes as $checkbox )
            {
	            if ( isset( $_POST[$checkbox] ) ) update_post_meta( $post_id, $checkbox, sanitize_text_field( $_POST[$checkbox] ) );
	            else delete_post_meta( $post_id, $checkbox );
            }
			update_post_meta( $post_id, '_molongui_guest_author_box_display', 'default' );
			if ( molongui_is_premium( $this->plugin->dir ) )
			{
				$selects = array
				(
					'_molongui_guest_author_box_display',
				);
				foreach ( $selects as $select )
				{
					if ( isset( $_POST[$select] ) and !empty( $_POST[$select] ) ) update_post_meta( $post_id, $select, sanitize_text_field( $_POST[$select] ) );
				}
			}
        }
		else
		{
            $this->save_authors( $_POST, $post_id );
            update_post_meta( $post_id, '_molongui_author_box_display', $_POST['_molongui_author_box_display'] );
            update_post_meta( $post_id, '_molongui_author_box_position', $_POST['_molongui_author_box_position'] );
		}
	}

} // class