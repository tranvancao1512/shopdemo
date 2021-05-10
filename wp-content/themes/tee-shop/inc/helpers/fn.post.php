<?php
/**
 * Single, Blogs helpers
 *
 * @package ln-moonlight
 * @since   1.0.0
 * @version 1.0.0
 */

/**
 * Don't access directly.
 */
defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

/**
 * Blogs help
 */

// help check if current loop post is in related section

if ( ! function_exists( 'origin_is_related_post' ) ) {
	function origin_is_related_post() {

		if ( ! is_single() ) return false;

		$queried_object = get_queried_object();
		
		if ( is_object( $queried_object) && $queried_object->ID != get_the_ID() ) 
			return true;
		else 
			return false;

	}
}

// loop start wraper

if ( ! function_exists( 'origin_blogs_loop_start' ) ) {
	function origin_blogs_loop_start( $blog_style = false ) { 

		$classes   = array();

		$classes[] = 'blog-loop';


		if ( defined('FW') ) {

			if ( ! $blog_style ) {
				if ( is_category() ) {
					$query = get_queried_object();
					$blog_style = origin_get_term_meta( 'blog_style', $query->taxonomy, $query->term_id );
				}
				if ( ! isset( $blog_style ) || $blog_style['style'] == 'default' ) {
					$blog_style = origin_get_setting( 'blog_style' );
				}
			}

			// sync for blog listing shortcode

			if ( in_array( $blog_style['style'], array( 'grid', 'masonry') ) ) {
				$column = $blog_style[ $blog_style['style'] ]['column'];
			}

			if ( is_page_template('page-templates/page-blog.php') ) {
				$blog_style['style'] 			= origin_get_post_meta( 'page_blog_style', get_the_ID() );
				if ( in_array( $blog_style['style'], array( 'grid', 'masonry') ) )  {
					$column = origin_get_post_meta( 'page_blog_column', get_the_ID() );
				}
			}

			$classes[]  = 'blog-' . $blog_style['style'];
			$classes[]  = 'basr-isotope';
			$classes[]  = ( in_array( $blog_style['style'], array( 'grid', 'masonry') ) ) ? $column . '' : '';
			$classes[]  = ( in_array( $blog_style['style'], array( 'masonry'		) ) ) ? 'masonry-layout' : '';
		} else {		
			$classes[]	= 'blog-large';
		}

		$classes = implode( ' ', $classes );

		$classes = apply_filters( 'origin_blog_loop_start_class', $classes );

		echo '<div class="' . esc_attr( $classes ) . '">';

	}
}


// loop start wraper

if ( ! function_exists( ' origin_blogs_loop_end' ) ) {
	function origin_blogs_loop_end() { 
		echo '</div>';
	}
}


/**
 * Single meta
 */

// post thumbnail

if ( ! function_exists( 'origin_post_meta_thumbnail' ) ) {
	function origin_post_meta_thumbnail() { 

		$format = get_post_format();

		if ( ! $format || origin_is_related_post() ) $format = 'image';

		get_template_part( 'templates/post/format/format', $format );
	}
}

// filter image size

if ( ! function_exists( 'origin_filter_single_thumb_size') ) {

	function origin_filter_single_thumb_size ( $size ) {

		// is_single return default size

		if( is_single() ) return $size;

		// blogs

		if ( defined( 'FW' ) ) {

			if ( is_category() ) {
				$query = get_queried_object();
				$blog_style = origin_get_term_meta( 'blog_style', $query->taxonomy, $query->term_id );
			}
			if ( ! isset( $blog_style ) || $blog_style['style'] == 'default' ) {
				$blog_style = origin_get_setting( 'blog_style' );
			}

			if ( is_page_template('page-templates/page-blog.php') ) {
				$blog_style = origin_get_post_meta( 'page_blog_style', get_the_ID() );
			}

			switch ( $blog_style['style'] ) {
				case 'masonry':
						$size = 'ln-moonlight-blog-masonry';
					break;
				case 'grid':
						$size = 'ln-moonlight-blog-grid';
					break;
				case 'medium':
						$size = 'ln-moonlight-blog-medium';
					break;
				default:
					// default is large 
					break;
			}
		}

		return $size;
	}
}

// post date

if ( ! function_exists( 'origin_post_meta_date' ) ) {
	function origin_post_meta_date( $format = 'd M Y' ) { 
		echo 	'<div class="post-date">' . 
					'<span>' . esc_html__('Posted ', 'origin') . '</span>' . 
					'<a href="' . get_permalink() . '">' .
						'<span>' . get_the_date( $format ) . '</span>' .
					'</a>' .
				'</div>';
	}
}

