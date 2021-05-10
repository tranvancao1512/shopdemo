<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'footer' => array(
		'title'     => esc_html__( 'Footer', 'origin' ),
		'type'      => 'tab',
		'options' => array(
			!fw_ext('footer-builder') ? array() : array(
				'ext:footer-builder' => array(
					'type' => 'multi',
					'label' => false,
					'inner-options' => fw_ext('footer-builder')->get_settings_options(),
					'fw-storage' => array(
						'type' => 'wp-option',
						'wp-option' => 'fw_ext_settings_options:footer-builder'
					),
				),
			),
			'footer_to_top' => array(
				'label'	 => esc_html__('Go to top Button', 'origin'),
				'type'		 => 'switch',
				'value'		=> 'yes',
				'left-choice' => array(
					'value' => 'no',
					'label' => esc_html__( 'Hide', 'origin' )
				),
				'right-choice'  => array(
					'value' => 'yes',
					'label' => esc_html__( 'Show', 'origin' )
				),
			),
			
		),
	),
);