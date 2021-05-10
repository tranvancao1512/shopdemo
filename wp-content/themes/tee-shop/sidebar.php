<?php
/**
 * The sidebar containing the main widget area
 *
 * @package ln-moonlight
 * @since 1.0.0
 * @version 1.0.0
 */

/**
 * The Sidebar containing the main widget area
 */
return;
$classes = get_body_class();

if ( in_array( 'no-sidebar', $classes ) ) return;

?>

<div id="secondary" class="primary-sidebar basr-isotope-hide widget-area masonry-layout" role="complementary">

<?php

	if ( defined( 'FW' ) ) {

		if ( ! in_array( 'no-sidebar', $classes ) ) {
			if ( in_array( 'theme-option-layout', $classes ) ) {
				if ( is_active_sidebar( 'sidebar-1' ) ) {
					dynamic_sidebar( 'sidebar-1' ); 
				}
			}
			else {
				if( function_exists('fw_ext_sidebars_show') ) {
					echo fw_ext_sidebars_show( 'blue' );
				}
			}	
		}

	} else {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			dynamic_sidebar( 'sidebar-1' );
		}
	}

?>

</div> <!-- #secondary -->

<div id="third" class="secondary-sidebar basr-isotope widget-area masonry-layout"> 

<?php 

	if ( defined( 'FW' ) ) {
		if ( in_array( 'has-two-sidebar', $classes ) )  {

			if ( in_array( 'theme-option-layout', $classes ) ) {
				if ( is_active_sidebar( 'sidebar-2' ) ) {
					dynamic_sidebar( 'sidebar-2' ); 
				}
			}
			else {
				if( function_exists('fw_ext_sidebars_show') ) {
					echo fw_ext_sidebars_show( 'yellow' );
				}
			}
		}
	}

?>

</div> <!-- #third -->


