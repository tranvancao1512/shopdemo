<?php 

class toolkit_basr_shortcode_background_icon extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'background_icon';

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
			'name' 				=> esc_html__( 'Background Icon', 'basr-core' ),
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
					'heading' => __( 'icon', 'basr-core' ),
					'admin_label' => true,
					'param_name' => 'icon',
				),
				array(
					'param_name'       => 'top',
					'heading'          => esc_html__( 'Top', 'basr-core' ),
					'type'             => 'textfield',
				),
				array(
					'param_name'       => 'left',
					'heading'          => esc_html__( 'Left', 'basr-core' ),
					'type'             => 'textfield',
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
			'icon' 								=> '',
			'top' 								=> '',
			'left' 								=> '',
			'classes' 							=> '',
			'anm'								=> '',
			'anm_name'							=> '',
			'anm_delay'							=> '',
		), $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '', ' ' ); // pass id setting if need vc custome css class, 

		// set up shortcode here

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';
		$output .= wp_get_attachment_image( $icon, 'full' );
		$output .= '</div>';

		// filter 

		$output = apply_filters( "basr_{$this->base}_filter", $output );

		return $output;
	}

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'top'						=> ''			,
			'left'						=> ''			,
			'classes'					=> ''			,
			'align'						=> 'left'		,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$rand = ( rand() % 4 ) + 1;

		$css  = '';

		$css .= $id . ' {' . 
					'left:' . $left . ';' . 
					'top:' . $top . ';' .
					'animation: ' . 'bg_icon_move_' . $rand . ' 30s infinite;' . 
					'animation-delay: 0.' . $rand . 's;' . 
				'}';
				
		return $css;
	}

}
