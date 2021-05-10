<?php if (!defined('FW')) die('Forbidden');

// replace default walker
{
	remove_filter('wp_nav_menu_args', 'origin_filter_ext_mega_menu_wp_nav_menu_args');

	/** @internal */
	function origin_filter_ext_mega_menu_wp_nav_menu_args($args) {
		$args['walker'] = new origin_Mega_Menu_Custom_Walker();
		return $args;
	}
	add_filter('wp_nav_menu_args', 'origin_filter_ext_mega_menu_wp_nav_menu_args');
}


if ( ! function_exists('origin_mega_menu_backend') ) {
	function origin_mega_menu_backend( $item_id, $item, $depth, $args ) {

		$images = get_post_meta( $item_id, 'mega_menu_item_images', true );

		$images = preg_replace('/\]|\[/', '', $images);

		$images = explode( ',', $images );

		$default = array();

		foreach ($images as $key => $value) {
			$default[$key] = array();
			$default[$key]['attachment_id'] = $value;
			$default[$key]['url'] = wp_get_attachment_url( $value, 'full' );
		}

		$option = array(
				'type'  => 'multi-upload',
				'attr'  => array( 'class' => 'upload_mega_menu_item_images', 'data-foo' => 'bar' ),
				'value' => $default,
			    'label' => esc_html__('Uploads', 'origin'),
			    'desc'  => esc_html__('', 'origin'),
			    'help'  => esc_html__('You can put link to Alt text section in Upload popup', 'origin'),
			    'images_only' => true,
			);

		$data  = array(
	        'id_prefix'   => 'mega_menu_item_',
	        'name_prefix' => 'mega_menu_item_',
	        'value'       => $default
	    );

	    ?>
	   	<div class="field-main-mega-menu-images description description-wide">

			<input type="hidden" name="<?php echo 'mega_menu_item_images_' . $item_id; ?>" value="<?php echo esc_attr( get_post_meta( $item_id, 'mega_menu_item_images', true ) ) ?>" data-subject="mega-menu-images-input" /> 

		</div>

		<?php

		if ( $depth == '0' ) {
			echo '<p class="field-main-mega-menu-images description description-wide">';
			echo '<label>';
			echo '<input type="checkbox" name="fullwidth_' . $item_id . '" ' . ( ( get_post_meta( $item_id, 'fullwidth', true ) ) ? 'checked' : '' ) . ' >';
			echo esc_html__( 'Fullwidth Mega menu', 'origin' );
			echo '</label>';
		}

		if ( $depth == '1' ) {
			echo '<p class="field-main-mega-menu-images description description-wide">';
			echo '<label>';
			echo '<input type="checkbox" name="border_' . $item_id . '" ' . ( ( get_post_meta( $item_id, 'border', true ) ) ? 'checked' : '' ) . ' >';
			echo esc_html__( 'Mega menu column border', 'origin' );
			echo '</label>';
		}

		if ( $depth >= 1 ) {
			echo '<div class="field-uploads-mega-menu-images description description-wide">';

			echo fw()->backend->render_option( 'images', $option ,  $data, 'taxonomy' ) ;

			echo '</div>';

			echo '<p class="field-main-mega-menu-images description description-wide">';
			echo '<label>';
			echo '<input type="checkbox" name="images_only_' . $item_id . '" ' . ( ( get_post_meta( $item_id, 'images_only', true ) ) ? 'checked' : '' ) . ' >';
			echo esc_html__( 'Show only images', 'origin' );
			echo '</label>';
		}

		if ( $depth == '2' ) {
			echo '<p class="field-main-mega-menu-images description description-wide">';
			echo '<label>';
			echo '<input type="checkbox" name="border_top_' . $item_id . '" ' . ( ( get_post_meta( $item_id, 'border_top', true ) ) ? 'checked' : '' ) . ' >';
			echo esc_html__( 'Mega menu item border top', 'origin' );
			echo '</label>';
		}

	}

	add_action( 'wp_nav_menu_item_custom_fields', 'origin_mega_menu_backend', 10, 4 );
}

function origin_mega_menu_option() {
	
	$options = array(
	    'mega_menu_item_images' => array( 'type' => 'multi-upload',     'value' => '' )
	);

	fw()->backend->enqueue_options_static( $options );
}

add_action( 'admin_enqueue_scripts', 'origin_mega_menu_option', 999 );

function origin_mega_menu_update_item( $menu_id, $menu_item_db_id, $args ) {

	if ( isset( $_REQUEST[ 'mega_menu_item_images_' . $menu_item_db_id ] ) ) {
		$value = $_REQUEST[ 'mega_menu_item_images_' . $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, 'mega_menu_item_images', $value );
	}

	if ( isset( $_REQUEST['fullwidth_' . $menu_item_db_id ] ) ) {
		$value = $_REQUEST[ 'fullwidth_' . $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, 'fullwidth', $value );
	} else {
		update_post_meta( $menu_item_db_id, 'fullwidth', '' );
	}

	if ( isset( $_REQUEST['border_' . $menu_item_db_id ] ) ) {
		$value = $_REQUEST[ 'border_' . $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, 'border', $value );
	} else {
		update_post_meta( $menu_item_db_id, 'border', '' );
	}
	if ( isset( $_REQUEST['border_top_' . $menu_item_db_id ] ) ) {
		$value = $_REQUEST[ 'border_top_' . $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, 'border_top', $value );
	} else {
		update_post_meta( $menu_item_db_id, 'border_top', '' );
	}
	if ( isset( $_REQUEST['images_only_' . $menu_item_db_id ] ) ) {
		$value = $_REQUEST[ 'images_only_' . $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, 'images_only', $value );
	} else {
		update_post_meta( $menu_item_db_id, 'images_only', '' );
	}
}

add_action( 'wp_update_nav_menu_item', 'origin_mega_menu_update_item', 10, 3 );

function origin_mega_menu_custom_js() {

	global $pagenow;

	if ( $pagenow == 'nav-menus.php' ) {

		$script = 
		'"use strict";' . 
		"(function($){" .
		"jQuery(document).ready(function(){
			console.log('custom-js-images');
			$('.upload_mega_menu_item_images').on('click', function(){
				var uploads 		= $(this).closest('.field-uploads-mega-menu-images'),
					input_upload    = uploads.find('input'),
					main_input      = uploads.prev().find('input');
				$('.media-button-select').on('click',function(){
					main_input.val( input_upload.val() );
				});
			});
			$('.fw-inner-option').bind( 'click', '.clear-uploads-thumb' , function(){
				var uploads 		= $(this).closest('.field-uploads-mega-menu-images'),
					input_upload    = uploads.find('input'),
					main_input      = uploads.prev().find('input');
				main_input.val( input_upload.val() );
			});
		});" .
		"})(jQuery);";

		wp_add_inline_script( 'fw', $script );

	}

}

add_action( 'admin_enqueue_scripts', 'origin_mega_menu_custom_js', 9999 );

// fullwidth menu

function origin_filter_nav_class( $class, $item, $args, $depth   ) {
	if ( $depth == 0 ) {
		if ( get_post_meta( $item->db_id, 'fullwidth', true ) ) {
			$class[] = 'megamenu-fullwidth';
		}
	}
	if ( $depth == 1 ) {
		if ( get_post_meta( $item->db_id, 'border', true ) ) {
			$class[] = 'has-border';
		}
	}
	if ( $depth == 2 ) {
		if ( get_post_meta( $item->db_id, 'border_top', true ) ) {
			$class[] = 'has-border-top';
		}
	}
	return $class;
}

add_filter( 'nav_menu_css_class', 'origin_filter_nav_class', 10, 4 );




