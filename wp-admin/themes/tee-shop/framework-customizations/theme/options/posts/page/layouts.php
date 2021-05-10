<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$current_header_version = fw_get_db_settings_option('header_version');
$options = array(
	'page_template' => array(
		'type'          => 'load-vc-template',
		'label'         => esc_html__('Create VC templates (Pages)', 'origin'),
		'value'         => '',
		'inner_options' => array(
			'templates' => array(
				'type'          => 'multi-select',
				'label'         => esc_html__('Select Demo template', 'origin'),
				'population'    => 'array',
				'template-type' => 'page',
				'limit'         => 99,
			),
		),
	),
	'header' => array(
		'type'        => 'multi-select',
		'label'       => esc_html__('Header', 'origin'),
		'population'  => 'array',
		'choices'      => origin_posts_array('header_builder'),
		'limit'       => 1,
	),
	'footer' => array(
		'type'       => 'multi-select',
		'label'      => esc_html__('Footer', 'origin'),
		'population' => 'posts',
		'source'     => 'footer_builder',
		'limit'      => 1,
	),
);
