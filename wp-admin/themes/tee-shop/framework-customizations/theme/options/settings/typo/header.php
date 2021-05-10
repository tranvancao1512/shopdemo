<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'typo_main_nav' => array(
		'type'  => 'typography',
		'value' => origin_default_typo( 'typo_main_nav' ),
		'components' => array(
			'family' => true,
			'size'   => true,
			'color'  => true,
		),
		'label' => esc_html__('Main Navigation', 'kids'),
	),

	'main_nav_hover' => array(
		'label' => false,
		'type'  => 'multi',
		'inner-options' => array(
	        'color'		 => array(
				'type'  => 'color-picker',
		    	'value' => '',
		    	'label'	=> 'Main Navigation link hover'
			)
	    )
	),

	'typo_sub_nav' => array(
		'type'  => 'typography',
		'value' => origin_default_typo( 'typo_sub_nav' ),
		'components' => array(
			'family' => true,
			'size'   => true,
			'color'  => true,
		),
		'label'		=> esc_html__('Sub Navigation', 'kids'),
	),

	'sub_nav_hover' => array(
		'label' => false,
		'type'  => 'multi',
		'inner-options' => array(
	        'color'		 => array(
				'type'  => 'color-picker',
		    	'value' => '',
		    	'label'	=> 'Sub Navigation link hover'
			)
	    )
	),
);
