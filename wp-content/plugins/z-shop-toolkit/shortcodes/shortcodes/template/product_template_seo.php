<?php 


class toolkit_basr_shortcode_product_template_seo extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'product_template_seo';

	public $animation = '';

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
						'name' 				=> esc_html__( 'Product SEO', 'basr-core' ),
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
								'param_name'  		=> 'metafields_global_title_tag',
								'heading'     		=> esc_html__( 'SEO title', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'     		=> 'div',
								'value'       		=> '',
								'description'		=> esc_html__( '', 'basr-core' ),
								'admin_label' 		=> true,
							),

							array(
								'param_name'  		=> 'metafields_global_description_tag',
								'heading'     		=> esc_html__( 'SEO description', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'     		=> 'div',
								'value'       		=> '',
								'description'		=> esc_html__( 'Max 160 character', 'basr-core' ),
								'admin_label' 		=> true,
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
						'metafields_global_title_tag'		=> '',
						'metafields_global_description_tag'	=> '',
						'classes'								=> ''				
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// enqueue

		$this->enqueue_script();

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// set up shortcode here

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . $this->animation_data( $sc_atts ) . '>' ;

		$output .= '<span class="button btn-primary btn-toggle">SEO OPTION</span>';
		$output .= '<div class="wrap-toggle box-element">';
		$output .= '<h4>SEO Title (leave blank, It will be the same with Product title)</h4>';
		$output .= '<div class=wrap-seo-title"><input class="seo-title" type="text" value="' . $metafields_global_title_tag . '"></div>';
		$output .= '<h4>SEO Description</h4>';
		$output .= '<div class="wrap-seo-desc"><textarea class="seo-desc" placeholder="max 160 character">' . $metafields_global_description_tag . '</textarea></div>';
		$output .= '</div>'; // .wrap-toggle

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
