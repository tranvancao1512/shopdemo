<?php 


class toolkit_basr_shortcode_animator extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'animator';

	// this->base = $prefix + $shortcode;

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
						'name' 				=> esc_html__( 'Toolkit Animator', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'js_view'         	=> 'VcColumnView',
						'as_parent'       	=> array(
							'except' => 'lucy_animator',
						),
						'params' 			=> array(
							array(
								'param_name'       => $this->base . '_id',
								'heading'          => esc_html__( 'ID', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  0,
								'edit_field_class' => 'hidden',
							),
							toolkit_basr_vcf_class(),
							array(
								'param_name' 		=> 'anm_name',
								'heading' 			=> esc_html__( 'Animation', 'basr-core' ),
								'type' 		 		=> 'dropdown',
								'edit_field_class'	=> 'vc_col-sm-6 vc_col-xs-12 mgt15',
								'std'               => 'fadeIn',
								'value'      		=> array('bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'jello', 'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp', 'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'fadeOut', 'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig', 'flip', 'flipInX', 'flipInY', 'flipOutX', 'flipOutY', 'lightSpeedIn', 'lightSpeedOut', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideOutUp', 'slideOutDown', 'slideOutLeft', 'slideOutRight', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp', 'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp', 'hinge', 'rollIn', 'rollOut', ),
							),
							array(
								'param_name'  		=> 'anm_delay',
								'heading'     		=> esc_html__( 'Animation Delay', 'basr-core' ),
								'description' 		=> esc_html__( 'Numeric value only, 1000 = 1second.', 'basr-core' ),
								'type'        		=> 'textfield',
								'value'		  		=> '1000',
								'edit_field_class'	=> 'vc_col-sm-6 vc_col-xs-12 mgt15',
							),
						),
					) 
				);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {
		$this->enqueue_script();

		extract( shortcode_atts( array(
			$this->base . '_id' 				=> ''				,
			'classes'							=> ''				,
			'anm'								=> '1'				,
			'anm_name'							=> 'fadeIn'				,
			'anm_delay'							=> '1000'			,
		), $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class, 

		// set up shortcode here

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';


		$output .= do_shortcode( $content );

		$output .= '</div>';

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

}

if ( class_exists('VC_Manager') && is_admin() ) {

	class WPBakeryShortCode_lucy_animator extends WPBakeryShortCodesContainer {}

}
