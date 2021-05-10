<?php
/**
 * Single, Blogs helpers
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
 * Blogs help
 */

if ( ! function_exists( 'origin_blogs_loop_start' ) ) {
	function origin_blogs_loop_start() { 


		$classes   = array();


		$classes[] = 'blog-loop';

		if ( defined('FW') ) {
			$classes = '';
		} else {

		}

		echo implode( ' ', $classes );

	}
}

if ( ! function_exists( ' origin_blogs_loop_end' ) ) {
	function origin_blogs_loop_end() { 

		echo 'loop-end';;

	}
}



