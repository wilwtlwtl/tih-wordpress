<?php
/**
 * Test data seed: 青ヶ島 (Aogashima) island + 青酎 (Aochu) product
 *
 * Trigger (admin only): /wp-admin/?tih_seed=1
 * WP-CLI:               wp eval 'require TIH_PLUGIN_DIR . "includes/test-data.php"; var_dump(tih_seed_test_data());'
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( ! isset( $_GET['tih_seed'] ) || '1' !== $_GET['tih_seed'] ) {
        return;
    }

    $result = tih_seed_test_data();

    wp_die(
        '<h1>TIH Test Data Seed</h1><pre style="font-size:14px">'
        . esc_html( implode( "\n", $result ) )
        . '</pre>'
        . '<p><a href="' . esc_url( admin_url() ) . '">&larr; Back to Dashboard</a></p>'
    );
} );

function tih_seed_test_data(): array {
    $log = [];

    // ----------------------------------------------------------------
    // 1. Island: 青ヶ島 / Aogashima
    // ----------------------------------------------------------------
    $existing = get_posts( [
        'post_type'   => 'islands',
        'name'        => 'aogashima',
        'post_status' => 'any',
        'numberposts' => 1,
    ] );

    if ( ! empty( $existing ) ) {
        $island_id = $existing[0]->ID;
        $log[]     = "[SKIP] Island already exists: Aogashima (ID: {$island_id})";
    } else {
        $island_id = wp_insert_post( [
            'post_type'    => 'islands',
            'post_status'  => 'publish',
            'post_title'   => 'Aogashima',
            'post_name'    => 'aogashima',
            'post_excerpt' => "Tokyo's most remote inhabited island — a double-caldera volcano with a population under 200 and one of Japan's rarest artisanal spirits.",
            'post_content' => '<p>Aogashima (青ヶ島) is the southernmost inhabited island of the Izu Islands chain, located approximately 358 km south of central Tokyo. With fewer than 200 residents, it is the most sparsely populated municipality in all of Tokyo metropolitan area. The island is geologically remarkable: a smaller active inner caldera sits within a larger extinct outer caldera, creating a surreal landscape of concentric volcanic ridges cloaked in dense subtropical forest.</p>

<p>Access is notoriously difficult. A small helicopter service from Hachijojima operates just a few times per week, and the ferry is frequently cancelled due to rough Pacific swells — giving the island the local nickname <em>kakurega no shima</em> (隠れ家の島, "the hideaway island"). This inaccessibility has preserved Aogashima\'s culture almost intact, making it a living museum of traditional island life.</p>

<p>The island is internationally known among spirits connoisseurs for <strong>Aochu (青酎)</strong>, a handcrafted shochu distilled in micro-batches using wild indigenous yeast unique to each family distillery. Because the yeast differs household by household, no two bottles of Aochu are identical — each is an unrepeatable expression of volcanic soil, Pacific air, and centuries of island craft. Aochu carries Japan\'s prestigious Geographic Indication (GI) certification under the <em>Tokyo Shimazake</em> designation.</p>',
        ], true );

        if ( is_wp_error( $island_id ) ) {
            return [ '[ERROR] Failed to create island: ' . $island_id->get_error_message() ];
        }

        update_field( 'island_description',
            "Aogashima is Tokyo's most remote inhabited island — a double-caldera volcano with a population under 200. Famously inaccessible, it is home to Aochu shochu, one of Japan's rarest GI-certified artisanal spirits.",
            $island_id
        );
        update_field( 'island_map_link', 'https://maps.google.com/?q=%E9%9D%92%E3%82%B1%E5%B3%B6%2C%E6%9D%B1%E4%BA%AC%E9%83%BD', $island_id );

        $log[] = "[OK] Created island: Aogashima (ID: {$island_id})";
        $log[] = "     URL: " . get_permalink( $island_id );
    }

    // ----------------------------------------------------------------
    // 2. Product: 青酎 / Aochu
    // ----------------------------------------------------------------
    $existing_p = get_posts( [
        'post_type'   => 'products',
        'name'        => 'aochu-aogashima-wild-yeast-shochu',
        'post_status' => 'any',
        'numberposts' => 1,
    ] );

    if ( ! empty( $existing_p ) ) {
        $product_id = $existing_p[0]->ID;
        $log[]      = "[SKIP] Product already exists: Aochu (ID: {$product_id})";
    } else {
        // Ensure 'spirits' term exists
        $spirits = get_term_by( 'slug', 'spirits', 'theme_category' );
        if ( ! $spirits ) {
            $ins     = wp_insert_term( 'Spirits', 'theme_category', [ 'slug' => 'spirits' ] );
            $term_id = is_wp_error( $ins ) ? null : $ins['term_id'];
        } else {
            $term_id = $spirits->term_id;
        }

        $product_id = wp_insert_post( [
            'post_type'    => 'products',
            'post_status'  => 'publish',
            'post_title'   => 'Aochu — Aogashima Wild Yeast Shochu (青酎)',
            'post_name'    => 'aochu-aogashima-wild-yeast-shochu',
            'post_excerpt' => 'Wild yeast shochu distilled in micro-batches on Aogashima. GI-certified under Tokyo Shimazake. Each bottle uniquely flavoured by the distiller\'s ancestral yeast.',
            'post_content' => '<p>Aochu (青酎) is the legendary shochu of Aogashima, distilled in micro-batches by the island\'s handful of resident distillers. Unlike commercial shochu, Aochu is crafted using wild <em>koji</em> and indigenous yeast strains that have evolved independently in each distillery for generations. The result is a spirit of startling complexity — floral and earthy, with volcanic minerality and a finish that lingers like ocean salt.</p>

<p>Each bottle is typically numbered and traceable to a specific producer. Because annual production is limited to a few hundred bottles per distiller, Aochu consistently sells out at Tokyo specialty liquor shops within days of arrival. International buyers have virtually no direct access — <strong>Buyee and Rakuten Ichiba remain the most practical overseas purchase channels</strong>.</p>

<h3>Tasting Notes</h3>
<ul>
<li><strong>Base:</strong> Barley (麦) with wild island koji</li>
<li><strong>ABV:</strong> 25–30%</li>
<li><strong>Nose:</strong> Wild flowers, volcanic stone, dried island herbs</li>
<li><strong>Palate:</strong> Silky texture, umami depth, subtle natural sweetness</li>
<li><strong>Finish:</strong> Long, mineral, faintly saline</li>
</ul>

<p><strong>GI certified:</strong> Aochu carries Japan\'s Geographic Indication designation under <em>Tokyo Shimazake</em>, confirming its authentic Aogashima origin.</p>',
        ], true );

        if ( is_wp_error( $product_id ) ) {
            return array_merge( $log, [ '[ERROR] Failed to create product: ' . $product_id->get_error_message() ] );
        }

        if ( $term_id ) {
            wp_set_post_terms( $product_id, [ $term_id ], 'theme_category' );
        }

        update_field( 'jp_keyword',      '青酎',   $product_id );
        update_field( 'price_yen',       3200,     $product_id );
        update_field( 'visual_id_guide',
            "Clear or frosted glass bottle (720ml or 300ml)\nLabel: white/cream background with bold black or dark-blue kanji「青酎」\nMany editions include a small silhouette of the double-caldera on the label\nSome bottles wrapped in natural straw cord around the neck\nGift box editions: plain white carton with minimal ink printing",
            $product_id
        );
        update_field( 'buyee_url',       '',       $product_id );
        update_field( 'featured_island', [ $island_id ], $product_id );

        $log[] = "[OK] Created product: Aochu (ID: {$product_id})";
        $log[] = "     URL: " . get_permalink( $product_id );
    }

    // ----------------------------------------------------------------
    // 3. Link island ← → product (island side)
    // ----------------------------------------------------------------
    $cur_products = get_field( 'related_products', $island_id ) ?: [];
    $cur_ids      = array_map( fn( $p ) => is_object( $p ) ? $p->ID : (int) $p, $cur_products );

    if ( ! in_array( $product_id, $cur_ids, true ) ) {
        $cur_ids[] = $product_id;
        update_field( 'related_products', $cur_ids, $island_id );
        $log[] = "[OK] Linked Aochu → Aogashima (island.related_products)";
    } else {
        $log[] = "[SKIP] Island→Product link already exists";
    }

    // ----------------------------------------------------------------
    // 4. Verification
    // ----------------------------------------------------------------
    $v_island_products = get_field( 'related_products', $island_id ) ?: [];
    $v_product_islands = get_field( 'featured_island',  $product_id ) ?: [];

    $v_ip_ids = array_map( fn( $p ) => is_object( $p ) ? $p->ID : (int) $p, $v_island_products );
    $v_pi_ids = array_map( fn( $i ) => is_object( $i ) ? $i->ID : (int) $i, $v_product_islands );

    $log[] = '';
    $log[] = '=== Cross-link Verification ===';
    $log[] = 'Island → Product : ' . ( in_array( $product_id, $v_ip_ids, true ) ? '✓ PASS' : '✗ FAIL' );
    $log[] = 'Product → Island : ' . ( in_array( $island_id,  $v_pi_ids, true ) ? '✓ PASS' : '✗ FAIL' );
    $log[] = '';
    $log[] = 'Island  URL : ' . get_permalink( $island_id );
    $log[] = 'Product URL : ' . get_permalink( $product_id );
    $log[] = 'Buyee search: https://buyee.jp/rakuten/search/?query=' . rawurlencode( '青酎' );

    return $log;
}
