<?php
/**
 * Register actions for using in Moonlight theme.
 *
 * @package ln-moonlight
 ** @since Ln Moonlight 1.0.0
 */

/**
 * TGM Plugin Activation
 */
require get_parent_theme_file_path( '/inc/actions/register-tgmpa-plugins.php' );

if ( defined( 'FW' ) ) {
	/**
	 * Custom Option types for Unyson
	 */
	function origin_action_add_custom_option_type() {

		// require_once get_template_directory() . '/framework-customizations/option-types/number/class-fw-option-type-number.php';
		require_once get_template_directory() . '/framework-customizations/option-types/td-slider/class-fw-option-type-td-slider.php';
	}

	add_action( 'fw_option_types_init', 'origin_action_add_custom_option_type' );
}

function origin_action_save_single_post( $post_id ) {

	if ( ! defined( 'FW' ) ) return;

	$post_type =  get_post_type( $post_id );

	if ( 'post' == $post_type ) {

		$css = '';

		$video_stt  = origin_get_post_meta( 'post_format_video', get_the_ID() );
		
		$post_css = get_option( 'origin_post_css', '' );

		if ( get_post_format() == 'video' && $video_stt['link']['video_thumb'] && has_post_thumbnail() ) {
			$css 	= '.post-' . $post_id . ' .basr-video:before {' .
						'background-image: url(' . get_the_post_thumbnail_url() . ');' .
					'}';
		}

		if( preg_match( '/\.post-' . $post_id . '/', $post_css ) ) {
			$post_css  = preg_replace( '/\.post-' . $post_id . '[^}]+}/' , $css, $post_css );
		} else {
			$post_css .= $css;
		}

		update_option( 'origin_post_css', $post_css  );
	}

}
add_action( 'save_post', 'origin_action_save_single_post' );


/**
 * Hook Favicon
 */

function origin_action_theme_favicon() {
	if( function_exists('has_site_icon') && has_site_icon() ) {
		return;
	}
	$favicon = origin_get_setting('general_favicon');
	if( !empty( $favicon ) ) :
		?>
		<link rel="icon" type="image/png" href="<?php echo esc_url($favicon['url']); ?>">
	<?php endif;
}
add_action( 'wp_head', 'origin_action_theme_favicon' );


/**
 * Hook Morphsearch wp_footer
 */

function origin_action_theme_morphsearch() {
	?>
	<div id="morphsearch" class="morphsearch">
		<form role="search" method="get" class="morphsearch-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" class="morphsearch-input" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'origin' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
			<button type="submit" class="search-submit morphsearch-submit"><i class="fa fa-search"></i></button>
		</form>
		<span class="morphsearch-close"></span>
	</div><!-- /morphsearch -->
<?php
}
// add_action('wp_footer', 'origin_action_theme_morphsearch', 5 );

/**
 * Hook titlebar into origin_after_header action.
 */
function origin_action_render_title_bar() {

	get_template_part( 'templates/title-bar/title', 'bar' );
}

add_action( 'origin_after_header', 'origin_action_render_title_bar', 10 );

/**
 * Hook default header into origin_header action.
 */
