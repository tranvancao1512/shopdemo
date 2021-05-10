<?php 

if ( ! defined( 'FW' ) ) {	die( 'Forbidden' ); }

$options = array(
	'site' => array(
		'title'   => esc_html__( 'Site Setting', 'origin' ),
		'type'    => 'tab',
		'options' => array(
			'h_section' => array(
				'type'  => 'html-full',
				'label' => false,
				'html'  => '<b>header Settings</b>',
			),
			'site_logo' => array(
				'label' => esc_html__( 'Logo', 'origin' ),
				'type'  => 'text',
				'value' => '',
			),
			'site_logo_ratio' => array(
				'label' => esc_html__( 'Logo Ratio', 'origin' ),
				'type'  => 'text',
				'value' => '',
			),
			'f_section' => array(
				'type'  => 'html-full',
				'label' => false,
				'html'  => '<b>Footer Settings</b>',
			),
			'site_address' => array(
				'label' => esc_html__( 'Address', 'origin' ),
				'type'  => 'text',
				'value' => '',
			),
			'site_std' => array(
				'label' => esc_html__( 'Phone Number', 'origin' ),
				'type'  => 'text',
				'value' => '',
			),
			'site_mail' => array(
				'label' => esc_html__( 'Email Contact', 'origin' ),
				'type'  => 'text',
				'value' => '',
			),
		),
	),
);