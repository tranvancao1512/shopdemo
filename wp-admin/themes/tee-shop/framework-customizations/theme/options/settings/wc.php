<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'wc' => array(
		'title'     => esc_html__( 'Woocommerce', 'origin' ),
		'type'      => 'tab',
		'options'   => array(
			'woo_tab_1' => array(
				'title'   => esc_html__( 'Product Archive', 'origin' ),
				'type'    => 'tab',
				'options' => array(
					fw()->theme->get_options( 'settings/wc/archive' ),
				),
			),
			'woo_tab_2' => array(
				'title'   => esc_html__( 'Single Product', 'origin' ),
				'type'    => 'tab',
				'options' => array(
					fw()->theme->get_options( 'settings/wc/single' ),
				),
			),
		),
	),
);