<?php
/**
 * Template Name: How to Buy
 * How to Buy page — Buyee / ZenMarket proxy shopping guide for overseas buyers.
 */

get_header(); ?>

<main id="main" class="tih-htb">

    <header class="tih-htb__hero">
        <div class="tih-htb__hero-inner">
            <span class="tih-htb__hero-icon" aria-hidden="true">🛒</span>
            <h1 class="tih-htb__hero-title">How to Buy Tokyo Island Products</h1>
            <p class="tih-htb__hero-sub">
                Products from Tokyo's volcanic islands aren't on Amazon. Here's how to get them
                delivered anywhere in the world — in three steps.
            </p>
        </div>
    </header>

    <div class="tih-htb__body">

        <!-- ── Why proxy? ─────────────────────────────────────────── -->
        <section class="tih-htb__section tih-htb__section--intro">
            <h2>Why Do I Need a Proxy Service?</h2>
            <p>
                Most Tokyo Island products are sold exclusively on <strong>Japanese domestic marketplaces</strong>
                (Rakuten, Yahoo! Shopping, direct island shops) that don't ship internationally.
                A proxy service buys on your behalf, inspects the item, and forwards it to you worldwide.
                The two most reliable options for island products are <strong>Buyee</strong> and
                <strong>ZenMarket</strong>.
            </p>
            <div class="tih-htb__compare">
                <div class="tih-htb__compare-card tih-htb__compare-card--buyee">
                    <h3>Buyee</h3>
                    <ul>
                        <li>✅ Direct Rakuten &amp; Yahoo! Shopping integration</li>
                        <li>✅ No membership fee — pay per purchase</li>
                        <li>✅ English interface throughout</li>
                        <li>✅ Instant checkout from product page</li>
                        <li>⚠️ Service fee: 300 ¥ + 5% of item price</li>
                    </ul>
                    <a href="https://buyee.jp" class="tih-btn tih-htb__ext-link"
                       target="_blank" rel="noopener noreferrer">
                        Visit Buyee →
                    </a>
                </div>
                <div class="tih-htb__compare-card tih-htb__compare-card--zen">
                    <h3>ZenMarket</h3>
                    <ul>
                        <li>✅ Covers more Japanese shops (incl. Yahoo! Auctions)</li>
                        <li>✅ Free storage up to 45 days</li>
                        <li>✅ Consolidate multiple orders into one shipment</li>
                        <li>✅ English &amp; Chinese support</li>
                        <li>⚠️ Service fee: 300 ¥ per order line</li>
                    </ul>
                    <a href="https://zenmarket.jp" class="tih-btn tih-htb__ext-link"
                       target="_blank" rel="noopener noreferrer">
                        Visit ZenMarket →
                    </a>
                </div>
            </div>
        </section>

        <!-- ── Step-by-step: Buyee ───────────────────────────────── -->
        <section class="tih-htb__section">
            <h2><span aria-hidden="true">🛍️</span> Buying via Buyee — Step by Step</h2>
            <ol class="tih-htb__steps">
                <li class="tih-htb__step">
                    <span class="tih-htb__step-num">1</span>
                    <div class="tih-htb__step-body">
                        <h3>Create a free Buyee account</h3>
                        <p>
                            Go to <strong>buyee.jp</strong> and register with your email.
                            No credit card is required until you place an order.
                        </p>
                    </div>
                </li>
                <li class="tih-htb__step">
                    <span class="tih-htb__step-num">2</span>
                    <div class="tih-htb__step-body">
                        <h3>Find your product on this site</h3>
                        <p>
                            Browse our <a href="<?php echo esc_url( home_url( '/spirits/' ) ); ?>">Spirits</a>,
                            <a href="<?php echo esc_url( home_url( '/beauty/' ) ); ?>">Beauty</a>,
                            <a href="<?php echo esc_url( home_url( '/gourmet/' ) ); ?>">Gourmet</a>,
                            or <a href="<?php echo esc_url( home_url( '/craft/' ) ); ?>">Craft</a> categories.
                            Each product page has a <strong>"How to Buy"</strong> panel with the Japanese keyword
                            and a direct Buyee search link.
                        </p>
                    </div>
                </li>
                <li class="tih-htb__step">
                    <span class="tih-htb__step-num">3</span>
                    <div class="tih-htb__step-body">
                        <h3>Copy the Japanese keyword</h3>
                        <p>
                            Click <strong>"Copy for Search"</strong> on the product page.
                            This copies the exact Japanese characters (e.g. <code>青酎</code>) needed to find
                            the product. You cannot find these items by searching in English.
                        </p>
                    </div>
                </li>
                <li class="tih-htb__step">
                    <span class="tih-htb__step-num">4</span>
                    <div class="tih-htb__step-body">
                        <h3>Search on Buyee with the Japanese keyword</h3>
                        <p>
                            Either click the <strong>"Find on Buyee / Rakuten"</strong> button
                            (which pre-fills the search), or paste the copied keyword into Buyee's search bar.
                            Use the <strong>Visual Match Guide</strong> on the product page to identify the
                            correct item from search results.
                        </p>
                    </div>
                </li>
                <li class="tih-htb__step">
                    <span class="tih-htb__step-num">5</span>
                    <div class="tih-htb__step-body">
                        <h3>Place your order</h3>
                        <p>
                            Add to cart on Buyee, enter your shipping address, and pay.
                            Buyee purchases the item from the Japanese seller, stores it in their
                            warehouse, and ships to you. Typical delivery: <strong>7–21 days</strong>
                            depending on shipping method chosen.
                        </p>
                    </div>
                </li>
            </ol>
        </section>

        <!-- ── Step-by-step: ZenMarket ──────────────────────────── -->
        <section class="tih-htb__section">
            <h2><span aria-hidden="true">📦</span> Buying via ZenMarket — Step by Step</h2>
            <ol class="tih-htb__steps">
                <li class="tih-htb__step">
                    <span class="tih-htb__step-num">1</span>
                    <div class="tih-htb__step-body">
                        <h3>Create a ZenMarket account</h3>
                        <p>Register at <strong>zenmarket.jp</strong>. Your account comes with
                        a personal Japanese address (used for all your purchases).</p>
                    </div>
                </li>
                <li class="tih-htb__step">
                    <span class="tih-htb__step-num">2</span>
                    <div class="tih-htb__step-body">
                        <h3>Paste a product URL or search by keyword</h3>
                        <p>
                            Paste any Rakuten or Yahoo! Shopping URL directly into ZenMarket's
                            "Order by URL" box, or use the Japanese keyword to search.
                        </p>
                    </div>
                </li>
                <li class="tih-htb__step">
                    <span class="tih-htb__step-num">3</span>
                    <div class="tih-htb__step-body">
                        <h3>Add to cart and top up your balance</h3>
                        <p>
                            ZenMarket uses a prepaid balance. Transfer funds (PayPal, card, bank transfer)
                            before placing the order.
                        </p>
                    </div>
                </li>
                <li class="tih-htb__step">
                    <span class="tih-htb__step-num">4</span>
                    <div class="tih-htb__step-body">
                        <h3>Consolidate and ship</h3>
                        <p>
                            If you ordered multiple products, ZenMarket can consolidate them into one
                            parcel — saving significantly on international shipping.
                            Free storage for up to <strong>45 days</strong>.
                        </p>
                    </div>
                </li>
            </ol>
        </section>

        <!-- ── Language tip ─────────────────────────────────────── -->
        <section class="tih-htb__section tih-htb__section--tip">
            <h2><span aria-hidden="true">🌐</span> Navigating Japanese Sites</h2>
            <div class="tih-htb__tip-grid">
                <div class="tih-htb__tip-card">
                    <h3>Use Google Translate in your browser</h3>
                    <p>
                        In Chrome, right-click any Japanese page and choose
                        <strong>"Translate to English"</strong>. This works on Rakuten product pages,
                        seller descriptions, and Buyee's checkout flow.
                    </p>
                </div>
                <div class="tih-htb__tip-card">
                    <h3>Always search with Japanese keywords</h3>
                    <p>
                        Japanese products are indexed in Japanese. Searching <em>"Aogashima shochu"</em>
                        returns almost nothing; searching <em>「青酎」</em> returns the actual product.
                        Use the <strong>Copy for Search</strong> button on each product page.
                    </p>
                </div>
                <div class="tih-htb__tip-card">
                    <h3>Reference price vs. actual price</h3>
                    <p>
                        The ¥ price on our product pages is a <strong>reference price</strong> based on
                        typical Rakuten listings. Actual marketplace prices vary. For rare items
                        (Niijima glass, Aochu), prices can be significantly higher when stock is low.
                    </p>
                </div>
                <div class="tih-htb__tip-card">
                    <h3>Customs and import duties</h3>
                    <p>
                        Shochu (spirits) over 22% ABV may be subject to import duty in your country.
                        Check your local customs rules. Most food and beauty products under ¥10,000
                        pass through customs duty-free in most countries.
                    </p>
                </div>
            </div>
        </section>

        <!-- ── Shipping methods ─────────────────────────────────── -->
        <section class="tih-htb__section">
            <h2><span aria-hidden="true">✈️</span> Shipping Methods Comparison</h2>
            <div class="tih-htb__table-wrap">
                <table class="tih-htb__table">
                    <thead>
                        <tr>
                            <th>Method</th>
                            <th>Transit Time</th>
                            <th>Tracking</th>
                            <th>Best For</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>EMS</strong></td>
                            <td>5–10 days</td>
                            <td>Full</td>
                            <td>Fragile items (glass), urgent orders</td>
                        </tr>
                        <tr>
                            <td><strong>DHL / FedEx</strong></td>
                            <td>3–7 days</td>
                            <td>Full</td>
                            <td>High-value items, USA/Europe</td>
                        </tr>
                        <tr>
                            <td><strong>SAL (Surface Air Lifted)</strong></td>
                            <td>2–4 weeks</td>
                            <td>Partial</td>
                            <td>Non-urgent, cost-sensitive orders</td>
                        </tr>
                        <tr>
                            <td><strong>Surface Mail</strong></td>
                            <td>4–8 weeks</td>
                            <td>Limited</td>
                            <td>Heavy/bulky, lowest cost</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="tih-htb__note">
                ⚠️ Liquids (shochu, oils) require <strong>ground or sea shipping</strong> for air freight.
                Some carriers prohibit spirits entirely. Buyee and ZenMarket display available options
                automatically at checkout based on your cart contents.
            </p>
        </section>

        <!-- ── FAQ ──────────────────────────────────────────────── -->
        <section class="tih-htb__section">
            <h2><span aria-hidden="true">❓</span> Frequently Asked Questions</h2>
            <dl class="tih-htb__faq">
                <dt>Do I need to speak Japanese?</dt>
                <dd>No. Buyee and ZenMarket both have full English interfaces. Use Google Translate
                    for Japanese product pages, and copy Japanese keywords from our product pages
                    instead of typing them.</dd>

                <dt>What payment methods are accepted?</dt>
                <dd>Buyee: Visa, Mastercard, PayPal, Alipay, bank transfer.
                    ZenMarket: PayPal, Visa, Mastercard, bank transfer, cryptocurrency.</dd>

                <dt>Can I return or exchange items?</dt>
                <dd>Returns are handled by the original Japanese seller's policy.
                    Most island producers do not accept returns on opened food or spirits.
                    Buyee offers optional purchase protection insurance for defective or
                    misdescribed items.</dd>

                <dt>Why can't I find the product after searching?</dt>
                <dd>Island products sell out frequently and listings are removed when stock runs out.
                    Try alternative spellings (shown on the product page), check back later, or
                    use ZenMarket to search Yahoo! Auctions for second-hand stock of collectible items
                    like Niijima glass.</dd>

                <dt>Is Aochu available internationally?</dt>
                <dd>Yes, occasionally. Aochu (青酎) has appeared on Rakuten in limited quantities.
                    It sells out within hours of restocking. Set up a Buyee alert with the keyword
                    「青酎」to be notified when new stock appears.</dd>
            </dl>
        </section>

        <!-- ── CTA ──────────────────────────────────────────────── -->
        <section class="tih-htb__cta">
            <h2>Ready to explore?</h2>
            <p>Browse products by category — each page has the Japanese keyword and Buyee link ready.</p>
            <nav class="tih-htb__cta-nav" aria-label="Category links">
                <a href="<?php echo esc_url( home_url( '/spirits/' ) ); ?>"
                   class="tih-btn tih-htb__cta-btn tih-htb__cta-btn--spirits">🍶 Spirits</a>
                <a href="<?php echo esc_url( home_url( '/beauty/' ) ); ?>"
                   class="tih-btn tih-htb__cta-btn tih-htb__cta-btn--beauty">🌸 Beauty</a>
                <a href="<?php echo esc_url( home_url( '/gourmet/' ) ); ?>"
                   class="tih-btn tih-htb__cta-btn tih-htb__cta-btn--gourmet">🐟 Gourmet</a>
                <a href="<?php echo esc_url( home_url( '/craft/' ) ); ?>"
                   class="tih-btn tih-htb__cta-btn tih-htb__cta-btn--craft">🟢 Craft</a>
            </nav>
        </section>

    </div><!-- /.tih-htb__body -->

