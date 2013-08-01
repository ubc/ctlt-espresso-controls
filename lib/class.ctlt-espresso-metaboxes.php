<?php

/**
 * Espresso CTLT Controls
 *
 * Events Admin Metabox
 *
 * @package		Espresso CTLT Controls
 * @author 		Julien
 * @license		GPL-2.0+
 * @link 		example.com
 * @copyright	2013 CTLT
 *
 */

class CTLT_Espresso_Metaboxes {

	protected $espresso_slug = 'espresso_events';

	public function __construct() {
		add_action( 'init', array( $this, 'init_metaboxes' ) );
	}

	public function init_metaboxes() {
		// do some stuff here
	}

	public function save() {

	}
	
}

new CTLT_Espresso_Metaboxes();