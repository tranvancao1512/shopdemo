<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$current_header_version = fw_get_db_settings_option('header_version');
$options = array(
	'page_blog' => array(
		'type' => 'multi-select',
		'label' => esc_html__('Blog template page settings', 'origin'),
		'population' => 'taxonomy',
		'source' => 'category',
	),
	'page_blog_style' => array(
		'type' => 'select',
		'label' => esc_html__('Blog Style', 'origin'),
		'value' => 'large',
		'choices' => array(
			'large' => esc_html__('Large', 'origin'),
			'grid' => esc_html__('Grid', 'origin'),
			'medium' => esc_html__('Medium', 'origin'),
			'masonry' => esc_html__('Masonry', 'origin'),
		),
	),
	'page_blog_column' => array(
		'type' => 'select',
		'label' => esc_html__('Number of Columns', 'origin'),
		'desc' => esc_html__('Apply for Grid or Masonry style', 'origin'),
		'value' => '3',
		'choices' => array(
			'columns-2' => esc_html__('2 Columns', 'origin'),
			'columns-3' => esc_html__('3 Columns', 'origin'),
			'columns-4' => esc_html__('4 Columns', 'origin'),
			'columns-5' => esc_html__('5 Columns', 'origin'),
		),
	),
	'page_blog_posts_per_page' => array(
		'type' => 'text',
		'label' => esc_html__('Posts per page', 'origin'),
		'value' => '10',
	),
	'page_infinite_scroll' => array(
		'type' => 'select',
		'label' => esc_html__('Pagination style', 'origin'),
		'choices' => array(
			'pagination_ajax'     => esc_html__('Pagination Number ajax', 'origin'),
			'pagination_infinite' => esc_html__('Infinite scroll', 'origin'),
			'pagination_button'   => esc_html__('Loadmore button', 'origin'),
		),
	),
	'infinite_stop_after' => array(
		'type' => 'text',
		'label' => esc_html__('Infinite scroll stop after: ', 'origin'),
	),
);
