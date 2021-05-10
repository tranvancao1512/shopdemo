<?php 

/**
 * @version    1.0
 * @package    Toolkit toolkit
 * @author     earththeme
 * @copyright  Copyright (C) 2016 lunartheme.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.lunartheme.com
 */

/**
 * Class add shortcode and register to vc 
 * 
 * @since    1.0
 */

class toolkit_basr_shortcode {

	protected 		$prefix    		= '' ;

	public    		$shortcode 		= ''								;

	public    		$base 			= ''								;	

	public  		$metakey 		= ''								;

	public 			$cat 			= ''								;

	public 			$icon 			= 'basr-shortcode-icon '			;

	public 			$animation		= ''								;

	public 			$container		= ''								;

	// init

	public function __construct( $cat = '', $icon = '' ){

		if ( $this->shortcode != '' ) :
			$this->prefix =  BASR_CORE . '_'					;

			$this->base 	= $this->prefix . $this->shortcode;

			$this->metakey 	=  '_' . $this->base . '_custom_css';

			// set cat and icon
			$this->icon 	.= toolkit_basr_listing_shortcode()[$this->shortcode]['icon'];
			$this->cat 		= toolkit_basr_vc_cat();

			add_action( 'save_post'		, array( $this, 'update_post' 	)			    );

			if ( class_exists('VC_Manager') && is_admin() ) {
				add_action( 'init'		, array( $this, 'vc_map_shortcode' 	), 9999 );
			}

			add_shortcode( $this->base, array( $this, 'generate_html') );

			add_filter( 'basr-shortcode-inline-css'	, array(    &$this					, 'add_inline_css'   )        );
			add_action( 'wp_head'                   , array( 	'toolkit_basr_shortcode', 'print_inline_css' ), 99999 );
			add_action( 'wp_enqueue_scripts'		, array(    $this 					, 'register_script'	 )		  );
			add_action( 'wp_enqueue_scripts'		, array(    $this 					, 'enqueue_script'	 )		  );

			if ( $this->container ) {
				if ( class_exists('VC_Manager') && is_admin() ) {

					$extends = 'class WPBakeryShortCode_' . $this->base . ' extends WPBakeryShortCodesContainer {}';

					eval( $extends );

				}
			}

		endif;

	}


	// register shortcode to vc 

	public function vc_map_shortcode() {
		// map short code 
		vc_map( array(

			)
		);
	}

	// build  css

	public function build_custom_css( $post_id ) {
		$post = get_post( $post_id );

		$css = apply_filters( 'build_custom_css', $this->parseShortcodesCustomCss( $post->post_content ) );

		return $css;
	}

	// parse custom css

	protected function parseShortcodesCustomCss( $content ) {
		$css = '';
		if ( class_exists('WPBMap') ) WPBMap::addAllMappedShortcodes();
		preg_match_all( '/' . get_shortcode_regex() . '/', $content , $shortcodes );
		foreach ( $shortcodes[2] as $index => $tag ) {
			if ( $tag == $this->base ) :
				$attr_array  = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
				$css 		.= $this->generate_shortcode_css( $attr_array );
			endif;
		}
		foreach ( $shortcodes[5] as $shortcode_content ) {
			$css .= $this->parseShortcodesCustomCss( $shortcode_content );
		}
		return $css;
	}


	// save custom css to post 

