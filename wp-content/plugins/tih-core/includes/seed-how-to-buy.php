<?php
/**
 * Seed: "How to Buy" static page
 * Creates the page with the correct template assignment.
 *
 * Admin trigger: /wp-admin/?tih_seed_htb=1
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( ! isset( $_GET['tih_seed_htb'] ) || '1' !== $_GET['tih_seed_htb'] ) return;

    $result = tih_seed_how_to_buy_page();
    wp_die(
        '<h1>TIH — How to Buy Page</h1><pre style="font-size:13px">'
        . esc_html( $result )
        . '</pre><p><a href="' . esc_url( get_permalink( get_page_by_path( 'how-to-buy' ) ) ) . '">View page →</a></p>'
        . '<p><a href="' . esc_url( admin_url() ) . '">&larr; Dashboard</a></p>'
    );
} );

function tih_seed_how_to_buy_page(): string {
    $existing = get_page_by_path( 'how-to-buy' );

    if ( $existing ) {
        // Update template assignment in case it was missing
        update_post_meta( $existing->ID, '_wp_page_template', 'page-how-to-buy.php' );
        return "[UPDATED] How to Buy page already exists (ID: {$existing->ID}) — template re-confirmed.";
    }

    $page_id = wp_insert_post( [
        'post_type'    => 'page',
        'post_status'  => 'publish',
        'post_title'   => 'How to Buy',
        'post_name'    => 'how-to-buy',
        'post_content' => '',
        'menu_order'   => 10,
    ], true );

    if ( is_wp_error( $page_id ) ) {
        return '[ERROR] ' . $page_id->get_error_message();
    }

    update_post_meta( $page_id, '_wp_page_template', 'page-how-to-buy.php' );

    return "[OK] How to Buy page created (ID: $page_id) at /how-to-buy/";
}
