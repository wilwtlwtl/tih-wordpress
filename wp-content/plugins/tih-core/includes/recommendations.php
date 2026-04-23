<?php
/**
 * Internal linking — "More from this island" + "Same category on other islands"
 * Auto-appended after single product and treasure content.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'the_content', 'tih_append_recommendations' );

function tih_append_recommendations( string $content ): string {
    if ( ! is_singular( [ 'products', 'treasures' ] ) || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    $post_id   = get_the_ID();
    $post_type = get_post_type();

    // Gourmet posts: inject "Ultimate Pairing" spirits link
    $content = tih_inject_pairing_link( $content, $post_id );

    return $content . tih_recommendations_html( $post_id, $post_type );
}

/**
 * #3 — For gourmet posts, append (or replace placeholder with) a
 * "Perfect Pairing" block linking to spirits from the same island + Aochu.
 */
function tih_inject_pairing_link( string $content, int $post_id ): string {
    $terms = wp_get_post_terms( $post_id, 'theme_category' );
    if ( empty( $terms ) || is_wp_error( $terms ) || $terms[0]->slug !== 'gourmet' ) {
        return $content;
    }

    // Gather spirits products: same island first, then always add Aochu
    $islands    = get_field( 'featured_island', $post_id );
    $spirits    = [];

    if ( ! empty( $islands ) ) {
        $island_id = is_object( $islands[0] ) ? $islands[0]->ID : (int) $islands[0];
        $spirits   = get_posts( [
            'post_type'      => 'products',
            'posts_per_page' => 2,
            'exclude'        => [ $post_id ],
            'meta_query'     => [ [
                'key' => 'featured_island', 'value' => '"' . $island_id . '"', 'compare' => 'LIKE',
            ] ],
            'tax_query' => [ [ 'taxonomy' => 'theme_category', 'field' => 'slug', 'terms' => 'spirits' ] ],
        ] );
    }

    // Always include Aochu as the "ultimate" pairing
    $aochu = get_posts( [
        'post_type'   => 'products',
        'name'        => 'aochu-aogashima-wild-yeast-shochu',
        'numberposts' => 1,
    ] );
    if ( ! empty( $aochu ) && ! in_array( $aochu[0]->ID, array_column( $spirits, 'ID' ), true ) ) {
        $spirits[] = $aochu[0];
    }

    if ( empty( $spirits ) ) {
        return str_replace( '<!-- ULTIMATE_PAIRING_PLACEHOLDER -->', '', $content );
    }

    ob_start();
    ?>
<div class="tih-pairing">
    <h3 class="tih-pairing__title">
        <span aria-hidden="true">🍶</span> The Ultimate Pairing — Island Spirits
    </h3>
    <p class="tih-pairing__intro">
        Kusaya and island shochu share the same volcanic terroir. The clean minerality of
        barley shochu cuts through the fermented richness of kusaya like no other spirit can.
    </p>
    <ul class="tih-pairing__list">
        <?php foreach ( $spirits as $s ) :
            $kw    = get_field( 'jp_keyword', $s->ID );
            $price = get_field( 'price_yen',  $s->ID );
        ?>
        <li class="tih-pairing__item">
            <a href="<?php echo esc_url( get_permalink( $s->ID ) ); ?>">
                <?php if ( has_post_thumbnail( $s->ID ) ) : ?>
                    <?php echo get_the_post_thumbnail( $s->ID, 'tih-product-thumb' ); ?>
                <?php endif; ?>
                <div class="tih-pairing__info">
                    <strong><?php echo esc_html( $s->post_title ); ?></strong>
                    <?php if ( $kw ) : ?>
                        <span class="tih-pairing__kw"><?php echo esc_html( $kw ); ?></span>
                    <?php endif; ?>
                    <?php if ( $price ) : ?>
                        <span class="tih-pairing__price">¥<?php echo number_format( (int) $price ); ?></span>
                    <?php endif; ?>
                </div>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<style>
.tih-pairing{background:var(--tih-lava,#2c2c2c);color:#fff;border-radius:var(--tih-radius,8px);padding:1.5rem;margin:2rem 0;}
.tih-pairing__title{color:#f5e6c8;font-size:1.1rem;margin:0 0 .6rem;display:flex;align-items:center;gap:.5rem;}
.tih-pairing__intro{font-size:.9rem;opacity:.85;margin:0 0 1rem;}
.tih-pairing__list{list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;gap:1rem;}
.tih-pairing__item a{display:flex;align-items:center;gap:.75rem;text-decoration:none;color:#fff;}
.tih-pairing__item img{width:60px;height:60px;object-fit:cover;border-radius:4px;}
.tih-pairing__info{display:flex;flex-direction:column;gap:.2rem;}
.tih-pairing__kw{font-size:1.1rem;}
.tih-pairing__price{font-size:.8rem;opacity:.7;}
</style>
    <?php
    $pairing_html = ob_get_clean();

    // Replace placeholder if it exists, otherwise append before content ends
    if ( strpos( $content, '<!-- ULTIMATE_PAIRING_PLACEHOLDER -->' ) !== false ) {
        return str_replace( '<!-- ULTIMATE_PAIRING_PLACEHOLDER -->', $pairing_html, $content );
    }
    return $content . $pairing_html;
}

function tih_recommendations_html( int $post_id, string $post_type ): string {
    $sections = [];

    // 1. More products from the same island
    $islands = get_field( 'featured_island', $post_id );
    if ( ! empty( $islands ) ) {
        $island    = is_array( $islands ) ? $islands[0] : $islands;
        $island_id = is_object( $island ) ? $island->ID : (int) $island;
        $siblings  = tih_products_by_island( $island_id, $post_type, $post_id );

        if ( ! empty( $siblings ) ) {
            $sections[] = tih_rec_section(
                'More Artisanal Products from ' . get_the_title( $island_id ),
                $siblings,
                get_permalink( $island_id )
            );
        }
    }

    // 2. Same theme category on other islands
    $terms = wp_get_post_terms( $post_id, 'theme_category' );
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        $term    = $terms[0];
        $related = get_posts( [
            'post_type'      => $post_type,
            'posts_per_page' => 4,
            'exclude'        => [ $post_id ],
            'tax_query'      => [ [
                'taxonomy' => 'theme_category',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ] ],
        ] );

        if ( ! empty( $related ) ) {
            $sections[] = tih_rec_section(
                'More ' . $term->name . ' from Other Islands',
                $related,
                get_term_link( $term )
            );
        }
    }

    if ( empty( $sections ) ) {
        return '';
    }

    return '<div class="tih-recommendations">' . implode( '', $sections ) . '</div>'
        . tih_recommendations_css();
}

function tih_products_by_island( int $island_id, string $post_type, int $exclude_id ): array {
    $all = get_posts( [
        'post_type'      => $post_type,
        'posts_per_page' => -1,
        'exclude'        => [ $exclude_id ],
        // ACF relationship fields store serialised arrays containing the post ID as a string
        'meta_query'     => [ [
            'key'     => 'featured_island',
            'value'   => '"' . $island_id . '"',
            'compare' => 'LIKE',
        ] ],
    ] );
    return array_slice( $all, 0, 4 );
}

function tih_rec_section( string $title, array $posts, $archive_url ): string {
    ob_start();
    ?>
<section class="tih-recommendations__section">
    <h3 class="tih-recommendations__heading"><?php echo esc_html( $title ); ?></h3>
    <ul class="tih-recommendations__grid">
        <?php foreach ( $posts as $p ) : ?>
        <li class="tih-recommendations__item">
            <a href="<?php echo esc_url( get_permalink( $p->ID ) ); ?>">
                <?php if ( has_post_thumbnail( $p->ID ) ) : ?>
                    <?php echo get_the_post_thumbnail( $p->ID, 'tih-product-thumb' ); ?>
                <?php else : ?>
                    <div class="tih-recommendations__placeholder" aria-hidden="true"></div>
                <?php endif; ?>
                <span class="tih-recommendations__label"><?php echo esc_html( $p->post_title ); ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php if ( $archive_url && ! is_wp_error( $archive_url ) ) : ?>
    <a class="tih-recommendations__see-all" href="<?php echo esc_url( $archive_url ); ?>">See all &rarr;</a>
    <?php endif; ?>
</section>
    <?php
    return ob_get_clean();
}

/**
 * #5 — Starter Kit: best one product per category for a given island.
 * Returns [ ['post'=>WP_Post, 'category'=>string, 'icon'=>string], ... ]
 */
function tih_get_starter_kit( int $island_id ): array {
    $categories = [
        'spirits' => '🍶',
        'beauty'  => '🌸',
        'gourmet' => '🐟',
        'craft'   => '🟢',
    ];

    $kit = [];

    foreach ( $categories as $slug => $icon ) {
        $products = get_posts( [
            'post_type'      => 'products',
            'posts_per_page' => 1,
            'meta_query'     => [ [
                'key'     => 'featured_island',
                'value'   => '"' . $island_id . '"',
                'compare' => 'LIKE',
            ] ],
            'tax_query' => [ [
                'taxonomy' => 'theme_category',
                'field'    => 'slug',
                'terms'    => $slug,
            ] ],
        ] );

        if ( ! empty( $products ) ) {
            $kit[] = [
                'post'     => $products[0],
                'category' => $slug,
                'icon'     => $icon,
            ];
        }
    }

    return $kit;
}

function tih_recommendations_css(): string {
    return '
<style>
.tih-recommendations { margin: 2.5rem 0 0; border-top: 2px solid var(--tih-ocean,#1a4a6b); padding-top: 1.5rem; }
.tih-recommendations__heading { font-size: 1.05rem; color: var(--tih-ocean,#1a4a6b); margin: 0 0 1rem; }
.tih-recommendations__grid { list-style:none; margin:0; padding:0; display:grid; grid-template-columns:repeat(auto-fill,minmax(140px,1fr)); gap:1rem; }
.tih-recommendations__item a { text-decoration:none; color:inherit; display:flex; flex-direction:column; gap:.4rem; }
.tih-recommendations__item img { width:100%; aspect-ratio:1; object-fit:cover; border-radius:4px; }
.tih-recommendations__placeholder { width:100%; aspect-ratio:1; background:var(--tih-sand,#f5e6c8); border-radius:4px; }
.tih-recommendations__label { font-size:.82rem; line-height:1.4; }
.tih-recommendations__see-all { display:inline-block; margin-top:.6rem; font-size:.9rem; font-weight:600; color:var(--tih-ocean,#1a4a6b); }
.tih-recommendations__section { margin-bottom:2rem; }
</style>';
}
