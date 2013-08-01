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
		<div class="row-fluid">
			<div class="span12">
			<label class="radio inline span2" for="handout-radios">Handouts:</label>
			<label class="radio inline" id="handout-radios">
				<input type="radio" name="handouts-radio" id="handouts-radio-1" value="N/A" /> N/A
			</label>
			<label class="radio inline" id="handout-radios">
				<input type="radio" name="handouts-radio" id="handouts-radio-2" value="Expected" /> Expected
			</label>
			<label class="radio inline" id="handout-radios">
				<input type="radio" name="handouts-radio" id="handouts-radio-3" value="Received" /> Received
			</label>
			<label class="radio inline" id="handout-radios">
				<input type="radio" name="handouts-radio" id="handouts-radio-4" value="Copying Complete" /> Copying Complete
			</label>
			</div>
		</div>
		<?php
	}

	public function handout_upload() {
		?>
		<div class="row-fluid">
			<div class="span12">
				<label class="span2" for="handout-upload">Handout File:</label>
				<input type="file" name="handout-upload" id="handout-upload" />
			</div>
		</div>
		<?php
	}

}

new CTLT_Espresso_Handouts();