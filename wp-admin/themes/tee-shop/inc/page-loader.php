<?php
/**
 * Page Loader 
 *
 ** @since Ln Moonlight 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

if ( ! defined('FW') ) return;

function origin_action_theme_page_loader_enqueue() {
	$loader = origin_get_setting('general_page_loader');
	if ( $loader['enable'] === 'no' ) return;
	$css = '.double-bounce1, .double-bounce2, .container1 > div, .container2 > div, .container3 > div, .spinner4, 
	.dot1, .dot2, .cube1, .cube2, .spinner6 > div, .spinner7 > div {
		background-color: '. $loader['yes']['spinner_color'] .';
	}
	';
	wp_add_inline_style('fakeLoader', $css );
	wp_enqueue_script('fakeLoader');

	$js = '
	jQuery(document).ready(function() {

		"use strict"; 

		var page_loader = jQuery("#basr-page-loader");
		page_loader.fakeLoader({
			timeToHide:1000,
			spinner:"'.$loader['yes']['spinner_type'].'",
			bgColor:"'.$loader['yes']['background'].'",
		});
		jQuery("a").click(function() {
			var self = this
			if( self.href.indexOf(window.location.host) < 0 ) return;
			if( self.href.indexOf("?") > -1 ) return;
			if( typeof jQuery(self).data("rel") === "undefined" || jQuery(self).data("rel").indexOf("prettyPhoto") > -1 ) return;
			if( "undefined" == typeof self.target || "_self" === self.target ) return;
			if( self.href.split("#")[0] === window.location.href.split("#")[0] ) return;
			page_loader.addClass("no-spinner");
			page_loader.fadeIn("400");
		});
	});
	';
	wp_add_inline_script('fakeLoader', $js);
}
add_action('wp_enqueue_scripts', 'origin_action_theme_page_loader_enqueue', 20);
