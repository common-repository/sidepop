<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

delete_option('sidepop_api_key');
delete_option('sidepop_public_key');
delete_option('sidepop_display');
delete_option('sidepop_wordpress');
delete_option('sidepop_wordpress_line1');
delete_option('sidepop_wordpress_line2');
delete_option('sidepop_woocommerce');
delete_option('sidepop_woocommerce_line1');
delete_option('sidepop_woocommerce_line2');



?>