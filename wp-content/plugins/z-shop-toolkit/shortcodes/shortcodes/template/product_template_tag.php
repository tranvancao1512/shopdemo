<?php 


class toolkit_basr_shortcode_product_template_tag extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'product_template_tag';

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
						'name' 				=> esc_html__( 'Product Tag', 'basr-core' ),
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
								'param_name'  		=> 'tags_selected',
								'heading'     		=> esc_html__( 'Tags default selected', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'     		=> 'div',
								'value'       		=> '',
								'description'		=> esc_html__( 'seperate by , . Ex: tag1, tag2 ', 'basr-core' ),
								'admin_label' 		=> true,
							),

							array(
								'param_name'  		=> 'tags',
								'heading'     		=> esc_html__( 'Tags default but not selected.', 'basr-core' ),
								'type'        		=> 'textfield',
								'holder'     		=> 'div',
								'value'       		=> '',
								'description'		=> esc_html__( 'seperate by , . Ex: tag1, tag2 ', 'basr-core' ),
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
						'tags'						=> '',
						'tags_selected'				=> '',
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

		if ( ! $tags_selected ) {
			$tags_selected = array(
				'3dhoodie',
			);
		} else {
			$tags_selected = explode(',', $tags_selected );
			foreach ($tags_selected as $key => $tag ) {
				$tags_selected[$key] = preg_replace('/(^\s*)|(\s*$)/', '', $tag );
			}
		}
		if ( ! $tags ) {
			$tags = array(
				'addmoretag'
			);
		} else  {
			$tags = explode(',', $tags );
			foreach ($tags as $key => $tag ) {
				$tags[$key] = preg_replace('/(^\s*)|(\s*$)/', '', $tag );
			}
		}

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . ' box-element" ' . $this->animation_data( $sc_atts ) . '>' ;

		$output .= '<h4>Tags</h4>';

		$output .= '<select class="tags-select2" multiple="false" style="width: 100%;">';

		if ( count( $tags ) ) {
			foreach ($tags as $key => $tag) {
				$output .= '<option value="' . $tag . '">' . $tag . '</option>';
			}
		}

		if ( count( $tags_selected ) ) {
			foreach ($tags_selected as $key => $tag) {
				$output .= '<option value="' . $tag . '" selected>' . $tag . '</option>';
			}
		}

		$output .= '</select>';

		$output .= '<span class="button btn-primary clear-select2" style="margin-top: 20px;margin-bottom: 0;">Clear</span>';

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
