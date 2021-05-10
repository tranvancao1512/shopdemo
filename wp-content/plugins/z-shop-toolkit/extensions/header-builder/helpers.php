<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

if ( ! function_exists( 'builder_menu_choices' ) ) {
	function builder_menu_choices() {

		$menus        = wp_get_nav_menus();
		$menu_choices = array( 'none' => __( 'Please Choose', 'lunar-core' ) );
		foreach ( $menus as $menu ) {
			$menu_choices[ $menu->slug ] = $menu->name;
		}

		return $menu_choices;
	}
}

/**
 * @param array $items
 *
 * @return string|void
 */
function header_builder_get_items( array $items ) {

	if ( empty( $items ) ) {
		return;
	}

	ob_start();

	$builder = fw()->backend->option_type( 'header-builder' );
	echo $builder->render_items( $items, array() );

	return ob_get_clean();
}

/**
 * @param array $items
 *
 * @return string|void
 */
function m_header_builder_get_items( array $items ) {

	if ( empty( $items ) ) {
		return;
	}

	ob_start();

	$builder = fw()->backend->option_type( 'm-header-builder' );
	echo $builder->render_items( $items, array() );

	return ob_get_clean();
}

/**
 * @return array
 */
function header_builder_get_sidebars() {

	$output = array();
	global $wp_registered_sidebars;
	foreach ( $wp_registered_sidebars as $id => $sidebar ) {
		$output[ $id ] = $sidebar['name'];
	}

	return $output;
}

/**
 * @param $type
 *
 * @return string
 */
function header_builder_header_button_attr( $type ) {

	$output = '';
	switch ( $type ) {
		case 'search':
			$output = array(
				'class' => 'search-trigger',
				'href'  => 'javascript:void(0)',
			);
			break;
		case 'cart':
			$output = array(
				'class' => 'cart',
				'href'  => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '',
				'title' => __( 'View your shopping cart', 'lunar-core' ),
			);
			break;
		case 'offcanvas':
			$output = array(
				'id'          => 'offcanvas-trigger',
				'class'       => 'st-trigger',
				'data-effect' => 'st-effect-1-right',
				'href'        => 'javascript:void(0)',
			);
			break;
	}
	if ( ! empty( $output ) ) {
		return fw_attr_to_html( $output );
	}
}

if ( ! function_exists( 'header_display_icon_v2' ) ) {
	function header_display_icon_v2( $array ) {

		printf(
			'<i class="%s"></i>',
			$array['icon-class']
		);
	}
}

/**
 * @return mixed
 */
function header_builder_get_version() {

	return fw()->extensions->get( 'header-builder' )->manifest->get( 'version' );
}

/**
 * @param $path
 *
 * @return string
 */
function header_builder_locate_uri( $path ) {

	return fw()->extensions->get( 'header-builder' )->locate_URI( $path );
}

