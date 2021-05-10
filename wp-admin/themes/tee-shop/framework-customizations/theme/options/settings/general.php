<?php 

if ( ! defined( 'FW' ) ) {	die( 'Forbidden' ); }

$options = array(
	'general' => array(
		'title'   => esc_html__( 'General Setting', 'origin' ),
		'type'    => 'tab',
		'options' => array(
			'general_section' => array(
				'type'  => 'html-full',
				'label' => false,
				'html'  => '<b>General</b>',
			),
			's_backup_store'	=> array(
				'label'	=> __('Shopify private app link', 'basr-core'),
				'type'  => 'addable-box',
			    'box-options' => array(
			        'api-link' => array( 
			        	'type' => 'text',
			        	'lable'	=> 'Private app link',
			       	),
			    ),
			    'add-button-text' => __('Add', 'basr-core'),
			),
			'general_google_key' => array(
				'label' => esc_html__( 'Google API key', 'origin' ),
				'type'  => 'text',
				'value' => '',
			),
			'general_minify' => array(
				'type'  => 'switch',
				'value' => '',
				'label' => esc_html__('Load minfiy css/js', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Yes', 'origin'),
				),
				'left-choice' => array(
					'value' => '',
					'label' => esc_html__('No', 'origin'),
				),
			),
			'general_breadcrumb' => array(
				'type'  => 'switch',
				'value' => 'yes',
				'label' => esc_html__('Show/Hide Breadcrumb', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Show', 'origin'),
				),
				'left-choice' => array(
					'value' => '',
					'label' => esc_html__('Hide', 'origin'),
				),
			),
			'disable_linked_image' => array(
				'type'  => 'switch',
				'value' => '',
				'label' => esc_html__('Disable Link image to demo', 'origin'),
				'desc'  => esc_html__('Use for import demo light version', 'origin'),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__('Yes', 'origin'),
				),
				'left-choice' => array(
					'value' => '',
					'label' => esc_html__('No', 'origin'),
				),
			),
			'general_logo_login' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'value' => array(
					'yesno' => 'no',
				),
				'picker' => array(
					'yesno' => array(
						'label' => esc_html__( 'Logo For Default Login Page', 'origin' ),
						'type' => 'switch',
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Show', 'origin' )
						),
						'left-choice'  => array(
							'value' => 'no',
							'label' => esc_html__( 'Hide', 'origin' )
						),
						'value'        => 'yes',
					)
				),
				'choices'      => array(
					'yes' => array(
						'image' => array(
							'type'  => 'upload',
							'label' => esc_html__( 'Upload logo', 'origin' ),
						)
					),
				),
				'show_borders' => false,
			),
			'general_page_loader' => array(
				'type'  => 'multi-picker',
				'label' => false,
				'desc'  => false,
				'value' => array(
					'enable' => 'yes',
					'yes' => array(
						'background' => '#fff',
						'spinner_color' => '#666',
						'spinner_type' => 'spinner1',
					),
				),
				'picker' => array(
					'enable' => array(
						'type'  => 'switch',
						'label' => esc_html__('Show/Hide Page Loader', 'origin'),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__('Show', 'origin'),
						),
						'left-choice' => array(
							'value' => 'no',
							'label' => esc_html__('Hide', 'origin'),
						),
					),
				),
				'choices' => array(
					'yes' => array(
						'background' => array(
							'type' => 'color-picker',
							'label' => esc_html__('Background Color', 'origin'),
						),
						'spinner_color' => array(
							'type' => 'color-picker',
							'label' => esc_html__('Spinner Color', 'origin'),
						),
						'spinner_type' => array(
							'type' => 'select',
							'label' => esc_html__('Spinner Type', 'origin'),
							'value' => 'spinner3',
							'choices' => array(
								'spinner1' => esc_html__('Spinner 1', 'origin'),
								'spinner2' => esc_html__('Spinner 2', 'origin'),
								'spinner3' => esc_html__('Spinner 3', 'origin'),
								'spinner4' => esc_html__('Spinner 4', 'origin'),
								'spinner5' => esc_html__('Spinner 5', 'origin'),
								'spinner6' => esc_html__('Spinner 6', 'origin'),
								'spinner7' => esc_html__('Spinner 7', 'origin'),
							),
						),
					),
				),
			),
			'general_code_head' => array(
				'label' => esc_html__( 'Code before the </head> tag', 'origin' ),
				'type'  => 'textarea',
				'value' => '',
			),
			'general_code_body' => array(
				'label' => esc_html__( 'Code before the </body> tag', 'origin' ),
				'type'  => 'textarea',
				'value' => '',
			),
			'general_favicon' => array(
				'label' => esc_html__('Favicon', 'origin'),
				'type' => 'upload',
				'images_only' => true,
				'desc' => esc_html__('Use 512x512 PNG image for best result.<br /> If you are using Wordpress Site Icon feature, you can skip this option.', 'origin'),
			),
		),
	),
);