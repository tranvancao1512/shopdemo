<?php 

// filter

// body class 

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @param array $classes A list of existing body class values.
 *
 * @return array The filtered body class list.
 * @internal
 */
function origin_filter_body_classes( $classes ) {

	global $post;

	// Page

	if ( is_page() && has_shortcode( $post->post_content, 'toolkit_empty_space' ) ) {
		$classes[] = 'has-empty-space';
	}

	$detector = Agent::get_instance();
	if( $detector->isPhone() === true ) $classes[] = 'isPhone';

	// Fullwidth || Boxed

	if( origin_get_setting('layout_type') == 'full' ) {
		$classes[] = 'full-width';
	} else if ( origin_get_setting('layout_type') == 'box' ) {
		$classes[] = 'boxed';
	}

	// sidebar layout 

	if ( function_exists( 'is_cart' ) ) {
		if ( is_cart() || is_checkout() ) {
			$classes[] = 'no-sidebar';
			return $classes;
		}

	}
	
	if ( function_exists('fw_ext_sidebars_get_current_position') ) {

		$current_position 	= fw_ext_sidebars_get_current_position();

		$two_sidebar 		= array( 'left-left-sidebar', 'left-right-sidebar', 'right-right-sidebar' );

		if ( $current_position ) { 					// If has specific config 

			$classes[] = $current_position;

			if ( $current_position != 'no-sidebar' )
				$classes[] = ( in_array( $current_position, $two_sidebar ) ) ? 'has-two-sidebar' : 'has-sidebar';

		} else if ( is_page() ) {
			$classes[] = 'no-sidebar';
		} else if ( get_post_type() == 'basr-portfolio' ) {
			$classes[] = 'no-sidebar';
			$classes[] = 'basr-portfolio';
		} else {									// Get default from Theme Option
			$layout    = origin_get_setting( 'layout_main' );
			$classes[] = 'theme-option-layout';
			$classes[] = $layout;

			if ( $layout != 'no-sidebar')
				$classes[] = ( in_array( $layout, $two_sidebar ) ) ? 'has-two-sidebar' : 'has-sidebar'; 
		}

	} else if( ! defined('FW') ) {
		$classes[] = 'has-sidebar';
		$classes[] = 'right-sidebar';


		if ( is_404() ) $classes[] = 'no-sidebar';
	}

	if ( is_page() ) :
		$page = get_post( get_the_ID() );
		if ( has_shortcode( $page->post_content ,'origin_empty_space' ) ) $classes[] = 'has-empty-space'; 
	endif;

	return $classes;
}

add_filter( 'body_class', 'origin_filter_body_classes' );

// single thumbnail size 

add_filter( 'origin_single_thumb_size', 'origin_filter_single_thumb_size' , 10 , 1 );

// Readmore text filter 

add_filter( 'the_content_more_link', 'origin_readmore_text', 10, 2 );

if ( !function_exists( 'origin_readmore_text' ) ) {
	function origin_readmore_text( $more_link, $more_link_text ) {
		return '<a class="more-link button" href="' . get_permalink() . '">'. esc_html__( 'Read more', 'origin' ) . '</a>';
	}
}

// Change default video embed 

add_filter( 'embed_defaults', 'origin_bigger_embed_size' );

if ( !function_exists( 'origin_bigger_embed_size' ) ) {
	function origin_bigger_embed_size() {
		return array( 'width' => 900, 'height' => 490 );
	}
}

// Move comment textare to bottom

add_filter( 'comment_form_fields', 'origin_wpb_move_comment_field_to_bottom' );

if ( ! function_exists('origin_wpb_move_comment_field_to_bottom') ) {
	
	function origin_wpb_move_comment_field_to_bottom( $fields ) {

		$comment_field = $fields['comment'];

		unset( $fields['comment'] );

		$fields['comment'] = $comment_field;

		return $fields;

	}
}

// Disable wp image filter 

function tee_shop_disable_images_sizes($sizes) {
	$list = [
		'shop_catalog',
		'shop_single',
		'shop_thumbnail',
		'woocommerce_thumbnail',
		'2048x2048',
		'1536x1536',
		'large',
		'medium_large',
		'medium',
	];
	foreach( $list as $key => $size ) {
		if( isset( $sizes[$size] ) ) unset( $sizes[$size] );
	}
	return $sizes;
}

add_filter( 'intermediate_image_sizes_advanced', 'tee_shop_disable_images_sizes' );

// force regen
add_filter( 'wp_get_attachment_image_src', 'tee_shop_force_regen', 9999, 4 );

