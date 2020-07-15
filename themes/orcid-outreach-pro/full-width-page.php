<?php
/**
* Template Name: Full Width No sidebar
* Description: Template for a full width page no sidebars
*/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
genesis();