// post author

if ( ! function_exists( 'origin_post_meta_author' ) ) {
	function origin_post_meta_author() { 
		echo 	'<div class="post-author">' . '<span>' . esc_html__('by', 'origin') . '</span>' . 
					'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '"> ' . get_the_author() . '</a>' .  
				'</div>';
	}
}

// post categories

if ( ! function_exists( 'origin_post_meta_categories' ) ) {
	function origin_post_meta_categories() { 

		$categories_list = get_the_category_list( esc_html__( ', ', 'origin' ) );
		if ( $categories_list ) :
			echo '<div class="post-cat">';
			echo '<span>' . esc_html__('Categories : ', 'origin') . '</span>';
				printf( esc_html__( '%1$s', 'origin' ), $categories_list ) ;
			echo '</div>';
		endif;
	}
}

// post tags

if ( ! function_exists( 'origin_post_meta_tags' ) ) {
	function origin_post_meta_tags() { 

		the_tags( '<div class="post-tags"><span>Tags:</span>', '', '</div>' );  

	}
}

// post title 

if ( ! function_exists( 'origin_post_meta_title' ) ) {
	function origin_post_meta_title() { 

		if ( is_singular('product') ) return;

		$link_start = $link_end = '';

		$link_start = '<a href="' . get_permalink() . '">';
		$link_end   = '</a>';

		$tag 		= 'h2';

		if ( origin_is_related_post() ) {
			$tag = 'h4';
		}

		echo '<' . esc_html( $tag ) . ' class="post-title">' . $link_start;
				the_title();
		echo ( $link_end ) .'</' . esc_html( $tag ) . '>';
	}
}

// post excerpt 

if ( ! function_exists( 'origin_post_meta_excerpt' ) ) {
	function origin_post_meta_excerpt() { 

		echo '<div class="post-content">';

			if ( defined('FW') ) {

				$excerpt  = origin_get_setting('blog_content_or_excerpt');

				if ( 'excerpt' == $excerpt['display_type'] && get_the_excerpt() && get_post_format() != 'quote' ) {
					the_excerpt();
				} else {
					the_content();
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'origin' ),
						'after'  => '</div>',
					) );
				}
			} else {
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'origin' ),
					'after'  => '</div>',
				) );
			}

		echo '</div>';
	}
}

// post comments 

if ( ! function_exists( 'origin_post_meta_comments' ) ) {
	function origin_post_meta_comments() { 
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			echo '<span class="comments-link"><i class="fa fa-comments"></i>';
				comments_popup_link( esc_html__( 'No comments', 'origin' ), esc_html__( '1 Comment', 'origin' ), esc_html__( '% Comments', 'origin' ) ); 
			echo '</span>';
		endif;
	}
}

// more link


if ( ! function_exists( 'origin_filter_excerpt_length' ) ) {

	add_filter( 'the_excerpt', 'origin_filter_excerpt_length', 999 );

	function origin_filter_excerpt_length( $excerpt ) {

		$setting = origin_get_setting('blog_content_or_excerpt');
		$setting = ( isset( $setting['excerpt']['length'] ) ) ? $setting['excerpt']['length'] : 120;
		$excerpt = wp_trim_words( $excerpt, $setting, esc_html__( '...', 'origin' ) );

		return $excerpt;
	}
}

if ( ! function_exists( 'origin_post_meta_morelink' ) ) {
	function origin_post_meta_morelink( $excerpt = '' ) {
		if ( defined('FW') ) {
			if ( ! $excerpt ) {
				$excerpt = origin_get_setting( 'blog_content_or_excerpt');
			}
			if ( ! ( 'excerpt' == $excerpt['display_type'] && get_the_excerpt() && get_post_format() != 'quote' ) ) return '';
			echo '<a class="more-link button" href="' . get_permalink() . '">'. esc_html__( 'Read more', 'origin' ) . '</a>';
		} else {
			echo '';
		} 

	}
}

// social sharing

if ( ! function_exists( 'origin_social_sharing_html' ) ) {
	function origin_social_sharing_html( $title = '' ) {

		if( ! $title ) $title = esc_html__( 'Share:', 'origin' );

		echo '<div class="basr-wrap-social-sharing">';
			if ( $title ) echo '<label class="title">' . esc_html( $title ) . '</label>'; 
			get_template_part( 'templates/globals/social', 'sharing' );
		echo '</div>';
	}
}

