<?php
/**
 * Post options
 *
 * @var array $options Fill this array with options to generate post options in backend
 */

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'product' => array(
		'title'   => false,
		'type'    => 'box',
		'options' => array(
			'combine_product' => [
				'type'          => 'multi-select',
				'label'         => esc_html__('Combine Products', 'tee-shop'),
				'population'    => 'posts',
				'source'		=> 'product',
				'limit'         => 99,
			],
			'size_guide' => [
				'type'          => 'multi-select',
				'label'         => esc_html__('Select Size Guide', 'tee-shop'),
				'population'    => 'posts',
				'source'		=> 'size_guide',
				'limit'         => 99,
			],
			'video'	=> array(
				'label'	=> __('Video link', 'basr-core'),
				'type'  => 'addable-box',
			    'box-options' => array(
			        'thumb' => array( 
			        	'type'  => 'upload',
			        	'images_only' => true,
			        	'label' => 'Video thumb'
			       	),
			       	'link' => array(
						'type' => 'text',
						'label'	=> 'Video position in Gallery',
					),
			    ),
			    'add-button-text' => __('Add', 'basr-core'),
			    'template' 	     => 'Video link', // box title
			),
		),
	),
);