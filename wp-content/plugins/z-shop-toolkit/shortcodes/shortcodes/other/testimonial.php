<?php 


class toolkit_basr_shortcode_testimonial extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'testimonial';

	// this->base = $prefix + $shortcode;

	public function register_script ( ) {
		
	}

	// Enqueue script, style 

	public function enqueue_script ( $extra = array() ) {
		if ( is_singular() ) {
		}

	}

	// map shortcode to vc

	public function vc_map_shortcode() {
		vc_map( array(
						'base' 				=> $this->base,
						'name' 				=> esc_html__( 'Testimonial', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'params' 			=> array(
							array(
								'param_name'       => 'style',
								'heading'          => esc_html__( 'Style', 'basr-core' ),
								'type'             => 'dropdown',
								'value'            => array(
									__( 'Style 1', 'basr-core' ) => 'style-1',
									__( 'Style 2', 'basr-core' ) => 'style-2',
									__( 'Style 3', 'basr-core' ) => 'style-3',
								),
							),
							array(
								'param_name'       => $this->base . '_id',
								'heading'          => esc_html__( 'ID', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  0,
								'edit_field_class' => 'hidden',
							),
							array(
								'param_name'  => 'name',
								'heading'     => esc_html__( 'Name', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),

							array(
								'param_name'  => 'job',
								'heading'     => esc_html__( 'Job', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),

							array(
								'param_name'  => 'img',
								'heading'     => esc_html__( 'avatar', 'basr-core' ),
								'type'        => 'attach_image',
								'holder'      => 'div'
							),

							array(
								'param_name'  => 'social',
								'heading'     => esc_html__( 'Social', 'basr-core' ),
								'type'        => 'exploded_textarea',
								'description' => esc_html__( 'Seperate by line', 'basr-core' ),
								'holder'      => 'div'
							),

							array(
								'param_name'  => 'content',
								'heading'     => esc_html__( 'Content', 'basr-core' ),
								'type'        => 'textarea_html',
								'holder'      => 'div'
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
			$this->base . '_id' 				=> ''				,
			'style' 							=> 'style-1'		,
			'name' 								=> ''				,
			'job' 								=> ''				,
			'social' 							=> ''				,
			'img' 								=> ''				,
			'classes'							=> ''				,
			'anm'								=> ''				,
			'anm_name'							=> ''				,
			'anm_delay'							=> ''				,
		), $atts ) );

		$social = explode( ',', $social );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '', ' ' . $style ); // pass id setting if need vc custome css class,

		// set up shortcode here

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" >';

		$output .= '<div class="quote">' . do_shortcode( $content ) . '</div>';

		$output .= '<div class="info">';
		if ( $img ) {
			$output .= 		'<div class="avatar">' . wp_get_attachment_image( $img ) . '</div>';
		}
		$output	.= 		'<span class="name">' . $name . '</span>';
		$output	.= 		'<span class="job">' . $job . '</span>';
		ob_start();
		basr_core_social_info( $social );
		$output	.= ob_get_clean();		
		$output .= '</div>';

		$output .= '</div>'; // $id

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

}

