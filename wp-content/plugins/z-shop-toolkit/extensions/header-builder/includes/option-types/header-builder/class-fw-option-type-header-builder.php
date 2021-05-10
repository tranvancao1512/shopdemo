<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Option_Type_Header_Builder extends FW_Option_Type_Builder {
	private $parent;
	/*
	 * @internal
	 */
	public function get_type() {
		return 'header-builder';
	}

	/*
	 * @internal
	 */
	public function _init() {
		$this->parent = fw()->extensions->get( 'header-builder' );
		$dir          = dirname( __FILE__ );
		require $dir . '/extends/class-fw-option-type-header-builder-item.php';
		require $dir . '/items/header-builder-items.php';
	}

	/**
	 * @param FW_Option_Type_Builder_Item $item_type_instance
	 *
	 * @return bool
	 */
	protected function item_type_is_valid( $item_type_instance ) {
		return is_subclass_of( $item_type_instance, 'FW_Option_Type_Header_Builder_Item' );
	}
	/*
	 * Sorts the tabs so that the layout tab comes first
	 */
	protected function sort_thumbnails(&$thumbnails)
	{
		uksort($thumbnails, array($this, 'sort_thumbnails_helper'));
	}

	private function sort_thumbnails_helper($tab1, $tab2)
	{
		$content_tab = __('Content Elements', 'header-toolkit' );
		if ($tab1 === $content_tab) {
			return 1;
		} elseif ($tab2 === $content_tab) {
			return -1;
		}

		return strcasecmp($tab1, $tab2);
	}
	/**
	 * @internal
	 */
	protected function _enqueue_static( $id, $option, $data ) {
		parent::_enqueue_static( $id, $option, $data );

		wp_enqueue_script(
			'header-builder-' . $this->get_type(),
			$this->parent->get_declared_URI( '/includes/option-types/' . $this->get_type() . '/static/js/helpers.js' ),
			array( 'fw' ),
			fw()->manifest->get_version(),
			true
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_value_from_items( $items ) {
		if ( ! is_array( $items ) ) {
			return array();
		}

		static $recursion_level = 0;

		/** prevent duplicate shortcodes */
		static $found_shortcodes = array();

		/**
		 * @var FW_Option_Type_Builder_Item[] $item_types
		 */
		$item_types = $this->get_item_types();

		$fixed_items = array();

		foreach ( $items as $item_attributes ) {
			if ( ! isset( $item_attributes['type'] ) || ! isset( $item_types[ $item_attributes['type'] ] ) ) {
				// invalid item type
				continue;
			}

			$fixed_item_attributes = $item_types[ $item_attributes['type'] ]->get_value_from_attributes( $item_attributes );

			// check if required attribute is set and it is unique
			{
				if (
					empty( $fixed_item_attributes['shortcode'] )
					||
					isset( $found_shortcodes[ $fixed_item_attributes['shortcode'] ] )
				) {
					$fixed_item_attributes['shortcode'] = sanitize_key(
						str_replace( '-', '_', $item_attributes['type'] ) . '_' . substr( fw_rand_md5(), 0, 7 )
					);
				}

				$found_shortcodes[ $fixed_item_attributes['shortcode'] ] = true;
			}

			if ( isset( $fixed_item_attributes['_items'] ) ) {
				// item leaved _items key, this means that it has/accepts items in it

				$recursion_level ++;

				$fixed_item_attributes['_items'] = $this->get_value_from_items( $fixed_item_attributes['_items'] );

				$recursion_level --;
			}

			$fixed_items[] = $fixed_item_attributes;

			unset( $fixed_item_attributes );
		}

		/**
		 * this will be real return (not inside a recursion)
		 * make some clean up
		 */
		if ( ! $recursion_level ) {
			$found_shortcodes = array();
		}

		return $fixed_items;
	}

	/**
	 * Render items
	 *
	 * This method can be used recursive by items that has another items inside
	 *
	 * @param array $items
	 * @param array $input_values
	 *
	 * @return string
	 */
	public function render_items( array $items, array $input_values ) {
		/**
		 * @var FW_Option_Type_Header_Builder_Item[] $item_types
		 */
		$item_types = $this->get_item_types();

		$html = '';

		foreach ( $items as $key => $item ) {
			if ( ! isset( $item_types[ $item['type'] ] ) ) {
				trigger_error( 'Invalid form item type: ' . $item['type'], E_USER_WARNING );
				continue;
			}

			$input_value = isset( $input_values[ $item['shortcode'] ] ) ? $input_values[ $item['shortcode'] ] : null;

			$item['number'] = ++ $key;

			$html .= $item_types[ $item['type'] ]->render( $item, $input_value );
		}

		return $html;
	}

}
FW_Option_Type::register('FW_Option_Type_Header_Builder');
