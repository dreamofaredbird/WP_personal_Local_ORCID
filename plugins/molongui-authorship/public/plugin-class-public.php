<?php

namespace Molongui\Authorship\FrontEnd;

use Molongui\Authorship\Includes\Author;
if ( !defined( 'ABSPATH' ) ) exit;
class FrontEnd
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
	    require_once( $this->plugin->dir . '/includes/functions.php' );
        require_once( $this->plugin->dir . 'includes/template-tags.php' );
        require_once( $this->plugin->dir . 'includes/compatibility.php' );
	    if ( $this->plugin->is_premium ) $this->load_premium_dependencies();
    }
    private function load_premium_dependencies()
    {
        require_once( $this->plugin->dir . 'premium/includes/shortcodes.php' );
        if ( !empty( $this->plugin->settings['enable_search_by_author'] ) or !empty( $this->plugin->settings['include_guests_in_search'] ) )
        {
	        require_once( $this->plugin->dir . 'premium/includes/search-results.php' );
        }
        if ( isset( $this->plugin->settings['enable_guest_authors_feature'] ) and $this->plugin->settings['enable_guest_authors_feature'] and
             isset( $this->plugin->settings['guest_archive_enabled'] ) and $this->plugin->settings['guest_archive_enabled'] )
        {
	        require_once( $this->plugin->dir . 'premium/includes/guest-archives.php' );
        }
        require_once( $this->plugin->dir . 'premium/includes/user-archives.php' );
    }
	private function define_hooks()
	{
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_head', $this->classes['author'], 'add_author_meta' );
		$this->loader->add_filter( 'the_author',  $this->classes['author'], 'maybe_filter_name', 999, 1 );
		$this->loader->add_filter( 'get_the_author_display_name', $this->classes['author'], 'maybe_filter_the_author_display_name', 999, 3 );
        $this->loader->add_filter( 'get_the_archive_title', $this->classes['author'], 'filter_archive_title', 999, 1 );
        $this->loader->add_filter( 'get_the_archive_description', $this->classes['author'], 'filter_archive_description', 999, 1 );
		$this->loader->add_filter( 'author_link', $this->classes['author'], 'maybe_filter_link', 999, 1 );
		$this->loader->add_filter( 'get_avatar',  $this->classes['author'], 'filter_avatar', 999, 6 );
		if ( $this->plugin->settings['order'] <= 10 )
		{
			remove_filter( 'the_content', 'wpautop' );
			add_filter( 'the_content', 'wpautop', $this->plugin->settings['order'] - 1 );
		}
		$this->loader->add_filter( 'the_content', $this->classes['author'], 'render_author_box', $this->plugin->settings['order'], 1 );
	}
    public function enqueue_styles()
    {
        if ( !$this->plugin->is_premium )
        {
            $fpath = 'public/css/molongui-authorship.219d.min.css';
            if ( file_exists( $this->plugin->dir . $fpath ) )
                wp_enqueue_style( strtolower( $this->plugin->dashed_name ), $this->plugin->url . $fpath, array(), $this->plugin->version, 'all' );
        }
        else
        {
            $fpath = 'premium/public/css/molongui-authorship-premium.bb5d.min.css';
            if ( file_exists( $this->plugin->dir . $fpath ) )
                wp_enqueue_style( strtolower( $this->plugin->dashed_name ), $this->plugin->url . $fpath, array(), $this->plugin->version, 'all' );
        }
	    $onthefly_css = '';
	    if ( isset( $this->plugin->settings['hide_elements'] ) and !empty( $this->plugin->settings['hide_elements'] ) )
	    {
		    $selectors     = $this->plugin->settings['hide_elements'];
		    $onthefly_css .= "{$selectors} { display: none !important; }";
	    }
	    $onthefly_css .= $this->generate_on_the_fly_css();
	    if ( !empty( $onthefly_css ) ) wp_add_inline_style( strtolower( $this->plugin->dashed_name ), $onthefly_css );
    }
    public function enqueue_scripts()
    {
	    molongui_enqueue_element_queries();
        if ( !$this->plugin->is_premium )
        {
            $fpath = 'public/js/molongui-authorship.9ecb.min.js';
            if ( file_exists( $this->plugin->dir . $fpath ) )
                wp_enqueue_script( strtolower( $this->plugin->dashed_name ), $this->plugin->url . $fpath, array( 'jquery' ), $this->plugin->version, true );
        }
        else
        {
            $fpath = 'premium/public/js/molongui-authorship-premium.9ecb.min.js';
            if ( file_exists( $this->plugin->dir . $fpath ) )
                wp_enqueue_script( strtolower( $this->plugin->dashed_name ), $this->plugin->url . $fpath, array( 'jquery' ), $this->plugin->version, true );
        }
	    wp_localize_script( strtolower( $this->plugin->dashed_name ), 'molongui_authorship', array
	    (
		    'byline_separator'      => ( ( isset( $this->plugin->settings['byline_multiauthor_separator'] ) and !empty( $this->plugin->settings['byline_multiauthor_separator'] ) ) ? $this->plugin->settings['byline_multiauthor_separator'] : ', ' ),
		    'byline_last_separator' => ( ( isset( $this->plugin->settings['byline_multiauthor_last_separator'] ) and !empty( $this->plugin->settings['byline_multiauthor_last_separator'] ) ) ? $this->plugin->settings['byline_multiauthor_last_separator'] : ' '.__( 'and', $this->plugin->textdomain ).' ' ),
            'byline_link_title'     => __( 'View all posts by', $this->plugin->textdomain ),
	    ));
	    $onthefly_js = '';
	    $onthefly_js .= $this->generate_on_the_fly_js();
	    if ( !empty( $onthefly_js ) ) wp_add_inline_script( strtolower( $this->plugin->dashed_name ), $onthefly_js );
    }
	public function enqueue_common_scripts()
	{
		?>
		<script type="text/javascript">

        </script>
		<?php
	}
    private function generate_on_the_fly_css()
    {
		$css = '';
	    if ( isset( $this->plugin->settings['tabs_position'] ) and !empty( $this->plugin->settings['tabs_position'] ) ) $position = explode('-', $this->plugin->settings['tabs_position'] );
	    if ( isset( $position ) or !empty( $position[0] ) ) $position = $position[0];
	    else $position = 'top';
	    if ( isset( $this->plugin->settings['tabs_border'] ) and !empty( $this->plugin->settings['tabs_border'] ) ) $border = $this->plugin->settings['tabs_border'];
	    else $border = 'around';
		$nav_style    = '';
		$tab_style    = '';
		$active_style = '';
	    if ( isset( $this->plugin->settings['tabs_background'] ) and !empty( $this->plugin->settings['tabs_background'] ) ) $nav_style .= ' background-color:'.$this->plugin->settings['tabs_background'].';';
	    if ( isset( $this->plugin->settings['tabs_color'] ) and !empty( $this->plugin->settings['tabs_color'] ) ) $tab_style .= ' background-color:'.$this->plugin->settings['tabs_color'].';';
	    $tabs_background_style        = 'background-color: '.$this->plugin->settings['tabs_color'].';';
	    $tabs_active_background_style = 'background-color: '.$this->plugin->settings['tabs_active_color'].';';
	    $css .= "
	        .molongui-author-box .molongui-author-box-tabs nav.molongui-author-box-tabs-{$position} { {$nav_style} }
	        .molongui-author-box .molongui-author-box-tabs nav label { {$tab_style} }
	        .molongui-author-box .molongui-author-box-tabs input[id^='mab-tab-profile-']:checked ~ nav label[for^='mab-tab-profile-'],
            .molongui-author-box .molongui-author-box-tabs input[id^='mab-tab-related-']:checked ~ nav label[for^='mab-tab-related-'],
            .molongui-author-box .molongui-author-box-tabs input[id^='mab-tab-contact-']:checked ~ nav label[for^='mab-tab-contact-']
            {
                {$active_style}
            }
            
            .molongui-author-box .molongui-author-box-tabs nav label.molongui-author-box-tab { {$tabs_background_style} }
            .molongui-author-box .molongui-author-box-tabs nav label.molongui-author-box-tab.molongui-author-box-tab-active { {$tabs_active_background_style} }
            
            .molongui-author-box .molongui-author-box-tabs .molongui-author-box-related .molongui-author-box-related-entry-title,
            .molongui-author-box .molongui-author-box-tabs .molongui-author-box-related .molongui-author-box-related-entry-title a
            {
                color: {$this->plugin->settings['related_text_color']} !important;
            }
        ";
	    return $css;
    }
	private function generate_on_the_fly_js()
	{
		$js = '';
		if ( isset( $this->plugin->settings['hide_elements'] ) and !empty( $this->plugin->settings['hide_elements'] ) )
		{
			$selectors = $this->plugin->settings['hide_elements'];
			$js .= "var s = '{$selectors}';
		            var match = s.split(', ');
		            for (var a in match) { jQuery(match[a]).hide(); }";
		}
		return $js;
	}
}