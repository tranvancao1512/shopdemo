<?php
/*
Description: Variant style page backend 
Author: SunriseTheme
Author URI: http://SunriseTheme.com
*/

$variant_type = array ( 
	'default'  => esc_html__( 'Default', 'moodshop-shortcodes' ),
	'color'    => esc_html__( 'Color', 'moodshop-shortcodes' ),
	'checkbox' => esc_html__( 'Checkbox', 'moodshop-shortcodes' ),
	'image'    => esc_html__( 'Image', 'moodshop-shortcodes' ),
);

$attributes = wc_get_attribute_taxonomies();

$output = '<div class="basr-wrap">';

foreach ( $attributes as $key => $attr ) {

	$taxonomy = wc_attribute_taxonomy_name( $attr->attribute_name );
	if ( taxonomy_exists( $taxonomy ) ) {
		$terms = get_terms( $taxonomy, 'hide_empty=0&menu_order=ASC' );
	}

	// label

	$output .= '<div class="wrap-item">';

	$output .= '<div class="wc-attr-item ' . $attr->attribute_name  . ' "><h3>' . $attr->attribute_label . '</h3>';

	// choose type 
	$output .= '<select class="option ' . $attr->attribute_name . '-type trigger-type" data-name="' . $attr->attribute_name . '-type" >';

	$data_type = get_option( $attr->attribute_name . '-type' );

	foreach ( $variant_type as $type => $label ) {
		if ( $data_type == $type ) $selected = 'selected'; else $selected = '';
		$output .= '<option value="' . $type . '" ' . $selected . '>' . $label . '</option>';
	}

	$output .= '</select>';

	$output .= '</div>'; // wc-attr-item

	// option detail for term color

	$output .= '<div class="wrap-terms type-color">';

	if ( isset( $terms ) ) {
		foreach ( $terms  as $term ) {
			$output .= '<div class="wrap-term-item">';
			$output .= '<p>' . $term->name . '</p>';
			$output .= '<input class="option wp-color-picker term-' . $term->term_id . '" value="' . get_option( 'term-' . $term->term_id . '-color' ) . '" data-name="term-' . $term->term_id . '-color" >';
			$output .= '</div>';
		}
	}

	$output .= '</div>'; // wrap-terms

		// option detail for term color

	$output .= '<div class="wrap-terms type-image">';

	if ( isset( $terms ) ) {
		foreach ( $terms  as $term ) {
			$attachment = get_option( 'term-' . $term->term_id . '-image' );
			$css = '';
			if ( isset($attachment) && $attachment ) {
				$css = 'style="background-image: url(' . wp_get_attachment_url( $attachment ) . ');"'; 
			}
			$output .= '<div class="wrap-term-item">';
			$output .= '<p>' . $term->name . '</p>';
			$output .= '<span class="option get-image term-' . $term->term_id . '" data-id="' . $attachment . '" data-name="term-' . $term->term_id . '-image" ' . $css . '></span>';
			$output .= '</div>';
		}
	}

	$output .= '</div>'; // wrap-terms

	$output .= '</div>'; // .wrap-item;

}

$output .= '<button class="basr-save button button-primary">' . esc_html__( 'Save', 'moodshop-shortcodes' ) . '</button>';
$output .= '<a class="button loader" style="border: none;box-shadow:none;background: transparent;"></a>';

$output .= '</div>'; // .basr-wrap

echo $output;