<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<?php if ( wp_is_mobile() && false ) : ?>
	<header id="<?php echo esc_attr( $m_id ); ?>" class="<?php echo esc_attr( $m_class ); ?>">
		<?php echo header_builder_render_m_header( $m_inputs ); ?>
	</header>
<?php else: ?>
	<header id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
		<?php echo header_builder_render_header( $inputs ); ?>
	</header>
<?php endif; ?>
