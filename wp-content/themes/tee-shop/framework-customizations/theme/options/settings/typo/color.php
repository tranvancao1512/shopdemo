<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'primary_color' => array(
		'label' => false,
		'type'  => 'multi',
		'help'	=> '#fd403e;',
		'inner-options' => array(
	        'color'		 => array(
				'type'  => 'color-picker',
		    	'value' => origin_default_typo( 'primary_color' ),
		    	'label'	=> 'Primary color'
			),
	    )
	),
);
