<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'page_404' => array(
		'title'     => esc_html__( '404', 'origin' ),
		'type'      => 'tab',
		'options'   => array(
			'img' => array(
				'title' => esc_html__( '404 image', 'origin' ),
				'type'  => 'upload',
				'label' => esc_html__( 'Upload image', 'origin' ),
			),
			'title' => array(
				'label' =>  esc_html__( 'Title', 'origin' ),
				'type'  => 'text',
				'value' =>  esc_html__( 'Oops! That page can&rsquo;t be found.', 'origin' ),
			),
			'excerpt' => array(
				'label' => esc_html__( 'Text', 'origin' ),
				'type'  => 'text',
				'value' => esc_html__( 'May be try a search ?', 'origin' ),
			),
		),
	),
);