// Social info 

// get social info 

if ( ! function_exists( 'origin_social_info' ) ) {

	function origin_social_info( $link_array = array() ) {

		$social_array = origin_get_setting('social_links');

		if( $link_array ) {
			$pattern = '/';
			foreach ( $social_array as $social => $link) {
				$pattern .= str_replace('_', '', $social ) . '|';
				$social_array[$social] = '';
			}

			$pattern .= '/';

			$pattern = str_replace( '|/', '/', $pattern );

			foreach ($link_array as $key => $link) {
				preg_match_all( $pattern, $link, $matches );
				if ( isset( $matches[0][0] ) ) {
					$social_array[ '_' . $matches[0][0] ] = $link;
				}
			}
		}

		$social_array = array_filter( (array) $social_array );

		?>
			<ul class="wrap-social-button social social-info">
				<?php foreach($social_array as $name => $link):
				$name = str_replace('_', '', $name);?>
					<li>
						<a target="_blank" href="<?php echo esc_url($link); ?>" class="<?php echo esc_url($name); ?>">
							<i class="fa fa-<?php echo esc_attr($name) ?>"></i>
						</a>
					</li>
				<?php endforeach; ?>		
			</ul>
		<?php 
	}

}



// author box

if( ! function_exists( 'origin_author_box' ) ) {
	function origin_author_box() {

		// return if description is empty 

		if ( ! get_the_author_meta('description') ) return;
		?>
		<div class="author-box">
			<?php printf(
				'<a class="avatar-wrap" href="%1$s" title="%2$s">%3$s</a>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author(),
				get_avatar( get_the_author_meta( 'user_email' ), 120 )
			); ?>
			<?php printf(
				'<a class="author-name" href="%1$s" title="%2$s">%3$s %2$s</a>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author(),
				esc_html__( '', 'origin' )
			); ?>
			<?php printf(
				'<p class="author-desc">%s</p>',
				esc_html( get_the_author_meta('description') )
			);
			?>
		</div>
		<?php
	}
}

// fucntion open wrap 

if ( ! function_exists( 'origin_div_wrap_group' ) ) {
	function origin_div_wrap_group() { 

		echo '<div class="basr-group-wrap">';

	}
}

// fn help end div

if ( ! function_exists( 'origin_end_div' ) ) {
	function origin_end_div() { 

		echo '</div>';

	}
}

// blog large style 

if ( ! function_exists( 'origin_blog_large_style') ) {
	function origin_blog_large_style() {

		$blogs  = array(
			'blog_author'		=> 'yes',
			'blog_post_date'	=> 'yes',
			'blog_categories'	=> 'yes',
			'blog_readmore'		=> 'yes',
		);

		if ( defined('FW') ) {
			$blogs = origin_get_setting( $blogs );
		}

		// before blog loop item title

		add_action( 'origin_before_blog_loop_item_title', 'origin_post_meta_thumbnail', 10 );

		// after blog loop item title

		if ( $blogs['blog_author'] ) {
			add_action( 'origin_after_blog_loop_item_title', 'origin_post_meta_author', 10 );
		}

		if ( $blogs['blog_post_date'] ) {
			add_action( 'origin_after_blog_loop_item_title', 'origin_post_meta_date' , 15 );
		}

		if ( $blogs['blog_categories'] ) {
			add_action( 'origin_after_blog_loop_item_title', 'origin_post_meta_categories', 20 );
		}

		// after blog loop item excertpt

		if ( $blogs['blog_readmore'] ) {
			add_action( 'origin_after_blog_loop_item_excerpt', 'origin_post_meta_morelink', 10 );
		}
	}
}

// usualy use for grid & masonry

