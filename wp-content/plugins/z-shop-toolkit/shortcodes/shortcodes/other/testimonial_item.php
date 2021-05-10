<?php 


class toolkit_basr_shortcode_testimonial_item extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'testimonial_item';

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
						'name' 				=> esc_html__( 'Toolkit Testimonial Item', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'as_child'       	=> array(
							'only' => $this->prefix . 'testimonial',
						),
						'params' 			=> array(
							array(
								'param_name'       => 'name',
								'heading'          => esc_html__( 'Customer Name', 'basr-core' ),
								'type'             => 'textfield',
								'admin_label'      => true,
							),
							array(
								'param_name'       => 'job',
								'heading'          => esc_html__( 'Job', 'basr-core' ),
								'type'             => 'textfield',
								'admin_label'      => true,
							),
							array(
								'param_name'       => 'image',
								'heading'          => esc_html__( 'Customer Photo', 'basr-core' ),
								'desc'          => esc_html__( 'Use Square image for best result.', 'basr-core' ),
								'type'             => 'attach_image',
							),
							array(
								'param_name'       => 'testimonial_content',
								'heading'          => esc_html__( 'Testimonial Content', 'basr-core' ),
								'type'             => 'textarea',
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
			'name' => '',
			'job' => '',
			'image' => '',
			'testimonial_content' => '',
			$this->base . '_id' 				=> ''				,
			'classes'							=> ''				,
			'anm'								=> ''				,
			'anm_name'							=> ''				,
			'anm_delay'							=> ''			,
		), $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class(); // pass id setting if need vc custome css class,

		// set up shortcode here
		$image = wp_get_attachment_image_src($image, 'thumbnail');

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';

		ob_start();
		?>

		<div class="photo">
			<img src="<?php echo esc_url($image[0]); ?>" />
		</div>
		<div class="info">
			<div class="testimonial-content">
				<?php echo wp_kses_post($testimonial_content); ?>
			</div>
			<h4 class="name"><?php esc_html_e($name); ?></h4>
			<span class="job"><?php esc_html_e($job); ?></span>
		</div>

		<?php
		$output .= ob_get_clean();

		$output .= '</div>';

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

}

if ( class_exists('VC_Manager') && is_admin() ) {

	class WPBakeryShortCode_lucy_testimonial_item extends WPBakeryShortCode {}

}
