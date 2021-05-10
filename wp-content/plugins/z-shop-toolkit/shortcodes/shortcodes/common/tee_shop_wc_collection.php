<?php


class toolkit_basr_shortcode_tee_shop_wc_collection extends toolkit_basr_shortcode {

	// shortcode name

	public $shortcode = 'tee_shop_wc_collection';

	public function vc_map_shortcode() {
		// fw_print( $list );
		vc_map( array(
				'base' 				=> $this->base,
				'name' 				=> esc_html__( 'Product Collection', 'moodshop-shortcodes' ),
				'class' 			=> '',
				'category' 			=> $this->cat,
				'icon' 				=> $this->icon,
				'params' 			=> array(
					array(
						'param_name'       => $this->base . '_id',
						'heading'          => esc_html__( 'ID', 'moodshop-shortcodes' ),
						'type'             => 'textfield',
						'value'            =>  0,
						'edit_field_class' => 'hidden',
					),
					array(
						'param_name'       => 'cat_id',
						'heading'          => esc_html__( 'Choose Collection', 'moodshop-shortcodes' ),
						'type'             => 'dropdown',
						'value'            => tee_shop_get_collection_wc_list(),
	                ),
	                array(
						'param_name'       => 'limit',
						'heading'          => esc_html__( 'Limit', 'moodshop-shortcodes' ),
						'type'             => 'textfield',
						'value'            => 8,
	                ),
	                array(
						'param_name'       => 'text_type',
						'heading'          => esc_html__( 'Display text type', 'moodshop-shortcodes' ),
						'type'             => 'dropdown',
						'value'            =>  array(
								__('Category name')			=> 'cat',
								__('Category extra des')	=> 'des',
							),
					),

					// More fields here

				),
			)
		);
	}

	// Render html

	public function enqueue_script( $extra = array() ) {
		parent::enqueue_script();
	}

	public function generate_html( $atts, $content = null ) {

		$sc_atts =  array(
			$this->base . '_id' 				=> ''				,

			'cat_id'							=> ''				,
			'text_type'							=> 'cat'			,
			'classes'								=> '',
		);
		foreach( (array)$atts as $key => $value ) {
			$value = preg_replace( '/"/', '', $value );
			$temp = explode('=', $value );
			$atts[$temp[0]] = $temp[1];
			unset( $atts[$key] );
		}
		extract( shortcode_atts( $sc_atts, $atts ) );

		// Enqueue

		$this->enqueue_script(${$this->base . '_id'});

		// get id

		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '', 'woocommerce columns-4' ); // pass id setting if need vc custome css class

		// set up shortcode here

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . '' . '>';

		ob_start();

		// content

		$i = 0;

	
		$thumbnail_id = get_term_meta( $cat_id, 'thumbnail_id', true );
		$image_size   = 'tee-shop-loop';
		$image 		  = wp_get_attachment_image( $thumbnail_id, $image_size );

		$cat 		  = get_term_by( 'id', $cat_id, 'collection' );

		if ( is_object( $cat ) ) {
			$term 		  = get_term( $cat_id, 'collection' );
			$term_link 	  = get_term_link( $term );
			$text_banner_html = '<h2><a href="' . $term_link . '">' . $cat->name . '</a></h2><a class="more" href="' . $term_link . '">More ' . $cat->name . '</a>';

			$output .= $text_banner_html;

			$query_args    = array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'posts_per_page'	  => 8,
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					array(
						'taxonomy' => 'collection',
						'field'    => 'term_id',
						'terms'    => $cat_id,
					),
				),
			);

			$products  = new WP_Query( $query_args  );

			$loop_name = 'shop';

			if ( $products->have_posts() ) {
				?>

				<?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

				<?php woocommerce_product_loop_start(); ?>


					<?php while ( $products->have_posts() ) : $products->the_post(); ?>


						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

				<?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

				<?php
			} else {
				do_action( "woocommerce_shortcode_{$loop_name}_loop_no_results" );
			}

			woocommerce_reset_loop();
			wp_reset_postdata();
		}

		$output .= ob_get_clean();

		$output .= '</div>'; // .$id

		// filter

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'classes'					=> ''			,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';

		return $css;
	}

}
/*
 *  function 4 short register vc map
*/

function tee_shop_get_collection_wc_list() {

	$listing = array();
	$listing[0] = '';

	if ( class_exists('WooCommerce') ) {
		$terms = get_terms( array( 'taxonomy' => 'collection', 'number' => 9999, 'hide_empty' => false ) );
		foreach ( (array) $terms as $key => $value) {
			$listing[ $value->name ] = $value->term_id;
		}
	}

	return $listing;

}