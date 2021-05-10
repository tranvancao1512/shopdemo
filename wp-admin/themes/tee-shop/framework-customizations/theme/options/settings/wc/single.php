<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'wc_desc_below_content' => array(
   		'type'  => 'multi-upload',
   		'value' => array(
	    ),
	    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
	    'label' => __('Label', 'origin'),
	    'desc'  => __('Description', 'origin'),
	    'help'  => __('Help tip', 'origin'),
   	),
   	'woo_single_timer' => array(
		'type'  => 'switch',
		'value' => 'no',
		'label' => esc_html__('Show/Hide Timer', 'origin'),
		'right-choice' => array(
			'value' => 'yes',
			'label' => esc_html__('Show', 'origin'),
		),
		'left-choice' => array(
			'value' => 'no',
			'label' => esc_html__('Hide', 'origin'),
		),
	),
	'woo_single_save_count' => array(
		'type'  => 'switch',
		'value' => 'no',
		'label' => esc_html__('Show/Hide Saved count', 'origin'),
		'right-choice' => array(
			'value' => 'yes',
			'label' => esc_html__('Show', 'origin'),
		),
		'left-choice' => array(
			'value' => 'no',
			'label' => esc_html__('Hide', 'origin'),
		),
	),
	'woo_single_style' => array(
		'type' => 'select',
		'label' => esc_html__('Number of Columns', 'origin'),
		'desc' => esc_html__('Apply for Grid or Masonry style', 'origin'),
		'value' => 'style-1',
		'choices' => array(
			'style-1' => esc_html__('Single slider style', 'origin'),
			'style-2' => esc_html__('Single sidebar style', 'origin'),
		),
	),
	'woo_single_related_products' => array(
		'type'  => 'switch',
		'value' => 'yes',
		'label' => esc_html__('Show/Hide Related Products', 'origin'),
		'right-choice' => array(
			'value' => 'yes',
			'label' => esc_html__('Show', 'origin'),
		),
		'left-choice' => array(
			'value' => 'no',
			'label' => esc_html__('Hide', 'origin'),
		),
	),
	'woo_single_related_products_title' => array(
		'type' => 'text',
		'value' => esc_html__('You may also like...', 'origin'),
	),
	'woo_single_related_products_count' => array(
		'type' => 'number',
		'label' => esc_html__('Number of Related Products', 'origin'),
		'value' => 4,
		'attr' => array(
			'min' => 4,
			'max' => 16,
		),
	),
	'woo_single_related_products_slider' => array(
		'type'  => 'switch',
		'value' => 'yes',
		'label' => esc_html__('Use slider for related products?', 'origin'),
		'right-choice' => array(
			'value' => 'yes',
			'label' => esc_html__('Yes', 'origin'),
		),
		'left-choice' => array(
			'value' => 'no',
			'label' => esc_html__('No', 'origin'),
		),
	),
);
