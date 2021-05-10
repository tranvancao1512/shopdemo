<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

function _action_footer_vc_custom_css() {

	$id 	   = footer_builder_get_current_footer();
	
	if ( is_numeric( $id ) ) :

		$vc_custom_css  = '<style>';

		$vc_custom_css .= get_post_meta( $id, '_wpb_shortcodes_custom_css', true );

		$vc_custom_css .= get_post_meta( $id, '_wpb_post_custom_css', true );

		$vc_custom_css .= '</style>';

		echo $vc_custom_css;

	endif;
}

add_action( 'wp_head', '_action_footer_vc_custom_css' );


function footer_builder_toolbar_edit( $wp_admin_bar ) {

	if ( is_admin() ) return;

	$footer_id = footer_builder_get_current_footer();

	if ( ! $footer_id ) return;

	$args = array(
		'id'    => 'edit_footer',
		'title' => esc_html( 'Edit Footer', 'basr-core' ),
		'href'  => get_edit_post_link( $footer_id ),
		'meta'  => array( 'class' => 'basr-edit-footer' )
	);

	$wp_admin_bar->add_node( $args );

}
add_action( 'admin_bar_menu', 'footer_builder_toolbar_edit', 999 );

function footer_builder_get_single_template($single_template) {
     global $post;

     if ( $post->post_type == 'footer_builder' ) {
          $single_template = dirname( __FILE__ ) . '/views/footer_single.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'footer_builder_get_single_template' );


