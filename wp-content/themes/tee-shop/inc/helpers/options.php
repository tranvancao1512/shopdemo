<?php
/**
 * Options printer shorthand functions. Grouping common complex options for use in theme options.
 *
 * Getting option functions:
 * For theme option     : origin_get_setting
 * For post option      : origin_get_post_meta
 * For taxonomy option  : origin_get_term_meta
 *
 * Shorthand functions to register setting metabox
 * origin_option_image         : Image wrapper option with predefined images and custom image uploading.
 * origin_option_background    : Background wrapper option with color, image, size, repeat and position.
 *
 * @package ln-moonlight
 * @since   1.0.0
 */

/**
 * Function to get theme option. Preventing error by checking Unyson get theme oiption function exist or not.
 *
 * @param        $settings
 * @param string $pre
 *
 * @return array|mixed|null
 */
function origin_get_setting( $settings, $pre = '' ) {

	if ( function_exists( 'fw_get_db_settings_option' ) ) {

		if ( is_array( $settings ) ) :
			$theme_option = array();
			foreach ( $settings as $key => $value ) {
				$theme_option[ $key ] = fw_get_db_settings_option( $pre . $key );
			}
		else :
			$theme_option = fw_get_db_settings_option( $pre . $settings );
		endif;

		return $theme_option;
	}
}

// Get Meta data ( Singular || Tax )

function origin_get_post_meta( $settings, $id, $pre = '' ) {

	if ( ! defined( 'FW' ) ) {
		return;
	}

	if ( is_array( $settings ) ) {
		$metas = array();
		foreach ( $settings as $key => $value ) {
			$metas[ $key ] = fw_get_db_post_option( $id, $pre . $key );
		}
	} else {
		$metas = fw_get_db_post_option( $id, $pre . $settings );
	}

	return $metas;
}

function origin_get_term_meta( $settings, $taxonomy, $term_id, $pre = '' ) {

	if ( ! defined( 'FW' ) ) {
		return;
	}

	if ( is_array( $settings ) ) {

		$metas = array();
		foreach ( $settings as $key => $value ) {
			$metas[ $key ] = fw_get_db_term_option( $term_id, $taxonomy, $pre . $key );
		}

	} else {
		$metas = fw_get_db_term_option( $term_id, $taxonomy, $pre . $settings );
	}

	return $metas;
}


/**
 * @param string $label
 *
 * @return array
 */
function origin_option_image( $label = '' ) {

	if ( $label === '' ) {
		$label = esc_html__( 'Choose Image', 'origin' );
	}

	return array(
		'type'    => 'background-image',
		'label'   => $label,
		'choices' => array(
			'none' => array(
				'icon' => get_template_directory_uri() . '/assets/images/patterns/no_pattern.jpg',
				'css'  => array(
					'background-image' => 'none',
				),
			),
			'bg-1' => array(
				'icon' => get_template_directory_uri() . '/assets/images/patterns/diagonal_bottom_to_top_pattern_preview.jpg',
				'css'  => array(
					'background-image'  => 'url("' . get_template_directory_uri() . '/assets/images/patterns/diagonal_bottom_to_top_pattern.png' . '")',
					'background-repeat' => 'repeat',
				),
			),
			'bg-2' => array(
				'icon' => get_template_directory_uri() . '/assets/images/patterns/diagonal_top_to_bottom_pattern_preview.jpg',
				'css'  => array(
					'background-image'  => 'url("' . get_template_directory_uri() . '/assets/images/patterns/diagonal_top_to_bottom_pattern.png' . '")',
					'background-repeat' => 'repeat',
				),
			),
			'bg-3' => array(
				'icon' => get_template_directory_uri() . '/assets/images/patterns/dots_pattern_preview.jpg',
				'css'  => array(
					'background-image'  => 'url("' . get_template_directory_uri() . '/assets/images/patterns/dots_pattern.png' . '")',
					'background-repeat' => 'repeat',
				),
			),
			'bg-4' => array(
				'icon' => get_template_directory_uri() . '/assets/images/patterns/romb_pattern_preview.jpg',
				'css'  => array(
					'background-image'  => 'url("' . get_template_directory_uri() . '/assets/images/patterns/romb_pattern.png' . '")',
					'background-repeat' => 'repeat',
				),
			),
			'bg-5' => array(
				'icon' => get_template_directory_uri() . '/assets/images/patterns/square_pattern_preview.jpg',
				'css'  => array(
					'background-image'  => 'url("' . get_template_directory_uri() . '/assets/images/patterns/square_pattern.png' . '")',
					'background-repeat' => 'repeat',
				),
			),
			'bg-6' => array(
				'icon' => get_template_directory_uri() . '/assets/images/patterns/noise_pattern_preview.jpg',
				'css'  => array(
					'background-image'  => 'url("' . get_template_directory_uri() . '/assets/images/patterns/noise_pattern.png' . '")',
					'background-repeat' => 'repeat',
				),
			),
			'bg-7' => array(
				'icon' => get_template_directory_uri() . '/assets/images/patterns/vertical_lines_pattern_preview.jpg',
				'css'  => array(
					'background-image'  => 'url("' . get_template_directory_uri() . '/assets/images/patterns/vertical_lines_pattern.png' . '")',
					'background-repeat' => 'repeat',
				),
			),
			'bg-8' => array(
				'icon' => get_template_directory_uri() . '/assets/images/patterns/waves_pattern_preview.jpg',
				'css'  => array(
					'background-image'  => 'url("' . get_template_directory_uri() . '/assets/images/patterns/waves_pattern.png' . '")',
					'background-repeat' => 'repeat',
				),
			),
		),
	);
}

