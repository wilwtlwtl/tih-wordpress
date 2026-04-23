<?php
/**
 * Custom Post Type registrations for TIH
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'tih_register_cpts' );

function tih_register_cpts(): void {

    // ---- Islands ----
    register_post_type( 'islands', [
        'labels' => [
            'name'               => __( 'Islands', 'tih' ),
            'singular_name'      => __( 'Island', 'tih' ),
            'add_new_item'       => __( 'Add New Island', 'tih' ),
            'edit_item'          => __( 'Edit Island', 'tih' ),
            'view_item'          => __( 'View Island', 'tih' ),
            'search_items'       => __( 'Search Islands', 'tih' ),
            'not_found'          => __( 'No islands found', 'tih' ),
            'not_found_in_trash' => __( 'No islands found in Trash', 'tih' ),
            'all_items'          => __( 'All Islands', 'tih' ),
        ],
        'public'        => true,
        'has_archive'   => 'islands',
        'rewrite'       => [ 'slug' => 'islands', 'with_front' => false ],
        'menu_icon'     => 'dashicons-location',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'show_in_rest'  => true,
        'menu_position' => 5,
    ] );

    // ---- Treasures (連載記事) ----
    register_post_type( 'treasures', [
        'labels' => [
            'name'               => __( 'Treasures', 'tih' ),
            'singular_name'      => __( 'Treasure', 'tih' ),
            'add_new_item'       => __( 'Add New Article', 'tih' ),
            'edit_item'          => __( 'Edit Article', 'tih' ),
            'view_item'          => __( 'View Article', 'tih' ),
            'search_items'       => __( 'Search Treasures', 'tih' ),
            'not_found'          => __( 'No articles found', 'tih' ),
            'not_found_in_trash' => __( 'No articles found in Trash', 'tih' ),
            'all_items'          => __( 'All Treasures', 'tih' ),
        ],
        'public'        => true,
        'has_archive'   => 'treasures',
        'rewrite'       => [ 'slug' => 'treasures', 'with_front' => false ],
        'menu_icon'     => 'dashicons-star-filled',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'show_in_rest'  => true,
        'menu_position' => 6,
    ] );

    // ---- Products (個別商品カタログ) ----
    register_post_type( 'products', [
        'labels' => [
            'name'               => __( 'Products', 'tih' ),
            'singular_name'      => __( 'Product', 'tih' ),
            'add_new_item'       => __( 'Add New Product', 'tih' ),
            'edit_item'          => __( 'Edit Product', 'tih' ),
            'view_item'          => __( 'View Product', 'tih' ),
            'search_items'       => __( 'Search Products', 'tih' ),
            'not_found'          => __( 'No products found', 'tih' ),
            'not_found_in_trash' => __( 'No products found in Trash', 'tih' ),
            'all_items'          => __( 'All Products', 'tih' ),
        ],
        'public'        => true,
        'has_archive'   => 'products',
        'rewrite'       => [ 'slug' => 'products', 'with_front' => false ],
        'menu_icon'     => 'dashicons-cart',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'show_in_rest'  => true,
        'menu_position' => 7,
    ] );
}
