<?php
/**
 * Template part for displaying posts listing
 *
 * @package ln-moonlight
 * @since   1.0.0
 * @version 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( '' !== get_the_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'ln-moonlight-featured-image' ); ?>
			</a>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>

	<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

	<?php
	if ( 'post' === get_post_type() ) :
		echo '<div class="entry-meta">';
		origin_posted_on();
		echo '</div><!-- .entry-meta -->';
	endif;
	?>

	<div class="entry-sumary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-sumary -->

</article><!-- #post-## -->
