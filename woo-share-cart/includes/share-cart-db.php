<?php

// Create shared cart DB table
function wsc_create_share_cart_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'shared_carts';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        cart_key VARCHAR(255) NOT NULL,
        cart_data LONGTEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY cart_key (cart_key)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
