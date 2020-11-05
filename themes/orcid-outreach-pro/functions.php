<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'outreach', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'outreach' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Outreach Pro Theme', 'outreach' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/outreach/' );
define( 'CHILD_THEME_VERSION', '3.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'outreach_load_scripts' );
function outreach_load_scripts() {

	wp_enqueue_script( 'outreach-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	
	wp_enqueue_style( 'dashicons' );
	
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Noto+Sans:400,400i,700,700i', array(), CHILD_THEME_VERSION );

}

//* Add new image sizes
add_image_size( 'home-top', 1140, 460, TRUE );
add_image_size( 'home-bottom', 285, 160, TRUE );
add_image_size( 'sidebar', 300, 150, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 40,
	'width'           => 340,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for additional color style options
// add_theme_support( 'genesis-style-selector', array(
// 	'outreach-pro-blue' 	=>	__( 'Outreach Pro Blue', 'outreach' ),
// 	'outreach-pro-orange' 	=> 	__( 'Outreach Pro Orange', 'outreach' ),
// 	'outreach-pro-purple' 	=> 	__( 'Outreach Pro Purple', 'outreach' ),
// 	'outreach-pro-red' 		=> 	__( 'Outreach Pro Red', 'outreach' ),
// ) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'outreach_author_box_gravatar_size' );
function outreach_author_box_gravatar_size( $size ) {

    return '80';
    
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'outreach_remove_comment_form_allowed_tags' );
function outreach_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add the sub footer section
add_action( 'genesis_before_footer', 'outreach_sub_footer', 5 );
function outreach_sub_footer() {

	if ( is_active_sidebar( 'sub-footer-left' ) || is_active_sidebar( 'sub-footer-right' ) ) {
		echo '<div class="sub-footer"><div class="wrap">';
		
		   genesis_widget_area( 'sub-footer-left', array(
		       'before' => '<div class="sub-footer-left">',
		       'after'  => '</div>',
		   ) );
	
		   genesis_widget_area( 'sub-footer-right', array(
		       'before' => '<div class="sub-footer-right">',
		       'after'  => '</div>',
		   ) );
	
		echo '</div><!-- end .wrap --></div><!-- end .sub-footer -->';	
	}
	
}

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'outreach' ),
	'description' => __( 'This is the top section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'outreach' ),
	'description' => __( 'This is the bottom section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-left',
	'name'        => __( 'Sub Footer - Left', 'outreach' ),
	'description' => __( 'This is the left section of the sub footer.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-right',
	'name'        => __( 'Sub Footer - Right', 'outreach' ),
	'description' => __( 'This is the right section of the sub footer.', 'outreach' ),
) );

//Allow Contributors to Add Media
if ( current_user_can('contributor') && !current_user_can('upload_files') )
add_action('admin_init', 'allow_contributor_uploads');

function allow_contributor_uploads() {
$contributor = get_role('contributor');
$contributor->add_cap('upload_files');
}

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION

//Enqueue Glyphicons
function wpb_load_glyph() {
 
	wp_enqueue_style( 'wpb-glyph', get_stylesheet_directory_uri() . '/fonts/social.css' );
	 
	}
	 
	add_action( 'wp_enqueue_scripts', 'wpb_load_glyph' );

//



//* Remove the author box on single posts HTML5 Themes
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );


/**
 * Modify YouTube oEmbeds to use youtube-nocookie.com
 *
 * @param $cached_html
 * @param $url
 *
 * @return string
 */
function filter_youtube_embed( $cached_html, $url = null ) {

	// Search for youtu to return true for both youtube.com and youtu.be URLs
	if ( strpos( $url, 'youtu' ) ) {
		$cached_html = preg_replace( '/youtube\.com\/(v|embed)\//s', 'youtube-nocookie.com/$1/', $cached_html );
	}

	return $cached_html;
}
add_filter( 'embed_oembed_html', 'filter_youtube_embed', 10, 2 );


// * Repostion the secondary Nav into the Secondary Sidebar

remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_after_sidebar_alt_widget_area', 'genesis_do_subnav' );


add_filter( 'get_custom_logo', 'sp_custom_logo_link' );

function sp_custom_logo_link( $html ) {

return str_replace( 'href="/', 'href="http://qa.orcid.org/', $html );

}


//* Modify the header URL - HTML5 Version
add_filter( 'genesis_seo_title', 'child_header_title', 10, 3 );
function child_header_title( $title, $inside, $wrap ) {
    $inside = sprintf( '<a href="https://qa.orcid.org/" title="%s"></a>', esc_attr( get_bloginfo( 'name' ) ), get_bloginfo( 'name' ) );
    return sprintf( '<%1$s class="site-title">%2$s</%1$s>', $wrap, $inside );
}


//* Enable Genesis Accessibility Components

add_theme_support( 'genesis-accessibility', array(

    '404-page',

    'drop-down-menu',

    'headings',

    'rems',

    'search-form',

    'skip-links',

) );	