<?php

namespace Molongui\Authorship\Includes;
if ( !defined( 'ABSPATH' ) ) exit;
class Activator
{
    public static function activate( $network_wide )
    {
	    if ( function_exists('is_multisite') and is_multisite() and $network_wide )
	    {
		    if ( false == is_super_admin() ) return;
		    foreach ( molongui_get_sites() as $site_id )
		    {
			    switch_to_blog( $site_id );
			    self::activate_single_blog();
			    restore_current_blog();
		    }
        }
        else
        {
	        if ( false == current_user_can( 'activate_plugins' ) ) return;

	        self::activate_single_blog();
        }
	    set_transient( strtolower( str_replace( ' ', '-', MOLONGUI_AUTHORSHIP_ID ) ).'-activated', 1 );
    }
	private static function activate_single_blog()
	{
		flush_rewrite_rules();
		if ( !class_exists( 'Molongui\Fw\Includes\DB_Update' ) ) require_once( MOLONGUI_AUTHORSHIP_FW_DIR . 'includes/fw-class-db-update.php' );
		$update_db = new \Molongui\Fw\Includes\DB_Update( MOLONGUI_AUTHORSHIP_ID, MOLONGUI_AUTHORSHIP_DB_VERSION );
		if ( $update_db->db_update_needed() ) $update_db->run_update();
		self::save_installation_data();
		self::add_default_options();
		if ( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) )
		{
			if ( !class_exists( 'Molongui\Fw\Includes\License' ) ) require_once( MOLONGUI_AUTHORSHIP_DIR . 'fw/premium/update/includes/fw-class-license.php' );
			$license = new \Molongui\Fw\Includes\License( MOLONGUI_AUTHORSHIP_ID );
			$license->init();
			self::add_contributors_page();
		}
	}
	public static function activate_on_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta )
	{
		if ( is_plugin_active_for_network( MOLONGUI_AUTHORSHIP_BASE_NAME ) )
		{
			switch_to_blog( $blog_id );
			self::activate_single_blog();
			restore_current_blog();
		}
	}
	public static function save_installation_data()
	{
		if ( get_option( MOLONGUI_AUTHORSHIP_INSTALLATION ) ) return;
		$installation = array
		(
			'installation_date'    => time(),
			'installation_version' => MOLONGUI_AUTHORSHIP_VERSION,
		);
		add_option( MOLONGUI_AUTHORSHIP_INSTALLATION, $installation );
	}
    public static function add_default_options()
    {
        $default_byline_settings = array
        (
	        'byline_automatic_integration'      => '1',
	        'byline_multiauthor_display'        => 'all',
	        'byline_multiauthor_separator'      => '',
	        'byline_multiauthor_last_separator' => '',
	        'byline_multiauthor_link'           => 'magic',
	        'byline_modifier_before'            => '',
	        'byline_modifier_after'             => '',
        );
        if ( !get_option( MOLONGUI_AUTHORSHIP_BYLINE_SETTINGS ) )
        {
            add_option( MOLONGUI_AUTHORSHIP_BYLINE_SETTINGS, $default_byline_settings );
        }
        else
        {
            $config = (array)get_option( MOLONGUI_AUTHORSHIP_BYLINE_SETTINGS );
            $update = array_merge( $default_byline_settings, $config );
            update_option( MOLONGUI_AUTHORSHIP_BYLINE_SETTINGS, $update );
        }
        $default_box_settings = array
        (
            'display'                => 'posts',
            'hide_if_no_bio'         => 'no',
	        'multiauthor_box_layout' => 'default',
	        'show_related'           => '0',
	        'related_order_by'       => 'date',
	        'related_order'          => 'asc',
	        'related_items'          => '4',
	        'related_post_type_post' => '1',
	        'related_post_type_page' => '1',
	        'show_facebook'          => '1',
	        'show_twitter'           => '1',
	        'show_linkedin'          => '1',
	        'show_googleplus'        => '0',
	        'show_youtube'           => '1',
	        'show_pinterest'         => '1',
	        'show_tumblr'            => '1',
	        'show_instagram'         => '1',
	        'show_slideshare'        => '1',
	        'show_xing'              => '0',
	        'show_renren'            => '0',
	        'show_vk'                => '0',
	        'show_flickr'            => '0',
	        'show_vine'              => '0',
	        'show_meetup'            => '0',
	        'show_weibo'             => '0',
	        'show_deviantart'        => '0',
	        'show_stumbleupon'       => '0',
	        'show_myspace'           => '0',
	        'show_yelp'              => '0',
	        'show_mixi'              => '0',
	        'show_soundcloud'        => '0',
	        'show_lastfm'            => '0',
	        'show_foursquare'        => '0',
	        'show_spotify'           => '0',
	        'show_vimeo'             => '0',
	        'show_dailymotion'       => '0',
	        'show_reddit'            => '0',
	        'show_skype'             => '0',
	        'show_livejournal'       => '0',
	        'show_taringa'           => '0',
	        'show_odnoklassniki'     => '0',
	        'show_askfm'             => '0',
	        'show_bebee'             => '0',
	        'show_goodreads'         => '0',
	        'show_periscope'         => '0',
	        'show_telegram'          => '0',
	        'show_livestream'        => '0',
	        'show_styleshare'        => '0',
	        'show_reverbnation'      => '0',
	        'show_everplaces'        => '0',
	        'show_eventbrite'        => '0',
	        'show_draugiemlv'        => '0',
	        'show_blogger'           => '0',
	        'show_patreon'           => '0',
	        'show_plurk'             => '0',
	        'show_buzzfeed'          => '0',
	        'show_slides'            => '0',
	        'show_deezer'            => '0',
	        'show_spreaker'          => '0',
	        'show_runkeeper'         => '0',
	        'show_medium'            => '0',
	        'show_speakerdeck'       => '0',
	        'show_teespring'         => '0',
	        'show_kaggle'            => '0',
	        'show_houzz'             => '0',
	        'show_gumtree'           => '0',
	        'show_upwork'            => '0',
	        'show_superuser'         => '0',
	        'show_bandcamp'          => '0',
	        'show_glassdoor'         => '0',
	        'show_toptal'            => '0',
	        'show_ifixit'            => '0',
	        'show_stitcher'          => '0',
	        'show_storify'           => '0',
	        'show_readthedocs'       => '0',
	        'show_ello'              => '0',
	        'show_tinder'            => '0',
	        'show_github'            => '0',
	        'show_stackoverflow'     => '0',
	        'show_jsfiddle'          => '0',
	        'show_twitch'            => '0',
	        'show_whatsapp'          => '0',
	        'show_tripadvisor'       => '0',
	        'show_wikipedia'         => '0',
	        'show_500px'             => '0',
	        'show_mixcloud'          => '0',
	        'show_viadeo'            => '0',
	        'show_quora'             => '0',
	        'show_etsy'              => '0',
	        'show_codepen'           => '0',
	        'show_coderwall'         => '0',
	        'show_behance'           => '0',
	        'show_coursera'          => '0',
	        'show_googleplay'        => '0',
	        'show_itunes'            => '0',
	        'show_angellist'         => '0',
	        'show_amazon'            => '0',
	        'show_ebay'              => '0',
	        'show_paypal'            => '0',
	        'show_digg'              => '0',
	        'show_dribbble'          => '0',
	        'show_dropbox'           => '0',
	        'show_scribd'            => '0',
	        'show_line'              => '0',
	        'show_lineat'            => '0',
	        'show_researchgate'      => '0',
	        'show_academia'          => '0',
	        'show_untappd'           => '0',
	        'show_bookbub'           => '0',
            'show_rss'               => '0',
            'show_designernews'      => '0',
            'show_applepodcasts'     => '0',
            'show_overcast'          => '0',
            'show_breaker'           => '0',
            'show_castbox'           => '0',
            'show_radiopublic'       => '0',
            'show_tunein'            => '0',
            'show_scoutfm'           => '0',
	        'layout'                   => 'slim',
	        'position'                 => 'below',
	        'order'                    => 11,
	        'box_width'                => '100',
	        'box_margin'               => '20',
	        'box_shadow'               => 'right',
	        'box_border'               => 'all',
	        'box_border_style'         => 'solid',
	        'box_border_width'         => '2',
	        'box_border_color'         => '#a5a5a5',
	        'box_background'           => '#e6e6e6',
            'show_headline'            => '0',
            'headline_text_size'       => '',
            'headline_text_color'      => 'inherit',
            'headline_text_align'      => 'left',
            'headline_text_style'      => '',
	        'headline_text_case'       => 'none',
	        'tabs_position'            => 'full',
	        'tabs_background'          => '#000000',
	        'tabs_color'               => '#e6e6e6',
	        'tabs_active_color'        => '#e6e6e6',
	        'tabs_border'              => 'top',
	        'tabs_border_style'        => 'solid',
	        'tabs_border_width'        => '4',
	        'tabs_border_color'        => 'orange',
	        'tabs_text_color'          => 'inherit',
	        'profile_layout'           => 'layout-1',
	        'profile_valign'           => 'center',
	        'bottom_background_color'  => 'inherit',
	        'bottom_border_style'      => 'solid',
	        'bottom_border_width'      => '1',
	        'bottom_border_color'      => '#B6B6B6',
	        'show_avatar'              => '1',
            'avatar_style'             => 'none',
            'avatar_border_style'      => 'solid',
            'avatar_border_width'      => '1',
            'avatar_border_color'      => 'inherit',
	        'avatar_link_to_archive'   => '1',
            'avatar_default_img'       => 'mm',
            'acronym_text_color'       => '#dd9933',
            'acronym_bg_color'         => '#000000',
	        'name_link_to_archive'     => '1',
            'name_text_size'           => '16',
	        'name_text_style'          => '',
	        'name_text_case'           => 'none',
            'name_text_color'          => 'inherit',
	        'name_text_align'          => 'left',
            'name_inherited_underline' => 'keep',
            'meta_text_size'           => '11',
	        'meta_text_style'          => '',
	        'meta_text_case'           => 'none',
            'meta_text_color'          => 'inherit',
	        'meta_text_align'          => 'left',
	        'meta_separator'           => '|',
            'bio_text_size'            => '14',
            'bio_line_height'          => '1',
            'bio_text_color'           => 'inherit',
            'bio_text_align'           => 'justify',
            'bio_text_style'           => '',
            'show_icons'               => '1',
            'icons_size'               => '20',
            'icons_color'              => '#999999',
            'icons_style'              => 'default',
	        'related_layout'           => 'layout-1',
	        'related_text_size'        => '14',
	        'related_text_style'       => '',
	        'related_text_color'       => 'inherit',
        );
        if ( !get_option( MOLONGUI_AUTHORSHIP_BOX_SETTINGS ) )
        {
            add_option( MOLONGUI_AUTHORSHIP_BOX_SETTINGS, $default_box_settings );
        }
        else
        {
            $config = (array)get_option( MOLONGUI_AUTHORSHIP_BOX_SETTINGS );
            $update = array_merge( $default_box_settings, $config );
            update_option( MOLONGUI_AUTHORSHIP_BOX_SETTINGS, $update );
        }
	    $default_authors_settings = array
	    (
		    'enable_guest_authors_feature' => true,
		    'enable_search_by_author'      => false,
		    'include_guests_in_search'     => false,
		    'guest_menu_item_level'        => 'top',
	    );
	    if ( !get_option( MOLONGUI_AUTHORSHIP_AUTHORS_SETTINGS ) )
	    {
		    add_option( MOLONGUI_AUTHORSHIP_AUTHORS_SETTINGS, $default_authors_settings );
	    }
	    else
	    {
		    $config = (array)get_option( MOLONGUI_AUTHORSHIP_AUTHORS_SETTINGS );
		    $update = array_merge( $default_authors_settings, $config );
		    update_option( MOLONGUI_AUTHORSHIP_AUTHORS_SETTINGS, $update );
	    }
	    $default_archives_settings = array
	    (
		    'guest_archive_enabled'       => ( molongui_is_premium( MOLONGUI_AUTHORSHIP_DIR ) ? '1' : '0' ),
		    'guest_archive_include_pages' => '0',
		    'guest_archive_include_cpts'  => '0',
		    'guest_archive_tmpl'          => '',
		    'guest_archive_permalink'     => '',
		    'guest_archive_base'          => 'author',
		    'user_archive_enabled'        => '1',
		    'user_archive_include_pages'  => '0',
		    'user_archive_include_cpts'   => '0',
		    'user_archive_tmpl'           => '',
		    'user_archive_base'           => 'author',
	    );
	    if ( !get_option( MOLONGUI_AUTHORSHIP_ARCHIVES_SETTINGS ) )
	    {
		    add_option( MOLONGUI_AUTHORSHIP_ARCHIVES_SETTINGS, $default_archives_settings );
	    }
	    else
	    {
		    $config = (array)get_option( MOLONGUI_AUTHORSHIP_ARCHIVES_SETTINGS );
		    $update = array_merge( $default_archives_settings, $config );
		    update_option( MOLONGUI_AUTHORSHIP_ARCHIVES_SETTINGS, $update );
	    }
	    $default_advanced_settings = array
	    (
		    'extend_to_post'         => '1',
		    'extend_to_page'         => '1',
		    'encode_email'           => '0',
		    'encode_phone'           => '0',
		    'enable_sc_text_widgets' => '0',
		    'keep_config'            => '1',
		    'keep_data'              => '1',
		    'hide_elements'          => '',
		    'add_opengraph_meta'     => '1',
		    'add_google_meta'        => '1',
		    'add_facebook_meta'      => '1',
		    'add_nofollow'           => '0',
		    'box_headline_tag'       => 'h3',
		    'box_author_name_tag'    => 'h5',
	    );
	    if ( !get_option( MOLONGUI_AUTHORSHIP_ADVANCED_SETTINGS ) )
	    {
		    add_option( MOLONGUI_AUTHORSHIP_ADVANCED_SETTINGS, $default_advanced_settings );
	    }
	    else
	    {
		    $config = (array)get_option( MOLONGUI_AUTHORSHIP_ADVANCED_SETTINGS );
		    $update = array_merge( $default_advanced_settings, $config );
		    update_option( MOLONGUI_AUTHORSHIP_ADVANCED_SETTINGS, $update );
	    }
	    $default_string_settings = array
	    (
		    'headline'         => 'About the author',
		    'at'               => 'at',
		    'web'              => 'Website',
		    'more_posts'       => '+ posts',
		    'bio'              => 'Bio',
		    'about_the_author' => 'About the author',
		    'related_posts'    => 'Related posts',
		    'profile_title'    => 'Author profile',
		    'related_title'    => 'Related entries',
		    'no_related_posts' => 'This author does not have any more posts.',
	    );
	    if ( !get_option( MOLONGUI_AUTHORSHIP_STRING_SETTINGS ) )
	    {
		    add_option( MOLONGUI_AUTHORSHIP_STRING_SETTINGS, $default_string_settings );
	    }
	    else
	    {
		    $config = (array)get_option( MOLONGUI_AUTHORSHIP_STRING_SETTINGS );
		    $update = array_merge( $default_string_settings, $config );
		    update_option( MOLONGUI_AUTHORSHIP_STRING_SETTINGS, $update );
	    }
    }
	public static function add_contributors_page()
	{
		if ( get_option( MOLONGUI_AUTHORSHIP_CONTRIBUTORS_PAGE ) ) return;
		$contributors = array
		(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			'post_author'    => get_current_user_id(),
			'meta_input'     => array
			(
				'_molongui_author_box_display' => 'hide',
			),
			'post_title'     => __( 'Contributors', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ),
			'post_content'   => '<p>'.__( 'Many people have contributed to this website and we are thankful to them all for their hard work.', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ).'</p> [molongui_author_list output=list layout=basic with_posts=yes]',
		);
		$contributors_id = wp_insert_post( $contributors, true );
		if ( !is_wp_error( $contributors_id ) )
		{
			add_option( MOLONGUI_AUTHORSHIP_CONTRIBUTORS_PAGE, $contributors_id );
		}
	}

}