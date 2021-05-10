<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Extend this class to create items for form-builder option type
 */
abstract class FW_Option_Type_Header_Builder_Item extends FW_Option_Type_Builder_Item {

	private $options = array(
		'header-specific-options' => array(),
		'header-general-options'  => array(),
	);

	final public function get_builder_type() {
		return 'header-builder';
	}

	/**
	 * Render item html for frontend form
	 *
	 * @param array $item Attributes from Backbone JSON
	 * @param mixed|null $input_value
	 *
	 * @return string HTML
	 */
	abstract public function render( array $item, $input_value );

	/**
	 * Return item options that was set before using set_options() method,
	 * The options will be merged with default items options: Question and Percentage mark
	 *
	 * @return array
	 */
	final public function get_options() {
		$this->options['header-general-options'] = array(
			'type'    => 'group',
			'options' => array()
		);

		if ( empty( $this->options['header-specific-options'] ) ) {
			unset( $this->options['header-specific-options'] );
		}

		return $this->options;
	}

	/**
	 * Set item options
	 *
	 * @param array $options
	 */
	protected function set_options( array $options ) {
		if ( ! empty( $options ) ) {
			$this->options['header-specific-options'] = array(
				'type'    => 'group',
				'options' => $options
			);
		}
	}

	/**
	 * Search relative path in '/extensions/header-builder/includes/option-types/{builder_type}/items/{item_type}/'
	 *
	 * @param string $rel_path
	 * @param string $default_path Used if no path found
	 *
	 * @return false|string
	 */
	final protected function locate_path( $rel_path, $default_path ) {
		if ( $path = fw()->extensions->get( 'header-builder' )->locate_path( '/' . $this->get_builder_type() . '/items/' . $this->get_type() . $rel_path ) ) {
			return $path;
		} else {
			return $default_path;
		}
	}

	/**
	 * Validate the header item
	 *
	 * @param array $item
	 *
	 * @return bool
	 */
	public function validate_item( $item ) {
		return true;
	}
}
