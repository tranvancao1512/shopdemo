<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => esc_html__('Page Options', 'origin'),
		'type'    => 'box',
		'options' => array(
			'page_tab_1' => array(
				'title'   => esc_html__( 'Page Layouts', 'origin' ),
				'type'    => 'tab',
				'options' => array(
					fw()->theme->get_options( 'posts/page/layouts' ),
				),
			),
			'page_tab_2' => array(
				'title'   => esc_html__( 'Titlebar', 'origin' ),
				'type'    => 'tab',
				'options' => array(
					fw()->theme->get_options( 'posts/page/titlebar' ),
				),
			),
			'page_tab_3' => array(
				'title'   => esc_html__( 'Blog', 'origin' ),
				'type'    => 'tab',
				'options' => array(
					fw()->theme->get_options( 'posts/page/blog' ),
				),
			),
		),
	),
);