<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'ot_title_bar' => array(
		'title'     => esc_html__( 'Titlebar Settings', 'origin' ),
		'type'      => 'tab',
		'options'   => origin_render_title_bar_metabox( true ),
	),
);