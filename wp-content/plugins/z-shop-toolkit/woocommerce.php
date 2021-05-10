<?php 

// move variant price to top 
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
add_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation', 1 );

// add_action( 'woocommerce_single_product_summary', 'wc_product_save_price', 11 );
// add_action( 'woocommerce_after_shop_loop_item_title', 'wc_product_save_price', 15 );

function wc_product_save_price() {
	if( origin_get_setting( 'woo_single_save_count' ) != 'yes') return;
	global $product;
	if( ! is_object( $product ) ) return 'tee-product-thumb-size';
	if ( $product->is_on_sale() ){
		if ( $product->is_type( 'variable' ) ) {
			$regular_price = $product->get_variation_regular_price( 'max' );
			$sale_price    = $product->get_variation_sale_price('max');
		} else {
			$regular_price = $product->get_regular_price();
			$sale_price    = $product->get_sale_price();
		}
		$discount = ($regular_price - $sale_price);
		
        echo '<span class="sale-tag">Save $' . $discount . '</span>';
	}
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// breadcrum 

add_filter( 'woocommerce_breadcrumb_defaults', 'tee_shop_breadcrum', 10, 2 );
function tee_shop_breadcrum( $args ) {
	return array(
		'delimiter'   => '/',
		'wrap_before' => '<nav class="woocommerce-breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '<span>',
		'after'       => '</span>',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	);
}

// input-quantity

// add video 

// add_action('woocommerce_product_thumbnails', 'tee_shop_product_video', 15 );

function tee_shop_product_video() {
	// fw_print(  );
	$videos = origin_get_post_meta('video', get_the_ID() );
	$html = '';
	foreach( $videos as $key => $video ) {
		if ( strpos( home_url(), $video['link'] ) ) {
			$shortcode = '[embed]' . $video['link'] . '[/embed]';
		} else {
			$shortcode = '[vc_video link="' . $video['link'] . '"]';
		}
		$image = '<img src="' . $video['thumb']['url'] . '">' . do_shortcode( $shortcode );
		$alt_text = 'alt text';
		$full_src = $video['thumb']['url'];
		$html .= '<div data-thumb="' . esc_url( $video['thumb']['url'] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="woocommerce-product-gallery__image video"><a href="' . esc_url( $full_src ) . '" data-large_image="' . $full_src . '" data-src="' . $full_src . '"></a>' . $image . '</div>';
	}
	
	return $html;
}


// filter size

add_filter( 'woocommerce_gallery_image_size', 'tee_single_product_size' );
function tee_single_product_size(){
	return 'tee-shop-product-single';
}

add_filter( 'single_product_archive_thumbnail_size', 'tee_shop_loop_img_size' );
function tee_shop_loop_img_size( $size ) {
	return 'tee-shop-loop';
}

add_filter( 'woocommerce_gallery_image_size', 'tee_shop_main_img_size', 10, 1 );

function tee_shop_main_img_size( $size ) {
	global $product;
	if( ! is_object( $product ) ) return 'tee-product-thumb-size';
	$id = ( $product->get_image_id() );
	if ( $id ) {
		$src = wp_get_attachment_image_src( $id, 'large' );
		if ( preg_match( '/\.gif$/', $src[0] ) ) {
			return 'large';
		}
	}
	return $size;
}
add_filter( 'woocommerce_gallery_image_size', 'tee_shop_gallery_size');
function tee_shop_gallery_size(){
	return 'tee-shop-product-single';
}
add_filter( 'woocommerce_gallery_thumbnail_size', 'tee_shop_product_gallery_thumb_size');
function tee_shop_product_gallery_thumb_size( $size ){
	global $product;
	if( ! is_object( $product ) ) return 'tee-product-thumb-size';
	$imgs = $product->get_gallery_image_ids();
	// lf( $size );
	if( count( $imgs ) == 1 )  {
		$src = wp_get_attachment_image_src( $imgs[0], 'large' );
		if ( $src[1]/$src[2] > 1.7 ) {
			return 'large';
		}
	}

	return 'tee-product-thumb-size';
}

// try reupdate data large image with height

add_filter( 'woocommerce_gallery_image_html_attachment_image_params', 'tee_shop_product_gallery_thumb_args', 9999, 4 );

function tee_shop_product_gallery_thumb_args( $args, $attachment_id, $image_size, $main_image ){
	
	if( ! $args['data-large_image_width'] || ! $args['data-large_image_height'] ) {
		$path = get_attached_file( $attachment_id );

		$metadata = get_post_meta( $attachment_id, '_wp_attachment_metadata', true );

		if( file_exists( $path ) ) {
			$editor = wp_get_image_editor( $path );
			$size = $editor->get_size();
			if( $size && $size['width'] ) {
				$args['data-large_image_width']  = $size['width'];
				$args['data-large_image_height'] = $size['height'];

				if( ! $metadata ) $metadata = [];
				$metadata['width'] = $size['width'];
				$metadata['height'] = $size['width'];
				update_post_meta( $attachment_id, '_wp_attachment_metadata', $metadata );
			}
		}
	}
	return $args;
}

// wrap shop loop thumb

add_action( 'woocommerce_before_shop_loop_item_title', 'tee_shop_div', 8 );
add_action( 'woocommerce_before_shop_loop_item_title', 'tee_shop_end_div', 12 );
function tee_shop_div() {
	echo '<div class="wrap">';
	echo '<p><span></span></p>';
}

function tee_shop_end_div() {
	echo '</div>';
}

// 

add_action( 'wp_head', 'tee_shop_more_product_desc' );

function tee_shop_more_product_desc() {
	if( is_cart() ) {
		add_filter( 'woocommerce_cart_item_quantity', 'tee_cart_shop_quantity_button', 10, 1 );
	}
	if ( ! is_singular('product') ) return;
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'woocommerce_single_product_summary', 'tee_before_woocommerce_product_description_tab', 59 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_product_description_tab', 60 );
	add_action( 'woocommerce_single_product_summary', 'tee_after_woocommerce_product_description_tab', 60 );
	add_action( 'woocommerce_single_product_summary', 'tee_img_below_des', 60 );
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

	// input quantity 

	add_action( 'woocommerce_after_quantity_input_field', 'tee_shop_quantity_button' );
}
function tee_shop_quantity_button(){
	echo '<span class="q-minus">-</span>';
	echo '<span class="q-add">+</span>';
}

function tee_cart_shop_quantity_button( $html ) {
	$html = preg_replace( '/^\s*<div class="quantity">/', '<div class="quantity"><span class="q-minus">-</span><span class="q-add">+</span>', $html );
	return $html;
}

function tee_img_below_des() {
	$images = origin_get_setting( 'wc_desc_below_content' );
	if( ! count( $images ) ) return;
	echo '<div class="top-reason"><p> 3 Great reasons to buy from us:</p></div>';
	if ( isset( $images[0] ) ) echo wp_get_attachment_image( $images[0]['attachment_id'], 'full' );
	echo '<div class="top-reason-2">'; 
	if ( isset( $images[1] ) ) echo wp_get_attachment_image( $images[1]['attachment_id'], 'full' );
	if ( isset( $images[2] ) ) echo wp_get_attachment_image( $images[2]['attachment_id'], 'full' );
	if ( isset( $images[3] ) ) echo wp_get_attachment_image( $images[3]['attachment_id'], 'full' );
	echo '</div>';
}

function tee_before_woocommerce_product_description_tab() {
		// separate content for ipad
	echo '</div><div class="p-content">'; 
}
function tee_after_woocommerce_product_description_tab() {
	// separate content for ipad
	echo '</div>'; //.end content tab
}

add_filter ('woocommerce_add_to_cart_redirect', 'redirect_to_checkout' );

function redirect_to_checkout() {
    return wc_get_checkout_url();
}

// hide payment on product 

add_filter( 'wc_stripe_hide_payment_request_on_product_page', 'tee_shop_hide_stripe_on_product' );
function tee_shop_hide_stripe_on_product() {
	return true;
}

// filter related product 

add_filter( 'woocommerce_related_products_args', 'rare_related_products_by_custom_taxonomy');
function rare_related_products_by_custom_taxonomy( $args ) {

	global $post;

	$tags = wp_get_post_terms( $post->ID, "collection" );
	foreach ( $tags as $tag ) {
		$tags_array[] .= $tag->term_id;
	}

	unset( $args['post__in'] );
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'collection',
			'field'    => 'id',
			'terms'    => $tags_array,
		),
	);
	return $args;
}

