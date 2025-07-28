<?php

add_action('woocommerce_after_cart', function () {
    echo '<p style="color:red; font-size:20px;">✅ Hook Test Success</p>';
});
function wsc_cart_share_shortcode() {
    ob_start();
    wsc_add_share_button(); // your same function
    return ob_get_clean();
}
add_shortcode('share_cart_button', 'wsc_cart_share_shortcode');
