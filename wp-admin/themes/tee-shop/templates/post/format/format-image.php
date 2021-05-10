<?php
/**
 * The template for displaying single image within loops
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

if ( has_post_thumbnail() ) :

	$image_size = isset( $image_size ) ? $image_size : 'ln-moonlight-blog-large';
	
	if ( is_page_template( 'page-templates/page-blog.php' ) ) {
		$page = get_queried_object();
		$image_size = 'ln-moonlight-blog-' . origin_get_post_meta( 'page_blog_style', $page->ID );
	}

	echo '<div class="post-thumb">';

	printf(
		'<a href="%1$s" title="%2$s">%3$s</a>',
		get_permalink(),
		get_the_title(),
		get_the_post_thumbnail( get_the_ID(), apply_filters( 'origin_single_thumb_size', $image_size ) )
	);

	echo '</div>'; // post-thumb

endif;