</main>

<style>
/* ── How to Buy page ── */
.tih-htb__hero {
    background: linear-gradient(135deg, var(--tih-ocean,#1a4a6b) 0%, #0d2e43 100%);
    color: #fff;
    padding: 3.5rem 1.5rem 3rem;
    text-align: center;
    border-radius: 0 0 var(--tih-radius,8px) var(--tih-radius,8px);
    margin-bottom: 0;
}
.tih-htb__hero-icon { display: block; font-size: 3rem; line-height: 1; margin-bottom: .5rem; }
.tih-htb__hero-title { font-size: 2rem; margin: 0 0 .75rem; color: #fff; }
.tih-htb__hero-sub {
    max-width: 600px; margin: 0 auto; font-size: 1.05rem; opacity: .9; line-height: 1.6;
}

.tih-htb__body { max-width: 860px; margin: 0 auto; padding: 2.5rem 1rem 4rem; }

.tih-htb__section { margin-bottom: 3rem; padding-bottom: 3rem;
    border-bottom: 1px solid rgba(0,0,0,.08); }
.tih-htb__section:last-child { border-bottom: none; }
.tih-htb__section h2 { font-size: 1.35rem; color: var(--tih-ocean,#1a4a6b);
    margin: 0 0 1.25rem; display: flex; align-items: center; gap: .5rem; }

/* Compare cards */
.tih-htb__compare { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-top: 1rem; }
@media (max-width: 580px) { .tih-htb__compare { grid-template-columns: 1fr; } }
.tih-htb__compare-card {
    border: 2px solid; border-radius: var(--tih-radius,8px); padding: 1.25rem;
}
.tih-htb__compare-card--buyee { border-color: var(--tih-volcano,#c0392b); }
.tih-htb__compare-card--zen   { border-color: var(--tih-forest,#2d6a4f); }
.tih-htb__compare-card h3 { font-size: 1.1rem; margin: 0 0 .75rem; }
.tih-htb__compare-card ul { list-style: none; margin: 0 0 1rem; padding: 0; font-size: .9rem; }
.tih-htb__compare-card ul li { padding: .25rem 0; }
.tih-htb__ext-link { font-size: .9rem; }
.tih-htb__compare-card--buyee .tih-htb__ext-link {
    background: var(--tih-volcano,#c0392b); color: #fff; }
.tih-htb__compare-card--buyee .tih-htb__ext-link:hover { background: #96281b; color: #fff; }
.tih-htb__compare-card--zen .tih-htb__ext-link {
    background: var(--tih-forest,#2d6a4f); color: #fff; }
.tih-htb__compare-card--zen .tih-htb__ext-link:hover { background: #1a3d2c; color: #fff; }

/* Steps */
.tih-htb__steps { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 1.25rem; }
.tih-htb__step { display: flex; gap: 1rem; align-items: flex-start; }
.tih-htb__step-num {
    flex-shrink: 0; width: 2.2rem; height: 2.2rem; border-radius: 50%;
    background: var(--tih-ocean,#1a4a6b); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 1rem;
}
.tih-htb__step-body h3 { margin: 0 0 .35rem; font-size: 1rem; }
.tih-htb__step-body p  { margin: 0; font-size: .92rem; line-height: 1.55; color: #444; }
.tih-htb__step-body a  { color: var(--tih-ocean,#1a4a6b); font-weight: 600; }

/* Intro section background */
.tih-htb__section--intro { background: var(--tih-sand,#f5e6c8);
    border-radius: var(--tih-radius,8px); padding: 1.5rem; border-bottom: none; margin-bottom: 2.5rem; }
.tih-htb__section--intro h2 { margin-top: 0; }

/* Language tip grid */
.tih-htb__section--tip { background: #f0f7ff; border-radius: var(--tih-radius,8px);
    padding: 1.5rem; border-bottom: none; margin-bottom: 2.5rem; }
.tih-htb__tip-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: .5rem; }
@media (max-width: 580px) { .tih-htb__tip-grid { grid-template-columns: 1fr; } }
.tih-htb__tip-card { background: #fff; border-radius: 6px; padding: 1rem; font-size: .9rem; }
.tih-htb__tip-card h3 { font-size: .95rem; margin: 0 0 .4rem; color: var(--tih-ocean,#1a4a6b); }
.tih-htb__tip-card p { margin: 0; color: #444; line-height: 1.5; }

/* Table */
.tih-htb__table-wrap { overflow-x: auto; margin: .5rem 0 1rem; }
.tih-htb__table { width: 100%; border-collapse: collapse; font-size: .9rem; }
.tih-htb__table th {
    background: var(--tih-ocean,#1a4a6b); color: #fff;
    padding: .6rem .9rem; text-align: left; font-weight: 600;
}
.tih-htb__table td { padding: .6rem .9rem; border-bottom: 1px solid #e5e5e5; }
.tih-htb__table tr:last-child td { border-bottom: none; }
.tih-htb__table tr:nth-child(even) td { background: #f9f9f9; }
.tih-htb__note { font-size: .85rem; color: #666; background: #fff3cd;
    border: 1px solid #f39c12; border-radius: 4px; padding: .75rem 1rem; margin-top: .5rem; }

/* FAQ */
.tih-htb__faq { margin: 0; }
.tih-htb__faq dt {
    font-weight: 700; color: var(--tih-ocean,#1a4a6b); margin: 1.25rem 0 .3rem;
    font-size: .97rem;
}
.tih-htb__faq dt:first-child { margin-top: 0; }
.tih-htb__faq dd { margin: 0; font-size: .92rem; color: #444; line-height: 1.55; }

/* CTA */
.tih-htb__cta {
    background: linear-gradient(135deg, #1a4a6b 0%, #0d2e43 100%);
    color: #fff; border-radius: var(--tih-radius,8px); padding: 2.5rem 1.5rem;
    text-align: center; margin-top: 2rem;
}
.tih-htb__cta h2 { color: var(--tih-sand,#f5e6c8); margin: 0 0 .5rem; }
.tih-htb__cta p  { opacity: .85; margin: 0 0 1.5rem; }
.tih-htb__cta-nav { display: flex; flex-wrap: wrap; justify-content: center; gap: .75rem; }
.tih-htb__cta-btn { font-size: .95rem; }
.tih-htb__cta-btn--spirits { background: var(--tih-lava,#2c2c2c); color: #fff; }
.tih-htb__cta-btn--beauty  { background: #c9a96e; color: #fff; }
.tih-htb__cta-btn--gourmet { background: var(--tih-forest,#2d6a4f); color: #fff; }
.tih-htb__cta-btn--craft   { background: var(--tih-ocean,#1a4a6b); color: #fff;
    border: 2px solid rgba(255,255,255,.3); }
.tih-htb__cta-btn:hover { opacity: .85; }
</style>

<?php get_sidebar(); get_footer(); ?>
