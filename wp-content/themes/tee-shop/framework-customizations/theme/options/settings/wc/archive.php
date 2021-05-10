<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

	'woo_archive_fullwidth' => array(
		'type'  => 'switch',
		'value' => 'yes',
		'label' => esc_html__('Layout Fullwidth', 'origin'),
		'right-choice' => array(
			'value' => 'yes',
			'label' => esc_html__('Yes', 'origin'),
		),
		'left-choice' => array(
			'value' => 'no',
			'label' => esc_html__('No', 'origin'),
		),
	),

	'woo_archive_sorting' => array(
		'type'  => 'switch',
		'value' => 'yes',
		'label' => esc_html__('Show/Hide Sorting', 'origin'),
		'right-choice' => array(
			'value' => 'yes',
			'label' => esc_html__('Show', 'origin'),
		),
		'left-choice' => array(
			'value' => 'no',
			'label' => esc_html__('Hide', 'origin'),
		),
	),
	'woo_archive_number_of_results' => array(
		'type'  => 'switch',
		'value' => 'yes',
		'label' => esc_html__('Show/Hide Number of Results', 'origin'),
		'right-choice' => array(
			'value' => 'yes',
			'label' => esc_html__('Show', 'origin'),
		),
		'left-choice' => array(
			'value' => 'no',
			'label' => esc_html__('Hide', 'origin'),
		),
	),
	'woo_archive_column' => array(
		'type' => 'number',
		'value' => 3,
		'label' => esc_html__('Number of Column', 'origin'),
		'attr' => array(
			'min' => 2,
			'max' => 4,
		),
	),
	'woo_archive_products_per_page' => array(
		'type' => 'number',
		'value' => 9,
		'label' => esc_html__('Number of Products per Page', 'origin'),
		'attr' 	=> array(
			'min' => 1,
			'max' => 60,
		),
	),
);
