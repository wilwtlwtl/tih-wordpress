<?php
/**
 * Seed: Treasure articles (Vol.1 × 4 categories) + new products
 * (#1 Jonarie, #2 Kumayo Tsubaki, #3 Kusaya pairing, #4 Niijima Glass Vol.1)
 *
 * Admin trigger: /wp-admin/?tih_seed_treasures=1
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( ! isset( $_GET['tih_seed_treasures'] ) || '1' !== $_GET['tih_seed_treasures'] ) return;
    $result = tih_seed_treasures_and_products();
    wp_die(
        '<h1>TIH Treasure Seed</h1><pre style="font-size:13px">'
        . esc_html( implode( "\n", $result ) )
        . '</pre><p><a href="' . esc_url( admin_url() ) . '">&larr; Dashboard</a></p>'
    );
} );

function tih_seed_treasures_and_products(): array {
    $log = [];

    /* ---------------------------------------------------------------
       Helper: fetch island ID by slug
    --------------------------------------------------------------- */
    $island_id = function ( string $slug ): ?int {
        $p = get_posts( [ 'post_type' => 'islands', 'name' => $slug,
                          'post_status' => 'any', 'numberposts' => 1 ] );
        return empty( $p ) ? null : $p[0]->ID;
    };

    /* ---------------------------------------------------------------
       #1  New product: 情け嶋 ジョナリー (Jonarie) — Spirits / Niijima
    --------------------------------------------------------------- */
    $niijima_id = $island_id( 'niijima' );

    $log = array_merge( $log, tih_upsert_product( [
        'title'    => 'Jonarie — Niijima Barley Shochu (情け嶋 ジョナリー)',
        'slug'     => 'jonarie-niijima-barley-shochu',
        'excerpt'  => 'Light, clean barley shochu from Niijima — the gateway spirit to Tokyo Island GI culture.',
        'content'  => '<p>Jonarie (ジョナリー) is produced by the sole distillery on Niijima island, using local barley and the island\'s mineral-rich spring water. It is deliberately crafted as an approachable entry point to Tokyo Island shochu — lighter and cleaner than the wild-yeast intensity of Aogashima\'s Aochu, with a fresh cereal character and a crisp, dry finish.</p>
<p>The brand name "情け嶋" (Nakejima / Jonarie) refers to an archaic poetic name for Niijima, evoking the island\'s gentle, humane character (情け = compassion). The 720ml clear bottle with its understated label has become a recognisable symbol of Niijima craftsmanship.</p>
<h3>Tasting Notes</h3>
<ul>
<li><strong>Nose:</strong> Fresh barley, light citrus zest, subtle mineral note</li>
<li><strong>Palate:</strong> Clean, dry, medium-light body</li>
<li><strong>Finish:</strong> Short, refreshing, faintly saline</li>
<li><strong>Best served:</strong> Mizuwari (with water) or on the rocks</li>
</ul>
<p><strong>GI certified</strong> under <em>Tokyo Shimazake</em> designation.</p>',
        'island_id' => $niijima_id,
        'category'  => 'spirits',
        'jp_kw'     => '情け嶋 ジョナリー',
        'price'     => 2500,
        'visual'    => "Clear glass bottle, 720ml, slim cylinder\nLabel: white/cream background with blue wave motif and kanji「情け嶋」in dark ink\nNo box typically — sometimes wrapped in tissue\nSimilar shape to a standard sake bottle",
        'rare'      => false,
    ] ) );

    /* ---------------------------------------------------------------
       #2  New product: 利島 椿油 神代椿 — Beauty / Toshima
    --------------------------------------------------------------- */
    $toshima_id = $island_id( 'toshima' );

    $log = array_merge( $log, tih_upsert_product( [
        'title'    => 'Jodai Tsubaki — Ancient Camellia Oil of Toshima (神代椿)',
        'slug'     => 'jodai-tsubaki-oil-toshima',
        'excerpt'  => 'Single-origin cold-pressed oil from Toshima\'s oldest camellia groves — the purest expression of J-Beauty camellia tradition.',
        'content'  => '<p>Jodai Tsubaki (神代椿 — "god-age camellia") is cold-pressed from camellia seeds harvested from Toshima\'s oldest trees, some of which are estimated to be over 200 years old. The advanced age of the trees concentrates oleic acid content to over 82%, surpassing even argan oil (typically 43–49%) and making Jodai Tsubaki one of the most biocompatible oils in the J-Beauty arsenal.</p>
<p>The pressing method is stone-mill cold pressing (石臼圧搾), a technique unique to Toshima that avoids any heat or chemical solvent, preserving the oil\'s full polyphenol and vitamin E content.</p>
<h3>Key Properties</h3>
<ul>
<li><strong>Oleic acid:</strong> 82%+ (vs argan oil: 43–49%)</li>
<li><strong>Method:</strong> Cold-pressed, stone mill, no heat or solvents</li>
<li><strong>Shelf life:</strong> 2 years unopened; 6 months after opening</li>
<li><strong>Uses:</strong> Hair oil, face oil, body oil, nail treatment</li>
</ul>
<p>300 years of sustainable camellia cultivation have made Toshima a UNESCO candidate for agricultural heritage recognition.</p>',
        'island_id' => $toshima_id,
        'category'  => 'beauty',
        'jp_kw'     => '利島 椿油 神代椿',
        'price'     => 3200,
        'visual'    => "Dark amber glass dropper bottle (50ml or 100ml)\nLabel: ivory/white with pressed camellia flower illustration in muted tones\nGold or dark metal dropper cap\nOften presented in a white gift box with camellia motif and gold foil text",
        'rare'      => false,
    ] ) );

    /* ---------------------------------------------------------------
       Treasure articles × 4 categories
    --------------------------------------------------------------- */
    $aogashima_id = $island_id( 'aogashima' );
    $hachijo_id   = $island_id( 'hachijojima' );

    $treasures = [
        /* ---- #1 Spirits Vol.1 ---- */
        [
            'title'      => 'The Mugi-Koji Revolution: How Tokyo Islands Reinvented Shochu',
            'slug'       => 'mugi-koji-revolution-tokyo-island-shochu',
            'excerpt'    => 'GI-certified Tokyo Shimazake, the barley-koji manufacturing secret, and why whisky lovers are switching to island shochu.',
            'content'    => '<p>In 2020, Japan\'s National Tax Agency awarded Tokyo Island Shochu a rare <strong>Geographic Indication (GI)</strong> — the same protection afforded to Champagne and Bordeaux. The designation, officially called <em>Tokyo Shimazake</em> (東京島酒), covers shochu and awamori produced on nine of the eleven Tokyo Islands, cementing their status as one of Japan\'s most distinctive artisanal spirits categories.</p>

<p>The secret is in the koji. While mainland shochu producers typically use black or white koji strains (imported from elsewhere), island distillers — isolated by geography for centuries — developed their own wild yeast and koji cultures unique to each island\'s microclimate. On Aogashima, each of the island\'s handful of distiller families uses a yeast strain evolved independently in their cellar for generations. The result is what the industry calls <em>terroir-shochu</em>: no two islands, and sometimes no two producers on the same island, make the same spirit.</p>

<h2>Why Whisky Lovers Are Paying Attention</h2>
<p>The pivot from whisky to island shochu among international spirits collectors follows a simple logic: rarity, craft, and story. Aogashima\'s Aochu is produced in quantities of perhaps 2,000–3,000 bottles per year by all producers combined. Niijima\'s Jonarie (情け嶋 ジョナリー) ships perhaps 500 cases annually. Compare this to Scotch whisky distilleries producing millions of litres, and the appeal becomes clear.</p>

<p>The flavour profile also translates well. Mugi (barley) shochu at 25–30% ABV, served mizuwari (with water) or on the rocks, carries the mineral complexity that whisky drinkers crave, without the heavy wood ageing — a different dimension, not a lesser one.</p>

<h2>The Starter Lineup</h2>
<ul>
<li><strong>Aochu (青酎)</strong> — Aogashima. Wild yeast, volcanic minerality. The connoisseur\'s choice.</li>
<li><strong>Jonarie (情け嶋 ジョナリー)</strong> — Niijima. Cleaner, lighter. The gateway spirit.</li>
<li><strong>Hachijo Shochu Toko (東光)</strong> — Hachijojima. Yellow koji, fruity, approachable.</li>
</ul>',
            'category'   => 'spirits',
            'island_ids' => array_filter( [ $aogashima_id, $niijima_id ] ),
        ],
        /* ---- #2 Beauty Vol.1 ---- */
        [
            'title'      => 'Beyond Argan Oil: Why Toshima Camellia Oil Is J-Beauty\'s Best-Kept Secret',
            'slug'       => 'beyond-argan-oil-toshima-camellia',
            'excerpt'    => 'Toshima\'s camellia oil has 82%+ oleic acid — outperforming argan oil — and 300 years of sustainable island history.',
            'content'    => '<p>The global J-Beauty boom has brought Korean sheet masks and Tokyo skincare serums to pharmacy shelves from London to Los Angeles. But one of Japan\'s most extraordinary skincare ingredients remains almost entirely unknown outside specialist circles: the cold-pressed camellia oil of Toshima island, produced from wild trees that have covered the island\'s slopes for three centuries.</p>

<p>The numbers tell the story. Argan oil — the reigning queen of luxury oils — contains approximately 43–49% oleic acid, the monounsaturated fatty acid that makes it compatible with human skin. Toshima camellia oil (椿油) contains <strong>80–85% oleic acid</strong>. This extraordinary concentration makes it not just comparable to the skin\'s natural sebum, but almost identical to it — meaning it absorbs without residue, nourishes without clogging pores, and leaves hair and skin with a luminosity that synthetic alternatives cannot replicate.</p>

<h2>300 Years of Sustainable Cultivation</h2>
<p>What makes Toshima unique is not just the chemistry of its oil but the continuity of its cultivation. The island\'s camellia trees have been managed by the same families across generations, with harvest practices that prioritise long-term forest health over short-term yield maximisation. No pesticides, no irrigation, no soil amendment — the trees grow in the island\'s volcanic soil as they have done for centuries, producing seeds that fall naturally and are gathered by hand.</p>

<p>This model — which today would be called regenerative agriculture — has been so successful that Toshima is currently under consideration for UNESCO\'s Globally Important Agricultural Heritage Systems (GIAHS) designation.</p>

<h2>How to Use It</h2>
<ul>
<li><strong>Hair:</strong> Apply 2–3 drops to damp hair before blow-drying. Prevents split ends, adds mirror shine.</li>
<li><strong>Face:</strong> 2–3 drops on clean, slightly damp skin. Morning or evening. No rinsing required.</li>
<li><strong>Body:</strong> Post-shower, while skin is still warm and slightly moist.</li>
<li><strong>Nails:</strong> Massage into cuticles daily.</li>
</ul>',
            'category'   => 'beauty',
            'island_ids' => array_filter( [ $toshima_id ] ),
        ],
        /* ---- #3 Gourmet Vol.1 ---- */
        [
            'title'      => 'The Blue Cheese of the Ocean: A Beginner\'s Guide to Kusaya',
            'slug'       => 'blue-cheese-ocean-kusaya-guide',
            'excerpt'    => 'Kusaya — Tokyo\'s 400-year-old fermented fish — is the umami equivalent of blue cheese: polarising on first sniff, transcendent on first taste.',
            'content'    => '<p>Imagine Roquefort. Now imagine it came from the sea, was fermented for 20 hours in a 400-year-old brine, and then sun-dried on the volcanic shores of a Japanese island 300 km from Tokyo. That is kusaya (くさや) — arguably the most challenging, and most rewarding, flavour in all of Japanese island cuisine.</p>

<p>The name literally means "smelly thing" (臭い → kusai → kusaya). This is not marketing spin. Kusaya\'s aroma — produced by the anaerobic fermentation of fish in a brine called <em>kusaya-jiru</em> (くさや汁) — is notoriously powerful. It has been measured at airport customs dogs\' alert thresholds. Hotels on Hachijojima politely ask guests not to cook it in rooms. And yet: when grilled over charcoal until the exterior caramelises to a lacquer-like glaze, the flavour that emerges is one of the most profound expressions of umami in any cuisine.</p>

<h2>The 400-Year-Old Living Brine</h2>
<p>The kusaya-jiru (fermentation brine) is the heart of kusaya culture. The oldest brines on Hachijojima are estimated to be 200–400 years old — living microbial ecosystems maintained across generations by the same production families. Like a sourdough starter, the brine is never fully discarded: fish are cycled through it, enriching and evolving its complexity. Each family\'s brine has its own distinct microbial signature. The older the brine, the more complex — and valuable — the result.</p>

<p>This living-culture dimension is what sets kusaya apart from other preserved fish products. It is not simply dried fish: it is fish that carries the biological memory of centuries.</p>

<h2>Overseas Availability: The Bottled Shortcut</h2>
<p>Whole dried kusaya is difficult to ship internationally (the aroma creates border control complications). However, <strong>bottled kusaya paste and sauce</strong> (くさや瓶詰め) bypasses these restrictions entirely. The flavour is nearly identical to grilled kusaya, in a format that works as a condiment, pasta ingredient, or umami booster.</p>

<!-- ULTIMATE_PAIRING_PLACEHOLDER -->

<h2>How to Eat It</h2>
<ol>
<li>Grill whole kusaya over charcoal or gas until exterior is caramelised (about 4–5 min per side).</li>
<li>Tear apart with fingers and eat with cold shochu mizuwari.</li>
<li>For bottled kusaya: spread on crackers, add to pasta, or mix into butter for an extraordinary compound butter.</li>
</ol>',
            'category'   => 'gourmet',
            'island_ids' => array_filter( [ $hachijo_id, $niijima_id ] ),
        ],
        /* ---- #4 Craft Vol.1 ---- */
        [
            'title'      => 'The Emerald of the Pacific: Why Niijima Glass Exists Nowhere Else on Earth',
            'slug'       => 'emerald-pacific-niijima-glass-koga-stone',
            'excerpt'    => 'Koga stone volcanic tuff — found only on Niijima and in Murano, Italy — creates an olive-green glass colour that cannot be replicated anywhere else.',
            'content'    => '<p>In the world of art glass, colour is chemistry. The deep ruby of Bohemian glass comes from gold salts. Murano\'s famous <em>vetro sommerso</em> layering relies on precision-engineered silica formulas. And the unmistakable smoky olive-green of Niijima glass? It comes from <strong>Koga stone</strong> (抗火石) — a volcanic tuff found in commercial quantities in only two places on earth: Niijima island, Tokyo, and the volcanic flanks near Murano, Italy.</p>

<p>Koga stone is a geological rarity: an amorphous volcanic glass (not crystalline rock) that melts at unusually low temperatures and, when fired, releases silica and trace minerals in a combination that produces a colour and translucency that glassblowers using conventional silica sand simply cannot replicate. The olive-green is not added; it emerges from the material itself.</p>

<h2>The Niijima Glass Village</h2>
<p>The craft was established on Niijima in the 1970s when Japanese glass artist Niyoko Ikuta and American glassblower Tom Buechner developed techniques for working with Koga stone. Today, a small community of island-based glassblowers — many trained at the island\'s purpose-built glass art centre — continues the tradition.</p>

<p>Annual production is extremely limited. Most glassblowers on Niijima produce fewer than a few hundred finished pieces per year. Gallery sales on the island account for the majority of production; pieces that reach Tokyo gallery shops command significant premiums. International availability through conventional retail channels is effectively zero.</p>

<h2>What to Buy</h2>
<ul>
<li><strong>Guinomi (ぐい呑み)</strong> — Sake cups, ¥3,000–¥8,000. The most accessible entry point.</li>
<li><strong>Vases</strong> — ¥8,000–¥30,000. Sculptural works with strong collector appeal.</li>
<li><strong>Large art pieces</strong> — ¥50,000+. Investment-grade works by named artists.</li>
</ul>

<div style="background:#fff8e1;border:1px solid #f39c12;border-radius:4px;padding:12px;margin:16px 0;">
    <strong>⚠️ Stock Warning:</strong> Niijima glass is produced in extremely limited quantities.
    Individual pieces sell out without notice. Always verify current availability before purchasing.
</div>',
            'category'   => 'craft',
            'island_ids' => array_filter( [ $niijima_id ] ),
        ],
    ];

    foreach ( $treasures as $t ) {
        $log = array_merge( $log, tih_upsert_treasure( $t ) );
    }

    /* ---------------------------------------------------------------
       Verify counts
    --------------------------------------------------------------- */
    $log[] = '';
    $log[] = '=== Summary ===';
    $log[] = 'Treasures (published): ' . wp_count_posts( 'treasures' )->publish;
    $log[] = 'Products  (published): ' . wp_count_posts( 'products' )->publish;

    return $log;
}

