<?php
if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$image = '<img src="' . get_template_directory_uri() . '/assets/images/logo.png' . '">';
if ( isset( $options['logo_img']['attachment_id'] ) ) {
	$image = wp_get_attachment_image( $options['logo_img']['attachment_id'] );
	$imgsrc = wp_get_attachment_image_src( $options['logo_img']['attachment_id'] );
	$ratio = $imgsrc[1]/$imgsrc[2];

	$stt_logo = shop_get_stts()['site_logo'];
	$stt_ratio = shop_get_stts()['site_logo_ratio'];

	if( $stt_logo ) {
		$image = '<img src="' . $stt_logo . '">';
	}
	if( $stt_ratio ) $ratio = $stt_ratio;
}

if( isset( $ratio ) && $ratio ) {
	$max_height = false;
	if( $ratio < 1.3 ) {
		$max_width = "max-width: 204px";
	} else {
		$max_width = "display: none";
		$max_height = ".header-builder-type-logo img{max-height:77px}";
		// $max_height .= ".header-builder-type-nav > ul > li:first-child{padding-left: 0}";
	}
	$inline = '.header-builder-type-section:nth-child(3) .header-builder-type-flex-space:first-child { ' . $max_width . ' }';
	$inline .= $max_height;

	echo '<style>' . $inline . '</style>';
} 
?>

<div class="<?php echo esc_attr( $class ); ?>">
	<a class="logo-image" href="<?php echo ( is_front_page() || is_home() ) ? '#' : esc_attr( home_url() ); ?>">
		<?php echo $image; ?>
	</a>
</div>
