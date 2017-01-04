<?php
/*
	Plugin Name: Genesis Simple Mobile Navigation
	Plugin URI: http://redblue.us
	Description: A plugin which handles mobile menus a bit differently than typical themes
	Version: 0.1
    Author: Jon Schroeder
    Author URI: http://redblue.us

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
*/

/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
    die( "Sorry, you are not allowed to access this page directly." );
}

// Plugin directory
define( 'REDBLUE_MOBILE_NAV', dirname( __FILE__ ) );


//* Enqueue Scripts and Styles (this should happen in the normal order)
add_action( 'wp_enqueue_scripts', 'rbmn_scripts_styles' );
function rbmn_scripts_styles() {

    //* Don't add these scripts and styles to the admin side of the site
    if ( is_admin() )
		return;

    wp_enqueue_style( 'dashicons' );

    //* Enqueue main style
    wp_enqueue_style( 'rbmn-style', plugin_dir_url( __FILE__ ) . '/css/rbmn-style.css' );

    //* Enqueue main script
    wp_enqueue_script( 'slideout', plugin_dir_url( __FILE__ ) . '/slideout/dist/slideout.min.js', 'jquery' );
    wp_enqueue_script( 'slideout-init', plugin_dir_url( __FILE__ ) . '/js/slideout-init.js', array( 'jquery', 'slideout' ) );

    //* Enqueue slideout styles
    wp_enqueue_style( 'slideout-style', plugin_dir_url( __FILE__ ) . '/slideout/index.css' );

}

//* Remove the default Genesis script for making menus mobile-friendly, since we're using our own
add_action( 'wp_enqueue_scripts', 'rbmn_remove_unused_genesis_scripts_styles', 99 );
function rbmn_remove_unused_genesis_scripts_styles() {
    wp_dequeue_script( 'genesis-sample-responsive-menu' );
}

//* Register the widget areas
add_action( 'init', 'rbmn_add_widget_areas' );
function rbmn_add_widget_areas() {
    genesis_register_sidebar( array(
        'id'			=> 'mobile-header',
        'name'		  => __( 'Mobile header', 'rbmn' ),
        'description'   => __( 'This area displays next to the hamburger. Keep this extremely short. If a logo is used, its height will be constrained.', 'rbmn' ),
    ) );
    genesis_register_sidebar( array(
        'id'			=> 'mobile-after-header',
        'name'		  => __( 'Mobile after header', 'rbmn' ),
        'description'   => __( 'This area appears below the header. Completely optional, but this area could show a phone number or other basic information you\'d like to show below the nav menu.', 'rbmn' ),
    ) );
    genesis_register_sidebar( array(
        'id'			=> 'mobile-nav',
        'name'		  => __( 'Mobile navigation area', 'rbmn' ),
        'description'   => __( 'This area displays after the hamburger is clicked. You can add multiple menus, if you like, and they\'ll display as one menu. Text or social icons are fine too.', 'rbmn' ),
    ) );
}

add_action( 'genesis_before', 'rbmn_add_mobile_nav_button', 0 );
function rbmn_add_mobile_nav_button() {

    //* We open 'main' here and will close it after everything
    echo '<main id="panel">';
        echo '<div class="mobile-header-wrapper">';
            echo '<button class="toggle-button panel-toggle">☰</button>';

            genesis_widget_area( 'mobile-header', array(
                'before' => '<div class="mobile-header-widget-area">',
                'after' => '</div>',
        	) );

            echo '<div class="clear"></div>';

        echo '</div>';

        genesis_widget_area( 'mobile-after-header', array(
            'before' => '<div class="clear"></div><div class="mobile-after-header-widget-area">',
            'after' => '</div>',
        ) );

}

add_action( 'genesis_after', 'rbmn_close_panel', 99 );
function rbmn_close_panel() {
    echo '</main>';

    echo '<nav id="menu">';
        echo '<div class="menu-wrapper">';

            genesis_widget_area( 'mobile-nav', array(
                'before' => '<div class="mobile-nav-area">',
                'after' => '</div>',
            ) );

        echo '</div>';
    echo '</nav>';
}
