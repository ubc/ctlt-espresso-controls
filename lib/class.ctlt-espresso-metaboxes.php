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

	// post slug is for debugging purposes
	protected $espresso_slug = 'post';
	//protected $espresso_slug = 'espresso_event'
	protected $prefix = '_ctlt_espresso_';

	public function __construct() {
		add_action( 'init', array( $this, 'init_metaboxes' ) );
	}

	public function init_metaboxes() {
		// do some stuff here
	}

	public function load_post_meta() {

	}
	
}

new CTLT_Espresso_Metaboxes();