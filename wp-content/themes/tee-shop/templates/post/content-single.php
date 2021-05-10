<?php
/**
 * Template part for displaying single post content
 *
 * @package ln-moonlight
 * @since   1.0.0
 * @version 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

	/**
	 * origin_before_single_post_title hook.
	 *
	 * @hooked origin_post_meta_thumbnail - 10
	 */
	do_action( 'origin_before_single_post_title' );


	origin_post_meta_title();

	/**
	 * origin_after_single_post_title hook.
	 *
	 * @hooked origin_after_single_post_title - 10
	 */
	do_action( 'origin_after_single_post_title' )
	?>

	<div class="post-content">
		<?php

		the_content();

		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'origin' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'origin' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		?>

		<?php
			edit_post_link(
				sprintf(
				/* translators: %s: Name of current post */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'origin' ),
					get_the_title()
				),
				'<p class="edit-link">',
				'</p>'
			);
		?>

	</div><!-- .entry-content -->

	<?php 
	/**
	 * origin_after_single_post_content hook.
	 *
	 * @hooked origin_post_meta_tags - 10
	 * @hooked origin_social_sharing_html - 20
	 * @hooked origin_author_box - 20
	 */
	do_action( 'origin_after_single_post_content' );
	?>

</article><!-- #post-## -->
