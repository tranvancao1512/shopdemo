<?php
/*
Plugin Name: Shop Toolkit
Plugin URI: http://lunartheme.com
Description: Moonlight core modules and functions
Version: 1.0.0
Author: LunarTheme
Author URI: http://lunartheme.com
Text Domain: basr-core
*/

/* Defined Constant */
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 's_backup_collection_term',99 );
if ( ! function_exists( 's_backup_collection_term' ) ) {
	function s_backup_collection_term()  {

		if ( ! class_exists('Woocommerce') ) return;

		$labels = array(
		    'name'                       => 'Collection',
		    'singular_name'              => 'Collection',
		    'menu_name'                  => 'Collections',
		    'all_items'                  => 'All Collection',
		    'parent_item'                => 'Parent Item',
		    'parent_item_colon'          => 'Parent Item:',
		    'new_item_name'              => 'New Collection',
		    'add_new_item'               => 'Add New Collection',
		    'edit_item'                  => 'Edit Collection',
		    'view_item'					 => 'View Collection',
		    'update_item'                => 'Update Collection',
		    'separate_items_with_commas' => 'Separate Item with commas',
		    'search_items'               => 'Search Collection',
		    'add_or_remove_items'        => 'Add or remove Collection',
		    'choose_from_most_used'      => 'Choose from the most used Collection',
		);
		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'query_var'         => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => array( 'slug'	=> 'collections' ),
		);
		register_taxonomy( 'collection', 'product', $args );
		flush_rewrite_rules();
	}
}

// Only for Moonlight WordPress Theme

$template   = get_option( 'template' );

if ( $template != 'tee-shop' ) return;

define( 'BASR_CORE'               , 'origin'					);

define( 'BASR_CORE_PLUGIN_URL'    , plugin_dir_url( __FILE__ )   );

define( 'BASR_CORE_PLUGIN_PATH'   , plugin_dir_path( __FILE__ )  );

define( 'BASR_CORE_PLUGIN_WC_URL' , plugin_dir_url( __FILE__ )  . '/woocommerce' );

define( 'BASR_CORE_PLUGIN_WC_PATH', plugin_dir_path( __FILE__ ) . '/woocommerce' );

define( 'BASR_CORE_PLUGIN_WELCOME_PATH', plugin_dir_path( __FILE__ ) . '/welcome' );

define( 'BASR_CORE_PLUGIN_WELCOME_URL', plugin_dir_url( __FILE__ ) . '/welcome' );

 /**
	* Load Text domain 
	*
	*/

function basr_core_load_plugin_textdomain() {
		load_plugin_textdomain( 'basr-core', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'basr_core_load_plugin_textdomain' );

// debug mode 
if ( strpos('localhost', home_url() ) ) {
	include  BASR_CORE_PLUGIN_PATH . '/kint/Kint.class.php';
}

 /**
	* Core func 
	*
	*/

include BASR_CORE_PLUGIN_PATH . '/inc/helpers.php';

include BASR_CORE_PLUGIN_PATH . '/inc/hooks.php';

/**
 * Unyson extensions 
 *
 */

include BASR_CORE_PLUGIN_PATH . '/extensions/extensions.php';

function basr_fw_filter_toolkit_extensions( $locations ) {
		$locations[dirname(__FILE__) . '/extensions'] =  plugin_dir_url( __FILE__ ) . 'extensions';

		return $locations;
}

add_filter( 'fw_extensions_locations', 'basr_fw_filter_toolkit_extensions');

/**
 * Unyson options type 
 *
 */
function _basr_core_load_more_option() {
		if ( file_exists( BASR_CORE_PLUGIN_PATH . 'unyson-options/load-vc-template/data-template.php' ) ) {
				require_once BASR_CORE_PLUGIN_PATH . 'unyson-options/load-vc-template/class-fw-option-type-load-vc-template.php';
		}
}
add_action('fw_option_types_init', '_basr_core_load_more_option');

/**
 * Infinite scroll
 *
 */

// include  BASR_CORE_PLUGIN_PATH . 'ajaxloadmore/fn.loadmore.php';


/**
 * Welcome
 *
 */

// include  BASR_CORE_PLUGIN_WELCOME_PATH . '/welcome.php';

/**
 * shortcodes
 *
 */

include  BASR_CORE_PLUGIN_PATH . '/shortcodes/index.php';
include  BASR_CORE_PLUGIN_PATH . '/inc/_test.php';

/**
 * Widget
 *
 */

// include  BASR_CORE_PLUGIN_PATH . 'widget/widgets.php';

// variant style 

/**
 * shortcodes
 *
 */

include  BASR_CORE_PLUGIN_PATH . '/wc-add-on/wc_add_on.php';

if ( ! function_exists( 'l' ) ) {
	function l( $param, $label = '----' ) {
		error_log( $label );
		error_log( print_r( $param, true ) );
	}
} 

if( class_exists( 'Woocommerce' ) ) {
	include 'woocommerce.php';
}