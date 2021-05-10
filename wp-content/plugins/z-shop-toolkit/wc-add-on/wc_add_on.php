<?php
/*
Description: This is the add-on for setting up woocommerce
Author: SunriseTheme
Author URI: http://SunriseTheme.com
*/

Class Basr_Core_Wc_Add_on {

	private $type;

	public function __construct() {

		$this->type = array(
			'default'  => esc_html__( 'Default', 'moodshop-shortcodes' ),
			'color'    => esc_html__( 'Color', 'moodshop-shortcodes' ),
			'checkbox' => esc_html__( 'Checkbox', 'moodshop-shortcodes' ),
			'image'    => esc_html__( 'Image', 'moodshop-shortcodes' ),
		);

		if ( class_exists('WooCommerce') ) {
			add_action( 'admin_menu'                       , array( $this, 'add_menu') );
			add_action( 'admin_enqueue_scripts'      , array( $this, 'enqueue_script' ), 999999 );
			add_action( 'wp_enqueue_scripts'         , array( $this, 'front_end_enqueue_script' ) );
			add_action( 'wp_ajax_basr_wc_add_on_save', array( $this, 'save' ) );

			// setting for single 
			add_filter( 'woocommerce_product_data_tabs'  , array( $this, 'filter_wc_single_tab' ) );
			add_action( 'woocommerce_product_data_panels', array( $this, 'basr_wc_out_put_tab') );
			add_action( 'save_post'                      , array( $this, 'save_meta_boxes' ) , 10, 2 );

			// add variation
			add_action( 'woocommerce_before_variations_form', array( $this, 'insert_variation' ) );

		} else {
			return;
		}
	}

	public function add_menu() {
		add_submenu_page( 
			'edit.php?post_type=product', 
			__( 'Variant Style', 'moodshop-shortcodes'), 
			__( 'Variant Style', 'moodshop-shortcodes'), 
			'manage_product_terms', 
			'basr_variant_style', 
			array( $this, 'variant_style_page' ) 
		);
	}

	public function variant_style_page() {
		include 'variant_page.php';
	}

	public function enqueue_script() {
		$post_type = get_current_screen()->post_type;
		if ( isset( $_GET['page'] ) &&  $_GET['page'] == 'basr_variant_style' || $post_type == 'product' ) {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'basr_wc_add_on',  BASR_CORE_PLUGIN_URL . 'wc-add-on/js/script.js' , array( 'wp-color-picker' ), false, true );
			wp_enqueue_style( 'basr_wc_add_on',  BASR_CORE_PLUGIN_URL . 'wc-add-on/css/style.css' );
			wp_enqueue_media();
		}
	}

	public function front_end_enqueue_script() {
		
		if ( is_singular('product') ) {
			wp_enqueue_script( 'basr_wc_add_on_frontend',  BASR_CORE_PLUGIN_URL . 'wc-add-on/js/basr-wc-add-on.js', array(), false, true );
		}

		if ( is_cart() ) {
			wp_enqueue_script( 'basr_sticky',  BASR_CORE_PLUGIN_URL . 'wc-add-on/js/sticky-sidebar.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'basr_wc_cart_js',  BASR_CORE_PLUGIN_URL . 'wc-add-on/js/tee-shop-cart.js', array(  'jquery','basr_sticky' ), false, true );
		}
	}

	public function save() {
		$data = $_POST['options'];

		$options = str_replace("\\", "",$data);
		$options = json_decode( $options );

		foreach ( (array) $options as $key => $value) {
			update_option( $key, $value );
		}
		die();
	}

	public function filter_wc_single_tab( $array ) {
		$array['basr_wc_add_on'] =  array(
			'label'    => __( 'Variations Style', 'moodshop-shortcodes' ),
			'target'   => 'basr_variation_style',
			'class'    => array(),
			'priority' => 65,
		);
		return $array;
	}
	public function basr_wc_out_put_tab() {
		include 'single_panel_variant_style.php';
	}

	public function save_meta_boxes( $post_id, $post ) {

		$post_id = $post->ID;
		$product_object = $post_id ? wc_get_product( $post_id ) : new WC_Product;

		if ( get_post_type( $post_id ) != 'product' ) return;
		if ( $product_object->get_type() != 'variable' ) return;

		if( $post_id ) update_post_meta( $post_id, 'cache_variant_style' , '' );

		$available_variations = $product_object->get_variation_attributes();

		$options = array();

		// l( $_POST );
		// l( $available_variations );

		foreach ( $available_variations as $key => $terms ) {
			$key = str_replace( ' ', '-', strtolower( $key ) );
			$options[ $key . '-adtype'] = '';
			foreach ($terms as $term) {
				$color_key = strtolower( $key ) . '-' . bin2hex( strtolower( $term ) ) . '-color';
				$options[ $color_key ] = $_POST[$color_key];
				$img_key   = strtolower( $key ) . '-' . bin2hex( strtolower( $term ) ) . '-image';
				$options[ $img_key ] = $img_key;
			}
		}

		// l( $options );

		foreach ( $options as $key => $value) {
			$options[ $key ] = isset( $_POST[$key] ) ? $_POST[$key] : '';
			delete_post_meta( $post_id, $key );
			update_post_meta( $post_id, $key, $options[$key] );
		}

	}

	protected function get_meta_box_value( $post_id, $id ) {
		return get_post_meta( $post_id, $id, true  );
	}

	public function get_variation_html( $key, $terms, $type = 'checkbox', $global = false, $hide_simple = false, $term_pos ) {
		global $product;

		if( $html ) return $html;
		$html = '';

		if( $type == 'default' ) $type = 'checkbox';

		// $availabe = $product->get_available_variations();

		// $availabe_list = [];

		// $term_class = array();

		// // lf( $terms );
		// // lf( $availabe );
		// foreach( $availabe as $k_av => $_item ) {

		// 	$availabe_key = '';
		// 	$cl = array_values( $_item['attributes'] );

		// 	$i  = array_search( $cl[$term_pos], $terms );
		// 	if( $i >= 0 ) {
		// 		unset( $cl[$term_pos] );
		// 		$term_class[$i] = isset( $term_class[$i] ) && is_array( $term_class[$i] ) ? $term_class[$i] : array();
		// 		foreach( $cl as $k_cl => $v_cl ) {
		// 			$term_class[$i][] = 'o' . $k_cl . '-' . bin2hex( $v_cl );
		// 		}
		// 	}

		// 	foreach( $_item['attributes'] as $k_ia => $v ) {
		// 		$v = str_replace( '"', '--basr--', $v );
		// 		$v = str_replace( "'", "__basr__", $v );
		// 		// lf( $v );
		// 		$availabe_key .= $availabe_key ? '-*t*-' . $v : $v ;
		// 	}
		// 	$availabe_list[] = $availabe_key;
		// }

		$term_default = $product->get_variation_default_attribute( $key );
		
		$hide_simple = $hide_simple ? 'hidden' : '';

		$s_option_name = get_post_meta( get_the_ID() ,'shopify_option_name', true );

		$temp_key = str_replace( 'pa_', '',$key );
		if ( $s_option_name && isset( $s_option_name[$temp_key] ) ) {
			$option_label = $s_option_name[$temp_key];
		} else {
			$option_label = wc_attribute_label( $key );
		}

		if( $option_label == 'option0' ) $option_label = 'Size';

		// lf( sanitize_title( $key ) );

		$html  = '';
		// $html .= '<div class="availabe-variants" data-list=\'' . ( json_encode( $availabe_list ) ) . '\'></div>';
		$html .= '<div class="basr-core-variant ' . $key . ' ' . $hide_simple . ' ' . $type . '" data-key="' . sanitize_title( $key ) . '">';
		$html .= '<label for="' . sanitize_title( $key ) . '"><span>' . $option_label . ':</span> <p></p></label>';
		$html .= '<div class="wrap-inner">';

		switch ( $type ) {
			case 'color':

				foreach ( $terms as $term ) {

					// Get default variant

					$selected     = '';
					if ( $term === $term_default  ) $selected = 'selected';
					if ( $term_default == '' ) {
						$selected = 'selected';
						$term_default = 'basr-core';
					}

					$t_class = implode( ' ', $term_class[$k_term] );
					$d_class = 'o' . $term_pos . '-' . bin2hex( $term );

					// Get setting

					if ( $global ) {
						$color    = '';
						$obj_term =  get_term_by( 'slug', $term, $key );
						if( is_object( $obj_term ) ) {
							$color = get_option(  'term-' . $obj_term->term_id . '-color' );
						} 
					} else {
						$color_key = strtolower( $key ) . '-' . bin2hex( strtolower( $term ) ) . '-color';
						$color = get_post_meta( $product->get_id(), $color_key , true );
					}

					$html .= '<span class="term ' . $t_class . ' ' . $selected . '" data-class="' . $d_class . '" data-value="' . str_replace( '"', '&quot;', $term ) . '" style="background-color: ' . $color .'" ><label>' . $term . '</label></span>';
				}
				break;
			case 'checkbox': 
				foreach ( $terms as $k_term => $term ) {

					$t_class = implode( ' ', $term_class[$k_term] );
					$d_class = 'o' . $term_pos . '-' . bin2hex( $term );

					$selected     = '';
					if ( $term === $term_default  ) $selected = 'selected';
					if ( $term_default == '' ) {
						$selected = 'selected';
						$term_default = 'basr-core';
					}

					$html .= '<span class="term ' . $t_class . ' ' . $selected . '" data-class="' . $d_class . '" data-value="' . str_replace( '"', '&quot;', $term ) . '">' . $term . '</span>';
				}
				break;
			case 'image':

				foreach ( $terms as $term ) {

					// Get default variant

					$selected     = '';
					if ( $term === $term_default  ) $selected = 'selected';
					if ( $term_default == '' ) {
						$selected = 'selected';
						$term_default = 'basr-core';
					}

					// Get setting
					$t_class = implode( ' ', $term_class[$k_term] );
					$d_class = 'o' . $term_pos . '-' . bin2hex( $term );

					if ( $global ) {
						$attachment    = '';
						$obj_term =  get_term_by( 'slug', $term, $key );
						if( is_object( $obj_term ) ) {
							$attachment = get_option(  'term-' . $obj_term->term_id . '-image' );
						} 
					} else {
						$img_key   = strtolower( $key ) . '-' . bin2hex( strtolower( $term ) ) . '-image';
						$attachment = get_post_meta( $product->get_id(), $img_key, true );
					}

					$html .= '<span class="term ' . $t_class . ' ' . $selected . '" data-class="' . $d_class . '" data-value="' . str_replace( '"', '&quot;', $term ) . '"><label>' . $term . '</label><img class="lazy" src="' . wp_get_attachment_image_src( $attachment )[0] . '"></span>';

				}
				break;
			
			default:
				# code...
				break;
		}

		$html .= '</div>'; // .wrap-inner
		$html .= '</div>'; // .basr-core-variant

		return $html;
	}

	public function insert_variation() {
		global $product;
		$attributes = $product->get_variation_attributes();

		// fw_print( $attributes );
		$hide_simple = false;

		if( isset( $attributes['pa_option0'] ) && $attributes['pa_option0'][0] == 'default-title' && count( $attributes ) == 1 ) {
			$hide_simple = true;
		} 
		
		$i = 0;

		// set  available options 

		$availables = $product->get_available_variations();

		$json = [];
		$json['index'] = [];

		do_action('before_wrap_variant_style');

		echo '<div class="wrap-variant-style">';

		do_action( 'basr_wrap_variant_style');

		// $cache = get_post_meta( $product->get_id(), 'cache_variant_style', true );

		if( ! $cache ) {
			ob_start();
			$cache = '';
			foreach ( $attributes as $key => $terms ) :
				
				$json[$key]    = [];
				$json['index'][strtolower($key)] = $i;

				$global = false;

				// get type

				$key_type = str_replace( ' ', '-', strtolower( $key ) ) . '-adtype';

				$type = get_post_meta( $product->get_id(), $key_type, true );

				$single_type = get_post_meta( $product->get_id(), $key_type, true );

				$single_type = $single_type ? $single_type : 'default';

				if ( preg_match( '/pa_/', $key ) && $single_type == 'default' ) {
					$key_type    = str_replace( 'pa_', '', $key_type );
					$single_type = get_option( $key_type ) ? get_option( $key_type ) : 'default' ;
					$global      = true;
				}

				// get html 

				echo $this->get_variation_html( $key, $terms, $single_type, $global, $hide_simple, $i );
				$i++;
				// script for quick view

			endforeach;

			$cache = ob_get_clean();
			// lf( 'new' );
			update_post_meta( $product->id, 'cache_variant_style', $cache );
		}

		echo $cache;

		// lf( $json );
		// foreach( $availables as $k => $available ) {
		// 	lf( $available['attributes'] );
		// 	$i_attr = 0;
		// 	foreach( $available['attributes'] as $k_att => $v_att ) {
		// 		$k_att = preg_replace( '/^attribute_/', '', $k_att );
		// 		$json[$k_att];
		// 		$i_attr++;
		// 	}
		// }

		echo '</div>';

		if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) : 
			?>
			<script type="text/javascript">
				jQuery(document).ready( function(){
					var $ = jQuery,
						$variants  = $('#yith-quick-view-content .basr-core-variant');

					$variants.each(function(){

						var $container 	= $(this),
							$wc_variant = $( '#' + $(this).attr('data-key').toLowerCase() );

						if ( ! $container.hasClass('default') ) {
							$wc_variant.closest('tr').css('display', 'none');
						}

						$container.find('span').on('click', function(){
							if ( $(this).hasClass('selected') ) return;

							$container.find('.selected').removeClass('selected');
							$(this).addClass('selected');
							$wc_variant.val( $(this).text() ).trigger('change');
						});
					});
					
				});
			</script>
			<?php 
		endif;
	}
}

