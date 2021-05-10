<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Option_Type_Header_Builder_Item_Nav extends FW_Option_Type_Header_Builder_Item {
	private $parent = null;

	public function _init() {

		$this->parent = fw()->extensions->get( 'header-builder' );

		$this->set_options( array(
			'menu'         => array(
				'type'    => 'select',
				'label'   => __( 'Choose menu', 'lunar-core' ),
				'desc'    => __( 'Choose menu to display on frontend. The selected menu will not shown in preview.', 'lunar-core' ),
				'choices' => builder_menu_choices(),
				'value'   => 'none',
			),
			'custom_style' => array(
				'type'         => 'multi-picker',
				'label'        => false,
				'desc'         => false,
				'value'        => array(
					'style' => 'default',
				),
				'picker'       => array(
					'style' => array(
						'label'        => __( 'Custom styling for this menu?', 'lunar-core' ),
						'type'         => 'switch',
						'left-choice'  => array(
							'value' => 'default',
							'label' => __( 'No', 'lunar-core' ),
						),
						'right-choice' => array(
							'value' => 'custom',
							'label' => __( 'Yes', 'lunar-core' ),
						),
					),
				),
				'choices'      => array(
					'custom' => array(
						'nav_text_transform'      => array(
							'type'    => 'select',
							'label'   => __( 'Text Transform', 'lunar-core' ),
							'choices' => array(
								'none'                  => __( 'None', 'lunar-core' ),
								'lowercase'             => __( 'Lowercase', 'lunar-core' ),
								'uppercase'             => __( 'Uppercase', 'lunar-core' ),
								'uppercase-first-level' => __( 'Uppercase for first level only', 'lunar-core' ),
								'capitalize'            => __( 'Capitalize', 'lunar-core' ),
							),
						),
						'nav_item_typo'           => array(
							'type'       => 'typography-v2',
							'value'      => array(
								'size'           => 14,
								'letter-spacing' => 0,
							),
							'components' => array(
								'family'         => false,
								'size'           => true,
								'line-height'    => false,
								'letter-spacing' => true,
								'color'          => false,
							),
							'label'      => __( 'Nav Item Typography', 'lunar-core' ),
						),
						'nav_item_font_weight'    => array(
							'label'   => __( 'Nav Item Font Weight', 'lunar-core' ),
							'type'    => 'select',
							'value'   => '400',
							'choices' => array( '100', '200', '300', '400', '500', '600', '700', '800', '900' ),
						),
						'nav_item_color'          => array(
							'type'  => 'color-picker',
							'label' => __( 'Nav Item Color', 'lunar-core' ),
							'value' => basr_core_get_setting( 'color-heading' ),
						),
						'nav_item_color_hover'    => array(
							'type'  => 'color-picker',
							'label' => __( 'Nav Item Color Hover', 'lunar-core' ),
							'value' => basr_core_get_setting( 'color-main' ),
						),
						'nav_subitem_typo'        => array(
							'type'       => 'typography-v2',
							'value'      => array(
								'size'           => 14,
								'letter-spacing' => 0,
							),
							'components' => array(
								'family'         => false,
								'size'           => true,
								'line-height'    => false,
								'letter-spacing' => true,
								'color'          => false,
							),
							'label'      => __( 'Nav Sub Item Typography', 'lunar-core' ),
						),
						'nav_subitem_font_weight' => array(
							'label'   => __( 'Nav Sub Item Font Weight', 'lunar-core' ),
							'type'    => 'select',
							'value'   => '400',
							'choices' => array( '100', '200', '300', '400', '500', '600', '700', '800', '900' ),
						),
						'nav_subitem_color'       => array(
							'type'  => 'color-picker',
							'label' => __( 'Nav Sub Item Color', 'lunar-core' ),
							'value' => basr_core_get_setting( 'color-heading' ),
						),
						'nav_subitem_color_hover' => array(
							'type'  => 'color-picker',
							'label' => __( 'Nav Sub Item Color Hover', 'lunar-core' ),
							'value' => basr_core_get_setting( 'color-main' ),
						),
					),
				),
				'show_borders' => false,
			),
			'center_el'    => array(
				'type'  => 'checkbox',
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
				'title'       => __( 'Navigation', 'lunar-core' ),
				'description' => __( 'Add menu', 'lunar-core' ),
				'tab'         => __( 'Content Elements', 'lunar-core' ),
				'html'        =>
					'<div class="item-type-icon-title">' .
					'    <div class="item-type-icon"><i class="ion-ios-barcode-outline"></i></div>' .
					'    <div class="item-type-title">' . __( 'Navigation', 'lunar-core' ) . '</div>' .
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
			'header_builder_item_type_nav',
			array(
				'l10n'     => array(
					'label'      => __( 'Label', 'lunar-core' ),
					'item_title' => __( 'Nav Setting', 'lunar-core' ),
					'name'       => __( 'Nav', 'lunar-core' ),
					'edit'       => __( 'Edit', 'lunar-core' ),
					'helptext'   => __( 'Please choose a menu', 'lunar-core' ),
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

		return 'nav';
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
			$classes[] = $item['options']['center_el'] ? 'center-el' : '';

			$class = implode( ' ', $classes );
		}

		return fw_render_view(
			$this->locate_path( '/views/view.php', dirname( __FILE__ ) . '/views/view.php' ),
			array(
				'menu'  => $item['options']['menu'],
				'class' => $class,
				'type'  => $this->get_type(),
			)
		);
	}
}

FW_Option_Type_Builder::register_item_type( 'FW_Option_Type_Header_Builder_Item_Nav' );
