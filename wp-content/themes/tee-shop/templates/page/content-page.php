<?php
/**
 * Template part for displaying page content
 *
 * @package ln-moonlight
 * @since   1.0.0
 * @version 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( 'post' === get_post_type() ) :
		echo '<div class="entry-meta">';
		origin_posted_on();
		echo '</div><!-- .entry-meta -->';
	endif;
	?>

	<div class="entry-content">
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

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'origin' ),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
		?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
