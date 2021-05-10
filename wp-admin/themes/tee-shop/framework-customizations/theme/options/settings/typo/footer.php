<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'typ_footer' => array(
		'type'  => 'typography',
		'value' => origin_default_typo( 'typo_body' ),
		'components' => array(
			'family' => true,
			'size'   => true,
			'color'  => true,
		),
		'label' => esc_html__('Footer typo', 'kids'),
	),

	'footer_link_color' => array(
		'label' => false,
		'type'  => 'multi',
		'inner-options' => array(
	        'color'		 => array(
				'type'  => 'color-picker',
		    	'value' => '',
		    	'label'	=> 'Link color'
			),
	    )
	),

	'footer_link_color_hover' => array(
		'label' => false,
		'type'  => 'multi',
		'inner-options' => array(
	        'color'		 => array(
				'type'  => 'color-picker',
		    	'value' => '',
		    	'label'	=> 'Link hover color'
			)
	    )
	),

	// footer_heading

	'footer_typo_heading' => array(
		'type'  => 'typography',
		'value' => origin_default_typo( 'typo_heading' ),
		'components' => array(
			'family' => true,
			'size'   => false,
			'color'  => true,
		),
		'label' => esc_html__('Heading Font', 'kids'),
	),

	
	'footer_heading_h1'	 => array(
		'label' => false,
		'type'  => 'multi',
		'inner-options' => array(
	        'size'		 => array(
				'label'	=> esc_html__('H1 Font Size', 'kids'),
				'type'  => 'td-slider',
				'value' => origin_default_typo( 'footer_heading_h1' ),
				'properties' => array(
					'min' => 16,
					'max' => 64,
					'step' => 1, // Set slider step. Always > 0. Could be fractional.
				),
			)
	    )
	),

	'footer_heading_h2'	 => array(
		'label' => false,
		'type'  => 'multi',
		'inner-options' => array(
	        'size'		 => array(
				'label'	=> esc_html__('H1 Font Size', 'kids'),
				'type'  => 'td-slider',
				'value' => origin_default_typo( 'footer_heading_h2' ),
				'properties' => array(
					'min' => 16,
					'max' => 64,
					'step' => 1, // Set slider step. Always > 0. Could be fractional.
				),
			)
	    )
	),

	'footer_heading_h3'	 => array(
		'label' => false,
		'type'  => 'multi',
		'inner-options' => array(
	        'size'		 => array(
				'label'	=> esc_html__('H3 Font Size', 'kids'),
				'type'  => 'td-slider',
				'value' => origin_default_typo( 'footer_heading_h3' ),
				'properties' => array(
					'min' => 12,
					'max' => 48,
					'step' => 1, // Se// Set slider step. Always > 0. Could be fractional.
				),
			)
	    )
	),

	'footer_heading_h4'	 => array(
		'label' => false,
		'type'  => 'multi',
		'inner-options' => array(
	        'size'		 => array(
				'label'	=> esc_html__('H4 Font Size', 'kids'),
				'type'  => 'td-slider',
				'value' => origin_default_typo( 'footer_heading_h4' ),
				'properties' => array(
					'min' => 8,
					'max' => 32,
					'step' => 1, // Se// Set slider step. Always > 0. Could be fractional.
				),
			)
	    )
	),

	'footer_heading_h5'	 => array(
		'label' => false,
		'type'  => 'multi',
		'inner-options' => array(
	        'size'		 => array(
				'label'	=> esc_html__('H5 Font Size', 'kids'),
				'type'  => 'td-slider',
				'value' => origin_default_typo( 'footer_heading_h5' ),
				'properties' => array(
					'min' => 8,
					'max' => 32,
					'step' => 1, // Se// Set slider step. Always > 0. Could be fractional.
				),
			)
	    )
	),

	'footer_heading_h6'	=> array(
		'label'		=> false,
		'type'  	=> 'multi',
		'inner-options' => array(
	        'size'		 => array(
				'label'	=> esc_html__('H6 Font Size', 'kids'),
				'type'  => 'td-slider',
				'value' => origin_default_typo( 'footer_heading_h6' ),
				'properties' => array(
					'min' => 8,
					'max' => 32,
					'step' => 1, // Se// Set slider step. Always > 0. Could be fractional.
				),
			)
	    )
	),
);
