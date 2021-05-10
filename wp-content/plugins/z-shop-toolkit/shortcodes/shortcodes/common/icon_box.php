<?php 


class toolkit_basr_shortcode_icon_box extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'icon_box';

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
						'name' 				=> esc_html__( 'Icon box', 'basr-core' ),
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
								'param_name' 		=> 'layout',
								'heading' 	 		=> esc_html__( 'Layout', 'basr-core' ),
								'type' 		 		=> 'dropdown',
								'value'      		=> array( 'layout-1', 'layout-2', 'layout-3'),
							),

							array(
								'param_name'  		=> 'active',
								'heading'     		=> esc_html__( 'Active', 'basr-core' ),
								'type'        		=> 'checkbox',
								'holder'      		=> 'div',
								'value'				=> false,
								'dependency'		=> array( 
									'element'		=> 'layout',
									'value'			=> 'layout-3',
								)
							),

							array(
								'param_name'  		=> 'title',
								'heading'     		=> esc_html__( 'Title', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'      		=> 'div'
							),
							array(
								'param_name'  		=> 'link',
								'heading'     		=> esc_html__( 'Title link to', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'      		=> 'div'
							),
							array(
								'param_name'  		=> 'fontsize',
								'heading'     		=> esc_html__( 'Title Font Size', 'basr-core' ),
								'description' 		=> esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'      		=> 'div',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15',
							),
							array(
								'param_name' 		=> 'text_transform',
								'heading' 	 		=> esc_html__( 'Text Transform', 'basr-core' ),
								'type' 		 		=> 'dropdown',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15',
								'value'      		=> array(
									esc_html__( 'Inherit', 'basr-core' )    => 'inherit',
									esc_html__( 'Uppercase', 'basr-core' )  => 'uppercase',
									esc_html__( 'Lowercase', 'basr-core' )  => 'lowercase',
									esc_html__( 'Capitalize', 'basr-core' ) => 'capitalize',
								),
							),
							array(
								'param_name'  		=> 'title_color',
								'heading'     		=> esc_html__( 'Title Color', 'basr-core' ),
								'type'        		=> 'colorpicker',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15',
							),
							array(
								'param_name'  		=> 'hover_title_color',
								'edit_field_class'	=> 'vc_col-sm-6 mgt15',
								'heading'     		=> esc_html__( 'Link hover Color', 'basr-core' ),
								'type'        		=> 'colorpicker',
							),


						// group icon	

							array(
								'param_name' 		=> 'icon_type',
								'heading' 	 		=> esc_html__( 'Icon Type', 'basr-core' ),
								'type' 		 		=> 'dropdown',
								'group'      		=> esc_html__( 'Icon setting', 'basr-core' ),
								'value'      		=> array(
									'Icon Fonts' => 'icon_fonts',
									'Graphics'   => 'graphics',
								)
							),
							array(
								'param_name' 		=> 'graphic',
								'heading' 	 		=> esc_html__( 'Images', 'basr-core' ),
								'type' 		 		=> 'attach_image',
								'group'      		=> esc_html__( 'Icon setting', 'basr-core' ),
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'dependency' 		=> array(
									'element' 	=> 'icon_type',
									'value'   	=> array( 'graphics' )
								),
							),

							array(
								'param_name' 		=> 'graphic_hover',
								'heading' 	 		=> esc_html__( 'Image hover', 'basr-core' ),
								'type' 		 		=> 'attach_image',
								'group'      		=> esc_html__( 'Icon setting', 'basr-core' ),
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'dependency' 		=> array(
									'element' 	=> 'icon_type',
									'value'   	=> array( 'graphics' )
								),
							),

							array(
								'type' 				=> 'iconpicker',
								'heading' 			=> __( 'Icon', 'basr-core' ),
								'param_name' 		=> 'icon_awesome',
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'group'      		=> esc_html__( 'Icon setting', 'basr-core' ),
								'settings' 			=> array(
									'emptyIcon' 		=> true, // default true, display an "EMPTY" icon?
									'type' 				=> 'fontawesome',
									'iconsPerPage' 		=> 200, // default 100, how many icons per/page to display
								),
								'dependency' 		=> array(
									'element' 	=> 'icon_type',
									'value'   	=> array( 'icon_fonts' )
								)
							),

							array(
								'param_name'  		=> 'icon_font_size',
								'heading'     		=> esc_html__( 'Icon size', 'basr-core' ),
								'type'        		=> 'textfield',
								'description' 		=> esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'group'      		=> esc_html__( 'Icon setting', 'basr-core' ),
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'dependency'		=> array(
									'element' => 'icon_type',
									'value'   => array( 'icon_fonts' )
								),
							),
							array(
								'param_name' 		=> 'icon_color',
								'heading' 	 		=> esc_html__( 'Icon Color', 'basr-core' ),
								'type' 		 		=> 'colorpicker',
								'group'      		=> esc_html__( 'Icon setting', 'basr-core' ),
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'dependency' 		=> array(
									'element' => 'icon_type',
									'value'   => array( 'icon_fonts' )
								),
							),

							array(
								'param_name' 		=> 'icon_hover_color',
								'heading' 	 		=> esc_html__( 'Icon Color', 'basr-core' ),
								'type' 		 		=> 'colorpicker',
								'group'      		=> esc_html__( 'Icon setting', 'basr-core' ),
								'edit_field_class'  => 'vc_col-sm-6 mgt15',
								'dependency'		=> array(
									'element' => 'icon_type',
									'value'   => array( 'icon_fonts' )
								),
							),

							array(
								'param_name'  => 'content',
								'heading'     => esc_html__( 'Content', 'basr-core' ),
								'type'        => 'textarea_html',
								'holder'      => 'div',
								'value'       => ''
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
						$this->base . '_id' 				=> '',
						'layout'							=> 'layout-1',
						'active'							=> '',
						'title'								=> '',
						'link'								=> '',
						'icon_type'							=> 'icon_fonts',
						'graphic'							=> '',
						'graphic_hover'						=> '',
						'icon_awesome'						=> '',

						// atts here  

						'classes'							=> '',
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// Enqueue 

		$this->enqueue_script();

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// animation

		// get class

		$classes .= $this->get_class( '', ' ' . $layout ); // pass id setting if need vc custome css class

		if ( $active )	

		$classes .= $active 		? ' active' 		 : '';	
		$classes .= $graphic_hover  ? ' has-image-hover' : '';	


		// set up shortcode here

		$link_open = $link_end = $icon = '';

			// link 

		if ( $link ) {
			$link_open = '<a href="' . $link . '">';
			$link_end  = '</a>';
		}

			// icon 

		if ( $icon_type == 'icon_fonts' ) 
			$icon = '<i class="' . $icon_awesome . '"></i>';
		else {
			$icon   = '<div class="hover-image">' . wp_get_attachment_image( $graphic_hover ) . '</div>';
			$icon  .= wp_get_attachment_image( $graphic );
		}

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . $this->animation_data( $sc_atts ) . '>';

		$output .= '<div class="extra-css"></div>';

		// content

		$output .= '<div class="icon">' . $link_open . $icon . $link_end . '</div>';

		if ( $layout == 'layout-3' ) {
			$output .= '<div class="icon-holder">' . $link_open . $icon . $link_end . '</div>';
		}

		$output .= '<div class="text">' . $link_open . '<h2 class="title">' . $title . '</h2>' . $link_end;

		$output .= '<div class="content">' . do_shortcode( $content ) . '</div>';

		$output .= '</div>'; // .text

		$output .= '</div>'; // .$id

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> 	'',
			'fontsize'					=>	'',
			'text_transform'			=>	'',
			'title_color'				=>	'',
			'hover_title_color'			=>	'',
			'icon_font_size'			=>	'',
			'icon_color'				=>	'',
			'icon_hover_color'			=>	'',
			'classes'					=> 	'',
			// atts here

		), $atts ) );

		$id   = '#' . ${ $this->base . '_id' };

		$css  = '';

		// title

		$css .= $id . ' .text * {';
			$css .= ( $fontsize ) 	 ? 'font-size: ' . intval( $fontsize ) . 'px;'	: '';
			$css .= ( $title_color ) ? 'color: ' . $title_color  . ';'			:'';
		$css .= '}';

		$css .= $id . ' .text:hover * {';
			$css .= ( $hover_title_color ) ? 'color: ' . $hover_title_color . ';' : '';
		$css .= '}';

		if ( $text_transform ) {
			$css .= $id . ' .title {' .
						'text-transform: ' . $text_transform . ';' .
						'}';
		}

		// icon 
		$css .= $id . ' .icon i {';
			$css .= ( $icon_font_size ) 	 ? 'font-size: ' . intval( $icon_font_size ) . 'px;'	: '';
			$css .= ( $icon_color ) 		 ? 'color: ' . $icon_color  . ';'						:'';
		$css .= '}';

		$css .= $id . ':hover .icon i {';
			$css .= ( $icon_hover_color ) 	 ? 'color: ' . $icon_hover_color . ';' : '';
		$css .= '}';


		return $css;
	}

}
