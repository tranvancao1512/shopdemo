<?php
/**
 * The template for displaying single video within loops
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

if( ! defined('FW') ) return;  // Exit if not is_active unyson

$post_format_video = origin_get_post_meta( 'post_format_video', get_the_ID() );

$classes = 'post-thumb post-format-video basr-video';

if ( $post_format_video['link']['video_thumb'] ) $classes .= ' has-thumb';

// fw_print( get_option( 'origin_post_css' ) );

?>

<div class="<?php echo esc_attr( $classes );?>" >
	
	<?php 
	if ( ( isset( $post_format_video['local']['video_local']['url'] ) && $post_format_video['local']['video_local']['url']  ) || 
		  (	isset( $post_format_video['link']['video_url'] ) && $post_format_video['link']['video_url'] ) ||
		  (	isset( $post_format_video['embeded']['video_embed_code'] ) && $post_format_video['embeded']['video_embed_code'] ) ) : ?>

		<div class="video-insider">
			<?php
			if( $post_format_video['_source'] === 'local' ) :
				if( isset( $post_format_video['local']['video_local']['url'] ) ) :
					echo do_shortcode( '[video src="' . esc_url( $post_format_video['local']['video_local']['url'] ) . '"/]' );
				endif;

			elseif( $post_format_video['_source'] === 'link' ) :
				if( isset( $post_format_video['link']['video_url'] ) ) :
					$video_w = 1200;
					$video_h = $video_w / 1.61; //1.61 golden ratio
					$sc = '[embed width="' . $video_w . '" height="' . $video_h . '"]' .  esc_url( $post_format_video['link']['video_url'] ) . '[/embed]';
					echo origin_vc_video( $sc );
				endif;

			elseif($post_format_video['_source'] === 'embeded') :
				if( isset( $post_format_video['embeded']['video_embed_code'] ) ) :
					echo wp_kses_post($post_format_video['embeded']['video_embed_code']);
				endif;

			endif;
			?>
		</div>
	<?php endif;?>

</div>