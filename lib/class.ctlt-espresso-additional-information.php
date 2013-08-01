<?php

class CTLT_Espresso_Additional_Information extends CTLT_Espresso_Metaboxes{
	
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'additional_information_metabox' ) );
	}


	public function init_assets() {

	}

	public function additional_information_metabox() {
		add_meta_box(
			'ctlt_espresso_additional_information',
			'Additional Information',
			array( $this, 'render_additional_information' ),
			$this->espresso_slug,
			'normal',
			'high'
		);
	}

	public function render_additional_information() {
		echo 'hello';
	}


}

new CTLT_Espresso_Additional_Information();