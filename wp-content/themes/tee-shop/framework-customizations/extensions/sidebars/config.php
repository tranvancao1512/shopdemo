<?php

$cfg = array();


$cfg['sidebar_positions'] = array(
	'no-sidebar' => array(
		'icon_url' => 'no-sidebar.png',
		'sidebars_number' => 0
	),
	'left-sidebar' => array(
		'icon_url' => 'left-sidebar.png',
		'sidebars_number' => 1
	),
	'right-sidebar' => array(
		'icon_url' => 'right-sidebar.png',
		'sidebars_number' => 1
	),
	'left-left-sidebar' => array(
		'icon_url' => 'left-left-sidebar.png',
		'sidebars_number' => 2
	),
	'left-right-sidebar' => array(
		'icon_url' => 'left-right-sidebar.png',
		'sidebars_number' => 2
	),
	'right-right-sidebar' => array(
		'icon_url' => 'right-right-sidebar.png',
		'sidebars_number' => 2
	),
);

$cfg['dynamic_sidebar_args'] = array(
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h2 class="widget-title">',
	'after_title'   => '</h2>',
);


/**
 * Render sidebar metabox in post types.
 */
$cfg['show_in_post_types'] = true;
$cfg['post_types_support'] = array('page', 'product','basr-portfolio');