/* -----------------------------------------------------------------------
   Internal helpers
----------------------------------------------------------------------- */

function tih_upsert_product( array $d ): array {
    $log = [];

    $existing = get_posts( [ 'post_type' => 'products', 'name' => $d['slug'],
                              'post_status' => 'any', 'numberposts' => 1 ] );
    if ( ! empty( $existing ) ) {
        $log[] = "[SKIP] Product already exists: {$d['title']}";
        return $log;
    }

    $term = get_term_by( 'slug', $d['category'], 'theme_category' );
    if ( ! $term ) {
        $names = [ 'spirits' => 'Spirits', 'beauty' => 'Beauty',
                   'gourmet' => 'Gourmet', 'craft'  => 'Craft' ];
        $ins     = wp_insert_term( $names[ $d['category'] ] ?? ucfirst( $d['category'] ),
                                   'theme_category', [ 'slug' => $d['category'] ] );
        $term_id = is_wp_error( $ins ) ? null : $ins['term_id'];
    } else {
        $term_id = $term->term_id;
    }

    $pid = wp_insert_post( [
        'post_type'    => 'products',
        'post_status'  => 'publish',
        'post_title'   => $d['title'],
        'post_name'    => $d['slug'],
        'post_excerpt' => $d['excerpt'],
        'post_content' => $d['content'],
    ], true );

    if ( is_wp_error( $pid ) ) {
        $log[] = "[ERROR] {$d['title']}: " . $pid->get_error_message();
        return $log;
    }

    if ( $term_id ) wp_set_post_terms( $pid, [ $term_id ], 'theme_category' );

    update_field( 'jp_keyword',      $d['jp_kw'],  $pid );
    update_field( 'price_yen',       $d['price'],  $pid );
    update_field( 'visual_id_guide', $d['visual'], $pid );
    update_field( 'buyee_url',       '',           $pid );
    update_field( 'rare_stock',      $d['rare'] ? 1 : 0, $pid );

    if ( ! empty( $d['island_id'] ) ) {
        update_field( 'featured_island', [ $d['island_id'] ], $pid );
        $cur     = get_field( 'related_products', $d['island_id'] ) ?: [];
        $cur_ids = array_map( fn($p) => is_object($p) ? $p->ID : (int)$p, $cur );
        if ( ! in_array( $pid, $cur_ids, true ) ) {
            update_field( 'related_products', array_merge( $cur_ids, [ $pid ] ), $d['island_id'] );
        }
    }

    $log[] = "[OK] Product: {$d['title']} (ID: $pid)";
    return $log;
}

