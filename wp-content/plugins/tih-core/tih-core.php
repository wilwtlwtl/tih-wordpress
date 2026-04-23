<?php
/**
 * Plugin Name: TIH Core
 * Plugin URI:  https://tokyo-island-heritage.com
 * Description: Custom Post Types, ACF Fields, Buyee Bridge, and core functionality for Tokyo Island Heritage
 * Version:     1.0.0
 * Author:      TIH Team
 * Text Domain: tih
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */

defined( 'ABSPATH' ) || exit;

define( 'TIH_VERSION',    '1.0.0' );
define( 'TIH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TIH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

foreach ( [
    'cpt-registration',
    'taxonomy-registration',
    'acf-fields',
    'buyee-bridge',
    'seo-meta',
    'recommendations',
    'test-data',
    'seed-all-islands',
    'seed-treasures',
] as $file ) {
    require_once TIH_PLUGIN_DIR . 'includes/' . $file . '.php';
}

// Activation: flush rewrite rules after CPT/taxonomy registration
register_activation_hook( __FILE__, function () {
    tih_register_cpts();
    tih_register_taxonomies();
    tih_seed_terms();
    flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function () {
    flush_rewrite_rules();
} );
