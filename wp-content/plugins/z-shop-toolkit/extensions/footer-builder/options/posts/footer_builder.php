<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'basr_footer'	=> array(
		'type'    => 'box',
		'options' => array(
			'basr_footer_tab' 	=> array(
				'title'   => esc_html__( 'Footer info', 'basr-core' ),
				'type'	  => 'tab',
				'options' => array(
					'info'	=> array(
						'type'	=> 'html',
						'html'	=> esc_html__( 'Anable Visual composer for footer builder: Dashboad > Visual Composer > Role Manager : post types > footer_builder. Use footer builder as normal page.'),
					)
				),
			),
			'page_template' => array(
				'type'          => 'load-vc-template',
				'label'         => esc_html__('Loader Demo footer template', 'basr-core'),
				'value'         => '',
				'inner_options' => array(
					'templates' => array(
						'type'          => 'multi-select',
						'label'         => esc_html__('Select Demo template', 'basr-core'),
						'population'    => 'array',
						'template-type' => 'footer_builder',
						'limit'         => 1,
					),
				),
			),
		)
	),
);
