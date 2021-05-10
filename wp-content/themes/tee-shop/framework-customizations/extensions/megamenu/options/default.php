<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'show_label' => array(
		'label' => esc_html__('Label', 'origin'),
		'type' => 'switch',
		'right-choice' => array(
			'value' => 'no',
			'label' => esc_html__('Hide', 'origin'),
		),
		'left-choice' => array(
			'value' => 'yes',
			'label' => esc_html__('Show', 'origin'),
		),
		'value' => 'yes',
	)
);