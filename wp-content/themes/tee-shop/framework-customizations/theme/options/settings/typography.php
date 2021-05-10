<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'typography' => array(
		'title'   => esc_html__( 'Typography', 'origin' ),
		'type'    => 'tab',
		'options' => array(
			'typo_font'	=> array( 
				'title'     	=> esc_html__( 'Basic Typography', 'origin' ),
				'type'      => 'tab',
				'options'   => fw()->theme->get_options( 'settings/typo/font' )
			),
			'typo_color'	=> array( 
				'title'     	=> esc_html__( 'Color', 'origin' ),
				'type'      => 'tab',
				'options'   => fw()->theme->get_options( 'settings/typo/color' )
			),
		),
	),
);
