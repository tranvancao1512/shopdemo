<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
function _action_header_builder_option_type_init() {
	require dirname( __FILE__ ) . '/includes/option-types/header-builder/class-fw-option-type-header-builder.php';
}

add_action( 'fw_option_types_init', '_action_header_builder_option_type_init' );

add_filter( 'post_updated_messages', '_filter_header_builder_updated_messages' );
/**
 * Header update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function _filter_header_builder_updated_messages( $messages ) {

	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['header_builder'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Header updated.', 'lunar-core' ),
		2  => __( 'Custom field updated.', 'lunar-core' ),
		3  => __( 'Custom field deleted.', 'lunar-core' ),
		4  => __( 'Header updated.', 'lunar-core' ),
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Header restored to revision from %s', 'lunar-core' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Header published.', 'lunar-core' ),
		7  => __( 'Header saved.', 'lunar-core' ),
		8  => __( 'Header submitted.', 'lunar-core' ),
		9  => sprintf(
			__( 'Header scheduled for: <strong>%1$s</strong>.', 'lunar-core' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'lunar-core' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Header draft updated.', 'lunar-core' ),
	);

	return $messages;
}

/**
 *
 */
function print_header_inline_style() {

	$current_header = header_builder_get_current_header();
	if ( is_null( $current_header ) ) {
		return;
	}
	$header    = fw_get_db_post_option( $current_header );
	$options   = json_decode( $header['header-builder']['json'], true );
	ob_start();
	header_builder_generate_css( $options );
	$style = ob_get_clean();
	wp_add_inline_style(
		BASR_CORE . '-style',
		$style
	);
}

add_action( 'wp_enqueue_scripts', 'print_header_inline_style' );

add_filter( 'woocommerce_add_to_cart_fragments', 'header_builder_add_to_cart_fragment' );

function header_builder_add_to_cart_fragment( $fragments ) {

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	global $woocommerce;

	ob_start();

	?>
	<span class="cart-counter">
		<?php echo WC()->cart->get_cart_contents_count(); ?>
	</span>
	<?php

	$fragments['span.cart-counter'] = ob_get_clean();

	$fragments['span.total'] = '<span class="total"> - ' . 
										WC()->cart->get_cart_total() . 
								'</span>';

	l( $fragments['span.total'] );

	return $fragments;

}

add_action( 'admin_menu', 'header_builder_add_submenu' );

function header_builder_add_submenu() {

	add_submenu_page(
		'the1989',
		__( 'Header Builder', 'lunar-core' ),
		__( 'Header Builder', 'lunar-core' ),
		'manage_options',
		'edit.php?post_type=header_builder'
	);
}

/**
 * Print Current Header.
 */
function header_builder_print_current_header() {

	echo header_builder_get_header_html( header_builder_get_current_header() );
}

function so_screen_layout_post() {

	return 1;
}

add_filter( 'get_user_option_screen_layout_header_builder', 'so_screen_layout_post' );

add_filter( 'wp_ajax_nopriv_header_builder_get_menu_html', 'header_builder_get_menu_html' );
add_filter( 'wp_ajax_header_builder_get_menu_html', 'header_builder_get_menu_html' );

function header_builder_get_menu_html() {

	if ( ! isset( $_POST['menu'] ) && ! $_POST['menu'] ) {
		return;
	}

	wp_nav_menu( array( 'menu' => $_POST['menu'], 'container' => '' ) );

	die();
}

/**
 * Hook header builder to main header.
 */
function header_builder_hooks() {

	if ( is_null( $current_header ) ) {
		return;
	} else {
		// add_action( 'the1989_header', 'header_builder_print_current_header', 10 );
	}
}

// add_action( 'template_redirect', 'header_builder_hooks', 11 );

function header_builder_toolbar_edit( $wp_admin_bar ) {

	if ( is_admin() ) return;

	$footer_id = header_builder_get_current_header();

	if ( ! $footer_id ) return;

	$args = array(
		'id'    => 'edit_header',
		'title' => esc_html( 'Edit Header', 'basr-core' ),
		'href'  => get_edit_post_link( $footer_id ),
		'meta'  => array( 'class' => 'basr-edit-header' )
	);

	$wp_admin_bar->add_node( $args );

}
add_action( 'admin_bar_menu', 'header_builder_toolbar_edit', 999 );

add_filter( 'body_class', 'header_builder_filter_body_class' );

function header_builder_filter_body_class( $classes ) {
	$id = header_builder_get_current_header();
	$class = get_the_title( $id );
	$class = preg_replace('/\s+/', '-', $class );
	$classes[] = $class;

	return $classes;
}