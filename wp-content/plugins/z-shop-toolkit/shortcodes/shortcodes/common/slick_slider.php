<?php 


class toolkit_basr_shortcode_slick_slider extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'slick_slider';
	public $container = true;

	// public $animation = 'true';  //  enable this to use make shortcode support animation

	// this->base = $prefix + $shortcode;

	// register script 

	public function register_script ( ) {

	}

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
						'name' 				=> esc_html__( 'Slider', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'as_parent'			=> array( 'only' => $this->prefix . 'slick_item' . ',' .
																$this->prefix . 'testimonial' . ',' .
																'vc_single_image'
																  ),
						'js_view'         	=> 'VcColumnView',
						'params' 			=> array(
							array(
								'param_name'       => $this->base . '_id',
								'heading'          => esc_html__( 'ID', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  0,
								'edit_field_class' => 'hidden',
							),

						// slick general

							array(
								'param_name' 	   => 'style',
								'heading'    	   => esc_html__( 'Choose style', 'basr-core' ),
								'type'      	   => 'dropdown',
								'value'      	   => array(
									esc_html__( 'Default', 'basr-core' )   => 'default',
									),
							),

							array(
								'param_name' 	   => 'css_ease',
								'heading'    	   => esc_html__( 'Slide animation', 'basr-core' ),
								'type'      	   => 'dropdown',
								'value'      	   => array(
									esc_html__( 'Ease'       , 'basr-core' )   => 'linear',
									esc_html__( 'Linear'     , 'basr-core' )   => 'ease',
									esc_html__( 'Ease-in'    , 'basr-core' )   => 'ease-in',
									esc_html__( 'Ease-out'   , 'basr-core' )   => 'ease-out',
									esc_html__( 'Ease-in-out', 'basr-core' )   => 'ease-in-out',
								),
							),

							array(
								'param_name' 	   => 'speed',
								'heading'    	   => esc_html__( 'Slide speed', 'basr-core' ),
								'type'      	   => 'textfield',
								'description'	   => esc_html__( 'Unit is ms', 'basr-core' ),
								'value'      	   => '1000',
							),

							array(
								'param_name' 	   => 'slide_to_scroll',
								'heading'    	   => esc_html__( 'Slide to scroll', 'basr-core' ),
								'type'      	   => 'textfield',
								'description'	   => esc_html__( 'Default 1', 'basr-core' ),
								'value'      	   => '1',
							),

						// slick item 

							array(
								'param_name' 	   => 'rows',
								'heading'    	   => esc_html__( 'Setting this to more than 1 initializes grid mode', 'basr-core' ),
								'type'      	   => 'textfield',
								'group'			   => esc_html__( 'Slick Display item', 'basr-core' ),
								'value'      	   => '1',
							),

							array(
								'param_name' 	   => 'slidestoshow',
								'heading'    	   => esc_html__( 'Desktop items display', 'basr-core' ),
								'type'      	   => 'textfield',
								'group'			   => esc_html__( 'Slick Display item', 'basr-core' ),
								'value'      	   => '1',
							),

							array(
								'param_name' 	   => 'tablet_horizontal',
								'heading'    	   => esc_html__( 'Tablet horizontal items display', 'basr-core' ),
								'type'      	   => 'textfield',
								'group'			   => esc_html__( 'Slick Display item', 'basr-core' ),
								'value'      	   => '1',
							),

							array(
								'param_name' 	   => 'tablet_vertical',
								'heading'    	   => esc_html__( 'Tablet vertical items display', 'basr-core' ),
								'type'      	   => 'textfield',
								'group'			   => esc_html__( 'Slick Display item', 'basr-core' ),
								'value'      	   => '1',
							),

							array(
								'param_name' 	   => 'mobile',
								'heading'    	   => esc_html__( 'Mobile items display', 'basr-core' ),
								'type'      	   => 'textfield',
								'group'			   => esc_html__( 'Slick Display item', 'basr-core' ),
								'value'      	   => '1',
							),

						// slick option

							array(
								'param_name' 	   => 'dots',
								'heading'    	   => esc_html__( 'Display dots', 'basr-core' ),
								'type'      	   => 'checkbox',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'value'      	   => false,
								'edit_field_class'	=> 'vc_col-sm-6 mgt15'
							),

							array(
								'param_name' 	   => 'arrows',
								'heading'    	   => esc_html__( 'Display arrow', 'basr-core' ),
								'type'      	   => 'checkbox',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'value'      	   => false,
								'edit_field_class'	=> 'vc_col-sm-6 mgt15'
							),

							array(
								'param_name' 	   => 'arrow_pos',
								'heading'    	   => esc_html__( 'Arrow position', 'basr-core' ),
								'type'      	   => 'dropdown',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'value'      	   => array(
									esc_html__( 'Default'       , 'basr-core' )   => 'arrow-defautl',
									esc_html__( 'Bottom'     , 'basr-core' )   => 'arrow-bottom',
								),
								'dependency'	   => array(
									'element'	   => 'arrows',
									'value'		   => 'true',
								),
							),

							array(
								'param_name' 	   => 'infinite',
								'heading'    	   => esc_html__( 'Loop items', 'basr-core' ),
								'type'      	   => 'checkbox',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'value'      	   => 'true',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15'
							),

							array(
								'param_name' 	   => 'autoplay',
								'heading'    	   => esc_html__( 'Autoplay', 'basr-core' ),
								'type'      	   => 'checkbox',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'value'      	   => true,
								'edit_field_class'	=> 'vc_col-sm-6 mgt15'
							),

							array(
								'param_name' 	   => 'autoplay_speed',
								'heading'    	   => esc_html__( 'Autoplay Speed', 'basr-core' ),
								'type'      	   => 'textfield',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'description'	   => esc_html__( 'Unit is ms', 'basr-core' ),
								'value'      	   => '2000',
								'edit_field_class' => 'vc_col-sm-6 mgt15',
								'dependency'	   => array(
									'element'	   => 'autoplay',
									'value'		   => 'true',
									),
							),

							array(
								'param_name' 	   => 'vertical',
								'heading'    	   => esc_html__( 'Vertical slider', 'basr-core' ),
								'type'      	   => 'checkbox',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'value'      	   => false,
								'edit_field_class'	=> 'vc_col-sm-6 mgt15'
							),

							array(
								'param_name' 	   => 'adaptiveheight',
								'heading'    	   => esc_html__( 'Adaptive Height', 'basr-core' ),
								'type'      	   => 'checkbox',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'value'      	   => false,
								'edit_field_class'	=> 'vc_col-sm-6 mgt15'
							),

							array(
								'param_name' 	   => 'centermode',
								'heading'    	   => esc_html__( 'Center Mode', 'basr-core' ),
								'type'      	   => 'checkbox',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'value'      	   => false,
								'edit_field_class'	=> 'vc_col-sm-6 mgt15'
							),

							array(
								'param_name' 	   => 'center_padding',
								'heading'    	   => esc_html__( 'Center padding', 'basr-core' ),
								'type'      	   => 'textfield',
								'group'			   => esc_html__( 'Slick options', 'basr-core' ),
								'description'	   => esc_html__( 'Unit is px', 'basr-core' ),
								'value'      	   => '0',
								'edit_field_class' => 'vc_col-sm-6 mgt15',
								'dependency'	   => array(
									'element'	   => 'centermode',
									'value'		   => 'true',
									),
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

		$sc_atts =  array( 
						$this->base . '_id' 				=> ''				,
						'css_ease'							=> 'ease'			,
						'speed'								=> '1000'			,
						'slide_to_scroll'					=> '1'				,
						'rows'								=> '1'				,
						'slidestoshow'						=> '1'				,
						'slidesToScroll'					=> '1'				,
						'tablet_horizontal'					=> '1'				,
						'tablet_vertical'					=> '1'				,
						'mobile'							=> '1'				,
						'arrows'							=> false			,
						'dots'								=> false				,
						'infinite'							=> false			,
						'autoplay'							=> false			,
						'autoplay_speed'					=> '0'				,
						'vertical'							=> false			,
						'centermode'						=> false			,
						'center_padding'					=> '0'				,
						'adaptiveheight'					=> false			,
						'arrow_pos'							=> 'arrow-defautl'	,

						'style'								=> 'style_1'		,
						// atts here  

						'classes'							=> ''				,
						'anm'								=> ''				,
						'anm_name'							=> ''				,
						'anm_delay'							=> ''			,
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		$rows              = intval( $rows );
		$slide_to_scroll   = intval( $slide_to_scroll != 0 ) 	? intval( $slide_to_scroll ) 	: 1;
		$slidestoshow      = intval( $slidestoshow ) 			? intval( $slidestoshow ) 		: 1;
		$tablet_horizontal = intval( $tablet_horizontal ) 		? intval( $tablet_horizontal )  : 1;
		$tablet_vertical   = intval( $tablet_vertical ) 		? intval( $tablet_vertical ) 	: 1;
		$mobile            = intval( $mobile ) 					? intval( $mobile ) 		 	: 1;

		$data_slick = array(
			'slidesToScroll' => $slide_to_scroll,
			'dots'           => (bool)$dots,
			'arrows'         => (bool)$arrows,
			'autoplay'       => (bool)$autoplay,
			'autoplaySpeed'  => intval($autoplay),
			'infinite'       => (bool)$infinite,
			'centerMode'     => (bool)$centermode,
			'adaptiveHeight' => (bool)$adaptiveheight,
			'cssEase'		 => $css_ease,
			'speed'			 => intval( $speed ),
			'autoplaySpeed'  => intval( $speed ),
			'centerPadding'	 => intval( $center_padding ) . 'px',
		);

		// fw_print( $data_slick );

		if ( $rows > 1 ) {
			$data_slick['rows']         = $rows;
			$data_slick['slidesPerRow'] = $slidestoshow;
			$data_slick['responsive']   = array(
				array(
					'breakpoint'	=> 1025,
					'settings'		=> array(
						'slidesPerRow'	=> $tablet_horizontal,
					),
				),
				array(
					'breakpoint'	=> 801,
					'settings'		=> array(
						'slidesPerRow'	=> $tablet_vertical,
					),
				),
				array(
					'breakpoint'	=> 568,
					'settings'		=> array(
						'slidesPerRow'	=> $mobile,
					),
				),
			);
		} else {
			$data_slick['slidesToShow'] = $slidestoshow;
			$data_slick['responsive']   = array(
					array(
						'breakpoint'	=> 1025,
						'settings'		=> array(
							'slidesToShow'	=> $tablet_horizontal,
						),
					),
					array(
						'breakpoint'	=> 801,
						'settings'		=> array(
							'slidesToShow'	=> $tablet_vertical,
						),
					),
					array(
						'breakpoint'	=> 568,
						'settings'		=> array(
							'slidesToShow'	=> $mobile,
						),
					),
				);
		}


		$data_slick = json_encode( $data_slick );

		// Enqueue 

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$testimonial = preg_match('/' . BASR_CORE . '_testimonial/',  $content ) ? 'has-testimonial' : '';

		$classes .= $this->get_class( '', ' ' . $arrow_pos . ' ' . $testimonial ); // pass id setting if need vc custome css class

		// set up shortcode here

		// Start out put


		$output  = '<div id="' . $id . '" class="' . $classes . '" >';

		$output .= '<div class="basr-slick" data-slick="' . esc_attr( $data_slick ) . '">';

		// ob_start 

		ob_start();

		echo do_shortcode( $content );

		$output .= ob_get_clean();

		$output .= '</div>'; // .basr-slick

		// ob_end

		$output .= '</div>'; // end wrap-slick-slider

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'classes'					=> ''			,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';

		return $css;

	}

}

