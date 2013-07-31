<?php

class CTLT_Espresso_Room_Setup extends CTLT_Espresso_Metaboxes {
	
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init_assets' ) );
		add_action( 'add_meta_boxes', array( $this, 'room_setup_metabox' ) );
	}

	public function init_assets() {
		
	}

	public function room_setup_metabox() {
		add_meta_box(
			'ctlt_espresso_room_setup',
			'Room Setup',
			array( $this, 'render_room_setup' ),
			$this->espresso_slug,
			'normal',
			'high'
		);
	}

	public function render_room_setup() {
		$this->rooms();
	}

	public function rooms() {
		?>
		
		<?php
	}

}

new CTLT_Espresso_Room_Setup();