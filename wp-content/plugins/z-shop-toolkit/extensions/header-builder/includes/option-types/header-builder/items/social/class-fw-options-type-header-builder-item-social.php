<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Option_Type_Header_Builder_Item_Social extends FW_Option_Type_Header_Builder_Item {
	private $parent = null;

	public function _init() {

		$this->parent = fw()->extensions->get( 'header-builder' );
		
		$array_social = basr_core_get_setting( 'social_links' );
		
		$social_stt   = array( 'social_list' => array(
							'type'    => 'multi',
							'inner-options' => array(),
						));

		foreach ($array_social as $key => $value) {
			if ( $value ) {
				$social_stt['social_list']['inner-options'][$key] = array(
										'type'  => 'switch',
										'value' => 'yes',
										'label' => esc_html__( str_replace( '_', '', $key ) , 'origin'),
										'right-choice' => array(
											'value' => 'yes',
											'label' => esc_html__('Show', 'origin'),
										),
										'left-choice' => array(
											'value' => '',
											'label' => esc_html__('Hide', 'origin'),
										),
									);
			}
		}

		$this->set_options( $social_stt );
	}

	/**
	 * The item type
	 * @return string
	 */
	public function get_type() {
		return 'social';
	}

	/**
	 * The boxes that appear on top of the builder and can be dragged down or clicked to create items
	 * @return array
	 */
	public function get_thumbnails() {
		return array(
			array(
				'title'       => __( 'Social', 'lunar-core' ),
				'description' => __( 'Add header social', 'lunar-core' ),
				'tab'         => __( 'Content Elements', 'lunar-core' ),
				'html' =>
					'<div class="item-type-icon-title">'.
					'    <div class="item-type-icon"><i class="ion-image"></i></div>'.
					'    <div class="item-type-title">'. __('Social', 'lunar-core' ) .'</div>'.
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
			array('fw-events'),
			$this->parent->manifest->get_version()
		);

		wp_enqueue_style( 'font-awesome' );

		wp_localize_script(
			'header-builder-' . $this->get_builder_type() . '-item-' . $this->get_type(),
			'header_builder_item_type_social',
			array(
				'l10n'     => array(
					'label'      => __( 'Label', 'lunar-core' ),
					'item_title' => __( 'Social Setting', 'lunar-core' ),
					'name'       => __( 'Social', 'lunar-core' ),
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

	public function get_value_from_attributes( $attributes ) {
		return $attributes;
	}

	public function render( array $item, $input_value ) {
		// prepare attributes
		{
			$classes = array();
			$classes[] = $item['shortcode'];
			$classes[] = 'header-builder-type-' . $this->get_type();
			$classes[] = 'header-elems';

			$class = implode(' ', $classes);
		}

		return fw_render_view(
			$this->locate_path( '/views/view.php', dirname( __FILE__ ) . '/views/view.php' ),
			array(
				'item' => $item,
				'options'   => $item['options'],
				'class'     => $class,
				'type'      => $this->get_type(),
			)
		);
	}
}
FW_Option_Type_Builder::register_item_type('FW_Option_Type_Header_Builder_Item_Social');