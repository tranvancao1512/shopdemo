<?php
/**
 * The template for displaying blog content within loops
 *
 * This template can be overridden by childtheme
 *
 * @author Lunartheme
 * @package basrpo/template
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<article <?php post_class('grid-item'); ?>>
	<?php
	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked origin_post_meta_thumbnail - 10
	 */
	do_action( 'origin_before_blog_loop_item_title' );	// prefix 1**

	/**
	 * origin_blog_loop_item_title hook.
	 *
	 * @hooked origin_show_blog_loop_item_tilte - 10
	 */
	do_action( 'origin_blog_loop_item_title' );			// prefix 2**

	/**
	 * origin_after_blog_loop_item_title hook.
	 *
	 * @hooked origin_post_meta_author - 10
	 * @hooked origin_post_meta_date - 15
	 * @hooked origin_post_meta_categories - 20
	 */
	do_action( 'origin_after_blog_loop_item_title' );	// prefix 3**

	/**
	 * origin_blog_loop_item_excerpt hook.
	 *
	 * @hooked origin_blog_loop_item_excerpt - 10
	 */
	do_action( 'origin_blog_loop_item_excerpt' );		// prefix 4**

	/**
	 * origin_after_blog_loop_item_excerpt hook.
	 *
	 * @hooked origin_post_meta_morelink -10
	 */
	do_action( 'origin_after_blog_loop_item_excerpt' );	// prefix 5**

	?>
</article> <!-- End article post -->