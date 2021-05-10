<?php
/**
 * Templating helpers
 *
 * @package ln-moonlight
 * @since   1.0.0
 * @version 1.0.0
 */

/**
 * Don't access directly.
 */
defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

// for dynamic style 

// typo defaul function 

if ( ! function_exists( 'origin_default_typo' ) ) {

	function origin_default_typo( $key = ''){

		$typo = array( 

			// colors

			'primary_color'		=> '#f6c93b',
			'second_color'		=> '#00dccb',
			'third_color'		=> '#ffc80b',

			// body typo

			'typo_body'			=> array(
					'family'	=> 'Noto Sans',
					'style'		=> 'regular',
					'color'		=> '#a1a1a1',
					'size'		=> 16,
				),

			// link 

			'link_color'		=> '',

			'link_color_hover'	=> '',


			// header 

			'typo_main_nav'	=> array(
					'family'	=> 'Noto Sans',
					'style'		=> '700',
					'color'		=> '#2e2e2e',
					'size'		=> 12,
				),

			'main_nav_hover'	=> array(
					'color'		=> '',
				),

			'typo_sub_nav'	=> array(
					'family'	=> 'Noto Sans',
					'style'		=> '700',
					'color'		=> '#2e2e2e',
					'size'		=> 12,
				),

			'sub_nav_hover'	=> array(
					'color'		=> '#f6c93b',
				),

			// heading 

			'typo_heading'		=> array(
					'family'	=> 'Noto Sans',
					'style'		=> '700',
					'color'		=> '#000000',
				),
			'heading_h1'		=> array(
					'size'		=> '60',
				),
			'heading_h2'		=> array(
					'size'		=> '48',
				),
			'heading_h3'		=> array(
					'size'		=> '36',
				),
			'heading_h4'		=> array(
					'size'		=> '24',
				),
			'heading_h5'		=> array(
					'size'		=> '21',
				),
			'heading_h6'		=> array(
					'size'		=> '18',
				),

			// footer

			'footer_typo'			=> array(
				'family'	=> 'Raleway',
				'style'		=> 'regular',
				'color'		=> '#313131',
				'size'		=> 16,
			),

			'footer_typo_heading'		=> array(
					'family'	=> 'Oswald',
					'style'		=> '700',
					'color'		=> '#252525',
				),
			'footer_heading_h1'		=> array(
					'size'		=> '45',
				),
			'footer_heading_h2'		=> array(
					'size'		=> '36',
				),
			'footer_heading_h3'		=> array(
					'size'		=> '30',
				),
			'footer_heading_h4'		=> array(
					'size'		=> '18',
				),
			'footer_heading_h5'		=> array(
					'size'		=> '16',
				),
			'footer_heading_h6'		=> array(
					'size'		=> '14',
				),
			);

		// array $key 

		if ( is_array( $key ) ) {
			$temp = array();
			foreach ($key as $k => $v) {
				if ( isset( $typo[ $k ] ) ) {
					$temp[ $k ] = $typo[ $k ];
				}
			}
			return $temp;
		}

		// heading_h*

		if ( preg_match( '/heading_\w\d/', $key ) ) {
			return $typo[ $key ]['size'];
		}

		if ( ! empty( $key ) ) return isset( $typo[ $key ] ) ?  $typo[ $key ] : '';

		return $typo;
	}
}

// typo help

if ( ! function_exists( 'origin_typo_convert_to_css' ) ) {
	function origin_typo_convert_to_css( $key ) {

		$css = array();

		if ( is_array( $key ) ) {
			foreach ($key as $k => $v ) {
				switch ($k) {
					case 'family':
							$css[] = 'font-family: ' . $v;
						break;
					case 'size':
							if ( intval( $v ) ) $css[] = 'font-size: ' . intval( $v ) . 'px';
						break;
					case 'color':
							$css[] = 'color: ' . $v;
						break;
					case 'style':
							$css[] = 'font-weight: ' . $v;
						break;
					
					default:
						break;
				}
			}
		}

		return implode( ';', $css );

	}
}