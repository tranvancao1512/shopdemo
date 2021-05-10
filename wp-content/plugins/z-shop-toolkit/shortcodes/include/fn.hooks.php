<?php

function ln_moonlight_action_theme_page_loader_html() {

	$loader = ln_moonlight_get_setting('general_page_loader');

	if( $loader['enable'] === 'no' )
		return;
	echo '<div id="basr-page-loader" style="background-color: rgb(255, 255, 255);display: block;position: fixed; width: 100%; height: 100%; top: 0px; left: 0px; z-index: 9999999;"></div>';
}
add_action('ln_moonlight_header', 'ln_moonlight_action_theme_page_loader_html', 1 );

// Register color product term 


function lucy_shortcode_custom_param() {
	vc_add_param( 'vc_tta_tabs', array(
		'type' => 'dropdown',
		'param_name' => 'style',
		'value' => array(
			__( 'Classic', 'basr-core' ) => 'classic',
			__( 'Modern', 'basr-core' ) => 'modern',
			__( 'Flat', 'basr-core' ) => 'flat',
			__( 'Outline', 'basr-core' ) => 'outline',
			__( 'basr-core', 'basr-core' ) => 'basr-core',
		),
		'heading' => __( 'Style', 'basr-core' ),
		'description' => __( 'Select tabs display style.', 'basr-core' ),
	) );
	vc_add_param( 'vc_btn', array(
		'type' => 'dropdown',
		'heading' => __( 'Style', 'basr-core' ),
		'description' => __( 'Select button display style.', 'basr-core' ),
		'param_name' => 'style',
		'value' => array(
			__( 'Modern', 'basr-core' ) => 'modern',
			__( 'Classic', 'basr-core' ) => 'classic',
			__( 'Flat', 'basr-core' ) => 'flat',
			__( 'Outline', 'basr-core' ) => 'outline',
			__( '3d', 'basr-core' ) => '3d',
			__( 'Custom', 'basr-core' ) => 'custom',
			__( 'Outline custom', 'basr-core' ) => 'outline-custom',
			__( 'Gradient', 'basr-core' ) => 'gradient',
			__( 'Gradient Custom', 'basr-core' ) => 'gradient-custom',
			__( 'Toolkit Outline', 'basr-core' ) => 'lucy-outline',
		),
	) );
	vc_add_param( 'vc_tta_tabs', array(
		'type' => 'dropdown',
		'param_name' => 'style',
		'value' => array(
			__( 'Classic', 'basr-core' ) => 'classic',
			__( 'Modern', 'basr-core' ) => 'modern',
			__( 'Flat', 'basr-core' ) => 'flat',
			__( 'Outline', 'basr-core' ) => 'outline',
			__( 'basr-core', 'basr-core' ) => 'basr-core',
		),
		'heading' => __( 'Style', 'basr-core' ),
		'description' => __( 'Select tabs display style.', 'basr-core' ),
	) );
}
add_action( 'vc_before_init', 'lucy_shortcode_custom_param');


function basr_shortcode_plugin_path() {
 
	// gets the absolute path to this plugin directory
 
	return untrailingslashit( plugin_dir_path( __FILE__ ) );
 
}
 
 
 
// add_filter( 'woocommerce_locate_template', 'basr_shortcode_woocommerce_locate_template', 10, 3 );
 
function basr_shortcode_woocommerce_locate_template( $template, $template_name, $template_path ) {
 
	global $woocommerce;
 
 
	$_template = $template;

 
	if ( ! $template_path ) $template_path = $woocommerce->template_url;
 
	$plugin_path  = TOOLKIT_BASR_TOOLKIT_PATH . '/woocommerce/';
 
	// Look within passed path within the theme - this is priority
 
	$template = locate_template(
 
		array(
	 
			$template_path . $template_name,
	 
			$template_name
	 
		)
	);
 
 
 
	// Modification: Get the template from this plugin, if it exists
 
	if ( ! $template && file_exists( $plugin_path . $template_name ) ) {

		$template = $plugin_path . $template_name;

	}
 
 
 
	// Use default template
 
	if ( ! $template ) $template = $_template;
 
	// Return what we found
 
	return $template;
 
}


