<?php 


class toolkit_basr_shortcode_product_template_variant extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'product_template_variant';

	public $animation = 'true';

	public $container = true;

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
						'name' 				=> esc_html__( 'Product Variant', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> 'Product Template',
						'icon' 				=> $this->icon,
						'as_parent'       	=> array( 
													'only' =>
														$this->prefix . 'product_template_variant_item' . ',' .
														$this->prefix . 'product_template_variant_item_2' . ',' 
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
								'param_name'       => 'product_type',
								'heading'          => esc_html__( 'Product type ( LMS ) for generate sku ', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  '',
							),
							array(
								'param_name'  		=> 'symbol',
								'heading'     		=> esc_html__( 'symbol between product (LMS) & attr key ', 'basr-core' ),
								'type'        		=> 'dropdown',
								'holder'     		=> 'div',
								'value'      		=> array(
									esc_html__( 'Yes'      , 'basr-core' ) 		=> 'yes',
									esc_html__( 'No symbol', 'basr-core' ) 		=> 'no',
								),
							),
							array(
								'param_name'       => 'product_type_name',
								'heading'          => esc_html__( 'Product type name for shopify product type ', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  '',
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
						'product_type'      => '',
						'product_type_name' => '',
						'price'             => '',
						'compare_price'     => '',
						'symbol'            => '',
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

		preg_match_all( '/' . get_shortcode_regex() . '/' , $content, $variant_item );
		if ( count( $variant_item[3] ) && ! preg_match( '/origin_product_template_variant_item_2/', $variant_item[0][0] ) ) : 
			// normal combine.
			$quick_filter_html = '<div class="quick-filter">';
			$filter_key = array();
			$filter_flag = false;

			$options = array();
			foreach ( $variant_item[3] as $key => $variant_sc ) {
				$options[$key] = new stdClass();
				$atts[] = shortcode_parse_atts( $variant_sc );
				$options[$key]->name = $atts[$key]['title'];
				if ( isset( $atts[$key]['variant_attr'] ) ) {
					$v_atts[] = $atts[$key]['variant_attr'];
					$v_atts_k[] = $atts[$key]['variant_attr_key'];
				}
				
				if ( isset( $atts[$key]['variant_quick_filter'] ) && $atts[$key]['variant_quick_filter'] == 'show' ) {
					$filter_key[] = $key;
					$filter_flag = true;
				}
			}

			foreach ($v_atts_k as $key => $value) {
				$v_atts_k[$key] = explode( '|', $value );
				foreach ($v_atts_k[$key] as $k => $v) {
					$v_atts_k[$key][$k] = preg_replace('/(^\s*)|(\s*$)/', '', $v);
				}
			}
			foreach ($v_atts as $key => $value) {
				$v_atts[$key] = explode( '|', $value );
				foreach ($v_atts[$key] as $k => $v) {
					$v_atts[$key][$k] = preg_replace('/(^\s*)|(\s*$)/', '', $v);
				}
				$options[$key]->values = $v_atts[$key];
			}

			if ( $filter_flag ) {
				foreach( $filter_key as $key ) {

					$quick_filter_html .= '<div class="filter-variant-item" data-filter-key="' . $key . '">';
						$quick_filter_html .= '<label style="display:block;color: red;"> Only add checked <span style="color: blue">' . $options[$key]->name . ' </span>to shopify product. Click Variant detail to view detail.</label>';
						foreach( $v_atts[$key] as $k => $v ) {
							$quick_filter_html .= '<p class="filter-item">';
							$quick_filter_html .= '<label>' . $v . '</label>';
							$quick_filter_html .= '<input type="checkbox" checked data-key="' . $v_atts_k[$key][$k] . '">';
							$quick_filter_html .= '</p>';
						}
					$quick_filter_html .= '</div>'; //.filter-variant-item

				}
			}

			$quick_filter_html .= '</div>'; //.quick-filter
			
			$cb = get_combinations( $v_atts );
			$cb_k = get_combinations( $v_atts_k );

			$output .= '<div class="product-options" data-options="' . esc_attr( json_encode($options) ) . '">Options</div>';
			$output .= '<div class="product-price box-element">';
				$output .= '<div class="price"><label>Price</label><input class="price" type="number" value="' . $price . '" step="0.01"></div>';
				$output .= '<div class="compare-price"><label>Compare Price</label><input class="compare-price" type="number" step="0.01" value="' . $compare_price . '"></div>';
			$output .= '</div>'; //.product-price
			$output .= $quick_filter_html;
			$output .= '<h4 class="button btn-primary btn-toggle">Variant Detail</h4>';
			$output .= '<div class="toggle-wrap box-element">';
				$output .= '<div class="wrap-type"><h4>Product Type</h4><input class="product-type" value="' . $product_type_name . '" placeholder="type"></div>' ;
				$output .= '<div class="variant-control"><span class="check-all">Check All</span><span class="uncheck-all">UnCheck All</span></div>';
				foreach ( $cb as $key => $value ) {
					$output .=  '<div class="variant-item"><input type="checkbox" checked>';
					$size = array();
					foreach ((array)$value as $k => $v) {
						$output .= '<span>' . $v . '</span>';
						preg_match_all( '/\S+\s*(\(\s*our\s*size\s*\))/i', $v, $matches );
						$size[] = isset( $matches[0][0] ) ? preg_replace( '/\s*(\(\s*our\s*size\s*\))/i', '', $matches[0][0] ) : '';
					}

					// for quick filter 

					$data_filter = '';
					if ( is_array( $cb_k[$key] ) ) {
						foreach( $cb_k[$key] as $cb_k_k => $cb_k_v ) {
							$data_filter .= ' data-' . $cb_k_k . '="' . $cb_k_v . '" ';
						}
					} else {
						$data_filter .= ' data-0="' . $cb_k[$key] . '" ';
					} 

					$_variant_code = is_array( $cb_k[$key] ) ? implode( '-', $cb_k[$key] ) : $cb_k[$key] ;
					$product_type = preg_replace( '/[^\w]/', '', $product_type );
					$separater = $symbol != 'no' ? '-' : '';
					$sku = $user->get_value('_folder') . '-' . $folder_id . '-' . $product_type . $separater . $_variant_code;
					$sku = strtoupper( $sku );
					$output .= '<div class="price"><label>Price</label><input class="price" type="number" step="0.01"></div>';
					$output .= '<div class="compare-price"><label>Compare Price</label><input class="compare-price" type="number" step="0.01"></div>';
					$output .= '<div class="sku"><label>SKU</label><input class="sku" value="' . $sku . '" ' . $data_filter . '></div>';
					$output .= '</div>'; //.variant-item
				}
		else :
			$options = $cb = $cb_k = array();
			$options[0] = new stdClass();
			$options[0]->name = 'Type';
			$options[0]->values = array();
			$options[1] = new stdClass();
			$options[1]->values = array();


			// fw_print( $variant_item[3] );
			foreach ( $variant_item[3] as $key => $variant_sc ) {
				$atts[] = shortcode_parse_atts( $variant_sc );
				$v_atts = array();
				$v_atts_k = array();
				if ( isset( $atts[$key]['variant_attr'] ) ) {
					$v_atts[] = $atts[$key]['type_title'];
					$v_atts[] = $atts[$key]['variant_attr'];
					$v_atts_k[] = $atts[$key]['type_sku'];
					$v_atts_k[] = $atts[$key]['variant_attr_key'];

					$options[0]->values[] = $atts[$key]['type_title'];
					$options[1]->name = $atts[$key]['title'];
					foreach ( $v_atts_k as $k => $v ) {
						$v_atts_k[$k] = explode( '|', $v );
						foreach ($v_atts_k[$k] as $_k => &$_v) {
							$v_atts_k[$k][$_k] = preg_replace('/(^\s*)|(\s*$)/', '', $_v);
						}
					}
					foreach ( $v_atts as $k => $v) {
						$v_atts[$k] = explode( '|', $v );
						foreach ( $v_atts[$k] as $_k => &$_v ) {
							$v_atts[$k][$_k] = preg_replace('/(^\s*)|(\s*$)/', '', $_v);
							$v_atts[$k][$_k] = preg_replace('/\s\s/', ' ', $_v);
						}
					}
					$options[1]->values = array_merge( $options[1]->values, $v_atts[1] );
					$cb[] = get_combinations( $v_atts );
					$cb_k[] = get_combinations( $v_atts_k );

				}

			}

			$options[1]->values = array_unique( $options[1]->values ); 

			$_temp_arr = array();
			foreach( $options[1]->values as $k => $v ) {
				$_temp_arr[] = $v;
			}

			$options[1]->values = $_temp_arr;

			$output .= '<div class="product-options" data-options="' . esc_attr( json_encode($options) ) . '">Options</div>';
			$output .= '<div class="product-price box-element">';
				$output .= '<div class="price"><label>Price</label><input class="price" type="number" value="' . $price . '" step="0.01"></div>';
				$output .= '<div class="compare-price"><label>Compare Price</label><input class="compare-price" type="number" step="0.01" value="' . $compare_price . '"></div>';
			$output .= '</div>'; //.product-price
			$output .= '<h4 class="button btn-primary btn-toggle">Variant Detail</h4>';
			$output .= '<div class="toggle-wrap box-element">';
				$output .= '<div class="wrap-type"><h4>Product Type</h4><input class="product-type" value="' . $product_type_name . '" placeholder="type"></div>' ;
				$output .= '<div class="variant-control"><span class="check-all">Check All</span><span class="uncheck-all">UnCheck All</span></div>';
				foreach ( $cb as $k_cb => $_cb ) {
					foreach ( $_cb as $key => $value ) {
						$output .=  '<div class="variant-item"><input type="checkbox" checked>';
						$size = array();
						foreach ((array)$value as $k => $v) {
							$output .= '<span>' . $v . '</span>';
							preg_match_all( '/\S+\s*(\(\s*our\s*size\s*\))/i', $v, $matches );
							$size[] = isset( $matches[0][0] ) ? preg_replace( '/\s*(\(\s*our\s*size\s*\))/i', '', $matches[0][0] ) : '';
						}
						$_variant_code = is_array( $cb_k[$k_cb][$key] ) ? implode( '-', $cb_k[$k_cb][$key] ) : $cb_k[$k_cb][$key] ;

						$separater = $symbol != 'no' ? '-' : '';

						$sku = $user->get_value('_folder') . '-' . $folder_id . '-' . ( $product_type ? $product_type . $separater : '' ) . $_variant_code;
						$sku = strtoupper( $sku );
						$output .= '<div class="price"><label>Price</label><input class="price" type="number" step="0.01"></div>';
						$output .= '<div class="compare-price"><label>Compare Price</label><input class="compare-price" type="number" step="0.01"></div>';
						$output .= '<div class="sku"><label>SKU</label><input class="sku" value="' . $sku . '"></div>';
						$output .= '</div>'; //.variant-item
					}
				}

		endif;

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

