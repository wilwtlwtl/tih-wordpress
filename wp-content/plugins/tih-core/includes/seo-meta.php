<?php
/**
 * SEO meta — dynamic keywords and JSON-LD structured data
 * Compatible with RankMath and Yoast SEO.
 */

defined( 'ABSPATH' ) || exit;

// JSON-LD Product schema for single products
add_action( 'wp_head', 'tih_product_json_ld' );

function tih_product_json_ld(): void {
    if ( ! is_singular( 'products' ) ) {
        return;
    }

    $post_id   = get_the_ID();
    $price     = get_field( 'price_yen', $post_id );
    $jp_kw     = get_field( 'jp_keyword', $post_id );
    $islands   = get_field( 'featured_island', $post_id );
    $island_name = ( is_array( $islands ) && ! empty( $islands ) )
        ? $islands[0]->post_title
        : 'Tokyo Islands';

    $data = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => get_the_title(),
        'description' => wp_strip_all_tags( get_the_excerpt() ),
        'keywords'    => $jp_kw,
        'brand'       => [
            '@type' => 'Brand',
            'name'  => 'Tokyo Island Heritage — ' . $island_name,
        ],
        'offers' => [
            '@type'         => 'Offer',
            'priceCurrency' => 'JPY',
            'price'         => $price ?: '',
            'availability'  => 'https://schema.org/InStock',
            'url'           => get_permalink(),
        ],
    ];

    if ( has_post_thumbnail() ) {
        $data['image'] = get_the_post_thumbnail_url( $post_id, 'large' );
    }

    echo '<script type="application/ld+json">'
        . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
        . "</script>\n";
}

// Theme category SEO — enriched descriptions appended to RankMath / Yoast
$seo_extras = [
    'spirits' => 'GI Tokyo Shimazake, Rare Japanese Shochu, Barley Koji Spirits',
    'beauty'  => 'Toshima Camellia Oil, J-Beauty Pure Oil, Camellia Japonica Benefits',
    'gourmet' => 'Kusaya fermented fish, Japanese Blue Cheese, Umami food',
    'craft'   => 'Niijima Glass, Volcanic Olive Green Glass, Koga Stone Art',
];

add_filter( 'rank_math/frontend/description', 'tih_enrich_tax_description' );
add_filter( 'wpseo_metadesc',                 'tih_enrich_tax_description' );

function tih_enrich_tax_description( string $desc ): string {
    if ( ! is_tax( 'theme_category' ) ) {
        return $desc;
    }
    static $extras = [
        'spirits' => 'GI Tokyo Shimazake, Rare Japanese Shochu, Barley Koji Spirits',
        'beauty'  => 'Toshima Camellia Oil, J-Beauty Pure Oil, Camellia Japonica Benefits',
        'gourmet' => 'Kusaya fermented fish, Japanese Blue Cheese, Umami food',
        'craft'   => 'Niijima Glass, Volcanic Olive Green Glass, Koga Stone Art',
    ];
    $term = get_queried_object();
    if ( isset( $extras[ $term->slug ] ) ) {
        $desc .= ' | ' . $extras[ $term->slug ];
    }
    return $desc;
}

// Page title enrichment for island and product pages
add_filter( 'rank_math/frontend/title', 'tih_enrich_page_title' );
add_filter( 'wpseo_title',              'tih_enrich_page_title' );

function tih_enrich_page_title( string $title ): string {
    if ( is_singular( 'islands' ) ) {
        return $title . ' — Tokyo Islands Hidden Gem';
    }
    if ( is_singular( 'products' ) ) {
        return $title . ' — Japanese Artisanal Product';
    }
    if ( is_post_type_archive( 'islands' ) ) {
        return 'Tokyo Islands | Hidden Gems of Japanese Artisanal Culture';
    }
    return $title;
}
