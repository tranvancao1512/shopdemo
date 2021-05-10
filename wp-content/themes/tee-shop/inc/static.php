<?php 

/**
 * Enqueue scripts and styles.
 */
function origin_scripts() {

	$minify = origin_get_setting( 'general_minify' ) ? 'minify/main.css' : 'main.css' ;

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'shop-fonts', origin_fonts_url(), array(), null );

	// slick stylesheet
	// wp_enqueue_style( 'slick'			, get_theme_file_uri( '/assets/vendor/slick/slick.css' ) );

	// font awesome
	wp_enqueue_style( 'font-awesome'	, get_theme_file_uri( '/assets/vendor/font-awesome/css/font-awesome.min.css' ) );

	// Ionicons font icon

	// Theme stylesheet.
	// wp_enqueue_style( 'shop-header', get_theme_file_uri( '/assets/css/header.css' ) );
	wp_enqueue_style( 'shop-style', get_theme_file_uri( '/assets/css/' . $minify ) );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Isotope 
	// wp_enqueue_script( 'jquery-slick'	, get_theme_file_uri( '/assets/vendor/slick/slick.min.js' )				, array('jquery')	, '1.8.0', true );

	// Isotope 
	// wp_enqueue_script( 'jquery-isotope'	, get_theme_file_uri( '/assets/vendor/js/isotope.pkgd.min.js' )			, array('jquery')	, '3.0.2', true );

	// Imageload

	// wp_enqueue_script( 'imagesloaded' );

	// main script

	wp_enqueue_script( 'tee-shop-script'	, get_theme_file_uri( '/assets/js/main.js' )						, array( 'jquery' )	, '1.0.0', true );

	wp_enqueue_script( 'tee-shop-scriptest'	, get_theme_file_uri( '/assets/js/booster.js' )						, array( 'jquery' )	, '1.0.0', true );

	wp_localize_script( 'tee-shop-script', 'tee_shop_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );

	// Back-end Stylesheet
}

add_action( 'wp_enqueue_scripts', 'origin_scripts', 9999 );

function tee_shop_inline_style() {
	$inline = '';
	ob_start();
	include get_theme_file_path( '/assets/css/minify/inline.css' );

	// header inline
	$detector = Agent::get_instance();
	if( $detector->isPhone() === true ) :
		include get_theme_file_path( '/assets/css/minify/mm-inline.css' );
	else : 
		include get_theme_file_path( '/assets/css/minify/header.css' );
	endif;

	if( class_exists( 'WooCommerce' ) ) {
		if( is_singular('product') ) {
			include get_theme_file_path( '/assets/css/minify/wc_single.css' );
		}
	}

	$inline .= ob_get_clean();
	if( $inline ) {
		// $inline = '<style>' . $inline . '</style>';
		wp_add_inline_style( 'shop-style', $inline );
	}
}

add_action( 'wp_enqueue_scripts', 'tee_shop_inline_style', 99999 );

function origin_admin_script() {
	wp_enqueue_style( 'font-ionicons'	, get_theme_file_uri( '/assets/vendor/ionicons/css/ionicons.min.css' ) );
	wp_enqueue_style( 'basr-backend'	, get_theme_file_uri( '/assets/css/basr-backend.css' ) );
	wp_enqueue_script( 'basr-backend'	, get_theme_file_uri( '/assets/js/basr-backend.js' ), array( 'jquery', 'fw' )	, '1.0.0', true );
}

add_action( 'admin_enqueue_scripts', 'origin_admin_script', 9999 );


add_action( 'wp_enqueue_scripts', 'tee_dequeue_style', 9999);

function tee_dequeue_style() {
	  // Print all loaded Styles (CSS)
    global $wp_styles;

    // lf( $wp_styles->queue );

    $list = [
    	'woocommerce-smallscreen',
    	'wp-block-library',
    	'basr-shortcode-css',
    ];

    if ( is_singular('product') || is_page() || is_archive('product') ) {
    	wp_dequeue_style( 'woocommerce-general' );
    	wp_dequeue_style( 'woocommerce-layout' );
    	wp_dequeue_style( 'wc-block-style' );
    }

    foreach( $list as $style ) :
        wp_dequeue_style( $style );
    endforeach;
}

add_action( 'origin_footer', 'tee_deregister_scripts', 1 );
function tee_deregister_scripts(){
	global $wp_scripts;
	// lf( $wp_scripts->queue );
	wp_deregister_script( 'wp-embed' );
}

function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	// add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );


