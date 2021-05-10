<?php 

class toolkit_basr_shortcode_social_info extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'social_info';

	// this->base = $prefix + $shortcode;

	// Enqueue script, style

	public function enqueue_script ( $extra = array() ) {
		if ( is_singular() ) {
			
			global $post;

			if ( has_shortcode( $post->post_content, "{$this->base}" ) ) {
				parent::enqueue_script();
			}
		}

	}

	// map shortcode to vc

	public function vc_map_shortcode() {
		vc_map( array(
			'base' 				=> $this->base,
			'name' 				=> esc_html__( 'Social Link', 'basr-core' ),
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
					'param_name'       => 'title',
					'heading'          => esc_html__( 'Title', 'basr-core' ),
					'type'             => 'textfield',
				),
				array(
					'param_name'       => 'style',
					'heading'          => esc_html__( 'Style', 'basr-core' ),
					'type'             => 'dropdown',
					'value' => array(
						__( 'Default', 'basr-core' ) => 'default',
						// TODO: Add support for these style
//						__( 'Gray Square', 'basr-core' ) => 'gray',
//						__( 'Square', 'basr-core' ) => 'boxed',
//						__( 'Colorful', 'basr-core' ) => 'colorful',
					),
				),
				array(
					'param_name'       => 'align',
					'heading'          => esc_html__( 'align', 'basr-core' ),
					'type'             => 'dropdown',
					'value' => array(
						__( 'Left'	, 'basr-core' ) => 'left',
						__( 'Right'	, 'basr-core' ) => 'right',
						__( 'Center', 'basr-core' ) => 'center',
						__( 'Inline', 'basr-core' ) => 'inline',
						__( 'fixed', 'basr-core' )  => 'fixed',
					),
				),
				array(
						'param_name'  		=> 'position',
						'heading'     		=> esc_html__( 'fixed position: ', 'basr-core' ),
						'description' 		=> esc_html__( 'Example: top: 30px;left: 30px;  | bottom: 30px;right: 30px; ', 'basr-core' ),
						'type'       		=> 'textfield',
						'holder'      		=> 'div',
						'edit_field_class'  => 'vc_col-sm-6 mgt15',
						'admin_label' 		=> false,
						'dependency' 		=> array(
													'element' => 'align',
													'value'   => array( 'fixed' )
												),
				),
				array(
					'param_name'  		=> 'color',
					'heading'     		=> esc_html__( 'Icon color', 'basr-core' ),
					'type'        		=> 'colorpicker',
					'edit_field_class'  => 'vc_col-sm-6 mgt15',
				),
				array(
					'param_name'  		=> 'color_hover',
					'heading'     		=> esc_html__( 'Icon color hover', 'basr-core' ),
					'type'        		=> 'colorpicker',
					'edit_field_class'  => 'vc_col-sm-6 mgt15',
				),
				toolkit_basr_vcf_class(),
				toolkit_basr_vcf_animate(0),
				toolkit_basr_vcf_animate(1),
				toolkit_basr_vcf_animate(2),
			),
		)
	);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {
		$this->enqueue_script();

		extract( shortcode_atts( array(
			$this->base . '_id' 				=> '',
			'title' 							=> '',
			'style'								=> 'default'	,
			'align'								=> 'left'	,
			'color'								=> '#555'		,
			'classes'							=> ''			,
			'anm'								=> ''			,
			'anm_name'							=> ''			,
			'anm_delay'							=> ''			,
		), $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '', ' ' . $align ); // pass id setting if need vc custome css class, 

		// set up shortcode here

		$classes .= empty( $title ) ? ' no-title' : '';

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';
		ob_start(); ?>

		<?php basr_core_social_info(); ?>

		<?php $output .= ob_get_clean();
		$output .= '</div>';

		// filter 

		$output = apply_filters( "basr_{$this->base}_filter", $output );

		return $output;
	}

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'classes'					=> ''			,
			'align'						=> 'left'		,
			'color'						=> '',
			'color_hover'				=> '',
			'position'					=> '',
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css  = '';

		switch ( $align ) {
			case 'center' :
				$css .= $id . ' {' .
						'display: block;' .
						'}';
				$css .= $id . ' .basr-wrap-social {' . 
							'display: table;' .
							'float: none;' .
							'margin: 0 auto;' .
						'}';
			break;

			case 'inline' : 
				$css .= $id . ' {' .
						'display: inline-block;' .
						'float: none;' . 
					'}';
			break;
			
			default:
				$css .= $id . ' .basr-wrap-social{' . 
						'display: block;' . 
						'float: ' . $align . ';' .
					'}';
			break;
		}

		if ( $color ) {
			$css .= $id .' .social li a {' . 
						'color: ' . $color . ';' . 
					'}';
		}

		if ( $color_hover ) {
			$css .= $id .' .social li a:hover {' . 
						'color: ' . $color_hover . ';' . 
					'}';
		}
		if ( $position ) {
			$css .= $id . ' {' . 
						$position . 
					'}';
		} 

		return $css;
	}

}
