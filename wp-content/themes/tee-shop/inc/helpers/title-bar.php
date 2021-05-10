<?php
/**
 * Titlebar helpers
 *
 * @package ln-moonlight
 * @since   1.0.0
 * @version 1.0.0
 */

/**
 * Don't access directly.
 */
defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


if ( ! function_exists( 'origin_render_title_bar_metabox' ) ) {
	/**
	 * Render title_bar options metabox. Use in theme options and post/taxonomy edit page.
	 *
	 * @param string $ot
	 *
	 * @return array
	 */
	function origin_render_title_bar_metabox( $ot = '' ) {

		$value = ( $ot ) ? 'yes' : 'no';

		$hidden = ( $ot ) ? 'fw-backend-option-type-hidden' : '';

		$label = ( $ot ) ? '' : esc_html__( 'Custom titlebar ?', 'origin' );

		$default = origin_get_default_settings( 'title-bar' );

		$opts = array(
			'title-bar' => array(
				'type'    => 'multi-picker',
				'label'   => false,
				'desc'    => false,
				'picker'  => array(
					'override' => array(
						'type'         => 'switch',
						'value'        => $value,
						'label'        => $label,
						'attr'         => array( 'class' => $hidden ),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'origin' ),
						),
						'left-choice'  => array(
							'value' => 'no',
							'label' => esc_html__( 'No', 'origin' ),
						),
					),
				),
				'choices' => array(
					'yes' => array(
						'display'        => array(
							'type'         => 'switch',
							'value'        => $default['display'],
							'label'        => esc_html__( 'Show/Hide Titlebar ', 'origin' ),
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Show', 'origin' ),
							),
							'left-choice'  => array(
								'value' => '',
								'label' => esc_html__( 'Hide', 'origin' ),
							),
						),
						'color'          => array(
							'type'  => 'color-picker',
							'value' => $default['color'],
							'label' => esc_html__( 'Titlebar color', 'origin' ),
						),
						'padding-top'    => array(
							'type'  => 'number',
							'label' => esc_html__( 'Titlebar Padding Top (px)', 'origin' ),
							'value' => $default['padding-top'],
							'attr'  => array(
								'min' => 0,
							),
						),
						'padding-bottom' => array(
							'type'  => 'number',
							'label' => esc_html__( 'Titlebar Padding Bottom (px)', 'origin' ),
							'value' => $default['padding-bottom'],
							'attr'  => array(
								'min' => 0,
							),
						),

						'bg' => origin_option_background( $default['bg'] ),

						'parallax'        => array(
							'type'         => 'switch',
							'value'        => $default['parallax'],
							'label'        => esc_html__( 'Background Parallax', 'origin' ),
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'On', 'origin' ),
							),
							'left-choice'  => array(
								'value' => 'no',
								'label' => esc_html__( 'Off', 'origin' ),
							),
						),
						'overlay-color'   => array(
							'type'  => 'color-picker',
							'value' => $default['overlay-color'],
							'label' => esc_html__( 'Overlay color', 'origin' ),
						),
						'overlay-opacity' => array(
							'label'      => esc_html__( 'Titlebar Overlay opacity', 'origin' ),
							'type'       => 'td-slider',
							'value'      => $default['overlay-opacity'],
							'properties' => array(
								'min'  => 0,
								'max'  => 10,
								'step' => 1, // Set slider step. Always > 0. Could be fractional.
							),
						),
						'clipmask-bg'     => origin_option_image( esc_html__( 'Clipmask pattern', 'origin' ) ),

						'clipmask-opacity' => array(
							'label'      => esc_html__( 'Titlebar Clipmask opacity', 'origin' ),
							'type'       => 'td-slider',
							'value'      => $default['clipmask-opacity'],
							'properties' => array(
								'min'  => 0,
								'max'  => 10,
								'step' => 1, // Set slider step. Always > 0. Could be fractional.
							),
						),
						'custom-content'   => array(
							'label' => esc_html__( 'Titlebar Custom Content', 'origin' ),
							'type'  => 'textarea',
							'desc'  => esc_html__( 'Fill in Custom Content', 'origin' ),
						),
					),
				),
			),
		);

		return $opts;
	}
}


// Get Titlebar setting Override || Theme Option || Default

if ( ! function_exists( 'origin_get_title_bar_settings' ) ) {
	function origin_get_title_bar_settings() {

		if ( ! defined( 'FW' ) ) {
			return origin_get_default_settings( 'title-bar' );
		}

		$id  = '';
		$tax = '';

		$id = is_page() || is_single() ? get_the_ID() : $id;

		if ( is_tax() || is_category() || is_tag() ) :
			$query = get_queried_object();
			$id    = $query->term_id;
			$tax   = $query->taxonomy;
		endif;

		if ( is_numeric( $id ) || $tax ) {

			// get meta

			if ( $tax != '' ) {
				$settings = origin_get_term_meta( 'title-bar', $tax, $id );
			} else {
				$settings = origin_get_post_meta( 'title-bar', $id );
			}

			if ( isset( $settings['override'] ) && $settings['override'] == 'yes' ) return $settings['yes'];

		}

		$settings = origin_get_setting( 'title-bar' );

		return $settings['yes'];

	}
}


