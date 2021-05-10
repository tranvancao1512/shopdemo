<?php
/**
 *  functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ln-moonlight
 * @since   1.0
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function origin_setup() {

	/*
	 * Make theme available for translation.
	 * If you're building a theme based on , use a find and replace
	 * to change 'origin' to the name of your theme in all the tegmplate files.
	 */
	load_theme_textdomain( 'origin', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	// add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	add_theme_support( 'woocommerce' );
	    // add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
	add_image_size( 'tee-shop-loop'             , 270, 999 , false );
	add_image_size( 'tee-shop-loop-2x'          , 540, 999 , false );
	add_image_size( 'tee-shop-product-single'   , 570, 999 , false );
	add_image_size( 'tee-shop-product-single-mb', 383, 999 , false );
	add_image_size( 'tee-product-thumb'         , 150, 999 , false );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'origin' ),
		'mobile'  => esc_html__( 'Mobile Menu', 'origin' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'image',
		'video',
		'quote',
		'gallery',
		'audio',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', origin_fonts_url() ) );
}

add_action( 'after_setup_theme', 'origin_setup' );

/**
 * Register custom fonts.
 */
function origin_fonts_url() {

	$fonts_url = '';

	$default_fonts = origin_get_default_settings( 'fonts' );

	$default_fonts = array(
		'li_bask'	=> array(
			'family'  => "Libre Baskerville", 
			'weights' => '400-700'
		),
	);

	$font_families = array();

	foreach ( $default_fonts as $key => $font ) {
		$font_families[] = $font['family'] . ':' . str_replace( '-', ',', $font['weights'] );
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	return esc_url_raw( $fonts_url );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function origin_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( '1st Sidebar', 'origin' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'origin' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( '2nd Sidebar', 'origin' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'origin' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'origin' ),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'origin' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'origin' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'origin' ),
		'before_widget' => '<section id="%1$s" class="footer-widget widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'origin' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'origin' ),
		'before_widget' => '<section id="%1$s" class="footer-widget widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'origin' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'origin' ),
		'before_widget' => '<section id="%1$s" class="footer-widget widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'origin' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'origin' ),
		'before_widget' => '<section id="%1$s" class="footer-widget widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}

add_action( 'widgets_init', 'origin_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * Create your own twentysixteen_excerpt_more() function to override in a child theme.
 *
 ** @since Ln Moonlight 1.0.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function origin_excerpt_more() {

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( esc_html__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'origin' ), get_the_title( get_the_ID() ) )
	);

	return ' &hellip; ' . $link;
}

add_filter( 'excerpt_more', 'origin_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 ** @since Ln Moonlight 1.0.0
 */
function origin_javascript_detection() {

	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action( 'wp_head', 'origin_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function origin_pingback_header() {

	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}

add_action( 'wp_head', 'origin_pingback_header' );


/**
 *  Load srcipts and stylesheets.
 */
require get_parent_theme_file_path( '/inc/static.php' );

/**
 *  third party classes and libraries.
 */
require get_parent_theme_file_path( '/inc/vendors.php' );

/**
 *  default variables.
 */
require get_parent_theme_file_path( '/inc/variables.php' );

/**
 *  helper functions.
 */
require get_parent_theme_file_path( '/inc/helpers.php' );

/**
 * Theme actions.
 */
require get_parent_theme_file_path( '/inc/actions.php' );

/**
 * Theme Filters
 */
require get_parent_theme_file_path( '/inc/filters.php' );

/**
 * Theme Dynamic style
 */
require get_parent_theme_file_path( '/inc/dynamic-style.php' );

/**
 * Theme Dynamic style
 */
require get_parent_theme_file_path( '/inc/dynamic-typo.php' );

/**
 * UserAgent
 */
require get_parent_theme_file_path( '/inc/vendors/UserAgent/Mobile_Detect.php' );

// require get_parent_theme_file_path( '/inc/page-loader.php' );


add_filter( 'upload_mimes', 'wc_product_myme_types', 1, 1 );
function wc_product_myme_types( $mime_types ) {
  $mime_types['csv'] = 'text/csv';     // Adding .csv extension
  
  return $mime_types;
}