function header_buider_generate_inline_style( $item ) {

	$style = '';

	if ( 'section' == $item['type'] && isset( $item['options']['height'] ) ) {
		$style .= '.' . $item['shortcode'] . ' .header-elems{height:' . intval( $item['options']['height']) . 'px;line-height:' . intval( $item['options']['height'] ) . 'px} ' . 
			'.' . $item['shortcode'] . ' .basr-core-menu > li {line-height:' . intval( $item['options']['height']) . 'px;}';
	}

	if ( 'header-buttons' === $item['type'] ) {
		if ( 'custom' === $item['options']['custom_style']['style'] ) {
			$style .= '
				.header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .item {
					font-size: ' . intval( $item['options']['custom_style']['custom']['font_size'] ) . 'px;
					color: ' . $item['options']['custom_style']['custom']['item_color'] . ';
				}
				.header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .item:hover {
					color: ' . $item['options']['custom_style']['custom']['item_color_hover'] . ';
				}
			';
		}
	}
	if ( 'nav' === $item['type'] ) {
		$selector                   = '.header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .basr-coremenu';
		$option                     = $item['options']['custom_style']['custom'];
		$nav_text_transform         = $option['nav_text_transform'];
		$nav_subitem_text_transform = $nav_text_transform;
		if ( 'uppercase-first-level' === $nav_text_transform ) {
			$nav_text_transform         = 'uppercase';
			$nav_subitem_text_transform = 'none';
		}
		if ( 'custom' === $item['options']['custom_style']['style'] ) {
			$style .=
				$selector . ' > li > a {
					font-size: ' . $option['nav_item_typo']['size'] . 'px;
					font-weight: ' . $option['nav_item_font_weight'] . ';
					letter-spacing: ' . $option['nav_item_typo']['letter-spacing'] . 'px;
					text-transform: ' . $nav_text_transform . ';
				}
			' . $selector . ' > li > a,
				' . $selector . ' > li > .megaicon,
				' . $selector . ' > li:after {
			color:' . $option['nav_item_color'] . ';
				}
				' . $selector . ' > li:hover > a,
				' . $selector . ' > li:hover > .megaicon,
				' . $selector . ' > li:hover:after {
			color:' . $option['nav_item_color_hover'] . ';
				}
				' . $selector . ' > li > ul a {
					color:' . $option['nav_subitem_color'] . ';
					font-weight: ' . $option['nav_subitem_font_weight'] . ';
					font-size: ' . $option['nav_subitem_typo']['size'] . 'px;
					letter-spacing: ' . $option['nav_subitem_typo']['letter-spacing'] . 'px;
					line-height: ' . $option['nav_subitem_typo']['line-height'] . 'px;
					text-transform: ' . $nav_subitem_text_transform . ';
				}
				' . $selector . ' > li > ul a:hover {
			color:
			' . $option['nav_subitem_color_hover'] . ';
				}
				';
		}
	}
	if (
		'search' === $item['type']
		|| 'wishlist' === $item['type']
		|| 'sidebar' === $item['type']
		|| 'account' === $item['type']
		|| 'cart' === $item['type']
	) {
		$style .= '
				.header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .item {
					font-size: ' . intval( $item['options']['font_size'] ) . 'px;
					color: ' . $item['options']['item_color'] . ';
				}
				.header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .item:hover {
					color: ' . $item['options']['item_color_hover'] . ';
				}
			';
	}

	return $style;
}

function m_header_buider_generate_inline_style( $item ) {

	$style = '';
	if ( 'menu' === $item['type'] ) {
		$selector                    = '.m-header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .header-builder-m-menu';
		$option                      = $item['options']['custom_style']['custom'];
		$menu_text_transform         = $option['menu_text_transform'];
		$menu_subitem_text_transform = $menu_text_transform;
		if ( 'uppercase-first-level' === $menu_text_transform ) {
			$menu_text_transform         = 'uppercase';
			$menu_subitem_text_transform = 'none';
		}
		$style .= '
				.m-header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .menu-toggler:before {
					font-size: ' . intval( $item['options']['font_size'] ) . 'px;
					color: ' . $item['options']['item_color'] . ';
				}
				.m-header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .menu-toggler:hover:before {
					color: ' . $item['options']['item_color_hover'] . ';
				}
			';
		if ( 'custom' === $item['options']['custom_style']['style'] ) {
			$style .=
				'.m-header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' nav.mobile-menu {
					background: ' . $option['menu_background'] . ';
				}' .
				$selector . ' > li > a {
					font-size: ' . $option['menu_item_typo']['size'] . 'px;
					font-weight: ' . $option['menu_item_font_weight'] . ';
					letter-spacing: ' . $option['menu_item_typo']['letter-spacing'] . 'px;
					text-transform: ' . $menu_text_transform . ';
				}
			' . $selector . ' > li > a,
				' . $selector . ' > li > .megaicon,
				' . $selector . ' > li:after {
			color:' . $option['menu_item_color'] . ';
				}
				' . $selector . ' > li:hover > a,
				' . $selector . ' > li:hover > .megaicon,
				' . $selector . ' > li:hover:after {
			color:' . $option['menu_item_color_hover'] . ';
				}
				' . $selector . ' > li > ul a {
					color:' . $option['menu_subitem_color'] . ';
					font-weight: ' . $option['menu_subitem_font_weight'] . ';
					font-size: ' . $option['menu_subitem_typo']['size'] . 'px;
					letter-spacing: ' . $option['menu_subitem_typo']['letter-spacing'] . 'px;
					line-height: ' . $option['menu_subitem_typo']['line-height'] . 'px;
					text-transform: ' . $menu_subitem_text_transform . ';
				}
				' . $selector . ' > li > ul a:hover {
			color:
			' . $option['menu_subitem_color_hover'] . ';
				}
				';
		}
	}
	if (
		'search' === $item['type']
		|| 'wishlist' === $item['type']
		|| 'sidebar' === $item['type']
		|| 'account' === $item['type']
		|| 'cart' === $item['type']
	) {
		$style .= '
				.m-header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .item {
					font-size: ' . intval( $item['options']['font_size'] ) . 'px;
					color: ' . $item['options']['item_color'] . ';
				}
				.m-header-builder-type-' . $item['type'] . '.' . $item['shortcode'] . ' .item:hover {
					color: ' . $item['options']['item_color_hover'] . ';
				}
			';
	}

	return $style;
}

