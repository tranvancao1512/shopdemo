<?php
/**
 * The template for displaying pagination
 *
 * This template can be overridden by childtheme
 *
 * @author Lunartheme
 * @package basrpo/template
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


$pagination_type = 'wp_pagination';


if ( get_post_type() == 'post' && ! is_page_template('page-templates/page-blog.php') ) {
	if ( is_tag() || is_category() || is_tax() ) {
		$pagination_type = origin_get_setting( 'blog_infinite_scroll' );
	}

	if ( $pagination_type == 'pagination_infinite' ) {
		$stop_after = origin_get_setting( 'infinite_stop_after' );
		$stop_after = intval( $stop_after ) ? intval( $stop_after ) : 9999;
	}

	$queried = get_queried_object();

	$data_query = array(
		'post_type'      => get_post_type(),
		'posts_per_page' => get_option('posts_per_page'),
		'post_status'	 => 'publish'
	);

	if ( is_category() ) $data_query['cat']		= $queried->term_taxonomy_id;
	if ( is_tag() )		 $data_query['tag_id'] 	= $queried->term_taxonomy_id;
	if ( is_tax() ) {
		$data_query['taxonomy'] = array(
			'taxonomy'	=> $queried->taxonomy,
			'fields'	=> 'term_id',
			'terms'		=> array( $queried->term_taxonomy_id ),
		);
	}

	$template = 'blog-large';

	if( is_category() ) {
		$blog_style = origin_get_term_meta( 'blog_style', $queried->taxonomy, $queried->term_id );
		if ( ! isset( $blog_style ) || $blog_style['style'] == 'default' ) {
			$blog_style = origin_get_setting( 'blog_style' );
		}
		$blog_paginatin_stt = origin_get_term_meta( 'blog_loadmore', $queried->taxonomy, $queried->term_id );
		if ( isset( $blog_paginatin_stt['custom_loadmore'] ) &&  $blog_paginatin_stt['custom_loadmore'] ) {
			$pagination_type = $blog_paginatin_stt['yes']['_type'];
			$stop_after      = $blog_paginatin_stt['yes']['_stop_after'];
		}
		$template = 'blog-' . $blog_style['style'];
	}

	$data_query = json_encode( $data_query );
}

// For Page template

if ( is_page_template('page-templates/page-blog.php') ) {

	$page_template_stt = array(
		'page_blog_style'          => 'large',
		'page_infinite_scroll'     => 'pagination_ajax',
		'infinite_stop_after'      => '',
		'page_blog'                => array(),
		'page_blog_posts_per_page' => get_option( 'posts_per_page' ),
	);
	if ( defined('FW') ) {
		$page_template_stt = origin_get_post_meta( $page_template_stt, get_the_ID() );
	}

	$data_query = array(
		'post_type'			=> 'post',
		'cat'				=> implode( ',' , $page_template_stt['page_blog'] ),
		'posts_per_page'	=> $page_template_stt['page_blog_posts_per_page'],
		'post_status'	 	=> 'publish'
	);

	$query           = new WP_Query( $data_query );
	
	$template        = 'blog-' . $page_template_stt['page_blog_style'];
	$pagination_type = $page_template_stt['page_infinite_scroll'];
	$stop_after      = ( $page_template_stt['infinite_stop_after'] ) ? $page_template_stt['infinite_stop_after'] : 9999;
	$max_paged       = $query->max_num_pages;

	$data_query = json_encode( $data_query );
}

// check if is_tax get paged from global

$data_extra = '';

if ( isset( $pagination_stt ) ) {

	$data_query      = $pagination_stt['query'];
	$template        = $pagination_stt['template'];
	$stop_after      = intval( $pagination_stt['stop_after'] ) ? intval( $pagination_stt['stop_after'] ): 9999;
	$pagination_type = $pagination_stt['pagination_type'];
	$max_paged       = $pagination_stt['max_paged'];
	$data_extra      = $pagination_stt['data_extra'];

	if ( $max_paged <= 1 ) return;
}

$max_paged  = isset( $max_paged ) ? $max_paged : '';

// Default WP

if ( $pagination_type == 'wp_pagination' ) {
	echo '<div class="basr-pagination number">';
		origin_pagination();
	echo '</div>';
}

// Default WP with ajax

if ( $pagination_type == 'pagination_ajax' ) {
	echo '<div class="basr-pagination number basr-wp-pagi-ajax" data-query=' . esc_attr( $data_query ) . ' data-template=' . esc_attr( $template ) .
			' data-max=' . esc_attr( $max_paged ) . ' data-extra=' . esc_attr( $data_extra ) . '>';
		origin_pagination(  $max_paged  );
	echo '</div>';
}

// Default Infinite scroll

if ( $pagination_type == 'pagination_infinite' ) {

	$current = max( 1, get_query_var('paged') );

	echo '<div class="basr-pagination basr-wp-infi-ajax infinite" data-query=' . esc_attr( $data_query ) . ' data-template=' . esc_attr( $template ) . 
			' data-max=' . esc_attr( $max_paged ) . ' data-extra=' . esc_attr( $data_extra ) . '>';
		echo '<a class="basr-infinite-scroll button" href="#" data-paged= ' . esc_attr( $current ) . ' data-stop=' . esc_attr( $stop_after ) . '>' . esc_html__( 'Infinite Scroll', 'origin' ) . '</a>';
	echo '</div>';
}

// Load more button

if ( $pagination_type == 'pagination_button' ) {

	$current = max( 1, get_query_var('paged') );

	echo '<div class="basr-pagination basr-wp-infi-ajax" data-query=' . esc_attr( $data_query ) . ' data-template=' . esc_attr( $template ) .
			' data-max=' . esc_attr( $max_paged ) . ' data-extra=' . esc_attr( $data_extra ) . '>';
		echo '<a class="basr-infinite-scroll button" href="#" data-paged= ' . esc_attr( $current ) . '>' . esc_html__( 'Load More', 'origin' ) . '</a>';
	echo '</div>';
}

do_action( 'origin_after_pagination' );


