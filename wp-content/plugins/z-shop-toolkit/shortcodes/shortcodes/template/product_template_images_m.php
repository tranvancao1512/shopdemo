<?php 


class toolkit_basr_shortcode_product_template_images_m extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'product_template_images_m';

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
						'name' 				=> esc_html__( 'Product Images New Upload Design', 'basr-core' ),
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

		$output  = '<div id="' . $id . '" class="basr-product_template_images ' . $classes . ' box-element" ' . $this->animation_data( $sc_atts ) . '>' ;
	
		$output .= '<h4>Product Images</h4>';
		$output .= '<p class="temp"></p>';

			// get folder image

			$sku = $_GET['sku'];

			$manager = new Tee_Folder_Manager();

			$data = $manager->get_data_by_sku( $sku );

			$img_ids = array();
			foreach( $data as $type => $value ) {
				$value = str_replace('\\', '', $value);
				$value = json_decode($value);
				foreach( $value as $k => $id ) {
					if ( $k != 'f_d' && $k != 'b_d' && $id ) {
						$img_ids[] = $id;
					}
				}
		}

			$html = '<div class="product-imgs sortable">';

				$images_html = array('','');

				foreach ($img_ids as $key => $id) {
					$_html  = '<div class="img-item"><span class="img-remove">remove</span>';
					$_html .= '<image src="' . wp_get_attachment_url( $id ) . '">';
					$_html .= '</div>';
					$images_html[] = $_html;
				}

				$html .= implode('', $images_html);

			$html .= '</div>'; //.product-images

		$output .= $html;

		$output .= '<p class="des" style="color: blue">Hover on image re-arrange position. Hover and click (x) to remove unnecessary images if need.</p>';

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
