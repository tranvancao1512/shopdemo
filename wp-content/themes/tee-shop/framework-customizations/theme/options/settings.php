<?php
/**
 * Theme options
 *
 * @todo sync theme options with customizers
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	fw()->theme->get_options( 'settings/site' ),
	fw()->theme->get_options( 'settings/general' ),
	fw()->theme->get_options( 'settings/layout' ),
	fw()->theme->get_options( 'settings/typography' ),
	fw()->theme->get_options( 'settings/header' ),
	fw()->theme->get_options( 'settings/footer' ),
	fw()->theme->get_options( 'settings/title-bar' ),
	fw()->theme->get_options( 'settings/blogs' ),
	fw()->theme->get_options( 'settings/share' ),
	fw()->theme->get_options( 'settings/social' ),
	fw()->theme->get_options( 'settings/wc' ),
	fw()->theme->get_options( 'settings/mail' ),
	fw()->theme->get_options( 'settings/page_404' ),
);