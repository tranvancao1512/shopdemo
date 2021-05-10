<?php 


class toolkit_basr_shortcode_slick_item extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'slick_item';

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
						'name' 				=> esc_html__( 'Slick Item', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'as_child'			=> array( 'only' => $this->prefix . 'slick_slider' ),
						'params' 			=> array(
							array(
								'param_name'       => $this->base . '_id',
								'heading'          => esc_html__( 'ID', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  0,
								'edit_field_class' => 'hidden',
							),

							array(
								'param_name'  => 'thumbnail',
								'heading'     => esc_html__( 'Thumbnail', 'basr-core' ),
								'description' => esc_html__( '', 'basr-core' ),
								'type'        => 'attach_image',
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

						// atts here  
						'thumbnail' => '',
						'classes'							=> ''				,
						'anm'								=> ''				,
						'anm_name'							=> ''				,
						'anm_delay'							=> ''			,
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// Enqueue 

		$this->enqueue_script();

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// set up shortcode here

		$thumbnail = wp_get_attachment_image_url($thumbnail, 'full');

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';

		// content
		ob_start();
		?>

		<img src="<?php echo esc_url($thumbnail); ?>" />

		<?php
		$output .= ob_get_clean();

		$output .= '</div>';

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

}

