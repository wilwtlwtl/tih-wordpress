<?php
/**
 * Series navigation, Buyee guide, and copy-button JS for Treasures.
 */

defined( 'ABSPATH' ) || exit;

// Series badge — prepended before post content
add_filter( 'the_content', 'tih_inject_series_badge', 8 );

// Series Buyee guide + prev/next nav — appended after recommendations
add_filter( 'the_content', 'tih_inject_series_nav', 25 );

// Copy-button JS for VIG sections in treasure content
add_action( 'wp_footer', 'tih_series_footer_js' );

/* -----------------------------------------------------------------------
   Series badge
----------------------------------------------------------------------- */
function tih_inject_series_badge( string $content ): string {
    if ( ! is_singular( 'treasures' ) || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    $post_id = get_the_ID();
    $terms   = wp_get_post_terms( $post_id, 'theme_category' );
    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        return $content;
    }

    $term   = $terms[0];
    $series = tih_get_series_posts( $term->term_id );
    if ( empty( $series ) ) {
        return $content;
    }

    $pos = 1;
    foreach ( $series as $i => $p ) {
        if ( $p->ID === $post_id ) {
            $pos = $i + 1;
            break;
        }
    }
    $total = count( $series );

    $badge = sprintf(
        '<div class="tih-series-badge tih-series-badge--%s">%s &middot; Vol.%d of %d</div>',
        esc_attr( $term->slug ),
        esc_html( $term->name ),
        $pos,
        $total
    );

    return $badge . $content;
}

/* -----------------------------------------------------------------------
   Series Buyee guide + prev/next nav
----------------------------------------------------------------------- */
function tih_inject_series_nav( string $content ): string {
    if ( ! is_singular( 'treasures' ) || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    $post_id   = get_the_ID();
    $terms     = wp_get_post_terms( $post_id, 'theme_category' );
    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        return $content;
    }

    $term      = $terms[0];
    $series    = tih_get_series_posts( $term->term_id );

    $prev = null;
    $next = null;
    foreach ( $series as $i => $p ) {
        if ( $p->ID === $post_id ) {
            if ( $i > 0 )                    $prev = $series[ $i - 1 ];
            if ( $i < count( $series ) - 1 ) $next = $series[ $i + 1 ];
            break;
        }
    }

    $buyee_kw = get_field( 'buyee_keyword',   $post_id );
    $price    = get_field( 'price_guide',     $post_id );
    $pname_jp = get_field( 'product_name_jp', $post_id );

    ob_start();
    ?>

<?php if ( $buyee_kw || $price ) : ?>
<div class="tih-series-buyee" aria-label="Where to Buy">
    <h3 class="tih-series-buyee__title"><span aria-hidden="true">🛒</span> Where to Buy</h3>
    <?php if ( $pname_jp ) : ?>
    <p class="tih-series-buyee__jp"><?php echo esc_html( $pname_jp ); ?></p>
    <?php endif; ?>
    <?php if ( $price ) : ?>
    <p class="tih-series-buyee__price">
        Price guide: <strong><?php echo esc_html( $price ); ?></strong>
    </p>
    <?php endif; ?>
    <?php if ( $buyee_kw ) : ?>
    <div class="tih-series-buyee__kw-row">
        <span>Search keyword:</span>
        <code class="tih-series-buyee__kw" id="tih-skw-<?php echo esc_attr( $post_id ); ?>">
            <?php echo esc_html( $buyee_kw ); ?>
        </code>
        <button
            class="tih-btn tih-series-buyee__copy"
            data-target="#tih-skw-<?php echo esc_attr( $post_id ); ?>"
            aria-label="Copy keyword to clipboard"
            type="button"
        >Copy</button>
        <a href="<?php echo esc_url( 'https://buyee.jp/rakuten/search/?query=' . rawurlencode( $buyee_kw ) ); ?>"
           class="tih-btn tih-series-buyee__buyee-btn"
           target="_blank" rel="noopener noreferrer">Search on Buyee &rarr;</a>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<nav class="tih-series-nav" aria-label="Series navigation">
    <div class="tih-series-nav__inner">
        <?php if ( $prev ) : ?>
        <a href="<?php echo esc_url( get_permalink( $prev->ID ) ); ?>"
           class="tih-series-nav__link tih-series-nav__link--prev">
            <span class="tih-series-nav__dir">&larr; Previous</span>
            <span class="tih-series-nav__title"><?php echo esc_html( $prev->post_title ); ?></span>
        </a>
        <?php else : ?>
        <span class="tih-series-nav__link tih-series-nav__link--empty"></span>
        <?php endif; ?>

        <a href="<?php echo esc_url( get_term_link( $term ) ); ?>"
           class="tih-series-nav__all">
            All <?php echo esc_html( $term->name ); ?> &rarr;
        </a>

        <?php if ( $next ) : ?>
        <a href="<?php echo esc_url( get_permalink( $next->ID ) ); ?>"
           class="tih-series-nav__link tih-series-nav__link--next">
            <span class="tih-series-nav__dir">Next &rarr;</span>
            <span class="tih-series-nav__title"><?php echo esc_html( $next->post_title ); ?></span>
        </a>
        <?php else : ?>
        <span class="tih-series-nav__link tih-series-nav__link--empty"></span>
        <?php endif; ?>
    </div>
</nav>

    <?php
    return $content . ob_get_clean();
}

/* -----------------------------------------------------------------------
   Returns series posts in menu_order for a given category term.
   Includes drafts so navigation works in development.
----------------------------------------------------------------------- */
function tih_get_series_posts( int $term_id ): array {
    $all = get_posts( [
        'post_type'      => 'treasures',
        'post_status'    => [ 'publish', 'draft' ],
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'tax_query'      => [ [
            'taxonomy' => 'theme_category',
            'field'    => 'term_id',
            'terms'    => $term_id,
        ] ],
    ] );
    // Only include posts that are part of the numbered series (menu_order 1–99)
    return array_values( array_filter( $all, fn( $p ) => $p->menu_order > 0 ) );
}

/* -----------------------------------------------------------------------
   Copy-button JS for .tih-vig__copy buttons inside article content
----------------------------------------------------------------------- */
function tih_series_footer_js(): void {
    if ( ! is_singular( 'treasures' ) ) {
        return;
    }
    ?>
<script>
(function () {
    'use strict';
    // VIG copy buttons (in post content)
    document.querySelectorAll('.tih-vig__copy').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var block = btn.closest('.tih-vig__kw-block');
            var el    = block ? block.querySelector('code') : null;
            if (!el) return;
            tihCopy(btn, el.textContent.trim());
        });
    });
    // Series buyee copy buttons (injected by PHP filter)
    document.querySelectorAll('.tih-series-buyee__copy').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var el = document.querySelector(btn.dataset.target);
            if (!el) return;
            tihCopy(btn, el.textContent.trim());
        });
    });
    function tihCopy(btn, text) {
        var done = function () {
            var orig = btn.textContent;
            btn.textContent = '✓ Copied!';
            btn.classList.add('copied');
            setTimeout(function () {
                btn.textContent = orig;
                btn.classList.remove('copied');
            }, 2000);
        };
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(done);
        } else {
            var ta = document.createElement('textarea');
            ta.value = text;
            ta.style.cssText = 'position:fixed;opacity:0';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            done();
        }
    }
}());
</script>
    <?php
}
