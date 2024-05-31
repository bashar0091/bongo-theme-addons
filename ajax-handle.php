<?php

/**
 * 
 * add to cart handler
 * 
 */

 function add_cart_handle_callback() {
    // Check if form_data is set
    if (isset($_POST['form_data'])) {
        parse_str($_POST['form_data'], $formFields);

        // Get product ID and quantity from the form data
        $product_id = isset($formFields['product_id']) ? intval($formFields['product_id']) : 0;
        $quantity = isset($formFields['quantity']) ? intval($formFields['quantity']) : 1;

        if ($product_id > 0) {
            $added = WC()->cart->add_to_cart($product_id, $quantity);

            if ($added) {
                wp_send_json_success(array('message' => 'Product added to cart successfully.'));
            } else {
                wp_send_json_error(array('message' => 'Failed to add product to cart.'));
            }
        } else {
            wp_send_json_error(array('message' => 'Invalid product ID.'));
        }
    } else {
        wp_send_json_error(array('message' => 'No form data received.'));
    }

    wp_die(); // Always end your AJAX functions with wp_die() to avoid a 0 output.
}
add_action('wp_ajax_add_cart_handle', 'add_cart_handle_callback');
add_action('wp_ajax_nopriv_add_cart_handle', 'add_cart_handle_callback');