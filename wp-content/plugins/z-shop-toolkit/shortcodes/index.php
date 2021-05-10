<?php
/*
Plugin Name: Moonlight Shortcodes
Plugin URI: http://www.lunartheme.com
Description: This is the plugin for setting up shortcodes on earththeme's items
Version: 1.0
Author: Lunartheme
Author URI: http://lunartheme.com



/*  [ Require Files. ]
- - - - - - - - - - - - - - - - - - - */

define( 'BASR_SHORTCODES_PATH'			, BASR_CORE_PLUGIN_PATH . 'shortcodes/'  );
define( 'BASR_SHORTCODES_URL' 			, BASR_CORE_PLUGIN_URL  . 'shortcodes/'  );
define( 'BASR_SHORTCODES_ASSET_URL' 	, BASR_SHORTCODES_URL   . 'assets/'  );
define( 'BASR_SHORTCODES_VENDOR_URL' 	, BASR_SHORTCODES_URL   . 'assets/vendors/'  );


include_once 	BASR_SHORTCODES_PATH . 'include/fn.hooks.php'										; // hooks

include_once 	BASR_SHORTCODES_PATH . 'include/fn.misc.php'										; // function

include_once	'class.shortcode.php' 					; // Class render shortcode

include_once 	'shortcodes.php'						; // listing of shortcode

$shortcodes = toolkit_basr_listing_shortcode();

foreach ( $shortcodes as $key => $shortcode ) {

	if ( is_file( BASR_SHORTCODES_PATH . 'shortcodes/'. $shortcode['type'] . '/' . $shortcode['slug'] . '.php' ) ) {
		require_once BASR_SHORTCODES_PATH . 'shortcodes/' . $shortcode['type'] . '/' . $shortcode['slug'] . '.php' ;
	}

	$class = 'toolkit_basr_shortcode_' . $shortcode['slug'];

	if ( class_exists( $class ) )  new $class();

}

// Enable shortcodes in text widgets

add_filter('widget_text','do_shortcode');

// Add image size 


/*-------------------------------------------------------------------
 * Enqueue Script and Css.
-------------------------------------------------------------------*/

function basr_shortcodes_fontend_scripts() {
	if ( ! is_admin() ) {

		$minify = basr_core_get_setting( 'general_minify' ) ? '.min' : '' ;

		$theme_prefix = str_replace('_', '-', BASR_CORE );

		// main style 
		wp_enqueue_style(  'basr-shortcode-css'		, BASR_SHORTCODES_ASSET_URL . 'css/shortcodes' . $minify . '.css' 	);
            
		// Vendors
		// wp_enqueue_style(  'moodshop-animate-css'	, BASR_SHORTCODES_VENDOR_URL . 'anvimate/css/animate.min.css' );

		// jquery nouislider 


		//  google map AIzaSyDGf7SpUQxHN0AXtJ86lF6Jx3zrWiI8vSM

		$key = function_exists( 'basr_core_get_setting' ) ? basr_core_get_setting('general_google_key') : '';

		wp_register_script( 'basr-google-map', '//maps.google.com/maps/api/js?v=3.exp&key=' . $key , array('jquery') );

		wp_enqueue_script( 'jQuery-ct'  	, BASR_SHORTCODES_ASSET_URL . 'js/jquery.countdown.min.js' ,array(), '1.0', true );
		// main js
		wp_enqueue_script( 'basr-shortcode-js'  	, BASR_SHORTCODES_ASSET_URL . 'js/shortcodes.js' , array( 'jquery' ), '1.0', true );

		wp_localize_script( 'basr-shortcode-js', 'basr_core', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}
}
add_action( 'wp_enqueue_scripts', 'basr_shortcodes_fontend_scripts' );

function toolkit_plugin_path() {

	return untrailingslashit( plugin_dir_path( __FILE__ ) );
}