/**
 *
 * @return string
 * @since 1.0
 */
function origin_option_background( $default = array() ) {
	$default = array_merge(
		array(
			'color'    => '#fff',
			'image'    => 'none',
			'position' => 'inherit',
			'repeat'   => 'inherit',
			'size'     => 'inherit',
		),
		$default
	);
	return array(
		'type'          => 'multi',
		'attr'          => array(
			'class' => 'fw-option-type-multi-show-borders',
		),
		'value'         => $default,
		'label'         => false,
		'inner-options' => array(
			'color'    => array(
				'type'  => 'rgba-color-picker',
				'label' => esc_html__( 'Background Color', 'origin' ),
			),
			'image'    => origin_option_image( esc_html__( 'Background Image', 'origin' ) ),
			'position' => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Background Position', 'origin' ),
				'value'   => '',
				'choices' => array(
					'inherit'       => esc_html__( 'None', 'origin' ),
					'left-top'      => esc_html__( 'Left Top', 'origin' ),
					'left-center'   => esc_html__( 'Left Center', 'origin' ),
					'left-bottom'   => esc_html__( 'Left Bottom', 'origin' ),
					'right-top'     => esc_html__( 'Right Top', 'origin' ),
					'right-center'  => esc_html__( 'Right Center', 'origin' ),
					'right-bottom'  => esc_html__( 'Right Bottom', 'origin' ),
					'center-top'    => esc_html__( 'Center Top', 'origin' ),
					'center-center' => esc_html__( 'Center Center', 'origin' ),
					'center-bottom' => esc_html__( 'Center Bottom', 'origin' ),
				),
			),
			'repeat'   => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Background Repeat', 'origin' ),
				'choices' => array(
					'no-repeat' => esc_html__( 'No repeat', 'origin' ),
					'repeat'    => esc_html__( 'Repeat', 'origin' ),
					'repeat-x'  => esc_html__( 'Repeat X', 'origin' ),
					'repeat-y'  => esc_html__( 'Repeat Y', 'origin' ),
				),
			),
			'size'     => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Background Size', 'origin' ),
				'choices' => array(
					'inherit' => esc_html__( 'None', 'origin' ),
					'auto'    => esc_html__( 'Auto', 'origin' ),
					'cover'   => esc_html__( 'Cover', 'origin' ),
					'contain' => esc_html__( 'Contain', 'origin' ),
				),
			),
		),
	);
}

// Option logo 

if( !function_exists('origin_option_logo') ) {
	function origin_option_logo() {
		return array(
			'type' => 'multi',
			'label' => false,
			'inner-options' => array(
				'_logo' => array(
					'type'	  => 'multi-picker',
					'label'	 => false,
					'desc'	  => false,
					'value'	 => array(
						'logo_type'	=> 'img',
					),
					'picker'	=> array(
						'logo_type' => array(
							'label'	 => esc_html__('Logo Mobile type', 'origin'),
							'type'		 => 'switch',
							'right-choice' => array(
								'value' => 'img',
								'label' => esc_html__( 'Image', 'origin' )
							),
							'left-choice'  => array(
								'value' => 'text',
								'label' => esc_html__( 'Text', 'origin' )
							),
							'value'		=> 'yes',
						)
					),
					'choices'   => array(
						'img'  => array(
							'logo_img'  => array(
								'type'  => 'group',
								'options'   => array(
									'logo_img'  => array(
										'label' => esc_html__('Logo width x2 dimension, and set 1/2 width below', 'origin'),
										'type'  => 'upload'
									),
									'logo_width'  => array(
										'label' => esc_html__('logo width', 'origin'),
										'type'  => 'text',
									),
								),
							),
						),
						'text' => array(
							'logo_text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text Logo content', 'origin' ),
								'value' => get_bloginfo( 'name' ),
							),
							'logo_text_typo' => array(
								'type' => 'typography',
								'value' => array(
									'style' => '700',
									'size' => 20,
									'color' => '#333',
								),
								'label' => esc_html__('Logo typography', 'origin'),
							),
							'letter_spacing' => array(
								'type' => 'number',
								'value' => 0,
								'attr' => array(
									'min' => '0',
									'step' => '0.1',
								),
								'label' => esc_html__('Letter Spacing (px)', 'origin'),
							),
						),
					),
					'show_borders' => false,
				),
			),
		);
	}
}

// Get logo 

function origin_get_setting_logo_html() {

	$logo = origin_get_setting( 'logo' );
	$html = '';

	// fw_print( $logo );

	if ( $logo ) {

		$html .= '<div class="mm-logo">';

		if (  'img' == $logo['_logo']['logo_type'] ) {

			$img_id = ( $logo['_logo']['img']['logo_img'] ) 	? $logo['_logo']['img']['logo_img']['attachment_id'] : '' ;

			if ( $img_id ) {
				$html .= wp_get_attachment_image( $img_id, 'full' );
			} else {
				$html .= '<h2 class="logo-text">' . $logo['_logo']['text']['logo_text'] . '</h2>';
			}
			
		} else {
			$html .= '<h2 class="logo-text">' . $logo['_logo']['text']['logo_text'] . '</h2>';
		}

		$html .= '</div>'; // menu mobile 
	}

	return $html;

}

