<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Header_Builder extends FW_Extension {

	private $post_type = 'header_builder';
	private $header_option_id = 'header-builder';

	/**
	 * @internal
	 */
	public function _init() {

		add_action( 'init', array( $this, '_action_register_post_type' ) );
		add_filter( 'fw_post_options', array( $this, '_filter_header_builder_options' ), 10, 2 );
	}

	/**
	 * @internal
	 */
	public function _action_register_post_type() {

		$post_names = array(
			'singular' => __( 'Header', 'lunar-core' ),
			'plural'   => __( 'Headers', 'lunar-core' ),
			'name'     => __( 'Header Builder', 'lunar-core' ),
		);
		register_post_type(
			$this->post_type,
			array(
				'labels'             => array(
					'name'               => $post_names['name'],
					'singular_name'      => $post_names['singular'],
					'add_new'            => __( 'Add New', 'lunar-core' ),
					'add_new_item'       => sprintf( __( 'Add New %s', 'lunar-core' ), $post_names['singular'] ),
					'edit'               => __( 'Edit', 'lunar-core' ),
					'edit_item'          => sprintf( __( 'Edit %s', 'lunar-core' ), $post_names['singular'] ),
					'new_item'           => sprintf( __( 'New %s', 'lunar-core' ), $post_names['singular'] ),
					'all_items'          => $post_names['name'],
					'view'               => sprintf( __( 'View %s', 'lunar-core' ), $post_names['singular'] ),
					'view_item'          => sprintf( __( 'View %s', 'lunar-core' ), $post_names['singular'] ),
					'search_items'       => sprintf( __( 'Search %s', 'lunar-core' ), $post_names['plural'] ),
					'not_found'          => sprintf( __( 'No %s Found', 'lunar-core' ), $post_names['plural'] ),
					'not_found_in_trash' => sprintf( __( 'No %s Found In Trash', 'lunar-core' ), $post_names['plural'] ),
					'parent_item_colon'  => '',
				),
				'public'             => false,
				'show_ui'            => true,
				'publicly_queryable' => false,
				'has_archive'        => false,
				'show_in_menu'       => 'basr-core-menu',
				'hierarchical'       => false,
				'query_var'          => true,
				'supports'           => array(
					'title',
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

	/**
	 * @param $post_options
	 * @param $post_type
	 *
	 * @return mixed
	 */
	public function _filter_header_builder_options( $post_options, $post_type ) {

		if ( $post_type !== $this->post_type ) {
			return $post_options;
		}
		$header_builder_options = apply_filters( 'header_builder_options',
			array(
				'instruction'     => array(
					'type'  => 'html',
					'label' => false,
					'html'  => __( 'Drag and drop items to build your header. All item must be placed inside Section item.', 'lunar-core' ),
				),
				'header_desktop'  => array(
					'type'    => 'tab',
					'title'   => __( 'Desktop', 'lunar-core' ),
					'options' => array(
						$this->header_option_id => array(
							'type'            => 'header-builder',
							'desc'            => false,
							'label'           => false,
							'fullscreen'      => false,
							'template_saving' => false,
							'history'         => true,
						),
						'_fixed'                => array(
							'type'         => 'switch',
							'value'        => 'no',
							'label'        => __( 'Fixed header?', 'lunar-core' ),
							'right-choice' => array(
								'value' => 'yes',
								'label' => __( 'Yes', 'lunar-core' ),
							),
							'left-choice'  => array(
								'value' => 'no',
								'label' => __( 'No', 'lunar-core' ),
							),
						),
						'_absolute'             => array(
							'type'         => 'switch',
							'value'        => 'no',
							'label'        => __( 'Absolute header?', 'lunar-core' ),
							'right-choice' => array(
								'value' => 'yes',
								'label' => __( 'Yes', 'lunar-core' ),
							),
							'left-choice'  => array(
								'value' => 'no',
								'label' => __( 'No', 'lunar-core' ),
							),
						),
						'_sticky_smart'         => array(
							'type'         => 'switch',
							'value'        => 'no',
							'label'        => __( 'Smart sticky?', 'lunar-core' ),
							'right-choice' => array(
								'value' => 'yes',
								'label' => __( 'On', 'lunar-core' ),
							),
							'left-choice'  => array(
								'value' => 'no',
								'label' => __( 'Off', 'lunar-core' ),
							),
							'desc'         => __( 'Turn ON to enable sticky menu, it will always stay in your page when scrolling to top and disappear when scrolling down.', 'lunar-core' ),
						),
					),
				),
				'header_settings' => array(
					'type'    => 'tab',
					'title'   => __( 'Settings', 'lunar-core' ),
					'options' => array(
						'_css' => array(
							'type'  => 'textarea',
							'label' => __( 'Custom CSS', 'lunar-core' ),
							'desc'  => __( 'Add class to section/item above then add custom style rules here.', 'lunar-core' ),
						),
					),
				),
			)
		);
		if ( empty( $header_builder_options ) ) {
			return $post_options;
		}
		if ( isset( $post_options['main'] ) && $post_options['main']['type'] === 'box' ) {
			$post_options['main']['options'][] = $header_builder_options;
		} else {
			$post_options['main'] = array(
				'title'   => __( 'Header Options' ),
				'desc'    => false,
				'type'    => 'box',
				'options' => $header_builder_options,
			);
		}

		return $post_options;
	}

	/**
	 * @param $inputs
	 *
	 * @return string
	 */
	public function render_header( $inputs ) {

		if ( ! is_array( $inputs ) ) {
			return '';
		}

		if ( empty( $inputs ) ) {
			return '';
		}

		ob_start();

		/**
		 * @var FW_Option_Type_Header_Builder $builder
		 */
		$builder = fw()->backend->option_type( 'header-builder' );
		echo $builder->render_items( $inputs, array() );

		return ob_get_clean();
	}


	/**
	 * @param $post_id
	 *
	 * @return string
	 */
	public function render( $post_id ) {

		if ( ! $this->is_header( $post_id ) ) {
			return '';
		}

		$options = fw_get_db_post_option( $post_id );

		$inputs = fw_get_db_post_option( $post_id, $this->get_name() );

		if ( ! is_array( $inputs ) ) {
			return '';
		}

		if ( ! isset( $inputs['json'] ) ) {
			return '';
		}

		$inputs = json_decode( $inputs['json'], true );

		if ( empty( $inputs ) ) {
			return '';
		}

		{
			$classes   = array();
			$classes[] = $this->header_option_id;

			if ( $options['_fixed'] === 'yes' ) {
				$classes[] = 'header-fixed';
			}

			if ( $options['_absolute'] === 'yes' ) {
				$classes   = array_diff( $classes, array( 'header-fixed' ) );
				$classes[] = 'header-absolute';
			}

			if ( $options['_sticky_smart'] === 'yes' ) {
				$classes   = array_diff( $classes, array( 'header-fixed' ) );
				$classes   = array_diff( $classes, array( 'header-absolute' ) );
				$classes[] = 'headroom';
			}
			$class[] = get_the_title( $post_id );

			$classes = implode( ' ', $classes );
		}
		{
			if ( $options['_sticky_smart'] === 'yes' ) {
				wp_enqueue_script( 'headroom' );
				wp_add_inline_script(
					'headroom',
					'
					var elem = document.getElementById(\'header-' . $post_id . '\');
					var headroom = new Headroom(elem, {	
						tolerance: {
							down: 10,
							up: 20
						},
						offset: 205
					});
					headroom.init();
					'
				);
			}
		}

		return fw_render_view(
			$this->locate_path( '/views/view.php', dirname( __FILE__ ) . '/views/view.php' ),
			array(
				'id'       => 'header-' . $post_id,
				'class'    => $classes,
				'inputs'   => $inputs,
				'options'  => $options,
			)
		);

	}

	/**
	 * @param int $post_id
	 *
	 * @return bool
	 */
	public function is_header( $post_id = null ) {

		if ( $post_id === 0 ) {
			return false;
		}

		if ( $post_id === null ) {
			global $post;
		} else {
			$post = get_post( (int) $post_id );
		}

		if ( empty( $post ) ) {
			return false;
		}

		if ( $post->post_type != $this->post_type ) {
			return false;
		}

		return true;
	}


}