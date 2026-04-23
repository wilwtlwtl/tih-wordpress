<?php
/**
 * Single Treasure template
 * Series badge, Buyee guide, and series nav are auto-injected via the_content filters.
 */

get_header(); ?>

<main id="main" class="tih-single-treasure">
<?php while ( have_posts() ) : the_post();

    $terms   = wp_get_post_terms( get_the_ID(), 'theme_category' );
    $term    = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0] : null;
    $islands = get_field( 'featured_island' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'tih-treasure' ); ?>>

    <header class="tih-treasure__header">
        <?php if ( $term ) : ?>
        <a href="<?php echo esc_url( get_term_link( $term ) ); ?>"
           class="tih-badge tih-badge--<?php echo esc_attr( $term->slug ); ?>">
            <?php echo esc_html( $term->name ); ?>
        </a>
        <?php endif; ?>

        <h1 class="tih-treasure__title"><?php the_title(); ?></h1>

        <?php if ( ! empty( $islands ) ) : ?>
        <p class="tih-treasure__islands">
            <?php foreach ( $islands as $island ) : ?>
            <a href="<?php echo esc_url( get_permalink( $island->ID ) ); ?>">
                📍 <?php echo esc_html( $island->post_title ); ?>
            </a>
            <?php endforeach; ?>
        </p>
        <?php endif; ?>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
    <figure class="tih-treasure__hero">
        <?php the_post_thumbnail( 'tih-island-hero', [ 'alt' => get_the_title() ] ); ?>
    </figure>
    <?php endif; ?>

    <div class="tih-treasure__body">
        <?php the_content(); ?>
        <!-- series badge, buyee guide, series nav auto-injected via filters -->
    </div>

</article>

<?php endwhile; ?>
</main>

<?php get_sidebar(); get_footer(); ?>
