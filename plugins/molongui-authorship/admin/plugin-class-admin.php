<?php

namespace Molongui\Authorship\Admin;

use Molongui\Fw\Includes\Notice;
use Molongui\Authorship\Includes\Author;
use Molongui\Authorship\Includes\AuthorPremium;
use Molongui\Authorship\Includes\User;
if ( !defined( 'ABSPATH' ) ) exit;
class Admin
{
	protected $plugin;
	protected $loader;
	private $classes;
	public function __construct( $plugin, $loader )
	{
		$this->plugin = $plugin;
		$this->loader = $loader;
		$this->load_dependencies();
		$this->define_hooks();
	}
	private function load_dependencies()
	{
		if ( !class_exists('Molongui\\'.$this->plugin->namespace.'\Includes\Author') ) require_once $this->plugin->dir . 'includes/molongui-class-author.php';
		$this->classes['author'] = new Author( $this->plugin );
		if ( !class_exists('Molongui\\'.$this->plugin->namespace.'\Includes\User') ) require_once $this->plugin->dir . 'includes/molongui-class-user.php';
		$this->classes['profile'] = new User();
		if ( $this->plugin->is_premium ) $this->load_premium_dependencies();
	}
	private function load_premium_dependencies()
	{
		if ( !class_exists('Molongui\\'.$this->plugin->namespace.'\Admin') ) require_once $this->plugin->dir . 'premium/admin/plugin-class-admin-premium.php';
		$this->classes['admin-premium'] = new AdminPremium( $this->plugin, $this->loader, $this->classes );
		if ( !class_exists('Molongui\\'.$this->plugin->namespace.'\Includes') ) require_once $this->plugin->dir . 'premium/includes/molongui-class-author-premium.php';
		$this->classes['author-premium'] = new AuthorPremium( $this->plugin, $this->loader );
	}
	private function define_hooks()
	{
		$this->loader->add_action( 'init', $this, 'init_plugin_settings' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_footer', $this, 'enqueue_common_scripts' );
		$authors_settings = get_option( MOLONGUI_AUTHORSHIP_AUTHORS_SETTINGS );
		$this->loader->add_filter( 'manage_users_columns', $this->classes['profile'], 'manage_users_columns' );
		$this->loader->add_action( 'manage_users_custom_column', $this->classes['profile'], 'fill_id_column', 10, 3 );
		$this->loader->add_action( 'user_new_form', $this->classes['profile'], 'add_authorship_fields' );       // Add new user screen
		$this->loader->add_action( 'edit_user_profile', $this->classes['profile'], 'add_authorship_fields' );   // Edit user screen
		$this->loader->add_action( 'show_user_profile', $this->classes['profile'], 'add_authorship_fields' );   // Profile screen
		$this->loader->add_filter( 'user_profile_picture_description', $this->classes['profile'], 'filter_user_profile_picture_description', 10, 2 );
		$this->loader->add_action( 'user_register', $this->classes['profile'], 'save_authorship_fields' );              // Fires immediately after a new user is registered.
		$this->loader->add_action( 'profile_update', $this->classes['profile'], 'save_authorship_fields' );             // Fires immediately after an existing user is updated.
		if ( $authors_settings['enable_guest_authors_feature'] )
		{
			$this->loader->add_action( 'init', $this->classes['author'], 'register_custom_post_type' );
			$this->loader->add_action( 'edit_form_after_title', $this->classes['author'], 'add_top_section_after_title' );
			$this->loader->add_action( 'edit_form_after_title', $this->classes['author'], 'add_bio_title_to_editor' );
			$this->loader->add_filter( 'post_updated_messages', $this->classes['author'], 'post_updated_messages' );
			$this->loader->add_action( 'admin_head', $this->classes['author'], 'remove_media_buttons' );
			$this->loader->add_action( 'admin_menu', $this->classes['author'], 'custom_remove_menu_pages' );
			$this->loader->add_filter( 'wp_insert_post_data', $this->classes['author'], 'filter_cpt_title', 99, 2 );
			$this->loader->add_filter( 'manage_molongui_guestauthor_posts_columns', $this->classes['author'], 'add_list_columns' );
			$this->loader->add_action( 'manage_molongui_guestauthor_posts_custom_column', $this->classes['author'], 'fill_list_columns', 5, 2 );
			$this->loader->add_action( 'admin_head', $this->classes['author'], 'quick_edit_add_guest_title_field' );
			$this->loader->add_action( 'quick_edit_custom_box', $this->classes['author'], 'quick_edit_add_custom_fields', 10, 2 );
			$this->loader->add_action( 'admin_footer', $this->classes['author'], 'quick_edit_populate_custom_fields' );
			$this->loader->add_action( 'save_post', $this->classes['author'], 'quick_edit_save_custom_fields', 10, 2 );

			if ( $this->plugin->is_premium )
            {
                if ( $this->plugin->settings['guest_archive_enabled'] ) $this->loader->add_filter( 'post_type_link', $this->classes['author'], 'edit_view_link', 10, 2 );
                else $this->loader->add_filter( 'post_row_actions', $this->classes['author'], 'remove_view_link', 10, 1 );
	            $this->classes['author-premium']->define_premium_hooks();
            }
            else
            {
	            $this->loader->add_filter( 'post_row_actions', $this->classes['author'], 'remove_view_link', 10, 1 );
	            $this->loader->add_filter( 'bulk_actions-'.'edit-'.$this->classes['author']->cpt_name, $this->classes['author'], 'remove_bulk_edit_action' );
            }
		}
		$this->loader->add_filter( 'manage_posts_columns', $this, 'customize_admin_columns' );
		$this->loader->add_action( 'manage_posts_custom_column', $this, 'populate_admin_columns', 10, 2 );
		$this->loader->add_filter( 'manage_pages_columns', $this, 'customize_admin_columns' );
		$this->loader->add_action( 'manage_pages_custom_column', $this, 'populate_admin_columns', 10, 2 );
		$this->loader->add_action( 'admin_head', $this, 'quick_edit_remove_author' );
		$this->loader->add_action( 'quick_edit_custom_box', $this, 'quick_edit_add_custom_fields', 10, 2 );
		$this->loader->add_action( 'admin_footer', $this, 'quick_edit_populate_custom_fields' );
		$this->loader->add_action( 'save_post', $this, 'quick_edit_save_custom_fields', 10, 2 );
		$this->loader->add_action( 'admin_menu', $this->classes['author'], 'remove_author_metabox' );
		$this->loader->add_action( 'add_meta_boxes', $this->classes['author'], 'add_meta_boxes' );
		$this->loader->add_action( 'save_post', $this->classes['author'], 'save' );
		if ( $this->plugin->is_premium ) $this->classes['admin-premium']->define_premium_hooks();
	}
    public function enqueue_styles()
    {
	    $screen = get_current_screen();
	    if ( in_array( $screen->id, array( 'profile', 'user', 'user-edit') ) )
	    {
		    $file = 'fw/admin/css/mcf-media-uploader.min.css';
		    if ( file_exists( $this->plugin->dir . $file ) ) wp_enqueue_style( 'mcf-media-uploader', $this->plugin->url . $file, array(), $this->plugin->version, 'all' );
	    }
	    if( !$this->plugin->is_premium )
        {
            $fpath = 'admin/css/molongui-authorship-admin.af91.min.css';
            if ( file_exists( $this->plugin->dir . $fpath ) )
                wp_enqueue_style( $this->plugin->dashed_name, $this->plugin->url . $fpath, array(), $this->plugin->version, 'all' );
        }
        else
        {
            $fpath = 'premium/admin/css/molongui-authorship-premium-admin.30ff.min.css';
            if ( file_exists( $this->plugin->dir . $fpath ) )
                wp_enqueue_style( $this->plugin->dashed_name, $this->plugin->url . $fpath, array(), $this->plugin->version, 'all' );
        }
    }
    public function enqueue_scripts( $hook )
    {
	    $screen = get_current_screen();
	    $post_types = molongui_supported_post_types( $this->plugin->id, 'all' );
	    $post_types = array_merge( $post_types, $this->plugin->config['cpt'] );
	    foreach ( $post_types as $post_type ) $post_types[] = 'edit-'.$post_type;
	    if ( current_user_can( 'edit_others_posts' ) or current_user_can( 'edit_others_pages' ) )
	    {
		    foreach ( $post_types as $post_type )
		    {
			    if ( $screen->id == $post_type )        // only for edit-screens.
			    {
				    molongui_enqueue_tiptip();
				    molongui_enqueue_selectr();
				    molongui_enqueue_sortable();
				    $fpath = 'admin/js/edit-post.651f.min.js';
				    if ( file_exists( $this->plugin->dir . $fpath ) )
				    {
					    $handle = $this->plugin->dashed_name.'-edit-post';
					    wp_enqueue_script( $handle, $this->plugin->url . $fpath, array( 'jquery' ), $this->plugin->version , true );
					    wp_localize_script( $handle, 'authorship', array
					    (
						    'remove_author_tip' => esc_html__( 'Remove author from selection', $this->plugin->textdomain ),
					    ));
				    }
			    }
		    }
	    }
	    if ( in_array( $screen->id, array( 'profile', 'user', 'user-edit') ) )
	    {
		    $fpath = 'admin/js/user.7228.min.js';
		    if ( file_exists( $this->plugin->dir . $fpath ) )
		    {
			    $handle = $this->plugin->dashed_name.'-user';
			    wp_enqueue_script( $handle, $this->plugin->url . $fpath, array( 'jquery' ), $this->plugin->version , true );
		    }
	    }
	    if ( $screen->id == 'molongui_page_molongui-authorship' )
	    {
		    $fpath = 'admin/js/settings.846a.min.js';
		    if ( file_exists( $this->plugin->dir . $fpath ) )
		    {
			    wp_enqueue_script( $this->plugin->dashed_name.'-settings', $this->plugin->url . $fpath, array( 'jquery' ), $this->plugin->version , true );
		    }
	    }
	    if ( !$this->plugin->is_premium )
        {
            $fpath = 'admin/js/admin.xxxx.min.js';
            if ( file_exists( $this->plugin->dir . $fpath ) )
                wp_enqueue_script( $this->plugin->dashed_name, $this->plugin->url . $fpath, array( 'jquery' ), $this->plugin->version , true );
        }
        else
        {
            $fpath = 'premium/admin/js/premium-admin.xxxx.min.js';
            if ( file_exists( $this->plugin->dir . $fpath ) )
                wp_enqueue_script( $this->plugin->dashed_name, $this->plugin->url . $fpath, array( 'jquery' ), $this->plugin->version, true );
        }
    }
	public function enqueue_common_scripts()
	{
		?>
        <script type="text/javascript">
			document.addEventListener("DOMContentLoaded", function()
			{
				var molongui_disabled_links = document.querySelectorAll('a[href="#molongui-disabled-link"]');
				Array.prototype.forEach.call(molongui_disabled_links, function(el, i)
				{
					el.classList.add('molongui-disabled-link');
					el.removeAttribute('href');
				});
			});
		</script>
		<?php
	}
    function init_plugin_settings()
    {
	    $tab_box      = (array) get_option( MOLONGUI_AUTHORSHIP_BOX_SETTINGS );
        $tab_byline   = (array) get_option( MOLONGUI_AUTHORSHIP_BYLINE_SETTINGS );
	    $tab_authors  = (array) get_option( MOLONGUI_AUTHORSHIP_AUTHORS_SETTINGS );
	    $tab_archives = (array) get_option( MOLONGUI_AUTHORSHIP_ARCHIVES_SETTINGS );
	    $tab_advanced = (array) get_option( MOLONGUI_AUTHORSHIP_ADVANCED_SETTINGS );
        $tab_strings  = (array) get_option( MOLONGUI_AUTHORSHIP_STRING_SETTINGS );
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
            'headline_text_size'       => '18',
            'headline_text_color'      => 'inherit',
            'headline_text_align'      => 'left',
            'headline_text_style'      => '',
            'headline_text_case'       => 'none',
	        'tabs_position'            => 'full',
	        'tabs_background'          => '#000000',
	        'tabs_color'               => '#f4f4f4',
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
	    $default_guest_settings = array
	    (
		    'enable_guest_authors_feature' => true,
		    'enable_search_by_author'      => false,
		    'include_guests_in_search'     => false,
		    'guest_menu_item_level'        => 'top',
	    );
	    $default_archives_settings = array
	    (
		    'guest_archive_enabled'       => ( $this->plugin->is_premium ? '1' : '0' ),
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
	    $default_string_settings = array
	    (
		    'headline'         => __( 'About the author', $this->plugin->textdomain ),
		    'at'               => __( 'at', $this->plugin->textdomain ),
		    'web'              => __( 'Website', $this->plugin->textdomain ),
		    'more_posts'       => __( '+ posts', $this->plugin->textdomain ),
		    'bio'              => __( 'Bio', $this->plugin->textdomain ),
		    'about_the_author' => __( 'About the author', $this->plugin->textdomain ),
		    'related_posts'    => __( 'Related posts', $this->plugin->textdomain ),
		    'profile_title'    => __( 'Author profile', $this->plugin->textdomain ),
		    'related_title'    => __( 'Related entries', $this->plugin->textdomain ),
		    'no_related_posts' => __( 'This author does not have any more posts.', $this->plugin->textdomain ),
	    );
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
	    $update = array_merge( $default_box_settings, $tab_box );
	    update_option( MOLONGUI_AUTHORSHIP_BOX_SETTINGS, $update );

        $update = array_merge( $default_byline_settings, $tab_byline );
        update_option( MOLONGUI_AUTHORSHIP_BYLINE_SETTINGS, $update );

	    $update = array_merge( $default_guest_settings, $tab_authors );
	    update_option( MOLONGUI_AUTHORSHIP_AUTHORS_SETTINGS, $update );

	    $update = array_merge( $default_archives_settings, $tab_archives );
	    update_option( MOLONGUI_AUTHORSHIP_ARCHIVES_SETTINGS, $update );

        $update = array_merge( $default_advanced_settings, $tab_advanced );
        update_option( MOLONGUI_AUTHORSHIP_ADVANCED_SETTINGS, $update );

	    $update = array_merge( $default_string_settings, $tab_strings );
	    update_option( MOLONGUI_AUTHORSHIP_STRING_SETTINGS, $update );
    }
	function validate_box_tab( $input )
	{
		$box_settings = (array) get_option( MOLONGUI_AUTHORSHIP_BOX_SETTINGS );
		$input['plugin_version'] = $this->plugin->version;
		if ( !isset( $input['related_post_type_post'] ) ) $input['related_post_type_post'] = '0';
		if ( !isset( $input['related_post_type_page'] ) ) $input['related_post_type_page'] = '0';
		$social = include $this->plugin->dir . 'config/social.php';
		foreach ( $social as $id => $network )
		{
			if ( !isset( $input['show_'.$id] ) ) $input['show_'.$id] = '0';
		}
		if( !$this->plugin->is_premium )
		{
			$input['related_order_by']       = 'date';
			$input['related_order']          = 'asc';
			$input['related_post_type_post'] = '1';
			$input['related_post_type_page'] = '1';
			$customizer_premium_refresh_settings = array
			(
				'profile_layout' => array
				(
					'accepted' => array( 'layout-1' ),
					'default'  => 'layout-1',
				),
				'related_layout' => array
				(
					'accepted' => array( 'layout-1', 'layout-2' ),
					'default'  => 'layout-1',
				),
				'avatar_default_img' => array
				(
					'accepted' => array( 'none', 'blank', 'mm' ),
					'default'  => 'mm',
				),
			);
			foreach ( $customizer_premium_refresh_settings as $setting => $params )
			{
				if ( !in_array( $input[$setting], $params['accepted'] ) )
				{
					if ( isset( $box_settings[$setting] ) and !empty( $box_settings[$setting] ) and in_array( $box_settings[$setting], $params['accepted'] ) ) $input[$setting] = $box_settings[$setting];
					else $input[$setting] = $params['default'];
				}
			}
		}
		$customizer_settings = array
		(
			'layout',
			'position',
			'order',
			'show_headline',
			'box_margin',
			'box_width',
			'box_border',
			'box_border_style',
			'box_border_width',
			'box_border_color',
			'box_background',
			'box_shadow',
			'headline_text_size',
			'headline_text_style',
			'headline_text_case',
			'headline_text_align',
			'headline_text_color',
			'tabs_position',
			'tabs_background',
			'tabs_color',
			'tabs_active_color',
			'tabs_border',
			'tabs_border_style',
			'tabs_border_width',
			'tabs_border_color',
			'tabs_text_color',
			'profile_layout',
			'profile_valign',
			'bottom_background_color',
			'bottom_border_style',
			'bottom_border_width',
			'bottom_border_color',
			'show_avatar',
			'avatar_style',
			'avatar_border_style',
			'avatar_border_width',
			'avatar_border_color',
			'avatar_link_to_archive',
			'avatar_default_img',
			'acronym_text_color',
			'acronym_bg_color',
			'name_link_to_archive',
			'name_text_size',
			'name_text_style',
			'name_text_case',
			'name_text_align',
			'name_inherited_underline',
			'name_text_color',
			'meta_text_size',
			'meta_text_style',
			'meta_text_case',
			'meta_text_align',
			'meta_text_color',
			'meta_separator',
			'bio_text_size',
			'bio_line_height',
			'bio_text_style',
			'bio_text_align',
			'bio_text_color',
			'show_icons',
			'icons_style',
			'icons_size',
			'icons_color',
			'related_layout',
			'related_text_size',
			'related_text_style',
			'related_text_color',
		);
		foreach ( $customizer_settings as $customizer_setting )
		{
			if ( !isset( $input[$customizer_setting] ) ) $input[$customizer_setting] = $box_settings[$customizer_setting];
		}
		$customizer_strings = array
		(
			'headline'         => __( 'About the author', $this->plugin->textdomain ),
			'about_the_author' => __( 'About the author', $this->plugin->textdomain ),
			'related_posts'    => __( 'Related posts', $this->plugin->textdomain ),
			'profile_title'    => __( 'Author profile', $this->plugin->textdomain ),
			'at'               => __( 'at', $this->plugin->textdomain ),
			'web'              => __( 'Web', $this->plugin->textdomain ),
			'more_posts'       => __( '+ posts', $this->plugin->textdomain ),
			'bio'              => __( 'Bio', $this->plugin->textdomain ),
			'related_title'    => __( 'Related posts', $this->plugin->textdomain ),
			'no_related_posts' => __( 'This author does not have any more posts.', $this->plugin->textdomain ),
		);
		foreach ( $customizer_strings as $customizer_string => $default )
		{
			if ( !isset( $input[$customizer_string] ) or empty( $input[$customizer_string] ) ) $input[$customizer_string] = $default;
		}
		return $input;
	}
    function validate_byline_tab( $input )
    {
        $input['plugin_version'] = $this->plugin->version;
        if ( !$this->plugin->is_premium )
        {
        }
        return $input;
    }
   function validate_authors_tab( $input )
    {
        $input['plugin_version'] = $this->plugin->version;
	    if ( !$this->plugin->is_premium )
	    {
		    $input['enable_search_by_author']  = false;
		    $input['include_guests_in_search'] = false;
		    $input['guest_menu_item_level']    = 'top';
	    }

        return $input;
    }
   function validate_archives_tab( $input )
    {
        $input['plugin_version'] = $this->plugin->version;
	    if( !$this->plugin->is_premium )
	    {
		    $input['guest_archive_enabled']       = '0';
		    $input['guest_archive_include_pages'] = '0';
		    $input['guest_archive_include_cpts']  = '0';
		    $input['guest_archive_tmpl']          = '';
		    $input['guest_archive_permalink']     = '';
		    $input['guest_archive_base']          = 'author';
		    $input['user_archive_enabled']        = '1';
		    $input['user_archive_include_pages']  = '0';
		    $input['user_archive_include_cpts']   = '0';
		    $input['user_archive_tmpl']           = '';
		    $input['user_archive_permalink']      = '';
		    $input['user_archive_base']           = 'author';
	    }
	    if ( !isset( $input['guest_archive_base'] ) ) $input['guest_archive_base'] = 'author';

        return $input;
    }
	public function customize_admin_columns( $columns )
	{
		$new_columns = array();
		global $post, $post_type;
		$pt = ( isset( $post->post_type ) ? $post->post_type : '' );
        if ( empty( $post->post_type ) and $post_type == 'page' ) $pt = 'page';
		if ( empty( $pt ) or $pt == $this->classes['author']->cpt_name or !in_array( $pt, molongui_supported_post_types( $this->plugin->id, 'all' ) ) ) return $columns;
		if ( array_key_exists( 'author', $columns ) ) $position = array_search( 'author', array_keys( $columns ) );      // Default 'Author' column position.
        elseif ( array_key_exists( 'title', $columns ) ) $position = array_search( 'title', array_keys( $columns ) )+1;  // After 'Title' column.
        else $position = count( $columns );                                                                                                      // Last column.
		unset( $columns['author'] );

        $i = 0;
        foreach ( $columns as $key => $column )
        {
            if ( $i == $position )
            {
                $new_columns['molongui-author'] = __( 'Authors', $this->plugin->textdomain );
	            $new_columns['molongui-box'] = __( 'Author Box', $this->plugin->textdomain );
            }
	        ++$i;
            $new_columns[$key] = $column;
        }
		return $new_columns;
	}
	public function populate_admin_columns( $column, $ID )
	{
		if ( $column == 'molongui-author' )
		{
			$authors = $this->classes['author']->get_authors($ID );
			if ( !$authors ) return;
			foreach ( $authors as $author )
			{
				if ( $author->type == 'guest' )
				{
                    $display_name = esc_html( get_the_title( $author->id ) );
					$edit_link    = admin_url().'post.php?post='.$author->id.'&action=edit';
					$author_tag   = __( 'guest', $this->plugin->textdomain );
				}
				else
				{
					$user = get_userdata( $author->id );
					$display_name = esc_html( $user->display_name );
					$edit_link    = admin_url().'user-edit.php?user_id='.$author->id;
					$author_tag   = __( 'user', $this->plugin->textdomain );
				}

				?>
                <p data-author-id="<?php echo $author->id; ?>" data-author-type="<?php echo $author->type; ?>" data-author-display-name="<?php echo $display_name; ?>" class="" style="margin:0 0 2px;">
                    <a href="<?php echo $edit_link; ?>">
						<?php echo $display_name; ?>
                    </a>
                    <span style="font-family: 'Courier New', Courier, monospace; font-size: 81%; color: #a2a2a2;" >
                        [<?php echo $author_tag; ?>]
                    </span>
                </p>
				<?php
			}

			return;
		}
		elseif ( $column == 'molongui-box' )
        {
	        $value = get_post_meta( $ID, '_molongui_author_box_display', true );
	        $icon  = ( empty( $value ) or $value == 'default' ) ? $this->plugin->settings['display'] : $value;
	        echo '<div id="box_display_'.$ID.'" data-display-box="'.$value.'">'.'<i data-tip="'.( $icon == 'show' ? __( 'Show', $this->plugin->textdomain ) : __( 'Hide', $this->plugin->textdomain ) ).'" class="m-a-icon-'.$icon.' molongui-tip"></i>'.'</div>';
	        return;
        }
	}
    public function quick_edit_remove_author()
    {
        global $pagenow, $post_type;

        if ( 'edit.php' == $pagenow and molongui_is_post_type_enabled( $this->plugin->id, $post_type ) )
        {
            remove_post_type_support( $post_type, 'author' );
        }
    }
	public function	quick_edit_add_custom_fields( $column_name, $post_type )
	{
		if ( !molongui_is_post_type_enabled( $this->plugin->id, $post_type ) ) return;
        if ( $column_name == 'molongui-author' )
        {
            wp_nonce_field( 'molongui_authorship_quick_edit_nonce', 'molongui_authorship_quick_edit_nonce' );

            ?>
            <br class="clear" />
            <fieldset class="inline-edit-col-left">
                <div class="inline-edit-col">
                    <h4><?php _e( 'Authorship data', $this->plugin->textdomain ); ?></h4>
                    <div class="inline-edit-group wp-clearfix">
                        <label class="inline-edit-authors alignleft" style="width: 100%;">
                            <span class="title"><?php _e( 'Authors', $this->plugin->textdomain ); ?></span>
                            <div id="molongui-author-selectr" style="margin-left: 6em;">
                                <?php echo $this->classes['author']->get_all( 'authors', false, array(), array(), array(), array(), 'asc', 'name', 'dropdown' ); ?>
                            </div>
                        </label>
                    </div>
                </div>
            </fieldset>
            <?php
        }
        elseif ( $column_name == 'molongui-box' )
        {
            wp_nonce_field( 'molongui_authorship_quick_edit_nonce', 'molongui_authorship_quick_edit_nonce' );

            ?>
            <br class="clear" />
            <fieldset class="inline-edit-col-left">
                <div class="inline-edit-col">
                    <div class="inline-edit-group wp-clearfix">
                        <label class="inline-edit-box-display alignleft">
                            <span class="title"><?php _e( 'Author box', $this->plugin->textdomain ); ?></span>
                            <select name="_molongui_author_box_display">
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
	}
	public function quick_edit_populate_custom_fields()
	{
		$current_screen = get_current_screen();
		if ( substr( $current_screen->id, 0, strlen( 'edit-' ) ) != 'edit-' or !molongui_is_post_type_enabled( $this->plugin->id, $current_screen->post_type ) ) return;
		wp_enqueue_script( 'jquery' );
		?>
        <script type="text/javascript">
			jQuery(function($)
			{
				var $inline_editor = inlineEditPost.edit;
				inlineEditPost.edit = function(id)
				{
					$inline_editor.apply(this, arguments);
					var post_id = 0;
					if (typeof(id) === 'object') post_id = parseInt(this.getId(id));
					if (post_id !== 0)
					{
						var $q_editor = $('#edit-' + post_id);
						var $post_row = $('#post-' + post_id);
						var authorSelect = document.getElementById('_molongui_author');
						var authorList = $q_editor.find('ul#molongui_authors');
						var container = document.getElementById('molongui-author-selectr');
						container.removeChild(container.firstElementChild);
						container.prepend(authorSelect);
						$.molonguiInitAuthorSelector(authorSelect, 'Select an(other) author...', authorList);
						authorList.empty();
						$post_row.find('.molongui-author p').each(function (index, item)
						{
							var $ref = $(item).data('author-type') + '-' + $(item).data('author-id');
							var $li  = '<li data-value="' + $ref + '">' + $(item).data('author-display-name') + '<input type="hidden" name="molongui_authors[]" value="' + $ref + '" /><span class="dashicons dashicons-trash molongui-tip js-remove" data-tip="' + authorship.remove_author_tip + '"></span></li>';
							authorList.append($li);
						});
						var $box_display = $('#box_display_' + post_id).data('display-box');
						if ($box_display === '') $box_display = 'default';
						$q_editor.find('[name="_molongui_author_box_display"]').val($box_display);
						$q_editor.find('[name="_molongui_author_box_display"]').children('[value="' + $box_display + '"]').attr('selected', true);
					}
				};
			});
        </script>
		<?php
	}
	public function quick_edit_save_custom_fields( $post_id, $post )
	{
		if ( !isset( $_POST['molongui_authorship_quick_edit_nonce'] ) or !wp_verify_nonce( $_POST['molongui_authorship_quick_edit_nonce'], 'molongui_authorship_quick_edit_nonce' ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) return;
		if ( !in_array( $post->post_type, molongui_supported_post_types( $this->plugin->id, 'all' ) ) ) return;
		if ( !current_user_can( 'edit_post', $post_id ) ) return;
		$this->classes['author']->save_authors( $_POST, $post_id, __CLASS__, __FUNCTION__ );
		if ( isset( $_POST['_molongui_author_box_display'] ) ) update_post_meta( $post_id, '_molongui_author_box_display', $_POST['_molongui_author_box_display'] );
	}
	static function get_customizer_link()
	{
		$customizer_panel = strtolower( str_replace( ' ', '-', MOLONGUI_AUTHORSHIP_NAME ) );
		$latest_post_url  = wp_get_recent_posts( array( 'numberposts' => 1, 'meta_key' => '_molongui_author_box_display', 'meta_value' =>'show', ) );
		if ( !$latest_post_url or empty( $latest_post_url ) ) return admin_url( 'customize.php?autofocus[panel]='.$customizer_panel );
		return admin_url( 'customize.php?autofocus[panel]='.$customizer_panel.'&url='.get_permalink( $latest_post_url[0]['ID'] ) );
	}
	static function display_guest_archives_section()
	{
		$authors_settings = (array) get_option( MOLONGUI_AUTHORSHIP_AUTHORS_SETTINGS );
		return ( ( isset( $authors_settings['enable_guest_authors_feature'] ) and $authors_settings['enable_guest_authors_feature'] ) ? true : false );
	}
    static function get_social_networks( $index = 'id' )
    {
        $list = array();
	    $social_networks = include( MOLONGUI_AUTHORSHIP_DIR . 'config/social.php' );
        if ( !empty( $social_networks ) )
        {
	        if ( $index == 'int' )
            {
                foreach ( $social_networks as $id => $social_network ) $list[] = array( 'id' => $id, 'label' => $social_network['name'], 'icon' => 'm-a-icon-'.$id, 'color' => $social_network['color'] );
                $list = molongui_sort_array( $list, 'asc', 'label' );
            }
	        else
            {
                foreach ( $social_networks as $id => $social_network ) $list[$id] = array( 'id' => $id, 'label' => $social_network['name'], 'icon' => 'm-a-icon-'.$id, 'color' => $social_network['color'] );
                $list = molongui_sort_array( $list );
            }
        }
        return $list;
    }

}