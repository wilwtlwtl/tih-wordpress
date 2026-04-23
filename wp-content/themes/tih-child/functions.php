<?php
/**
 * TIH Child Theme — functions.php
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'tih-parent-style',
        get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_style(
        'tih-child-style',
        get_stylesheet_uri(),
        [ 'tih-parent-style' ],
        wp_get_theme()->get( 'Version' )
    );
} );

add_action( 'after_setup_theme', function () {
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'tih' ),
        'islands' => __( 'Islands Navigation', 'tih' ),
        'footer'  => __( 'Footer Navigation', 'tih' ),
    ] );

    add_theme_support( 'post-thumbnails' );
    add_image_size( 'tih-island-hero',    1200, 600,  true );
    add_image_size( 'tih-product-thumb',  400,  400,  true );
    add_image_size( 'tih-card',           600,  400,  true );

    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption' ] );
} );
