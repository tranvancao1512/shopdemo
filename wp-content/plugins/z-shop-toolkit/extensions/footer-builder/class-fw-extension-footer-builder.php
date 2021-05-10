<?php if (!defined('FW')) die('Forbidden');

class FW_Extension_Footer_Builder extends FW_Extension {

	private $post_type = 'footer_builder';
	private $footer_option_id = 'footer-builder';

	/**
	 * @internal
	 */
	public function _init() {
		if ( true ) {
			add_action( 'init', array( $this, '_action_register_post_type' ) );
			add_filter( 'fw_post_options', array( $this, '_filter_fw_post_options' ), 10, 2 );
		}
	}

	/**
	 * @internal
	 */
	public function _action_register_post_type() {
		$post_names = array(
			'singular' => __( 'Footer', 'basr-core' ),
			'plural'   => __( 'Footers', 'basr-core' ),
			'name'     => __( 'Footer Builder', 'basr-core' ),
		);
		register_post_type(
			$this->post_type,
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
				'description'        => __( 'Create a footer item', 'basr-core' ),
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'publicly_queryable' => true,
				/* queries can be performed on the front end */
				'has_archive'        => false,
				'menu_position'      => 5,
				'show_in_rest' 		 => true,
				'show_in_menu'       => 'basr-core-menu',
				// 'menu_icon'          => 'dashicons-grid-view',
				'hierarchical'       => true,
				'query_var'          => true,
				/* Sets the query_var key for this post type. Default: true - set to $post_type */
				'supports'           => array(
					'title' /* Text input field to create a post title. */,
					'editor',
				),
				'capabilities'       => array(
					'edit_post'              => 'edit_pages',
					'read_post'              => 'edit_pages',
					'delete_post'            => 'edit_pages',
					'edit_posts'             => 'edit_pages',
					'edit_others_posts'      => 'edit_pages',
					'publish_posts'          => 'edit_pages',
					'read_private_posts'     => 'edit_pages',
					'read'                   => 'edit_pages',
					'delete_posts'           => 'edit_pages',
					'delete_private_posts'   => 'edit_pages',
					'delete_published_posts' => 'edit_pages',
					'delete_others_posts'    => 'edit_pages',
					'edit_private_posts'     => 'edit_pages',
					'edit_published_posts'   => 'edit_pages',
				),
			) 
		);
	}

	public function _filter_fw_post_options(  $post_options, $post_type ) {

		if ( $post_type != $this->post_type ) return $post_options;

		$options = $this->get_post_options( $this->post_type );

		if ( count( $options ) ) {
			$post_options['main'] = array(
				'title'   => false,
				'desc'    => false,
				'type'    => 'box',
				'options' => $options,
			);
		}

		return $post_options;

	}

	public function render( $post_id) {

		if ( ! ( get_post_type( $post_id ) == 'footer_builder' ) ) {
			return '';
		}

		return fw_render_view(
			$this->locate_path( '/views/view-vc.php', dirname( __FILE__ ) . '/views/view-vc.php' ),
			array(
				'post_id' 		=> $post_id,
			)
		);

	}
}
