<?php
/**
 * Extra helpers functions
 *
 * @package ln-moonlight
 * @since   1.0.0
 * @version 1.0.0
 */

/**
 * Don't access directly.
 */
defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

/**
 * Compare two unknow depth array and return the diferrences
 *
 * @param array $array1  First array to compare.
 * @param array $array2  Second array to compare to.
 * @param array $include Always include this item.
 *
 * @return array
 */
function origin_array_diff_recusive( $array1 = array(), $array2 = array(), $include = array() ) {

	$output = array();
	foreach ( $array1 as $key => $value ) {
		if ( in_array( $key, $include ) ) {
			$output[ $key ] = $value;
		}
		if ( array_key_exists( $key, $array2 ) ) {
			if ( is_array( $value ) ) {
				if ( is_array( $array2[ $key ] ) ) {
					$output[ $key ] = origin_array_diff_recusive( $value, $array2[ $key ] );
				} else {
					$output[ $key ] = $value;
				}
			} else {
				if ( $array1[ $key ] !== $array2[ $key ] ) {
					$output[ $key ] = $value;
				}
			}
		} else {
			$output[ $key ] = $value;
		}
	}

	return array_filter( $output );
}

/**
 * Add unit to number variable. Strip all no numeric from string then add unit.
 *
 * @param string $value Raw value, probably has unit.
 * @param string $unit  Unit to add, default is px.
 *
 * @return string
 */
function origin_unit( $value = '', $unit = 'px' ) {

	return filter_var( $value, FILTER_SANITIZE_NUMBER_INT ) . $unit;
}

/**
 * Check value of a property before printing it.
 *
 * @param $property
 * @param $value
 * @param $unit
 *
 * @return string|void
 */
function origin_safe_print_css( $property = '', $value = '', $unit = '' ) {

	if ( ! isset( $value ) || empty( $value ) ) {
		return;
	}

	if ( is_array( $value ) ) {
		if ( array_key_exists( $property, $value ) ) {
			if ( $unit === 'px' || $unit === '%' ) {
				return $property . ': ' . origin_unit( $value[ $property ], $unit ) . ';';
			}

			return $property . ': ' . $value[ $property ] . ';';
		} else {
			return;
		}
	}

	if ( $unit === 'px' || $unit === '%' ) {
		return $property . ': ' . origin_unit( $value, $unit ) . ';';
	}

	return $property . ': ' . $value . ';';
}

function origin_pagination( $max_paged = '', $current = 1 ) {
	global $wp_query;

	if ( $max_paged == '' ) {
		$max_paged = $wp_query->max_num_pages; 
		$current = max( 1, get_query_var('paged') );
	}

	$big = 999999999; // need an unlikely integer
	$translated = __( 'Page', 'origin' ); // Supply translatable string

	echo '<div class="wrap-pagination">';

	echo paginate_links( 
			array(
				'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'             => '?paged=%#%',
				'current'            => intval( $current ),
				'total'              => $max_paged,				
				'before_page_number' => '<span class="screen-reader-text">'. $translated .' </span>'
			) 
		);

	echo '</div>';
}

function origin_vc_video( $sc = '' ) {
	global $wp_embed;
	$output  = '<div class="basr-wrap-inner-video">';
	$output .= $wp_embed->run_shortcode( $sc );
	$output .= '</div>';
	echo $output;
}

function origin_posts_array( $post_type = '' ) {
	$args = array(
		'post_type'	=> $post_type,
		'post_status' => 'publish',
	);

	$posts_array = get_posts( $args );

	$posts  = array();

	foreach ($posts_array as $key => $obj ) {
		$posts[ $obj->ID ] = $obj->post_title;
	}

	return $posts;
}
