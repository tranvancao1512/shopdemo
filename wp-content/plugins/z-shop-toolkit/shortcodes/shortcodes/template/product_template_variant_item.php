<?php 


class toolkit_basr_shortcode_product_template_variant_item extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'product_template_variant_item';

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
						'name' 				=> esc_html__( 'Product Variant Item', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> 'Product Template',
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
								'description'		=> esc_html__( 'Variant Title', 'basr-core' ),
								'admin_label' 		=> true,
							),

							array(
								'param_name'  		=> 'variant_attr',
								'heading'     		=> esc_html__( 'variant attributes name', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'     		=> 'div',
								'value'       		=> '',
								'description'		=> esc_html__( 'Seperate by |', 'basr-core' ),
								'admin_label' 		=> true,
							),

							array(
								'param_name'  		=> 'variant_attr_key',
								'heading'     		=> esc_html__( 'variant attributes', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'     		=> 'div',
								'value'       		=> '',
								'description'		=> esc_html__( 'Seperate by |', 'basr-core' ),
								'admin_label' 		=> true,
							),

							array(
								'param_name'  		=> 'variant_quick_filter',
								'heading'     		=> esc_html__( 'Show/Hide Quick filter', 'basr-core' ),
								'type'        		=> 'dropdown',
								'holder'     		=> 'div',
								'value'      		=> array(
									esc_html__( 'Hide', 'basr-core' ) 		=> 'hide',
									esc_html__( 'Show', 'basr-core' ) 		=> 'show',
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

		$sc_atts =  array( 
						$this->base . '_id' 				=> ''				,
						'title'								=> ''				
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// enqueue

		$this->enqueue_script();

		// get id 
		
		$id = ${$this->base . '_id'} ;

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


		$output .= '</div>'; // . #id

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 				=> ''			,
			'classes'							=> ''			,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';

		return $css;
	}

}
