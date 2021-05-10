<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'layout' => array(
		'title'   => esc_html__( 'Layout', 'origin' ),
		'type'    => 'tab',
		'options' => array(
			'layout_tab_1' => array(
				'title'   => esc_html__( 'General', 'origin' ),
				'type'    => 'tab',
				'options' => array(
					fw()->theme->get_options( 'settings/layout/general' ),
				),
			),
		),
	),
);
