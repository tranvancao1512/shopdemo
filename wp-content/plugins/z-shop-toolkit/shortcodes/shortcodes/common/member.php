<?php 


class toolkit_basr_shortcode_member extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'member';

	// public $animation = 'true';  //  enable this to use make shortcode support animation

	// this->base = $prefix + $shortcode;

	// register script 

	public function register_script ( ) {

	}

	// Enqueue script, style 

	public function enqueue_script ( $sc = '' ) {
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
						'name' 				=> esc_html__( 'Member', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						// 'as_child'			=> array( 'only' => $this->prefix . 'isotope' ),
						"content_element" 	=> true,
						'params' 			=> array(
							array(
								'param_name'       => $this->base . '_id',
								'heading'          => esc_html__( 'ID', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  0,
								'edit_field_class' => 'hidden',
							),

							array(
								'param_name'  		=> 'thumbnail',
								'heading'     		=> esc_html__( 'Avatar', 'basr-core' ),
								'description' 		=> esc_html__( '', 'basr-core' ),
								'type'       		=> 'attach_image',
								'admin_label'       => true,
							),

							array(
								'param_name'       => 'size',
								'heading'          => esc_html__( 'Image size', 'basr-core' ),
								'type'             => 'textfield',
								'description'      => 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme)',
							),

							array(
								'param_name'       => 'name',
								'heading'          => esc_html__( 'Name', 'basr-core' ),
								'type'             => 'textfield',
								'description'      => '',
								'admin_label'	   => '',
							),

							array(
								'param_name'       => 'pos',
								'heading'          => esc_html__( 'Position', 'basr-core' ),
								'type'             => 'textfield',
								'description'      => '',
							),

							array(
								'param_name'       => 'social',
								'heading'          => esc_html__( 'explode', 'basr-core' ),
								'type'             => 'exploded_textarea',
								'description'      => '',
							),

							array(
								'param_name'       => 'content',
								'heading'          => esc_html__( 'Description', 'basr-core' ),
								'type'             => 'textarea_html',
								'admin_label'	   => true,
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

	public function generate_html( $atts, $content = null ) {

		$sc_atts =  array( 
						$this->base . '_id' 				=> '',
						'thumbnail'							=> '',
						'size'								=> '',
						'name'								=> '',
						'pos'								=> '',
						'social'							=> '',
						'anm'								=> '',
						'anm_name'							=> '',
						'anm_delay'							=> '1000'			,
						// atts here  

						'classes'							=> '',
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// social

		$social = $social ? explode( ',', $social ) : array();

		if ( ! $thumbnail ) return '';

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '', ' ' . 'isotope-item' ); // pass id setting if need vc custome css class

		// set up shortcode here


		// Start out put

		$output = '<div id="' . $id . '" class="' . $classes . '" ' . $this->animation_data( $sc_atts ) . '>';

		$output .= '<div class="wrap-inner">';

		// content

		$output .= '<div class="thumbnail">' . wp_get_attachment_image( $thumbnail, $size ) . '</div>';

		$output .= '<div class="info">';

		$output .= '<p class="name">' . $name . '</p>';

		$output .= '<p class="pos">' . $pos . '</p>';

		$output .= '<div class="des">' . wpautop( do_shortcode( $content ) ) . '</div>';

		ob_start();

		basr_core_social_info( $social );

		$output .= ob_get_clean();

		$output .= '</div>'; // .wrap-inner

		$output .= '</div>'; // .info

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
