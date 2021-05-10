<?php 


class toolkit_basr_shortcode_empty_space extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'empty_space';

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
						'name' 				=> esc_html__( 'Empty space', 'basr-core' ),
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
								'param_name'  => 'height_desk_top',
								'heading'     => esc_html__( 'Height of unit on Large desktop', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'height_1600',
								'heading'     => esc_html__( 'Height of unit on desktop screen <= 1600', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'group'		  => esc_html__( 'Extra screen desktop', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'height_1440',
								'heading'     => esc_html__( 'Height of unit on desktop screen <= 1440', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'group'		  => esc_html__( 'Extra screen desktop', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'height_1366',
								'heading'     => esc_html__( 'Height of unit on desktop screen <= 1366', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'group'		  => esc_html__( 'Extra screen desktop', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'height_1280',
								'heading'     => esc_html__( 'Height of unit on desktop screen <= 1280', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'group'		  => esc_html__( 'Extra screen desktop', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'height_tablet_h',
								'heading'     => esc_html__( 'Height of unit on tablet Horizontal : =< 1024px ', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'height_tablet_v',
								'heading'     => esc_html__( 'Height of unit on tablet Vertical : =< 768px', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),
							array(
								'param_name'  => 'height_tablet_m',
								'heading'     => esc_html__( 'Height of unit on mobile  : =< 667', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),

							toolkit_basr_vcf_class(),

							// toolkit_basr_vcf_animate( $i =  0,1,2 ); anable animation ?, animation name, animation delay .

							// More fields here 

						),
					) 
				);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 			=> ''			,
			'classes'							=> ''			,
			'height_desk_top'					=> ''			,
			'height_tablet_h'					=> ''			,
			'height_tablet_v'					=> ''			,
			'height_tablet_m'					=> ''			,

			// atts here

		), $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// Start out put

		$output = '<div id="' . $id . '" class="' . $classes . '">';

		$output .= '</div>';

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {
		extract( shortcode_atts( array(
			$this->base . '_id' 				=> ''			,
			'height_desk_top'					=> ''			,
			'height_1600'						=> ''			,
			'height_1440'						=> ''			,
			'height_1366'						=> ''			,
			'height_1280'						=> ''			,
			'height_tablet_h'					=> ''			,
			'height_tablet_v'					=> ''			,
			'height_tablet_m'					=> ''			,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';

		$css .= $id . '{height: ' . intval( $height_desk_top ) . 'px;}' ;

		$css .= $height_1600 != ''  ? '@media (max-width: 1600px){' . $id . '{height: ' . intval( $height_1600 ) . 'px;}' . '}' : '';
		$css .= $height_1440 != ''  ? '@media (max-width: 1440px){' . $id . '{height: ' . intval( $height_1440 ) . 'px;}' . '}' : '';
		$css .= $height_1366 != ''  ? '@media (max-width: 1366px){' . $id . '{height: ' . intval( $height_1366 ) . 'px;}' . '}' : '';
		$css .= $height_1280 != ''  ? '@media (max-width: 1280px){' . $id . '{height: ' . intval( $height_1280 ) . 'px;}' . '}' : '';
		$css .= $height_tablet_h != ''  ? '@media (max-width: 1024px){' . $id . '{height: ' . intval( $height_tablet_h ) . 'px;}' . '}' : '';
		$css .= $height_tablet_h != '' ? '@media (max-width: 1024px){' . $id . '{height: ' . intval( $height_tablet_h ) . 'px;}' . '}' : '';
		$css .= $height_tablet_v != '' ? '@media (max-width: 768px) {' . $id . '{height: ' . intval( $height_tablet_v ) . 'px;}' . '}' : '';
		$css .= $height_tablet_m != ''  ? '@media (max-width: 667px) {' . $id . '{height: ' . intval( $height_tablet_m ) . 'px;}' . '}' : '';

		return $css;
	}

}
