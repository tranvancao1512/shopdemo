<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package University
 */

get_header(); ?>
<div id="contentwrapper">
  <div id="content">
   <?php if (have_posts()) : ?>
  		<?php while ( have_posts() ) : the_post();
  			get_template_part( 'content', get_post_format() );
  		endwhile; ?>

		<?php the_posts_pagination(); ?>

		<?php else : ?>
    <p class="center"><?php esc_html_e( 'No Posts Found.', 'university' ); ?></p>
    <?php endif; ?>
  </div>
  <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
