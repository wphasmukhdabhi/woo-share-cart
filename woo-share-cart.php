<?php
error_log('✅ wsc-functions.php loaded');

/**
 * Plugin Name: WooCommerce Share Cart
 * Description: Share your WooCommerce cart via unique link.
 * Version: 1.0
 * Author: Hasmukh Dabhi
 */

if (!defined('ABSPATH')) {
    exit;
}

// Activation + Deactivation
register_activation_hook(__FILE__, 'wsc_activate_plugin');
register_deactivation_hook(__FILE__, 'wsc_deactivate_plugin');

function wsc_activate_plugin()
{
    require_once plugin_dir_path(__FILE__) . 'includes/share-cart-db.php';
    wsc_create_share_cart_table();
    flush_rewrite_rules();
}

function wsc_deactivate_plugin()
{
    flush_rewrite_rules();
}

// Load if WooCommerce active
// if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
require_once plugin_dir_path(__FILE__) . 'includes/wsc-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/share-cart-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/share-cart-db.php';
// }