// image
add_action( 'woocommerce_before_single_product_summary', 'tee_shop_wrap_product_gallery', 19 );
add_action( 'woocommerce_before_single_product_summary', 'echo_tee_shop_gallery_nav', 21 );

function tee_shop_wrap_product_gallery() {
	echo '<div class="tee-gallery"><span class="open-swipe"><svg viewBox="0 0 22 24" width="25" height="25"><g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2"><circle class="l" cx="9" cy="10" r="7" stroke-linecap="square"></circle><path class="l" stroke-linecap="square" d="M14 15l6 6"></path><path d="M9 6v8m4-4H5"></path></g></svg></span>';
}

function echo_tee_shop_gallery_nav() {
	global $product;
	$attachment_ids = $product->get_gallery_image_ids();
	$cb = origin_get_post_meta( 'combine_product', $product->get_id() );

	if( count( $cb ) ) {
		foreach( $cb as $k => $v ) {
			$attachment_ids[] = get_post_thumbnail_id( $v );
		}
	}

	if( $product->get_image_id() && count( $attachment_ids ) ) {
		$nav  = '<ol class="wrap-flex-nav flex-control-nav flex-control-thumbs">';
			$nav .= '<li><img class="flex-active" src="' . wp_get_attachment_image_src( $product->get_image_id(), 'tee-product-thumb' )[0] . '"></li>';
		foreach ( $attachment_ids as $attachment_id ) {
			$nav .=  '<li><img src="' . wp_get_attachment_image_src( $attachment_id , 'tee-product-thumb' )[0] . '"></li>';
		}
		$nav .= '</ol>';
	}
	echo  $nav . '</div>';
}

