<?php 


class toolkit_basr_shortcode_service_item extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'service_item';

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
						'name' 				=> esc_html__( 'Service Item', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'as_child'			=> array( 'only' => $this->prefix . 'service' ),
						'params' 			=> array(
							array(
								'param_name'       => $this->base . '_id',
								'heading'          => esc_html__( 'ID', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  0,
								'edit_field_class' => 'hidden',
							),


							array(
								'param_name'  => 'title',
								'heading'     => esc_html__( 'Title', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),

							array( 
								'param_name'	=> 'link',
								'heading'		=> esc_html__( 'Link to', 'basr-core' ),
								'type'			=> 'textfield',
							),

							array(
								'param_name'  => 'img',
								'heading'     => esc_html__( 'Image', 'basr-core' ),
								'type'        => 'attach_image',
								'holder'      => 'div'
							),

							array(
								'param_name'  => 'content',
								'heading'     => esc_html__( 'Content', 'basr-core' ),
								'type'        => 'textarea_html',
								'holder'      => 'div'
							),

							toolkit_basr_vcf_class(),

							// toolkit_basr_vcf_animate( $i =  0,1,2 ); anable animation , animation name, animation delay .

							// More fields here 

						),
					) 
				);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {

		$sc_atts =  array( 
						$this->base . '_id' 				=> ''				,
						'title'								=> ''				,
						'link'								=> '',
						// atts here  

						'classes'							=> ''				,
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// Enqueue 

		$this->enqueue_script();

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// set up shortcode here

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . $this->animation_data( $sc_atts ) . '>';

		ob_start();

		$open_link = $end_link = '';

		if ( $link ) {
			$open_link = '<a href="' . $link . '">';
			$end_link = '</a>';
		}

		echo '<h3 class="title">' . $open_link . $title . $end_link . '</h3>';
		echo do_shortcode( $content );

		$output .= ob_get_clean();

		$output .= '</div>';

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
