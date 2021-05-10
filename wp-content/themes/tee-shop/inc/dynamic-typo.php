<?php
/**
 * Render dynamic style
 *
 * @package ln-moonlight
 ** @since Ln Moonlight 1.0.0
 */

// Typo 
if ( ! function_exists( 'origin_typo_dynamic_style' ) ) {

	add_action( 'wp_enqueue_scripts', 'origin_typo_dynamic_style', 999 );

	/**
	 * Render post style from options
	 */
	function origin_typo_dynamic_style() {

		if ( !defined( 'FW' ) ) return;

		$css = '';

		$css = '';

		$default 		= origin_default_typo();

	// Typo 

		$font = array( 
			'typo_body'		=> '',
			'typo_heading'	=> '',
		);

		$font         =  origin_get_setting( $font );

		if ( ! isset( $font['typo_body']['family'] ) ) return;

		// get only value diff from default

		foreach ( $font as $key => $value) {
			foreach ($value as $k => $v) {
				if ( isset( $default[ $key ][ $k ] ) && $v == $default[ $key ][ $k ] ) {
					unset( $font[ $key ][ $k ] );
				}
			}
		}

		// break if theme option is old version or not update db

		foreach ( $font as $key => $arr_font ) {
			switch ($key) {
				case 'typo_body':
					$css .= 'body {' .
								origin_typo_convert_to_css( $arr_font ) .
							'}';
					break;
				case 'typo_heading':
					$css .= 'h1, h2, h3, h4, h5, h6 {' .
								origin_typo_convert_to_css( $arr_font ) .
							'}';
					break;
			}
		}

		// heading font 

		$h = array( 
			'heading_h1'	=> '',
			'heading_h2'	=> '',
			'heading_h3'	=> '',
			'heading_h4'	=> '',
			'heading_h5'	=> '',
			'heading_h6'	=> ''
		);

		$h = origin_get_setting( $h );

		foreach ($h as $key => $value) {
			if ( $value['size'] == $default[$key]['size'] ) {
				unset( $h[$key] );
			}
		}

		foreach ($h as $key => $value) {
			$select = str_replace('heading_', '' , $key);
			$css  	.= 	$select . ' {' .
							origin_typo_convert_to_css( $value ) . 
						'}';
		}

		// link color 

		$link = array( 
			'link_color'       => '',
			'link_color_hover' => '',
		);

		$link = origin_get_setting( $link );

		foreach ($link as $key => $value) {
			switch ( $key ) {
				case 'link_color':
					$css .= 'a {' . 
								origin_typo_convert_to_css( $value ) . 
							'}';
					break;
				case 'link_color_hover':
					$css .= 'a:hover, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover {' . 
								origin_typo_convert_to_css( $value ) . 
							'}';
					break;
			}
		}

		// primary 

		$primary_color = origin_get_setting( 'primary_color' );

		if ( $primary_color['color'] != origin_default_typo( 'primary_color' ) ) {
			$css .= origin_custom_theme_color( $primary_color['color'] );
			$css .= origin_custom_shortcodes_color( $primary_color['color'] );
			$css .= origin_custom_portfolio_color( $primary_color['color'] );
		}

		$handle = 'ln-moonlight-style';

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		if ( is_plugin_active( 'z-kids-toolkit/init.php' ) ) {
			$handle = 'basr-shortcode-css';
		}

		if ( defined( 'FW' ) && fw_ext('basr-portfolio') ) {
			$handle = 'basr-portfolio-css';
		}

		wp_add_inline_style( $handle, $css );

	}
}

