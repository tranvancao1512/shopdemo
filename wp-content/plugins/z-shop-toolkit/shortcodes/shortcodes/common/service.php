<?php 


class toolkit_basr_shortcode_service extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'service';

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
						'name' 				=> esc_html__( 'Service', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'as_parent'			=> array( 
													'only' => $this->prefix . 'service_item' . ',' 
				  								),
						'is_container'		=> true,
						'js_view'         	=> 'VcColumnView',
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
								'param_name'	=> 'heading_color',
								'heading'     	=> esc_html__( 'Heading color', 'basr-core' ),
								'type'			=> 'colorpicker',
							),

							array(
								'param_name'	=> 'link_color',
								'heading'     	=> esc_html__( 'Link hover color if heading contain link', 'basr-core' ),
								'type'			=> 'colorpicker',
							),

							array(
								'param_name'	=> 'text_color',
								'heading'     	=> esc_html__( 'Text color', 'basr-core' ),
								'type'			=> 'colorpicker',
							),

							array(
								'param_name'	=> 'bg_color',
								'heading'     	=> esc_html__( 'Background Color', 'basr-core' ),
								'type'			=> 'colorpicker',
							),

							// slick item display 

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
						'title'								=> ''				,
						// atts here  

						'classes'							=> ''				,
						'anm'								=> ''				,
						'anm_name'							=> ''				,
						'anm_delay'							=> ''			,
					);

		$sc_atts = is_array( $atts ) ? $atts + $sc_atts : $sc_atts;

		extract( shortcode_atts( $sc_atts, $atts ) );

		// Enqueue 


		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$slick_uniqid 	  = 'slick-' . uniqid();
		$slick_uniqid_nav =	'slick-' . uniqid();

		$classes .= $this->get_class( '', 'slick-reverse-syn' ); // pass id setting if need vc custome css class

		// set up shortcode here

		preg_match_all( '/' . get_shortcode_regex() . '/' , $content, $service_items );

		$uploads = array();

		foreach ($service_items[3] as $key => $item) {
			$atts = shortcode_parse_atts( $item );
			if ( isset( $atts['img'] ) ) {
				$uploads[] = $atts['img'];
			}
		}

		$uploads = array_reverse( $uploads );

		// Start out put

		$data_slick = toolkit_basr_slick_data($sc_atts);

		$output = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . ' data-slider="' . htmlentities( $data_slick, ENT_QUOTES, 'UTF-8') . '">';

		// ob_start 

		// left slider 

		$left_slider = array( 
			'slidestoshow'						=> 1						,
			'arrows'							=> false					,
			'dots'								=> false					,
			'infinite'							=> true						,
			'autoplay'							=> false					,
			'vertical'							=> false					,
			'swipe'								=> false 					,
			'swipeToSlide'						=> false
			// 'asNavFor'							=> $slick_uniqid			,
		);

		$data_slick = json_encode( $left_slider );

		ob_start();

		echo '<div class="wrap-left-slider">';

		echo '<h2 class="service-title">' . $title . '</h2>';

		echo '<div class="basr-slick left-slider ' . esc_attr( $slick_uniqid_nav ) . '" data-slick="' . esc_attr( $data_slick ) . '">';
		foreach ($service_items[0] as $key => $item) {
			echo do_shortcode( $item );
		}
		echo '</div>'; // .slick

		echo '<div class="wrap-nav">';
		echo '<span class="fake-prev"><i class="ion-chevron-left"></i>' . esc_html__( 'prev', 'basr-core' ) . '</span>';
		echo '<span class="fake-next"><i class="ion-chevron-right"></i>' . esc_html__( 'next', 'basr-core' ) . '</span>';
		echo '</div>';

		echo '</div>'; // .wrap-left-slider

		$left_slider = ob_get_clean();



		// right slider 

		$right_slider = array( 
			'slidestoshow'						=> 1						,
			'arrows'							=> false					,
			'dots'								=> false					,
			'infinite'							=> true						,
			'autoplay'							=> false					,
			'vertical'							=> false					,
			'swipe'								=> false 					,
			'swipeToSlide'						=> false 					, 
			// 'asNavFor'							=> $slick_uniqid			,
		);

		ob_start();

		$data_slick = json_encode( $right_slider );

		echo '<div class="basr-slick right-slider ' . esc_attr( $slick_uniqid_nav ) . '" data-slick="' . esc_attr( $data_slick ) . '">';
		foreach ($uploads as $key => $img) {
			echo wp_get_attachment_image( $img, 'full' );
		}
		echo '</div>';

		$right_slider = ob_get_clean();


		$output .= $right_slider . $left_slider;

		// ob_end

		$output .= '</div>'; // end wrap-slick-slider

		// $output .= wpb_js_remove_wpautop( $content, true );

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'heading_color'				=> '',
			'link_color'				=> '',
			'text_color'				=> '',
			'bg_color'					=> '',
			'classes'					=> '',
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';
		if ( $heading_color ) $css .= $id . ' .service-title,' . $id . ' .title,' . $id . ' .title a{ color:' . $heading_color . ';}';
		if ( $link_color )	$css .= $id . ' .title a:hover{color:' . $link_color . '}';
		if ( $text_color )	{
			$css .= $id . ' .basr-service_item,' . $id . ' .wrap-nav{color:' . $text_color . '}'; 
			$css .= $id . ' .wrap-nav span:hover{color: #fff}';
		}
		if ( $bg_color	) 	{
			$css .= $id . ' .wrap-left-slider,' . $id . ' .wrap-left-slider .wrap-nav .fake-next:hover{background-color:' . $bg_color . '}'; 
		}
		return $css;

	}

}

