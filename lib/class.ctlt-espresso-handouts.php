<?php

class CTLT_Espresso_Handouts extends CTLT_Espresso_Metaboxes {
	
	public function __construct() {
		//add_action( 'init', array( $this, 'init_handouts_properties') );
		add_action( 'add_meta_boxes', array( $this, 'handouts_metabox' ) );
	}

	public function init_handouts_properties() {
		
	}

	public function handouts_metabox() {
		add_meta_box(
			'ctlt_espresso_handouts',
			'Handouts',
			array( $this, 'render_handouts' ),
			$this->espresso_slug,
			'normal',
			'high'
		);
	}

	public function render_handouts() {
		$this->handouts_radio();
		$this->handout_upload();
	}

	public function handouts_radio() {
		?>
		<p>
			<label>Handouts:</label>
			<input type="radio" name="handouts-radio" id="handouts-radio-1" value="N/A" /> N/A
			<input type="radio" name="handouts-radio" id="handouts-radio-2" value="Expected" /> Expected
			<input type="radio" name="handouts-radio" id="handouts-radio-3" value="Received" /> Received
			<input type="radio" name="handouts-radio" id="handouts-radio-4" value="Copying Complete" /> Copying Complete
		</p>
		<?php
	}

	public function handout_upload() {
		?>
		<p>
			<label>Handout File:</label>
			<input type="file" name="document-file" id="document-file" />
		</p>
		<?php
	}

}

new CTLT_Espresso_Handouts();