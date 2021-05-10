<?php
/**
 * The template for displaying search results pages
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package ln-moonlight
 * @since   1.0
 * @version 1.0
 */
get_header(); ?>


	<?php

	global $wp_query;

	/* Start the Loop */
	if ( have_posts() ) {

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

		//while ( $q->have_posts() ) {
			// $q->the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			// do_action( 'woocommerce_shop_loop' );

			// wc_get_template_part( 'content', 'product' );
		// }

		woocommerce_product_loop_end();

		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action( 'woocommerce_no_products_found' );
	}

	// $nav_page .= '</div></nav>';

    the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => sprintf(
				'<span class="nav-prev-text">%s</span>',
				'←',
			),
			'next_text' => sprintf(
				'<span class="nav-next-text">%s</span>',
				'→',
			),
		)
	);

	?>

	<?php get_sidebar(); ?>

<?php get_footer();
