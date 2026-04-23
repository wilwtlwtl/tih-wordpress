<?php
/**
 * ACF field group definitions — registered programmatically.
 * Requires ACF Pro 6.x. No JSON sync file needed.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'tih_register_acf_fields' );

function tih_register_acf_fields(): void {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // ========================================================
    // Island Details
    // ========================================================
    acf_add_local_field_group( [
        'key'    => 'group_tih_islands',
        'title'  => 'Island Details',
        'fields' => [
            [
                'key'          => 'field_island_description',
                'label'        => 'Island Description (English)',
                'name'         => 'island_description',
                'type'         => 'textarea',
                'instructions' => 'English overview of the island (100–200 words recommended).',
                'required'     => 0,
                'rows'         => 6,
            ],
            [
                'key'          => 'field_island_map_link',
                'label'        => 'Google Map Link',
                'name'         => 'island_map_link',
                'type'         => 'url',
                'instructions' => 'Full Google Maps URL for this island.',
            ],
            [
                'key'           => 'field_island_related_treasures',
                'label'         => 'Related Treasures',
                'name'          => 'related_treasures',
                'type'          => 'relationship',
                'post_type'     => [ 'treasures' ],
                'filters'       => [ 'search', 'taxonomy' ],
                'elements'      => [ 'featured_image' ],
                'return_format' => 'object',
            ],
            [
                'key'           => 'field_island_related_products',
                'label'         => 'Related Products',
                'name'          => 'related_products',
                'type'          => 'relationship',
                'post_type'     => [ 'products' ],
                'filters'       => [ 'search', 'taxonomy' ],
                'elements'      => [ 'featured_image' ],
                'return_format' => 'object',
            ],
        ],
        'location' => [
            [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'islands' ] ],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
    ] );

    // ========================================================
    // Treasure Details
    // ========================================================
    acf_add_local_field_group( [
        'key'    => 'group_tih_treasures',
        'title'  => 'Treasure Details',
        'fields' => [
            [
                'key'           => 'field_treasure_featured_island',
                'label'         => 'Featured Island(s)',
                'name'          => 'featured_island',
                'type'          => 'relationship',
                'post_type'     => [ 'islands' ],
                'filters'       => [ 'search' ],
                'elements'      => [ 'featured_image' ],
                'min'           => 1,
                'max'           => 3,
                'return_format' => 'object',
                'instructions'  => 'Select the island(s) this article is primarily about.',
                'required'      => 1,
            ],
        ],
        'location' => [
            [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'treasures' ] ],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
    ] );

    // ========================================================
    // Product Details & Buyee Info
    // ========================================================
    acf_add_local_field_group( [
        'key'    => 'group_tih_products',
        'title'  => 'Product Details & Buyee Info',
        'fields' => [
            [
                'key'           => 'field_product_featured_island',
                'label'         => 'Origin Island',
                'name'          => 'featured_island',
                'type'          => 'relationship',
                'post_type'     => [ 'islands' ],
                'filters'       => [ 'search' ],
                'elements'      => [ 'featured_image' ],
                'max'           => 1,
                'return_format' => 'object',
                'instructions'  => 'Select the island this product originates from.',
                'required'      => 1,
            ],
            [
                'key'          => 'field_jp_keyword',
                'label'        => 'Japanese Search Keyword',
                'name'         => 'jp_keyword',
                'type'         => 'text',
                'instructions' => '日本語キーワード（Buyee / Rakuten検索用）',
                'required'     => 1,
                'placeholder'  => 'e.g. 青酎',
            ],
            [
                'key'          => 'field_price_yen',
                'label'        => 'Reference Price',
                'name'         => 'price_yen',
                'type'         => 'number',
                'instructions' => 'Approximate price in Japanese Yen.',
                'min'          => 0,
                'step'         => 1,
                'prepend'      => '¥',
            ],
            [
                'key'          => 'field_visual_id_guide',
                'label'        => 'Visual Identification Guide',
                'name'         => 'visual_id_guide',
                'type'         => 'textarea',
                'instructions' => 'Describe bottle/box color, shape, and label so overseas buyers can identify the correct product on Buyee.',
                'rows'         => 5,
                'required'     => 1,
            ],
            [
                'key'          => 'field_buyee_url',
                'label'        => 'Buyee / Rakuten Direct Link (optional)',
                'name'         => 'buyee_url',
                'type'         => 'url',
                'instructions' => 'Direct product URL. Leave blank to auto-generate a keyword search link.',
            ],
            [
                'key'          => 'field_rare_stock',
                'label'        => 'Rare / Limited Stock Warning',
                'name'         => 'rare_stock',
                'type'         => 'true_false',
                'instructions' => 'Show "Limited stock — verify availability" badge on the Buyee Bridge.',
                'default_value' => 0,
                'ui'           => 1,
            ],
        ],
        'location' => [
            [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'products' ] ],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
    ] );
}
