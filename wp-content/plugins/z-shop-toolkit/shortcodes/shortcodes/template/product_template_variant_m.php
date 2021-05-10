<?php 


class toolkit_basr_shortcode_product_template_variant_m extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'product_template_variant_m';

	public $animation = 'true';

	public $container = false;

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
						'name' 				=> esc_html__( 'Product Variant For New Upload Design', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> 'Product Template',
						'icon' 				=> $this->icon,
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
								'param_name'       => 'price',
								'heading'          => esc_html__( 'Product price', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  '',
							),
							array(
								'param_name'       => 'compare_price',
								'heading'          => esc_html__( 'Product compare price', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  '',
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
						$this->base . '_id' => '',
						'price'             => '',
						'compare_price'     => '',
						'classes'           => ''				
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// enqueue

		$this->enqueue_script();

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// set up shortcode here

		$folder_id = $_GET['sku'];
		$user = new Tee_user();

		if ( !$price ) $price = '49.99';
		if ( !$compare_price ) $compare_price = '69.99';

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . $this->animation_data( $sc_atts ) . '>' ;

			$sku = $_GET['sku'];

			$folder = new Tee_Folder_Manager();

			$data = $folder->get_data_by_sku( $sku );

			$user = new Tee_user();

			$current_folder = $user->obj->user_login . '-' . $sku . '-'; 
 
			if ( $data ) {
				$type_arr = array();
				$type_option_arr = array();
				foreach( $data as $type => $line_data ) {
					$line_data = str_replace('\\', '',$line_data);
					$line_data = json_decode( $line_data );
					$cb = tee_get_product_cb_size( $type );
					$type_arr[$type] = $cb;
					$type_option_arr[] = $cb['type-label'];
				}
			}

			// setup shopify option register

			$option = array();
			$option[0] = new stdClass();
			$size_option_key = 0;
			$size_option_arr = array();
			if ( count($type_arr) > 1 ) {
				$option[1]        = new stdClass();
				$size_option_key  = 1;
				$option[0]->name  = 'Product';
				$option[0]->values = $type_option_arr;
				$has_option_type = true;
			}
			foreach( $type_arr as $type => $cb ) {
				$size_option_arr = array_merge( $size_option_arr, (array)$cb['size'] );
			}

			$option[$size_option_key]->name = 'Size';
			$_size_option_arr = array();
			foreach( $size_option_arr as $value ) {
				$_size_option_arr[] = $value;
			}
			$option[$size_option_key]->values = $_size_option_arr;

			// ?

			$product_type_name = isset( $product_type_name ) ? $product_type_name : '';

			$output .= '<div class="product-options" data-options="' . esc_attr( json_encode($option) ) . '">Options</div>';
			$output .= '<div class="product-price box-element">';
				$output .= '<div class="price"><label>Price</label><input class="price" type="number" value="' . $price . '" step="0.01"></div>';
				$output .= '<div class="compare-price"><label>Compare Price</label><input class="compare-price" type="number" step="0.01" value="' . $compare_price . '"></div>';
			$output .= '</div>'; //.product-price
			$output .= '<h4 class="button btn-primary btn-toggle">Variant Detail</h4>';
			$output .= '<div class="toggle-wrap box-element">';
				$output .= '<div class="wrap-type"><h4>Product Type</h4><input class="product-type" value="' . $product_type_name . '" placeholder="type"></div>' ;
				$output .= '<div class="variant-control"><span class="check-all">Check All</span><span class="uncheck-all">UnCheck All</span></div>';
				foreach ( $type_arr as $type => $cb ) {
					foreach ( $cb['cb'] as $cb_key => $cb_value ) {
						$output .=  '<div class="variant-item"><input type="checkbox" checked>';

						$sku = $current_folder . $cb_key;
						$sku = strtoupper( $sku );
						if( preg_match('/\|\|\|/', $cb_value ) ) {
							$_temp = explode('|||', $cb_value);
							if ( isset( $has_option_type ) && count($type_arr) > 1  ) {
								$output .= '<span>' . $_temp[0] . '</span>';
							}
							$output .= '<span>' . $_temp[1] . '</span>';
						} else {
							$output .= '<span>' . $cb_value . '</span>';	
						}
						$output .= '<div class="price"><label>Price</label><input class="price" type="number" step="0.01"></div>';
						$output .= '<div class="compare-price"><label>Compare Price</label><input class="compare-price" type="number" step="0.01"></div>';
						$output .= '<div class="sku"><label>SKU</label><input class="sku" value="' . $sku . '"></div>';
						$output .= '</div>'; //.variant-item
					}
				}

				$output .= '<div class="publish-product"><input class="publish" type="checkbox" checked><label>Publish</label></div>';
			$output .= '</div>'; //.toggle-wrap

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
if ( ! function_exists('get_cb_first_and_others') ) {
	function get_cb_first_and_others( $arr ) {
		$first = $arr[0];
		$cb = array();
		foreach ($arr as $key => $value) {
			if ( $key != 0 ) {
				$cb[] = $first . '-' . $value;
			}
		}

		return $cb;
	}
}
if ( ! function_exists('get_combinations') ) {
	function get_combinations( $arr, $cb = array() ) {
		if ( ! count( $arr ) ) return $cb ;
		$check_cb = count( $cb ) ? true: false;
		foreach ($arr as $key => $atts) {
			$next_arr = ( $arr );
			unset( $next_arr[$key] );
			foreach ( $atts as $att ) {
				if ( ! $check_cb ) {
					$cb[] = $att;  
				} else {
					foreach ($cb as $k => $v ) {
						$temp[] = array_merge((array)$v ,(array)$att);
					} 
				}
			}
			if ( isset( $temp ) && count( $temp ) ) {
				$cb = $temp;
			}
			$cb = get_combinations( $next_arr, $cb );
			//  
			
			break;
		}
		return $cb;
	}
}

function tee_get_product_cb_size( $type ) {
	$tee_product = get_page_by_title( $type, OBJECT, 'tee_product' );

	$type_lable = origin_get_post_meta( 'title', $tee_product->ID );

	$size = origin_get_post_meta( 'size', $tee_product->ID );
	$size = json_decode( $size );
	$temp = array();
	// foreach( $size_arr as $value ) {
	// 	$_size = explode( ',', $value );
	// 	$temp[trim($_size[0])] = trim( $_size[1]);
	// }
	// $size = $temp;

	$cb = array();

	foreach ($size as $key => $lable) {
		$cb[ $type . '-' . $key ] = $type_lable . '|||' . $lable;
	}

	$temp = array(
		'cb' => $cb,
		'type-label' => $type_lable,
		'size' => $size
	);

	return $temp;
}