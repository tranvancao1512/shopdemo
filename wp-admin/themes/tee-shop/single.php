<?php
/**
 * The template for displaying all single posts
 *
 * @package ln-moonlight
 * @since 1.0
 * @version 1.0
 */
get_header(); ?>

	<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post();

			get_template_part( 'templates/post/content', 'single' );

			// related posts

			get_template_part( 'templates/blogs/related', 'blogs' );

			// If comments are open or we have at least one comment, load up the comment template.

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			// the_post_navigation();

		endwhile; // End of the loop.
	?>

<?php get_footer();
