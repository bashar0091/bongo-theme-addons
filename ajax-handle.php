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