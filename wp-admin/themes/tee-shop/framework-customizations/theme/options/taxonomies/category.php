<?php
/**
 * Category options
 *
 * @package ln-moonlight
 ** @since Ln Moonlight 1.0.0
 * @var array $options Fill this array with options to generate category options in backend
 */

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'post_cat' => array(
		'title'   => esc_html__( 'Category setting', 'origin' ),
		'type'    => 'box',
		'options' => array(
			'post_cat_title' => array(
				'title'   => esc_html__( 'Titlebar settings', 'origin' ),
				'type'    => 'tab',
				'options' => origin_render_title_bar_metabox(),
			),
			'post_cat_layout' => array(
				'title'   => esc_html__( 'Style settings', 'origin' ),
				'type'    => 'tab',
				'options' => array(
					'blog_style' => array(
						'type'    => 'multi-picker',
						'label'   => false,
						'desc'    => false,
						'picker'  => array(
							'style' => array(
								'type' 				=> 'select',
								'choices'	 		=> array(
									'default'		=> esc_html__('Default', 'origin'),
									'large'		 	=> esc_html__('Large', 'origin'),
									'grid' 			=> esc_html__('Grid', 'origin'),
									'medium' 		=> esc_html__('Medium', 'origin'),
									'masonry' 		=> esc_html__('Masonry', 'origin'),
								),
								'value'				=> 'default',
							),
						),
						'choices' 	=> array(
							'grid' 				=> array(
								'column' 		=> array(
										'type' 				=> 'select',
										'choices'	 		=> array(
											'columns-2'		=> esc_html__('2 columns', 'origin'),
											'columns-3' 	=> esc_html__('3 columns', 'origin'),
											'columns-4' 	=> esc_html__('4 columns', 'origin'),
										),
										'value'					=> 'columns-2',
									)
							),
							'masonry' 			=> array(
								'column' 		=> array(
									'type' 				=> 'select',
									'choices'	 		=> array(
										'columns-2'		=> esc_html__('2 columns', 'origin'),
										'columns-3' 	=> esc_html__('3 columns', 'origin'),
										'columns-4' 	=> esc_html__('4 columns', 'origin'),
									),
									'value'					=> 'columns-2',
								)
							),
						),
					),
					'blog_loadmore' => array(
						'type'    => 'multi-picker',
						'label'   => false,
						'desc'    => false,
						'picker'  => array(
							'custom_loadmore' => array(
								'type'  => 'switch',
								'value' => '',
								'label' => esc_html__('Custom Pagination', 'origin'),
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__('Yes', 'origin'),
								),
								'left-choice' => array(
									'value' => '',
									'label' => esc_html__('No', 'origin'),
								),
							),
						),
						'choices' 	=> array(
							'yes' 				=> array(
								'_type' 		=> array(
									'type' 				=> 'select',
									'choices'	 		=> array(
										'wp_pagination'       => esc_html__('WP Pagination', 'origin'),
										'pagination_ajax'     => esc_html__('Pagination Number ajax', 'origin'),
										'pagination_infinite' => esc_html__('Infinite scroll', 'origin'),
										'pagination_button'   => esc_html__('Loadmore button', 'origin'),
									),
									'value'					=> 'wp_pagination',
								),
								'_stop_after'	=> array(
									'type'	=> 'text',
									'title'	=> esc_html__( 'Stop infinite scroll after', 'origin' ),
								),
							),
						),
					),
				),
			),
		),
	),
); 