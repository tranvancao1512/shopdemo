<?php
// l('size guide');
Class Tee_SizeGuide {
	public static $instance;
	public $size_guide;

	public static function get_instance()  {
        if ( !isset( self::$instance) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

	public function __construct() {
		add_action( 'init', [ $this, '_action_register_post_type' ] );
		add_action( 'before_wrap_variant_style', [ $this, 'print_size_guide' ] );
		add_action( 'wp_footer', [ $this, 'popup_size_guide' ] );
	}

	public function print_size_guide() {
		global $product;

		$this->size_guide = origin_get_post_meta( 'size_guide', $product->get_id() );

		$html = '';

		if( is_array( $this->size_guide ) && count( $this->size_guide ) ) {
			$html = '<span class="btn-size"><svg width="28" height="16" ><g fill="none" stroke="currentColor" stroke-miterlimit="10"><path d="M.5 6.5h18v6H.5z"></path><path stroke-linecap="square" d="M3.5 12.5v-3m3 3v-2m3 2v-3m6 3v-3m-3 3v-2"></path></g></svg>Size Chart</span>';
		}

		echo $html;

		return $html;
	}

	public function popup_size_guide(){
		if( is_array( $this->size_guide ) && count( $this->size_guide ) ) {
			$html = '<div class="popup-size">';
				$html .= '<span class="close"><svg focusable="false" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg></span>';
				$nav = '<div class="nav">';
				$content = '<div class="content">';
				$i = 0;
				$active = '';
				foreach( $this->size_guide as $key => $id ) {
					$active = $i == 0 ? ' active' : '';
					$nav     .= '<span class="n-' . $id . $active . '" data-id="' . $id . '">' . get_the_title( $id ) . '</span>';
					$content .= '<div class="c-' . $id . $active . '">' . get_the_content( null, false, $id ) . '</div>';
					$i++;
				}
				$nav .= '</div>';
				$content .= '</div>';
				$html .= count( $this->size_guide ) > 1 ? $nav . $content : $content;
			$html .= '</div>'; //.size-guider

			echo $html;
		}
	}

	public function _action_register_post_type() {
		$post_names = array(
			'singular' => __( 'Size Guide', 'basr-core' ),
			'plural'   => __( 'Size Guides', 'basr-core' ),
			'name'     => __( 'Size Guide', 'basr-core' ),
		);
		register_post_type(
			'size_guide',
			array(
				'labels'             => array(
					'name'               => $post_names['name'],
					'singular_name'      => $post_names['singular'],
					'add_new'            => __( 'Add New', 'basr-core' ),
					'add_new_item'       => sprintf( __( 'Add New %s', 'basr-core' ), $post_names['singular'] ),
					'edit'               => __( 'Edit', 'basr-core' ),
					'edit_item'          => sprintf( __( 'Edit %s', 'basr-core' ), $post_names['singular'] ),
					'new_item'           => sprintf( __( 'New %s', 'basr-core' ), $post_names['singular'] ),
					// 'all_items'          => sprintf( __( 'All %s', 'basr-core' ), $post_names['plural'] ),
					'all_items'          => $post_names['name'],
					'view'               => sprintf( __( 'View %s', 'basr-core' ), $post_names['singular'] ),
					'view_item'          => sprintf( __( 'View %s', 'basr-core' ), $post_names['singular'] ),
					'search_items'       => sprintf( __( 'Search %s', 'basr-core' ), $post_names['plural'] ),
					'not_found'          => sprintf( __( 'No %s Found', 'basr-core' ), $post_names['plural'] ),
					'not_found_in_trash' => sprintf( __( 'No %s Found In Trash', 'basr-core' ), $post_names['plural'] ),
					'parent_item_colon'  => '' /* text for parent types */
				),
				'description'        => __( 'Create ' . $post_names['singular'], 'basr-core' ),
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_rest'       => false,
				'publicly_queryable' => true,
				/* queries can be performed on the front end */
				'has_archive'        => false,
				// 'menu_icon'          => 'dashicons-grid-view',
				'hierarchical'       => true,
				'query_var'          => true,
				/* Sets the query_var key for this post type. Default: true - set to $post_type */
				'supports'           => array(
					'title' /* Text input field to create a post title. */,
					'editor',
					'excerpt',
					'thumbnail',
				),
				'capabilities' => array(
					'edit_post'            => 'edit_pages', 
					'read_post'            => 'edit_pages', 
					'delete_post'          => 'edit_pages', 
					'delete_posts'         => 'edit_pages', 
					'edit_posts'           => 'edit_pages', 
					'edit_published_posts' => 'edit_pages', 
					'edit_others_posts'    => 'edit_pages', 
					'publish_posts'        => 'edit_pages',       
					'read_private_posts'   => 'edit_pages', 
					'edit_private_posts'   => 'edit_pages', 
					'create_posts'         => 'edit_pages', 
				),
			) 
		);
	}
}

Tee_SizeGuide::get_instance();
