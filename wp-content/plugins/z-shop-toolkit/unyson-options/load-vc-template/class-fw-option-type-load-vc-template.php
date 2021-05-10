<?php 

class FW_Option_Type_Load_Vc_Template extends FW_Option_Type
{
    public function get_type()
    {
        return 'load-vc-template';
    }

    /**
     * @internal
     */
    protected function _enqueue_static($id, $option, $data)
    {
        $uri = BASR_CORE_PLUGIN_URL .'unyson-options/'. $this->get_type() .'/static';

        wp_enqueue_style(
            'fw-option-'. $this->get_type().'-style',
            $uri .'/css/style.css'
        );
        wp_enqueue_script(
            'fw-option-'. $this->get_type().'-js',
            $uri .'/js/script.js',
            array( 'jquery', 'fw-events',), 
            true
        );

        fw()->backend->option_type( 'multi-select' )->enqueue_static();
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

        if ( $option['inner_options']['templates']['template-type'] != 'export' ) {
            $option['inner_options']['templates']['choices'] = call_user_func( 'basr_core_template_name_' . $option['inner_options']['templates']['template-type'] );
        }
       

        $wrapper_attr = array(
            'id'        => $option['attr']['id'],
            'class'     => $option['attr']['class'],
            'data-type' => $option['inner_options']['templates']['template-type'],
        );

        unset(
            $option['attr']['id'],
            $option['attr']['class']
        );

        $multi_select_data = array (
            'id_prefix' => 'fw-option-',
            'name_prefix' => 'fw_options',
            'value' => array()
        );

        $html  = '<div '. fw_attr_to_html($wrapper_attr) .'>';
        if ( $option['inner_options']['templates']['template-type'] != 'export' ) {
            $html .= fw()->backend->option_type( 'multi-select' )->render( 'load-template', $option['inner_options']['templates'], $multi_select_data );
            $html .= '<button type="button" class="button basr-load-template" style="margin-top: 15px">'. __('Create New Page and load template', 'basr-core') .'</button>' . 
                '<a class="button loader" style="border: none;box-shadow:none;background: transparent;margin-top: 15px;"></a>';
            $html .= '<div class="template-load-popup"></div>';
        } else {
            $html .= '<button type="button" class="button basr-export-template" style="margin-top: 15px">'. __('Export data template', 'basr-core') .'</button>' . '<a class="button loader" style="border: none;box-shadow:none;background: transparent;margin-top: 15px;"></a>';
        }
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
         * only one required parameter array('type' => 'new').
         */

        return array(
            'value' => ''
        );
    }
}

FW_Option_Type::register('FW_Option_Type_Load_Vc_Template');

include 'data-template.php';
include 'hooks.php';