new Basr_Core_Wc_Add_on();

include 'size_guide.php';

// combine product

add_action( 'basr_wrap_variant_style', 'basr_combine_products' );

function basr_combine_products() {
	global $product;
	if( ! is_object( $product ) || ! $product->get_id() ) return;

	$cb = origin_get_post_meta( 'combine_product', $product->get_id() );

	if( ! count( $cb ) ) return;

	$html = '<div class="basr-core-variant combine-product">';
		foreach ($cb as $key => $id) {
			$html .= '<a data-id="' . $id . '" href="' . get_permalink( $id ) . '" class="term">' . 
					'<label>' . get_the_title( $id ) . '</label>' .
					'<img class="lazy" src="' . wp_get_attachment_image_src( get_post_thumbnail_id( $id ) )[0] . '">' . 
				'</a>';
		}
	$html .= '</div>'; //.basr-core-variant

	$html .= 
			'<script>' .
			'</script>';

	echo $html;

}

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'basr_combine_products_images', 10, 2 );

function basr_combine_products_images( $html, $f_id ) {
	global $product;
	if( ! is_object( $product ) || ! $product->get_id() ) return;
	$cb = origin_get_post_meta( 'combine_product', $product->get_id() );
	if( ! count( $cb ) ) {
		remove_filter( 'woocommerce_single_product_image_thumbnail_html', 'basr_combine_products_images', 10 );
		return $html;
	}

	$attachment_ids = $product->get_gallery_image_ids();

	if( count( $attachment_ids ) && $attachment_ids[ count( $attachment_ids ) - 1 ] != $f_id ) {
		return $html;
	}

	foreach( $cb as $key => $id ) {
		$html .= wc_get_gallery_image_html( get_post_thumbnail_id( $id ), true );
	}

	remove_filter( 'woocommerce_single_product_image_thumbnail_html', 'basr_combine_products_images', 10 );

	return $html;
}

