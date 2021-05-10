<?php
class origin_Option_Type_Number extends FW_Option_Type
{
	public function get_type()
	{
		return 'number';
	}

	/**
	 * @internal
	 */
	protected function _enqueue_static($id, $option, $data)
	{
		$uri = get_template_directory_uri() .'/framework-customizations/option-types/'. $this->get_type() .'/static';

		wp_enqueue_script(
			'fw-option-'. $this->get_type(),
			$uri .'/js/scripts.js',
			array('fw-events', 'jquery')
		);
	}

	/**
	 * @internal
	 */
	protected function _render($id, $option, $data)
	{
		/**
		 * $data['value'] contains correct value returned by the _get_value_from_input()
		 * You decide how to use it in html
		 */
		$option['attr']['value'] = (string)$data['value'];

		/**
		 * $option['attr'] contains all attributes.
		 *
		 * Main (wrapper) option html element should have "id" and "class" attribute.
		 *
		 * All option types should have in main element the class "fw-option-type-{$type}".
		 * Every javascript and css in that option should use that class.
		 *
		 * Remaining attributes you can:
		 *  1. use them all in main element (if option itself has no input elements)
		 *  2. use them in input element (if option has input element that contains option value)
		 *
		 * In this case you will use second option.
		 */

		$wrapper_attr = array(
			'id'    => $option['attr']['id'],
			'class' => $option['attr']['class'],
		);

		unset(
			$option['attr']['id'],
			$option['attr']['class']
		);

		$html  = '<div '. fw_attr_to_html($wrapper_attr) .'>';
		$html .= '<input '. fw_attr_to_html($option['attr']) .' type="number" />';
		$html .= '</div>';

		return $html;
	}

	/**
	 * @internal
	 */
	protected function _get_value_from_input($option, $input_value)
	{
		/**
		 * In this method you receive $input_value (from form submit or whatever)
		 * and must return correct and safe value that will be stored in database.
		 *
		 * $input_value can be null.
		 * In this case you should return default value from $option['value']
		 */

		if (is_null($input_value)) {
			$input_value = $option['value'];
		}

		return (string)$input_value;
	}

	/**
	 * @internal
	 */
	protected function _get_defaults()
	{
		/**
		 * These are default parameters that will be merged with option array.
		 * They makes possible that any option has
		 * only one required parameter array('type' => 'number').
		 */

		return array(
			'value' => ''
		);
	}
}

FW_Option_Type::register('origin_Option_Type_Number');