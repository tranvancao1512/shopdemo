<?php
/**
 * Get default variables of current theme.
 *
 * @param string $variable
 *
 * @return array|mixed|void
 */
function origin_get_default_settings( $variable = "" ) { 

	$default = array(
		"devmode" => "false",
		"fonts" => array(
		"open_sans" => array(
		"family" => "Open Sans",
		"weights" => "400-700",
		),
		"san_serif" => array(
		"family" => "sans-serif",
		"weights" => "400-700",
		),
		),
		"content-width" => "1170",
		"sidebar-width" => "270",
		"gutter-width" => "30",
		"layout-boxed" => "no",
		"color-primary" => "#000",
		"color-secondary" => "#424642",
		"color-text" => "#a1a1a1",
		"color-heading" => "#000000",
		"color-heading_2" => "#272727",
		"color-link" => "#000000",
		"color-link-hover" => "#ea9355",
		"color-nav" => "#2e2e2e",
		"color-nav-hover" => "#f6c93b",
		"color-meta" => "#aaa",
		"color-border" => "#d3d3d3",
		"colors-text" => array(
		"blog_content" => "#a1a1a1",
		"blog_meta" => "#6a6a6a",
		"quote" => "#292929",
		"widget_h" => "#272727",
		"widget_tag" => "#c6c6c6",
		"widget_cat" => "#999999",
		),
		"bg-primary" => "#fff",
		"bg-secondary" => "#f5f5f5",
		"bg-form-field" => "#f8f8f8",
		"typo-family" => "'Open Sans', sans-serif",
		"typo-size" => "16",
		"typo-line-height" => "32",
		"typo-h-family" => "'Open Sans', sans-serif;",
		"title-bar" => array(
		"display" => "yes",
		"color" => "#000000",
		"padding-top" => "114",
		"padding-bottom" => "114",
		"bg" => array(
		"color" => "#f5f5f5",
		"image" => "none",
		"position" => "center center",
		"repeat" => "repeat",
		"size" => "auto",
		),
		"parallax" => "no",
		"overlay-color" => "#fff",
		"overlay-opacity" => "5",
		"clipmask-bg" => "",
		"clipmask-opacity" => "0",
		),
	);

	if( $variable === "" )  {
		return $default;
	}

	if( is_string($variable) ) {
		if( array_key_exists( $variable, $default ) ) {
			return $default[$variable];
		}
	}

	if( is_array($variable) ) {
		$output = array();
		foreach( $variable as $key => $value ) {
			if( array_key_exists( $key, $default ) ) {
				$output[$key] = $default[$key];
			}
			else {
				$output[$key] = $value;
			}
		}
		return $output;
	}
}
