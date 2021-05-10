<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name'] = __( 'Header Builder', 'lunar-core' );
$manifest['version'] = '1.0.0';
$manifest['display'] = false;
$manifest['standalone'] = true;
$manifest['requirements']  = array(
	'extensions' => array(
		'builder' => array(),
	),
);