function origin_action_default_header() {

	// simple layout for mobile 

	$detector = Agent::get_instance();

	if( $detector->isPhone() === true ) :
		// optimize for iphone, samsamng phone 
		// lf( origin_get_setting( 'logo' ) );
		$logo_src = origin_get_setting( 'site_logo' );

		$mm =   '<div id="mobile-menu" class="mobile-menu">' . 
					'<div class="logo"><a href="' . home_url('/') . '"><img class="logo-mm lazy" data-src="' . $logo_src . '"></a></div>';
		if( function_exists('get_product_search_form') ) : 
			$mm .= '<div class="mm-search">' .
						get_product_search_form( false ) .
						'<span class="trigger-search"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg></span>' .
					'</div>'; // .mm-search
		endif;
		$mm .=  '</div>'; // mobile menu

		// fixed mm 

		$mm .=  '<div class="fixed-mm">' . 
					'<div class="mm-menu">' .
						'<span class="close"><svg viewBox="0 0 24 24" width="30" height="30" preserveAspectRatio="xMidYMid meet" focusable="false"><g><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path></g></svg></span>' .
						'<span class="open"><svg viewBox="0 0 24 24" width="30" height="30"><g><path d="M3 18h6v-2H3v2zM3 6v2h18V6H3zm0 7h12v-2H3v2z"></path><path d="M0 0h24v24H0z" fill="none"></path></g></svg></span>' .
		 			'</div>';

		 	$mm .= '<div class="logo"><a href="' . home_url('/') . '"><img class="logo-mm lazy" data-src="' . $logo_src . '"></a></div>';

			$mm .= 	'<div class="mm-cart">';
				if ( class_exists( 'WooCommerce' ) ) : 
					$mm .=  '<a href="' . wc_get_cart_url() . '">' .
								'<div class="cart-icon item">' .
									'<svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-cart" width="20" viewBox="0 0 37 40"><path fill="#fff" d="M36.5 34.8L33.3 8h-5.9C26.7 3.9 23 .8 18.5.8S10.3 3.9 9.6 8H3.7L.5 34.8c-.2 1.5.4 2.4.9 3 .5.5 1.4 1.2 3.1 1.2h28c1.3 0 2.4-.4 3.1-1.3.7-.7 1-1.8.9-2.9zm-18-30c2.2 0 4.1 1.4 4.7 3.2h-9.5c.7-1.9 2.6-3.2 4.8-3.2zM4.5 35l2.8-23h2.2v3c0 1.1.9 2 2 2s2-.9 2-2v-3h10v3c0 1.1.9 2 2 2s2-.9 2-2v-3h2.2l2.8 23h-28z"></path></svg>' . 
									'<span class="cart-counter-wrapper">' .
										'<span class="cart-counter">' .
											WC()->cart->get_cart_contents_count() . 
										'</span>' .
										'<span>items</span>' .
										'<span class="total"> - <span class="wrap-total">' . WC()->cart->get_cart_total() . '</span></span>' .
									'</span>' .
								'</div>' .
							'</a>';
				endif;
			$mm .= '</div>'; // .mm-cart 

			if( class_exists( 'WooCommerce' ) && is_cart() ) {
				$mm .= '<div class="goto-checkout"><a href="' . wc_get_checkout_url() . '">Go to Checkout</a></div>';
			}

		$mm .= '</div>'; //fixed-mm

		echo $mm;

		return true;
	endif; // isPhone

	$header_id = function_exists('header_builder_get_current_header') ? header_builder_get_current_header() : '';

	if ( $header_id ) {
		$current_header = header_builder_get_current_header();
		echo header_builder_get_header_html( $header_id );
	} else {
		get_template_part( 'templates/header/header', 'default' );
	}

}

add_action( 'origin_header', 'origin_action_default_header', 10 );

/**
 * Hook default footer into origin_footer action.
 */
function origin_action_default_footer() {

	$footer_template_id    = function_exists( 'footer_builder_get_current_footer' ) ? footer_builder_get_current_footer() : '';
	
	if ( $footer_template_id ) {
		echo footer_builder_get_footer( $footer_template_id );
	} else {
		get_template_part( 'templates/footer/footer', 'default' );
	}

}

// default menu for mobile 

add_action( 'origin_footer', 'tee_shop_fixed_mobile_header' );

function tee_shop_fixed_mobile_header() {
	$detector = Agent::get_instance();
	if( $detector->isPhone() === true ) {

		$logo = origin_get_setting( 'logo' );
		$logo_src = '';
		$logo_src = $logo['_logo']['img']['logo_img']['url'];

		$menu = wp_nav_menu( [ 'menu_class' => 'mm-nav', 'echo' => false, 'theme_location' => 'mobile'] );

		$logo =  '<div class="logo"><img class="logo-mm lazy" data-src="' . $logo_src . '"></div>';
		$mm   =   '<div id="mm-popup" class="mm-popup">' . 
					$menu . 
				'</div>';
		echo $mm;
	}
}

add_action( 'origin_footer', 'origin_action_default_footer', 10 );

function origin_action_mobile_menu() { ?>
	<nav id="mobile-menu" class="st-menu mobile-menu st-effect-1">

		<!-- Top bar mobile menu -->

		<div class="top-bar-mm">

			<div class="logo">
				<?php echo wp_kses_post( origin_get_setting_logo_html() ); ?>
			</div>  <!-- .logo -->

			<?php if ( origin_get_setting('mm_info') ) : ?>

				<div class="detail-info">
					<?php echo wp_kses_post( origin_get_setting( 'mm_info' ) );?>
				</div>

			<?php endif; ?>

		</div> <!-- .top-bar-mm -->

		<!-- mobile menu  -->

		<?php
			wp_nav_menu( array(
					'theme_location' => 'mobile',
					'container_class' => 'm-menu',
				)
			);

			origin_social_info();
		?>
	</nav>
	<?php
}

// add_action( 'origin_footer', 'origin_action_mobile_menu', 15 );

/*
 * Hook blogs style
 */
add_action( 'origin_blog_loop_item_title', 'origin_post_meta_title', 10 );
add_action( 'origin_blog_loop_item_excerpt', 'origin_post_meta_excerpt', 10 );

