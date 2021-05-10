<?php if (!defined('FW')) die('Forbidden');

function origin_filter_ext_sidebars_add_conditional_tag($data) {
	$data['is_archive_page_slug'] = array(
		'order_option' => 2, // (optional: default is 1) position in the 'Others' lists in backend
		'check_priority' => 'last', // (optional: default is last, can be changed to 'first') use it to change priority checking conditional tag
		'name' => esc_html__('Shop Page', 'origin'), //conditional tag title
		'conditional_tag'       => array(
			'callback'              => 'is_post_type_archive', //existing callback
			'params'                => array('product') //parameters for callback
		)
	);


	return $data;
}
add_filter('fw_ext_sidebars_conditional_tags', 'origin_filter_ext_sidebars_add_conditional_tag' );

