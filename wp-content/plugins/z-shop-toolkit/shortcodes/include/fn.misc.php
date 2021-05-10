<?php

// blog help func 

function basr_core_blogs_post_article() {
	echo '<article '; post_class("grid-item post"); echo '>';
}

function basr_core_blogs_post_article_end() {
	echo '</article>';
}


/*
 *  function 4 short register vc map
*/

function toolkit_get_category_wc_list() {

	$listing = array();

	if ( is_plugin_active('woocommerce/woocommerce.php') ) {
		$terms = get_terms( array( 'taxonomy' => 'product_cat' ) );

		foreach ( (array) $terms as $key => $value) {
			$listing[ $key ] = array();
			$listing[ $key ]['value'] = $value->term_id;
			$listing[ $key ]['label'] = $value->name;
		}
	}
	// d( $listing );
	return $listing;
}


function toolkit_basr_vc_cat(){
	return str_replace( 'LN_', '', strtoupper( BASR_CORE ) ) . esc_html__(  ' SHORTCODES', 'basr-core' );
}

function toolkit_basr_vcf_class(){
	return array(
		'param_name'  => 'classes',
		'heading'     => esc_html__( 'Classes', 'basr-core' ),
		'description' => esc_html__( '(Optional) Enter a unique class name. Seperate by blank space.', 'basr-core' ),
		'type'        => 'textfield',
	);
}

function toolkit_basr_vcf_animate( $i = 0 ) {
	$fields = array(
		array(
			'param_name' 		=> 'anm',
			'heading' 	 		=> esc_html__( 'Enable Animation', 'basr-core' ),
			'type' 		 		=> 'checkbox',
			'value'      		=> array(
										'' => true
									)
		),
		array(
			'param_name' 		=> 'anm_name',
			'heading' 			=> esc_html__( 'Animation', 'basr-core' ),
			'type' 		 		=> 'dropdown',
			'edit_field_class'	=> 'vc_col-sm-6 vc_col-xs-12 mgt15',
			'dependency' 		=> array(
										'element' 		=> 'anm',
										'value'   		=> array( '1' ),
										'not_empty'		=> true,
									),
			'std'               => 'fadeIn',
			'value'      		=> array('bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'jello', 'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp', 'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'fadeOut', 'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig', 'flip', 'flipInX', 'flipInY', 'flipOutX', 'flipOutY', 'lightSpeedIn', 'lightSpeedOut', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideOutUp', 'slideOutDown', 'slideOutLeft', 'slideOutRight', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp', 'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp', 'hinge', 'rollIn', 'rollOut', ),
		),
		array(
			'param_name'  		=> 'anm_delay',
			'heading'     		=> esc_html__( 'Animation Delay', 'basr-core' ),
			'description' 		=> esc_html__( 'Numeric value only, 1000 = 1second.', 'basr-core' ),
			'type'        		=> 'textfield',
			'value'		  		=> '1000',
			'edit_field_class'	=> 'vc_col-sm-6 vc_col-xs-12 mgt15',
			'dependency' 		=> array(
										'element'	 => 'anm',
										'value'   	 => array( '1' ),
										'not_empty'	 => false,
									),
		),
	);

	return $fields[$i];
}

