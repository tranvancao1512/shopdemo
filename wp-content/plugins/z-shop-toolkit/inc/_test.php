<?php

/*
 *  Helper function 
*/

// add_action( 'wp_footer', 'livereload_script' );
function livereload_2323_script() {

	?>
	<script>
		document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] +
			':35729/livereload.js?snipver=1"></' + 'script>')
	</script>
	<?php
}

	// $csv = new Handling_CSV();

	// fw_print( wp_upload_dir() );

	// $file_path = wp_upload_dir()['basedir'] . '/orders_export-12.6-18.6.csv';
	// fw_print( $file_path );
	// $csv->parse_csv( 'order_color_convert', $file_path );

	// fw_print( array_unique( $csv->color ) );
	// fw_print( array_unique( $csv->size ) );

function yy_horror_remove_duplicate_images() {
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => '-1',
	);

	$query = new WP_Query( $args );

	while ( $query->have_posts() ) : $query->the_post();
		if ( in_array( get_the_ID(), array(11672,13233,14781) ) ) return;
		$change_flag = false;
		$remove_list = array( 11659,11660,11661,11662,11663,11664,11665,11666,11667,14768,14769,14770,14771,14772,14773,14774,14775,14776,13220,13221,13222,13223,13224,13225,13226,13227,13228 );
		fw_print( 'Product ID' . get_the_ID() );
		$product = new WC_Product(get_the_ID());
		$imgs    = $product->get_gallery_image_ids();
		foreach ($imgs as $key => $img_id) {
			if ( in_array( $img_id, $remove_list ) ) {
				unset( $imgs[$key] );
				$change_flag = true;
				fw_print('remove' . $img_id );
			}
		}
		if ( $change_flag ) {
			$product->set_gallery_image_ids( $imgs );
			$product->save();
		}
	endwhile;
}

if ( ! function_exists('after_header_test_case') ) {
	function after_header_test_case() {
		// $metadata = get_post_meta( 9104, '_wp_attachment_metadata', true );
		// lf( $metadata );

		// $rs = $wpdb->query("RENAME TABLE wezzyp_test TO wp_test");

		?>

	<?php 

		// get_dominant_color( 9081 );
		// $color = get_post_meta( 9104, 'dominant_color', true );
		// lf( $color );
		// lf( ABSPATH );
		// lf( wp_get_attachment_image_src( 9070, 'tee-qshop-loop-2x' ) );
		// echo '<img srcset="http://localhost/shop/wp-content/uploads/1.jpg 1920w,http://localhost/shop/wp-content/uploads/2.jpg 1200w,http://localhost/shop/wp-content/uploads/3.jpg 2x,http://localhost/shop/wp-content/uploads/4.jpg 400w" sizes="(max-width: 800px) 400px, 720px" width="400" src="http://localhost/shop/wp-content/uploads/1.jpg">';

 	// 	$page = get_page_by_title('View Order');
 	// 	if ( is_object( $page ) && isset( $page->ID ) ) {
 	// 		$view_order_link = get_permalink( $page->ID );
 	// 	}
 	// 	// fw_print( origin_get_setting('user_group') );
		// shopify_test();
		// $apis = origin_get_setting('s_backup_store');
		// $d4f  = new S_Collection( $apis[2]['api-link'] );
		// $d4f->backup_collections();
		global $product;
	}	

	add_action( BASR_CORE . '_after_header', 'after_header_test_case' );
}

function shopify_test() {

}

function test_shopify_api() {
	$url = 'http://dev.teeallover.com/wp-json/shopify_api/v1/orders/';
	$args = array(
		'store' => 'hhs',
		'api_key' => '8e85415bc7992b0b7eb64535574bac5e396cdfb4',
		'status' => 'any',
	);


	// $args = array(
	// 	'args' => $args 
	// );

	// $args = json_encode( $args );

	// fw_print( $args );

	// $curl = 'curl -X GET -H "Content-type: application/json" -d \'' . $args . '\'' . ' \'' . $url . '\'';

	// fw_print( $curl );

	foreach ( $args as $key => $value ) {
		$url .= $key . '=' . $value . '&';
	}

	$url = preg_replace( '/&$/', '', $url );

	fw_print( $url );

	$result = file_get_contents( $url, true );

	fw_print( json_decode( $result ) );
}


