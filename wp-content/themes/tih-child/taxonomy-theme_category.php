<?php
/**
 * Theme Category archive — /spirits/ /beauty/ /gourmet/ /craft/
 */

get_header();

$term        = get_queried_object();
$slug        = $term ? $term->slug : '';
$description = $term ? $term->description : '';

$icons = [
    'spirits' => '🍶',
    'beauty'  => '🌸',
    'gourmet' => '🐟',
    'craft'   => '🟢',
];
$taglines = [
    'spirits' => 'Volcanic terroir in every drop — island-distilled shochu and awamori.',
    'beauty'  => 'Tsubaki oil and botanical extracts from Japan\'s remote island ateliers.',
    'gourmet' => 'Fermented, cured and sun-dried — the bold flavours of the Pacific.',
    'craft'   => 'Hand-blown glass and woven textiles forged from island tradition.',
];

$icon    = $icons[ $slug ]    ?? '🏝️';
$tagline = $taglines[ $slug ] ?? '';
?>

<main id="main" class="tih-category-archive tih-category-archive--<?php echo esc_attr( $slug ); ?>">

    <header class="tih-cat-hero tih-cat-hero--<?php echo esc_attr( $slug ); ?>">
        <div class="tih-cat-hero__inner">
            <span class="tih-cat-hero__icon" aria-hidden="true"><?php echo esc_html( $icon ); ?></span>
            <h1 class="tih-cat-hero__title"><?php echo esc_html( $term->name ); ?></h1>
            <p class="tih-cat-hero__tagline"><?php echo esc_html( $tagline ); ?></p>
            <?php if ( $description ) : ?>
            <p class="tih-cat-hero__desc"><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>
        </div>
    </header>

    <?php if ( have_posts() ) : ?>

    <div class="tih-cat-grid-wrap">
        <p class="tih-cat-count">
            <?php
            global $wp_query;
            printf(
                '%d item%s from Tokyo\'s volcanic islands',
                $wp_query->found_posts,
                $wp_query->found_posts === 1 ? '' : 's'
            );
            ?>
        </p>

        <ul class="tih-cat-grid">
            <?php while ( have_posts() ) : the_post();
                $post_type  = get_post_type();
                $islands    = get_field( 'featured_island' );
                $island     = ( is_array( $islands ) && ! empty( $islands ) ) ? $islands[0] : null;
                $jp_kw      = get_field( 'jp_keyword' );
                $price_yen  = get_field( 'price_yen' );
            ?>
            <li class="tih-cat-card">
                <a href="<?php the_permalink(); ?>" class="tih-cat-card__link">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'tih-card', [ 'class' => 'tih-cat-card__img', 'loading' => 'lazy' ] ); ?>
                    <?php else : ?>
                        <div class="tih-cat-card__placeholder" aria-hidden="true">
                            <span><?php echo esc_html( $icon ); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="tih-cat-card__body">
                        <span class="tih-badge tih-badge--<?php echo esc_attr( $slug ); ?>">
                            <?php echo esc_html( $term->name ); ?>
                        </span>
                        <h2 class="tih-cat-card__title"><?php the_title(); ?></h2>

                        <?php if ( $island ) : ?>
                        <span class="tih-cat-card__island">
                            📍 <?php echo esc_html( $island->post_title ); ?>
                        </span>
                        <?php endif; ?>

                        <?php if ( $jp_kw ) : ?>
                        <span class="tih-cat-card__kw"><?php echo esc_html( $jp_kw ); ?></span>
                        <?php endif; ?>

                        <?php if ( $price_yen ) : ?>
                        <span class="tih-cat-card__price">¥<?php echo number_format( (int) $price_yen ); ?></span>
                        <?php elseif ( $post_type === 'treasures' ) : ?>
                        <span class="tih-cat-card__read">Read article →</span>
                        <?php endif; ?>
                    </div>
                </a>
            </li>
            <?php endwhile; ?>
        </ul>

        <nav class="tih-pagination" aria-label="Archive pages">
            <?php
            echo paginate_links( [
                'prev_text' => '← Previous',
                'next_text' => 'Next →',
                'type'      => 'list',
            ] );
            ?>
        </nav>
    </div>

    <?php else : ?>
    <div class="tih-cat-empty">
        <p>No <?php echo esc_html( $term->name ); ?> products have been added yet — check back soon.</p>
    </div>
    <?php endif; ?>

</main>

<?php get_sidebar(); get_footer(); ?>
