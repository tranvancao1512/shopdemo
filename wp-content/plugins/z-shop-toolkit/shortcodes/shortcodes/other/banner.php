<?php


class toolkit_basr_shortcode_banner extends toolkit_basr_shortcode {

	// shortcode name

	public $shortcode = 'banner';

	public function vc_map_shortcode() {
		vc_map( array(
				'base' 				=> $this->base,
				'name' 				=> esc_html__( 'Toolkit Banner', 'basr-core' ),
				'class' 			=> '',
				'category' 			=> $this->cat,
				'icon' 				=> $this->icon,
				'params' 			=> array(
					array(
						'param_name'       => $this->base . '_id',
						'heading'          => esc_html__( 'ID', 'basr-core' ),
						'type'             => 'textfield',
						'value'            =>  0,
						'edit_field_class' => 'hidden',
					),

					array(
						'type' => 'attach_image',
						'heading' => __( 'Banner Image', 'basr-core' ),
						'admin_label' => true,
						'param_name' => 'banner_image',
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'URL', 'basr-core' ),
						'param_name' => 'banner_url',
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'For Isotope item width( base on isotope columns )', 'basr-core' ),
						'param_name' => 'isotope_width',
						'value'		 => array(
							esc_html__( '1 column', 'basr-core' )  	=> '',
							esc_html__( '2 column', 'basr-core' )  	=> 'is_x2',
							esc_html__( '3 column', 'basr-core' )  	=> 'is_x3',
							)
					),
					array(
						'param_name' => 'overlay_color',
						'type' => 'colorpicker',
						'heading' => __( 'Overlay background image', 'basr-core' ),
						'value'		 => '',
					),

					array(
						'param_name'  => 'position',
						'heading'     => esc_html__( 'Content position', 'basr-core' ),
						'type'        => 'dropdown',
						'std'         => 'center',
						'value' 	  => array(
							esc_html__( 'Bottom after Image', 'basr-core' ) 		=> 'content-bottom',
							esc_html__( 'Absolute', 'basr-core' ) 				=> 'absolute',
							esc_html__( 'Top before Image', 'basr-core' ) 		=> 'content-top',
						),
					),

					array(
						'param_name'  => 'align',
						'heading'     => esc_html__( 'Content align', 'basr-core' ),
						'type'        => 'dropdown',
						'std'         => 'center',
						'value' 	  => array(
							esc_html__( 'Top Left', 'basr-core' ) 			=> 'top-left',
							esc_html__( 'Top Right', 'basr-core' ) 			=> 'top-right',
							esc_html__( 'Center Center', 'basr-core' ) 		=> 'center-center',
							esc_html__( 'Center Left', 'basr-core' ) 		=> 'center-left',
							esc_html__( 'Center Right', 'basr-core' ) 		=> 'center-right',
							esc_html__( 'Bottom Left', 'basr-core' ) 		=> 'bottom-left',
							esc_html__( 'Bottom Right', 'basr-core' ) 		=> 'bottom-center',
						),
						'dependency'  => array( 
								'element'	=> 'position',
								'value'		=> 'absolute',
							),

					),

					array( 
						'param_name'	=> 'top',
						'heading'     => esc_html__( 'Top Offset', 'basr-core' ),
						'type'        => 'textfield',
						'value' 	  => '',
						'dependency'  => array( 
								'element'	=> 'align',
								'value'		=> array('top-left', 'top-right'),
							),
					),

					array( 
						'param_name'	=> 'Left',
						'heading'     => esc_html__( 'Left Offset', 'basr-core' ),
						'type'        => 'textfield',
						'value' 	  => '',
						'dependency'  => array( 
								'element'	=> 'align',
								'value'		=> array('top-left', 'bottom-left'),
							),
					),

					array( 
						'param_name'	=> 'bottom',
						'heading'     => esc_html__( 'Bottom Offset', 'basr-core' ),
						'type'        => 'textfield',
						'value' 	  => '',
						'dependency'  => array( 
								'element'	=> 'align',
								'value'		=> array('bottom-left', 'bottom-right'),
							),
					),

					array( 
						'param_name'	=> 'right',
						'heading'     => esc_html__( 'Right Offset', 'basr-core' ),
						'type'        => 'textfield',
						'value' 	  => '',
						'dependency'  => array( 
								'element'	=> 'align',
								'value'		=> array('top-right', 'top-right'),
							),
					),

					array(
						'param_name' => 'content',
						'type' => 'textarea_html',
						'heading' => __( 'Text content', 'basr-core' ),
						'value'		 => '',
					),

					toolkit_basr_vcf_class(),
					toolkit_basr_vcf_animate(0),
					toolkit_basr_vcf_animate(1),
					toolkit_basr_vcf_animate(2),

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
			$this->base . '_id' 				=> ''			   ,
			'position'							=> 'content-bottom',
			'layout' 							=> ''				,
			'isotope_width' 					=> ''				,
			'banner_image' 						=> ''				,
			'banner_url' 						=> '#'				,
			'overlay_color' 					=> '#'				,
			'classes'							=> ''				,
			'align' 							=> 'top-left'		,
			'anm'								=> '0'				,
			'anm_name'							=> 'fadeIn'			,
			'anm_delay'							=> '1000'			,
		);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// Enqueue

		$this->enqueue_script(${$this->base . '_id'});

		// get id

		$id = ${$this->base . '_id'} ;

		// get class

		if ( $layout == 'masonry-1' ) {
			$classes .= ' masonry-1' . '-item';
		}


		$classes .= $this->get_class( '', $align . ' ' . $position . ' ' . $isotope_width ); // pass id setting if need vc custome css class

		// set up shortcode here

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" >';

		$output .= '<div class="wrap-inner animated" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';

		if ( $position == 'content-top' ) {
			$output .= '<div class="content"><p class="hidden">' . do_shortcode( wpautop($content) ) . '</div>';
		}

		// content
		ob_start();

		if ( $layout == 'masonry-1' ) {
			echo '<div class="banner-thumb" style="background-image: url(\'' . wp_get_attachment_url( $banner_image, 'full' ) . '\');" >' . '</div>';
		} else {
			echo '<a class="banner-thumb" href="' . $banner_url . '">' . wp_get_attachment_image( $banner_image, 'full' )  . '</a>';
		}

		$output .= ob_get_clean();

		if ( $position != 'content-top' ) {
			$output .= '<div class="content"><p class="hidden">' . do_shortcode( wpautop($content) ) . '</div>';
		}

		$output .= '</div>'; // .wrap-inner

		$output .= '</div>'; // #id

		// filter

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'classes'					=> ''			,
			'banner_image'				=> ''			,
			'layout'					=> ''			,
			'position'					=> ''			,
			'align'						=> 'top-left'	,
			'top'						=> ''			,
			'bottom'					=> ''			,
			'left'						=> ''			,
			'right'						=> ''			,
			// atts here

			'overlay_color'				=> ''			,

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';

		if ( $overlay_color ) {

			$css .= $id . ' .banner-thumb:before {' .
						'display: block;' .
						'background-color: ' . $overlay_color . ';' .
					'}';
		}

		if ( $position == 'absolute' ) {

			$css .= $id . '.absolute .content {';

			if ( $align != 'center-center' ) {
				if ( in_array( $align, array( 'top-left', 'top-right' ) ) ) {
					$css .= 'top:' . ( $top ? intval( $top ) : '' ) . 'px;';
				}
				if ( in_array( $align, array( 'top-left', 'bottom-left' ) ) ) {
					$css .= 'left:' . ( $left ? intval( $left ) : '' ) . 'px;';
					$css .= 'right: initial;';
				}
				if ( in_array( $align, array( 'top-right', 'bottom-right' ) ) ) {
					$css .= 'right:' . ( $right ? intval( $right ) : '' ) . 'px;';
					$css .= 'left: initial;';
				}
				if ( in_array( $align, array( 'bottom-left', 'bottom-right' ) ) ) {
					$css .= 'bottom:' . ( $bottom ? intval( $bottom ) : '' ) . 'px;';
					$css .= 'top: initial;';
				}
			}

			$css .= '}';
		}

		return $css;
	}

}

if ( class_exists('VC_Manager') && is_admin() ) {
	class WPBakeryShortCode_Lucy_banner extends WPBakeryShortCode {
	}
}
