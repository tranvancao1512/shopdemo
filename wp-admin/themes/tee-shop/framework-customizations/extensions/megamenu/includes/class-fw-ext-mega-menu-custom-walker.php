<?php if (!defined('FW')) die('Forbidden');

class origin_Mega_Menu_Custom_Walker extends FW_Ext_Mega_Menu_Walker {
	/*
	 * TODO: Maker cleaner and better way to insert dropdown trigger element
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= '<span class="dropdown-trigger"></span>';
		return parent::end_el($output, $item, $depth, $args);
	}

}

class origin_Sidebar_Menu_Custom_Walker extends Walker_Nav_Menu {
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= '<span class="dropdown-trigger"></span>';
		return parent::end_el($output, $item, $depth, $args);
	}
}