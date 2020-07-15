<?php
/**
* Template Name: Product page
* Description: Template for product with no primary sidebar
*/

add_filter( 'genesis_site_layout', '__genesis_return_content_sidebar' );



    // Remove the Primary Sidebar from the Primary Sidebar area.
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );


    // Place the Secondary Sidebar into the Primary Sidebar area.
add_action( 'genesis_sidebar', 'genesis_do_sidebar_alt' );


genesis();