	public function update_post( $post_id ){
		if ( ! isset( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		$post = $this->replace_post( $post_id );

		if ( $post ) {	

			$this->save_post( $post );

			$custom_css = $this->build_custom_css( $post_id );

			$this->save_postmeta( $post_id, $custom_css );

		}

	}


	// regenerate shortcode id

	public function replace_post( $post_id ) {
		$post = get_post( $post_id );
		if ( $post ) {

			if ( has_shortcode( $post->post_content, "{$this->base}" ) ) {
				if ( ! function_exists( 'shortcode_replace_id_callback' ) ) {
					function shortcode_replace_id_callback( $matches ) {
						// Generate a random string to use as element ID.
						$id = 'basr_' . mt_rand();

						return $matches[1] . '="' . $id . '"';
					}
				}

				$post->post_content = preg_replace_callback(
					'/(' . $this->base . '_id)="[^"]+"/',
					'shortcode_replace_id_callback',
					$post->post_content
				);
			}
		}

		return $post;
	}

	public function save_postmeta( $post_id, $css ) {
		if ( $post_id && $this->metakey ) {
			if ( empty( $css ) ) {
				delete_post_meta( $post_id, $this->metakey );
			} else {
				update_post_meta( $post_id, $this->metakey, preg_replace( '/[\t\r\n]/', '', $css ) );
			}
		}	
	}

	public function save_post( $post ) {
		// Sanitize post data for inserting into database.
		// $data = sanitize_post( $post, 'db' );
		$data = $post;
		// Update post content.
		global $wpdb;

		$wpdb->query( "UPDATE {$wpdb->posts} SET post_content = '" . esc_sql( $data->post_content ) . "' WHERE ID = {$data->ID};" );

		// Update post cache.
		$data = sanitize_post( $post, 'raw' );

		wp_cache_replace( $data->ID, $data, 'posts' );

	}

	/**
	 * Add custom inline CSS.
	 *
	 * @param   array  $inline_css  Array of inline CSS.
	 *
	 * @return  array
	 */

	public function add_inline_css( $inline_css ) {

		// page shortcode custom css

		if ( is_singular() && ! empty( $this->metakey ) && $post_id = get_the_ID() ) {
			$post_custom_css = get_post_meta( $post_id, $this->metakey, true );

			$inline_css[] = $post_custom_css;
		}

		// footer shortcode custom css 

		if ( function_exists( 'footer_builder_get_current_footer') ) :

			$post_id 		 = footer_builder_get_current_footer();
			$post_custom_css = get_post_meta( $post_id, $this->metakey, true );

			$inline_css[]    = $post_custom_css;
			
		endif;

		return $inline_css;
	}

	/**
	 * Print custom inline CSS.
	 *
	 * @return  void
	 */

	public static function print_inline_css() {
		// Get all custom inline CSS.
		$inline_css = apply_filters( 'basr-shortcode-inline-css', array() );

		if ( count( $inline_css ) ) {
			echo '<style id="basr-custom-shortcode" type="text/css">' . trim( implode( ' ', $inline_css ) ) . "</style>\n";
		}
	}

	/**
	 * Register script
	 *
	 * @return  void
	 */

	public function register_script () {

	}

	/**
	 * Enqueue script
	 *
	 * @return  void
	 */

	public function enqueue_script ( $extra = array() ) {
		// wp_enqueue_style( 'basr-shortcode');
		// wp_enqueue_script('basr-shortcode');
	}

	// generate class 

	public function get_class( $settings = '', $str_classes = '' ) {

		$classes 	  = ' basr-' . $this->shortcode;

		if ( function_exists('vc_shortcode_custom_css_class') ) {
			$classes .= vc_shortcode_custom_css_class( $settings, '' );
		}

		if ( isset( $animation ) && $animation ) {
			$classes .= ' animated';
		}

		$classes 	 .=	' ' . $str_classes;

		return $classes;
	} 


	// generate shortcode html

	public function generate_html( $atts, $content = null ) {

		return '';

	}

	// generate custom css

	public function generate_shortcode_css( $atts ) {
		$css = '';
		return $css;
	}

	/**
	 * return data of animation name and animation delay 
	 *
	 * @return  void
	 */

	public function animation_data( $atts ) {
		if ( isset( $this->animation ) && $this->animation )  {
			extract( $atts );
			if ( isset( $anm ) && $anm ) {
				return ' data-animation="' . $anm_name . '"' . ' data-animation-delay="' . $anm_delay . '"';
			}
		} // if $animation
	}

}
	