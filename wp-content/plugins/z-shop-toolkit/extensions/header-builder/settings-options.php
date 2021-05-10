<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'default_header' => array(
		'type'    => 'select',
		'label'   => __( 'Default Header', 'lunar-core' ),
		'desc'    => sprintf( __( 'You can use our <a href="%s" target="_blank">Header Builder</a> to build unlimited headers.', 'lunar-core' ), admin_url( '/edit.php?post_type=header_builder' ) ),
		'choices' => header_builder_prepare_select_box(),
	),
	apply_filters( 'header_builder_settings_options', array() ),
);
