<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<footer id="colophon">
	<div class="container">
		<?php 

			$args	=	array(
				'post_type'		=> 'footer_builder',
				'p'				=> $post_id,
				);
			
			$the_query = new WP_Query( $args );

			while ( $the_query->have_posts() ) : $the_query->the_post();

				the_content();

			endwhile;

			wp_reset_postdata();
		?>
	</div>
</footer>
