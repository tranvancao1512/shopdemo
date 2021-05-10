<?php
if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

if ( ! is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ) {
	return;
}
?>

<div class="<?php echo esc_attr( $class ); ?>">
	<div class="lunar-wishlist-icon item">
		<a href="<?php echo get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ); ?>"
			 title="<?php _e( 'Wishlist', 'lunar-core' ); ?>">
			<i class="ion-ios-heart"></i>
		</a>
	</div>
</div> <!-- .end $class -->
