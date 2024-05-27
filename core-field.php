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

	$widgets_manager->register( new \Theme_Banner_Widget() );
	$widgets_manager->register( new \Theme_Category_Widget() );

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