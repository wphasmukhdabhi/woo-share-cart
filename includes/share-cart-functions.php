<?php

// Save cart + generate URL
function wsc_store_cart_and_generate_url() {
    $cart_items = WC()->cart->get_cart();
    $data = [];

    foreach ($cart_items as $item) {
        $data[] = [
            'id' => $item['product_id'],
            'qty' => $item['quantity']
        ];
    }

    $cart_json = json_encode($data);
    $cart_key = substr(md5(time() . rand()), 0, 8);

    global $wpdb;
    $table = $wpdb->prefix . 'shared_carts';
    $wpdb->insert($table, [
        'cart_key' => $cart_key,
        'cart_data' => $cart_json
    ]);

    return home_url('/cart/share/' . $cart_key);
}

// Add rewrite rules
add_action('init', 'wsc_add_rewrite_rules');
function wsc_add_rewrite_rules() {
    add_rewrite_rule('^cart/share/([^/]+)?', 'index.php?wsc_cart_key=$matches[1]', 'top');
}

// Add query var
add_filter('query_vars', function ($vars) {
    $vars[] = 'wsc_cart_key';
    return $vars;
});

// Handle shared cart URL
add_action('template_redirect', 'wsc_load_cart_from_url');
function wsc_load_cart_from_url() {
    $key = get_query_var('wsc_cart_key');
    if (!$key) return;

    global $wpdb;
    $table = $wpdb->prefix . 'shared_carts';
    $row = $wpdb->get_row($wpdb->prepare("SELECT cart_data FROM $table WHERE cart_key = %s", $key));

    if ($row) {
        $cart_data = json_decode($row->cart_data, true);
        if (is_array($cart_data)) {
            WC()->cart->empty_cart();
            foreach ($cart_data as $item) {
                WC()->cart->add_to_cart($item['id'], $item['qty']);
            }
            wc_add_notice('✅ Shared cart loaded successfully!', 'success');
            wp_safe_redirect(wc_get_cart_url());
            exit;
        }
    } else {
        wc_add_notice('❌ Shared cart not found or expired.', 'error');
        wp_safe_redirect(wc_get_cart_url());
        exit;
    }
}
