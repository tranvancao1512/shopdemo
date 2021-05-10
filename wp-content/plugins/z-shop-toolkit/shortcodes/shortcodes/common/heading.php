<?php 


class toolkit_basr_shortcode_heading extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'heading';

	public $animation = 'true';

	// this->base = $prefix + $shortcode;

	// register script 

	public function register_script ( ) {

	}

	// Enqueue script, style 

	public function enqueue_script ( $extra = array() ) {

		global $post;

		$sc = get_query_var( $this->base );

		if (  ( is_object( $post ) && has_shortcode( $post->post_content, "{$this->base}" ) ) || $sc ) {
			
			parent::enqueue_script();

		}
		
	}

	// map shortcode to vc

	public function vc_map_shortcode() {

		vc_map( array(
						'base' 				=> $this->base,
						'name' 				=> esc_html__( 'Heading', 'basr-core' ),
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
								'param_name'  		=> 'title',
								'heading'     		=> esc_html__( 'Title', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'     		=> 'div',
								'value'       		=> '',
								'description'		=> esc_html__( 'Use {{words}} to hightlight, {br} to break line', 'basr-core' ),
								'admin_label' 		=> true,
							),
							array(
								'param_name' 		=> 'h',
								'heading' 	 		=> esc_html__( 'Heading Tag', 'basr-core' ),
								'type' 		 		=> 'dropdown',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15',
								'std'				=> 'h2',
								'value'      		=> array(
									esc_html__( 'H1', 'basr-core' ) 		=> 'h1',
									esc_html__( 'H2', 'basr-core' ) 		=> 'h2',
									esc_html__( 'H3', 'basr-core' ) 		=> 'h3',
									esc_html__( 'H4', 'basr-core' ) 		=> 'h4',
									esc_html__( 'H5', 'basr-core' ) 		=> 'h5',
									esc_html__( 'H6', 'basr-core' ) 		=> 'h6',
									esc_html__( 'Custom', 'basr-core' ) 	=> 'custom',
								),
							),
							array(
								'param_name'  		=> 'font_size',
								'heading'     		=> esc_html__( 'Custom Font Size', 'basr-core' ),
								'description' 		=> esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'type'       		=> 'textfield',
								'holder'      		=> 'div',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'admin_label' 		=> false,
								'dependency' 		=> array(
															'element' => 'h',
															'value'   => array( 'custom' )
														),
							),
							array(
								'param_name'  		=> 'letter_spacing',
								'heading'     		=> esc_html__( 'Letter spacing', 'basr-core' ),
								'description' 		=> esc_html__( 'Unit is em.', 'basr-core' ),
								'type'       		=> 'textfield',
								'holder'      		=> 'div',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
							),
							array(
								'param_name'  		=> 'font_weight',
								'heading'     		=> esc_html__( 'Font Weight', 'basr-core' ),
								'description' 		=> esc_html__( '', 'basr-core' ),
								'type'       		=> 'dropdown',
								'std'				=> '700',
								'holder'      		=> 'div',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'value'      		=> array(
									esc_html__( '300', 'basr-core' ) 		=> '300',
									esc_html__( '400', 'basr-core' )   		=> '400',
									esc_html__( '600', 'basr-core' )  		=> '600',
									esc_html__( '700', 'basr-core' )  		=> '700',
									esc_html__( '800', 'basr-core' )  		=> '800',
									esc_html__( '900', 'basr-core' )  		=> '900',
								),
								'admin_label' 		=> false,
							),
							array(
								'param_name' 		=> 'align',
								'heading' 	 		=> esc_html__( 'Align', 'basr-core' ),
								'type' 		 		=> 'dropdown',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'value'      		=> array(
									esc_html__( 'Center', 'basr-core' ) => 'text-center',
									esc_html__( 'Left', 'basr-core' )   => 'text-left',
									esc_html__( 'Right', 'basr-core' )  => 'text-right'
								),
							),
							array(
								'param_name' 		=> 'text_transform',
								'heading' 	 		=> esc_html__( 'Text transform', 'basr-core' ),
								'type' 		 		=> 'dropdown',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'value'      		=> array(
									esc_html__( 'Uppercase', 'basr-core' ) 	=> 'uppercase',
									esc_html__( 'Lowercase', 'basr-core' ) 	=> 'lowercase',
									esc_html__( 'None'     , 'basr-core' )  	=> 'none'
								),
							),
							array(
								'param_name' 		=> 'border',
								'heading' 	 		=> esc_html__( 'Has border', 'basr-core' ),
								'type' 		 		=> 'checkbox',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15',
								'value'      		=> true
							),
							array(
								'param_name' 		=> 'border_style',
								'heading' 	 		=> esc_html__( 'Border Style', 'basr-core' ),
								'type' 		 		=> 'dropdown',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15',
								'value'      		=> array(
															esc_html__( 'Border 1', 'basr-core' ) 		=> 'border-1',
															esc_html__( 'Border 2', 'basr-core' )   		=> 'border-2',
															esc_html__( 'Border 3', 'basr-core' )   		=> 'border-3',
															esc_html__( 'Border 4', 'basr-core' )   		=> 'border-4',
															esc_html__( 'Border 5', 'basr-core' )   		=> 'border-5',
														),
								'dependency'		=> array(
									'element'		=> 'border',
									'value'			=> 'true'
								),	
							),
							array(
								'param_name'  		=> 'color',
								'heading'     		=> esc_html__( 'Title Color', 'basr-core' ),
								'type'        		=> 'colorpicker',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'group'			  	=> esc_html__( 'Custom color, hightlight words', 'basr-core' ),
							),
							array(
								'param_name'  		=> 'hightlight_color',
								'heading'     		=> esc_html__( 'hightligh Color', 'basr-core' ),
								'type'        		=> 'colorpicker',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'group'			  	=> esc_html__( 'Custom color, hightlight words', 'basr-core' ),
							),
							array(
								'param_name'  		=> 'border_color',
								'heading'     		=> esc_html__( 'Border Color', 'basr-core' ),
								'type'        		=> 'colorpicker',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'group'			  	=> esc_html__( 'Custom color, hightlight words', 'basr-core' ),
							),
							array(
								'param_name'  		=> 'link',
								'heading'     		=> esc_html__( 'Link to', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'      		=> 'div',
								'value'       		=> ''
							),
							array(
								'param_name'  		=> 'color_hover',
								'heading'     		=> esc_html__( 'Link hover color', 'basr-core' ),
								'type'        		=> 'colorpicker',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15',
								'group'			  	=> esc_html__( 'Custom color, hightlight words', 'basr-core' ),
							),
							array(
								'param_name'  		=> 'hightlight_font_size',
								'heading'     		=> esc_html__( 'hightligh font size', 'basr-core' ),
								'type'        		=> 'textfield',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'group'			  	=> esc_html__( 'Custom color, hightlight words', 'basr-core' ),
							),
							array(
								'param_name' 		=> 'hightlight_style',
								'heading' 	 		=> esc_html__( 'hightlight style', 'basr-core' ),
								'type' 		 		=> 'dropdown',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15',
								'value'      		=> array(
															esc_html__( 'Normal', 'basr-core' ) 		=> '',
															esc_html__( 'Italic', 'basr-core' )   	=> 'italic',
															esc_html__( 'oblique', 'basr-core' )   	=> 'oblique',
														),
								'group'			  	=> esc_html__( 'Custom color, hightlight words', 'basr-core' ),
							),
							array(
								'param_name'       => 'content',
								'heading'          => esc_html__( 'Excerpt', 'basr-core' ),
								'type'             => 'textarea_html',
								'admin_label'	   => true,
							),

							toolkit_basr_vcf_animate(0),

							toolkit_basr_vcf_animate(1),

							toolkit_basr_vcf_animate(2),

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
						'h'         						=> 'h2'				,
						'title'								=> ''				,
						'align'     						=> 'text-center'	,
						'link'								=> ''				,
						'border'    						=> ''				,
						'border_style'    					=> 'border-1'				,
						'classes'							=> ''				,
						'anm'								=> ''				,
						'anm_name'							=> ''				,
						'anm_delay'							=> '1000'			,
						'color'								=> '',
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// high light span

		$title = str_replace( '{{', '<span>', $title );
		$title = str_replace( '}}', '</span>', $title );
		$title = str_replace( '{br}', '<br>', $title );

		// enqueue

		$this->enqueue_script();

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// animation

		$anm_html = toolkit_basr_get_animation( $atts );

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// set up shortcode here

			$classes .= ' ' . $align;

			// border

			$border_html_before = $border_html_after = '';

			if ( $border ) : 
				$classes .= ' has-border ' . $border_style ;
			endif; 

			//  link 

			if ( $link ) $title = '<a href="' . esc_url( $link ) . '">' . $title . '</a>';

			$h  = ( $h == 'custom' ) ? 'h2' : $h;
		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . $this->animation_data( $sc_atts ) . '>' ;

		$output .= $anm_html[0];

		$output .= '<div class="basr-heading-inner">';

		$output .= $border_html_before;

		$output .= '<' . $h . ' class="h">' . $title . '</' . $h . '>';

		$output .= $border_html_after;

		$content = preg_replace( '/^<\/p>/', '', $content );
		$content = preg_replace( '/<p>$/', '', $content );

		$output .= '<div class="excerpt">' . $content  . '</div>';

		$output .= '</div>';// heading inner

		$output .= $anm_html[1];

		$output .= '</div>'; // . #id

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 				=> ''			,
			'font_size' 						=> ''			,
			'letter_spacing' 					=> ''			,
			'font_weight'	 					=> ''			,
			'color'								=> ''			,
			'hightlight_color'					=> ''			,
			'hightlight_font_size'				=> ''			,
			'hightlight_style'					=> ''			,
			'border_color'						=> ''			,
			'color_hover'						=> ''			,
			'text_transform'					=> 'uppercase'	,
			'classes'							=> ''			,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';

		if ( $font_size ) {
			$css .= $id . ' .h { font-size:' . intval( $font_size ) . 'px;}';
		}
		if ( $font_weight ) {
			$css .= $id . ' .h { font-weight:' . intval( $font_weight ) . ';}';
		}
		if ( $letter_spacing ) {
			$css .= $id . ' .h { letter-spacing:' . floatval( $letter_spacing ) . 'em;}';
			$css .= '@media (max-width: 568px) {' . $id . ' .h{ letter-spacing: 0.01em;}'  . '}';
		}
		if ( $color ) {
			$css .= $id . ' .h { color:' . $color . ';}';
		}
		if ( $hightlight_color ) {
			$css .= $id . ' .h span { color:' . $hightlight_color . ';}';
		}
		if ( intval( $hightlight_font_size ) ) {
			$css .= $id . ' .h span { font-size:' . intval( $hightlight_font_size ) . 'px;}';
		}
		if ( $hightlight_style ) {
			$css .= $id . ' .h span { font-style:' . $hightlight_style . ';}';
		}
		if ( $border_color ) {
			$css .= $id . ' .h:after,' . $id . ' .h:before { background:' . $border_color . ' !important;}';
		}
		if ( $color_hover) {
			$css .= $id . ' .h a:hover { color: ' . $color_hover . '}';
		}
		if ( $text_transform && $text_transform != 'none') {
			$css .= $id . ' .h { text-transform: ' . $text_transform . '}';
		}

		return $css;
	}

}
