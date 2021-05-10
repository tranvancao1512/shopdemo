<?php
defined( 'ABSPATH' ) || exit;

add_action('init', 'shop_wc_block' );

function shop_wc_block() {
	 // automatically load dependencies and version
    // $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');
 
    wp_register_script(
        'block-example',
        plugins_url('/blocks/build/index.js', __FILE__ ),
		['wp-blocks', 'wp-i18n', 'wp-element' ],
        '1.0.0'
    );
 
    register_block_type( 'tee-shop/block-example', array(
        'editor_script' => 'block-example',
    ) );

}

function tee_block_categories( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'tee-shop',
				'title' => __( 'Tee Shop', 'z-shop-toolkit' )
			),
		)
	);
}
add_filter( 'block_categories', 'tee_block_categories', 10, 2 );

add_filter( 'wp_get_attachment_image_attributes', 'tee_shop_lazy_load', 9999, 4 );
function tee_shop_lazy_load( $attr, $attachment, $size ) {
	if( is_admin() ) return $attr;
	if( in_array( $size, ['tee-shop-loop','woocommerce_thumbnail'] ) ) {
		$attr['srcset'] = wp_get_attachment_image_src( $attachment->ID, 'tee-shop-loop-2x' )[0] . ' 2x';
		$attr['src']    = wp_get_attachment_image_src( $attachment->ID, 'tee-shop-loop' )[0];
		unset( $attr['sizes'] );
	} else if ( in_array( $size, [ 'tee-shop-product-single', 'tee-shop-product-single-mb' ] ) ) {
		$attr['srcset'] = wp_get_attachment_image_src( $attachment->ID, 'tee-shop-product-single' )[0] . ' 1024w,' . 
						  wp_get_attachment_image_src( $attachment->ID, 'tee-shop-product-single-mb' )[0] . ' 800w';
		$attr['src'] = wp_get_attachment_image_src( $attachment->ID, 'tee-shop-product-single-mb' )[0];
		unset( $attr['sizes'] );
	}
	$attr['class'] .= " lazy";
	if( isset( $attr['src'] ) ) {
		$attr['data-src'] = $attr['src'];
		unset( $attr['src'] );
	}
	if( isset( $attr['srcset'] ) ) {
		$attr['data-srcset'] = $attr['srcset'];
		unset( $attr['srcset'] );
	}
	return $attr;
}

// add_filter( 'woocommerce_product_get_image', 'tee_shop_filter_block_image', 10, 6 );

function tee_shop_filter_block_image( $output, $obj, $size, $attr, $placeholder, $image ) {
	if( isset( $_GET['post'] ) || ( isset( $_GET['context'] ) &&  $_GET['context'] == 'edit' ) ) return $output; 
	$output = preg_replace_callback( '/(class=")|(\ssrc\=)|(\ssrcset\=)/' , function($matches){
		if( preg_match( '/^\s/', $matches[0] ) ) {
			return 'data-' . trim( $matches[0] );
		} else {
			return $matches[0] . 'lazy ';
		}
	}, $output);
	return $output;
}

add_filter( 'the_content', 'tee_content_images_lazy', 10, 1 );

function tee_content_images_lazy( $content ) {
	$content = preg_replace_callback( '/<img[^>]+>/', function($matches){
		$url = $matches[0];
		$url = preg_replace_callback( '/(class=")|(\ssrc\=)|(\ssrcset\=)/' , function($mt){
			if( preg_match( '/^\s/', $mt[0] ) ) {
				return ' data-' . trim( $mt[0] );
			} else {
				return $mt[0] . 'lazy ';
			}
		}, $url);
		if( ! preg_match( '/class="/', $url ) ) {
			$url = str_replace( '<img', '<img class="lazy" ', $url );
		}
		return $url;
	}, $content);

	return $content;
}