<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'mail_group_box' => array(
		'title'   => esc_html__( 'Action - Mail template', 'origin' ),
		'type'    => 'tab',
		'options' => array(
			'mail_action'	=> array(
				'label'	=> __('Mail group', 'basr-core'),
				'type'  => 'addable-box',
			    'box-options' => array(
			        'action' => array( 
			        	'type' => 'text',
			        	'lable'	=> 'Name of group',
			       	),
			       	'template' => array(
						'type'       => 'multi-select',
						'label'      => esc_html__('Mail template accessable', 'origin'),
						'population' => 'posts',
						'source'	 => 'tee_mail',
						'limit'		 => 1,
					),
			    ),
			    'add-button-text' => __('Add', 'basr-core'),
			    'template' 	     => 'Action - template', // box title
			),
		),
	),
);

