<?php
/**
 * Visual Buyer's Assistant — Buyee Bridge
 *
 * Auto-appended to single product pages.
 * Also available as shortcode: [tih_buyee_bridge]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'tih_buyee_bridge', 'tih_render_buyee_bridge' );

// Auto-inject after product content
add_filter( 'the_content', 'tih_inject_buyee_bridge' );

function tih_inject_buyee_bridge( string $content ): string {
    if ( ! is_singular( 'products' ) || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }
    return $content . tih_render_buyee_bridge();
}

function tih_render_buyee_bridge( array $atts = [], ?string $inner = null ): string {
    if ( ! is_singular( 'products' ) && ! isset( $atts['post_id'] ) ) {
        return '';
    }

    $post_id    = isset( $atts['post_id'] ) ? absint( $atts['post_id'] ) : get_the_ID();
    $jp_keyword = get_field( 'jp_keyword',      $post_id );
    $price_yen  = get_field( 'price_yen',       $post_id );
    $visual     = get_field( 'visual_id_guide', $post_id );
    $buyee_url  = get_field( 'buyee_url',       $post_id );
    $rare_stock = (bool) get_field( 'rare_stock', $post_id );

    // Auto-flag craft category products as rare if field not explicitly set
    if ( ! $rare_stock ) {
        $terms = wp_get_post_terms( $post_id, 'theme_category' );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) && $terms[0]->slug === 'craft' ) {
            $rare_stock = true;
        }
    }

    if ( ! $jp_keyword ) {
        return '';
    }

    // Build search URL — rawurlencode handles multi-byte characters correctly
    $search_url = 'https://buyee.jp/rakuten/search/?query=' . rawurlencode( $jp_keyword );
    $final_url  = ! empty( $buyee_url ) ? $buyee_url : $search_url;

    ob_start();
    ?>
<aside class="tih-buyee-bridge" aria-label="Buyee Purchase Guide">

    <h3 class="tih-buyee-bridge__title">
        <span aria-hidden="true">🛒</span>
        How to Buy — Visual Buyer's Assistant
    </h3>

    <?php if ( $visual ) : ?>
    <div class="tih-buyee-bridge__section">
        <h4><span aria-hidden="true">👁️</span> Visual Match Guide</h4>
        <p><?php echo wp_kses_post( nl2br( esc_html( $visual ) ) ); ?></p>
    </div>
    <?php endif; ?>

    <?php if ( $price_yen ) : ?>
    <div class="tih-buyee-bridge__section">
        <h4><span aria-hidden="true">💴</span> Reference Price</h4>
        <p class="tih-buyee-bridge__price">
            ¥<?php echo number_format( (int) $price_yen ); ?>
            <span class="tih-buyee-bridge__price-note">(approx. — actual prices vary)</span>
        </p>
    </div>
    <?php endif; ?>

    <div class="tih-buyee-bridge__section tih-buyee-bridge__actions">
        <h4><span aria-hidden="true">🔍</span> Search on Buyee</h4>

        <div class="tih-buyee-bridge__kw-row">
            <span>Japanese keyword:</span>
            <code class="tih-buyee-bridge__kw" id="tih-kw-<?php echo esc_attr( $post_id ); ?>">
                <?php echo esc_html( $jp_keyword ); ?>
            </code>
            <button
                class="tih-btn tih-buyee-bridge__copy"
                data-target="#tih-kw-<?php echo esc_attr( $post_id ); ?>"
                aria-label="Copy Japanese keyword to clipboard"
            >Copy for Search</button>
        </div>

        <a
            href="<?php echo esc_url( $final_url ); ?>"
            class="tih-btn tih-buyee-bridge__buyee-btn"
            target="_blank"
            rel="noopener noreferrer"
        >🛍️ Find on Buyee / Rakuten</a>

        <?php if ( $rare_stock ) : ?>
        <div class="tih-buyee-bridge__rare">
            <span aria-hidden="true">⚠️</span>
            <strong>Limited stock — verify availability</strong> before purchasing.
            Niijima glass and rare island spirits sell out without notice.
        </div>
        <?php endif; ?>

        <p class="tih-buyee-bridge__tip">
            <span aria-hidden="true">🌐</span>
            <strong>Language tip:</strong> Buyee is in Japanese.
            Use <strong>Google Translate</strong> (top-right of your browser), then paste
            the copied keyword into Buyee's search box.
        </p>
    </div>

</aside>
    <?php
    return ob_get_clean();
}

// Enqueue clipboard JS on product singles
add_action( 'wp_footer', 'tih_buyee_bridge_footer_js' );

function tih_buyee_bridge_footer_js(): void {
    if ( ! is_singular( 'products' ) ) {
        return;
    }
    ?>
<script>
(function () {
    'use strict';
    document.querySelectorAll('.tih-buyee-bridge__copy').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var el = document.querySelector(btn.dataset.target);
            if (!el) return;
            var text = el.textContent.trim();
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
        });
    });
}());
</script>
<style>
.tih-buyee-bridge {
    background: var(--tih-sand, #f5e6c8);
    border: 2px solid var(--tih-ocean, #1a4a6b);
    border-radius: var(--tih-radius, 8px);
    padding: 1.5rem;
    margin: 2.5rem 0;
}
.tih-buyee-bridge__title {
    color: var(--tih-ocean, #1a4a6b);
    font-size: 1.2rem;
    margin: 0 0 1.25rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.tih-buyee-bridge__section {
    margin-bottom: 1.25rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid rgba(0,0,0,.1);
}
.tih-buyee-bridge__section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.tih-buyee-bridge__section h4 {
    font-size: .8rem;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #666;
    margin: 0 0 .5rem;
    display: flex;
    align-items: center;
    gap: .35rem;
}
.tih-buyee-bridge__kw-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .5rem;
    margin-bottom: .75rem;
}
.tih-buyee-bridge__kw {
    font-size: 1.5rem;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: .2rem .6rem;
}
.tih-buyee-bridge__copy {
    background: var(--tih-ocean, #1a4a6b);
    color: #fff;
    font-size: .85rem;
    min-height: 44px;
    padding: 0 1rem;
    border-radius: 4px;
}
.tih-buyee-bridge__copy:hover  { background: #0d2e43; }
.tih-buyee-bridge__copy.copied { background: var(--tih-forest, #2d6a4f); }
.tih-buyee-bridge__buyee-btn {
    display: inline-flex;
    background: var(--tih-volcano, #c0392b);
    color: #fff;
    font-size: 1rem;
    min-height: 48px;
    padding: 0 1.5rem;
    border-radius: 6px;
    margin-bottom: .75rem;
}
.tih-buyee-bridge__buyee-btn:hover { background: #96281b; color: #fff; }
.tih-buyee-bridge__price {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--tih-ocean, #1a4a6b);
    margin: 0;
}
.tih-buyee-bridge__price-note {
    font-size: .8rem;
    font-weight: 400;
    color: #888;
    margin-left: .3rem;
}
.tih-buyee-bridge__rare {
    background: #fff3cd;
    border: 1px solid #f39c12;
    border-radius: 4px;
    padding: .6rem .9rem;
    font-size: .85rem;
    margin-bottom: .75rem;
    display: flex;
    gap: .5rem;
    align-items: flex-start;
}
.tih-buyee-bridge__rare strong { color: #c0392b; }
.tih-buyee-bridge__tip {
    font-size: .85rem;
    color: #555;
    background: #fff;
    padding: .75rem;
    border-radius: 4px;
    margin: 0;
    display: flex;
    gap: .5rem;
    align-items: flex-start;
}
</style>
    <?php
}
