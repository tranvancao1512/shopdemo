<?php 

class toolkit_basr_shortcode_lightbox_video extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'lightbox_video';

	// this->base = $prefix + $shortcode;

	// Enqueue script, style

	public function enqueue_script ( $extra = array() ) {
		if ( is_singular() ) {
			
			global $post;

			if ( has_shortcode( $post->post_content, "{$this->base}" ) ) {
				parent::enqueue_script();
				wp_enqueue_script('isotope');
				wp_enqueue_script('magnific-popup');
				wp_enqueue_style('magnific-popup');
				wp_add_inline_script('magnific-popup', '
				(function($) {
					$(".mp-video-popup").magnificPopup({
						type: \'iframe\',
						mainClass: \'mfp-fade\',
						removalDelay: 160,
					});
				})(jQuery);
				');
			}
		}

	}

	// map shortcode to vc

	public function vc_map_shortcode() {
		vc_map( array(
			'base' 				=> $this->base,
			'name' 				=> esc_html__( 'Toolkit Lightbox Video', 'basr-core' ),
			'class' 			=> '',
			'category' 			=> $this->cat,
			'icon' 				=> $this->icon,
			'params' 			=> array(
				array(
					'param_name'       => 'align',
					'heading'          => esc_html__( 'Align', 'basr-core' ),
					'type'             => 'dropdown',
					'value'			   => array(
						esc_html__('Left'  ) 	=> 'left',			
						esc_html__('Center') 	=> 'center',			
						esc_html__('Right') 	=> 'right',			
					),
				),
				array(
					'param_name'       => 'video_url',
					'heading'          => esc_html__( 'Video Url', 'basr-core' ),
					'type'             => 'textfield',
				),
				array(
					'param_name'       => 'video_thumb',
					'heading'          => esc_html__( 'Video Thumbnail', 'basr-core' ),
					'type'             => 'attach_image',
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
			'align'		  => 'left',
			'video_url'   => '',
			'video_thumb' => '',
			'size'		  => '',
			'classes'     => '',
			'anm'         => '',
			'anm_name'    => '',
			'anm_delay'   => '',
		), $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '', ' ' . $align ); // pass id setting if need vc custome css class, 

		// set up shortcode here

		$size = $size ? $size : 'full';

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';
		ob_start(); ?>

		<a class="mp-video-popup" href="<?php echo esc_url($video_url) ?>">
			<?php echo wp_get_attachment_image( $video_thumb, $size );?>
			<div class="icon">
				<div class="insider">
					<i class="video-play-icon"></i>
				</div>
			</div>
		</a>

		<?php $output .= ob_get_clean();
		$output .= '</div>';

		// filter 

		$output = apply_filters( "basr_{$this->base}_filter", $output );

		return $output;
	}

}

