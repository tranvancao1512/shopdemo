<?php 


class toolkit_basr_shortcode_product_template_content_m extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'product_template_content_m';

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
						'name' 				=> esc_html__( 'Product content for New Upload Design', 'basr-core' ),
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
								'param_name'  		=> 'content',
								'heading'     		=> esc_html__( 'Content', 'basr-core' ),
								'type'        		=> 'textarea_html',
								'holder'     		=> 'div',
								'value'       		=> '',
								'content'			=> true,
								'description'		=> esc_html__( 'Content', 'basr-core' ),
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
						'classes'							=> ''				
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// enqueue

		$this->enqueue_script();

		wp_enqueue_script('Tee-A-MU');

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// set up shortcode here

		$sku = $_GET['sku'];

		$manager = new Tee_Folder_Manager();

		$data = $manager->get_data_by_sku ( $sku );

		$sizeguide = '';

		foreach ( $data as $key => $value ) {
			$sizeguide .= tee_get_product_size_guide( $key );
		}

		// Start out put

		$output  = '<div id="' . $id . '" class="product_template_content basr-product_template_content basr-product_template_content_m ' . $classes . ' box-element" ' . $this->animation_data( $sc_atts ) . '>' ;

		$output .= '<h4>Product Description</h4>';

		ob_start();

		wp_editor( $content . $sizeguide , 'p-content' );

		$output .= ob_get_clean();

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

function tee_get_product_size_guide( $type ) {
	$product = get_page_by_title( $type, OBJECT, 'tee_product' );
	$sizeguide = origin_get_post_meta('size_guide', $product->ID );

	if ( isset( $sizeguide ) && $sizeguide && isset( $sizeguide['url'] ) ) {
		$html = '<img style="width: 100%;clear:left;margin:20px 0;" src="' . wp_get_attachment_url( $sizeguide['attachment_id'] ) . '" alt="sizeguide">';
	} else {
		$html = '';
	}

	return $html;
}