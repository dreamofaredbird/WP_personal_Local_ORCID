<?php

use Molongui\Authorship\Includes\Author;
if ( !defined( 'ABSPATH' ) ) exit;
global $current_user;
$authors          = array();
$authors[0]       = new \stdClass();
$authors[0]->id   = $current_user->ID;
$authors[0]->type = 'user';
$authors[0]->ref  = 'user'.'-'.$current_user->ID;
if ( !class_exists('Molongui\\'.$this->plugin->namespace.'\Includes\Author') ) require_once $this->plugin->dir . 'includes/molongui-class-author.php';
$author_class = new Author( $this->plugin );
$fpath = 'customizer/css/live-preview.min.css';
if ( file_exists( $this->plugin->dir . $fpath ) )
{
	wp_enqueue_style( $this->plugin->dashed_name.'-preview', $this->plugin->url . $fpath, array(), $this->plugin->version );
}
molongui_enqueue_element_queries();
?>

<div class="molongui-author-box-preview">

	<?php echo $author_class->get_box_markup( null, $authors ); //include( $this->plugin->dir . 'public/views/html-author-box-layout.php' ); ?>
	<p class="molongui-settings-link-desc">
		<?php _e( "How the author box is displayed in your site's frontend could differ slightly from what is shown here.", $this->plugin->textdomain ); ?>
	</p>

</div><!-- !.molongui-author-box-preview -->