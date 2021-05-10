<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

if ( ! is_admin() ) {
	wp_register_script(
		'headroom',
		header_builder_locate_uri( '/static/vendors/headroom.min.js' ),
		array(),
		header_builder_get_version(),
		true
	);
	// wp_enqueue_style(
	// 	'header-builder',
	// 	header_builder_locate_uri( '/static/css/frontend.css' ),
	// 	array(),
	// 	header_builder_get_version()
	// );

	wp_enqueue_script(
		'header-builder',
		header_builder_locate_uri( '/static/js/frontend.js' ),
		array( 'jquery' ),
		header_builder_get_version(),
		true
	);
}

if ( is_admin() ) {
	wp_enqueue_style(
		'header-builder',
		header_builder_locate_uri( '/static/css/backend.css' ),
		array(),
		header_builder_get_version()
	);
	wp_enqueue_script(
		'header-builder',
		header_builder_locate_uri( '/static/js/backend.js' ),
		array( 'jquery' ),
		header_builder_get_version(),
		true
	);
}
