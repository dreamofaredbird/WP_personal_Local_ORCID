<?php

use Molongui\Authorship\Includes\Author;
if ( !defined( 'ABSPATH' ) ) exit;
function get_the_molongui_author( $pid = null, $separator = '', $last_separator = '', $before = '', $after = '' )
{
	if ( ( is_null( $pid ) or !is_integer( $pid ) ) and !in_the_loop() ) return '';
	$settings = get_option( MOLONGUI_AUTHORSHIP_BYLINE_SETTINGS );
    $output  = '';
    $output .= apply_filters( 'molongui_author_byline_before', ( !empty( $before ) ? $before : $settings['byline_modifier_before'] ) );
    $author  = new Author();
    $output .= $author->get_byline( $pid, $separator, $last_separator, false );
    $output .= apply_filters( 'molongui_author_byline_after', ( !empty( $after ) ? $after : $settings['byline_modifier_after'] ) );
    return $output;
}
function the_molongui_author( $pid = null, $separator = '', $last_separator = '', $before = '', $after = '' )
{
    echo get_the_molongui_author( $pid, $separator, $last_separator, $before, $after );
}
function get_the_molongui_author_posts_link( $pid = null, $separator = '', $last_separator = '', $before = '', $after = '' )
{
	if ( ( is_null( $pid ) or !is_integer( $pid ) ) and !in_the_loop() ) return '';
	$settings = get_option( MOLONGUI_AUTHORSHIP_BYLINE_SETTINGS );
    $output  = '';
    $output .= apply_filters( 'molongui_author_byline_before', ( !empty( $before ) ? $before : $settings['byline_modifier_before'] ) );
    $author  = new Author();
    $linked  = apply_filters( 'molongui_author_byline_linked', true );
    $output .= $author->get_byline( $pid, $separator, $last_separator, $linked );
    $output .= apply_filters( 'molongui_author_byline_after', ( !empty( $after ) ? $after : $settings['byline_modifier_after'] ) );
    return $output;
}
function the_molongui_author_posts_link( $pid = null, $separator = '', $last_separator = '', $before = '', $after = '' )
{
    echo get_the_molongui_author_posts_link( $pid, $separator, $last_separator, $before, $after );
}