function toolkit_basr_slick_data ( $atts ) {

	$data_arr = array();
	$data_arr['responsive'] = array();
	$index = array(
			'slidestoshow',
			'tablet_horizontal',
			'tablet_vertical',
			'mobile', 
			'arrows', 
			'dots', 
			'infinite', 
			'autoplay', 
			'vertical',
			'asNavFor',
		);

	// var_dump($atts);

	foreach ($atts as $key => $value) {

		if ( in_array( $key, $index) ) :

			$temp = array();
			switch ($key) {
				case 'tablet_horizontal':
					$temp['breakpoint'] = '1024';
					$temp['settings']	= array( 
						'slidesToShow'		=> $value,
						'slidesToScroll'	=> $value,
						);
					$data_arr['responsive'][] = $temp;
					break;
				case 'tablet_vertical':
					$temp['breakpoint'] = '768';
					$temp['settings']	= array( 
						'slidesToShow'		=> $value,
						'slidesToScroll'	=> $value,
						);
					$data_arr['responsive'][] = $temp;
					break;
				case 'mobile':
					$temp['breakpoint'] = '668';
					$temp['settings']	= array( 
						'slidesToShow'		=> $value,
						'slidesToScroll'	=> $value,
						);
					$data_arr['responsive'][] = $temp;
					break;
				case 'slidestoshow':
					$data_arr['slidesToShow'] = $value;
					$data_arr['slidesToScroll'] = $value;
					break;
				
				default:
					$data_arr[$key] = $value;
					break;
			}
		endif; // key in index
	}
	// var_dump($data_arr);
	return json_encode( $data_arr );
}

function toolkit_basr_animation_data( $anm = '0', $anm_name = 'bounce', $anm_delay = '1000' ) {
	if ( $anm === '1' ) {
		return ' data-animation-enable="1" data-animation="' . $anm_name . '"' . ' data-animation-delay="' .
		$anm_delay .
		       '"';
	}

}

function toolkit_basr_icon_param() {
	return array(
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'basr-core' ),
			'param_name' => 'lucy_icon',
			'value' => 'fa fa-adjust', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'description' => __( 'Select icon from library.', 'basr-core' ),
			'group' => __( 'Icon', 'basr-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Icon color', 'basr-core' ),
			'param_name' => 'color',
			'description' => __( 'Select icon color.', 'basr-core' ),
			'group' => __( 'Icon', 'basr-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Background shape', 'basr-core' ),
			'param_name' => 'background_style',
			'value' => array(
				__( 'None', 'basr-core' ) => '',
				__( 'Circle', 'basr-core' ) => 'rounded',
				__( 'Square', 'basr-core' ) => 'boxed',
				__( 'Rounded', 'basr-core' ) => 'rounded-less',
				__( 'Outline Circle', 'basr-core' ) => 'rounded-outline',
				__( 'Outline Square', 'basr-core' ) => 'boxed-outline',
				__( 'Outline Rounded', 'basr-core' ) => 'rounded-less-outline',
			),
			'description' => __( 'Select background shape and style for icon.', 'basr-core' ),
			'group' => __( 'Icon', 'basr-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom background color', 'basr-core' ),
			'param_name' => 'background_color',
			'description' => __( 'Select custom icon background color.', 'basr-core' ),
			'group' => __( 'Icon', 'basr-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Size', 'basr-core' ),
			'param_name' => 'size',
			'value' => '18',
			'description' => __( 'Icon size in px. Just put the number here.', 'basr-core' ),
			'group' => __( 'Icon', 'basr-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Icon padding', 'basr-core' ),
			'param_name' => 'padding',
			'value' => '19',
			'description' => __( 'Padding of icon in px. Just put the number here.', 'basr-core' ),
			'group' => __( 'Icon', 'basr-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Border Width', 'basr-core' ),
			'param_name' => 'border_width',
			'value' => '1',
			'description' => __( 'Border width of Outline styles', 'basr-core' ),
			'group' => __( 'Icon', 'basr-core' ),
			'dependency' => array(
				'element' => 'background_style',
				'value' => array(
					'rounded-outline',
					'boxed-outline',
					'rounded-less-outline',
				),
			),
		),
	);
}

