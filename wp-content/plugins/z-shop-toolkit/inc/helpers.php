<?php

/*
 *  Helper function 
*/

if ( ! function_exists('basr_core_get_setting') ) {
	function basr_core_get_setting( $key = '' ) {

		return call_user_func( BASR_CORE . '_get_setting', $key );
	}
}

if ( ! function_exists('basr_core_get_post_meta') ) {
	function basr_core_get_post_meta( $settings, $id, $pre = '' ) {
		return call_user_func_array( BASR_CORE . '_get_post_meta', array( $settings, $id, $pre ) );
	}
}


if ( ! function_exists('basr_core_get_ext_settings') ) {
	function basr_core_get_ext_settings( $ext, $settings, $pre = '' ) {
		if ( is_array( $settings ) ) {
			foreach ($settings as $key => $value) {
				$settings[$key] = fw_get_db_ext_settings_option( $ext, $key ); 
			}
			return $settings;
		}
		return ( fw_get_db_ext_settings_option( $ext, $settings ) );
	}
}

if ( ! function_exists('basr_core_social_sharing_html') ) {
	function basr_core_social_sharing_html(  $title = '' ) {
		call_user_func_array( BASR_CORE . '_social_sharing_html', array( $title ) );
	}
}

function basr_core_get_term_list( $term = '' ) {

	$listing = array();

	$terms = get_terms( array( 'taxonomy' => $term ) );

	foreach ( (array) $terms as $key => $value) {
		$listing[ $key ] = array();
		$listing[ $key ]['value'] = $value->term_id;
		$listing[ $key ]['label'] = $value->name;
	}

	return $listing;
}


function basr_core_social_info( $link_array = array() ) {
	call_user_func_array( BASR_CORE . '_social_info', array( $link_array ) );
}

function basr_core_post_meta_thumbnail( $image_size = '' ) {

	$format = get_post_format();

	if ( ! $format || ln_moonlight_is_related_post() ) $format = 'image';

	include get_template_directory() .  '/templates/post/format/format-' . $format . '.php' ;

}

if ( ! function_exists( 'l' ) ) {
	function l( $param, $label = '' ) {
		// if ( ! get_current_user_id() == 1 ) return;
		// if( ! preg_match( '/localhost/', home_url() ) ) return;
		$dir = WP_CONTENT_DIR . '/tee-log.log';
		$backtrace = debug_backtrace();
		$arr = explode( '/', $backtrace[0]['file'] );
		$last = count( $arr );
		if( ! isset( $arr[$last-3] ) ) $arr[$last-3] = '';
		if( ! isset( $arr[$last-2] ) ) $arr[$last-2] = '';
		error_log( "\n" . $label . '_________________' . $arr[$last-3] . '/' . $arr[$last-2] . '/' . $arr[$last-1] . ':__________' . $backtrace[0]['line'] . "\n", 3, $dir );
		error_log( "\n" );
		error_log( print_r( $param, true ), 3, $dir  );
		error_log( "\n" );
	}
} 
