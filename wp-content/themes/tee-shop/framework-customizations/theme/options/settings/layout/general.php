<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

	'layout_main' => array(
		'label'  => esc_html__('Main layout', 'origin'),
		'type'	=> 'image-picker',
		'value'  => 'right-sidebar',
		'desc'	=> esc_html__('Layout can change for specific post/page.', 'origin'),
		'choices' => array(
			'no-sidebar' => array(
				'small' => array(
					'height' => 36,
					'src'	=> get_template_directory_uri() . '/framework-customizations/extensions/sidebars/static/images/no-sidebar.png'
				),
			),
			'left-sidebar' => array(
				'small' => array(
					'height' => 36,
					'src'	=> get_template_directory_uri() . '/framework-customizations/extensions/sidebars/static/images/left-sidebar.png'
				),
			),
			'right-sidebar' => array(
				'small' => array(
					'height' => 36,
					'src'	=> get_template_directory_uri() . '/framework-customizations/extensions/sidebars/static/images/right-sidebar.png'
				),
			),
			'left-left-sidebar' => array(
				'small' => array(
					'height' => 36,
					'src'	=> get_template_directory_uri() . '/framework-customizations/extensions/sidebars/static/images/left-left-sidebar.png'
				),
			),
			'left-right-sidebar' => array(
				'small' => array(
					'height' => 36,
					'src'	=> get_template_directory_uri() . '/framework-customizations/extensions/sidebars/static/images/left-right-sidebar.png'
				),
			),
			'right-right-sidebar' => array(
				'small' => array(
					'height' => 36,
					'src'	=> get_template_directory_uri() . '/framework-customizations/extensions/sidebars/static/images/right-right-sidebar.png'
				),
			),
		),
	),
	'layout_width' => array(
		'label'	=> esc_html__('Content Width', 'origin'),
		'type'  => 'td-slider',
		'value' => 1200,
		'properties' => array(
			'min' => 940,
			'max' => 1200,
			'step' => 1, // Set slider step. Always > 0. Could be fractional.
		),
	),
	'layout_2col' => array(
		'type'	=> 'group',
		'options' => array(
			'2col_title' => array(
				'type'	=> 'html-full',
				'html'	=> esc_html__('Setting for one sidebar layout', 'origin'),
				'label'  => false,
			),
			'2col_content'	=> array(
				'label'	=> esc_html__('Main content width', 'origin'),
				'type'  => 'number',
				'value'	=> 75,
				'properties' => array(
					'min'	=> 1,
					'max'	=> 100,
				),
				'desc'	=> esc_html__('Sidebar width will be auto calculated. Unit: %', 'origin'),
			),
			'2col_gutter'	=> array(
				'label'	=> esc_html__('Gutter width', 'origin'),
				'type'  => 'number',
				'value'	=> 4,
				'properties' => array(
					'min'	=> 1,
					'max'	=> 10,
				),
			),
		),
	),
);
