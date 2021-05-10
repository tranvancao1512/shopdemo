<?php 

class toolkit_basr_shortcode_social_sharing extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'social_sharing';

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
			'name' 				=> esc_html__( 'Toolkit Social', 'basr-core' ),
			'class' 			=> '',
			'category' 			=> $this->cat,
			'icon' 				=> $this->icon,
			'params' 			=> array(
				array(
					'param_name'       => 'style',
					'heading'          => esc_html__( 'Style', 'basr-core' ),
					'type'             => 'dropdown',
					'value' => array(
						__( 'Inline', 'basr-core' ) => 'inline',
						// TODO: Add support for these style
//						__( 'Gray Square', 'basr-core' ) => 'gray',
//						__( 'Square', 'basr-core' ) => 'boxed',
//						__( 'Colorful', 'basr-core' ) => 'colorful',
					),
				),
				array(
					'param_name'       => $this->base . '_id',
					'heading'          => esc_html__( 'ID', 'basr-core' ),
					'type'             => 'textfield',
					'value'            =>  0,
					'edit_field_class' => 'hidden',
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
			'title' 		=> __('Share this:', 'basr-core'),
			'style'		=> 'inline',
			'color'		=> '#555',
			'classes'							=> ''				,
			'anm'								=> ''				,
			'anm_name'							=> ''			,
			'anm_delay'							=> ''			,
		), $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class, 

		// set up shortcode here

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';
		ob_start(); ?>

		<span class="cta">
			<?php echo $title ?>
		</span>
			<?php hdecor_social_info(); ?>


		<?php $output .= ob_get_clean();
		$output .= '</div>';

		// filter 

		$output = apply_filters( "basr_{$this->base}_filter", $output );

		return $output;
	}

}

if ( class_exists('VC_Manager') && is_admin() ) {

	class WPBakeryShortCode_basr_social_sharing extends WPBakeryShortCode {}

}
