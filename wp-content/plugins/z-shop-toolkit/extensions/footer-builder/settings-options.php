<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'default_footer' => array(
		'type' => 'multi-select',
		'label' => __('Default Footer', 'basr-core'),
		'population' => 'posts',
		'source' => 'footer_builder',
		'prepopulate' => 10,
		'limit' => 1,
	),
	apply_filters('footer_builder_settings_options', array())
);
