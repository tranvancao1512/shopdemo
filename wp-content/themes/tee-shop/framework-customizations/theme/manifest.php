<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['id'] = get_option( 'stylesheet' );

$manifest['supported_extensions'] = array(
	'builder'        => array(),
	'sidebars'       => array(),
	'header-builder' => array(),
	'footer-builder' => array(),
	'basr-portfolio' => array(),
	'backups'        => array(),
);
