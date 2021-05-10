<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ln-moonlight
 * @since   1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head();?>
</head>

<body <?php body_class(); ?>>
<div id="st-container" class="st-container">
	<?php
	/**
	 * origin_header hook
	 *
	 * @hooked origin_action_default_header - 10
	 */
	do_action( 'origin_header' );
	?>

	<?php
	/**
	 * origin_after_header hook
	 *
	 * @hooked origin_action_render_title_bar - 10
	 */
	do_action( 'origin_after_header' );

	?>

	<div id="content" class="container site-content">
