<?php
/**
 * Template Name: Blogs
 *
 ** @since Ln Moonlight 1.0.0
 */
get_header(); ?>

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
	?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php

			if ( $query->have_posts() ) :

				get_template_part( 'templates/blogs/loop-query', 'blogs' );

			else :

				get_template_part( 'templates/post/content', 'none' );

			endif; 

			wp_reset_postdata();

			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php get_sidebar(); ?>

<?php get_footer();