function toolkit_basr_font_params(
	$prefix = '',
	$default = array(),
	$disable = array()
	) {
	$default = array_merge(
		array(
		'font-family' => '',
		'font-size' => '16',
		'font-weight' => '400',
		'color' => '#4f4f4f',
		'line-height' => '1',
		'letter-spacing' => '0',
		),
		$default
	);
	$output = array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Font Family', 'basr-core' ),
			'param_name' => $prefix . '_font_family',
			'edit_field_class' => 'vc_col-md-4 vc_col-sm-6 vc_col-xs-12',
			'value' => $default['font-family']
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Font Size', 'basr-core' ),
			'param_name' => $prefix . '_font_size',
			'value' => $default['font-size'],
			'edit_field_class' => 'vc_col-md-4 vc_col-sm-6 vc_col-xs-12',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Font Weight', 'basr-core' ),
			'param_name' => $prefix . '_font_weight',
			'value' => array( '100', '300', '400', '500', '600', '700', '800', '900' ),
			'std' => $default['font-weight'],
			'edit_field_class' => 'vc_col-md-4 vc_col-sm-6 vc_col-xs-12',
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Color', 'basr-core' ),
			'param_name' => $prefix . '_color',
			'value' => $default['color'],
			'edit_field_class' => 'vc_col-md-4 vc_col-sm-6 vc_col-xs-12',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Line Height', 'basr-core' ),
			'param_name' => $prefix . '_line_height',
			'value' => $default['line-height'],
			'edit_field_class' => 'vc_col-md-4 vc_col-sm-6 vc_col-xs-12',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Letter spacing', 'basr-core' ),
			'param_name' => $prefix . '_letter_spacing',
			'value' => $default['letter-spacing'],
			'edit_field_class' => 'vc_col-md-4 vc_col-sm-6 vc_col-xs-12',
		),
	);
	foreach ($output as $key => $param) {
		if( in_array( str_replace( $prefix . '_', '', $param['param_name']), $disable ) ) {
			unset($output[$key]);
		}
	}
	return $output;
}

function toolkit_basr_font_print_style( $prefix, $atts, $default = array() ) {
	$default = array_merge(
		array(
			'font-family' => '',
			'font-size' => '16',
			'font-weight' => '400',
			'color' => '#4f4f4f',
			'line-height' => '1',
			'letter-spacing' => '0',
		),
		$default
	);
	extract( shortcode_atts( array(
		$prefix . '_font_family' => $default['font-family'],
		$prefix . '_font_size' => $default['font-size'],
		$prefix . '_font_weight' => $default['font-weight'],
		$prefix . '_color' => $default['color'],
		$prefix . '_line_height' => $default['line-height'],
		$prefix . '_letter_spacing' => $default['letter-spacing'],
	), $atts ) );
	$css = '';
	$attrs = array();
	if( ${$prefix . '_font_family'} ) {
		$attrs['font-family'] = ${$prefix . '_font_family'};
	}
	if( ${$prefix . '_font_size'} ) {
		$attrs['font-size'] = ${$prefix . '_font_size'} . 'px';
	}
	if( ${$prefix . '_font_weight'} ) {
		$attrs['font-weight'] = ${$prefix . '_font_weight'};
	}
	if( ${$prefix . '_color'} ) {
		$attrs['color'] = ${$prefix . '_color'};
	}
	if( ${$prefix . '_line_height'} ) {
		$attrs['line-height'] = ${$prefix . '_line_height'};
	}
	if( ${$prefix . '_letter_spacing'} ) {
		$attrs['letter-spacing'] = ${$prefix . '_letter_spacing'} . 'px';
	}

	foreach ( $attrs as $key => $attr ) {
		$css .= $key . ':' . $attr . ';';
	}
	return $css;
}
if( ! function_exists('generateRandomString') ) :
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
endif;

function toolkit_basr_padding_params(
	$prefix = '',
	$default = array()
) {
	$default = array_merge(
		array(
			'top' => '0',
			'right' => '0',
			'bottom' => '0',
			'left' => '0',
		),
		$default
	);
	return array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Padding Top', 'basr-core' ),
			'param_name' => $prefix . '_top',
			'edit_field_class' => 'vc_col-md-3 vc_col-sm-6 vc_col-xs-12',
			'value' => $default['top']
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Right', 'basr-core' ),
			'param_name' => $prefix . '_right',
			'edit_field_class' => 'vc_col-md-3 vc_col-sm-6 vc_col-xs-12',
			'value' => $default['right']
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Bottom', 'basr-core' ),
			'param_name' => $prefix . '_bottom',
			'edit_field_class' => 'vc_col-md-3 vc_col-sm-6 vc_col-xs-12',
			'value' => $default['bottom']
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Left', 'basr-core' ),
			'param_name' => $prefix . '_left',
			'edit_field_class' => 'vc_col-md-3 vc_col-sm-6 vc_col-xs-12',
			'value' => $default['left']
		),
	);
}

