<?php 

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

	'blogs' => array(
		'title'   => esc_html__( 'Blogs Setting', 'origin' ),
		'type'    => 'tab',
		'options' => array(
			'blog_style' 		=> array(
				'type' 				=> 'select',
				'choices'	 		=> array(
					'large'		 	=> esc_html__('Large', 'origin'),
					'grid' 			=> esc_html__('Grid', 'origin'),
					'medium' 		=> esc_html__('Medium', 'origin'),
					'masonry' 		=> esc_html__('Masonry', 'origin'),
				),
				'value'				=> 'large',
			),
			'blog_style' => array(
				'type'    => 'multi-picker',
				'label'   => false,
				'desc'    => false,
				'picker'  => array(
					'style' => array(
						'type' 				=> 'select',
						'choices'	 		=> array(
							'large'		 	=> esc_html__('Large', 'origin'),
							'grid' 			=> esc_html__('Grid', 'origin'),
							'medium' 		=> esc_html__('Medium', 'origin'),
							'masonry' 		=> esc_html__('Masonry', 'origin'),
						),
						'value'				=> 'large',
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
			'blog_content_or_excerpt' => array(
				'type' => 'multi-picker',
				'value' => array(
					'display_type' => 'excerpt',
				),
				'label' => false,
				'picker' => array(
					'display_type' => array(
						'type' => 'select',
						'label' => esc_html__('Content or Excerpt', 'origin'),
						'choices' => array(
							'content' => esc_html__('Content', 'origin'),
							'excerpt' => esc_html__('Excerpt', 'origin'),
						),
					),
				),
				'choices' => array(
					'excerpt' => array(
						'length' => array(
							'type' => 'td-slider',
							'value' => 40,
							'label' => esc_html__('Excerpt length (words)', 'origin'),
							'properties' => array(
								'min' => 10,
								'max' => 100,
								'step' => 1, // Set slider step. Always > 0. Could be fractional.
							),
						),
					),
				),
			),
			'blog_infinite_scroll' => array(
				'type' => 'select',
				'label' => esc_html__('Pagination style', 'origin'),
				'choices' => array(
					'wp_pagination'       => esc_html__('WP Pagination', 'origin'),
					'pagination_ajax'     => esc_html__('Pagination Number ajax', 'origin'),
					'pagination_infinite' => esc_html__('Infinite scroll', 'origin'),
					'pagination_button'   => esc_html__('Loadmore button', 'origin'),
				),
			),
			'infinite_stop_after' => array(
				'type' => 'text',
				'label' => esc_html__('Infinite scroll stop after: ', 'origin'),
			),
			'blog_category_filter' => array(
				'type'  => 'switch',
				'value' => 'no',
				'label' => esc_html__('Categories Filter', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => 'no',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
			'blog_title_link' => array(
				'type'  => 'switch',
				'value' => 'no',
				'label' => esc_html__('Title Link', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => 'no',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
			'blog_post_date' => array(
				'type'  => 'switch',
				'value' => 'yes',
				'label' => esc_html__('Post Date', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => 'no',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
			'blog_number_of_comments' => array(
				'type'  => 'switch',
				'value' => 'yes',
				'label' => esc_html__('Number of Comments', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => 'no',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
			'blog_categories' => array(
				'type'  => 'switch',
				'value' => 'yes',
				'label' => esc_html__('Categories', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => 'no',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
			'blog_author' => array(
				'type'  => 'switch',
				'value' => 'yes',
				'label' => esc_html__('Author', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => 'no',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
			'blog_readmore' => array(
				'type'  => 'switch',
				'value' => 'yes',
				'label' => esc_html__('Readmore Link', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => 'no',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
		),
	),
);
