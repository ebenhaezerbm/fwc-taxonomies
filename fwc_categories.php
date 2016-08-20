<?php

/*
Plugin Name: FWC Categories
Plugin URI:  http://funkmo.com/
Description: Display dynamic categories on your sites
Version:     1.0
Author:      Ebenhaezer BM
Author URI:  http://ebenhaezerbm.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: fwc
*/


add_action( 'wp_enqueue_scripts', 'fwc_load_script' );
function fwc_load_script(){
    wp_enqueue_style('bootstrap-cdn-fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), true);
    
    wp_enqueue_style('fwc-script', plugins_url( 'assets/css/style.css', __FILE__ ), array(), true);
    
    wp_enqueue_script('fwc-script', plugins_url( 'assets/js/scripts.js', __FILE__ ), array( 'jquery' ), '', true);
}

/**
 * Display Post Categories Likes Menus 
 */
function get_the_categories( $parent = 0, $orderby = 'name', $order = 'ASC', $exclude = '', $tax = 'category' ) {
    $args = array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'parent'                   => $parent,
        'orderby'                  => $orderby,
        'order'                    => $order,
        'hide_empty'               => 0,
        'hierarchical'             => 1,
        'exclude'                  => $exclude,
        'include'                  => '',
        'number'                   => '',
        'taxonomy'                 => $tax,
        'pad_counts'               => false
    );
    
    $categories = get_categories( $args );

    if ( $categories ) {
        echo '<ul class="categories-item">';
        foreach ( $categories as $cat ) {
            $child = get_term_children( $cat->term_id, $tax );
            $icon = ( $child ) ? '<i class="fa fa-plus-square-o"> </i>' : '<i class="fa fa-minus-square-o"> </i>';
            
            if ( $cat->category_parent == $parent ) {
                echo '<li class="category-item">'.$icon.'<a href="' . get_term_link($cat) . '" >' . $cat->name . '</a>';
                get_the_categories( $cat->term_id, $orderby, $order, $exclude, $tax );
                echo '</li>';
            }
        }
        echo '</ul>';
    }
}

/**
 * Create Shortcode for FWC Categories 
 */
add_action( 'init', 'register_shortcodes');
function register_shortcodes(){
    add_shortcode('categories-menu', 'categories_menu');
}

function categories_menu( $atts, $content=null  ){
    $args = shortcode_atts( array(
        'parent'        => 0,
        'orderby'       => 'name',
        'order'         => 'ASC',
        'exclude'       => '',
        'tax'           => 'category'
    ), $atts );
    
    $parent     = $args['parent'];
    $orderby    = $args['orderby'];
    $order      = $args['order'];
    $exclude    = $args['exclude'];
    $tax        = $args['tax'];

    return get_the_categories( $parent, $orderby, $order, $exclude, $tax );
}

?>