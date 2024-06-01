<?php
/**
 * Plugin Name: Core Field
 * Description: 
 * Version:     1.0.0
 * Author:      Awal Bashar
 * Author URI:  
 * Text Domain: core_field
 */


/**
 * 
 * Register All theme widgets
 * 
 */
function register_elementor_addons( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/banner.php' );
	require_once( __DIR__ . '/widgets/category.php' );
	require_once( __DIR__ . '/widgets/product-tab.php' );
	require_once( __DIR__ . '/widgets/fixed-checkout.php' );

	$widgets_manager->register( new \Theme_Banner_Widget() );
	$widgets_manager->register( new \Theme_Category_Widget() );
	$widgets_manager->register( new \Theme_Product_Tab_Widget() );
	$widgets_manager->register( new \Theme_Fixed_Checkout_Widget() );

}
add_action( 'elementor/widgets/register', 'register_elementor_addons' );



/**
 * 
 * Register New Widget Category
 * 
 */
function new_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'theme-widget-category',
		[
			'title' => esc_html__( 'Theme Widgets', 'core_field' ),
			'icon' => 'fa fa-plug',
		]
	);
}
add_action( 'elementor/elements/categories_registered', 'new_elementor_widget_categories' );


/**
 * 
 * enqueue css and js 
 * 
 */

function etheme_enqueue_scripts() {

	// css file 
    wp_enqueue_style('customed-style', plugin_dir_url(__FILE__) . 'assets/css/custom.css', false, '1.0.0', '');

	// js add 
    wp_enqueue_script('ajax-script', plugin_dir_url(__FILE__) . 'assets/js/ajax-submit.js', array('jquery'), '1.0.0', true);

    // Ajax Request URL
    wp_localize_script('ajax-script', 'ecomAjax', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'cart_url' => home_url('/cart')
	));

	// Generate dynamic CSS
    $custom_css = "
		.spinner {
			background-image: url('".admin_url()."/images/spinner.gif');
		}
    ";
    wp_add_inline_style('customed-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'etheme_enqueue_scripts');


/**
 * 
 * require file
 * 
 */

 require_once('ajax-handle.php');


 /**
 * 
 * add new menu on woocommerce my account page 
 * 
 */
function add_wishlist_endpoint( $vars ) {
    $vars['wishlist'] = 'wishlist';
    return $vars;
}
add_filter( 'woocommerce_get_query_vars', 'add_wishlist_endpoint', 0 );

function add_wishlist_menu_item( $items ) {
    $items['wishlist'] = __('Wishlist', 'core_field');
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'add_wishlist_menu_item', 10, 1 );

function add_wishlist_menu_before_logout( $items ) {
    $logout_item = $items['customer-logout'];
    unset( $items['customer-logout'] );
    $items['wishlist'] = __('Wishlist', 'core_field');
    $items['customer-logout'] = $logout_item;
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'add_wishlist_menu_before_logout', 10, 1 );

function wishlist_endpoint_content() {
    
	require('wishlist-product-card.php');

}
add_action( 'woocommerce_account_wishlist_endpoint', 'wishlist_endpoint_content' );


 /**
 * 
 * delete wishlit from my account
 * 
 */
add_action('template_redirect', 'delete_wishlist');

function delete_wishlist() {
    if (isset($_GET['wishlist_id'])) {
        $wishlist_id = $_GET['wishlist_id'];

        wp_delete_post($wishlist_id, true);

        wp_redirect(home_url("/my-account/wishlist"));
        exit;
    }
}