<?php
/**
 * origin_before_blogs_loop_start hook.
 *
 */
do_action( 'origin_before_blogs_loop_start' );
?>

<?php origin_blogs_loop_start(); ?>

<?php
/**
 * origin_after_blogs_loop_start hook.
 * isotope filter
 */
do_action( 'origin_after_blogs_loop_start' );
?>

<?php

$blogs = array( 
	'page_blog'	=> '',
	'page_blog_posts_per_page'	=> get_option( 'posts_per_page' ),
);

if ( defined('FW') ) {
	$blogs = origin_get_post_meta( $blogs, get_the_ID() );
}

$args = array(
	'post_type'			=> 'post',
	'cat'				=> implode( ',' , $blogs['page_blog'] ),
	'posts_per_page'	=> $blogs['page_blog_posts_per_page'],
);

$query = new WP_Query( $args );

if ( $query ) {
	while ( $query->have_posts() ) : $query->the_post();

		get_template_part( 'templates/blogs/content', 'blog' );

	endwhile;
} else {
	while ( have_posts() ) : the_post();

		get_template_part( 'templates/blogs/content', 'blog' );

	endwhile;
}
/**
 * origin_before_blogs_loop_end hook.
 *
 */
do_action( 'origin_before_blogs_loop_end' );
?>

<?php origin_blogs_loop_end(); ?>

<?php
/**
 * origin_after_blogs_loop_end hook.
 */
do_action( 'origin_before_blogs_loop_end' );
wp_reset_postdata();

get_template_part( 'templates/globals/basr', 'pagination' );
