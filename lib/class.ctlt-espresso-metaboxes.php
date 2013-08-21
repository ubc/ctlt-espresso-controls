<?php

/**
* Espresso CTLT Controls
*
* Events Admin Metabox
*
* @package Espresso CTLT Controls
* @author Julien
* @license GPL-2.0+
* @link example.com
* @copyright 2013 CTLT
*
*/

class CTLT_Espresso_Metaboxes {

	protected $add_hook = 'action_hook_espresso_new_event_left_column_advanced_options_top';
	protected $edit_hook = 'action_hook_espresso_edit_event_left_column_advanced_options_top';
	//protected $hook_name = 'action_hook_espresso_new_event_left_column_advanced_options_top';

	protected static $prefix = '_ctlt_espresso_';

	public function __construct() {
		
	}

	public static function nonce_input( $nonce_name ) {
		$nonce_box = '<input type="hidden" name="' . self::$prefix . $nonce_name . '" value="' . wp_create_nonce( CTLT_ESPRESSO_CONTROLS_BASENAME ) . '" />';
	}

	public function get_events_meta( $event_id, $key = '', $single = false ) {
		// events_meta table alias = CTLT_ESPRESSO_EVENTS_META

	}

	public function insert_events_meta( $event_id ) {
		// check if each of the ids are set

	}

	public function save() {

	}

}

new CTLT_Espresso_Metaboxes();