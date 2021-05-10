<?php
/**
 * Template Name: Full Width
 *
 * @package University
 */

get_header(); ?>

<div id="contentwrapper">
  <div id="contentfull">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
      <h1 class="entry-title">
        <?php the_title(); ?>
      </h1>
      <div class="entry">
        <?php the_content(); ?>
        <?php edit_post_link(); ?>
        <?php comments_template( '', true ); ?>
        <?php wp_link_pages(array('before' => '<p><strong>'. esc_attr__( 'Pages:', 'university' ) .'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
      </div>
    </div>
    <?php endwhile; endif; ?>
  </div>
</div>
<?php get_footer(); ?>
