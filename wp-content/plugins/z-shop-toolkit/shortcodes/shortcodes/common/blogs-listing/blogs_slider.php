<?php 

ob_start();

$data_slick_arr = array(
	'slidesToScroll'		=> 1,
	'slidesToShow'			=> 1,
	'autoplay' 				=> false,
	'dots'					=> false,
	'arrows'				=> false,
	'loop'					=> true,
	'adaptiveHeight'		=> true,
	'swipe'					=> false,
	'swipeToSlide'			=> false,
);

$data_slick = json_encode( $data_slick_arr );

if ( $query->have_posts() ) {

	$blog_ids = array();

	echo '<div class="wrap-right-slider">';

	echo '<div class="basr-slick right-slider" data-slick="' . esc_attr( $data_slick ) . '">';

	while ( $query->have_posts() ) : $query->the_post();

		$blog_ids[] = get_the_ID();

		basr_core_blogs_post_article();

		foreach ($hooks as $key => $fn) {
			if ( is_array( $fn ) && $fn[1] ) {
				call_user_func( $fn[0] );
			} else if ( ! is_array( $fn ) ) {
				call_user_func( $fn );
			}
		}

		basr_core_blogs_post_article_end();

	endwhile;

	echo '</div>'; // .basr-slick

	echo '<div class="wrap-nav">';
	echo '<span class="fake-prev"><i class="ion-chevron-left"></i>' . esc_html__( 'prev', 'basr-core' ) . '</span>';
	echo '<span class="fake-next"><i class="ion-chevron-right"></i>' . esc_html__( 'next', 'basr-core' ) . '</span>';
	echo '</div>';

	echo '</div>'; // .wrap-right-slider

	wp_reset_postdata();

} else {
	echo '<p class="no-post">' . esc_html__('No post found') . '</p>';
}

$articles = ob_get_clean();

$blog_ids = array_reverse( $blog_ids );

$data_slick_arr['initialSlide'] = count( $blog_ids ) - 1;

$data_slick = json_encode( $data_slick_arr );

$output	.= '<div class="basr-slick left-slider" data-slick="' . esc_attr( $data_slick ) . '">';

foreach ( $blog_ids as $key => $id ) {
	$output .= get_the_post_thumbnail( $id, 'ln-moonlight-blog-medium' );
}

$output .= '</div>';


$output .= $articles;