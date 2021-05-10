<?php 
 /**
  * Function helper for unyson extensions
  *
  */

add_action( 'admin_menu', 'basr_core_plugin_menu' );

/** Step 1. */
function basr_core_plugin_menu() {
	if ( ! current_user_can( 'manage_options' ) ) return;
	$theme = strtoupper( BASR_CORE );
	$theme = str_replace( 'LN_' , '', $theme );
	add_menu_page( 'ML Welcome', $theme , 'manage_options', 'basr-core-menu', 'basr_core_plugin_page' , BASR_CORE_PLUGIN_WELCOME_URL . '/assets/images/moonlight-favicon.png', 3 );
}

/** Step 3. */
function basr_core_plugin_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
}