<?php
/**
 * The Template for displaying all single posts.
 *
 * @package University
 */

get_header(); ?>
<div id="contentwrapper">
  <div id="content">
    <?php while ( have_posts() ) : the_post(); ?>
    <div <?php post_class(); ?>>
      <h1 class="entry-title">
        <?php the_title(); ?>
      </h1>
      <div class="entry">
        <?php the_content(); ?>
        <?php edit_post_link(); ?>
        <?php echo get_the_tag_list('<p class="singletags">',' ','</p>'); ?>
        <?php comments_template(); ?>
      </div>
    </div>
    <?php endwhile; // end of the loop. ?>
  </div>
  <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
