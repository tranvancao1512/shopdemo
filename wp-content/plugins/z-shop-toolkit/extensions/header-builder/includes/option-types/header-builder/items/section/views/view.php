<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$style = '';
if ( isset( $options['height'] ) && $height = intval( $options['height'] ) ) {
	$style .= 'height: ' . $height . 'px;';
}
if ( $bg_color = $options['bg_color'] ) {
	$style .= 'background-color: ' . $bg_color . ';';
}
if ( $bg_image = $options['bg_image'] ) {
	$style .= 'background-image: ' . $bg_image . ';';
	$style .= 'background-size: ' . $options['bg_size'] . ';';
	$style .= 'background-repeat: ' . $options['bg_repeat'] . ';';
	$style .= 'background-position: ' . $options['bg_position'] . ';';
}
if ( 'no' === $options['stretch'] ) :
	?>
	<div class="<?php echo esc_attr( $class ); ?>">
		<div class="container" style="<?php echo esc_attr( $style ); ?>">
			<div class="row">
				<?php echo header_builder_get_items( $children ); ?>
			</div>
		</div>
	</div>
	<?php else : ?>
	<div class="<?php echo esc_attr( $class ); ?>" style="<?php echo esc_attr( $style ); ?>">
		<div class="container">
			<div class="row">
				<?php echo header_builder_get_items( $children ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
