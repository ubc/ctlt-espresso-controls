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
	protected $upload_hook = 'ctlt_espresso_form';
	protected $update_hook = 'ctlt_espresso_update_event';
	protected $insert_hook = 'ctlt_espresso_insert_event';

	protected static $prefix = '_ctlt_espresso_';

	protected static $data = null;

	public function __construct() {
		add_action( $this->edit_hook, array( $this, 'load_data' ) );
	}

	protected function nonce_input( $metabox_noncename ) {
		return '<input type="hidden" name="' . self::$prefix . $metabox_noncename . '" value="' . wp_create_nonce( CTLT_ESPRESSO_CONTROLS_BASENAME ) . '" />';
	}

	public static function load_data( ) {
		self::$data = CTLT_Espresso_Saving::get_from_db( $_GET['event_id'] );
	}

}

new CTLT_Espresso_Metaboxes();