function tee_shop_force_regen( $image, $attachment_id, $size, $icon ) {
	// if( $attachment_id != 9070 ) return $image;
	if( $image[3] === false ) {
		switch ( $size ) {
			case 'tee-product-thumb-size':
				if( $image['1'] < 100 ) return $image;
				break;
			case 'tee-shop-loop-2x':
				if( $image['1'] < 555 ) return $image;
				break;
			case 'tee-shop-loop':
				if( $image['1'] < 262 ) return $image;
				break;
			case 'tee-shop-product-single':
				if( $image['1'] < 545 ) return $image;
				break;
			case 'tee-shop-product-single-mb':
				if( $image['1'] < 383 ) return $image;
				break;
			default:
				return $image;
				break;
		}
		$list_sizes = [
			'tee-product-thumb-size' => [
				'width'  => 150,
				'height' => 150,
				'crop'   => true, 
			],
			'tee-shop-loop-2x' => [
				'width'  => 540,
				'height' => 999,
				'crop'   => false,
			],
			'tee-shop-loop' => [
				'width'  => 270,
				'height' => 999,
				'crop'   => false,
			],
			'tee-shop-product-single' => [
				'width'  => 570,
				'height' => 999,
				'crop'   => false,
			],
			'tee-shop-product-single-mb' => [
				'width'  => 383,
				'height' => 999,
				'crop'   => false,
			]
		];

		// _wp_make_subsizes( $new_sizes, $file, $image_meta, $attachment_id )
		$file = get_attached_file( $attachment_id );
		if( file_exists( $file ) ) {
			if( ! function_exists( '_wp_make_subsizes' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';
			$image_meta = wp_get_attachment_metadata( $attachment_id );
			l('make subsize');
			$rs = _wp_make_subsizes( $list_sizes, $file, $image_meta, $attachment_id );
		} else {
			// l('file not exist');
		}
	}

	$data64 = get_post_meta( $attachment_id, 'data64', true );
	if( ! $data64 || $data64 === 'false' ) {
		$data64 = tee_render_place_holder( $attachment_id );
	}

	return $image;
}

function tee_render_place_holder( $id ) {
	$size = [
		27,
		999
	];
	$path = get_attached_file( $id );
	if( ! file_exists( $path ) ) {
		update_post_meta( $id, 'data64', 'false' );
		return;	
	} 
	$mime = mime_content_type( $path );
	$editor = wp_get_image_editor( $path );
	if( is_wp_error( $editor ) ) {
		return false;
	}
	$editor->set_quality( 20 );
	$editor->resize( $size[0], $size[1], false );
	$new_path = $editor->generate_filename();
	$editor->save( $new_path );
	$data = 'data:' . $mime . ';charset=utf-8;base64,' .  base64_encode( file_get_contents( $new_path ) );
	$size = $editor->get_size();
	if( $data ) {
		$rs = update_post_meta( $id, 'data64', $data );
		update_post_meta( $id, 'ratio', number_format( $size['height']/$size['width'], 2 ) * 100 );
	}
	return $data;
}

// find dominant color 

add_action( 'add_attachment', 'add_attachment_place_holder_data', 10, 1 );

function add_attachment_place_holder_data( $id ) {
	$data64 = tee_render_place_holder( $id );
}

add_filter( 'woocommerce_product_get_image', 'tee_shop_blur_wc', 10, 2 );
function tee_shop_blur_wc(  $image, $object ) {
	if( is_admin() ) return $image;
	$id = $object->get_image_id();
	if( $id ) {
		$data64 = get_post_meta( $id, 'data64', true );
		if( $data64 ) {
			$ratio = get_post_meta( $id, 'ratio', true ) > 100 ? "height: 100%" : "width: 100%";
			$image .= '<img class="blur" style="' . $ratio . '" src="' . $data64 . '"/>';
		}
	}
	return $image;
}

// add_filter( 'woocommerce_single_product_image_thumbnail_html', 'tee_shop_single_blur_wc', 10, 2 );
function tee_shop_single_blur_wc(  $image ) {
	global $product;
	if( ! is_object( $product ) ) return;
	$id = $product->get_image_id();
	if( $id ) {
		$data64 = get_post_meta( $id, 'data64', true );
		if( $data64 ) {
			$ratio = get_post_meta( $id, 'ratio', true ) > 100 ? "height: 100%" : "width: 100%";
			$image = preg_replace( '/(<img[^>]*>)/', '$1' .  '<img class="blur" style="' . $ratio . '" src="' . $data64 . '"/>', $image );
		}
	}
	return $image;
} 
