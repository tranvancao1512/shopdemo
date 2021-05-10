<?php if (!defined('FW')) die('Forbidden');
/**
 * @var WP_Post $item
 * @var string $title
 * @var array $attributes
 * @var object $args
 * @var int $depth
 */
{	

	$html_images = '';

	$images = get_post_meta( $item->ID , 'mega_menu_item_images', true );

	$images = preg_replace('/\]|\[/', '', $images);

	$images = explode( ',', $images );

	if ( $depth >= 1  ) {

		if ( is_numeric( $images[0] )  && count( $images ) == 1 ) {
			$data_image 	= wp_prepare_attachment_for_js( $images[0] ) ;
			$html_images 	= '<a class="nav-images" href="' . $item->url . '">';
			$html_images   .= wp_get_attachment_image( $images[0], 'full' );
			$html_images   .= '</a>';
		} else if ( is_numeric( $images[0] )  && count( $images ) >= 2 ) {

			$data_slick = array(
				'slidesToScroll'		=> 1,
				'slidesToShow'			=> 1,
				'autoplay' 				=> true,
				'dots'					=> false,
				'arrows'				=> false,
				'loop'					=> true,
			);

			$data_slick = json_encode( $data_slick );

			$html_images = '<div class="basr-slick" data-slick=' . esc_attr( $data_slick ) . ' >';

			foreach ( $images as $key => $image ) {

				$data_image = wp_prepare_attachment_for_js( $image ) ;
				$html_images .= '<div class="item">';
				if ( $data_image['alt'] ) {
					$html_images .= '<a href="' . esc_url( $data_image['alt'] ) . '">';
					$html_images .= wp_get_attachment_image( $image, 'full' );
					$html_images .= '</a>';
				} else {
					$html_images .= wp_get_attachment_image( $image, 'full' );
				}
				$html_images .= '</div>';
			}

			$html_images .= '</div>';
		}
	}

	$icon_html = '';
	if (
		fw()->extensions->get('megamenu')->show_icon()
		&&
		($icon = fw_ext_mega_menu_get_meta($item, 'icon'))
	) {
		$icon_html = '<i class="'. $icon .'"></i>';
		$title = '<span>' . $title . '</span>';
	}

	if ($values = fw_ext_mega_menu_get_db_item_option($item->ID, 'default')) {
//		$values = fw_ext_mega_menu_get_db_item_option($item->ID, $item_type);
//		fw_print($values);
		if( $values['show_label'] === 'no' ) {
			$title = '';
		}
	}

	$only_images = get_post_meta( $item->ID, 'images_only', true );

}
echo $html_images;
if ( ! $only_images ) {
	echo wp_kses_post($args->before);
	echo fw_html_tag('a', $attributes, $args->link_before . '<span class="td-link">' . $icon_html . $title . '</span>' . $args->link_after);
	echo wp_kses_post($args->after);
}