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
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="radio inline ctlt-span-4 ctlt-events-col">Handouts:</label>
				<label class="radio inline ctlt-span-2 ctlt-events-col" id="handout-radios">
					<input type="radio" name="handouts-radio" id="handouts-radio-1" value="N/A" /> N/A
				</label>
				<label class="radio inline ctlt-span-2 ctlt-events-col" id="handout-radios">
					<input type="radio" name="handouts-radio" id="handouts-radio-2" value="Expected" /> Expected
				</label>
				<label class="radio inline ctlt-span-2 ctlt-events-col" id="handout-radios">
					<input type="radio" name="handouts-radio" id="handouts-radio-3" value="Received" /> Received
				</label>
				<label class="radio inline ctlt-span-2 ctlt-events-col" id="handout-radios">
					<input type="radio" name="handouts-radio" id="handouts-radio-4" value="Copying Complete" /> Copying Complete
				</label>
			</div>
		</div>
		<?php
	}

	public function handout_upload() {
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="ctlt-span-4 ctlt-events-col" for="handout-upload">Handout File:</label>
				<input class="ctlt-span-6 ctlt-events-col" type="file" name="handout-upload" id="handout-upload" />
			</div>
		</div>
		<?php
	}

}

new CTLT_Espresso_Handouts();