function origin_custom_theme_color( $color ){
	$css = '';
	$css .= '.basr-video-banner>.vc_column-inner>.wpb_wrapper:hover:after ,a:hover ,a.button.style-2:hover ,h1 a:hover,h2 a:hover,h3 a:hover,h4 a:hover,h5 a:hover,h6 a:hover ,blockquote cite:hover,q cite:hover ,.search-form .search-submit:hover .moonlight-search-icon:after ,.site-header .menu-toggle ,.site-header .menu-toggle:hover,.site-header .menu-toggle:focus ,.morphsearch-form input.morphsearch-input ,.morphsearch-form .morphsearch-submit,.header-builder-type-social .social li a:hover ,.st-menu ul li a:hover,.st-menu ul li a:active ,.st-menu ul li.menu-item-has-children:hover:after ,.td-menu li .sub-menu .menu-item-has-children:hover:after,.primary-navigation div.menu li .sub-menu .menu-item-has-children:hover:after ,.td-menu li .sub-menu a:hover,.primary-navigation div.menu li .sub-menu a:hover ,.title-bar h1 span:not(.border) ,div.breadcrumbs span a:hover ,div.breadcrumbs .last-item ,.comments-area .comments-pagination .page-numbers:hover,.comments-area .comments-pagination .page-numbers.current ,.comments-area .bypostauthor .fn ,.comments-area .comment-list li article .reply .comment-reply-link:hover ,.widget a:hover ,.basr_core_widget_latest_posts .posts-list .post-item .post-text h4 a:hover ,.widget_archive ul li a:hover,.widget_categories ul li a:hover ,.widget_tag_cloud a:hover ,#wp-calendar caption ,#wp-calendar tbody td a ,.pagination .nav-links>*:not(.current):hover ,.pagination .nav-links .current ,.pagination .nav-links .next:hover:after,.pagination .nav-links .prev:hover:after ,.basr-carousel.owl-theme .owl-nav .owl-prev:hover,.basr-carousel.owl-theme .owl-nav .owl-next:hover ,#colophon.footer-default a ,.single-post .post-navigation .nav-previous:hover,.single-post .post-navigation .nav-next:hover ,.single-post .post-navigation .nav-previous:hover:before,.single-post .post-navigation .nav-next:hover:before ,.single-post .post-navigation .nav-previous:hover a,.single-post .post-navigation .nav-next:hover a ,.post-author a:hover,.post-date a:hover,.post-cat a:hover ,.page-links span:not(:first-child) ,.blog-grid .post.format-quote .post-format-quote blockquote p + a cite:hover,.blog-masonry .post.format-quote .post-format-quote blockquote p + a cite:hover ,.blog-medium .hentry.format-quote .post-format-quote blockquote p + a cite:hover ,.dark-background-color a:hover ,.basr-custom-nav a:hover { color: ' . $color . ';}';
	$css .= 'button:not(.pswp__button):hover,input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover,.button:hover ,mark,ins ,hr ,.basr-video.has-thumb:after ,#wrap-footer-info:before ,.hamburger:hover .hamburger-inner ,.hamburger:hover .hamburger-inner:after,.hamburger:hover .hamburger-inner:before ,.site-header .menu-toggle.toggled-on:focus ,.header-builder-type-header-buttons .cart .cart-counter ,.td-menu .menu>li>a:after,.td-menu .menu>li>a:before,.primary-navigation div.menu .menu>li>a:after,.primary-navigation div.menu .menu>li>a:before ,.comments-area .comment-list li #respond .comment-form .form-submit input ,.widget_archive ul li:before,.widget_categories ul li:before ,.basr-pagination.number .page-numbers.current ,.basr-pagination.number .page-numbers:hover ,div.basr-slick .slick-dots li.slick-active button:before ,div.basr-slick .slick-dots li button:hover:before ,.basr-carousel.owl-theme .owl-dots .owl-dot:hover span ,.basr-carousel.owl-theme .owl-dots .owl-dot.active span ,.moonlight.tp-bullets .tp-bullet.selected ,.moonlight.tp-bullets .tp-bullet:hover { background-color: ' . $color . ';}';
	$css .= '.basr-video-banner>.vc_column-inner>.wpb_wrapper:hover:after ,input:focus,textarea:focus ,button:not(.pswp__button),input[type="button"],input[type="reset"],input[type="submit"],.button ,button:not(.pswp__button).style-2:hover,input[type="button"].style-2:hover,input[type="reset"].style-2:hover,input[type="submit"].style-2:hover,.button.style-2:hover ,select:focus ,.post-password-form input[type="submit"] ,.site-header .menu-toggle:hover,.site-header .menu-toggle:focus ,.site-header .menu-toggle.toggled-on:focus ,.comments-area .comments-pagination .page-numbers:hover,.comments-area .comments-pagination .page-numbers.current ,.search-form input:focus ,.pagination .nav-links .current ,.basr-pagination.number .page-numbers ,.basr-carousel.owl-theme .owl-nav .owl-prev:hover,.basr-carousel.owl-theme .owl-nav .owl-next:hover ,.blog-loop .sticky ,.post-thumb>a:after ,.post-thumb>a:hover:after ,.page-links>*:hover ,.page-links span:not(:first-child) ,.wpcf7-form .style-2 p .wpcf7-submit:hover ,.moonlight.tp-bullets .tp-bullet:after { border-color: ' . $color . ';}';
	$css .= 'hr ,.td-menu ul ul,.primary-navigation div.menu ul ul ,.td-menu .mega-menu,.primary-navigation div.menu .mega-menu { border-top-color: ' . $color . ';}';
	$css .= '.morphsearch-form input.morphsearch-input { border-bottom-color: ' . $color . ';}';
	return $css;
}