// pre size for gallery image;

add_action( 'wp_head', 'tee_shop_product_gallery_pre_size' );

function tee_shop_product_gallery_pre_size( $id = false, $update = false ) {
	if( ! is_singular( 'product') ) return;
	$id = get_the_ID();
	if( isset( $_GET['reset'] ) && $_GET['reset'] ) {

	} else {
		$custom_css = get_post_meta( $id, 'tee_shop_pre_css', true );
		if( $custom_css ) {
			if( $custom_css != 'true' ) echo '<style>' . $custom_css . '</style>';
			return;
		}
	}
	
	// feature image
	$custom_css = '';
	$feature_img = wp_get_attachment_image_src( get_post_thumbnail_id() );

	$max_ratio = 0;

	if( $feature_img ) {
		$tmp = $feature_img[2]/$feature_img[1];
		$max_ratio = $tmp > $max_ratio ? $tmp : $max_ratio ;
		// $custom_css .= ".woocommerce-product-gallery__wrapper > div:nth-child(1):before{padding-top:" . number_format( $feature_img[2]/$feature_img[1] * 100, 2 ) . "%}";
	}
	$product = new WC_Product( $id );
	$attachment_ids = $product->get_gallery_image_ids();

	if( count( $attachment_ids ) ) {
		$i = 2;
		foreach( $attachment_ids as $key => $id ) {
			$src = wp_get_attachment_image_src( $id, 'tee-shop-product-single' );
			$tmp = $src[2]/$src[1];
			$max_ratio = $tmp > $max_ratio ? $tmp : $max_ratio ;
			// $custom_css .= ".woocommerce-product-gallery__wrapper > div:nth-child($i):before{padding-top:" . number_format( $src[2]/$src[1] * 100, 2 ) . "%}";
			// $custom_css .= ".woocommerce-product-gallery__wrapper[data-i='" . ( i - 1 ) . "'] > div:first-child:before{padding-top:" . number_format( $src[2]/$src[1] * 100, 2 ) . "%}";
			$i++;
		}
	}


	if( $max_ratio ) {
		$custom_css = '.woocommerce-product-gallery__wrapper > div:before,div .flex-control-nav li::before{padding-top:' . number_format( $max_ratio * 100, 2 ) . '%}';
	}

	if( $custom_css ) {
		echo '<style>' . $custom_css . '</style>';
	} else {
		$custom_css = 'true';
	}
	update_post_meta( get_the_ID(), 'tee_shop_pre_css', $custom_css );
}

