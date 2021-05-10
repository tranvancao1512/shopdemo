<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package ln-moonlight
 * @since   1.0.0
 * @version 1.0.0
 */

get_header(); ?>

<?php 
if ( class_exists('S_Order') ) : ?>
	<div id="primary" class="full-width content-area">
		<main id="main" class="site-main" role="main">

			<?php
			do_action('S_backup_order_page');
			?>

			</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	get_footer();
return;
endif;

	$stt = array(
		'img'		=> '',
		'title'		=> esc_html( 'Oops! That page can&rsquo;t be found.', 'origin' ),
		'excerpt' 	=> esc_html( 'May be try a search ?', 'origin' ),
	);

	if ( defined('FW') ) {
		$settings = origin_get_setting( $stt );
		$stt = array_merge( $stt, $settings );
	}

	$classes = $stt['img'] ? 'has-img' : 'default';
?>

	<div id="primary" class="full-width content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found <?php echo esc_html( $classes ); ?>" >
				<header class="page-header">
					<div class="error-404-icon">
						<?php 
							if ( $stt['img'] ) {
								echo wp_get_attachment_image( $stt['img']['attachment_id'] );
							}
						?>
					</div><!-- /.error-icon -->
					<h1 class="page-title"><?php echo esc_html( $stt['title'] ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">

					<p> <?php echo esc_html( $stt['excerpt'] ) ?></p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
				<div class="back-to-home">
					<p><?php esc_html_e( 'or', 'origin' ); ?></p>
					<p><?php
						$home_page = esc_html__( 'Back to Homepage', 'origin' );
						printf(
							__( '%s', 'origin' ),
							'<a class="button" href="' . esc_url( get_home_url() ) . '">' . $home_page . '</a>'
						);
						?></p>
				</div><!-- /.back-to-home -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
