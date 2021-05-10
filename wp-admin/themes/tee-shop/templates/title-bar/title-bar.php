<?php
/**
 * Titlebar template for display title_bar in page, single and archive
 *
 * @package ln-moonlight
 * @since 1.0
 */

if ( function_exists('is_shop') ) {
	if( is_singular('product') || is_shop() ) return;
}

// Get setting

$settings = origin_get_title_bar_settings();

$classes = 'title-bar';

// Parallax 

$inline_attr = ( $settings['parallax'] == 'yes' ) ? 'data-stellar-background-ratio=2' : '';

$classes 	.= ( $settings['parallax'] == 'yes' ) ? ' parallax' : '';

// Mask & Overlay

$mask_color_html   = ! empty( $settings['parallax'] )    							? true 		: false;

$pattern_html 	   = ! empty( $settings['clipmask-bg']['image']['data']['icon'] ) ? true 		: false;

// break if ! display 

if ( ! $settings['display'] ) return;

?>
<!-- Title bar -->

<div class="<?php echo esc_attr($classes); ?>" <?php echo esc_attr($inline_attr); ?>>
	<?php

	if( $mask_color_html ) {
		echo '<div class="mask color"></div>';
	}
	if( $pattern_html ) {
		echo '<div class="mask pattern"></div>';
	}

	$classes = array('container', 'text-xs-center', 'wrap-inner');
	$classes = implode(' ', $classes);

	?>
	<div class="<?php echo esc_attr($classes); ?>">

		<!-- Main title  -->

		<h1>
			<?php

			if ( is_home() ) :
				bloginfo();

			elseif ( is_singular() ) :
				the_title();

			elseif ( is_404() ) :
				esc_html_e( 'Error 404', 'origin' );

			elseif ( is_tag() ) :
				single_tag_title();

			elseif ( is_category() ) :
				single_cat_title();

			elseif ( is_tax() ) :
				echo preg_replace( '/(designfullprint)|(^.{3}\s)/', '', single_term_title( '', false ) );

			elseif ( is_day() ) :
				printf( get_the_date() );

			elseif ( is_month() ) :
				printf( get_the_date( _x( 'F Y', 'monthly archives date format', 'origin' ) ) );

			elseif ( is_year() ) :
				printf( get_the_date( _x( 'Y', 'yearly archives date format', 'origin' ) ) );

			elseif ( is_search() ) :
				printf( esc_html__( 'Searching for: ', 'origin' ) );
				echo $_GET['s'];
			endif;
			?>

			<span class="border"></span> 
		</h1>

		<!-- Custom content -->

		<?php if( isset( $settings['custom-content'] ) ) : ?>
			<div class="custom-content">
				<?php echo do_shortcode( wp_kses_post( $settings['custom-content'] ) ); ?>
			</div>
		<?php endif; ?>

		<!-- breadcrumb -->

		<?php
			if( origin_get_setting( 'general_breadcrumb' ) === 'yes' ) {
				if( function_exists('fw_ext_breadcrumbs') ) {
					fw_ext_breadcrumbs('/');
				}
			}
		?>
	</div>
</div>
