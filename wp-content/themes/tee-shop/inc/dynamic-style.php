<?php
/**
 * Render dynamic style
 *
 * @package ln-moonlight
 ** @since Ln Moonlight 1.0.0
 */

/**
 * Other dynamic 
 */

if ( ! function_exists( 'origin_other_dynamic_style' ) ) {

	add_action( 'wp_enqueue_scripts', 'origin_other_dynamic_style' );

	/**
	 * Render post style from options
	 */
	function origin_other_dynamic_style() {

		if ( !defined( 'FW' ) ) return;

		$css = '';

		$logo = origin_get_setting( 'logo' );

		if ( isset( $logo['_logo']['img']['logo_width'] ) && intval( $logo['_logo']['img']['logo_width'] ) ) {
			$css .= '.mm-logo img {max-width: ' .  intval( $logo['_logo']['img']['logo_width'] ) . 'px;}';
		}

		if ( isset( $logo['_logo']['text']['logo_text_typo']['size'] ) ) {
			$css .= '.m-header .mm-logo .logo-text { ' .
						'font-size: ' . intval( $logo['_logo']['text']['logo_text_typo']['size'] ) . 'px;' .
						'font-weight: ' . $logo['_logo']['text']['logo_text_typo']['style'] . ';' .
						'color: ' . $logo['_logo']['text']['logo_text_typo']['color'] . ';' . 
					'}';
		}
		
		wp_add_inline_style( 'ln-moonlight-style', $css );

	}
}

/**
 * Single dynamic style 
 */

if ( ! function_exists( 'origin_single_dynamic_style' ) ) {

	add_action( 'wp_enqueue_scripts', 'origin_single_dynamic_style' );

	/**
	 * Render post style from options
	 */
	function origin_single_dynamic_style() {

		$css = '';

		if ( is_category() || is_tag() || is_home() || is_page() ) {

			$css = get_option( 'origin_post_css', '' );
		}

		if ( is_single() ) {

			$video_stt = origin_get_post_meta( 'post_format_video', get_the_ID() );

			if ( get_post_format() == 'video' && $video_stt['link']['video_thumb'] && has_post_thumbnail() ) {
				$css .= '.site-main .post .basr-video:before {' .
							'background-image: url(' . get_the_post_thumbnail_url() . ');' .
						'}';
			}

		}
		
		wp_add_inline_style( 'ln-moonlight-style', $css );

	}
}


/**
 * Title bar style
 */
if ( ! function_exists( 'origin_render_title_bar_dynamic_style' ) ) {

	add_action( 'wp_enqueue_scripts', 'origin_render_title_bar_dynamic_style' );

	/**
	 * Render titlebar style from options
	 */
	function origin_render_title_bar_dynamic_style() {

		$title_bar = origin_get_title_bar_settings();

		$title_bar_css = '';

		$title_bar_bg = isset( $title_bar['bg']['image']['data']['icon'] ) ? $title_bar['bg']['image']['data']['icon'] : '';

		$title_bar_css .= '.title-bar {';
		$title_bar_css .= ( $title_bar_bg ) ? 'background-image: url(\'' . $title_bar_bg . '\');' : '';

		$title_bar_css .= ( $title_bar['padding-top'] != '114' ) ?  origin_safe_print_css( 'padding-top'	 , $title_bar, 'px' ) : '';
		$title_bar_css .= ( $title_bar['padding-top'] != '114' ) ?  origin_safe_print_css( 'padding-bottom', $title_bar, 'px' )	  : '';

		if ( isset( $title_bar['bg']['color'] ) ) {
			$title_bar_css .= origin_safe_print_css( 'background-color', $title_bar['bg']['color'] );
		}
		if ( isset( $title_bar['bg']['position'] ) ) {
			$title_bar_css .= origin_safe_print_css( 'background-position', $title_bar['bg']['position'] );
		}
		if ( isset( $title_bar['bg']['repeat'] ) ) {
			$title_bar_css .= origin_safe_print_css( 'background-repeat', $title_bar['bg']['repeat'] );
		}
		if ( isset( $title_bar['bg']['size'] ) ) {
			$title_bar_css .= origin_safe_print_css( 'background-size', $title_bar['bg']['size'] );
		}
		$title_bar_css .= '}';

		if ( isset( $title_bar['color'] ) ) :
			$title_bar_css .= '.title-bar, .title-bar h1, .title-bar p, .title-bar a {';
			$title_bar_css .= 'color: ' . $title_bar['color'] . ';';
			$title_bar_css .= '}';
		endif;

		if ( isset( $title_bar['overlay-color'] ) && $title_bar['overlay-color'] ) :
			$title_bar_css .= '.mask.color {';
			$title_bar_css .= 'background-color: ' . $title_bar['overlay-color'] . ';';
			$title_bar_css .= 'opacity: 0.' . $title_bar['overlay-opacity'] . ';';
			$title_bar_css .= '}';
		endif;

		if ( isset( $title_bar['clipmask-bg']['image']['data']['icon'] ) ) :

			$url = $title_bar['clipmask-bg']['image']['data']['icon'];

			$title_bar_css .= '.title_bar .mask.pattern {';
			$title_bar_css .= 'background-image: url(\'' . esc_url( $url ) . '\');';
			$title_bar_css .= 'opacity: 0.' . $title_bar['clipmask-opacity'] . ';';
			$title_bar_css .= '}';
		endif;

		wp_add_inline_style( 'ln-moonlight-style', $title_bar_css );

	}
}
