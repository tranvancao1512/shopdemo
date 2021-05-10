<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'tab_social_sharing' => array(
		'title'   => esc_html__( 'Social sharing setting', 'origin' ),
		'type'    => 'tab',
		'options' => array(
					'social_share' => array(
						'type' => 'multi',
						'attr' => array(
							'class' => 'fw-option-type-multi-show-borders',
						),
						'value' => array(
							'_facebook' => 'yes',
							'_twitter' => 'yes',
							'_google_plus' => 'yes',
							'_linkedin' => 'yes',
							'_tumblr' => 'yes',
							'_email' => 'yes',
						),
						'label' => false,
						'inner-options' => array(
							'_facebook' =>array(
								'type' => 'switch',
								'label' => esc_html__('Facebook Share', 'origin'),
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__('Show', 'origin'),
								),
								'left-choice' => array(
									'value' => '',
									'label' => esc_html__('Hide', 'origin'),
								),
							),
							'_twitter' =>array(
								'type' => 'switch',
								'label' => esc_html__('Twitter Share', 'origin'),
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__('Show', 'origin'),
								),
								'left-choice' => array(
									'value' => '',
									'label' => esc_html__('Hide', 'origin'),
								),
							),
							'_google_plus' =>array(
								'type' => 'switch',
								'label' => esc_html__('Google Plus Share', 'origin'),
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__('Show', 'origin'),
								),
								'left-choice' => array(
									'value' => '',
									'label' => esc_html__('Hide', 'origin'),
								),
							),
							'_linkedin' =>array(
								'type' => 'switch',
								'label' => esc_html__('Linkedin Share', 'origin'),
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__('Show', 'origin'),
								),
								'left-choice' => array(
									'value' => '',
									'label' => esc_html__('Hide', 'origin'),
								),
							),
							'_tumblr' =>array(
								'type' => 'switch',
								'label' => esc_html__('Tumblr Share', 'origin'),
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__('Show', 'origin'),
								),
								'left-choice' => array(
									'value' => '',
									'label' => esc_html__('Hide', 'origin'),
								),
							),
							'_email' =>array(
								'type' => 'switch',
								'label' => esc_html__('Email Share', 'origin'),
								'right-choice' => array(
									'value' => 'yes',
									'label' => esc_html__('Show', 'origin'),
								),
								'left-choice' => array(
									'value' => '',
									'label' => esc_html__('Hide', 'origin'),
								),
							),
						),
					),
		),	
	),
);
