<?php
/**
  * The template for displaying Archive pages.
 *
 * @package University
 */

get_header(); ?>

<div id="contentwrapper">
  	<div id="content">
   		<?php
			the_archive_title( '<h1 class="archive-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>

		<?php if (have_posts()) : ?>
  		<?php while ( have_posts() ) : the_post();
  			get_template_part( 'content', get_post_format() );
  		endwhile; ?>

		<?php the_posts_pagination(); ?>

		<?php else : ?>
  
  			<p class="center">
    			<?php esc_html_e( 'You don&#39;t have any posts yet.', 'university' ); ?>
  			</p>
  		<?php endif; ?>
  	</div>
  	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
