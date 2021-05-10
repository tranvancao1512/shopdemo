<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ln-moonlight
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<!-- Primary -->

	<?php
	while ( have_posts() ) : the_post();

		get_template_part( 'templates/page/content', 'page' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // End of the loop.
	?>

	<!-- Sidbar -->

<?php get_footer();
