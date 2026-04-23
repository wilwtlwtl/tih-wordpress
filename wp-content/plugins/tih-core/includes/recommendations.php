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
    return $content . tih_recommendations_html( get_the_ID(), get_post_type() );
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
