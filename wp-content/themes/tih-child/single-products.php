<?php
/**
 * Single Product template
 * Note: Buyee Bridge and Recommendations are auto-injected
 *       via the_content filters in buyee-bridge.php / recommendations.php
 */

get_header(); ?>

<main id="main" class="tih-single-product">
<?php while ( have_posts() ) : the_post(); ?>

<?php
$islands    = get_field( 'featured_island' );
$island     = ( is_array( $islands ) && ! empty( $islands ) ) ? $islands[0] : null;
$price_yen  = get_field( 'price_yen' );
$terms      = wp_get_post_terms( get_the_ID(), 'theme_category' );
$theme_term = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0] : null;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'tih-product' ); ?>>

    <header class="tih-product__header">
        <?php if ( $theme_term ) : ?>
        <a href="<?php echo esc_url( get_term_link( $theme_term ) ); ?>"
           class="tih-badge tih-badge--<?php echo esc_attr( $theme_term->slug ); ?>">
            <?php echo esc_html( $theme_term->name ); ?>
        </a>
        <?php endif; ?>

        <h1 class="tih-product__title"><?php the_title(); ?></h1>

        <p class="tih-product__meta">
            <?php if ( $island ) : ?>
            From <a href="<?php echo esc_url( get_permalink( $island->ID ) ); ?>">
                <?php echo esc_html( $island->post_title ); ?>
            </a>
            <?php endif; ?>
            <?php if ( $price_yen ) : ?>
            &nbsp;·&nbsp; <strong>¥<?php echo number_format( (int) $price_yen ); ?></strong>
            <?php endif; ?>
        </p>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
    <figure class="tih-product__hero">
        <?php the_post_thumbnail( 'tih-island-hero', [ 'alt' => get_the_title() ] ); ?>
    </figure>
    <?php endif; ?>

    <div class="tih-product__body">
        <?php the_content(); ?>
        <!-- Buyee Bridge + Recommendations auto-injected here via filters -->
    </div>

</article>

<?php endwhile; ?>
</main>

<?php get_sidebar(); get_footer(); ?>
