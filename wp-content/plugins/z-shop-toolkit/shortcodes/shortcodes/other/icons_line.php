<?php 

class toolkit_basr_shortcode_icons_line extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'icons_line';

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
			'name' 				=> esc_html__( 'Toolkit Icons Line', 'basr-core' ),
			'class' 			=> '',
			'category' 			=> $this->cat,
			'icon' 				=> $this->icon,
			'js_view'         	=> 'VcColumnView',
			'as_parent'       	=> array(
				'only' => $this->prefix . 'icon_line',
			),
			'params' 			=> array(
				array(
					'param_name'       => $this->base . '_id',
					'heading'          => esc_html__( 'ID', 'basr-core' ),
					'type'             => 'textfield',
					'value'            =>  0,
					'edit_field_class' => 'hidden',
				),
				array(
					'param_name'       => 'bg_size',
					'heading'          => esc_html__( 'Background Size', 'basr-core' ),
					'type'             => 'textfield',
					'description'      => esc_html__( 'Number only. Unit in px', 'basr-core' ),
					'value'            => '86',
					'edit_field_class'       => 'vc_col-xs-12 vc_col-md-6',
				),
				array(
					'param_name'       => 'icon_size',
					'heading'          => esc_html__( 'Icon Size', 'basr-core' ),
					'type'             => 'textfield',
					'description'      => esc_html__( 'Number only. Unit in px', 'basr-core' ),
					'value'            => '26',
					'edit_field_class'       => 'vc_col-xs-12 vc_col-md-6',
				),
				array(
					'param_name'  => 'color_text',
					'heading'     => esc_html__( 'Icon Color', 'basr-core' ),
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'edit_field_class'       => 'vc_col-xs-12 vc_col-md-4',
					'value'         => '#4f4f4f',
					'description'      => esc_html__( 'Apply to Icon Font only.', 'basr-core' ),
				),
				array(
					'param_name'  => 'color_bg',
					'heading'     => esc_html__( 'Background Color', 'basr-core' ),
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'edit_field_class'       => 'vc_col-xs-12 vc_col-md-4',
					'value' => '#ffffff',
				),
				array(
					'param_name'  => 'color_border',
					'heading'     => esc_html__( 'Border Color', 'basr-core' ),
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'edit_field_class'       => 'vc_col-xs-12 vc_col-md-4',
					'value'         => '#ececec',
				),
				array(
					'param_name'  => 'color_hover_text',
					'heading'     => esc_html__( 'Icon Color Hover', 'basr-core' ),
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'value'         => '#ffffff',
					'edit_field_class'       => 'vc_col-xs-12 vc_col-md-4',
					'description'      => esc_html__( 'Apply to Icon Font only.', 'basr-core' ),
				),
				array(
					'param_name'  => 'color_hover_bg',
					'heading'     => esc_html__( 'Background Hover', 'basr-core' ),
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'value'         => '#91a7d0',
					'edit_field_class'       => 'vc_col-xs-12 vc_col-md-4',
				),
				array(
					'param_name'  => 'color_hover_border',
					'heading'     => esc_html__( 'Border Hover', 'basr-core' ),
					'type'        => 'colorpicker',
					'holder'      => 'div',
					'value'         => '#91a7d0',
					'edit_field_class'       => 'vc_col-xs-12 vc_col-md-4',
				),
				toolkit_basr_vcf_class(),
				toolkit_basr_vcf_animate(0),
				toolkit_basr_vcf_animate(1),
				toolkit_basr_vcf_animate(2),
			)
		)
	);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {
		$this->enqueue_script();

		extract( shortcode_atts( array(
			$this->base . '_id' 				=> ''				,
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
		$output .= do_shortcode($content);
		$output .= '</div>';

		// filter 

		$output = apply_filters( "basr_{$this->base}_filter", $output );

		return $output;
	}

	public function generate_shortcode_css ( $atts ) {
		extract( shortcode_atts( array(
			$this->base . '_id' 				=> ''			,
			'bg_size'					=> '86'			,
			'icon_size'					=> '29'			,
			'color_text'					=> '#4f4f4f'			,
			'color_bg'					=> '#fff'			,
			'color_border'					=> '#ececec'			,
			'color_hover_text'					=> '#fff'			,
			'color_hover_bg'					=> '#91a7d0'			,
			'color_hover_border'					=> '#91a7d0'			,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = $id . ' .icon {';
		$css .= 'width:' . $bg_size . 'px;';
		$css .= 'height:' . $bg_size . 'px;';
		$css .= 'font-size:' . $icon_size . 'px;';
		$css .= 'background-size:' . $icon_size . 'px;';
		$css .= 'color:' . $color_text . ';';
		$css .= 'background-color:' . $color_bg . ';';
		$css .= 'border-color:' . $color_border . ';';
		$css .= '}';

		$css .= $id . ' > div:hover .icon {';
		$css .= 'color:' . $color_hover_text . ';';
		$css .= 'background-color:' . $color_hover_bg . ';';
		$css .= 'border-color:' . $color_hover_border . ';';
		$css .= '}';
		$css .= '@media (min-width: 768px) {';
		$css .= $id. ':before {';
		$css .= 'top: ' . (intval($bg_size) / 2) .'px;';
		$css .= '}';
		$css .= '}';


			return $css;
	}

}

if ( class_exists('VC_Manager') && is_admin() ) {

	class WPBakeryShortCode_lucy_icons_line extends WPBakeryShortCodesContainer {}

}
