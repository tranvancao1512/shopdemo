<?php
/**
 * Post options
 *
 * @var array $options Fill this array with options to generate post options in backend
 */

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => false,
		'type'    => 'box',
		'options' => array(
				'post_tab_2' => array(
					'title'   => esc_html__( 'Post Format', 'origin' ),
					'type'    => 'tab',
					'options' => array(
						fw()->theme->get_options( 'posts/post/format' ),
					),
				),

				'page_tab_3' => array(
					'title'   => esc_html__( 'Titlebar', 'origin' ),
					'type'    => 'tab',
					'options' => array(
						fw()->theme->get_options( 'posts/page/titlebar' ),
					),
				),

		),
	),
);