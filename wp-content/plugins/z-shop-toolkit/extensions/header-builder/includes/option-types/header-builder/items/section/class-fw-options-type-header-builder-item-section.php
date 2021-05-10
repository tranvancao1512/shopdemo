<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Option_Type_Header_Builder_Item_Section extends FW_Option_Type_Header_Builder_Item {
	private $parent = null;

	public function _init() {

		$this->parent = fw()->extensions->get( 'header-builder' );

		$this->set_options( array(
			'height'      => array(
				'type'  => 'text',
				'label' => __( 'Header height', 'lunar-core' ),
				'desc'  => __( 'Number only. Unit is px', 'lunar-core' ),
				'value' => '80',
			),
			'bg_color'    => array(
				'type'  => 'rgba-color-picker',
				'label' => __( 'Background Color', 'lunar-core' ),
				'value' => '#fff',
			),
			'bg_image'    => array(
				'type'  => 'upload',
				'label' => __( 'Background Image', 'lunar-core' ),
			),
			'bg_position' => array(
				'type'    => 'select',
				'label'   => __( 'Background Position', 'lunar-core' ),
				'value'   => '',
				'choices' => array(
					'none'       => __( 'None', 'lunar-core' ),
					'left-top'      => __( 'Left Top', 'lunar-core' ),
					'left-center'   => __( 'Left Center', 'lunar-core' ),
					'left-bottom'   => __( 'Left Bottom', 'lunar-core' ),
					'right-top'     => __( 'Right Top', 'lunar-core' ),
					'right-center'  => __( 'Right Center', 'lunar-core' ),
					'right-bottom'  => __( 'Right Bottom', 'lunar-core' ),
					'center-top'    => __( 'Center Top', 'lunar-core' ),
					'center-center' => __( 'Center Center', 'lunar-core' ),
					'center-bottom' => __( 'Center Bottom', 'lunar-core' ),
				),
			),
			'bg_repeat'   => array(
				'type'    => 'select',
				'label'   => __( 'Background Repeat', 'lunar-core' ),
				'choices' => array(
					'no-repeat' => __( 'No repeat', 'lunar-core' ),
					'repeat'    => __( 'Repeat', 'lunar-core' ),
					'repeat-x'  => __( 'Repeat X', 'lunar-core' ),
					'repeat-y'  => __( 'Repeat Y', 'lunar-core' ),
				),
			),
			'bg_size'     => array(
				'type'    => 'select',
				'label'   => __( 'Background Size', 'lunar-core' ),
				'choices' => array(
					'none' => __( 'None', 'lunar-core' ),
					'auto'    => __( 'Auto', 'lunar-core' ),
					'cover'   => __( 'Cover', 'lunar-core' ),
					'contain' => __( 'Contain', 'lunar-core' ),
				),
			),
			'stretch'     => array(
				'type'    => 'select',
				'label'   => __( 'Stretch Item', 'lunar-core' ),
				'choices' => array(
					'no'          => __( 'No stretch', 'lunar-core' ),
					'fullwidth'   => __( 'Full Width', 'lunar-core' ),
					'fullcontent' => __( 'Full Width with Content', 'lunar-core' ),
				),
				'value'   => 'fullwidth',
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
				'title'       => __( 'Section', 'lunar-core' ),
				'description' => __( 'Add header section', 'lunar-core' ),
				'tab'         => __( 'Content Elements', 'lunar-core' ),
				'html'        =>
					'<div class="item-type-icon-title">' .
					'    <div class="item-type-icon"><i class="ion-minus"></i></div>' .
					'    <div class="item-type-title">' . __( 'Section', 'lunar-core' ) . '</div>' .
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
			'header_builder_item_type_section',
			array(
				'l10n'     => array(
					'label'      => __( 'Section', 'lunar-core' ),
					'item_title' => __( 'Section Setting', 'lunar-core' ),
					'name'       => __( 'Section', 'lunar-core' ),
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

		return 'section';
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
			$classes[] = isset($item['options']['custom_class']) ? $item['options']['custom_class'] : '';
			$classes[] = 'stretch-' . $item['options']['stretch'];

			$class = implode( ' ', $classes );
		}

		return fw_render_view(
			$this->locate_path( '/views/view.php', dirname( __FILE__ ) . '/views/view.php' ),
			array(
				'type'     => $this->get_type(),
				'class'    => $class,
				'children' => $item['_items'],
				'options'  => $item['options'],
			)
		);
	}
}

FW_Option_Type_Builder::register_item_type( 'FW_Option_Type_Header_Builder_Item_Section' );