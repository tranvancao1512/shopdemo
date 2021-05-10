<?php 

ob_start();

if ( $query->have_posts() ) {

	ln_moonlight_blogs_loop_start( $blog_style );

	while ( $query->have_posts() ) : $query->the_post();

		basr_core_blogs_post_article();

		foreach ($hooks as $key => $fn) {
			if ( $fn == 'basr_core_post_meta_thumbnail' ) {
				call_user_func_array( $fn, array( $image_size ) );
			} else {
				call_user_func( $fn );
			}
		}

		basr_core_blogs_post_article_end();

	endwhile;

	ln_moonlight_blogs_loop_end();

	wp_reset_postdata();

} else {
	echo '<p class="no-post">' . esc_html__('No post found') . '</p>';
}

$output .= ob_get_clean();