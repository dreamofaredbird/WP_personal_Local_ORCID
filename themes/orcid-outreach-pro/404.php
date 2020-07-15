<?php
 
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'genesis_404');
 
function genesis_404()
{
    echo genesis_html5() ? '<article class="entry">' : '<div class="post hentry">';
    printf('<h1>%s</h1>', apply_filters('genesis_404_entry_title', __('Sorry, we can\'t find the page you\'re looking for.', 'genesis')));
    echo '<div class="entry-content">';
    echo apply_filters('genesis_404_entry_content', '<p>' . sprintf(__('It looks like the page you are looking for is not here. Don\'t worry, this can happen for many reasons. The URL could be typed wrong, the page could have moved or something might have gone wrong with our site. We will do our best to put you back on track.', 'genesis') , trailingslashit(home_url())) . '</p>');
?>

<div class= 'entry-content'>
<h2>What now?</h2>
<h3>Search the ORCID Site</h3>

<?php
genesis_markup(
       [
           'open'    => '<div %s>',
           'close'   => '</div>',
           'content' => $genesis_404_content . get_search_form( 0 ),
           'context' => 'entry-content',
       ]
   );
   
   ?>
   
   <h3>Head back to our <a href="/">homepage</a> and start again from there.</h3>
</div>

<div class="archive-page">
<h3>
<?php
    _e('Or take a look at our most recent blog posts:', 'genesis'); ?></h3>
<ul>
<?php
    wp_get_archives('type=postbypost&limit=3'); ?>
</ul>
 
</div><!-- end .archive-page-->

<h3>Still need help? </h3>
<p>If you still can't find what you're looking for then please <a href ="https://support.orcid.org/hc/en-us/requests/new">Contact us.</a></p>

<?php
}
 
genesis();


