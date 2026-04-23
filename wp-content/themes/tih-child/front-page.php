<?php
/**
 * Front page template — Tokyo Island Heritage
 */

get_header();

// Latest 4 treasure articles (any category)
$latest_treasures = get_posts( [
    'post_type'      => 'treasures',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
] );

// Islands (all published)
$islands = get_posts( [
    'post_type'      => 'islands',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'title',
    'order'          => 'ASC',
] );

// Category term counts
$cat_data = [];
foreach ( [ 'spirits', 'beauty', 'gourmet', 'craft' ] as $slug ) {
    $term = get_term_by( 'slug', $slug, 'theme_category' );
    if ( $term ) {
        $cat_data[ $slug ] = [
            'term'  => $term,
            'count' => $term->count,
        ];
    }
}

$cat_meta = [
    'spirits' => [ 'icon' => '🍶', 'label' => 'Island Spirits',    'desc' => 'GI-certified shochu from volcanic terroir' ],
    'beauty'  => [ 'icon' => '🌸', 'label' => 'J-Beauty',          'desc' => '80%+ oleic acid camellia oil & boxwood tools' ],
    'gourmet' => [ 'icon' => '🐟', 'label' => 'Island Gourmet',    'desc' => 'Fermented, smoked & sun-dried Pacific flavours' ],
    'craft'   => [ 'icon' => '🟢', 'label' => 'Island Craft',      'desc' => 'Volcanic glass, silk & artisan woodcraft' ],
];
?>

