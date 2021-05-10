<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Option_Type_Header_Builder_Item_Wishlist extends FW_Option_Type_Header_Builder_Item {
	private $parent = null;

	public function _init() {

		$this->parent = fw()->extensions->get( 'header-builder' );
		
		$this->set_options( array(
			'font_size'        => array(
				'type'  => 'text',
				'label' => __( 'Font Size', 'lunar-core' ),
				'value' => '18',
				'attr'  => array(
					'type' => 'number',
				),
			),
			'item_color'       => array(
				'type'  => 'color-picker',
				'label' => __( 'Icon Color', 'lunar-core' ),
				'value' => basr_core_get_setting( 'color-heading' ),
			),
			'item_color_hover' => array(
				'type'  => 'color-picker',
				'label' => __( 'Icon Color Hover', 'lunar-core' ),
				'value' => basr_core_get_setting( 'color-main' ),
			),
		) );
	}

	/**
	 * The boxes that appear on top of the builder and can be dragged down or clicked to create items
	 *
	 * @return array
	 */
	public function get_thumbnails() {

		return array(
			array(
				'title'       => __( 'Wishlist', 'lunar-core' ),
				'description' => __( 'Wishlist icon', 'lunar-core' ),
				'tab'         => __( 'Content Elements', 'lunar-core' ),
				'html'        =>
					'<div class="item-type-icon-title">' .
					'    <div class="item-type-icon"><i class="ion-ios-heart"></i></div>' .
					'    <div class="item-type-title">' . __( 'Wishlist', 'lunar-core' ) . '</div>' .
					'</div>',
			),
		);
	}

	/**
	 * Enqueue item type scripts and styles
	 */
	public function enqueue_static() {

		wp_enqueue_script(
			'header-builder-' . $this->get_builder_type() . '-item-' . $this->get_type(),
			$this->parent->get_declared_URI( '/includes/option-types/' . $this->get_builder_type() . '/items/' . $this->get_type() . '/static/js/scripts.js' ),
			array( 'fw-events' ),
			$this->parent->manifest->get_version()
		);

		wp_localize_script(
			'header-builder-' . $this->get_builder_type() . '-item-' . $this->get_type(),
			'header_builder_item_type_wishlist',
			array(
				'l10n'     => array(
					'label'      => __( 'Label', 'lunar-core' ),
					'item_title' => __( 'Wishlist Setting', 'lunar-core' ),
					'name'       => __( 'Wishlist', 'lunar-core' ),
					'edit'       => __( 'Edit', 'lunar-core' ),
					'delete'     => __( 'Delete', 'lunar-core' ),
					'duplicate'  => __( 'Duplicate', 'lunar-core' ),
				),
				'options'  => $this->get_options(),
				'defaults' => array(
					'type'    => $this->get_type(),
					'options' => fw_get_options_values_from_input( $this->get_options(), array() ),
				),
			)
		);

		fw()->backend->enqueue_options_static( $this->get_options() );
	}

	/**
	 * The item type
	 *
	 * @return string
	 */
	public function get_type() {

		return 'wishlist';
	}

	public function get_value_from_attributes( $attributes ) {

		return $attributes;
	}

	public function render( array $item, $input_value ) {

		// prepare attributes
		{
			$classes   = array();
			$classes[] = $item['shortcode'];
			$classes[] = 'header-builder-type-' . $this->get_type();
			$classes[] = $this->get_type();
			$classes[] = 'header-elems';

			$class = implode( ' ', $classes );
		}

		return fw_render_view(
			$this->locate_path( '/views/view.php', dirname( __FILE__ ) . '/views/view.php' ),
			array(
				'class'   => $class,
				'type'    => $this->get_type(),
			)
		);
	}
}

FW_Option_Type_Builder::register_item_type( 'FW_Option_Type_Header_Builder_Item_Wishlist' );