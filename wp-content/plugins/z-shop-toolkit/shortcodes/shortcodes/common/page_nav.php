<?php 


class toolkit_basr_shortcode_page_nav extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'page_nav';
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
						'name' 				=> esc_html__( 'Page Pagination', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'as_parent'			=> array( 'only' => $this->prefix . 'page_nav_item' . ','
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

							// array(
							// 	'param_name' 	   => 'style',
							// 	'heading'    	   => esc_html__( 'Choose style', 'basr-core' ),
							// 	'type'      	   => 'dropdown',
							// 	'value'      	   => array(
							// 		esc_html__( 'Default', 'basr-core' )   => 'default',
							// 		),
							// ),


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

						// atts here  

						'classes'							=> ''				,
						'anm'								=> ''				,
						'anm_name'							=> ''				,
						'anm_delay'							=> ''			,
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '', ' ' ); // pass id setting if need vc custome css class

		// set up shortcode here

		// Start out put


		$output  = '<div id="' . $id . '" class="' . $classes . '" >';

		$output .= '<ul class="page-nav">';

		// ob_start 

		ob_start();

		echo do_shortcode( $content );

		$output .= ob_get_clean();

		$output .= '</ul>';

		$output .= '</div>'; // $id

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

