<?php
/**
 * Taxonomy registrations and clean URL rewrite rules for TIH
 *
 * Theme category archives use clean slugs: /spirits/, /beauty/, /gourmet/, /craft/
 * Custom rewrite rules override the default /theme_category/{slug}/ pattern.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'tih_register_taxonomies' );

function tih_register_taxonomies(): void {

    register_taxonomy( 'theme_category', [ 'treasures', 'products' ], [
        'labels' => [
            'name'          => __( 'Theme Categories', 'tih' ),
            'singular_name' => __( 'Theme Category', 'tih' ),
            'search_items'  => __( 'Search Categories', 'tih' ),
            'all_items'     => __( 'All Categories', 'tih' ),
            'edit_item'     => __( 'Edit Category', 'tih' ),
            'add_new_item'  => __( 'Add New Category', 'tih' ),
        ],
        'public'            => true,
        'hierarchical'      => false,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        // Disable default rewrite — we add custom rules below for clean /spirits/ URLs
        'rewrite'           => false,
        'query_var'         => 'theme_category',
    ] );

    // Custom rewrite rules for /spirits/, /beauty/, /gourmet/, /craft/
    $theme_slugs = implode( '|', [ 'spirits', 'beauty', 'gourmet', 'craft' ] );

    add_rewrite_rule(
        '^(' . $theme_slugs . ')/?$',
        'index.php?theme_category=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^(' . $theme_slugs . ')/page/([0-9]+)/?$',
        'index.php?theme_category=$matches[1]&paged=$matches[2]',
        'top'
    );
}

// Register theme_category as a recognized query var
add_filter( 'query_vars', function ( array $vars ): array {
    $vars[] = 'theme_category';
    return $vars;
} );

/**
 * Seed the four default theme_category terms.
 * Called on plugin activation via tih-core.php.
 */
function tih_seed_terms(): void {
    $terms = [
        [
            'name'        => 'Spirits',
            'slug'        => 'spirits',
            'description' => '島酒 — Artisanal shochu and awamori from Tokyo Islands',
        ],
        [
            'name'        => 'Beauty',
            'slug'        => 'beauty',
            'description' => '椿油 — Camellia oil and island beauty products',
        ],
        [
            'name'        => 'Gourmet',
            'slug'        => 'gourmet',
            'description' => 'くさや — Fermented fish and artisanal island foods',
        ],
        [
            'name'        => 'Craft',
            'slug'        => 'craft',
            'description' => '新島ガラス — Handcrafted glass and traditional island crafts',
        ],
    ];

    foreach ( $terms as $term ) {
        if ( ! term_exists( $term['slug'], 'theme_category' ) ) {
            wp_insert_term( $term['name'], 'theme_category', [
                'slug'        => $term['slug'],
                'description' => $term['description'],
            ] );
        }
    }
}
