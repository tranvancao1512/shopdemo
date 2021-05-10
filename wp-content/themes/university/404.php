<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package University
 */

get_header(); ?>
<div id="contentwrapper">
<div id="content">
      <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'university' ); ?>
      <?php get_search_form(); ?>
    </div>
     <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
