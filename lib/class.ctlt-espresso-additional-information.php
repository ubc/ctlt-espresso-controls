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
		?>
		<div class="ctlt-espresso-row">
			<div class="room-setup">
				<label>Room Setup Notes:</label>
			</div>
			<div class="room-setup">
				<textarea></textarea>
			</div>
			<div class="room-setup">
				<label>Admin Support Notes</label>
			</div>
			<div class="room-setup">
				<textarea></textarea>
			</div>
		</div>
		<div class="ctlt-espresso-row">
			<div class="room-setup">
				<label>A/V and Computer Requirements:</label>
			</div>
			<div class="room-setup">
				<textarea></textarea>
			</div>
			<div class="room-setup">
				<label>Marketing & Communication Support Notes:</label>
			</div>
			<div class="room-setup">
				<textarea></textarea>
			</div>
		</div>
		<div class="ctlt-espresso-row">
			<div class="room-setup">
				<label>Catering Notes:</label>
			</div>
			<div class="room-setup">
				<textarea></textarea>
			</div>
		</div>
		<div class="ctlt-espresso-row">
			<div class="room-setup">
				<label>Need Help Setting Up the Room?</label>
			</div>
			<div class="room-setup">
				<input type="checkbox" id="help-setup-room" />
			</div>
			<div class="room-setup">
				<label>I Would Like Signs Posted for My Event:</label>
			</div>
			<div class="room-setup">
				<input type="checkbox" id="post-signs" />
			</div>
		</div>
		<?php
	}


}

new CTLT_Espresso_Additional_Information();