<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Option_Type_Header_Builder_Item_HTML extends FW_Option_Type_Header_Builder_Item {
	private $parent = null;

	public function _init() {

		$this->parent = fw()->extensions->get( 'header-builder' );

		$this->set_options( array(
			'html' => array(
				'type'  => 'textarea',
				'label' => __( 'HTML', 'lunar-core' ),
			),
			'center_el' => array(
				'type' => 'checkbox',
				'label' => __( 'Make this element center', 'lunar-core' ),
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
				'title'       => __( 'HTML', 'lunar-core' ),
				'description' => __( 'Add header html', 'lunar-core' ),
				'tab'         => __( 'Content Elements', 'lunar-core' ),
				'html'        =>
					'<div class="item-type-icon-title">' .
					'    <div class="item-type-icon"><i class="ion-code-working"></i></div>' .
					'    <div class="item-type-title">' . __( 'HTML', 'lunar-core' ) . '</div>' .
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
			'header_builder_item_type_html',
			array(
				'l10n'     => array(
					'label'       => __( 'Label', 'lunar-core' ),
					'item_title'  => __( 'HTML Setting', 'lunar-core' ),
					'name'        => __( 'HTML', 'lunar-core' ),
					'edit'        => __( 'Edit', 'lunar-core' ),
					'delete'      => __( 'Delete', 'lunar-core' ),
					'duplicate'   => __( 'Duplicate', 'lunar-core' ),
					'placeholder' => __( 'Place some HTML code here!', 'lunar-core' ),
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

		return 'html';
	}

	public function get_value_from_attributes( $attributes ) {

		return $attributes;
	}

	public function render( array $item, $input_value ) {

		// prepare attributes
		{
			$classes   = array();
			$classes[] = $item['shortcode'];
			$classes[] = isset($item['options']['custom_class']) ? $item['options']['custom_class'] : '';
			$classes[] = 'header-builder-type-' . $this->get_type();
			$classes[] = 'header-elems';
			$classes[] = $item['options']['center_el'] ? 'center-el' : '';

			$class = implode( ' ', $classes );
		}

		return fw_render_view(
			$this->locate_path( '/views/view.php', dirname( __FILE__ ) . '/views/view.php' ),
			array(
				'html'  => $item['options']['html'],
				'class' => $class,
				'type'  => $this->get_type(),
			)
		);
	}
}

FW_Option_Type_Builder::register_item_type( 'FW_Option_Type_Header_Builder_Item_HTML' );