function origin_custom_shortcodes_color( $color ){
	$css = '';
	$css .= '.basr-heading .h span ,    .basr-filter.style-2 .nav-filter span.active ,.basr-page_nav .page-nav li a:hover ,.basr-blogs_listing .wrap-right-slider .wrap-nav .fake-next:hover,.basr-blogs_listing .wrap-right-slider .wrap-nav .fake-prev:hover ,.basr-banner h1 a:hover,.basr-banner h2 a:hover,.basr-banner h3 a:hover,.basr-banner h4 a:hover,.basr-banner h5 a:hover,.basr-banner h6 a:hover ,.basr-testimonial.style-3 .info .job ,.basr-testimonial.style-3 .info .social li:hover i:before ,.basr-twitter_timeline .tweet:hover .screen-name i,.basr-twitter_timeline .tweet:hover .screen-name h3 ,.basr-twitter_timeline .tweet-content a ,.basr-wc_listing .products .product .same-height .wrap-animation .collection-title a:hover ,.basr-product_slider .slick-banner .slick-prev,.basr-product_slider .slick-banner .slick-next { color: ' . $color . ';}';
	$css .= '.basr-blogs_listing.grid-2 .blog-loop .hentry:hover .post-thumb img ,.basr-member .wrap-inner:after ,.basr-testimonial:hover .info .avatar:after ,.basr-testimonial:hover .quote ,.basr-testimonial.style-3:hover .info .avatar:after ,.basr-product_slider .slick-banner .slick-prev,.basr-product_slider .slick-banner .slick-next { border-color: ' . $color . ';}';
	$css .= '.basr-heading.has-border.border-2 .h:after,.basr-heading.has-border.border-4 .h:after { border-bottom-color: ' . $color . ';}';
	$css .= '.basr-heading.has-border.border-3 .h:before,.basr-heading.has-border.border-5 .h:before ,.basr-filter:not(.style-2).active ,.basr-filter:not(.style-2) .button-filter:hover ,    .basr-filter.style-2:not(.active) ,.basr-filter.style-2 .nav-filter span:after,.basr-filter.style-2 .nav-filter span:before ,    .basr-filter.style-2 .button-filter:hover ,.basr-service .wrap-left-slider ,.basr-service .wrap-left-slider .wrap-nav .fake-next:hover ,.basr-page_nav .page-nav li a:after ,.basr-blogs_listing .wrap-right-slider ,.basr-blogs_listing .wrap-right-slider .post ,.basr-blogs_listing.grid-2 .blog-loop .hentry .wrap-content ,.basr-blogs_listing.grid-2 .blog-loop .hentry .wrap-content:after,.basr-blogs_listing.grid-2 .blog-loop .hentry .wrap-content:before ,.basr-icon_box.layout-2:before,.basr-icon_box.layout-2:after ,.basr-icon_box.layout-2 .extra-css:before,.basr-icon_box.layout-2 .extra-css:after ,.basr-icon_box.layout-3:hover,.basr-icon_box.layout-3.active ,.basr-icon_box.layout-3:hover:after,.basr-icon_box.layout-3.active:after ,.basr-icon_box.layout-3:hover:before,.basr-icon_box.layout-3.active:before ,.wrap-slick-nav-slider .basr-slick-nav-slider.noUi-horizontal .noUi-draggable ,.basr-testimonial:hover .quote ,.basr-testimonial.style-2:hover .quote ,.basr-testimonial.style-2 .info .avatar:before ,.basr-lightbox_video .icon ,.basr-product_slider .slick-banner .slick-prev:hover,.basr-product_slider .slick-banner .slick-next:hover { background-color: ' . $color . ';}';
	return $css;
}
function origin_custom_portfolio_color( $color ){
	$css = '';
	$css .= 'a.portfolio-link:hover ,.portfolio-listing .hentry .portfolio-content .title a:hover ,.portfolio-slider-1 .hentry .portfolio-content .title a:hover ,.portfolio-slider-2 .hentry .portfolio-content .portfolio-link:hover ,.portfolio-slider-3 .hentry .slick-fake-prev ,.portfolio-grid .hentry .portfolio-link:hover ,.portfolio-grid.hover-2 .hentry .portfolio-content .title a ,.portfolio-grid.hover-2 .hentry .portfolio-content .wrap-p-cat a:hover { color: ' . $color . ';}';
	$css .= '.portfolio-slider-2 .slick-slide .hidden-slide:after ,.portfolio-slider-2 .hentry:hover .portfolio-content ,    .portfolio-slider-2 .hentry.first-slide .portfolio-content ,.portfolio-grid.hover-1.no-border .hentry .portfolio-content ,.portfolio-grid.hover-1 .hentry:hover .portfolio-content ,.portfolio-grid.hover-2.no-border .hentry .portfolio-content ,.portfolio-grid.hover-2 .hentry:hover .portfolio-content ,.portfolio-grid.hover-3 .hentry:hover .open-photoswipe:before { border-color: ' . $color . ';}';
	$css .= '    .portfolio-slider-2 .hentry.first-slide .portfolio-content { border-top-color: ' . $color . ';}';
	$css .= '    .portfolio-slider-2 .hentry.first-slide .portfolio-content { border-bottom-color: ' . $color . ';}';
	$css .= '.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar ,.single-basr-portfolio .container .portfolio-wrap.style-3 .portfolio-content ,.single-basr-portfolio .container .portfolio-wrap.style-4 .portfolio-content .portfolio-info .portfolio-author,.single-basr-portfolio .container .portfolio-wrap.style-5 .portfolio-content .portfolio-info .portfolio-author ,.single-basr-portfolio .container .portfolio-wrap.style-4 .portfolio-content .portfolio-info .portfolio-author .author .avatar:before,.single-basr-portfolio .container .portfolio-wrap.style-5 .portfolio-content .portfolio-info .portfolio-author .author .avatar:before ,.portfolio-slider-3 .hentry .slick-fake-prev ,.portfolio-slider-3 .hentry .wrap-portfolio-content ,    .portfolio-slider-3 .hentry .wrap-portfolio-content ,.portfolio-grid.hover-4 .hentry .portfolio-content:hover:after,.portfolio-grid.hover-7 .hentry .portfolio-content:hover:after ,.cssload-cube { background-color: ' . $color . ';}';
	return $css;
}