<?php
/*
	Plugin Name: Elodin Simple Mobile Navigation
	Plugin URI: http://elod.in
	Description: A plugin which handles mobile menus a bit differently than typical themes
	Version: 0.2.5
    Author: Jon Schroeder
    Author URI: http://elod.in

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

//* Bail if it's not a Genesis child theme
if ( wp_get_theme( get_template() ) != 'Genesis' ) 
    return 0;

// Plugin directory
define( 'ELODIN_MOBILE_NAV', dirname( __FILE__ ) );

// Define the version of the plugin
define ( 'EMH_VERSION', '0.2.5' );

// Updater
require 'vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/jonschr/elodin-mobile-header',
	__FILE__,
	'elodin-mobile-header'
);

// Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');


//* Enqueue Scripts and Styles (this should happen in the normal order)
add_action( 'wp_enqueue_scripts', 'emh_scripts_styles' );
function emh_scripts_styles() {

    //* Don't add these scripts and styles to the admin side of the site
    if ( is_admin() )
		return;

    wp_enqueue_style( 'dashicons' );

    //* Enqueue main style
    wp_enqueue_style( 'emh-style', plugin_dir_url( __FILE__ ) . 'css/rbmn-style.css', array(), EMH_VERSION, 'screen' );

    //* Enqueue scripts
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'slideout', plugin_dir_url( __FILE__ ) . 'js/slide-menus.js', array( 'jquery' ), EMH_VERSION, true );
    wp_enqueue_script( 'dropdown', plugin_dir_url( __FILE__ ) . 'js/dropdown-menus.js', array( 'jquery' ), EMH_VERSION, true );

}

//* Remove the default Genesis script for making menus mobile-friendly, since we're using our own
add_action( 'wp_enqueue_scripts', 'emh_remove_unused_genesis_scripts_styles', 99 );
function emh_remove_unused_genesis_scripts_styles() {
    wp_dequeue_script( 'genesis-sample-responsive-menu' );
}

//* Register the widget areas
add_action( 'init', 'emh_add_widget_areas' );
function emh_add_widget_areas() {
    genesis_register_sidebar( array(
        'id'			=> 'mobile-header',
        'name'		  => __( 'Mobile header', 'emh' ),
        'description'   => __( 'This area displays next to the hamburger. Keep this extremely short. If a logo is used, its height will be constrained. Recommended usage: <div style="background-image:url(http://yoursite.com/yourlogo.svg);" class="logo"></div>', 'emh' ),
    ) );
    genesis_register_sidebar( array(
        'id'			=> 'mobile-after-header',
        'name'		  => __( 'Mobile after header', 'emh' ),
        'description'   => __( 'This area appears below the header. Completely optional, but this area could show a phone number or other basic information you\'d like to show below the nav menu.', 'emh' ),
    ) );
    genesis_register_sidebar( array(
        'id'			=> 'mobile-nav-left',
        'name'		  => __( 'Left mobile navigation area', 'emh' ),
        'description'   => __( 'This area displays after the left hamburger is clicked. You can add multiple menus, if you like, and they\'ll display as one menu. Text or social icons are fine too.', 'emh' ),
    ) );
    genesis_register_sidebar( array(
        'id'			=> 'mobile-nav-right',
        'name'		  => __( 'Right mobile navigation area', 'emh' ),
        'description'   => __( 'This area displays after the right hamburger is clicked. You can add multiple menus, if you like, and they\'ll display as one menu. Text or social icons are fine too.', 'emh' ),
    ) );
}

add_action( 'genesis_before', 'emh_output_menus', 0 );
function emh_output_menus() {

    if ( is_active_sidebar('mobile-nav-left') || has_action( 'mobile_nav_left_before' ) || has_action( 'mobile_nav_left_after' ) ) {
        echo '<div class="slide-left slide-menu"><div class="mobile-nav-area">';
            do_action( 'mobile_nav_left_before' );
            dynamic_sidebar('mobile-nav-left');
            do_action( 'mobile_nav_left_after' );
        echo '</div></div>';
    }

    if ( is_active_sidebar('mobile-nav-right') || has_action( 'mobile_nav_right_before' ) || has_action( 'mobile_nav_right_after' ) ) {
        echo '<div class="slide-right slide-menu"><div class="mobile-nav-area">';
            do_action( 'mobile_nav_right_before' );
            dynamic_sidebar('mobile-nav-right');
            do_action( 'mobile_nav_right_after' );
        echo '</div></div>';
    }

}

add_action( 'genesis_before', 'emh_add_mobile_nav_button', 5 );
function emh_add_mobile_nav_button() {

    //* We open 'main' here and will close it after everything
    echo '<div class="mobile-header-wrapper">';

        if ( is_active_sidebar('mobile-nav-left') || has_action( 'mobile_nav_left_before' ) || has_action( 'mobile_nav_left_after' ) )
            echo '<a href="#" class="open-left open-menu"><span></span><span></span><span></span></a>';

        if ( is_active_sidebar('mobile-nav-right') || has_action( 'mobile_nav_right_before' ) || has_action( 'mobile_nav_right_after' ) )
            echo '<a href="#" class="open-right open-menu"><span></span><span></span><span></span></a>';

        genesis_widget_area( 'mobile-header', array(
            'before' => '<div class="mobile-header-widget-area">',
            'after' => '</div>',
    	) );

        echo '<div class="clear"></div>';

    echo '</div>';
    echo '<div class="body-wrapper">';

}

add_action( 'genesis_before', 'emh_add_after_header', 7 );
function emh_add_after_header() {

    genesis_widget_area( 'mobile-after-header', array(
        'before' => '<div class="clear"></div><div class="mobile-after-header-widget-area">',
        'after' => '</div>',
    ) );
}


add_action( 'genesis_after', 'emh_close_body_container_markup', 99 );
function emh_close_body_container_markup() {

        echo '<div class="slide-overlay"></div>';
    echo '</div>'; // .body-container
}
