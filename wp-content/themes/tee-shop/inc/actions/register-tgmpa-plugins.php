<?php
/**
 * Register required and recommend plugins for install with TGMPA.
 *
 ** @since Ln Moonlight 1.0.0
 */

/**
 * @internal
 */
if ( ! class_exists('origin_welcome') ) {
	function origin_tgmpa_register() { 

		$activate_nonce = wp_create_nonce( 'tgmpa-activate' );

		$install_nonce = wp_create_nonce( 'tgmpa-install' );

		$uninstall_nonce = wp_create_nonce( 'uninstall-nonce' );

		$plugins = array (
				array(
					'name'             => esc_html__( 'Unyson','origin' ),
					'slug'             => 'unyson',
					'required'         => true,
					'file'             => 'unyson.php',
					'activate_nonce'   => $activate_nonce,
					'install_nonce'    => $install_nonce,
					'uninstall_nonce'  => $uninstall_nonce,
					'extensions_nonce' => wp_create_nonce( 'install' ),
					'source'           => '',
					'redirect'         => true,
					'thumb'            => 'unyson.jpg',
					'link'             => '',
				),
				array(
					'name'           => esc_html__( 'Visual composer','origin' ),
					'slug'           => 'js_composer',
					'source'         => get_template_directory() . '/inc/plugins/js_composer.zip',
					'required'       => true,
					'file'	         => 'js_composer.php',
					'activate_nonce' => $activate_nonce,
					'install_nonce'  => $install_nonce,
					'uninstall_nonce'=> $uninstall_nonce,
					'redirect'       => true,
					'thumb'			 => 'vc.jpg',
					'link'			 => '',
				),
				array(
					'name'           => esc_html__( 'Moonlight Toolkit','origin' ),
					'slug'           => 'z-moonlight-toolkit',
					'source'         => get_template_directory() . '/inc/plugins/z-moonlight-toolkit.zip',
					'required'       => true,
					'file'	         => 'init.php',
					'activate_nonce' => $activate_nonce,
					'install_nonce'  => $install_nonce,
					'uninstall_nonce'=> $uninstall_nonce,
					'thumb'			 => 'sc.jpg',
					'link'			 => '',
				),
				array(
					'name'           => esc_html__( 'Revolution Slider','origin' ),
					'slug'           => 'revslider',
					'source'         => get_template_directory() . '/inc/plugins/revslider.zip',
					'required'       => false,
					'file'	         => 'revslider.php',
					'activate_nonce' => $activate_nonce,
					'install_nonce'  => $install_nonce,
					'uninstall_nonce'=> $uninstall_nonce,
					'thumb'			 => 'rev.jpg',
					'link'			 => '',
				),
				array(
					'name'     		 => esc_html__( 'Contact form 7','origin' ),
					'slug'     		 => 'contact-form-7',
					'required' 		 => false,
					'file'	         => 'wp-contact-form-7.php',
					'activate_nonce' => $activate_nonce,
					'install_nonce'  => $install_nonce,
					'uninstall_nonce'=> $uninstall_nonce,
					'source'         => '',
					'thumb'			 => 'contact-7.jpg',
					'link'			 => '',
				),
				array(
					'name'     		 => esc_html__( 'Instagram feed','origin' ),
					'slug'     		 => 'instagram-feed',
					'required' 		 => false,
					'file'	         => 'instagram-feed.php',
					'activate_nonce' => $activate_nonce,
					'install_nonce'  => $install_nonce,
					'uninstall_nonce'=> $uninstall_nonce,
					'source'         => '',
					'thumb'			 => 'instagram-feed.jpg',
					'link'			 => '',
				)
		);
					
		tgmpa( $plugins );
	}

	// add_action( 'tgmpa_register', 'origin_tgmpa_register' );
}