if ( ! function_exists( 'origin_blog_grid_style') ) {
	function origin_blog_grid_style() {

		$blogs  = array(
			'blog_author'		=> 'yes',
			'blog_post_date'	=> 'yes',
			'blog_categories'	=> 'yes',
			'blog_readmore'		=> 'yes',
		);

		if ( defined('FW') ) {
			$blogs = origin_get_setting( $blogs );
		}

		// before blog loop item title
		add_action( 'origin_before_blog_loop_item_title', 'origin_div_wrap_group'		, 5 );
		add_action( 'origin_before_blog_loop_item_title', 'origin_post_meta_thumbnail'	, 10 );
		add_action( 'origin_before_blog_loop_item_title', 'origin_div_wrap_group'		, 15 );

		// after blog loop item title

		if ( $blogs['blog_author'] ) {
			add_action( 'origin_after_blog_loop_item_title', 'origin_post_meta_author', 10 );
		}

		if ( $blogs['blog_post_date'] ) {
			add_action( 'origin_after_blog_loop_item_title', 'origin_post_meta_date' , 15 );
		}

		if ( $blogs['blog_categories'] ) {
			add_action( 'origin_after_blog_loop_item_title', 'origin_post_meta_categories', 20 );
		}

		// after blog loop item excertpt

		if ( $blogs['blog_readmore'] ) {
			add_action( 'origin_after_blog_loop_item_excerpt', 'origin_post_meta_morelink', 10 );
		}

		add_action( 'origin_after_blog_loop_item_excerpt', 'origin_end_div'				  , 15 );  // for origin_before_blog_loop_item_title, 15
		add_action( 'origin_after_blog_loop_item_excerpt', 'origin_end_div'				  , 20 );  // for origin_before_blog_loop_item_title, 5
	}
}

// blog masonry 

if ( ! function_exists( 'origin_blog_masonry_style') ) {
	function origin_blog_masonry_style() {

		$blogs  = array(
			'blog_author'		=> 'yes',
			'blog_post_date'	=> 'yes',
			'blog_categories'	=> 'yes',
			'blog_readmore'		=> 'yes',
		);

		if ( defined('FW') ) {
			$blogs = origin_get_setting( $blogs );
		}


		

		// before blog loop item title
		add_action( 'origin_before_blog_loop_item_title', 'origin_div_wrap_group'		, 5 );
		add_action( 'origin_before_blog_loop_item_title', 'origin_post_meta_thumbnail'	, 10 );
		if ( $blogs['blog_post_date'] ) {
			add_action( 'origin_before_blog_loop_item_title', 'origin_post_meta_date' 	, 15 );
		}
		if ( $blogs['blog_author'] ) {
			add_action( 'origin_before_blog_loop_item_title', 'origin_post_meta_author' , 20 );
		}
		add_action( 'origin_before_blog_loop_item_title', 'origin_div_wrap_group'		, 25 );

		// after blog loop item title

		if ( $blogs['blog_categories'] ) {
			add_action( 'origin_after_blog_loop_item_title', 'origin_post_meta_categories', 20 );
		}

		// after blog loop item excertpt

		if ( $blogs['blog_readmore'] ) {
			add_action( 'origin_after_blog_loop_item_excerpt', 'origin_post_meta_morelink', 10 );
		}

		add_action( 'origin_after_blog_loop_item_excerpt', 'origin_end_div'				  , 15 );  // for origin_before_blog_loop_item_title, 15
		add_action( 'origin_after_blog_loop_item_excerpt', 'origin_end_div'				  , 20 );  // for origin_before_blog_loop_item_title, 5
	}
}


// Blog medium

if ( ! function_exists( 'origin_blog_medium_style') ) {
	function origin_blog_medium_style() {

		$blogs  = array(
			'blog_author'		=> 'yes',
			'blog_post_date'	=> 'yes',
			'blog_categories'	=> 'yes',
			'blog_readmore'		=> 'yes',
		);

		if ( defined('FW') ) {
			$blogs = origin_get_setting( $blogs );
		}

		// before blog loop item title

		add_action( 'origin_before_blog_loop_item_title', 'origin_post_meta_thumbnail', 10 );

		add_action( 'origin_before_blog_loop_item_title', 'origin_div_wrap_group'	    , 15 );
		add_action( 'origin_before_blog_loop_item_title', 'origin_div_wrap_group'	    , 16 );

		if ( $blogs['blog_post_date'] ) {
			add_action( 'origin_before_blog_loop_item_title', 'origin_post_meta_date' , 20 );
		}

		if ( $blogs['blog_author'] ) {
			add_action( 'origin_before_blog_loop_item_title', 'origin_post_meta_author', 25 );
		}

		if ( $blogs['blog_categories'] ) {
			add_action( 'origin_before_blog_loop_item_title', 'origin_post_meta_categories', 30 );
		}

		// after blog loop item excertpt

		if ( $blogs['blog_readmore'] ) {
			add_action( 'origin_after_blog_loop_item_excerpt', 'origin_post_meta_morelink', 10 );
		}

		add_action( 'origin_after_blog_loop_item_excerpt', 'origin_end_div', 15 );
		add_action( 'origin_after_blog_loop_item_excerpt', 'origin_end_div', 16 );
	}
}


