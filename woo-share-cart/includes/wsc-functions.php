<?php

// Add button to cart page after table
// add_action('woocommerce_after_cart_table', 'wsc_add_share_button');
add_action('woocommerce_after_cart_table', 'wsc_add_share_button');
add_action('woocommerce_cart_actions', 'wsc_add_share_button', 20);
add_action('wsc_test_hook', 'wsc_add_share_button');

function wsc_add_share_button()
{
    echo '<p>Share Cart Button Function Loaded</p>';
    echo '<div style="margin-top:20px;padding:15px;border:2px dashed #0073aa;background:#f9f9f9;">';

    echo '<form method="post">';
    echo '<input type="submit" class="button" name="wsc_generate_link" value="Generate Shareable Cart Link" />';
    echo '</form>';

    if (isset($_POST['wsc_generate_link'])) {
        if (WC()->cart->is_empty()) {
            echo '<p style="color:red;">⚠️ Your cart is empty. Please add products before sharing.</p>';
            echo '</div>';
            return;
        }

        $share_url = wsc_store_cart_and_generate_url();
        echo '<p><strong>📎 Share this link:</strong> <a href="' . esc_url($share_url) . '" target="_blank">' . esc_html($share_url) . '</a></p>';
    }

    echo '</div>';
}
// Shortcode for Elementor or manual placement
function wsc_cart_share_shortcode()
{
    ob_start();
    wsc_add_share_button(); // reuse main button function
    return ob_get_clean();
}
add_shortcode('wsc_share_cart_button', 'wsc_cart_share_shortcode');