add_action( 'wp_enqueue_script', 'basr_data_combine_product' );

function basr_data_combine_product(){
	global $product;
	if( ! is_object( $product ) && ! $product->get_id() ) return;

	$data_combine = [];
	$data_combine[ $product->get_id() ] = get_data_product( $product );

}

function get_data_product( $product ) {
	$data = [];
	$product->get_available_variations();
	$variations_json = wp_json_encode( $available_variations );
	$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

	$data['available_variations'] = $variations_attr;
}

add_action( 'wp_head', 'basr_combine_product_options' );

function basr_combine_product_options() {
	$product = wc_get_product( get_the_ID() );
	if( ! is_object( $product ) ) return;
	$cb = origin_get_post_meta( 'combine_product', $product->get_id() );
	if( ! count( $cb ) ) return;

	$html = '<div class="combine-options">';

	ob_start();

	// if( $product)

	$attributes = $product->get_variation_attributes();

	echo '<div class="wrap" data-id="' . $product->get_id() . '">';

	foreach ( $attributes as $attribute_name => $options ) :
		wc_dropdown_variation_attribute_options(
			array(
				'options'   => $options,
				'attribute' => $attribute_name,
				'product'   => $product,
			)
		);
	endforeach;

	echo '</div>';

	foreach( $cb as $k => $id ) {
		$product = wc_get_product( $id );
		$attributes = $product->get_variation_attributes();

		echo '<div class="wrap" data-id="' . $product->get_id() . '">';

		foreach ( $attributes as $attribute_name => $options ) :
			wc_dropdown_variation_attribute_options(
				array(
					'options'   => $options,
					'attribute' => $attribute_name,
					'product'   => $product,
				)
			);
		endforeach;

		echo '</div>';
	}

	$html .= ob_get_clean();

	$html = preg_replace( '/id=/i', 'data-id=', $html );

	$html .= '</div>'; // .combine-options

	echo $html;
}

