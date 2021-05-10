<?php 

ob_start();

$blog_style['style'] = 'grid';

if ( $query->have_posts() ) {

	ln_moonlight_blogs_loop_start( $blog_style );

	while ( $query->have_posts() ) : $query->the_post();

		basr_core_blogs_post_article();

		echo '<div class="wrap-inner">';

		echo '<div class="post-thumb">';

		echo '<a href=' . get_permalink() . '">';

		the_post_thumbnail( $image_size );

		echo '</a>';

		echo '</div>';

		echo '<div class="wrap-content">';

		ln_moonlight_post_meta_date( 'M d, Y' );

		ln_moonlight_post_meta_title();

		ln_moonlight_post_meta_excerpt();

		ln_moonlight_post_meta_morelink();

		echo '</div>';

		echo '</div>';

		basr_core_blogs_post_article_end();

	endwhile;

	ln_moonlight_blogs_loop_end();

	wp_reset_postdata();

} else {
	echo '<p class="no-post">' . esc_html__('No post found') . '</p>';
}

$output .= ob_get_clean();