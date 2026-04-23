<?php
/**
 * Single Island template
 */

get_header(); ?>

<main id="main" class="tih-single-island">
<?php while ( have_posts() ) : the_post(); ?>

<?php
$map_link           = get_field( 'island_map_link' );
$related_products   = get_field( 'related_products' );
$related_treasures  = get_field( 'related_treasures' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'tih-island' ); ?>>

    <header class="tih-island__header">
        <span class="tih-island__kicker">Tokyo Islands</span>
        <h1 class="tih-island__title"><?php the_title(); ?></h1>
        <?php if ( $map_link ) : ?>
        <a href="<?php echo esc_url( $map_link ); ?>"
           class="tih-btn tih-island__map-link"
           target="_blank" rel="noopener noreferrer">
            📍 View on Google Maps
        </a>
        <?php endif; ?>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
    <figure class="tih-island__hero">
        <?php the_post_thumbnail( 'tih-island-hero', [ 'alt' => get_the_title() . ' island' ] ); ?>
    </figure>
    <?php endif; ?>

    <div class="tih-island__body">
        <?php the_content(); ?>
    </div>

    <?php if ( ! empty( $related_products ) ) : ?>
    <section class="tih-island__products">
        <h2>Artisanal Products from <?php the_title(); ?></h2>
        <ul class="tih-island__products-grid">
            <?php foreach ( $related_products as $product ) :
                $jp_kw = get_field( 'jp_keyword', $product->ID );
                $price = get_field( 'price_yen',  $product->ID );
                $terms = wp_get_post_terms( $product->ID, 'theme_category' );
                $term  = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0] : null;
            ?>
            <li class="tih-island__product-card">
                <a href="<?php echo esc_url( get_permalink( $product->ID ) ); ?>">
                    <?php if ( has_post_thumbnail( $product->ID ) ) : ?>
                        <?php echo get_the_post_thumbnail( $product->ID, 'tih-card' ); ?>
                    <?php else : ?>
                        <div class="tih-island__product-placeholder" aria-hidden="true"></div>
                    <?php endif; ?>
                    <div class="tih-island__product-info">
                        <?php if ( $term ) : ?>
                        <span class="tih-badge tih-badge--<?php echo esc_attr( $term->slug ); ?>">
                            <?php echo esc_html( $term->name ); ?>
                        </span>
                        <?php endif; ?>
                        <h3><?php echo esc_html( $product->post_title ); ?></h3>
                        <?php if ( $jp_kw ) : ?>
                        <span class="tih-island__product-kw"><?php echo esc_html( $jp_kw ); ?></span>
                        <?php endif; ?>
                        <?php if ( $price ) : ?>
                        <span class="tih-island__product-price">¥<?php echo number_format( (int) $price ); ?></span>
                        <?php endif; ?>
                    </div>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>

    <?php if ( ! empty( $related_treasures ) ) : ?>
    <section class="tih-island__treasures">
        <h2>Stories &amp; Features about <?php the_title(); ?></h2>
        <ul class="tih-island__treasures-list">
            <?php foreach ( $related_treasures as $treasure ) : ?>
            <li>
                <a href="<?php echo esc_url( get_permalink( $treasure->ID ) ); ?>">
                    <?php echo esc_html( $treasure->post_title ); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>

</article>

<?php endwhile; ?>
</main>

<?php get_sidebar(); get_footer(); ?>
