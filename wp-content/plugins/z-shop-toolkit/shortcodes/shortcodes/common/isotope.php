<?php 


class toolkit_basr_shortcode_isotope extends toolkit_basr_shortcode {

	// shortcode name 

	public 		$shortcode = 'isotope';
	public 		$container = true;

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
						'name' 				=> esc_html__( 'Isotope Grid', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'as_parent'       	=> array( 
													'only' => 'vc_single_image, vc_column_text, toolkit_banner ,' .
															  $this->prefix . 'member' . ',' .
															  $this->prefix . 'empty_space'
												),
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
								'param_name'  => 'layout',
								'heading'     => esc_html__( 'Layout Type', 'basr-core' ),
								'description' => esc_html__( '', 'basr-core' ),
								'type'        => 'dropdown',
								'holder'      => 'div',
								'value' 	  => array(
									esc_html__('Grid','basr-core') => 'grid',
									esc_html__('Masonry','basr-core') => 'masonry',
									esc_html__('Layout 1 (Masonry 2 column)') => 'masonry-1',
								),
							),
							array(
								'param_name'  => 'no_padding',
								'heading'     => esc_html__( 'No padding', 'basr-core' ),
								'type'        => 'checkbox',
								'holder'      => 'div',
								'value' 	  => true,
							),
							array(
								'param_name'  => 'column',
								'heading'     => esc_html__( 'Number of columns', 'basr-core' ),
								'description' => esc_html__( '', 'basr-core' ),
								'type'        => 'dropdown',
								'holder'      => 'div',
								'value' 	  => array(
									esc_html__('2 column','basr-core') => 'column-2',
									esc_html__('3 column','basr-core') => 'column-3',
									esc_html__('4 column','basr-core') => 'column-4',
									esc_html__('5 column','basr-core') => 'column-5',
								),
								'dependency' => array(
										'element'	=> 'layout',
										'value'		=> array('grid','masonry'),
								),
							),
							array(
								'param_name'  => 'column_md',
								'heading'     => esc_html__( 'Number of columns on Medium device >= 992px', 'basr-core' ),
								'description' => esc_html__( '', 'basr-core' ),
								'type'        => 'dropdown',
								'holder'      => 'div',
								'value' 	  => array(
									esc_html__('1 column','basr-core') => 'column-md-1',
									esc_html__('2 column','basr-core') => 'column-md-2',
									esc_html__('3 column','basr-core') => 'column-md-3',
									esc_html__('4 column','basr-core') => 'column-md-4',
									esc_html__('5 column','basr-core') => 'column-md-5',
								),
								'dependency' => array(
										'element'	=> 'layout',
										'value'		=> array('grid','masonry'),
									),
							),
							array(
								'param_name'  => 'column_sm',
								'heading'     => esc_html__( 'Number of columns on Small device >= 768px', 'basr-core' ),
								'description' => esc_html__( '', 'basr-core' ),
								'type'        => 'dropdown',
								'holder'      => 'div',
								'value' 	  => array(
									esc_html__('1 column','basr-core') => 'column-sm-1',
									esc_html__('2 column','basr-core') => 'column-sm-2',
									esc_html__('3 column','basr-core') => 'column-sm-3',
									esc_html__('4 column','basr-core') => 'column-sm-4',
									esc_html__('5 column','basr-core') => 'column-sm-5',
								),
								'dependency' => array(
										'element'	=> 'layout',
										'value'		=> array('grid','masonry'),
									),
							),
							array(
								'param_name'  => 'column_xs',
								'heading'     => esc_html__( 'Number of columns on Small device < 768px', 'basr-core' ),
								'description' => esc_html__( '', 'basr-core' ),
								'type'        => 'dropdown',
								'holder'      => 'div',
								'value' 	  => array(
									esc_html__('1 column','basr-core') => 'column-xs-1',
									esc_html__('2 column','basr-core') => 'column-xs-2',
									esc_html__('3 column','basr-core') => 'column-xs-3',
									esc_html__('4 column','basr-core') => 'column-xs-4',
									esc_html__('5 column','basr-core') => 'column-xs-5',
								),
								'dependency' => array(
										'element'	=> 'layout',
										'value'		=> array('grid','masonry'),
									),
							),

							toolkit_basr_vcf_class(),

							// toolkit_basr_vcf_animate( $i =  0,1,2 ); anable animation , animation name, animation delay .

							// More fields here 

						),
					) 
				);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {
		$this->enqueue_script();

		extract( shortcode_atts( array(
			$this->base . '_id' 				=> ''				,
			'layout' 							=> 'grid'			,
			'no_padding' 						=> ''				,
			'column' 							=> 'column-2'		,
			'column_md'  						=> 'column-md-1'	,
			'column_sm'  						=> 'column-sm-1'	,
			'column_xs'  						=> 'column-xs-1'	,
			'classes'							=> ''				,
		), $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$no_padding = $no_padding ? ' no-padding ' : '';

		$classes .= $this->get_class( '', $no_padding ); // pass id setting if need vc custome css class, 

		// set up shortcode here

		$arr_class 	 = array();
		$arr_class[] = 'basr-sc-isotope';
		$arr_class[] = $layout;

		if ( $layout != 'masonry-1' ) {
			$arr_class[] = 'basr-isotope-grid';
			$arr_class[] = $column;
			$arr_class[] = $column_md;
			$arr_class[] = $column_sm;
			$arr_class[] = $column_xs;
		} else {
			$arr_class[] = 'masonry-layout';
		}

		if ( $layout == 'masonry' ) {
			$arr_class[] = 'masonry-layout';
		}

		$classes  	.= implode( ' ', $arr_class );

		// change content shortcode 

		if ( $layout == 'masonry-1' ) {
			$content = preg_replace( '/\[(\w+)(\s)/', '[$1$2 layout=' . $layout . ' ', $content );
		}

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '">';

		$output .= do_shortcode( $content );

		$output .= '</div>';

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'classes'					=> ''			,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';

		return $css;
	}

}

if ( class_exists('VC_Manager') && is_admin() ) {

	class WPBakeryShortCode_toolkit_isotope extends WPBakeryShortCodesContainer {}

}
