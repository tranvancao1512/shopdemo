<?php
/**
 * The template for displaying related blogs on single post
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

if ( ! defined( 'FW') || ! is_single() ) {
	return;
}

if ( is_singular('product') ) return;

$related  = array( 
		'related_posts'					=> 'yes',
		'single_related_posts_count'	=> 3,
		'single_related_posts_title'    => esc_html__('Related Posts', 'origin'),
	);


// if ( defined( 'FW') )$related = origin_get_setting( $related );

if ( ! $related['related_posts'] )  exit ; // exit if turn off 

// get cat of single post 

$current_post = get_the_ID();
$cats = array();
$current_post_cats = get_the_category($current_post);

foreach ( $current_post_cats as $key => $value ) {
	$cats[] = $value->term_id;
};

$args = array(
	'post_type'			=> 'post',
	'order'    			=> 'DESC',
	'posts_per_page' 	=> $related['single_related_posts_count'],
	'category__in' 		=> $cats,
);

$the_query = new WP_Query( $args ); 

// slick data 

$data_slick = array(
		'slidesToScroll'		=> 1,
		'slidesToShow'			=> 2,
		'autoplay' 				=> true,
		'dots'					=> false,
		'arrows'				=> true,
		'loop'					=> true,
		'responsive'			=> array(
				array( 
					'breakpoint'	=> 800,
					'settings'		=> array(
						'slidesToShow'		=>	1, 
					)
				),
				array( 
					'breakpoint'	=> 768,
					'settings'		=> array(
						'slidesToShow'		=> 2,
					)
				),
				array( 
					'breakpoint'	=> 600,
					'settings'		=> array(
						'slidesToShow'		=> 1,
					)
				),
			)
	);

$data_slick = json_encode( $data_slick );

// Start output 
	
if ( $the_query->have_posts() && $the_query->found_posts > 1 ): ?>
	
	<div class="post-related">

		<h3><?php echo esc_html( $related['single_related_posts_title']); ?></h3>

		<div class="basr-slick" data-slick=<?php echo esc_attr( $data_slick ); ?> >

		<?php 
		while ( $the_query->have_posts() ) : $the_query->the_post();  ?>

			<?php if( $current_post == get_the_ID() ) continue;  ?> 

			<div class="related-post-item">
				<article <?php post_class(); ?> >

					<?php

					/**
					 * origin_before_post_related_title hook.
					 *
					 * @hooked origin_post_meta_thumbnail -10
					 */
					do_action( 'origin_before_post_related_title' );

					origin_post_meta_title();

					/**
					 * origin_before_post_related_title hook.
					 *
					 * @hooked origin_post_meta_author		-10
					 * @hooked origin_post_meta_date		-20
					 * @hooked origin_post_meta_categories	-30
					 */
					do_action( 'origin_after_post_related_title' );

					?>
				</article> <!-- post-class() -->
			</div> <!-- related-post-item -->

		<?php endwhile;
		wp_reset_postdata();
		?>

		</div> <!-- .basr-slick -->

	</div> <!-- basr related post -->
<?php
endif;