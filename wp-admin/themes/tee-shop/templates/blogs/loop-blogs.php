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
/* Start the Loop */
while ( have_posts() ) : the_post();

	get_template_part( 'templates/blogs/content', 'blog' );

endwhile;
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

get_template_part( 'templates/globals/basr', 'pagination' );