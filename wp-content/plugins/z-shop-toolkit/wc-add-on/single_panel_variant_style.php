<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$post_id = $post->ID;

$product_object = $post_id ? wc_get_product( $post_id ) : new WC_Product();
// $product_object = new WC_Product( $post_id );

if ( ! $product_object->is_type( 'variable' ) ) {
	echo '<div id="basr_variation_style" class="panel woocommerce_options_panel">';
	echo '<p>' . esc_html__( ' Only work with Variable Product', 'moodshop-shortcodes' ) . '</p>'; 
	echo '</div>';
	return;
}

$available_variations = $product_object->get_variation_attributes();

if ( ! $available_variations ) return;

?>
<div id="basr_variation_style" class="panel woocommerce_options_panel">
	
	<?php

	foreach ( $available_variations as $key => $atts ) :

		echo '<div class="wrap-item">';

		$label = $key;
		if ( preg_match( '/pa_/' , $key ) ) {
			$tax_atts = get_taxonomy( $key );
			if ( $tax_atts ) {
				$label  = $tax_atts->labels->singular_name;
				$prefix = '';	
			} 
		}

		$key = str_replace( ' ', '-', $key );

		// lf( array(
		// 	'id'             => strtolower( $key ) . '-type',
		// 	'value'          => $this->get_meta_box_value( $post_id, strtolower( $key ) . '-type' ) ,
		// 	'label'          => $label,
		// 	'class'			 => 'trigger-type',
		// 	'options'        => $this->type,
		// 	'desc_tip'       => 'true',
		// 	'description'    => __( 'If is default, It will apply setting from Dashboard > Product > Variation Style', 'moodshop-shortcodes' ),
		// ) );

		woocommerce_wp_select( array(
			'id'             => strtolower( $key ) . '-adtype',
			'value'          => $this->get_meta_box_value( $post_id, strtolower( $key ) . '-adtype' ) ,
			'label'          => $label,
			'class'			 => 'trigger-type',
			'options'        => $this->type,
			'desc_tip'       => 'true',
			'description'    => __( 'If is default, It will apply setting from Dashboard > Product > Variation Style', 'moodshop-shortcodes' ),
		) );

		echo '<div class="wrap-term type-color" style="display: none">';
			$output = '';
			foreach ( ( array ) $atts  as $term ) {
				$output .= '<div class="wrap-term-item">';
					$output .= '<p class="form-field ' . strtolower( $key ) . '-' . strtolower( $term ) . '-color' . '_field ">';
					$output .= '<label>' . $term . '</label>';
					$output .= '<input class="option wp-color-picker ' . strtolower( $key ) . '-' . strtolower( $term ) . '-color" value="' . get_post_meta( $post_id, strtolower( $key ) . '-' . bin2hex( strtolower( $term ) ) . '-color', true ) . '" name="' . strtolower( $key ) . '-' . bin2hex( strtolower( $term ) ) . '-color" >';
					$output .= '</p>';
				$output .= '</div>';
			}

			echo $output;

		echo '</div>'; // .wrap-term


		echo '<div class="wrap-term type-image" style="display: none">';
			$output = '';
			foreach ( ( array ) $atts  as $term ) {
				$img_key   = strtolower( $key ) . '-' . bin2hex( strtolower( $term ) ) . '-image';
				$img_id = get_post_meta( $post_id, $img_key, true );
				$img_url = $img_id ? wp_get_attachment_image_src( $img_id, 'thumb' )[0] : '';
				$output .= '<div class="wrap-term-item">';
					$output .= '<p class="form-field ' . $img_key . '_field ">';
					$output .= '<label>' . $term . '</label>';
					$output .= "<img style='cursor:pointer' class='image-preview' src='$img_url' width='100' height='100' style='max-height: 100px; width: 100px;' />";
					$output .= "<input type='hidden' name='" . $img_key . "' class='image_attachment_id' value='$img_id'>";
				$output .= '</div>';
			}

			echo $output;

		echo '</div>'; // .wrap-term

		echo '</div>'; // .wrap-item


	endforeach;
		
	?>

</div>