add_action( 'save_post', 'tee_shop_update_product_gallery_pre_size', 10, 1 );

function tee_shop_update_product_gallery_pre_size( $post_id ) {
	if( ! $post_id ) return;
	if( get_post_type( $post_id ) != 'product' ) return;

	// feature image
	$custom_css = '';
	$max_ratio = 0;
	$feature_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) );
	if( $feature_img ) {
		$tmp = $feature_img[2]/$feature_img[1];
		$max_ratio = $tmp > $max_ratio ? $tmp : $max_ratio ;
		// $custom_css .= ".woocommerce-product-gallery__wrapper > div:nth-child(1):before{padding-top:" . number_format( $feature_img[2]/$feature_img[1] * 100, 2 ) . "%}";
		// $custom_css .= ".woocommerce-product-gallery__wrapper[data-i='0'] > div:first-child:before{padding-top:" . number_format( $feature_img[2]/$feature_img[1] * 100, 2 ) . "%}";
	}
	$product = new WC_Product( $post_id );
	$attachment_ids = $product->get_gallery_image_ids();
	if( count( $attachment_ids ) ) {
		$i = 2;
		foreach( $attachment_ids as $key => $id ) {
			$src = wp_get_attachment_image_src( $id, 'tee-shop-product-single' );
			$tmp = $src[2]/$src[1];
			$max_ratio = $tmp > $max_ratio ? $tmp : $max_ratio ;
			// $custom_css .= ".woocommerce-product-gallery__wrapper > div:nth-child($i):before{padding-top:" . number_format( $src[2]/$src[1] * 100, 2 ) . "%}";
			// $custom_css .= ".woocommerce-product-gallery__wrapper[data-i='" . ( i - 1 ) . "'] > div:first-child:before{padding-top:" . number_format( $src[2]/$src[1] * 100, 2 ) . "%}";
			$i++;
		}

		// $custom_css .= '.woocommerce-product-gallery__wrapper[data-i="1"] > div:not(.flex-active-slide):before{padding-top: 0}';
	}

	if( $max_ratio ) {
		$custom_css = '.woocommerce-product-gallery__wrapper > div:before,div .flex-control-nav li::before{padding-top:' . number_format( $max_ratio * 100, 2 ) . '%}';
	}

	$custom_css = $custom_css ? $custom_css : 'true';
	
	$rs = update_post_meta( $post_id, 'tee_shop_pre_css', $custom_css );
}
// filter single product params 

add_action('wp_enqueue_scripts', 'tee_custom_single_product_params', 9999 );

function tee_custom_single_product_params(){
	$script = 
		'if(wc_single_product_params){' .
			'var $ = jQuery, $wrap;' .
			'wc_single_product_params.flexslider.smoothHeight = false;' .
			'wc_single_product_params.flexslider.animation = "fade";' .
			'wc_single_product_params.flexslider.before = function(slider){' .
				// 'console.log(slider);' .
				// 'console.log($(".woocommerce-product-gallery__wrapper"));' .
				'$(".woocommerce-product-gallery__wrapper").attr( "data-i", slider.animatingTo == 0 ? 0 : 1 );' .
				'$(".wrap-flex-nav").find(".flex-active").removeClass("flex-active");' .
				'$(".wrap-flex-nav").find("li:nth-child(" + ( slider.animatingTo + 1 ) + ") img").addClass("flex-active");' .
			'};' . 
		'}';
	wp_add_inline_script( 'wc-single-product', $script, 'before' );
}

// force display attr for product cart 

add_filter( 'woocommerce_is_attribute_in_product_name', 'tee_shop_force_display_cart_attr' );

function tee_shop_force_display_cart_attr( ) {
	if( is_cart() ) return false;
}

include 'tools_blocks.php';

add_filter( 'woocommerce_ajax_variation_threshold', 'tee_shop_wc_inc_ajax_threshold' );
function tee_shop_wc_inc_ajax_threshold() {
    return 1000;
}