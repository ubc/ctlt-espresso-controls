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
	//protected $espresso_slug = 'post';
	protected $espresso_slug = 'espresso_events';
	protected $prefix = '_ctlt_espresso_';

	public function __construct() {
		add_action( 'init', array( $this, 'init_metaboxes' ) );
	}

	public function init_metaboxes() {
		// do some stuff here
	}

	public function create_post_meta_fields( $key, $value ) {
		global $post;
		add_post_meta( $post->ID, $key, $value, true );
	}
	
	public function back_to_edit() {
		global $post;
		return get_site_url() . '/wp-admin/post.php?post=' . $post->ID . '&action=edit';
	}
}

new CTLT_Espresso_Metaboxes();
