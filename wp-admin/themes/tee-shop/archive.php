<?php
/**
 * The template for displaying archive pages
 *
 * @package ln-moonlight
 * @since 1.0.0
 * @version 1.0.0
 */

get_header(); ?>

	<?php
	if ( have_posts() ) :
		if ( get_post_type() == 'product' ) {
			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );

			woocommerce_product_loop_start();

			while ( have_posts() ) {
				the_post();

				/**
				 * Hook: woocommerce_shop_loop.
				 *
				 * @hooked WC_Structured_Data::generate_product_data() - 10
				 */
				do_action( 'woocommerce_shop_loop' );

				wc_get_template_part( 'content', 'product' );
			}

			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			get_template_part( 'templates/blogs/loop', 'blogs' );
		}

	else :

		get_template_part( 'templates/post/content', 'none' );

	endif; ?>


<?php get_footer();
