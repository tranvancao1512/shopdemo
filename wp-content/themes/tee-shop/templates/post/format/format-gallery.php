<?php
/**
 * The template for displaying single audio within loops
 *
 * This template can be overridden by childtheme
 *
 * @author Lunartheme
 * @package basrpo/template
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

if( ! defined( 'FW' ) ) return; // Exit if not is_active unyson

$gallery = origin_get_post_meta( 'post_format_gallery', get_the_ID() );

if ( sizeof($gallery['_images']) == 0 ) {

	get_template_part( 'templates/post/format/format', 'image' );

	return; // Exit if empty gallery
}

// Slick data 

$data_slick = array(
		'slidesToScroll'		=> 1,
		'slidesToShow'			=> 1,
		'autoplay' 				=> (bool)$gallery['_autoplay'],
		'dots'					=> (bool)$gallery['_pagination'],
		'fade'					=> (bool)$gallery['_fade'],
		'arrows'				=> (bool)$gallery['_navigation'],
		'loop'					=> (bool)$gallery['_autoplay'],
		'speed'					=> intval( $gallery['_speed'] ),
		'autoplaySpeed'			=> intval( $gallery['_duration'] ),
		'responsive'			=> array(
				array( 
					'breakpoint'	=> 800,
					'settings'		=> array(
						'slidesToShow'		=>	1, 
					)
				),
			)
	);

$data_slick = json_encode( $data_slick );

$image_size = isset( $image_size ) ? $image_size : 'ln-moonlight-blog-large';

if ( is_page_template( 'page-templates/page-blog.php' ) ) {
	$page = get_queried_object();
	$image_size = 'ln-moonlight-blog-' . origin_get_post_meta( 'page_blog_style', $page->ID );
}

?>

<div class="post-format-gallery post-thumb basr-slick" data-slick=<?php echo esc_attr( $data_slick );?> >
	<?php

	if ( has_post_thumbnail() ) {
		get_the_post_thumbnail( get_the_ID(),  apply_filters( 'origin_single_thumb_size', $image_size ) );
	}

	foreach( $gallery['_images'] as $image ) {
		echo wp_get_attachment_image( $image['attachment_id'],  apply_filters( 'origin_single_thumb_size', $image_size ) );
	}
	?>
</div> <!-- End slick -->