function tih_upsert_treasure( array $d ): array {
    $log = [];

    $existing = get_posts( [ 'post_type' => 'treasures', 'name' => $d['slug'],
                              'post_status' => 'any', 'numberposts' => 1 ] );
    if ( ! empty( $existing ) ) {
        $log[] = "[SKIP] Treasure already exists: {$d['title']}";
        return $log;
    }

    $term = get_term_by( 'slug', $d['category'], 'theme_category' );
    $term_id = $term ? $term->term_id : null;

    $tid = wp_insert_post( [
        'post_type'    => 'treasures',
        'post_status'  => 'publish',
        'post_title'   => $d['title'],
        'post_name'    => $d['slug'],
        'post_excerpt' => $d['excerpt'],
        'post_content' => $d['content'],
    ], true );

    if ( is_wp_error( $tid ) ) {
        $log[] = "[ERROR] {$d['title']}: " . $tid->get_error_message();
        return $log;
    }

    if ( $term_id ) wp_set_post_terms( $tid, [ $term_id ], 'theme_category' );

    // Link to featured islands
    if ( ! empty( $d['island_ids'] ) ) {
        update_field( 'featured_island', array_values( $d['island_ids'] ), $tid );

        // Back-link: add treasure to island's related_treasures
        foreach ( $d['island_ids'] as $iid ) {
            $cur     = get_field( 'related_treasures', $iid ) ?: [];
            $cur_ids = array_map( fn($t) => is_object($t) ? $t->ID : (int)$t, $cur );
            if ( ! in_array( $tid, $cur_ids, true ) ) {
                update_field( 'related_treasures', array_merge( $cur_ids, [ $tid ] ), $iid );
            }
        }
    }

    $log[] = "[OK] Treasure: {$d['title']} (ID: $tid)";
    return $log;
}