if ( ! function_exists( 'origin_action_blogs_style' ) ) {

	add_action( 'wp_head', 'origin_action_blogs_style' );

	function origin_action_blogs_style() {

		$blogs = array(
			'style'	=> 'large',
		);

		if ( defined( 'FW' ) ) {

			$blogs = origin_get_setting( 'blog_style' );

			if ( is_category() ) {
				$query = get_queried_object();
				$blogs = origin_get_term_meta( 'blog_style', $query->taxonomy, $query->term_id );
			}

			if ( is_page_template('page-templates/page-blog.php') ) {
				$blogs['style'] = origin_get_post_meta( 'page_blog_style', get_the_ID() );
			}
		}

		switch ( $blogs['style'] ) {
			case 'grid':
				origin_blog_grid_style();
				break;
			case 'masonry':
				origin_blog_masonry_style();
				break;
			case 'medium':
				origin_blog_medium_style();
				break;
			default:
				origin_blog_large_style();
				break;
		}

	}
}

/**
 * Single hook.
 */

if ( ! function_exists( 'origin_action_single_post_hook' ) ) {

	add_action( 'wp_head', 'origin_action_single_post_hook' );

	function origin_action_single_post_hook() {

		// after title  

		if ( is_singular('product') ) return;

		add_action( 'origin_after_single_post_title', 'origin_post_meta_thumbnail'		, 10 );
		add_action( 'origin_after_single_post_title', 'origin_post_meta_date'  			, 15 );
		add_action( 'origin_after_single_post_title', 'origin_post_meta_author'			, 20 );
		add_action( 'origin_after_single_post_title', 'origin_post_meta_categories'  		, 25 );

		// after content 
		add_action( 'origin_after_single_post_content', 'origin_div_wrap_group'		, 5 );
		add_action( 'origin_after_single_post_content', 'origin_post_meta_tags'		, 10 );
		add_action( 'origin_after_single_post_content', 'origin_social_sharing_html'	, 20 );
		add_action( 'origin_after_single_post_content', 'origin_end_div'				, 25 );
		add_action( 'origin_after_single_post_content', 'origin_author_box'			, 30 );

	}
}

/**
 * Related hook.
 */

if ( ! function_exists( 'origin_action_post_related_hook' ) ) {

	add_action( 'wp_head', 'origin_action_post_related_hook' );

	function origin_action_post_related_hook() {

		// before post related 

		add_action( 'origin_before_post_related_title', 'origin_post_meta_thumbnail', 10 );

		// after post related  
		add_action( 'origin_after_post_related_title', 'origin_post_meta_author', 10 );
		add_action( 'origin_after_post_related_title', 'origin_post_meta_date', 20 );
		add_action( 'origin_after_post_related_title', 'origin_post_meta_categories', 30 );

	}
}

/**
 * Comment form hook
 */


if ( ! function_exists( 'origin_comment_reply_avatar') ) {

	function origin_comment_reply_avatar() {

		if ( is_user_logged_in() ) {
			$id = get_current_user_id();

			echo get_avatar( $id, 40, 'mystery' );
		}
	}

}

add_action( 'comment_form_top', 'origin_comment_reply_avatar' );

/**
 *  After pagination 
 */



if ( !function_exists( 'origin_after_pagination' ) ) {
	add_action( 'origin_after_pagination', 'origin_after_pagination' ) ;
	function origin_after_pagination() {
		$loader = '<div class="cssload-spinner" style="display: none">
							<div class="cssload-cube cssload-cube0"></div>
							<div class="cssload-cube cssload-cube1"></div>
							<div class="cssload-cube cssload-cube2"></div>
							<div class="cssload-cube cssload-cube3"></div>
							<div class="cssload-cube cssload-cube4"></div>
							<div class="cssload-cube cssload-cube5"></div>
							<div class="cssload-cube cssload-cube6"></div>
							<div class="cssload-cube cssload-cube7"></div>
							<div class="cssload-cube cssload-cube8"></div>
							<div class="cssload-cube cssload-cube9"></div>
							<div class="cssload-cube cssload-cube10"></div>
							<div class="cssload-cube cssload-cube11"></div>
							<div class="cssload-cube cssload-cube12"></div>
							<div class="cssload-cube cssload-cube13"></div>
							<div class="cssload-cube cssload-cube14"></div>
							<div class="cssload-cube cssload-cube15"></div>
						</div>';
		echo $loader;
	}
}

add_action( 'wp_head', 'insert_general_code_head' );

function insert_general_code_head() {
	$code = trim( origin_get_setting( 'general_code_head' ) );
	if( $code ) {
		echo $code;
	}
}

