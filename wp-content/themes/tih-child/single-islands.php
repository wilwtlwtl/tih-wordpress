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

    <?php
    // #5 — Starter Kit: one product per category from this island
    $starter_kit = tih_get_starter_kit( get_the_ID() );
    if ( ! empty( $starter_kit ) ) :
        $island_name = get_the_title();
    ?>
    <section class="tih-starter-kit">
        <h2 class="tih-starter-kit__heading">
            <span aria-hidden="true">🎁</span>
            <?php echo esc_html( $island_name ); ?> Starter Kit
        </h2>
        <p class="tih-starter-kit__intro">
            New to <?php echo esc_html( $island_name ); ?>? Start with one from each category —
            the fastest way to experience the island's artisanal range.
        </p>
        <ul class="tih-starter-kit__grid">
            <?php foreach ( $starter_kit as $item ) :
                $kw    = get_field( 'jp_keyword', $item['post']->ID );
                $price = get_field( 'price_yen',  $item['post']->ID );
            ?>
            <li class="tih-starter-kit__card tih-starter-kit__card--<?php echo esc_attr( $item['category'] ); ?>">
                <a href="<?php echo esc_url( get_permalink( $item['post']->ID ) ); ?>">
                    <?php if ( has_post_thumbnail( $item['post']->ID ) ) : ?>
                        <?php echo get_the_post_thumbnail( $item['post']->ID, 'tih-card' ); ?>
                    <?php else : ?>
                        <div class="tih-starter-kit__placeholder" aria-hidden="true">
                            <span><?php echo esc_html( $item['icon'] ); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="tih-starter-kit__card-body">
                        <span class="tih-badge tih-badge--<?php echo esc_attr( $item['category'] ); ?>">
                            <?php echo esc_html( ucfirst( $item['category'] ) ); ?>
                        </span>
                        <h3><?php echo esc_html( $item['post']->post_title ); ?></h3>
                        <?php if ( $kw ) : ?>
                        <span class="tih-starter-kit__kw"><?php echo esc_html( $kw ); ?></span>
                        <?php endif; ?>
                        <?php if ( $price ) : ?>
                        <span class="tih-starter-kit__price">¥<?php echo number_format( (int) $price ); ?>〜</span>
                        <?php endif; ?>
                        <span class="tih-starter-kit__cta">View &amp; Buy →</span>
                    </div>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <style>
    .tih-starter-kit{margin:3rem 0 0;padding:2rem;background:linear-gradient(135deg,#1a4a6b 0%,#0d2e43 100%);border-radius:var(--tih-radius,8px);color:#fff;}
    .tih-starter-kit__heading{color:#f5e6c8;font-size:1.3rem;margin:0 0 .5rem;display:flex;align-items:center;gap:.5rem;}
    .tih-starter-kit__intro{font-size:.9rem;opacity:.8;margin:0 0 1.5rem;}
    .tih-starter-kit__grid{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;}
    .tih-starter-kit__card a{display:flex;flex-direction:column;text-decoration:none;color:#fff;background:rgba(255,255,255,.08);border-radius:6px;overflow:hidden;transition:background .2s;}
    .tih-starter-kit__card a:hover{background:rgba(255,255,255,.15);}
    .tih-starter-kit__card img{width:100%;aspect-ratio:4/3;object-fit:cover;}
    .tih-starter-kit__placeholder{width:100%;aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;font-size:3rem;background:rgba(255,255,255,.05);}
    .tih-starter-kit__card-body{padding:.9rem;}
    .tih-starter-kit__card-body h3{font-size:.9rem;margin:.4rem 0 .3rem;line-height:1.35;}
    .tih-starter-kit__kw{display:block;font-size:1.1rem;margin:.2rem 0;}
    .tih-starter-kit__price{display:block;font-size:.85rem;opacity:.75;margin:.2rem 0;}
    .tih-starter-kit__cta{display:inline-block;margin-top:.5rem;font-size:.8rem;font-weight:700;color:var(--tih-sand,#f5e6c8);}
    @media(max-width:480px){.tih-starter-kit__grid{grid-template-columns:1fr 1fr;}}
    </style>
    <?php endif; ?>

</article>

<?php endwhile; ?>
</main>

<?php get_sidebar(); get_footer(); ?>
