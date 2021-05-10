<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'header' => array(
		'title'   => esc_html__( 'Header Setting', 'origin' ),
		'type'    => 'tab',
		'options' => array(
			'default_header' => array(
				'type'       => 'multi-select',
				'label'      => esc_html__('Header', 'origin'),
				'population' => 'array',
				'choices'    => origin_posts_array('header_builder'),
				'limit'      => 1,
			),
			'logo' => origin_option_logo(),

			'mm_info' => array(
				'type'				=> 'wp-editor',
				'value' 			=> '',
				'label'				=> esc_html__( 'Menu mobile info detail', 'origin' ),
				'help'				=> esc_html__( 'This Info display below mobile menu logo', 'origin'),
				'editor_height' 	=> 200,
				'wpautop' 			=> false,
    			'editor_type' 		=> 'html',
			),
		)
	),
);