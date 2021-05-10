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
} ?>

<div class="audio-wrap post-thumb">
	<div class="audio-insider">
		<?php
		$post_format_audio = origin_get_post_meta( 'post_format_audio', get_the_ID() );
		if( $post_format_audio['_source'] === 'soundcloud' ) :
			if( isset( $post_format_audio['soundcloud']['soundcloud_url'] ) ) :
				global $wp_embed;
				echo ( $wp_embed->run_shortcode( '[embed]' . esc_url( $post_format_audio['soundcloud']['soundcloud_url'] ) . '[/embed]' ) );
			endif;

		elseif( $post_format_audio['_source'] === 'local' ) :
			if( isset( $post_format_audio['local']['audio_local']['url'] ) ) :
				echo do_shortcode( '[audio src="' . esc_url( $post_format_audio['local']['audio_local']['url'] ) . '"/]' );
			endif;
		endif;
		?>
	</div>
</div>