function header_builder_generate_css( $options, $css = '' ) {

	foreach ( $options as $item ) {
		echo header_buider_generate_inline_style( $item );
		if ( is_array( $item['_items'] ) && ! empty( $item['_items'] ) ) {
			header_builder_generate_css( $item['_items'], $css );
		}
	}
}

function m_header_builder_generate_css( $options, $css = '' ) {

	foreach ( $options as $item ) {
		echo m_header_buider_generate_inline_style( $item );
		if ( is_array( $item['_items'] ) && ! empty( $item['_items'] ) ) {
			m_header_builder_generate_css( $item['_items'], $css );
		}
	}
}

function header_builder_get_header_html( $post_id ) {

	$header = fw()->extensions->get( 'header-builder' );
	ob_start();
	echo $header->render( $post_id );

	return ob_get_clean();
}

/**
 * @param int $post_id
 *
 * @return bool|WP_Post
 */
function header_builder_render_header( $inputs ) {

	/**
	 * @var FW_Extension_Header_Builder $header
	 */
	ob_start();
	$header = fw()->extensions->get( 'header-builder' );
	echo $header->render_header( $inputs );

	return ob_get_clean();
}

/**
 * @param int $post_id
 *
 * @return bool|WP_Post
 */
function header_builder_render_m_header( $inputs ) {

	/**
	 * @var FW_Extension_Header_Builder $header
	 */
	ob_start();
	$header = fw()->extensions->get( 'header-builder' );
	echo $header->render_m_header( $inputs );

	return ob_get_clean();
}

/**
 * @return array
 */
function header_builder_get_all_headers() {

	$output  = array();
	$headers = get_posts( array(
		'post_type'      => 'header_builder',
		'order'          => 'ASC',
		'posts_per_page' => 100,
		'post_status'    => 'publish',
	) );
	foreach ( $headers as $header ) {
		$output[] = $header->ID;
	}

	return $output;
}

/**
 * @return array
 */
function header_builder_prepare_select_box() {

	$output  = array();
	$headers = get_posts( array(
		'post_type'      => 'header_builder',
		'order'          => 'ASC',
		'posts_per_page' => 100,
	) );
	$output[0] = __( 'Default header', 'lunar-core' );
	foreach ( $headers as $header ) {
		$output[ $header->ID ] = $header->post_title;
	}
	return $output;
}

/**
 * @return mixed|null
 */
function header_builder_get_current_header() {

	$header_id = basr_core_get_post_meta( 'header', get_the_ID() );

	if ( ! empty( $header_id[0] ) && get_post( $header_id[0] ) ) {
		return intval( $header_id[0] );
	}
	$header_id = origin_get_setting( 'default_header' );
	if ( ! empty( $header_id ) && get_post( $header_id ) ) {
		return intval($header_id[0]);
	}
	$all_headers = header_builder_get_all_headers();
	if ( ! empty( $all_headers ) ) {
		$header_id = $all_headers[0];

		return intval($header_id);
	}

	return null;
}