<main id="main" class="tih-home">

    <!-- ═══ HERO ═══════════════════════════════════════════════════ -->
    <section class="tih-hero" aria-label="Site hero">
        <div class="tih-hero__inner">
            <p class="tih-hero__kicker">358 km south of Tokyo · 11 volcanic islands</p>
            <h1 class="tih-hero__title">
                Tokyo Island<br>Heritage
            </h1>
            <p class="tih-hero__sub">
                Artisanal products from Japan's remote volcanic islands —<br>
                spirits, beauty, gourmet &amp; craft, delivered worldwide via Buyee.
            </p>
            <nav class="tih-hero__cta" aria-label="Primary actions">
                <a href="<?php echo esc_url( home_url( '/spirits/' ) ); ?>"
                   class="tih-btn tih-hero__btn tih-hero__btn--primary">Explore Products</a>
                <a href="<?php echo esc_url( home_url( '/how-to-buy/' ) ); ?>"
                   class="tih-btn tih-hero__btn tih-hero__btn--secondary">How to Buy</a>
            </nav>
        </div>
        <div class="tih-hero__scroll-hint" aria-hidden="true">↓</div>
    </section>

    <!-- ═══ CATEGORIES ══════════════════════════════════════════════ -->
    <section class="tih-home-section tih-home-cats" aria-labelledby="cats-heading">
        <div class="tih-home-section__inner">
            <h2 id="cats-heading" class="tih-home-section__title">Shop by Category</h2>
            <ul class="tih-home-cats__grid">
                <?php foreach ( $cat_meta as $slug => $meta ) :
                    $url   = home_url( '/' . $slug . '/' );
                    $count = $cat_data[ $slug ]['count'] ?? 0;
                ?>
                <li class="tih-home-cat tih-home-cat--<?php echo esc_attr( $slug ); ?>">
                    <a href="<?php echo esc_url( $url ); ?>" class="tih-home-cat__link">
                        <span class="tih-home-cat__icon" aria-hidden="true"><?php echo esc_html( $meta['icon'] ); ?></span>
                        <h3 class="tih-home-cat__name"><?php echo esc_html( $meta['label'] ); ?></h3>
                        <p class="tih-home-cat__desc"><?php echo esc_html( $meta['desc'] ); ?></p>
                        <?php if ( $count > 0 ) : ?>
                        <span class="tih-home-cat__count"><?php echo $count; ?> items</span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- ═══ LATEST ARTICLES ═════════════════════════════════════════ -->
    <?php if ( ! empty( $latest_treasures ) ) : ?>
    <section class="tih-home-section tih-home-articles" aria-labelledby="articles-heading">
        <div class="tih-home-section__inner">
            <div class="tih-home-section__head">
                <h2 id="articles-heading" class="tih-home-section__title">Latest Stories</h2>
                <a href="<?php echo esc_url( home_url( '/treasures/' ) ); ?>"
                   class="tih-home-section__see-all">All stories &rarr;</a>
            </div>
            <ul class="tih-home-articles__grid">
                <?php foreach ( $latest_treasures as $t ) :
                    $terms = wp_get_post_terms( $t->ID, 'theme_category' );
                    $term  = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0] : null;
                    $islands_acf = get_field( 'featured_island', $t->ID );
                    $island = ( is_array( $islands_acf ) && ! empty( $islands_acf ) ) ? $islands_acf[0] : null;
                ?>
                <li class="tih-home-article-card">
                    <a href="<?php echo esc_url( get_permalink( $t->ID ) ); ?>" class="tih-home-article-card__link">
                        <?php if ( has_post_thumbnail( $t->ID ) ) : ?>
                            <?php echo get_the_post_thumbnail( $t->ID, 'tih-card', [ 'class' => 'tih-home-article-card__img', 'loading' => 'lazy' ] ); ?>
                        <?php else : ?>
                            <div class="tih-home-article-card__placeholder" aria-hidden="true">
                                <?php echo esc_html( $cat_meta[ $term ? $term->slug : '' ]['icon'] ?? '🏝️' ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="tih-home-article-card__body">
                            <?php if ( $term ) : ?>
                            <span class="tih-badge tih-badge--<?php echo esc_attr( $term->slug ); ?>">
                                <?php echo esc_html( $term->name ); ?>
                            </span>
                            <?php endif; ?>
                            <h3 class="tih-home-article-card__title"><?php echo esc_html( $t->post_title ); ?></h3>
                            <?php if ( $t->post_excerpt ) : ?>
                            <p class="tih-home-article-card__excerpt"><?php echo esc_html( wp_trim_words( $t->post_excerpt, 18 ) ); ?></p>
                            <?php endif; ?>
                            <?php if ( $island ) : ?>
                            <span class="tih-home-article-card__island">📍 <?php echo esc_html( $island->post_title ); ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>

    <!-- ═══ ISLANDS ════════════════════════════════════════════════ -->
    <?php if ( ! empty( $islands ) ) : ?>
    <section class="tih-home-section tih-home-islands" aria-labelledby="islands-heading">
        <div class="tih-home-section__inner">
            <div class="tih-home-section__head">
                <h2 id="islands-heading" class="tih-home-section__title">Explore the Islands</h2>
            </div>
            <ul class="tih-home-islands__track">
                <?php foreach ( $islands as $isl ) :
                    $kit = tih_get_starter_kit( $isl->ID );
                ?>
                <li class="tih-home-island-chip">
                    <a href="<?php echo esc_url( get_permalink( $isl->ID ) ); ?>" class="tih-home-island-chip__link">
                        <?php if ( has_post_thumbnail( $isl->ID ) ) : ?>
                            <?php echo get_the_post_thumbnail( $isl->ID, 'tih-product-thumb', [ 'class' => 'tih-home-island-chip__img', 'loading' => 'lazy' ] ); ?>
                        <?php else : ?>
                            <div class="tih-home-island-chip__placeholder" aria-hidden="true">🏝️</div>
                        <?php endif; ?>
                        <span class="tih-home-island-chip__name"><?php echo esc_html( $isl->post_title ); ?></span>
                        <?php if ( ! empty( $kit ) ) : ?>
                        <span class="tih-home-island-chip__count"><?php echo count( $kit ); ?> products</span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>

    <!-- ═══ HOW TO BUY CTA ══════════════════════════════════════════ -->
    <section class="tih-home-section tih-home-buyee" aria-labelledby="buyee-heading">
        <div class="tih-home-section__inner">
            <div class="tih-home-buyee__inner">
                <div class="tih-home-buyee__text">
                    <h2 id="buyee-heading">These products aren&#8217;t on Amazon.</h2>
                    <p>Most Tokyo Island products are sold only on Japanese domestic marketplaces.
                    We show you exactly how to get them delivered anywhere in the world —
                    step by step, in English, in three minutes.</p>
                    <a href="<?php echo esc_url( home_url( '/how-to-buy/' ) ); ?>"
                       class="tih-btn tih-home-buyee__btn">Read the How to Buy Guide &rarr;</a>
                </div>
                <ul class="tih-home-buyee__steps" aria-hidden="true">
                    <li><span>1</span> Find a product on this site</li>
                    <li><span>2</span> Copy the Japanese keyword</li>
                    <li><span>3</span> Search &amp; order on Buyee</li>
                </ul>
            </div>
        </div>
    </section>

</main>

<style>
/* ── Hero ── */
.tih-hero {
    min-height: 88vh;
    display: flex; flex-direction: column; justify-content: center; align-items: center;
    text-align: center;
    background: linear-gradient(160deg, #0d1f30 0%, #1a4a6b 45%, #2c2c2c 100%);
    color: #fff;
    padding: 4rem 1.5rem 3rem;
    position: relative;
}
.tih-hero__kicker {
    font-size: .8rem; text-transform: uppercase; letter-spacing: .12em;
    opacity: .65; margin: 0 0 1rem;
}
.tih-hero__title {
    font-size: clamp(2.6rem, 7vw, 5rem);
    font-weight: 800; line-height: 1.05;
    color: #fff; margin: 0 0 1rem;
}
.tih-hero__sub {
    font-size: clamp(.95rem, 2vw, 1.15rem);
    opacity: .85; max-width: 560px; line-height: 1.65; margin: 0 0 2rem;
}
.tih-hero__cta { display: flex; flex-wrap: wrap; gap: .75rem; justify-content: center; }
.tih-hero__btn { font-size: 1rem; min-height: 50px; padding: 0 2rem; border-radius: 6px; }
.tih-hero__btn--primary  { background: var(--tih-volcano,#c0392b); color: #fff; }
.tih-hero__btn--primary:hover { background: #96281b; color: #fff; }
.tih-hero__btn--secondary {
    background: transparent; color: #fff;
    border: 2px solid rgba(255,255,255,.5);
}
.tih-hero__btn--secondary:hover { background: rgba(255,255,255,.1); }
.tih-hero__scroll-hint {
    position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
    font-size: 1.2rem; opacity: .4;
    animation: tih-bounce 2s infinite;
}
@keyframes tih-bounce {
    0%,100% { transform: translateX(-50%) translateY(0); }
    50%      { transform: translateX(-50%) translateY(6px); }
}

/* ── Shared section wrapper ── */
.tih-home-section { padding: 4rem 0; }
.tih-home-section:nth-child(even) { background: #fafafa; }
.tih-home-section__inner { max-width: 1100px; margin: 0 auto; padding: 0 1.25rem; }
.tih-home-section__head {
    display: flex; justify-content: space-between; align-items: baseline;
    margin-bottom: 1.75rem;
}
.tih-home-section__title {
    font-size: 1.5rem; color: var(--tih-ocean,#1a4a6b); margin: 0;
}
.tih-home-section__see-all {
    font-size: .85rem; font-weight: 700;
    color: var(--tih-ocean,#1a4a6b); text-decoration: none;
}
.tih-home-section__see-all:hover { text-decoration: underline; }

/* ── Category grid ── */
.tih-home-cats__grid {
    list-style: none; margin: 0; padding: 0;
    display: grid; grid-template-columns: repeat(4,1fr); gap: 1.25rem;
}
@media (max-width: 700px) {
    .tih-home-cats__grid { grid-template-columns: repeat(2,1fr); }
}
.tih-home-cat__link {
    display: flex; flex-direction: column; align-items: flex-start;
    text-decoration: none; color: inherit;
    border-radius: var(--tih-radius,8px); padding: 1.5rem 1.25rem;
    transition: transform .2s, box-shadow .2s;
}
.tih-home-cat__link:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.1); }
.tih-home-cat--spirits .tih-home-cat__link { background: #2c2c2c; color: #fff; }
.tih-home-cat--beauty  .tih-home-cat__link { background: #c9a96e; color: #fff; }
.tih-home-cat--gourmet .tih-home-cat__link { background: var(--tih-forest,#2d6a4f); color: #fff; }
.tih-home-cat--craft   .tih-home-cat__link { background: var(--tih-ocean,#1a4a6b); color: #fff; }
.tih-home-cat__icon  { font-size: 2.2rem; line-height: 1; margin-bottom: .6rem; }
.tih-home-cat__name  { font-size: 1.1rem; font-weight: 700; margin: 0 0 .35rem; }
.tih-home-cat__desc  { font-size: .8rem; opacity: .85; margin: 0 0 .75rem; line-height: 1.45; flex: 1; }
.tih-home-cat__count { font-size: .75rem; opacity: .7; font-weight: 600; }

/* ── Article cards ── */
.tih-home-articles__grid {
    list-style: none; margin: 0; padding: 0;
    display: grid; grid-template-columns: repeat(4,1fr); gap: 1.25rem;
}
@media (max-width: 860px) {
    .tih-home-articles__grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 480px) {
    .tih-home-articles__grid { grid-template-columns: 1fr; }
}
.tih-home-article-card__link {
    display: flex; flex-direction: column;
    text-decoration: none; color: inherit;
    border-radius: var(--tih-radius,8px);
    border: 1px solid rgba(0,0,0,.08);
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
    height: 100%;
}
.tih-home-article-card__link:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,.1); transform: translateY(-2px);
}
.tih-home-article-card__img,
.tih-home-article-card__placeholder {
    width: 100%; aspect-ratio: 4/3; object-fit: cover; display: block;
}
.tih-home-article-card__placeholder {
    display: flex; align-items: center; justify-content: center;
    font-size: 2.5rem; background: var(--tih-sand,#f5e6c8);
}
.tih-home-article-card__body {
    padding: .9rem; display: flex; flex-direction: column; gap: .3rem; flex: 1;
}
.tih-home-article-card__title {
    font-size: .9rem; margin: .3rem 0 0; line-height: 1.35; font-weight: 700;
}
.tih-home-article-card__excerpt {
    font-size: .8rem; color: #666; line-height: 1.45; margin: .2rem 0 0; flex: 1;
}
.tih-home-article-card__island {
    font-size: .75rem; color: #888; margin-top: auto; padding-top: .4rem;
}

/* ── Island chips (horizontal scroll) ── */
.tih-home-islands__track {
    list-style: none; margin: 0; padding: .5rem 0 1rem;
    display: flex; gap: 1rem;
    overflow-x: auto; scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
}
.tih-home-islands__track::-webkit-scrollbar { height: 4px; }
.tih-home-islands__track::-webkit-scrollbar-thumb { background: var(--tih-ocean,#1a4a6b); border-radius: 2px; }
.tih-home-island-chip { scroll-snap-align: start; flex-shrink: 0; width: 140px; }
.tih-home-island-chip__link {
    display: flex; flex-direction: column; align-items: center; gap: .4rem;
    text-decoration: none; color: inherit;
    border-radius: var(--tih-radius,8px); padding: .75rem .5rem;
    border: 1px solid rgba(0,0,0,.08);
    transition: background .2s;
    text-align: center;
}
.tih-home-island-chip__link:hover { background: var(--tih-sand,#f5e6c8); }
.tih-home-island-chip__img,
.tih-home-island-chip__placeholder {
    width: 72px; height: 72px; border-radius: 50%; object-fit: cover;
    display: flex; align-items: center; justify-content: center;
}
.tih-home-island-chip__placeholder { background: var(--tih-sand,#f5e6c8); font-size: 1.8rem; }
.tih-home-island-chip__name  { font-size: .8rem; font-weight: 700; line-height: 1.2; }
.tih-home-island-chip__count { font-size: .7rem; color: #888; }

/* ── How to Buy CTA ── */
.tih-home-buyee {
    background: linear-gradient(135deg, var(--tih-ocean,#1a4a6b) 0%, #0d2e43 100%);
    color: #fff;
}
.tih-home-buyee .tih-home-section__inner { padding-top: 0; padding-bottom: 0; }
.tih-home-buyee__inner {
    display: grid; grid-template-columns: 1fr auto;
    gap: 3rem; align-items: center;
    padding: 3.5rem 0;
}
@media (max-width: 700px) {
    .tih-home-buyee__inner { grid-template-columns: 1fr; gap: 1.5rem; }
    .tih-home-buyee__steps { display: none; }
}
.tih-home-buyee__text h2 {
    font-size: 1.5rem; color: var(--tih-sand,#f5e6c8); margin: 0 0 .75rem;
}
.tih-home-buyee__text p { opacity: .85; line-height: 1.65; margin: 0 0 1.5rem; max-width: 500px; }
.tih-home-buyee__btn {
    background: var(--tih-volcano,#c0392b); color: #fff;
    font-size: .95rem; min-height: 48px; padding: 0 1.75rem; border-radius: 6px;
}
.tih-home-buyee__btn:hover { background: #96281b; color: #fff; }
.tih-home-buyee__steps {
    list-style: none; margin: 0; padding: 0;
    display: flex; flex-direction: column; gap: .75rem;
}
.tih-home-buyee__steps li {
    display: flex; align-items: center; gap: .75rem;
    font-size: .9rem; opacity: .85;
}
.tih-home-buyee__steps span {
    width: 1.8rem; height: 1.8rem; border-radius: 50%;
    background: rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem; font-weight: 700; flex-shrink: 0;
}
</style>

<?php get_footer(); ?>