function toolkit_basr_padding_print_style( $prefix, $atts, $default = array() ) {
	$default = array_merge(
		array(
			'top' => '0',
			'right' => '0',
			'bottom' => '0',
			'left' => '0',
		),
		$default
	);
	extract( shortcode_atts( array(
		$prefix . '_top' => $default['padding-top'],
		$prefix . '_right' => $default['padding-right'],
		$prefix . '_bottom' => $default['padding-bottom'],
		$prefix . '_left' => $default['padding-left'],
	), $atts ) );
	$css = '';
	$attrs = array();
	if( ${$prefix . '_top'} ) {
		$attrs['padding-top'] = ${$prefix . '_top'} . 'px';
	}
	if( ${$prefix . '_right'} ) {
		$attrs['padding-right'] = ${$prefix . '_right'} . 'px';
	}
	if( ${$prefix . '_bottom'} ) {
		$attrs['padding-bottom'] = ${$prefix . '_bottom'} . 'px';
	}
	if( ${$prefix . '_left'} ) {
		$attrs['padding-left'] = ${$prefix . '_left'} . 'px';
	}

	foreach ( $attrs as $key => $attr ) {
		$css .= $key . ':' . $attr . ';';
	}
	return $css;
}

if( !function_exists('basr_get_image_url') ) {
	function basr_get_image_url( $id, $size = 'full' ) {
		$image = wp_get_attachment_image_src($id, $size);
		if( is_array($image) ) {
			return $image[0];
		}
		return;
	}
}


function toolkit_basr_get_animation( $atts ){

	$animation_html = array();

	$args =	array( 
				'anm'								=> ''				,
				'anm_name'							=> ''				,
				'anm_delay'							=> '500'			,
			);

	extract( shortcode_atts( $args, $atts ) );

	if ( $anm ) {

		$anm        = ' animated';
		$data_name  = ' data-animation="' . $anm_name . '"';
		$data_delay = ' data-animation-delay="' . $anm_delay . '"';

		$animation_html[] = '<div class="basr-animation ' .  $anm . '" '. $data_name . $data_delay . ' >';
		$animation_html[] = '</div>';
	}

	if ( ! count( $animation_html  ) ) $animation_html = array( '', '' );

	return $animation_html;
}

function toolkit_action_theme_login_logo() {
	$logo = basr_core_get_setting('general_logo_login');
	if( $logo['yesno'] === 'no') {
		return;
	}
	if( $logo['yes']['image']['url'] == '') {
		return;
	}
	?>
	<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url(<?php echo esc_url( $logo['yes']['image']['url'] ); ?>);
			padding-bottom: 30px;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'toolkit_action_theme_login_logo' );



/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 */
function toolkit_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}

	$located = toolkit_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
		return;
	}

	// Allow 3rd party plugin filter template file from their plugin.
	$located = apply_filters( 'toolkit_get_template', $located, $template_name, $args, $template_path, $default_path );

	do_action( 'toolkit_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'toolkit_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function toolkit_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path ) {
		$template_path = toolkit_template_path();
	}

	if ( ! $default_path ) {
		$default_path = toolkit_plugin_path() . '/shortcodes/wc-template/';
	}

	// Look within passed path within the theme - this is priority.
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template/
	if ( ! $template || WC_TEMPLATE_DEBUG_MODE ) {
		$template = $default_path . $template_name;
	}

	// Return what we found.
	return apply_filters( 'toolkit_locate_template', $template, $template_name, $template_path );
}

function toolkit_template_path() {
	return apply_filters( 'toolkit_template_path', 'toolkit-template/' );
}




