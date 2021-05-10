<?php
/**
 * The template for displaying all footer single
 *
 * @package ln-moonlight
 * @since 1.0
 * @version 1.0
 */
get_header(); ?>

	<div id="primary" class="content-area" style="width: 100% !important;">
		<main id="main" class="site-main" role="main">

			<?php
				while ( have_posts() ) : the_post();

					the_content();

				endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php 
get_footer();