function basr_core_output_dynamic_typo_css( $file_name = '' ) {

	$primary_color = '#f6c93b';

	// $handle = fopen( get_template_directory() . '/assets/css/main.css', "r" );
	// $handle = fopen( BASR_CORE_PLUGIN_PATH . '/shortcodes/assets/css/shortcodes.css', "r" );
	$handle = fopen( BASR_CORE_PLUGIN_PATH . '/extensions/basr-portfolio/static/css/portfolio.css', "r" );

	$i = 0;

	$selectors = array();
	$selector_color = $selector_bg = $selector_border = $selector_border_top = $selector_border_bot = $selector_border_left = $selector_border_right = array();
	$color_flag = $bg_flag = $border_flag = $border_top_flag = $border_bot_flag = $border_left_flag = $border_right_flag = false;

	if ($handle) {

		$current = array();

	    while ( ( $line = fgets($handle) ) !== false) {
	    	$i++;

	    	$start_block = true;

	    	if ( ! preg_match('/^(\s*([:a-z@#\.\[}]|-))/', $line ) ) {
	    		continue;
	    	} else {
	    		if ( preg_match( '/^(\s*@)/', $line ) ) {	
	    			if ( preg_match( '/min|max/', $line ) ) {
	    				continue;
	    			} 
	    		} else {

	    			// add selector to current;

	    			if ( preg_match('/{/', $line ) ) {
	    				if ( ! preg_match( '/\:\:/', $line ) ) {
	    					$current[] = str_replace( '{', '', $line );
	    				} 
	    				$process_inner_block = true;
	    			}

	    			if ( preg_match('/,\s*$/', $line ) ) {
	    				if ( ! preg_match( '/\:\:/', $line ) ) {
	    					$current[] = str_replace( ',', '', $line );
	    				}
	    			}

	    			// Search inner block

	    			if ( $process_inner_block = true ) {

	    				// color
	    				if ( preg_match( '/\s+color:\s*' . $primary_color . '/', $line ) ) {
	    					$color_flag = true;
	    				}

	    				// border color 
	    				if ( preg_match( '/\s+border[^:]*:\s[^#;\n]*' . $primary_color .'/', $line ) ) {
	    					if ( preg_match( '/top/', $line ) ) {
	    						$border_top_flag = true;
	    					}
	    					if ( preg_match( '/bot/', $line ) ) {
	    						$border_bot_flag = true;
	    					}
	    					if ( preg_match( '/left/', $line ) ) {
	    						$border_left_flag = true;
	    					} 
	    					if ( preg_match( '/right/', $line ) ) {
	    						$border_right_flag = true;
	    					}
	    					if ( preg_match( '/border(-color)*\s*:/', $line )) {
	    						$border_flag = true;
	    					}
	    				}

	    				// background color

	    				if ( preg_match( '/\s+background[^:]*:[^#]' . $primary_color . '/', $line ) ) {
	    					$bg_flag = true;
	    				}
	    			}

	    			// finish a block

	    			if ( preg_match( '/\}/', $line ) && $process_inner_block )  {

	    				if ( $color_flag ) {
	    					$selector_color[] = $current;
	    				}

	    				if ( $border_top_flag ) {
	    					$selector_border_top[] = $current;
	    				}

	    				if ( $border_bot_flag ) {
	    					$selector_border_bot[] = $current;
	    				}

	    				if ( $border_left_flag ) {
	    					$selector_border_bot[] = $current;
	    				}

	    				if ( $border_right_flag ) {
	    					$selector_border_right[] = $current;
	    				}

	    				if ( $border_flag ) {
	    					$selector_border[] = $current;
	    				}

	    				if ( $bg_flag ) {
	    					$selector_bg[] = $current;
	    				}
	    					
	    				// Reset for new block;

	    				$process_inner_block = false;
	    				$color_flag = $bg_flag = $border_flag = $border_top_flag = $border_bot_flag = $border_left_flag = $border_right_flag = false;
	    				$current = array();
	    			}

	    			// finish media or other 

	    			if ( preg_match( '/}/', $line ) && ! $process_inner_block ) {
	    				continue;
	    			}
	    		}
	    	}
	    }

	    fclose($handle);
	} else {
	    // error opening the file.
	    fw_print( 'error' );
	} 

	$string = "<?php\n";

	$string .= "function basr_core_custom_theme_color( \$color ){\n";
	$string .= "\t\$css = '';\n";
	if ( $selector_color ) {
		$string .= "\t\$css .= '";
		$string .= basr_core_convert_to_css_selector( $selector_color );
		$string .= "{ color: ' . \$color . ';}';\n";
	}

	if ( $selector_border ) {
		$string .= "\t\$css .= '";
		$string .= basr_core_convert_to_css_selector( $selector_border );
		$string .= "{ border-color: ' . \$color . ';}';\n";
	}

	if ( $selector_border_top ) {
		$string .= "\t\$css .= '";
		$string .= basr_core_convert_to_css_selector( $selector_border_top );
		$string .= "{ border-top-color: ' . \$color . ';}';\n";
	}

	if ( $selector_border_bot ) {
		$string .= "\t\$css .= '";
		$string .= basr_core_convert_to_css_selector( $selector_border_bot );
		$string .= "{ border-bottom-color: ' . \$color . ';}';\n";
	}

	if ( $selector_border_left ) {
		$string .= "\t\$css .= '";
		$string .= basr_core_convert_to_css_selector( $selector_border_left );
		$string .= "{ border-left-color: ' . \$color . ';}';\n";
	}

	if ( $selector_border_right ) {
		$string .= "\t\$css .= '";
		$string .= basr_core_convert_to_css_selector( $selector_border_right );
		$string .= "{ border-right-color: ' . \$color . ';}';\n";
	}

	if ( $selector_bg ) {
		$string .= "\t\$css .= '";
		$string .= basr_core_convert_to_css_selector( $selector_bg );
		$string .= "{ background-color: ' . \$color . ';}';\n";
	}

	$string .= "\treturn \$css;\n}";

	$fw = fopen( dirname(__FILE__) . '/' . $file_name, 'w' );

	fwrite( $fw, $string );
	fclose( $fw );
}

function basr_core_convert_to_css_selector( $array ) {
	foreach ( $array as $key => $block ) {
		$array[$key] = implode( ',', $block );
	}

	return preg_replace( '/\n*\r*/', '', implode( ',', $array ) );
}

