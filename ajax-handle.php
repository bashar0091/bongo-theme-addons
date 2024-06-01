<?php

/**
 * 
 * add to cart handler
 * 
 */

 function add_cart_handle_callback() {
    if (isset($_POST['form_data'])) {
        parse_str($_POST['form_data'], $formFields);

        $product_id = isset($formFields['product_id']) ? intval($formFields['product_id']) : 0;
        $quantity = isset($formFields['quantity']) ? intval($formFields['quantity']) : 1;

        if ($product_id > 0) {
            $added = WC()->cart->add_to_cart($product_id, $quantity);
        }
    }
    wp_die();
}
add_action('wp_ajax_add_cart_handle', 'add_cart_handle_callback');
add_action('wp_ajax_nopriv_add_cart_handle', 'add_cart_handle_callback');


/**
 * 
 * single add to cart handler
 * 
 */

 function single_add_cart_handle_callback() {
    if (isset($_POST['form_data'])) {
        parse_str($_POST['form_data'], $formFields);

        $product_id = isset($formFields['product_id']) ? intval($formFields['product_id']) : 0;
        $quantity = isset($formFields['quantity']) ? intval($formFields['quantity']) : 1;
        $color = isset($formFields['color']) ? $formFields['color'] : '';
        $size = isset($formFields['size']) ? $formFields['size'] : '';

        if ($product_id > 0) {
            $added = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), array('color' => $color, 'size' => $size));
        }
    }
    wp_die();
}
add_action('wp_ajax_single_add_cart_handle', 'single_add_cart_handle_callback');
add_action('wp_ajax_nopriv_single_add_cart_handle', 'single_add_cart_handle_callback');


/**
 * 
 * Fixed checkout handle
 * 
 */

 function fixed_checkout_handle_callback() {
    if (isset($_POST['form_data'])) {

        parse_str($_POST['form_data'], $formFields);
        
        // Sanitize input data
        $billing_name = sanitize_text_field($formFields['fixed_name']);
        $billing_mobile = sanitize_text_field($formFields['fixed_mobile']);
        $billing_address = sanitize_text_field($formFields['fixed_address']);
        $product_id = $formFields['product_id'];
        
        $order = wc_create_order();

        $order->set_billing_first_name($billing_name);
        $order->set_billing_phone($billing_mobile);
        $order->set_billing_address_1($billing_address);
        $order->set_billing_country('BD');

        $product_quantity = 1;
        foreach ($product_id as $single_product_id) {
            $order->add_product(wc_get_product($single_product_id), $product_quantity);
        }

        $order->calculate_totals();
        $order->save();

        WC()->mailer()->emails['WC_Email_Customer_Processing_Order']->trigger($order->get_id());
    }
    wp_die();
}
add_action('wp_ajax_fixed_checkout_handle', 'fixed_checkout_handle_callback');
add_action('wp_ajax_nopriv_fixed_checkout_handle', 'fixed_checkout_handle_callback');


/**
 * 
 * additional field on cart page
 * 
 */
add_filter('woocommerce_get_item_data', 'display_custom_item_data_in_cart', 10, 2);
function display_custom_item_data_in_cart($item_data, $cart_item) {
    if (isset($cart_item['color'])) {
        $item_data[] = array(
            'key' => __('Color', 'woocommerce'),
            'value' => wc_clean($cart_item['color']),
            'display' => '',
        );
    }
    if (isset($cart_item['size'])) {
        $item_data[] = array(
            'key' => __('Size', 'woocommerce'),
            'value' => wc_clean($cart_item['size']),
            'display' => '',
        );
    }
    return $item_data;
}

/**
 * 
 * additional field as meta
 * 
 */
add_action('woocommerce_add_order_item_meta', 'save_custom_item_data_in_order', 10, 3);
function save_custom_item_data_in_order($item_id, $values, $cart_item_key) {
    if (isset($values['color'])) {
        wc_add_order_item_meta($item_id, 'Color', $values['color']);
    }
    if (isset($values['size'])) {
        wc_add_order_item_meta($item_id, 'Size', $values['size']);
    }
}

/**
 * 
 * display on cart and checkout
 * 
 */
add_action('woocommerce_admin_order_item_headers', 'display_custom_fields_order_header');
function display_custom_fields_order_header($columns) {
    $new_columns = array();
    foreach ($columns as $column => $label) {
        $new_columns[$column] = $label;
        if ('product' === $column) {
            $new_columns['color'] = __('Color', 'woocommerce');
            $new_columns['size'] = __('Size', 'woocommerce');
        }
    }
    return $new_columns;
}

add_action('woocommerce_admin_order_item_values', 'display_custom_fields_order_values', 10, 3);
function display_custom_fields_order_values($product, $item, $item_id) {
    if ($meta_data = wc_get_order_item_meta($item_id, 'Color', true)) {
        echo '<td>' . esc_html($meta_data) . '</td>';
    }
    if ($meta_data = wc_get_order_item_meta($item_id, 'Size', true)) {
        echo '<td>' . esc_html($meta_data) . '</td>';
    }
}
