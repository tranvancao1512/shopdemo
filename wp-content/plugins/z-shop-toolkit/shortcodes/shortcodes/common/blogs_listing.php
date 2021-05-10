<?php 

class toolkit_basr_shortcode_blogs_listing extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'blogs_listing';

	// this->base = $prefix + $shortcode;

	// Enqueue script, style

	public function enqueue_script ( $extra = array() ) {
		if ( is_singular() ) {
			
			global $post;

			if ( has_shortcode( $post->post_content, "{$this->base}" ) ) {
				parent::enqueue_script();
			}
		}

	}

	/*	Prefix for template loop blogs 
	
		moonlight_before_blog_loop_item_title	--  1**
		moonlight_blog_loop_item_title 			--  2**
		moonlight_after_blog_loop_item_title 	--  3**
		moonlight_blog_loop_item_excerpt	 	--  4**
		moonlight_after_blog_loop_item_excerpt	--  5**

	*/

	public function blog_array_function( $style = 'large' ) {
		$large = array(

			// moonlight_before_blog_loop_item_title	1**

			100 => 'basr_core_post_meta_thumbnail',

			// moonlight_blog_loop_item_title

			200 => 'ln_moonlight_post_meta_title',

			// moonlight_after_blog_loop_item_title		2**

			310 => 'ln_moonlight_post_meta_date',
			315 => 'ln_moonlight_post_meta_author',
			320 => 'ln_moonlight_post_meta_author',

			// moonlight_blog_loop_item_excerpt 		3**

			400 => 'ln_moonlight_post_meta_excerpt',

				// 'ln_moonlight_post_meta_categories'	=> 30,

			// moonlight_after_blog_loop_item_excerpt 	4**

			500 => 'ln_moonlight_post_meta_morelink',
		);

		$medium = array(

			// moonlight_before_blog_loop_item_title	1**

			110 => 'basr_core_post_meta_thumbnail',
			115 => 'ln_moonlight_div_wrap_group',
			116 => 'ln_moonlight_div_wrap_group',
			120 => 'ln_moonlight_post_meta_date',
			125 => 'ln_moonlight_post_meta_author',
			130 => 'ln_moonlight_post_meta_categories',

			// moonlight_blog_loop_item_title

			200 => 'ln_moonlight_post_meta_title',

			// moonlight_after_blog_loop_item_title		2**

			// moonlight_blog_loop_item_excerpt 		3**

			400 => 'ln_moonlight_post_meta_excerpt',

				// 'ln_moonlight_post_meta_categories'	=> 30,

			// moonlight_after_blog_loop_item_excerpt 	4**

			500 => 'ln_moonlight_post_meta_morelink',
			510 => 'ln_moonlight_end_div',
			520 => 'ln_moonlight_end_div',
		);

		$grid = array( 
			// moonlight_before_blog_loop_item_title	1**

			105 => 'ln_moonlight_div_wrap_group',
			110 => 'basr_core_post_meta_thumbnail',
			115 => 'ln_moonlight_div_wrap_group',

			// moonlight_blog_loop_item_title

			200 => 'ln_moonlight_post_meta_title',

			// moonlight_after_blog_loop_item_title		2**

			210 => 'ln_moonlight_post_meta_date',
			215 => 'ln_moonlight_post_meta_author',
			320 => 'ln_moonlight_post_meta_categories',

			// moonlight_blog_loop_item_excerpt 		3**

			400 => 'ln_moonlight_post_meta_excerpt',
			410 => 'ln_moonlight_post_meta_morelink',

				// 'ln_moonlight_post_meta_categories'	=> 30,

			// moonlight_after_blog_loop_item_excerpt 	4**
			515 => 'ln_moonlight_end_div',
			520 => 'ln_moonlight_end_div',
		);

		$slider = array( 
			// moonlight_before_blog_loop_item_title	1**

			// moonlight_blog_loop_item_title

			200 => array( 'ln_moonlight_post_meta_title', true ),

			// moonlight_after_blog_loop_item_title		2**

			310 => array( 'ln_moonlight_post_meta_date', false ),
			315 => array( 'ln_moonlight_post_meta_author', false),
			320 => array( 'ln_moonlight_post_meta_categories', false),

			// moonlight_blog_loop_item_excerpt 		3**

			400 => 'ln_moonlight_post_meta_excerpt',

				// 'ln_moonlight_post_meta_categories'	=> 30,

			// moonlight_after_blog_loop_item_excerpt 	4**

			500 => array( 'ln_moonlight_post_meta_morelink', true ),
		);

		if ( $style == 'masonry' || $style == 'grid-2' ) $style = 'grid';

		return ${$style};
	}

	// map shortcode to vc

	public function vc_map_shortcode() {
		vc_map( array(
			'base' 				=> $this->base,
			'name' 				=> esc_html__( 'Blogs listing', 'basr-core' ),
			'class' 			=> '',
			'category' 			=> $this->cat,
			'icon' 				=> $this->icon,
			'params' 			=> array(

				array(
                    'type' 			=> 'autocomplete',
                    'heading' 		=> __( 'Select Blog categories', 'basr-core' ),
                    'param_name'	=> 'cat_id',
                    'description' 	=> __( 'Input name to search', 'basr-core' ),
                    // There is autocomplete custom settings:
                    'settings' 		=> array(
                        'values' 	=> basr_core_get_term_list('category'),
                        'multiple'	=> true,
                    )
                ),

				array(
					'param_name'       => 'style',
					'heading'          => esc_html__( 'Style', 'basr-core' ),
					'type'             => 'dropdown',
					'value' => array(
						__( 'Large'  , 'basr-core' ) 	 	=> 'large',
						__( 'Grid'   , 'basr-core' )	 	 	=> 'grid',
						__( 'Grid 2' , 'basr-core' )	 	 	=> 'grid-2',
						__( 'Medium' , 'basr-core' ) 		=> 'medium',
						__( 'Masonry', 'basr-core' ) 	 	=> 'masonry',
						__( 'Slider', 'basr-core' ) 	 		=> 'slider',
					),
				),

				array(
					'param_name'       => 'columns',
					'heading'          => esc_html__( 'Style', 'basr-core' ),
					'type'             => 'dropdown',
					'value' => array(
						__( '2 columns'  , 'basr-core' ) 	 	=> 'columns-2',
						__( '3 columns'   , 'basr-core' )	 	=> 'columns-3',
						__( '4 columns ' , 'basr-core' ) 		=> 'columns-4',
					),
					'dependency'		=> array(
						'element'		=> 'style',
						'value'			=> array( 'grid', 'grid-2', 'masonry' ),
					),
				),

				array(
					'param_name'		=> 'limit',
					'heading'			=> esc_html__( 'Limit', 'basr-core' ),
					'type'				=> 'textfield',
				),

				array(
					'param_name' 		=> 'show_paged',
					'heading' 	 		=> esc_html__( 'Display pagination', 'basr-core' ),
					'type' 		 		=> 'dropdown',
					'value'      		=> array(
						esc_html__( 'hidden', 'basr-core' ) 	=> '',
						esc_html__( 'Show', 'basr-core' ) 	=> 'true',
					),
					// 'dependency'		=> array(
					// 	'element'		=> 'style',
					// 	'value'			=> array( 'portfolio-grid', 'portfolio-masonry', 'portfolio-free', 'portfolio-listing' ),
					// ),
				),

				array(
					'param_name' 		=> 'pagination_type',
					'heading' 	 		=> esc_html__( 'Type of pagination', 'basr-core' ),
					'type' 		 		=> 'dropdown',
					'edit_field_class'	=> 'vc_col-sm-6 mgt15',
					'value'      		=> array(
						esc_html__( 'Pagination number', 'basr-core' ) 	=> 'pagination_ajax',
						esc_html__( 'Infinite scroll', 'basr-core' ) 	=> 'pagination_infinite',
						esc_html__( 'Loadmore button', 'basr-core' ) 	=> 'pagination_button',
					),
					'dependency'		=> array(
						'element'		=> 'show_paged',
						'value'			=> array( 'true' ),
					),
				),
				array( 
					'param_name'	=> 'stop_after',
					'heading'		=> esc_html__( 'Times to stop infinite scroll', 'basr-core' ),
					'type'			=> 'textfield',
					'edit_field_class'	=> 'vc_col-sm-6 mgt15',
					'dependency'		=> array(
						'element'		=> 'pagination_type',
						'value'			=> array( 'pagination_infinite' ),
					),
				),

				array(
					'param_name'       => $this->base . '_id',
					'heading'          => esc_html__( 'ID', 'basr-core' ),
					'type'             => 'textfield',
					'value'            =>  0,
					'edit_field_class' => 'hidden',
				),
				toolkit_basr_vcf_class(),
				toolkit_basr_vcf_animate(0),
				toolkit_basr_vcf_animate(1),
				toolkit_basr_vcf_animate(2),
			),
		)
	);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {
		$this->enqueue_script();

		extract( shortcode_atts( array(
			$this->base . '_id' 				=> '',
			'cat_id'							=> '',
			'style'								=> 'large'		,
			'columns'							=> 'columns-2'	,
			'limit'								=> '-1'			,
			'show_paged'						=> '',
			'pagination_type'					=> 'pagination_ajax',
			'stop_after'						=> '',
			'classes'							=> ''			,
			'anm'								=> ''			,
			'anm_name'							=> ''			,
			'anm_delay'							=> ''			,
		), $atts ) );

		// get id 
		
		$id = ${$this->base . '_id'} ;

		// get class

		$classes .= $this->get_class( '', ' ' ); // pass id setting if need vc custome css class, 

		$classes .= ( 'slider' == $style ) ? ' slick-reverse-syn' : '';


		$image_size = '';

		switch ( $style ) {
			case 'grid':
				$image_size = 'ln-moonlight-blog-grid';
				break;
			case 'masonry':
				$image_size = 'ln-moonlight-blog-medium';
				break;
			case 'large':
				$image_size = 'ln-moonlight-blog-large';
				break;
			case 'medium':
				$image_size = 'ln-moonlight-blog-medium';
				break;
			case 'grid-2':
				$image_size = 'ln-moonlight-blog-grid-2';
				break;
		}


		if ( $style == 'grid-2' ) {
			$classes .= ' ' . $style;
		}

		// set up shortcode here

		$blog_style = array(
			'style' 	 => $style,
    		'grid'		 => array (
		        'column' => $columns
		    ),
    		'masonry' 	 => array (
		        'column' => $columns
		    ),
		);

		$hooks = $this->blog_array_function( $style );

		$args = array(
			'post_type'      => 'post',
			'cat'         	 => $cat_id,
			'posts_per_page' => intval( $limit ),
			'post_status'	 => 'publish',
		);

		$query = new WP_Query( $args );

		// setup pagination 

		if ( $show_paged ) {

			$pagination_stt = array(
				'query'           => json_encode( $args ),
				'max_paged'       => $query->max_num_pages,
				'pagination_type' => $pagination_type,
				'template'		  => 'blog-' . $style,
				'stop_after'	  => $stop_after,
				'data_extra'	  => json_encode( array() ),
			);
		}

		// Start out put

		$output  = '<div id="' . $id . '" class="' . $classes . '" ' . toolkit_basr_animation_data( $anm, $anm_name, $anm_delay ) . '>';

		switch ( $style ) {
			case 'slider':
				include 'blogs-listing/blogs_slider.php';
				break;
			case 'grid-2':
				include 'blogs-listing/blogs_grid_2.php';
				break;
			default:
				include 'blogs-listing/blogs_standard.php';
				break;
		}

		if ( $show_paged ) {

			ob_start();

			include( locate_template('templates/globals/basr-pagination.php') );

			$output .=  ob_get_clean();
		}

		$output .= '</div>';

		// filter 

		$output = apply_filters( "basr_{$this->base}_filter", $output );

		return $output;
	}

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 		=> ''			,
			'classes'					=> ''			,
			'align'						=> 'left'		,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css  = '';

		return $css;
	}

}
