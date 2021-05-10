<?php
/**
 * Default footer template when our theme is just activated.
 *
 * @package ln-moonlight
 * @since   1.0.0
 * @version 1.0.0
 */
?>

<footer id="colophon" class="site-footer footer-default" role="contentinfo">
	<div class="container">
		<div class="site-info">
			<a href="<?php echo esc_url( home_url() ); ?>">
				<?php printf(
					__( 'Copyrights &copy; %1$s %2$s. All Rights Reserved.', 'origin' ),
					date( "Y" ),
					get_bloginfo( 'name' )
				); ?>
			</a>
		</div><!-- /.site-info -->
	</div><!-- /.container -->
</footer><!-- #colophon -->
