<?php
if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( $menu === 'none' ) {
	return;
}
if ( ! is_nav_menu( $menu ) ) {
	return;
}
?>

<nav class="<?php echo esc_attr( $class ); ?>">
	<?php wp_nav_menu( array(
		'menu'       => $menu,
		'container'  => '',
		'menu_class' => 'basr-core-menu',
		// 'walker'     => new origin_Mega_Menu_Custom_Walker,
	) ); ?>
</nav>
